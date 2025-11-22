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
$id = $row["llave"];
// URL del servicio externo al que se hará la solicitud
$externalUrl = "http://159.65.32.58:5041/Inarticulosapi?llave=" . $id;


// Obtener el cuerpo de la solicitud
$requestBody = file_get_contents("php://input");
$data = json_decode($requestBody, true); // Decodificar JSON a array

// Verificar que los datos estén presentes
if (!isset($data['codigo']) || !isset($data['nombre'])) {
    http_response_code(400);
    echo json_encode(["message" => "Faltan los parámetros 'codigo' o 'nombre'"]);
    exit;
}

// Los datos a enviar al servicio externo
$codigo = $data['codigo'];
$nombre = $data['nombre'];

// Otros datos que puedas necesitar (vacíos en este caso)
$inarticulosbodega = isset($data['inarticulosbodega']) ? $data['inarticulosbodega'] : [];
$inarticuloslistaprecio = isset($data['inarticuloslistaprecio']) ? $data['inarticuloslistaprecio'] : [];
$inarticuloscompuesto = isset($data['inarticuloscompuesto']) ? $data['inarticuloscompuesto'] : [];
$inarticulosstock = isset($data['inarticulosstock']) ? $data['inarticulosstock'] : [];

// Datos que se enviarán al servicio externo
$externalData = [
    "codigo" => $codigo,
    "nombre" => $nombre,
    "inarticulosbodega" => $inarticulosbodega,
    "inarticuloslistaprecio" => $inarticuloslistaprecio,
    "inarticuloscompuesto" => $inarticuloscompuesto,
    "inarticulosstock" => $inarticulosstock
];
// Inicializar cURL
$ch = curl_init($externalUrl);

// Configurar la solicitud cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
curl_setopt($ch, CURLOPT_POST, true); // Método POST
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Cabecera Content-Type
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($externalData)); // Enviar el cuerpo en formato JSON

error_log("Enviando a API externa:");
error_log(json_encode($externalData, JSON_PRETTY_PRINT));
// Ejecutar la solicitud
// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si ocurrió un error
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode([
        "message" => "Error en la solicitud externa",
        "error" => curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

// Obtener información detallada
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

curl_close($ch);

// Mostrar respuesta completa
http_response_code($httpCode);
header("Content-Type: " . $contentType); // Mantener el content-type original
echo $response;