<?php
include(__DIR__ . '/../conexion.php');
extract($_REQUEST);
ini_set('date.timezone', 'America/Bogota');

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
//obtener datos de la factura (encabezado)
$sql_factura = mysqli_query($link, "SELECT f.*,c.cc_cliente,c.nombre_cliente FROM tbl_factura as f left join tbl_cliente as c on c.id_cliente=f.id_cliente where f.id_factura='$idFact' " );
$row_factura = mysqli_fetch_array($sql_factura);
//obtener datos detalle factura
$sql_det_factura = mysqli_query($link, "SELECT f.*,p.codigo_producto,p.descripcion,i.iva,p.valor_unidad FROM tbl_detallefactura as f left join tbl_producto as p on p.id_producto=f.id_producto left join tbl_iva as i on i.id_iva=p.id_iva where id_factura='$idFact' " );

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
    // Construir un array para cada fila
    $detalle = [
        "item" => $itemCounter++,
        "referencia" => $row_det_factura['codigo_producto'] ?? "",
        "descripcion" => $row_det_factura['descripcion'] ?? "",
        "descrip" => $row_det_factura['descripcion'] ?? "",
        "bodega" => "1", // Valor predeterminado, ya que no está en la consulta
        "cantidad" => $row_det_factura['cantidadFraccion'] ?? 0,
        "precio" => $row_det_factura['valor_unidad'] ?? 0, // Asegúrate de que exista 'precio' en la consulta si es necesario
        "descuento" => $row_det_factura['descuento'] ?? 0,
        "iva" => $row_det_factura['iva'] ?? 0,
        "porimptoconsumo" => 0,
                "subtotal" => $row_det_factura['cantidadFraccion']*$row_det_factura['valor_unidad'],
                "compañia" =>  "",
                "concepto" => $prefijo,
                "nrodocumento" => $consecutivo ?? 123,
                "costo" => 0,
                "desadicional" => $dataF['descuento'] ?? "0",
                "tercero" => $tercero ?? "",
                "cliente" =>$idtercero?? ""
    ];

    // Agregar al array general
    $detallesFactura[] = $detalle;
}


// Objeto dinámico
$externalData = [
    "faencmovi" => [
        "compañia" =>$compa,
        "concepto" =>$prefijo,
        "ndocumento" =>$consecutivo ?? 0,
        "fecha" => date("Y-m-d"),
        "tercero" => $tercero,
        "cliente" => $idtercero,
        "nombrecli" => $tercero,
        "observacion" => "",
        "bruto" => $bruto ?? 0,
        "iva" => $iva ?? 0,
        "descuento" => "0",
        "despiefact" => 0,
        "retefuente" => 0,
        "reteiva" => 0,
        "ica" => 0,
        "retefte" => 0,
        "impconsumo" => 0,
        "subtotal" => $subtotal ?? 0,
        "total" => $total ?? 0,
        "fechpost" =>date("Y-m-d"),
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


// Inicializar cURL
$ch = curl_init($externalUrl);

// Configurar la solicitud cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
curl_setopt($ch, CURLOPT_POST, true); // Método POST
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Cabecera Content-Type
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($externalData)); // Enviar el cuerpo en formato JSON

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si ocurrió un error
if (curl_errno($ch)) {
    // Si hubo un error, devolverlo como respuesta
    http_response_code(500);
    echo json_encode(["message" => "Error en la solicitud externa" ." id".$data , "error "=> curl_error($ch)]);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Verificar si la respuesta fue exitosa
if ($httpCode === 200) {
// Asegúrate de que $prefijo y $consecutivo están definidos
    if (!isset($prefijo) || !isset($consecutivo)) {
        http_response_code(400);
        echo json_encode(["message" => "Faltan parámetros requeridos: prefijo o consecutivo"]);
        exit;
    }

    // Construir la URL del servicio externo
    $externalUrldian = "https://www.factin.app:5091/EnvioApi/" . $prefijo . "/" . $consecutivo . "/73148319/BENIGNO2025/233b2627-adae-430e-9f8c-7f11f7582f95?llave=EDVOAZXWJZMKBXMVVIBZCLXC73148319TQRIAQAAFJGRSGYGJRMJLSMWGAFROSWLYL";

    $ch = curl_init($externalUrldian);

    // Configurar la solicitud cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
  
    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Verificar errores
    if (curl_errno($ch)) {
        http_response_code(500);
        echo json_encode([
            "message" => "Error en la solicitud externa",
            "curl_error" => curl_error($ch)
        ]);
        curl_close($ch);
        exit;
    }

    
    // Mostrar el contenido de la respuesta
    if ($response === false || empty($response)) {
        echo "Respuesta vacía del servidor externo.\n";
    } else {
        echo $response;
    }

    curl_close($ch);
 
} else {
    // Si la respuesta no fue exitosa, devolver el mensaje de error
    http_response_code($httpCode);
    echo json_encode(["message" => "Error en la solicitud externa" , "httpCode" => $httpCode, "response" => $response]);
}
