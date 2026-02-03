<?php
include '../conexion.php';

$inicio = isset($_GET['inicio']) ? mysqli_real_escape_string($link, $_GET['inicio']) : '';
$fin = isset($_GET['fin']) ? mysqli_real_escape_string($link, $_GET['fin']) : '';

$where = "WHERE 1=1";
if ($inicio !== '' && $fin !== '') {
    $where .= " AND e.fecha BETWEEN '$inicio' AND '$fin'";
} elseif ($inicio !== '') {
    $where .= " AND e.fecha >= '$inicio'";
} elseif ($fin !== '') {
    $where .= " AND e.fecha <= '$fin'";
}

$sql = "SELECT e.id_egreso, te.codigo_egreso, te.nombreTipo, te.concepto, e.pagado, e.valor, e.mes, e.fecha, e.id_user
        FROM tbl_egresos e
        INNER JOIN tbl_tipoegreso te ON e.id_tipoEgreso = te.id_tipoEgreso
        $where
        ORDER BY e.id_egreso DESC";

$resultado = mysqli_query($link, $sql);

if ($resultado) {
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="egresos_' . date('Y-m-d_H-i-s') . '.xls"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo "<?xml version=\"1.0\"?>\n";
    echo "<?mso-application progid=\"Excel.Sheet\"?>\n";
    echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";
    echo "<Styles>\n";
    echo "<Style ss:ID=\"Header\"><Font ss:Bold=\"1\" ss:Color=\"#FFFFFF\"/><Interior ss:Color=\"#4CAF50\" ss:Pattern=\"Solid\"/></Style>\n";
    echo "<Style ss:ID=\"Right\"><Alignment ss:Horizontal=\"Right\"/></Style>\n";
    echo "<Style ss:ID=\"Center\"><Alignment ss:Horizontal=\"Center\"/></Style>\n";
    echo "</Styles>\n";
    echo "<Worksheet ss:Name=\"Egresos\">\n";
    echo "<Table>\n";
    echo "<Row>\n";
    $headers = ['ID','Código','Nombre','Concepto','Pagado a','Valor','Mes','Fecha','Usuario'];
    foreach ($headers as $h) {
        echo "<Cell ss:StyleID=\"Header\"><Data ss:Type=\"String\">" . htmlspecialchars($h) . "</Data></Cell>\n";
    }
    echo "</Row>\n";

    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<Row>\n";
        echo "<Cell ss:StyleID=\"Center\"><Data ss:Type=\"Number\">" . (int)$fila['id_egreso'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['codigo_egreso']) . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['nombreTipo']) . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['concepto']) . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['pagado']) . "</Data></Cell>\n";
        echo "<Cell ss:StyleID=\"Right\"><Data ss:Type=\"Number\">" . (float)$fila['valor'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['mes']) . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fila['fecha']) . "</Data></Cell>\n";
        echo "<Cell ss:StyleID=\"Center\"><Data ss:Type=\"Number\">" . (int)$fila['id_user'] . "</Data></Cell>\n";
        echo "</Row>\n";
    }

    echo "</Table>\n";
    echo "</Worksheet>\n";
    echo "</Workbook>\n";
} else {
    echo 'Error en la consulta: ' . mysqli_error($link);
}
