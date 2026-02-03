<?php
//require_once('pdf/scr/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once '../../app/conexion.php';
use Mpdf\Mpdf;
extract($_REQUEST);
$id = isset($id) ? $id : null;
$descuentoGeneral = isset($descuentoGeneral) ? (float)$descuentoGeneral : 0;
$sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);
$telefono = $filaempresa['telefono'];
$direccion = $filaempresa['direccion'];
ini_set('date.timezone','America/Bogota');
    $hoy =date("d-m-Y h:i:s",time());

sleep(1);
$sql_egreso = mysqli_query($link,"SELECT e.*, te.codigo_egreso, te.nombreTipo, te.concepto FROM tbl_egresos e INNER JOIN tbl_tipoegreso te ON e.id_tipoEgreso=te.id_tipoEgreso WHERE e.id_egreso='$id'");

      if (mysqli_num_rows($sql_egreso) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
         $egreso = mysqli_fetch_assoc($sql_egreso);
        
$titulo='<div class="titulo">
  
</div>
'
;
$variable_html = '
<!DOCTYPE html>
<html lang="en">


  <head>
    <meta >
    <title>Reporte</title>
    <link rel="stylesheet" href="estilo.css" media="all" />
    
  </head>
  <body >
    <h3 class="tmedia">
   '.$filaempresa['nombre_empresa'].'</h3><h4 class="tmedia"><br>Nit: '.$filaempresa['nit_empresa'].'<br>
    Iva Regimen Simplificado <br>
    Recibo de Egreso N '.$egreso['id_egreso'].'<br>
    fecha :'.$egreso['fecha'].'<br>
    pagado a: '.$egreso['pagado'].'<br>
    concepto: '.$egreso['nombreTipo'].'
    </h4>    
  <p>=============================</p>
    <table>
        <tr>
          <th >CONCEPTO</th>
          <th >VALOR</th>
          </tr>

         <tr>
              <th >_______</th>
              <th >_______</th>
             
              </tr>';
      
      $totalvalor = (float)$egreso['valor'];
      $ivaV = 0;
      $variable_html .= '                 
        <tr class="productos">
          <td><strong>'.$egreso['codigo_egreso'].' - '.$egreso['nombreTipo'].'</strong></td>
          <td><strong>$'.number_format($totalvalor).'</strong></td>
        </tr>';
      $subtotal=$totalvalor - $ivaV+$descuentoGeneral;
      $totalconDES=$totalvalor;
      $variable_html .= '
    </table>
  <p>=============================</p>  

    <table class="tmedia">
      <tr>
        <th class="cabecera2">Subtotal</th>
        <td><strong>$ '.number_format( $subtotal).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Descuento</th>
        <td><strong>$ '.number_format($descuentoGeneral).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Iva</th>
        <td><strong>$ '.number_format($ivaV).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Neto</th>
        <td><strong>$ '.number_format($totalconDES).'</strong></td>
      </tr>
    
      <tr>
        <th class="cabecera2">Efectivo</th>
        <td><strong>$ '.number_format($totalconDES).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Cambio</th>
        <td><strong>$ 0</strong></td>
      </tr>
    </table>
    <p>=============================</p>
    <h4 class="cabecera2">
    Direccion:<br>'.$direccion .'<br>
    Telefono:<br>'.$telefono.' <br>';
  }
    $variable_html.='

   
    </h4>
    <h4 class="cabecera"> ~~Gracias por su compra~~</h4>
  </body>
</html>';
//$mpdf=new mPDF('c','jar','','' , 3, 5, 7 , 0, 0 , 0); // clase desconocida
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
$variable_html = mb_convert_encoding($variable_html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($variable_html);
$mpdf->Output();
