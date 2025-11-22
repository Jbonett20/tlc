<?php
include './app/conexion.php';

// Verificar que se reciban los datos
if (
    isset($_POST['codigo']) &&
    isset($_POST['codigo_barras']) &&
    isset($_POST['nombre']) &&
    isset($_POST['stock']) &&
    isset($_POST['proveedor']) &&
    isset($_POST['categoria']) &&
    isset($_POST['iva']) &&
    isset($_POST['valor']) &&
    isset($_POST['valor_venta']) &&
    isset($_POST['valor_unidad'])
) {
    $codigo = $link->real_escape_string($_POST['codigo']);
    $codigo_barras = $link->real_escape_string($_POST['codigo_barras']);
    $nombre = $link->real_escape_string($_POST['nombre']);
    $stock = $link->real_escape_string($_POST['stock']);
    $proveedor = $link->real_escape_string($_POST['proveedor']);
    $categoria = $link->real_escape_string($_POST['categoria']);
    $iva = $link->real_escape_string($_POST['iva']);
    $valor = $link->real_escape_string($_POST['valor']);
    $valor_venta = $link->real_escape_string($_POST['valor_venta']);
    $valor_unidad = $link->real_escape_string($_POST['valor_unidad']);

    // Depuración: Verifica los valores recibidos
    error_log("Actualizando producto con código: $codigo");

    // Consulta para actualizar el producto en tbl_producto
    $sql_producto = "UPDATE tbl_producto 
                     SET codigo_barras = '$codigo_barras',
                         descripcion = '$nombre',
                         id_proveedor = '$proveedor',
                         id_categoria = '$categoria',
                         id_iva = '$iva',
                         valor = '$valor',
                         valor_venta = '$valor_venta',
                         valor_unidad = '$valor_unidad'
                     WHERE codigo_producto = '$codigo'";

    if ($link->query($sql_producto)) {
        // Consulta para actualizar la unidad en tbl_inventario
        $sql_inventario = "UPDATE tbl_inventario 
                           SET stock = '$stock'
                           WHERE id_producto = '$codigo'";

        if ($link->query($sql_inventario)) {
            echo "success";
        } else {
            error_log("Error al actualizar tbl_inventario: " . $link->error);
            echo "Error: No se pudo actualizar el inventario.";
        }
    } else {
        error_log("Error al actualizar tbl_producto: " . $link->error);
        echo "Error: No se pudo actualizar el producto.";
    }
} else {
    echo "Error: Datos incompletos para la actualización.";
}

$link->close();
