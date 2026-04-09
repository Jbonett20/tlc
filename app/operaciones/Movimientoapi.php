<?php
include(__DIR__ . '/../conexion.php');
extract($_REQUEST);
ini_set('date.timezone', 'America/Bogota');

// Mostrar errores (SOLO PARA DEBUG - QUITAR EN PRODUCCIÓN)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurar cabeceras para permitir JSON
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");


$sql_busqueda = mysqli_query($link, "SELECT * FROM tbl_datos_fact_electronica");
$row = mysqli_fetch_array($sql_busqueda);
$llave = $row["llave"];
$usuario = $row["usuario"];
$usu_llave= $row["llaveusuario"];
$res= $row["resolucion_desc"];
$prefijo=$row['prefijo'];

// Datos para envío DIAN (configurables por variables de entorno o BD)
$nitDian = trim((string)(getenv('FACTIN_NIT') ?: ($row['nit'] ?? $row['nit_empresa'] ?? $row['nitempresa'] ?? '')));
$claveCertificadoDian = trim((string)(getenv('FACTIN_CLAVE_CERTIFICADO') ?: ($row['clave_certificado'] ?? $row['clavecertificado'] ?? $row['password_certificado'] ?? $row['clave_cert'] ?? '')));
$softwareIdDian = trim((string)(getenv('FACTIN_SOFTWARE_ID') ?: ($row['software_id'] ?? $row['softwareid'] ?? $row['id_software'] ?? $row['idsoftware'] ?? '')));
$llaveEnvioDian = trim((string)(getenv('FACTIN_LLAVE_ENVIO') ?: ($row['llave_envio'] ?? $row['llaveenvio'] ?? $row['llave'] ?? '')));
// URL del servicio externo al que se hará la solicitud
$externalUrl = "https://www.factin.app:8443/Movimientoapi?llave=" . $llave ."&nuevo=false&bodegg=-&usuario=".$usuario."&tipocosto=promedio&llaveusuario=".$usu_llave;


// Obtener el cuerpo de la solicitud
$requestBody = file_get_contents("php://input");
$data = json_decode($requestBody, true); // Decodificar JSON a array

$idFact=$data['idFact'];

// Crear archivo de log personalizado - usar /tmp para evitar problemas de permisos
$logFile = '/tmp/debug_factura_electronica_' . date('Y-m-d') . '.log';
@file_put_contents($logFile, "\n=== Nueva petición: " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
@file_put_contents($logFile, "ID Factura: $idFact\n", FILE_APPEND);

// Validar que existe el ID de factura
if (empty($idFact)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "ID de factura no proporcionado",
        "step" => "validation_idfactura"
    ]);
    exit;
}

//obtener datos de la factura (encabezado)
$sql_factura = mysqli_query($link, "SELECT f.*,c.cc_cliente,c.nombre_cliente FROM tbl_factura as f left join tbl_cliente as c on c.id_cliente=f.id_cliente where f.id_factura='$idFact' " );
$row_factura = mysqli_fetch_array($sql_factura);

// Validar que existe la factura
if (!$row_factura) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "Factura no encontrada con ID: " . $idFact,
        "step" => "validation_factura_notfound"
    ]);
    exit;
}

// VALIDAR QUE SEA FACTURA ELECTRÓNICA (tipo_factura = 2)
if ($row_factura['tipo_factura'] != 2) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Error: Esta factura NO es electrónica (tipo_factura=" . ($row_factura['tipo_factura'] ?? 'NULL') . "). Solo se pueden enviar facturas electrónicas a la DIAN.",
        "step" => "validation_tipo_factura",
        "tipo_factura_recibido" => $row_factura['tipo_factura']
    ]);
    exit;
}

//obtener datos detalle factura
$sql_query = "SELECT f.*,p.codigo_producto,p.descripcion,p.presentacion,p.valor,p.valor_unidad,i.iva FROM tbl_detallefactura as f left join tbl_producto as p on p.id_producto=f.id_producto left join tbl_iva as i on i.id_iva=p.id_iva where f.id_factura='$idFact'";
error_log("SQL Query: " . $sql_query);
@file_put_contents($logFile, "SQL Query: $sql_query\n", FILE_APPEND);
$sql_det_factura = mysqli_query($link, $sql_query);

// Log para debug - ver cuántos productos se encontraron
$num_productos = mysqli_num_rows($sql_det_factura);
error_log("Número de productos en la consulta: " . $num_productos);
@file_put_contents($logFile, "Número de productos encontrados: $num_productos\n", FILE_APPEND);

// Si no hay productos, intentar con otras posibles estructuras de columnas
if ($num_productos == 0) {
    // Intentar sin alias
    $sql_query_alt = "SELECT * FROM tbl_detallefactura WHERE id_factura='$idFact'";
    error_log("Intentando query alternativa: " . $sql_query_alt);
    $sql_det_alt = mysqli_query($link, $sql_query_alt);
    $num_alt = mysqli_num_rows($sql_det_alt);
    error_log("Productos con query alternativa: " . $num_alt);
    
    if ($num_alt > 0) {
        // Mostrar estructura de la tabla
        $first_row = mysqli_fetch_assoc($sql_det_alt);
        error_log("Columnas encontradas: " . implode(", ", array_keys($first_row)));
        mysqli_data_seek($sql_det_alt, 0); // Reset pointer
    }
}

// Los datos a enviar al servicio externo

$compa="1";
// Usar codigo_factura en lugar de id_factura para respetar los rangos de resolución
$consecutivo=$row_factura['codigo_factura'];
@file_put_contents($logFile, "Consecutivo FE usado: $consecutivo (de la factura ID: $idFact)\n", FILE_APPEND);

// VALIDAR RANGO PARA FACTURA ELECTRÓNICA
if ($row_factura['tipo_factura'] == 2) {
    $sql_rango_fe = mysqli_query($link, "SELECT * FROM tbl_rangofactura_electronica ORDER BY id_rango DESC LIMIT 1");
    $rango_fe = mysqli_fetch_array($sql_rango_fe);
    
    if (!$rango_fe || $consecutivo < $rango_fe['InicioFactura'] || $consecutivo > $rango_fe['FinalFactura']) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Error: Número de factura fuera de rango autorizado. Usa insertarfacturaElectronica en lugar de insertarfactura",
            "consecutivo_enviado" => $consecutivo,
            "rango_esperado" => "De " . ($rango_fe['InicioFactura'] ?? 'NULL') . " a " . ($rango_fe['FinalFactura'] ?? 'NULL'),
            "step" => "validation_rango_fe"
        ]);
        exit;
    }
}

$idtercero=$row_factura['cc_cliente'];
$tercero='cliente';
$bruto=$row_factura['valor_pago'];
$iva=0;
$subtotal=$row_factura['valor_pago'];
$total=$row_factura['valor_pago'];

$nombreClienteFactura = trim((string)($row_factura['nombre_cliente'] ?? ''));
$documentoClienteFactura = trim((string)($row_factura['cc_cliente'] ?? ''));
$clienteGenericoInvalido = false;

if ($documentoClienteFactura === '' || strlen(preg_replace('/\D+/', '', $documentoClienteFactura)) < 5) {
    $clienteGenericoInvalido = true;
}

if (preg_match('/cliente\s+estandar|cliente\s+general|consumidor\s+final/i', $nombreClienteFactura)) {
    $clienteGenericoInvalido = true;
}

if ($documentoClienteFactura === '12345') {
    $clienteGenericoInvalido = true;
}

if ($clienteGenericoInvalido) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "La factura electrónica no se puede enviar con cliente genérico. Selecciona un cliente real con identificación válida antes de emitir a DIAN.",
        "step" => "validation_cliente_fe",
        "cliente" => [
            "id_cliente" => $row_factura['id_cliente'] ?? null,
            "documento" => $documentoClienteFactura,
            "nombre" => $nombreClienteFactura
        ]
    ]);
    exit;
}


$detallesFactura = []; // Array para almacenar los datos procesados
$productosIndexados = [];
$itemCounter = 1; // Inicializar el contador de items
 $total_iva_sum = 0;
 $subtotal_sin_iva_sum = 0;
while ($row_det_factura = mysqli_fetch_array($sql_det_factura)) {
    // Log de cada producto para debug
    error_log("Producto #" . $itemCounter . " - Codigo: " . ($row_det_factura['codigo_producto'] ?? 'NULL') . " - Descripcion: " . ($row_det_factura['descripcion'] ?? 'NULL'));

    $codigoProducto = isset($row_det_factura['codigo_producto']) ? trim((string)$row_det_factura['codigo_producto']) : '';
    if ($codigoProducto === '' && isset($row_det_factura['id_producto'])) {
        $codigoProducto = trim((string)$row_det_factura['id_producto']);
    }

    $descripcionProducto = isset($row_det_factura['descripcion']) ? trim((string)$row_det_factura['descripcion']) : '';
    if ($descripcionProducto === '' && $codigoProducto !== '') {
        $descripcionProducto = 'PRODUCTO ' . $codigoProducto;
    }

    $cantidadLinea = floatval($row_det_factura['cantidadFraccion'] ?? 0);
    if ($cantidadLinea <= 0) {
        $cantidadLinea = floatval($row_det_factura['cantidad'] ?? 0);
    }

    $precioUnitario = floatval($row_det_factura['valor_unidad'] ?? 0);
    if ($precioUnitario <= 0 && $cantidadLinea > 0) {
        $precioUnitario = floatval($row_det_factura['total_pago'] ?? 0) / $cantidadLinea;
    }

    $costoUnitario = floatval($row_det_factura['valor'] ?? 0);
    if ($costoUnitario <= 0) {
        $costoUnitario = $precioUnitario;
    }
    
    // Validar que existan los campos requeridos (permitir "0" como válido)
    if ($codigoProducto === '' || $descripcionProducto === '' || $cantidadLinea <= 0 || $precioUnitario <= 0) {
        error_log("Producto saltado - codigo: '" . ($row_det_factura['codigo_producto'] ?? 'NULL') . "', descripcion: '" . ($row_det_factura['descripcion'] ?? 'NULL') . "', cantidad: '" . ($row_det_factura['cantidadFraccion'] ?? $row_det_factura['cantidad'] ?? 'NULL') . "', precio: '" . ($row_det_factura['valor_unidad'] ?? 'NULL') . "'");
        continue; // Saltar productos sin datos válidos
    }
    
    // Construir un array para cada fila
    $detalle = [
        "item" => $itemCounter++,
        "referencia" => $codigoProducto,
        "codprod" => $codigoProducto,
        "descripcion" => $descripcionProducto,
        "descrip" => $descripcionProducto,
        "bodega" => "1",
        "cantidad" => $cantidadLinea,
        "precio" => $precioUnitario,
        "presentacion" => $row_det_factura['presentacion'] ?? null,
        "descuento" => floatval($row_det_factura['descuento'] ?? 0),
        "iva" => floatval($row_det_factura['iva'] ?? 0),
            "porimptoconsumo" => 0,
            // Campos adicionales para compatibilidad con la API externa
            "poriva" => floatval($row_det_factura['iva'] ?? 0),
            "preivainc" => 1,
            "vlr_iva" => 0,
            "vlr_base_iva" => 0,
            "vlr_desc" => 0,
            "subtotal" => $cantidadLinea * $precioUnitario,
        // Calculamos el IVA y el subtotal sin IVA suponiendo que el valor unitario incluye IVA
        "iva_porcentaje" => floatval($row_det_factura['iva'] ?? 0),
        "iva_valor" => 0,
        "subtotal_sin_iva" => 0,
        "compañia" =>  "1",
        "concepto" => $prefijo,
        "nrodocumento" => strval($consecutivo),
        "costo" => round($costoUnitario, 2),
        "desadicional" => strval(floatval($row_det_factura['descuento'] ?? 0)),
        "fecha" => date("Y-m-d"),
        "tercero" => $tercero,
        "cliente" => strval($idtercero)
    ];
    // Calcular IVA por línea y subtotal sin IVA (si el precio ya incluye IVA)
    $line_subtotal = $cantidadLinea * $precioUnitario;
    $line_iva_percent = floatval($row_det_factura['iva'] ?? 0);
    if ($line_iva_percent > 0) {
        $line_iva_value = ($line_subtotal * $line_iva_percent) / (100 + $line_iva_percent);
    } else {
        $line_iva_value = 0;
    }
    $line_net = $line_subtotal - $line_iva_value;

    // Rellenar campos compatibles con la API externa
    $detalle["iva_valor"] = $line_iva_value;
    $detalle["subtotal_sin_iva"] = $line_net;
    $detalle["vlr_iva"] = $line_iva_value;
    $detalle["vlr_base_iva"] = $line_net;
    $detalle["poriva"] = $line_iva_percent;
    $detalle["preivainc"] = 1; // indicamos que el precio enviado incluye IVA

    // Acumular totales
    $total_iva_sum += $line_iva_value;
    $subtotal_sin_iva_sum += $line_net;

    if (!isset($productosIndexados[$codigoProducto])) {
        $productosIndexados[$codigoProducto] = [
            "codigo" => $codigoProducto,
            "descripcion" => $descripcionProducto,
            "cantidad" => $cantidadLinea,
            "precio" => $precioUnitario
        ];
    }

    error_log("Detalle agregado para producto: " . $descripcionProducto . " (ref: " . $codigoProducto . ")");

    // Agregar al array general
    $detallesFactura[] = $detalle;
}

error_log("Total de productos agregados: " . count($detallesFactura));

// Validar que haya al menos un producto
if (empty($detallesFactura)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "La factura no tiene productos válidos",
        "step" => "validation_empty_products",
        "debug" => [
            "id_factura" => $idFact,
            "num_productos_sql" => $num_productos,
            "sql_query" => $sql_query,
            "prefijo" => $prefijo,
            "consecutivo" => $consecutivo
        ]
    ]);
    exit;
}


// Objeto dinámico
$externalData = [
    "faencmovi" => [
        "compañia" => "1",
        "concepto" => $prefijo,
        "ndocumento" => strval($consecutivo),
        "fecha" => date("Y-m-d"),
        "tercero" => $tercero,
        "cliente" => strval($idtercero),
        "nombrecli" => $row_factura['nombre_cliente'] ?? "CLIENTE GENERAL",
        "observacion" => "",
        // Valores calculados a partir de las líneas (subtotal sin IVA, total IVA y total)
        "bruto" => floatval($subtotal_sin_iva_sum),
        "iva" => floatval($total_iva_sum),
        "descuento" => "0",
        "despiefact" => 0,
        "retefuente" => 0,
        "reteiva" => 0,
        "ica" => 0,
        "retefte" => 0,
        "impconsumo" => 0,
        "subtotal" => floatval($subtotal_sin_iva_sum),
        "total" => floatval($subtotal_sin_iva_sum + $total_iva_sum),
        "fechpost" => date("Y-m-d"),
        "mpago" => "EFECTIVO",
        "sucursal" => "",
        "documento2" => "",
        "cufe" => "",
        "emitido" => "No",
        "qr" => "",
        "direccion" => ""
    ],
    "famovimiento" => $detallesFactura,
    "caja" => [],
    "remisiones" => []
];

function postJsonFactin($url, $payload)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_RESOLVE, ['www.factin.app:8443:159.65.32.58']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_errno($ch) ? curl_error($ch) : '';
    curl_close($ch);

    return [
        'httpCode' => $httpCode,
        'response' => $response,
        'curlError' => $curlError
    ];
}

function guardarJsonDian($filePath, $data)
{
    @file_put_contents(
        $filePath,
        json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    );
}

function respuestaTieneErrorCodigoArticulo($responseText)
{
    if (!is_string($responseText) || $responseText === '') {
        return false;
    }
    return (bool)preg_match('/c[oó]digo.+art[ií]culo.+vac[ií]o/i', $responseText);
}

function extraerCodigoArticuloVacio($responseText)
{
    if (!is_string($responseText) || $responseText === '') {
        return '';
    }

    if (preg_match('/c[oó]digo\s+del\s+art[ií]culo\s+est[aá]\s+vac[ií]o:\s*([^\s\\"\n\r]+)/iu', $responseText, $m)) {
        return trim((string)$m[1]);
    }

    if (preg_match('/art[ií]culo.+vac[ií]o:\s*([^\s\\"\n\r]+)/iu', $responseText, $m)) {
        return trim((string)$m[1]);
    }

    return '';
}

function sincronizarArticuloFactin($llave, $codigo, $nombre, $logFile)
{
    $codigo = trim((string)$codigo);
    $nombre = trim((string)$nombre);
    if ($codigo === '' || $nombre === '') {
        return false;
    }

    $payloadArticulo = [
        'codigo' => $codigo,
        'nombre' => $nombre,
        'inarticulosbodega' => [],
        'inarticuloslistaprecio' => [],
        'inarticuloscompuesto' => [],
        'inarticulosstock' => []
    ];

    $urls = [
        'https://www.factin.app:8443/Inarticulosapi?llave=' . rawurlencode($llave),
        'http://159.65.32.58:5041/Inarticulosapi?llave=' . rawurlencode($llave)
    ];

    foreach ($urls as $urlArticulo) {
        $res = postJsonFactin($urlArticulo, $payloadArticulo);
        @file_put_contents($logFile, "Sync articulo [$codigo] URL: $urlArticulo HTTP: " . $res['httpCode'] . "\n", FILE_APPEND);

        if ($res['curlError'] === '' && in_array((int)$res['httpCode'], [200, 201, 204])) {
            return true;
        }
    }

    return false;
}

// Log de datos enviados para debug
error_log("=== DATOS ENVIADOS A FACTIN ===");
error_log("URL: " . $externalUrl);
error_log("Cantidad de productos: " . count($detallesFactura));
error_log("Datos JSON: " . json_encode($externalData, JSON_PRETTY_PRINT));

// Ejecutar primer intento de guardado de movimiento
$movRes = postJsonFactin($externalUrl, $externalData);
$response = $movRes['response'];
$httpCode = (int)$movRes['httpCode'];

// Verificar si ocurrió un error de conexión
if ($movRes['curlError'] !== '') {
    // Si hubo un error, devolverlo como respuesta
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al conectar con el servidor de facturación: " . $movRes['curlError'], 
        "idFactura" => isset($data['idFact']) ? $data['idFact'] : 'No disponible',
        "error" => $movRes['curlError'],
        "step" => "movimientoapi_connection"
    ]);
    exit;
}

// Si hubo error de código de artículo, sincronizar artículos y reintentar una vez
if ($httpCode >= 400 && respuestaTieneErrorCodigoArticulo((string)$response)) {
    @file_put_contents($logFile, "Detectado error de código de artículo. Iniciando sincronización de artículos y reintento...\n", FILE_APPEND);

    $codigoConProblema = extraerCodigoArticuloVacio((string)$response);
    if ($codigoConProblema !== '') {
        $productoDetectado = $productosIndexados[$codigoConProblema] ?? null;
        @file_put_contents(
            $logFile,
            "Código con problema detectado por Factin: $codigoConProblema | Producto: " . json_encode($productoDetectado, JSON_UNESCAPED_UNICODE) . "\n",
            FILE_APPEND
        );
    }

    foreach ($detallesFactura as $detalleSync) {
        sincronizarArticuloFactin($llave, $detalleSync['referencia'] ?? '', $detalleSync['descrip'] ?? '', $logFile);
    }

    $movResRetry = postJsonFactin($externalUrl, $externalData);
    if ($movResRetry['curlError'] === '') {
        $response = $movResRetry['response'];
        $httpCode = (int)$movResRetry['httpCode'];
        @file_put_contents($logFile, "Reintento Movimientoapi HTTP: $httpCode\n", FILE_APPEND);
    }
}

// Log para debug - quitar después
error_log("HTTP Code del primer API: " . $httpCode);
error_log("Respuesta del primer API: " . $response);

// Verificar si la respuesta fue exitosa
if ($httpCode === 200) {
    // Decodificar respuesta del primer API
    $firstApiResponse = json_decode($response, true);
    $firstApiCodigo = isset($firstApiResponse['codigo']) ? (string)$firstApiResponse['codigo'] : '';
    $firstApiMovimiento = $firstApiResponse['movimiento'] ?? null;
    error_log("Respuesta decodificada: " . print_r($firstApiResponse, true));
    
    // Asegúrate de que $prefijo y $consecutivo están definidos
    if (!isset($prefijo) || !isset($consecutivo)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Faltan parámetros requeridos: prefijo o consecutivo",
            "step" => "validation_parameters"
        ]);
        exit;
    }

    // Validar configuración mínima de envío DIAN
    if ($nitDian === '' || $claveCertificadoDian === '' || $softwareIdDian === '' || $llave === '') {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Configuración incompleta para envío DIAN. Verifica NIT, clave certificado, software ID y llave.",
            "step" => "envio_dian_config",
            "config" => [
                "nit" => $nitDian !== '' ? "OK" : "FALTA",
                "clave_certificado" => $claveCertificadoDian !== '' ? "OK" : "FALTA",
                "software_id" => $softwareIdDian !== '' ? "OK" : "FALTA",
                "llave" => $llave !== '' ? "OK" : "FALTA"
            ]
        ]);
        exit;
    }

    // Construir la URL del servicio externo
    // IMPORTANTE: usar $llave (misma que Movimientoapi) para que el servidor encuentre el movimiento guardado
    $externalUrldian = "https://www.factin.app:8443/EnvioApi/"
        . rawurlencode($prefijo) . "/"
        . rawurlencode((string)$consecutivo) . "/"
        . rawurlencode($nitDian) . "/"
        . rawurlencode($claveCertificadoDian) . "/"
        . rawurlencode($softwareIdDian)
        . "?llave=" . rawurlencode($llave);

    $payloadEnviado = $externalData;
    @file_put_contents($logFile, "URL EnvioApi real: $externalUrldian\n", FILE_APPEND);
    $dianRequestDebug = [
        "endpoint" => $externalUrldian,
        "prefijo" => $prefijo,
        "consecutivo" => (string)$consecutivo,
        "nit" => $nitDian,
        "softwareId" => $softwareIdDian,
        "llaveEnvioMasked" => $llave !== ''
            ? str_repeat('*', max(0, strlen($llave) - 4)) . substr($llave, -4)
            : '',
        "claveCertificadoMasked" => $claveCertificadoDian !== ''
            ? str_repeat('*', max(0, strlen($claveCertificadoDian) - 4)) . substr($claveCertificadoDian, -4)
            : ''
    ];

    $traceSafeId = preg_replace('/[^A-Za-z0-9_-]/', '_', (string)$prefijo . '_' . (string)$consecutivo . '_' . (string)$idFact);
    $dianTraceFile = '/tmp/dian_exchange_' . $traceSafeId . '.json';
    $dianTrace = [
        "fecha" => date('c'),
        "idFactura" => (string)$idFact,
        "prefijo" => (string)$prefijo,
        "consecutivo" => (string)$consecutivo,
        "enviado" => [
            "payload" => $payloadEnviado,
            "solicitudDian" => $dianRequestDebug
        ],
        "recibido" => [
            "intentos" => []
        ]
    ];
    guardarJsonDian($dianTraceFile, $dianTrace);
    @file_put_contents($logFile, "Trace DIAN JSON: $dianTraceFile\n", FILE_APPEND);

    // Ejecutar la solicitud a la DIAN con reintentos (exponential backoff)
    $maxAttempts = 3;
    $attempt = 0;
    $response = false;
    $httpCodeDian = 0;
    $lastCurlError = '';
    $ultimoCodigoDian = '';
    $ultimoMensajeDian = '';
    while ($attempt < $maxAttempts) {
        $attempt++;
        error_log("Intento envío DIAN #" . $attempt);
        @file_put_contents($logFile, "Intento envio DIAN #$attempt\n", FILE_APPEND);

        $ch = curl_init($externalUrldian);
        // Configurar la solicitud cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RESOLVE, ['www.factin.app:8443:159.65.32.58']);

        $response = curl_exec($ch);
        $httpCodeDian = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlErr = $curlErrNo ? curl_error($ch) : '';

        $decodedAttempt = json_decode((string)$response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $decodedAttempt = null;
        }
        $dianTrace['recibido']['intentos'][] = [
            "intento" => $attempt,
            "httpCode" => (int)$httpCodeDian,
            "curlError" => $curlErr,
            "rawResponse" => $response,
            "responseJson" => $decodedAttempt
        ];
        guardarJsonDian($dianTraceFile, $dianTrace);

        error_log("Respuesta DIAN intento $attempt HTTP $httpCodeDian: " . ($response === false ? '[false]' : $response));
        @file_put_contents($logFile, "Respuesta DIAN intento $attempt HTTP $httpCodeDian: " . ($response === false ? '[false]' : $response) . "\n", FILE_APPEND);
        if ($curlErrNo) {
            $lastCurlError = $curlErr;
            error_log("cURL error intento $attempt: $curlErr");
            @file_put_contents($logFile, "cURL error intento $attempt: $curlErr\n", FILE_APPEND);
            curl_close($ch);
            if ($attempt < $maxAttempts) {
                sleep(pow(2, $attempt)); // backoff
                continue;
            } else {
                $dianTrace['resultado'] = [
                    "estado" => "error_conexion",
                    "step" => "envio_dian_connection",
                    "httpCode" => (int)$httpCodeDian,
                    "mensaje" => $lastCurlError
                ];
                guardarJsonDian($dianTraceFile, $dianTrace);
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al enviar a la DIAN: " . $lastCurlError,
                    "curl_error" => $lastCurlError,
                    "step" => "envio_dian_connection",
                    "enviado" => $dianTrace['enviado'],
                    "recibido" => $dianTrace['recibido'],
                    "traceFile" => $dianTraceFile
                ]);
                exit;
            }
        }

        // Si recibimos 200/201/204 validamos también el código de negocio de DIAN
        if (in_array($httpCodeDian, [200, 201, 204])) {
            $codigoIntento = is_array($decodedAttempt) && isset($decodedAttempt['codigo'])
                ? (string)$decodedAttempt['codigo']
                : '';
            $mensajeIntento = is_array($decodedAttempt) ? trim((string)($decodedAttempt['mensaje'] ?? '')) : '';

            if ($codigoIntento !== '' && !in_array($codigoIntento, ['200', '201', '204'])) {
                $ultimoCodigoDian = $codigoIntento;
                $ultimoMensajeDian = $mensajeIntento;
                error_log("DIAN rechazo de negocio en intento $attempt. codigo=$codigoIntento mensaje=$mensajeIntento");
                @file_put_contents($logFile, "DIAN rechazo de negocio en intento $attempt. codigo=$codigoIntento mensaje=$mensajeIntento\n", FILE_APPEND);
                curl_close($ch);
                if ($attempt < $maxAttempts) {
                    sleep(pow(2, $attempt));
                    continue;
                }
            }

            break;
        }

        // Si no fue exitoso y quedan intentos, esperar y reintentar
        error_log("HTTP Code DIAN intento $attempt: $httpCodeDian");
        @file_put_contents($logFile, "HTTP Code DIAN intento $attempt: $httpCodeDian\n", FILE_APPEND);
        curl_close($ch);
        if ($attempt < $maxAttempts) {
            sleep(pow(2, $attempt));
            continue;
        }
    }

    if (!in_array($httpCodeDian, [200, 201, 204])) {
        $dianTrace['resultado'] = [
            "estado" => "error_http",
            "step" => "envio_dian_failed",
            "httpCode" => (int)$httpCodeDian,
            "mensaje" => "Error al enviar a la DIAN"
        ];
        guardarJsonDian($dianTraceFile, $dianTrace);
        http_response_code($httpCodeDian > 0 ? $httpCodeDian : 500);
        echo json_encode([
            "success" => false,
            "message" => "Error al enviar a la DIAN",
            "step" => "envio_dian_failed",
            "httpCode" => $httpCodeDian,
            "enviado" => $dianTrace['enviado'],
            "recibido" => $dianTrace['recibido'],
            "traceFile" => $dianTraceFile
        ]);
        if (isset($ch) && is_resource($ch)) {
            curl_close($ch);
        }
        exit;
    }

    
    // Procesar la respuesta del servidor
    if ($response === false || empty($response)) {
        $dianTrace['resultado'] = [
            "estado" => "respuesta_vacia",
            "step" => "envio_dian_empty_response",
            "httpCode" => (int)$httpCodeDian,
            "mensaje" => "Respuesta vacía del servidor DIAN"
        ];
        guardarJsonDian($dianTraceFile, $dianTrace);
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Respuesta vacía del servidor DIAN",
            "step" => "envio_dian_empty_response",
            "httpCode" => $httpCodeDian,
            "enviado" => $dianTrace['enviado'],
            "recibido" => $dianTrace['recibido'],
            "traceFile" => $dianTraceFile
        ]);
    } else {
        // Intentar decodificar la respuesta como JSON
        $responseData = json_decode($response, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            $codigoRespuestaDian = isset($responseData['codigo']) ? (string)$responseData['codigo'] : '';
            $mensajeRespuestaDian = trim((string)($responseData['mensaje'] ?? ''));
            $movimientoDian = $responseData['movimiento']['faencmovi'] ?? null;
            $cufeDian = is_array($movimientoDian) ? trim((string)($movimientoDian['cufe'] ?? '')) : '';
            $qrDian = is_array($movimientoDian) ? trim((string)($movimientoDian['qr'] ?? '')) : '';

            if ($codigoRespuestaDian !== '' && !in_array($codigoRespuestaDian, ['200', '201', '204'])) {
                if ($mensajeRespuestaDian === '' && $ultimoMensajeDian !== '') {
                    $mensajeRespuestaDian = $ultimoMensajeDian;
                }
                if ($mensajeRespuestaDian === '') {
                    $mensajeRespuestaDian = "DIAN/Factin devolvió código " . $codigoRespuestaDian . " sin mensaje.";
                }

                $diagnosticoDian = [
                    "codigo_dian" => $codigoRespuestaDian,
                    "mensaje_dian" => $mensajeRespuestaDian,
                    "intentos" => $attempt,
                    "movimientoapi_codigo" => $firstApiCodigo,
                    "movimientoapi_tiene_movimiento" => is_array($firstApiMovimiento),
                    "prefijo" => $prefijo,
                    "consecutivo" => (string)$consecutivo,
                    "nit" => $nitDian,
                    "sugerencia" => "Verifica que el consecutivo exista en Factin y que NIT/SoftwareID/Clave/llave correspondan al mismo ambiente."
                ];

                $dianTrace['resultado'] = [
                    "estado" => "rechazado",
                    "step" => "envio_dian_rejected",
                    "httpCode" => (int)$httpCodeDian,
                    "codigo" => $codigoRespuestaDian,
                    "mensaje" => $mensajeRespuestaDian
                ];
                guardarJsonDian($dianTraceFile, $dianTrace);
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al enviar a la DIAN: " . $mensajeRespuestaDian,
                    "step" => "envio_dian_rejected",
                    "httpCode" => $httpCodeDian,
                    "codigoDian" => $codigoRespuestaDian,
                    "diagnostico" => $diagnosticoDian,
                    "enviado" => $dianTrace['enviado'],
                    "recibido" => [
                        "intentos" => $dianTrace['recibido']['intentos'],
                        "respuestaFinalRaw" => $response,
                        "respuestaFinalJson" => $responseData
                    ],
                    "traceFile" => $dianTraceFile,
                    "fullResponse" => $responseData
                ]);
                if (isset($ch) && is_resource($ch)) {
                    curl_close($ch);
                }
                exit;
            }

            if ($cufeDian === '' && $qrDian === '') {
                $dianTrace['resultado'] = [
                    "estado" => "sin_cufe_qr",
                    "step" => "envio_dian_without_cufe",
                    "httpCode" => (int)$httpCodeDian,
                    "mensaje" => "La DIAN respondió sin CUFE ni QR"
                ];
                guardarJsonDian($dianTraceFile, $dianTrace);
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "La DIAN respondió sin CUFE ni QR",
                    "step" => "envio_dian_without_cufe",
                    "httpCode" => $httpCodeDian,
                    "enviado" => $dianTrace['enviado'],
                    "recibido" => [
                        "intentos" => $dianTrace['recibido']['intentos'],
                        "respuestaFinalRaw" => $response,
                        "respuestaFinalJson" => $responseData
                    ],
                    "traceFile" => $dianTraceFile,
                    "fullResponse" => $responseData
                ]);
                if (isset($ch) && is_resource($ch)) {
                    curl_close($ch);
                }
                exit;
            }

            // Si es JSON válido, agregar indicador de éxito
            $dianTrace['resultado'] = [
                "estado" => "ok",
                "step" => "envio_dian_ok",
                "httpCode" => (int)$httpCodeDian,
                "mensaje" => "Factura electrónica creada exitosamente"
            ];
            $dianTrace['recibido']['respuestaFinalRaw'] = $response;
            $dianTrace['recibido']['respuestaFinalJson'] = $responseData;
            guardarJsonDian($dianTraceFile, $dianTrace);

            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Factura electrónica creada exitosamente",
                "idFactura" => $consecutivo,
                "prefijo" => $prefijo,
                "data" => $responseData,
                "traceFile" => $dianTraceFile
            ]);
        } else {
            // Si no es JSON, devolver como texto
            $dianTrace['resultado'] = [
                "estado" => "ok_raw",
                "step" => "envio_dian_ok_raw",
                "httpCode" => (int)$httpCodeDian,
                "mensaje" => "Factura electrónica creada exitosamente (respuesta no JSON)"
            ];
            $dianTrace['recibido']['respuestaFinalRaw'] = $response;
            guardarJsonDian($dianTraceFile, $dianTrace);

            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Factura electrónica creada exitosamente",
                "idFactura" => $consecutivo,
                "prefijo" => $prefijo,
                "response" => $response,
                "traceFile" => $dianTraceFile
            ]);
        }
    }

    curl_close($ch);
 
} else {
    // Si la respuesta no fue exitosa, devolver el mensaje de error
    error_log("Error en Movimientoapi - HTTP Code: " . $httpCode);
    error_log("Respuesta de error: " . $response);
    
    http_response_code($httpCode);
    $errorResponse = json_decode($response, true);
    
    // Intentar extraer mensaje de error más específico
    $errorMsg = "Error desconocido";
    $errorDetails = "";
    
    if ($errorResponse && isset($errorResponse['errors'])) {
        // El servidor devuelve un objeto "errors" con los campos problemáticos
        $errorDetails = json_encode($errorResponse['errors']);
        $errorMsg = "Errores de validación: " . $errorDetails;
    } else if ($errorResponse && isset($errorResponse['title'])) {
        $errorMsg = $errorResponse['title'];
        if (isset($errorResponse['errors'])) {
            $errorDetails = json_encode($errorResponse['errors']);
        }
    } else if ($errorResponse && isset($errorResponse['message'])) {
        $errorMsg = $errorResponse['message'];
    } else if ($errorResponse && isset($errorResponse['error'])) {
        $errorMsg = $errorResponse['error'];
    } else if (!empty($response)) {
        $errorMsg = substr($response, 0, 500); // Primeros 500 caracteres de la respuesta
    }

    $codigoArticuloProblema = extraerCodigoArticuloVacio((string)$response);
    $productoProblema = null;
    if ($codigoArticuloProblema !== '') {
        $productoProblema = $productosIndexados[$codigoArticuloProblema] ?? [
            "codigo" => $codigoArticuloProblema,
            "descripcion" => null
        ];
    }
    
    echo json_encode([
        "success" => false,
        "message" => "Error al guardar factura: " . $errorMsg,
        "httpCode" => $httpCode,
        "step" => "movimientoapi_failed",
        "errorDetails" => $errorDetails,
        "fullResponse" => $errorResponse ?? $response,
        "codigoArticuloProblema" => $codigoArticuloProblema,
        "productoProblema" => $productoProblema
    ]);
}
