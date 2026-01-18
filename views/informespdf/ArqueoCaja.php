<?php
// Incluir archivos necesarios
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once '../../app/conexion.php';

use Mpdf\Mpdf;
// Obetener datos del usuario
$idCajero = isset($_REQUEST['idCajero']) ? intval($_REQUEST['idCajero']) : 0;
$fechaInicio = isset($_REQUEST['inicio']) ? $_REQUEST['inicio'] : '';
$fechaFinal = isset($_REQUEST['final']) ? $_REQUEST['final'] : '';

$nombreUsuario = "TODOS";
if ($idCajero)
{
    $sql_usuario = mysqli_query($link, "SELECT * FROM tbl_usuario_sistema WHERE id_usuariosistema = $idCajero");
    $rUsuario = mysqli_fetch_array($sql_usuario);

    $nombreUsuario = $rUsuario["nombre_usuario"]; 
}

// Obtener datos de la empresa
$sql_empresa = mysqli_query($link, "SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);

$nombreEmpresa  = isset($filaempresa['nombre_empresa']) ? $filaempresa['nombre_empresa'] : '';
$nitEmpresa  = isset($filaempresa['nit_empresa']) ? $filaempresa['nit_empresa'] : '';

// Configurar zona horaria y obtener fechas
ini_set('date.timezone', 'America/Bogota');
$hoy  = date("d-m-Y h:i:s", time());
$hoyd = date("Y-m-d", time());

// Consulta de facturación agrupada por tipo de pago para la fecha actual
$whereVendedor = "";
$whereFecha = "fecha_factura = '$hoyd'";

if ($idCajero)
    $whereVendedor = "id_vendedor = $idCajero AND";

if ($fechaInicio != '' && $fechaFinal == '')
    $whereFecha = "fecha_factura = '$fechaInicio'";
else if ( $fechaInicio != '' && $fechaFinal != '')
    $whereFecha = "fecha_factura BETWEEN '$fechaInicio' AND '$fechaFinal'";

$sqlinventariogeneral = mysqli_query(
    $link,
    "SELECT 
        IFNULL(tipoPago, 'Total') AS tipoPago, 
        SUM(valor_pago) AS total_pago 
    FROM tbl_factura 
    WHERE $whereVendedor $whereFecha 
    GROUP BY tipoPago WITH ROLLUP"
);

$whereFecha = str_replace("fecha_factura", "fecha", $whereFecha);

if (!$idCajero) {
    $sqlGastosDiario = mysqli_query($link, "SELECT SUM(valor) FROM tbl_egresos WHERE $whereFecha");
    $sqlBaseDiario = mysqli_query($link, "SELECT SUM(base) FROM tbl_basediaria WHERE $whereFecha");
} else {
    $sqlGastosDiario = mysqli_query($link, "SELECT SUM(valor) FROM tbl_egresos WHERE $whereFecha and id_user='$caja'");
    $sqlBaseDiario = mysqli_query($link, "SELECT SUM(base) FROM tbl_basediaria WHERE $whereFecha");
}

$gastos = doubleval(mysqli_fetch_array($sqlGastosDiario)[0]);
$base = doubleval(mysqli_fetch_array($sqlBaseDiario)[0]);

// Construir el contenido de las filas de la tabla
$tablaContenido = '';
$totalPagos = 0;

if (mysqli_num_rows($sqlinventariogeneral) == 0) {
    $tablaContenido .= '<tr><td colspan="2">No se encontraron resultados</td></tr>';
} else {
    while ($row = mysqli_fetch_assoc($sqlinventariogeneral)) {
        $tablaContenido .= '<tr>';
        $tablaContenido .= '<td>' . htmlspecialchars($row['tipoPago']) . '</td>';
        $tablaContenido .= '<td>' . number_format($row['total_pago'], 2, ',', '.') . '</td>';
        $tablaContenido .= '</tr>';

        if ($row['tipoPago'] == "Total")
            $totalPagos = doubleval($row['total_pago']);
    }
}

// Cargar la plantilla HTML
$templatePath = __DIR__ . '/pdf/reporttmpl/tmplarqueocaja.html';
if (!file_exists($templatePath)) {
    die("La plantilla no se encontró en: $templatePath");
}
$templateHtml = file_get_contents($templatePath);

// Realizar el reemplazo de los placeholders en la plantilla
$strFecha = "Fecha: $hoy";

if ($fechaInicio != '' && $fechaFinal == '')
    $strFecha = "Fecha: $fechaInicio";
else if ( $fechaInicio != '' && $fechaFinal != '')
    $strFecha = "Desde: $fechaInicio<br>Hasta: $fechaFinal";

$placeholders = [
    '{vendedor}'    => $nombreUsuario,
    '{fecha}'    => $strFecha,
    '{nombre_empresa}'      => htmlspecialchars($nombreEmpresa),
    '{nit_empresa}'     => htmlspecialchars($nitEmpresa),
    '{detalles}' => $tablaContenido,
    '{gastos}' => number_format($gastos, 2, ',', '.'),
    '{base}' => number_format($base, 2, ',', '.'),
    '{neto}' => number_format($totalPagos + $base - $gastos, 2, ',', '.')
];
$html = str_replace(array_keys($placeholders), array_values($placeholders), $templateHtml);

// Configurar y crear el objeto Mpdf
$mpdf = new Mpdf([
    'format'        => [79.375, 1411.111], // Formato de papel personalizado
    'margin_left'   => 5,
    'margin_right'  => 5,
    'margin_top'    => 7,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0
]);

// Establecer el encabezado del PDF
$mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">' . htmlspecialchars($titulo) . '</div>');

// Escribir el contenido HTML en el PDF
$mpdf->WriteHTML($html);

// Enviar el PDF generado al navegador
$mpdf->Output();
