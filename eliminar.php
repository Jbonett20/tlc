<?php
include './app/conexion.php';

if (isset($_GET['id'])) {
    $id = $link->real_escape_string($_GET['id']);

    $sql = "DELETE FROM tbl_producto WHERE codigo_producto = '$id'";
    if ($link->query($sql)) {
        echo "success";
    } else {
        echo "Error: " . $link->error;
    }
} else {
    echo "No se proporcionó un ID válido.";
}

$link->close();
?>
