<?php
//require_once('pdf/src/mpdf.php');
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
   
    $variable_html = ""; //agregado

$sqlinventariogeneral =  mysqli_query($link,"SELECT f.tipoPago,f.descuento,f.id_factura,f.codigo_factura,f.fecha_factura,f.hora,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.presentacion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.cantidadFraccion,df.total_pago,p.valor_venta,p.*,em.*,f.*, us.nombre_usuario FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat, tbl_usuario_sistema us WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and us.id_usuariosistema=f.id_vendedor and p.id_categoria=cat.id_categoria and df.id_factura='$factura'");

      if (mysqli_num_rows($sqlinventariogeneral) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
         $respuesta = mysqli_fetch_array($sqlinventariogeneral);
         $descuentoGeneral = $respuesta['descuento'];
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
<center>
    <h3 class="tmedia">
   '.$respuesta['nombre_empresa'].'</h3>
   </center>
   
   <h4 class="tmedia"><br>Nit: '.$respuesta['nit_empresa'].'<br>
    Iva Régimen Común <br>
    factura de Venta N '.$respuesta['codigo_factura'].'<br>
    fecha :'.$respuesta['fecha_factura'].' | '.$respuesta['hora'].'<br>
    cliente:'.$respuesta['nombre_cliente'].'<br>
    CC: '.$respuesta['cc_cliente'].' <br>
    forma de pago: '.$respuesta['tipoPago'].'<br>
    Vendedor: '.$respuesta['nombre_usuario'].'
    
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
        $sql_detallefactura =  mysqli_query($link,"SELECT  f.descuento,f.id_factura,f.codigo_factura,f.fecha_factura,f.hora,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.cantidadFraccion,df.total_pago,p.valor_venta,iv.* FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat,tbl_iva iv WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and p.id_categoria=cat.id_categoria and iv.id_iva=p.id_iva and df.id_factura='$factura'");
      
      $totalvalor=0;
      $ivaV=0;
        while ($respuestadetalle = mysqli_fetch_assoc($sql_detallefactura))
        { 
          
          $totalvalor=$totalvalor+$respuestadetalle['total_pago'];
          $ivaVV=$respuestadetalle['total_pago']*$respuestadetalle['iva']/100;
          $ivaV=$ivaV+$ivaVV;
              

    $variable_html .= '                 
        <tr class="productos">
          <td><strong>'.$respuestadetalle['descripcion'].'</strong></td>
          <td align="center"><strong>'.$respuestadetalle['cantidad'].':'.$respuestadetalle['cantidadFraccion'].'</strong></td>
         
          <td><strong>$'.number_format($respuestadetalle['valor_venta']).'</strong></td>
          <td><strong>$'.number_format($respuestadetalle['total_pago']).'</strong></td>
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
    </table>
    
    <table class="tmedia">
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
    Direccion:'.$telefono .'<br>
    Telefono:'.$direccion.' <br>';
  }
    $variable_html.='

   
    </h4>
    <h4 class="cabecera"> ~~Gracias por su compra~~</h4> <br>';

    if($_REQUEST["cufe"] !== NULL)
    {
        $variable_html .= '<div class="cabecera" style="border-top: 1px solid #ccc; margin-top: 20px; padding-top: 10px;">
        <h4 class="cabecera">Factura Electrónica validada por la DIAN</h4>
        <p class="cabecera"><strong>CUFE:</strong>'.$_REQUEST["cufe"].'</p>
        
        <p class="cabecera">
            Puede verificar esta factura escaneando el código QR:
        </p>
        
        <p class="cabecera">
            
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($_REQUEST["qr"]) . '" alt="QR de verificación">
        </p>';
    }
    

  '</body>
</html>';

// =======================================================
// PASO 1: Calcular la altura del contenido
// =======================================================
$calculador = new \Mpdf\Mpdf([
    'format' => [79.375, 10000], // Ancho fijo, altura GIGANTE para que quepa todo
    'margin_left' => 5, 'margin_right' => 5,
    'margin_top' => 7, 'margin_bottom' => 0,
    'margin_header' => 0, 'margin_footer' => 0
]);
$calculador->WriteHTML($variable_html);
$alturaCalculada = $calculador->y; // Obtenemos la altura real del contenido
unset($calculador); // Liberamos memoria


// =======================================================
// PASO 2: Generar el PDF final con la altura exacta
// =======================================================
$alturaFinal = $alturaCalculada + 25; // Añadimos un pequeño margen de 5mm por seguridad

$mpdf = new \Mpdf\Mpdf([
    'format' => [79.375, $alturaFinal], // Ancho fijo, altura CALCULADA
    'margin_left' => 5, 'margin_right' => 5,
    'margin_top' => 7, 'margin_bottom' => 0,
    'margin_header' => 0, 'margin_footer' => 0
]);

$mpdf->SetAutoPageBreak(false); // Desactivamos el salto de página, ya que la página tiene el tamaño perfecto
$variable_html_utf8 = mb_convert_encoding($variable_html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($variable_html_utf8);

$mpdf->SetDisplayMode('fullpage');
$mpdf->Output('factura.pdf', 'I');