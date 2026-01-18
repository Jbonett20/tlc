<?php
//require_once('pdf/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once '../../app/conexion.php';
use Mpdf\Mpdf;
extract($_REQUEST);
$sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);
$titulo='<div class="titulo">
  
</div>
'
;
$variable_html = '
<!DOCTYPE html>
<html lang="en">
  <style>
    body{
  font-family: courier;
  text-transform: uppercase;
  
}
.cabecera{
  text-align: center;
}
table{
  width:100%;

}
  </style>
  <head>
    <meta charset="utf-8">
    <title>Reporte</title>
    <link rel="stylesheet" href="estilo.css" media="all" />
    
  </head>
  <body style="font-family:courier; text-transform:uppercase;">
    <h4 class="cabecera">
    Drogas Alex<br>Nit: 0000000-00<br>
    Iva Regimen Comun <br>
    factura de Venta N 00001 <br>
    fecha 02-02-2000 07:23 pm <br>
    cliente: General <br>
    nit: 00000001000-0-0 <br>
    forma de pago: Efectivo
    </h4>
  <p>=============================</p>
    <table>
        <tr>
          <th>Cant.</th>
          <th>Desc.</th>
          <th>V. Unitario</th>
          <th>Total</th>
        </tr>

        <tr class="productos">
          <td>3</td>
          <td>pastilla</td>
          <td>200</td>
          <td>600</td>
        </tr>
      
    </table>
  <p>=============================</p>  
    <table class="tmedia">
      <tr>
        <th>subtotal</th>
        <td>$ 600</td>
      </tr>
      <tr>
        <th>descuento</th>
        <td>$ 0</td>
      </tr>
      <tr>
        <th>iva</th>
        <td>$ 120</td>
      </tr>
      <tr>
        <th>Neto</th>
        <td>600</td>
      </tr>
    </table>
    <p>=============================</p>
    <table class="tmedia">
      <tr>
        <th>Efectivo</th>
        <td>$ 2000</td>
      </tr>
      <tr>
        <th>cambio</th>
        <td>$ 1400</td>
      </tr>
    </table>
    <p>=============================</p>
    <h4 class="cabecera">
    Direccion:Coveñas<br>
    Telefono: 4545454545 - 56565656 <br>
    Gracias por su compra
    </h4>
    
  </body>
</html>';
//$mpdf=new mPDF('c','jar','','' , 5, 5, 7 , 0, 0 , 0);
$mpdf = new Mpdf([
  'format' => [79.375, 1411.111],           // Reemplaza 'jar' con un tamaño de papel válido (por ejemplo, 'A4', 'A5', etc.)
  'margin_left' => 5,
  'margin_right' => 5,
  'margin_top' => 7,
  'margin_bottom' => 0,
  'margin_header' => 0, 
  'margin_footer' => 0
]);
$mpdf->SetHTMLHeader($titulo);
$mpdf->WriteHTML($variable_html);
$mpdf->Output();