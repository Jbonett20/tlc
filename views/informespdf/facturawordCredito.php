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


$sqlinventariogeneral =  mysqli_query($link,"SELECT c.valor_aumeto,c.id_credito,c.codigoCredito,c.fecha_inicio,c.fecha_fin,c.valorTotal,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.presentacion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,dc.cantidad,dc.cantidadFraccion,dc.valor_actual_producto,p.valor_venta,p.*,c.* FROM tbl_credito c, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detalle_credito dc, tbl_categoria cat WHERE  c.id_cliente=cli.id_cliente and dc.id_producto=p.id_producto and dc.id_credito=c.id_credito and p.id_categoria=cat.id_categoria and dc.id_credito='$factura'");

      if (mysqli_num_rows($sqlinventariogeneral) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
         $respuesta = mysqli_fetch_array($sqlinventariogeneral);
         $valorAumento = $respuesta['valor_aumeto'];
$titulo='<div class="titulo">
  
</div>
'
;
$variable_html = '
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta >
    <title>Reporte</title>
    <link rel="stylesheet" href="facturaword.css" media="all" />
    
  </head>
  <body>
  <div class="logo">   </div>

    <h3 class="tmedia">
      '.$filaempresa['nombre_empresa'].' <br>
      NIT: '.$filaempresa['nit_empresa'].' <br>
      IVA REGIMEN COMUN <br>
      DIRECCION: '.$direccion.' <br>
      TELEFONO: '.$telefono .'


    </h3>

<table class="padre">
  <tr>
 

    <td class="padretd2">


    <table class="factura">
    <tr class="ti_fac">
      <th>CREDITO</th>
      <td></td>
    </tr>
      <tr>
        <th>N° DE CREDITO </th>
        <td> '.$respuesta['codigoCredito'].'</td>
      </tr>
      <tr>
        <th>FECHA</th>
        <td> '.$respuesta['fecha_inicio'].' | '.$respuesta['fecha_fin'].'</td>
      </tr>

       <tr>
        <th>CLIENTE</th>
        <td>'.$respuesta['nombre_cliente'].'</td>
      </tr>

      <tr>
        <th>CC</th>
        <td> '.$respuesta['cc_cliente'].'</td>
      </tr>

      <tr>
        <th>FORMA DE PAGO</th>
        <td> EFECTIVO</td>
      </tr>

    </table>
</td>
  </tr>    
</table>

    <table>
        <tr class="desp">
          <th>PRODUCTOS.</th>
          <th>CANT.</th>
          <th>VALOR</th>
          <th>TOTAL</th>
        
        </tr>

        ';
        $sql_detallefactura =  mysqli_query($link,"SELECT  c.valor_aumeto,c.id_credito,c.codigoCredito,c.fecha_inicio,c.fecha_fin,c.valorTotal,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,dc.cantidad,dc.cantidadFraccion,dc.valor_actual_producto,p.valor_venta,iv.* FROM tbl_credito c, tbl_cliente cli, tbl_producto p, tbl_detalle_credito dc, tbl_categoria cat,tbl_iva iv WHERE  c.id_cliente=cli.id_cliente and dc.id_producto=p.id_producto and dc.id_credito=c.id_credito and p.id_categoria=cat.id_categoria and iv.id_iva=p.id_iva and dc.id_credito='$factura'");
      
      $totalvalor=0;
      $ivaV=0;
        while ($respuestadetalle = mysqli_fetch_assoc($sql_detallefactura))
        { 
          
          $totalvalor=$totalvalor+$respuestadetalle['valor_actual_producto'];
          $ivaVV=$respuestadetalle['valor_actual_producto']*$respuestadetalle['iva']/100;
          $ivaV=$ivaV+$ivaVV;
              

    $variable_html .= '                 
        <tr class="productos">
          <td align="center"><strong>'.$respuestadetalle['descripcion'].'</strong></td>
          <td align="center"><strong>'.$respuestadetalle['cantidad'].':'.$respuestadetalle['cantidadFraccion'].'</strong></td>
         
          <td align="center"><strong>$'.number_format($respuestadetalle['valor_venta']).'</strong></td>
          <td align="center"><strong>$'.number_format($respuestadetalle['valor_actual_producto']).'</strong></td>
        </tr>';
      }
      $subtotal=$totalvalor - $ivaV;
      $totalconDES=$totalvalor+$valorAumento;
      $variable_html .= '
    </table>
  

    <table class="totales">
      
      <tr>
        <th class="cabecera2">EFECTIVO:</th>
        <td><strong>$ '.number_format(0).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">CAMBIO:</th>
        <td><strong>$ '.number_format(0).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">SUBTOTAL:</th>
        <td><strong>$ '.number_format( $subtotal).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">DESCUENTO:</th>
        <td><strong>$ '.number_format($valorAumento).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">IVA:</th>
        <td><strong>$ '.number_format($ivaV).'</strong></td>
      </tr>
      <tr class="neto">
        <th class="cabecera2">NETO:</th>
        <td><strong>$ '.number_format($totalconDES).'</strong></td>
      </tr>
    </table>

    ';
  }
  $footer=    '<h4 class="cabecera"> ~~Gracias por su compra~~</h4>';
    $variable_html.='

  
  </body>
</html>';

//$mpdf=new mPDF('c','A4','','' , 5, 5, 7 , 0, 0 , 0);
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
$mpdf->SetHTMLFooter ($footer);
$variable_html = mb_convert_encoding($variable_html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($variable_html);
$mpdf->Output();