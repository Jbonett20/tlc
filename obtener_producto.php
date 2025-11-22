<?php
include './app/conexion.php';

$id = $_GET['id'] ?? 0;

// Consulta para obtener el producto
$sql = "SELECT descripcion, codigo_barras, unidad, valor, valor_venta, valor_unidad FROM tbl_producto WHERE codigo_producto = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

$stmt->close();
$link->close();
?>
