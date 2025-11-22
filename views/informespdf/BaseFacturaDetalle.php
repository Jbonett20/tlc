<?php
//require_once('pdf/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once '../../app/scr/conexion.php';
use Mpdf\Mpdf;
extract($_REQUEST);
$sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);
$telefono = $filaempresa['telefono'];
$direccion = $filaempresa['direccion'];
ini_set('date.timezone','America/Bogota');
    $hoy =date("d-m-Y h:i:s",time());

    
$sqlinventariogeneral =  mysqli_query($link,"SELECT fac.fecha_factura,iva.iva,def.total_pago,def.descuento FROM tbl_producto pro, tbl_factura fac, tbl_detallefactura def, tbl_iva iva WHERE def.id_factura=fac.id_factura AND def.id_producto=pro.id_producto AND pro.id_iva=iva.id_iva  and fac.id_vendedor!=4 and  fac.fecha_factura >= '$inicio' and  fac.fecha_factura <= '$final' ORDER BY fac.fecha_factura ASC");
$sqlfechas =  mysqli_query($link,"SELECT DISTINCT fac.fecha_factura FROM tbl_producto pro, tbl_factura fac, tbl_detallefactura def, tbl_iva iva WHERE def.id_factura=fac.id_factura AND def.id_producto=pro.id_producto AND pro.id_iva=iva.id_iva  and fac.id_vendedor!=4 and  fecha_factura BETWEEN '$inicio' and '$final' ORDER BY fac.fecha_factura ASC");
$sqliva =  mysqli_query($link,"SELECT iva FROM tbl_iva");


      if (mysqli_num_rows($sqlinventariogeneral) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
         // $respuestaTres = mysqli_fetch_array($sqlinventariogeneral);
         // $respuestaUno= mysqli_fetch_array($sqlfechas);
         // $respuestaDos = mysqli_fetch_array($sqliva);
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
   '.$filaempresa['nombre_empresa'].'<br>Nit: '.$filaempresa['nit_empresa'].'<br>
    Iva Regimen Comun <br>
     Rango de Fecha:'.$inicio.' entre '.$final.'<br> 
    listado de ventas por periodo<br>
    Fecha:'.$hoy.'
    </h4>
  <p>=============================</p>
  ';

  
  $array=array();
  $array2=array();
  $array3=array();
  $array4=array();
  $contador=0;
  $totalIva19=0;
  $totalIva19Desc=0;
  $totalIva5=0;
  $totalIva5Desc=0;
  $totalExento=0;
  $totalExentoDesc=0;
  $totalDescuento=0;
  $totalGravados=0;

while ($respuestadetalle = mysqli_fetch_assoc($sqlinventariogeneral))
        { 

$array[$contador]=$respuestadetalle['fecha_factura'];
$array2[$contador]=$respuestadetalle['iva'];
$array3[$contador]=$respuestadetalle['total_pago'];
$array4[$contador]=$respuestadetalle['descuento'];
$contador++;
        }
        $longuitud=count($array);
 
   while ($respuestadetalleDos = mysqli_fetch_assoc($sqlfechas))
        { 
        
  $exento=0;
  $exentoIva=0;
  $gravados=0;
  $iva19=0;
  $iva19V=0;
  $iva5=0;
  $iva5V=0;
  for ($i=0; $i <$longuitud ; $i++) { 
    
    if ($array[$i]==$respuestadetalleDos['fecha_factura']) {
    
      if ($array2[$i]==0) {
        $exento=$exento+$array3[$i];
         $exentoIva=$exentoIva+$array4[$i];
      }if ($array2[$i]==19) {
        $iva19=$iva19+$array3[$i];
         $iva19V=$iva19V+$array4[$i];
      }if ($array2[$i]==5) {
       $iva5=$iva5+$array3[$i];
       $iva5V=$iva5V+$array4[$i];
      }

    }
  }
//   while ($respuestadetalleDos = mysqli_fetch_assoc($sqlinventariogeneral))
//         { 

// if ($respuestadetalleDos['fecha_factura']==$respuestadetalle['fecha_factura']) {
 
  
        
//        if ($respuestadetalleDos['iva']==0) {
      
//          $exento=$exento+$respuestadetalleDos['total_pago'];
//        }if ($respuestadetalleDos['iva']==19) {
      
//          $iva19=$iva19+$respuestadetalleDos['total_pago'];
//        }if ($respuestadetalleDos['iva']==5) {
       
//          $iva5=$iva5+$respuestadetalleDos['total_pago'];
//        }
// }
    
//         }
          $val19=$iva19*0.19;
          $val5=$iva5*0.05;
          $totalIva=$val5 + $val19;
          $gravados=$iva19+$iva5;
          $totalVenta=$exento+$gravados;
          $totalVentaDes=$iva19V+$iva5V+$exentoIva;
          $totalIva19=$totalIva19+$iva19;
          $totalIva19Desc=$totalIva19Desc+$iva19V;
          $totalIva5=$totalIva5+$iva5;
          $totalIva5Desc=$totalIva5Desc+$iva5V;
          $totalExento=$totalExento+$exento;
          $totalExentoDesc=$totalExentoDesc+$exentoIva;
          $totalGravados=$totalGravados+$gravados;
          $totalTotal=$totalExento+$totalGravados;

          // fecha :<h3>'.$respuestadetalle['fecha_factura'].'</h3>

          $variable_html .= '  <p>=============================</p>
    <table>
        <tr>
          <th>Produc.</th>
          <th style="width:20px;">Cant</th>
          <th>V. Uni</th>
          <th>V. Tot</th>
        
        </tr>
         <tr>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              </tr>
  ';
  $fechaTemp=$respuestadetalleDos['fecha_factura'];
    $sql_detallefactura =  mysqli_query($link,"SELECT  f.id_factura,f.codigo_factura,f.fecha_factura,f.hora,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.cantidadFraccion,df.total_pago,p.valor_venta,iv.* FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat,tbl_iva iv WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and p.id_categoria=cat.id_categoria and iv.id_iva=p.id_iva and f.fecha_factura='$fechaTemp'");

    $totalvalor=0;
      $ivaV=0;
        while ($respuestadetalleDD = mysqli_fetch_assoc($sql_detallefactura))
        { 
          
          $totalvalor=$totalvalor+$respuestadetalleDD['total_pago'];
          $ivaVV=$respuestadetalleDD['total_pago']*$respuestadetalleDD['iva']/100;
          $ivaV=$ivaV+$ivaVV;
              

    $variable_html .= '                 
        <tr class="productos">
          <td><strong>'.$respuestadetalleDD['descripcion'].' '.$respuestadetalleDD['presentacion'].'</strong></td>
          <td class="tmedia" style="width:20px;"><strong>'.$respuestadetalleDD['cantidad'].':'.$respuestadetalleDD['cantidadFraccion'].'</strong></td>
         
          <td><strong>$'.number_format($respuestadetalleDD['valor_venta']).'</strong></td>
          <td><strong>$'.number_format($respuestadetalleDD['total_pago']).'</strong></td>
        </tr>';
      }
      $subtotal=$totalvalor - $ivaV;
      $variable_html .= '
    </table>';
           $variable_html .= '  
          <h4>fecha :'.$respuestadetalleDos['fecha_factura'].'</h4>
           <table>
              <tr>
                <th>Iva</th>
                <th>Valor</th>
                <th>Desc</th>
                <th>Val Iva</th>
              </tr>
               <tr>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              </tr>
              <tr>
                <th>0%</th>
                <th class="tmedia">$'.number_format($exento).'</th>
                <th class="tmedia">$'.number_format($exentoIva).'</th>
                <th class="tmedia">$0</th>    
              </tr>
              <tr>
                <th>19%</th>
                <th class="tmedia">$'.number_format($iva19).'</th>
                <th class="tmedia">$'.number_format($iva19V).'</th>
                <th class="tmedia">$'.number_format($val19).'</th>
              </tr>
              <tr>
                <th>5%</th>
                <th class="tmedia">$'.number_format($iva5).'</th>
                <th class="tmedia">$'.number_format($totalIva5Desc).'</th>
                <th class="tmedia">$'.number_format($val5).'</th>
              </tr>
              <tr>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              </tr>
              <tr>
                <th class="tmedia">Total</th>
                <th class="tmedia">$'.number_format($totalVenta).'</th>
                <th class="tmedia">$'.number_format($totalVentaDes).'</th>
                <th class="tmedia">$'.number_format($totalIva).'</th>

              </tr>
             
          </table>
          <p>=============================</p>
            
             <h2 class="cabecera">Neto $
             '.number_format($totalVenta -$totalVentaDes ).'</h2>

           
           <p>=============================</p>
        ';

  
       }

    
    $val19T=$totalIva19*0.19;
    $val5T=$totalIva5*0.05;
    $totalIvaTo= $val19T+$val5T;
    $totalDescuentoFull=$totalExentoDesc+$totalIva19Desc+$totalIva5;
    $variable_html .= '  
              <h2 align="center">Datos Globales</h2>
           <p>=============================</p>
           <table>

              <tr>
             
                <th> <strong>Iva</strong></th>
                <th> <strong>Valor</strong></th>
                <th> <strong>Desc</strong></th>
                <th> <strong>Val Iva</strong></th>

              </tr>
                <tr>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              </tr>
              <tr>
                <th>0%</th>
                <th class="tmedia">$'.number_format($totalExento).'</th>
                <th class="tmedia">$'.number_format($totalExentoDesc).'</th>
                <th class="tmedia">$0</th>    
              </tr>
              <tr>
                <th>19%</th>
                <th class="tmedia">$'.number_format($totalIva19).'</th>
                <th class="tmedia">$'.number_format($totalIva19Desc).'</th>
                <th class="tmedia">$'.number_format($val19T).'</th>
              </tr>
              <tr>
                <th>5%</th>
                <th class="tmedia">$'.number_format($totalIva5).'</th>
                <th class="tmedia">$'.number_format($totalIva5).'</th>
                <th class="tmedia">$'.number_format($val5T).'</th>
              </tr>
                <tr>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              <th>_______</th>
              </tr>
              <tr>
                <th>Total</th>
                <th class="tmedia">$'.number_format($totalTotal).'</th>
                <th class="tmedia">$'.number_format($totalDescuentoFull).'</th>
                <th class="tmedia">$'.number_format($totalIvaTo).'</th>

              </tr>

          </table>
           <p>=============================</p>
            
             <h2 class="cabecera">Neto $
             '.number_format($totalTotal -$totalDescuentoFull ).'</h2>
          
           <p>=============================</p>
 
  </body>
</html>';
}
//$mpdf=new mPDF('c','jar','','' , 5, 5, 7 , 0, 0 , 0); //clase desconocida
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
