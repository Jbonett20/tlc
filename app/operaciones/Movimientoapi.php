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
// URL del servicio externo al que se hará la solicitud
$externalUrl = "https://www.factin.app:5091/Movimientoapi?llave=" . $llave ."&nuevo=false&bodegg=-&usuario=".$usuario."&tipocosto=promedio&llaveusuario=".$usu_llave;


// Obtener el cuerpo de la solicitud
$requestBody = file_get_contents("php://input");
$data = json_decode($requestBody, true); // Decodificar JSON a array

$idFact=$data['idFact'];

// Crear archivo de log personalizado
$logFile = __DIR__ . '/debug_factura_electronica.log';
file_put_contents($logFile, "\n=== Nueva petición: " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
file_put_contents($logFile, "ID Factura: $idFact\n", FILE_APPEND);

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

//obtener datos detalle factura
$sql_query = "SELECT f.*,p.codigo_producto,p.descripcion,i.iva,p.valor_unidad FROM tbl_detallefactura as f left join tbl_producto as p on p.id_producto=f.id_producto left join tbl_iva as i on i.id_iva=p.id_iva where f.id_factura='$idFact'";
error_log("SQL Query: " . $sql_query);
file_put_contents($logFile, "SQL Query: $sql_query\n", FILE_APPEND);
$sql_det_factura = mysqli_query($link, $sql_query);

// Log para debug - ver cuántos productos se encontraron
$num_productos = mysqli_num_rows($sql_det_factura);
error_log("Número de productos en la consulta: " . $num_productos);
file_put_contents($logFile, "Número de productos encontrados: $num_productos\n", FILE_APPEND);

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
$consecutivo=$row_factura['id_factura'];
$idtercero=$row_factura['cc_cliente'];
$tercero='cliente';
$bruto=$row_factura['valor_pago'];
$iva=0;
$subtotal=$row_factura['valor_pago'];
$total=$row_factura['valor_pago'];


$detallesFactura = []; // Array para almacenar los datos procesados
$itemCounter = 1; // Inicializar el contador de items
while ($row_det_factura = mysqli_fetch_array($sql_det_factura)) {
    // Log de cada producto para debug
    error_log("Producto #" . $itemCounter . " - Codigo: " . ($row_det_factura['codigo_producto'] ?? 'NULL') . " - Descripcion: " . ($row_det_factura['descripcion'] ?? 'NULL'));
    
    // Validar que existan los campos requeridos (permitir "0" como válido)
    if (!isset($row_det_factura['codigo_producto']) || !isset($row_det_factura['descripcion']) || 
        $row_det_factura['codigo_producto'] === '' || $row_det_factura['codigo_producto'] === null ||
        $row_det_factura['descripcion'] === '' || $row_det_factura['descripcion'] === null) {
        error_log("Producto saltado - codigo: '" . ($row_det_factura['codigo_producto'] ?? 'NULL') . "', descripcion: '" . ($row_det_factura['descripcion'] ?? 'NULL') . "'");
        continue; // Saltar productos sin datos válidos
    }
    
    // Construir un array para cada fila
    $detalle = [
        "item" => $itemCounter++,
        "referencia" => $row_det_factura['codigo_producto'],
        "descripcion" => $row_det_factura['descripcion'],
        "descrip" => $row_det_factura['descripcion'],
        "bodega" => "1",
        "cantidad" => floatval($row_det_factura['cantidadFraccion'] ?? 0),
        "precio" => floatval($row_det_factura['valor_unidad'] ?? 0),
        "descuento" => floatval($row_det_factura['descuento'] ?? 0),
        "iva" => floatval($row_det_factura['iva'] ?? 0),
        "porimptoconsumo" => 0,
        "subtotal" => floatval($row_det_factura['cantidadFraccion'] ?? 0) * floatval($row_det_factura['valor_unidad'] ?? 0),
        "compañia" =>  "1",
        "concepto" => $prefijo,
        "nrodocumento" => strval($consecutivo),
        "costo" => 0,
        "desadicional" => strval(floatval($row_det_factura['descuento'] ?? 0)),
        "tercero" => $tercero,
        "cliente" => strval($idtercero)
    ];
    
    error_log("Detalle agregado para producto: " . $row_det_factura['descripcion']);

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
        "bruto" => floatval($bruto),
        "iva" => floatval($iva),
        "descuento" => "0",
        "despiefact" => 0,
        "retefuente" => 0,
        "reteiva" => 0,
        "ica" => 0,
        "retefte" => 0,
        "impconsumo" => 0,
        "subtotal" => floatval($subtotal),
        "total" => floatval($total),
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

// Log de datos enviados para debug
error_log("=== DATOS ENVIADOS A FACTIN ===");
error_log("URL: " . $externalUrl);
error_log("Cantidad de productos: " . count($detallesFactura));
error_log("Datos JSON: " . json_encode($externalData, JSON_PRETTY_PRINT));

// Inicializar cURL
$ch = curl_init($externalUrl);

// Configurar la solicitud cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
curl_setopt($ch, CURLOPT_POST, true); // Método POST
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Cabecera Content-Type
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($externalData)); // Enviar el cuerpo en formato JSON

// Configuraciones adicionales para resolver problemas de DNS y SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilitar verificación SSL (solo desarrollo)
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Deshabilitar verificación de host SSL
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecciones
curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout de 30 segundos
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Timeout de conexión de 10 segundos
curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 120); // Cache DNS por 2 minutos
// Forzar resolución DNS usando la IP si es necesario
curl_setopt($ch, CURLOPT_RESOLVE, ['www.factin.app:5091:159.65.32.58']);

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si ocurrió un error
if (curl_errno($ch)) {
    // Si hubo un error, devolverlo como respuesta
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al conectar con el servidor de facturación: " . curl_error($ch), 
        "idFactura" => isset($data['idFact']) ? $data['idFact'] : 'No disponible',
        "error" => curl_error($ch),
        "step" => "movimientoapi_connection"
    ]);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Log para debug - quitar después
error_log("HTTP Code del primer API: " . $httpCode);
error_log("Respuesta del primer API: " . $response);

// Verificar si la respuesta fue exitosa
if ($httpCode === 200) {
    // Decodificar respuesta del primer API
    $firstApiResponse = json_decode($response, true);
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

    // Construir la URL del servicio externo
    $externalUrldian = "https://www.factin.app:5091/EnvioApi/" . $prefijo . "/" . $consecutivo . "/73148319/BENIGNO2025/233b2627-adae-430e-9f8c-7f11f7582f95?llave=EDVOAZXWJZMKBXMVVIBZCLXC73148319TQRIAQAAFJGRSGYGJRMJLSMWGAFROSWLYL";

    $ch = curl_init($externalUrldian);

    // Configurar la solicitud cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RESOLVE, ['www.factin.app:5091:159.65.32.58']);
  
    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $httpCodeDian = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Verificar errores
    if (curl_errno($ch)) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Error al enviar a la DIAN: " . curl_error($ch),
            "curl_error" => curl_error($ch),
            "step" => "envio_dian_connection"
        ]);
        curl_close($ch);
        exit;
    }

    
    // Procesar la respuesta del servidor
    if ($response === false || empty($response)) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Respuesta vacía del servidor DIAN",
            "step" => "envio_dian_empty_response",
            "httpCode" => $httpCodeDian
        ]);
    } else {
        // Intentar decodificar la respuesta como JSON
        $responseData = json_decode($response, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            // Si es JSON válido, agregar indicador de éxito
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Factura electrónica creada exitosamente",
                "idFactura" => $consecutivo,
                "prefijo" => $prefijo,
                "data" => $responseData
            ]);
        } else {
            // Si no es JSON, devolver como texto
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Factura electrónica creada exitosamente",
                "idFactura" => $consecutivo,
                "prefijo" => $prefijo,
                "response" => $response
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
    
    echo json_encode([
        "success" => false,
        "message" => "Error al guardar factura: " . $errorMsg,
        "httpCode" => $httpCode,
        "step" => "movimientoapi_failed",
        "errorDetails" => $errorDetails,
        "fullResponse" => $errorResponse ?? $response
    ]);
}
