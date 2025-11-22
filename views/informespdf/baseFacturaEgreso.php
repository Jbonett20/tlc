<?php
//require_once('pdf/scr/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once '../../app/conexion.php';
use Mpdf\Mpdf;
extract($_REQUEST);
$sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);
$telefono = $filaempresa['telefono'];
$direccion = $filaempresa['direccion'];
ini_set('date.timezone','America/Bogota');
    $hoy =date("d-m-Y h:i:s",time());

sleep(1);
$sqlinventariogeneral =  mysqli_query($link,"SELECT * FROM tbl_empresa");

      if (mysqli_num_rows($sqlinventariogeneral) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
         $respuesta = mysqli_fetch_array($sqlinventariogeneral);
        
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
   '.$respuesta['nombre_empresa'].'</h3><h4 class="tmedia"><br>Nit: '.$respuesta['nit_empresa'].'<br>
    Iva Regimen Simplificado <br>
    factura de Venta N '.$respuesta['codigo_factura'].'<br>
    fecha :'.$respuesta['fecha_factura'].' | '.$respuesta['hora'].'<br>
    cliente:'.$respuesta['nombre_cliente'].'<br>
    CC: '.$respuesta['cc_cliente'].' <br>
    forma de pago: '.$respuesta['tipoPago'].'
    </h4>    
  <p>=============================</p>
    <table>
        <tr>
          <th >PROD.</th>
          </tr>

         <tr>
              <th >_______</th>
             
              </tr>';
        $sql_detallefactura =  mysqli_query($link,"SELECT * FROM tbl_egresos e tbl_tipoegreso te WHERE e.id_tipoEgreso=te.id_tipoEgreso and e.id_egreso='$id'");
      
      $totalvalor=0;
      $ivaV=0;
        while ($respuestadetalle = mysqli_fetch_assoc($sql_detallefactura))
        { 
          
          $totalvalor=$totalvalor+$respuestadetalle['total_pago'];
          $ivaVV=$respuestadetalle['total_pago']*$respuestadetalle['iva']/100;
          $ivaV=$ivaV+$ivaVV;
              

    $variable_html .= '                 
        <tr class="productos">
          <td colspan="4"><strong>'.$respuestadetalle['descripcion'].'-'.$respuestadetalle['presentacion'].'</strong></td>
          </tr>
          <tr>
         
          <th>CANT</th>
          <th>VAL</th>
          <th>TOT</th>
        
        </tr>
         
           <tr class="productos">
          
          <td align="center"><strong>'.$respuestadetalle['cantidad'].':'.$respuestadetalle['cantidadFraccion'].'</strong></td>
         
          <td><strong>$'.number_format($respuestadetalle['valor_venta']).'</strong></td>
          <td><strong>$'.number_format($respuestadetalle['total_pago']).'</strong></td>
        </tr>';
      }
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
        <td><strong>$ '.number_format($respuesta['pagoCambio']).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Cambio</th>
        <td><strong>$ '.number_format($respuesta['cambio']).'</strong></td>
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
