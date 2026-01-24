<?php
include '../conexion.php';

$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';

switch ($operacion) {
    case 'listar':
        listarInventarioGeneral($link);
        break;
    case 'exportar':
        exportarExcel($link);
        break;
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function listarInventarioGeneral($link) {
    header('Content-Type: application/json; charset=utf-8');
    $sql = "SELECT 
                p.id_producto,
                p.codigo_producto,
                CASE 
                    WHEN p.descripcion IS NULL OR p.descripcion = '' THEN 'SIN DESCRIPCION'
                    ELSE p.descripcion
                END AS descripcion,
                p.presentacion,
                p.valor,
                p.valor_venta,
                p.valor_unidad,
                i.Unidad,
                i.stock,
                i.fecha_movimiento
            FROM tbl_producto p
            INNER JOIN tbl_inventario i ON p.id_producto = i.id_producto
            WHERE p.id_producto IS NOT NULL
            ORDER BY 
                CASE 
                    WHEN p.descripcion IS NULL OR p.descripcion = '' THEN 1
                    ELSE 0
                END,
                p.descripcion ASC";

    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        $datos = array();
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $datos[] = array(
                'id_producto' => $fila['id_producto'],
                'codigo_producto' => $fila['codigo_producto'],
                'descripcion' => $fila['descripcion'] . ' ' . $fila['presentacion'],
                'Unidad' => intval($fila['Unidad']),
                'stock' => intval($fila['stock']),
                'valor' => floatval($fila['valor']),
                'valor_venta' => floatval($fila['valor_venta']),
                'valor_unidad' => floatval($fila['valor_unidad']),
                'fecha_movimiento' => $fila['fecha_movimiento']
            );
        }
        echo json_encode($datos);
    } else {
        echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($link)]);
    }
}

function exportarExcel($link) {
    $sql = "SELECT 
                p.codigo_producto,
                CASE 
                    WHEN p.descripcion IS NULL OR p.descripcion = '' THEN 'SIN DESCRIPCION'
                    ELSE p.descripcion
                END AS descripcion,
                p.presentacion,
                i.Unidad,
                i.stock,
                p.valor,
                p.valor_venta,
                p.valor_unidad,
                (i.Unidad * p.valor + i.stock * p.valor_unidad) as total_inventario
            FROM tbl_producto p
            INNER JOIN tbl_inventario i ON p.id_producto = i.id_producto
            WHERE p.id_producto IS NOT NULL
            ORDER BY 
                CASE 
                    WHEN p.descripcion IS NULL OR p.descripcion = '' THEN 1
                    ELSE 0
                END,
                p.descripcion ASC";

    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="inventario_general_' . date('Y-m-d_H-i-s') . '.xls"');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo "<?xml version=\"1.0\"?>\n";
        echo "<?mso-application progid=\"Excel.Sheet\"?>\n";
        echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";
        echo "<Styles>\n";
        echo "<Style ss:ID=\"Header\"><Font ss:Bold=\"1\" ss:Color=\"#FFFFFF\"/><Interior ss:Color=\"#4CAF50\" ss:Pattern=\"Solid\"/></Style>\n";
        echo "<Style ss:ID=\"Total\"><Font ss:Bold=\"1\" ss:Color=\"#FFFFFF\"/><Interior ss:Color=\"#2196F3\" ss:Pattern=\"Solid\"/></Style>\n";
        echo "<Style ss:ID=\"Center\"><Alignment ss:Horizontal=\"Center\"/></Style>\n";
        echo "<Style ss:ID=\"Right\"><Alignment ss:Horizontal=\"Right\"/></Style>\n";
        echo "</Styles>\n";
        echo "<Worksheet ss:Name=\"Inventario General\">\n";
        echo "<Table>\n";
        echo "<Row>\n";
        $headers = ['Código','Descripción','Unidad','Stock','Valor','Valor Venta','Valor Unidad','Total Inventario'];
        foreach ($headers as $h) {
            echo "<Cell ss:StyleID=\"Header\"><Data ss:Type=\"String\">" . htmlspecialchars($h) . "</Data></Cell>\n";
        }
        echo "</Row>\n";

        $totalGeneral = 0;
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $totalGeneral += $fila['total_inventario'];
            echo "<Row>\n";
            echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['codigo_producto']) . "</Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['descripcion'] . ' ' . $fila['presentacion']) . "</Data></Cell>\n";
            echo "<Cell ss:StyleID=\"Center\"><Data ss:Type=\"Number\">" . (int)$fila['Unidad'] . "</Data></Cell>\n";
            echo "<Cell ss:StyleID=\"Center\"><Data ss:Type=\"Number\">" . (int)$fila['stock'] . "</Data></Cell>\n";
            echo "<Cell ss:StyleID=\"Right\"><Data ss:Type=\"Number\">" . (float)$fila['valor'] . "</Data></Cell>\n";
            echo "<Cell ss:StyleID=\"Right\"><Data ss:Type=\"Number\">" . (float)$fila['valor_venta'] . "</Data></Cell>\n";
            echo "<Cell ss:StyleID=\"Right\"><Data ss:Type=\"Number\">" . (float)$fila['valor_unidad'] . "</Data></Cell>\n";
            echo "<Cell ss:StyleID=\"Right\"><Data ss:Type=\"Number\">" . (float)$fila['total_inventario'] . "</Data></Cell>\n";
            echo "</Row>\n";
        }

        echo "<Row>\n";
        echo "<Cell ss:MergeAcross=\"6\" ss:StyleID=\"Total\"><Data ss:Type=\"String\">TOTAL GENERAL:</Data></Cell>\n";
        echo "<Cell ss:StyleID=\"Total\"><Data ss:Type=\"Number\">" . (float)$totalGeneral . "</Data></Cell>\n";
        echo "</Row>\n";
        echo "</Table>\n";
        echo "</Worksheet>\n";
        echo "</Workbook>\n";
    } else {
        echo 'Error en la consulta: ' . mysqli_error($link);
    }
}
?>
