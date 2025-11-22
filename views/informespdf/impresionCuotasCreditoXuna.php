<?php
//require_once('pdf/scr/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once'../../app/conexion.php';
use Mpdf\Mpdf;
extract($_REQUEST);
$sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);
$telefono = $filaempresa['telefono'];
$direccion = $filaempresa['direccion'];
ini_set('date.timezone','America/Bogota');
    $hoy =date("d-m-Y h:i:s",time());


$sqlinventariogeneral =  mysqli_query($link,"SELECT pla.codigoCredito,dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_credito,abp.valor_abono,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_credito abp WHERE abp.id_credito=pla.id_credito and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_credito='$credito' GROUP BY dpl.id_producto");

      if (mysqli_num_rows($sqlinventariogeneral) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
         $respuesta = mysqli_fetch_array($sqlinventariogeneral);
         $descuentoGeneral = $respuesta['valor_aumeto'];
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
    <meta >
    <title>Reporte</title>
    <link rel="stylesheet" href="estilo.css" media="all" />
    
  </head>
  <body style="font-family:courier; text-transform:uppercase;">
    <h3 class="tmedia">
   '.$filaempresa['nombre_empresa'].'</h3><h4 class="tmedia"><br>Nit: '.$filaempresa['nit_empresa'].'<br>
    Iva Regimen Comun <br>
    factura de credito N° '.$respuesta['codigoCredito'].'<br>
    fecha :'.$respuesta['fecha_inicio'].' | '.$respuesta['fecha_fin'].'<br>
    cliente:'.$respuesta['nombre_cliente'].'<br>
    CC: '.$respuesta['cc_cliente'].' <br>
    forma de pago: EFECTIVO
    </h4>    
  <p>=============================</p>
    <table>
        <tr>
          <th>PROD.</th>
          <th>CANT</th>
          <th>VAL</th>
          <th>TOT</th>
        
        </tr>
         <tr>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              </tr>';
              $sql_abonodetalle= mysqli_query($link,"SELECT * FROM tbl_abonos_credito WHERE id_abonos_credito='$idAbono'");
              $filaAbono= mysqli_fetch_array($sql_abonodetalle);

        $sql_detallefactura =  mysqli_query($link,"SELECT iv.*,pla.codigoCredito,dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_credito,sum(abp.valor_abono) as valor_abono,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.valorTotal,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_credito abp,tbl_iva iv WHERE abp.id_credito=pla.id_credito and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and iv.id_iva=pr.id_iva and pr.id_categoria=c.id_categoria and pla.id_credito='$credito' GROUP BY dpl.id_producto");
      
      $totalvalor=0;
      $ivaV=0;
        while ($respuestadetalle = mysqli_fetch_assoc($sql_detallefactura))
        { 
          
          $totalvalor=$totalvalor+$respuestadetalle['total_pagosepare'];
          $ivaVV=$respuestadetalle['valorTotal']*$respuestadetalle['iva']/100;
          $ivaV=$ivaV+$ivaVV;
          $abono=$respuestadetalle['valor_abono'];
          $deuda=$respuestadetalle['descuento_abonos'];

    $variable_html .= '                 
        <tr class="productos">
          <td><strong>'.$respuestadetalle['descripcion'].'</strong></td>
          <td align="center"><strong>'.$respuestadetalle['cantidad'].':'.$respuestadetalle['cantidadFraccion'].'</strong></td>
         
          <td><strong>$'.number_format($respuestadetalle['valor_venta']).'</strong></td>
          <td><strong>$'.number_format($respuestadetalle['valorTotal']).'</strong></td>
        </tr>';
      }
      $subtotal=$totalvalor - $ivaV;
      $totalconDES=$totalvalor-$descuentoGeneral;
      $variable_html .= '
    </table>
  <p>=============================</p>  

    <table class="tmedia">
      <tr>
        <th class="cabecera2">Subtotal</th>
        <td><strong>$ '.number_format( $totalconDES).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Valor Aumento</th>
        <td><strong>$ '.number_format($descuentoGeneral).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Iva</th>
        <td><strong>$ '.number_format($ivaV).'</strong></td>
      </tr>
      <tr>
        <th class="cabecera2">Neto</th>
        <td><strong>$ '.number_format($subtotal).'</strong></td>
      </tr>
       <tr>
        <th class="cabecera2">Abono</th>
        <td><strong>$ '.number_format($filaAbono['valor_abono']).'</strong></td>
      </tr> <tr>
        <th class="cabecera2">Total Abonos</th>
        <td><strong>$ '.number_format( $abono).'</strong></td>
      </tr> 
      <tr>
        <th class="cabecera2">Deuda</th>
        <td><strong>$ '.number_format($deuda).'</strong></td>
      </tr>
    </table>
    
    
    <p>=============================</p>
    <h4 class="cabecera2">
    Direccion:'.$direccion .'<br>
    Telefono:'.$telefono.' <br>';
  }
    $variable_html.='

   
    </h4>
    <h4 class="cabecera"> ~~Gracias por su compra~~</h4>
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
$variable_html = mb_convert_encoding($variable_html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($variable_html);
$mpdf->Output();