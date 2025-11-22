<?php
// Configurar cabeceras para CORS (opcional)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "nombre_de_tu_base_de_datos";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Error de conexión: " . $conn->connect_error]));
}

// Leer datos enviados desde Angular
$input = json_decode(file_get_contents('php://input'), true);
$idProducto = $input['idProducto'];
$cantidad = $input['cantidad'];

// Validar datos recibidos
if (!$idProducto || $cantidad <= 0) {
    echo json_encode(["success" => false, "message" => "Datos inválidos"]);
    exit;
}

// Consultar la cantidad actual en la tabla de inventario
$sql = "SELECT cantidad FROM tbl_inventario WHERE id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idProducto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cantidadActual = $row['cantidad'];

    if ($cantidadActual >= $cantidad) {
        // Actualizar cantidad
        $nuevaCantidad = $cantidadActual - $cantidad;
        $updateSql = "UPDATE tbl_inventario SET cantidad = ? WHERE id_producto = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $nuevaCantidad, $idProducto);
        if ($updateStmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar la cantidad"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Cantidad insuficiente en el inventario"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
}

// Cerrar conexión
$conn->close();
?>
