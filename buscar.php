<?php
include './app/conexion.php';

$busqueda = isset($_GET['buscar']) ? $link->real_escape_string($_GET['buscar']) : '';

$sql = "SELECT 
            p.codigo_producto, 
            p.codigo_barras, 
            p.descripcion AS nombre, 
            i.stock AS stock, 
            p.valor, 
            p.valor_venta, 
            p.valor_unidad
        FROM tbl_producto p
        LEFT JOIN tbl_inventario i ON p.codigo_producto = i.id_producto";

if (!empty($busqueda)) {
    $sql .= " WHERE p.descripcion LIKE '%$busqueda%'";
}

$result = $link->query($sql);
?>

<table>
    <thead>
        <tr>
            <th>Cod. Producto</th>
            <th>Código de Barras</th>
            <th>Nombre</th>
            <th>stock</th>
            <th>Valor</th>
            <th>Venta</th>
            <th>Valor U</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['codigo_producto']) . "</td>";
                echo "<td>" . htmlspecialchars($row['codigo_barras']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                echo "<td>" . htmlspecialchars($row['valor']) . "</td>";
                echo "<td>" . htmlspecialchars($row['valor_venta']) . "</td>";
                echo "<td>" . htmlspecialchars($row['valor_unidad']) . "</td>";
                echo "<td>
                        <button type='button' onclick=\"abrirModal('{$row['codigo_producto']}', '{$row['codigo_barras']}', '{$row['nombre']}', '{$row['stock']}', '{$row['valor']}', '{$row['valor_venta']}', '{$row['valor_unidad']}')\">Editar</button>
                        <form action='eliminar.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['codigo_producto']}'>
                            <button type='submit'>Eliminar</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No se encontraron resultados</td></tr>";
        }
        ?>
    </tbody>
</table>
