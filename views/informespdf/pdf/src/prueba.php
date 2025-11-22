<?php


//C:\xampp\htdocs\app0\views\informespdf\pdf\vendor\autoload.php
/* require '../vendor/autoload.php';
if (class_exists('Psr\Log\LoggerAwareInterface')) {
    echo "LoggerAwareInterface está disponible.";
} else {
    echo "LoggerAwareInterface NO está disponible.";
}*/
/*
if (extension_loaded('apcu')) {
    echo "APCu está cargada";
} else {
    echo "APCu no está cargada";
}

//phpinfo();
*/

// Conexión a la base de datos
require_once 'C:\xampp\htdocs\app0\app\conexion.php';

// Consulta para seleccionar todos los registros de tbl_inventario
$sql = mysqli_query($link,"SELECT id_inventario FROM tbl_inventario");

if (mysqli_num_rows($sql) > 0) {
    // Iterar sobre cada registro para actualizar el stock con un valor aleatorio
    while ($row = $sql->fetch_assoc()) {
        $id_inventario = $row['id_inventario'];
        // Generar un número aleatorio para el campo 'stock'
        $stock_random = rand(1, 100); // Cambia el rango según tus necesidades

        // Actualizar el campo 'stock' con el valor aleatorio
        $update_sql = "UPDATE tbl_inventario SET stock = $stock_random WHERE id_inventario = $id_inventario";
        
        if ($link->query($update_sql) === TRUE) {
            echo "Registro actualizado con éxito: id_inventario = $id_inventario, stock = $stock_random<br>";
        } else {
            echo "Error al actualizar el registro: " . $link->error . "<br>";
        }
    }
} else {
    echo "No se encontraron registros en la tabla tbl_inventario.";
}

// Cerrar conexión
$link->close();