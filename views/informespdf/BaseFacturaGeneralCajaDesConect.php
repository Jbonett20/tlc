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

    
$sqlinventariogeneral =  mysqli_query($link,"SELECT fac.fecha_factura,iva.iva,def.total_pago FROM tbl_producto pro, tbl_factura fac, tbl_detallefactura def, tbl_iva iva WHERE def.id_factura=fac.id_factura AND def.id_producto=pro.id_producto AND pro.id_iva=iva.id_iva  and fac.id_vendedor='$caja' and  fecha_factura BETWEEN '$inicio' and '$final' ORDER BY fac.fecha_factura ASC");
$sqlfechas =  mysqli_query($link,"SELECT DISTINCT fac.fecha_factura FROM tbl_producto pro, tbl_factura fac, tbl_detallefactura def, tbl_iva iva WHERE def.id_factura=fac.id_factura AND def.id_producto=pro.id_producto AND pro.id_iva=iva.id_iva  and   fecha_factura BETWEEN '$inicio' and '$final' ORDER BY fac.fecha_factura ASC");
$sqliva =  mysqli_query($link,"SELECT iva FROM tbl_iva");
$sqlCaja =  mysqli_query($link,"SELECT * FROM tbl_usuario_sistema WHERE id_usuariosistema='$caja'");

$cajaD=mysqli_fetch_assoc($sqlCaja);


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
     Caja :'.$cajaD['nombre_usuario'].' <br>
     Rango de Fecha:'.$inicio.' entre '.$final.'<br> 
    listado de ventas por periodo<br>
    Fecha:'.$hoy.'
    </h4>
  <p>=============================</p>
  ';
  
  $array=array();
  $array2=array();
  $array3=array();
  $contador=0;
  $totalIva19=0;
  $totalIva5=0;
  $totalExento=0;
  $totalGravados=0;

while ($respuestadetalle = mysqli_fetch_assoc($sqlinventariogeneral))
        { 

$array[$contador]=$respuestadetalle['fecha_factura'];
$array2[$contador]=$respuestadetalle['iva'];
$array3[$contador]=$respuestadetalle['total_pago'];
$contador++;
        }
        $longuitud=count($array);
 
   while ($respuestadetalleDos = mysqli_fetch_assoc($sqlfechas))
        { 
        
  $exento=0;
  $gravados=0;
  $iva19=0;
  $iva5=0;
  for ($i=0; $i <$longuitud ; $i++) { 
    
    if ($array[$i]==$respuestadetalleDos['fecha_factura']) {
    
      if ($array2[$i]==0) {
        $exento=$exento+$array3[$i];
      }if ($array2[$i]==19) {
        $iva19=$iva19+$array3[$i];
      }if ($array2[$i]==5) {
       $iva5=$iva5+$array3[$i];
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
          $totalIva19=$totalIva19+$iva19;
          $totalIva5=$totalIva5+$iva5;
          $totalExento=$totalExento+$exento;
          $totalGravados=$totalGravados+$gravados;
          $totalTotal=$totalExento+$totalGravados;
          // fecha :<h3>'.$respuestadetalle['fecha_factura'].'</h3>
           $variable_html .= '  
          <h4>fecha :'.$respuestadetalleDos['fecha_factura'].'</h4>
          <table>
              <tr>
                <th>Iva</th>
                <th>Valor</th>
                <th>Valor Iva</th>
              </tr>
              <tr>
                <th>Exento</th>
                <th>'.number_format($exento).'</th>
                <th>0</th>    
              </tr>
              <tr>
                <th>19%</th>
                <th>'.number_format($iva19).'</th>
                <th>'.number_format($val19).'</th>
              </tr>
              <tr>
                <th>5%</th>
                <th>'.number_format($iva5).'</th>
                <th>'.$val5.'</th>
              </tr>
              <tr>
                <th>Total</th>
                <th>'.number_format($totalVenta).'</th>
                <th>'.number_format($totalIva).'</th>

              </tr>
          </table>

           
           <p>=============================</p>
        ';

  
       }

    
    $val19T=$totalIva19*0.19;
    $val5T=$totalIva5*0.05;
    $totalIvaTo= $val19T+$val5T;
    $variable_html .= '  
          
           <p>=============================</p>
           <table>
              <tr>
                <th>Iva</th>
                <th>Valor</th>
                <th>Valor Iva</th>
              </tr>
              <tr>
                <th>Exento</th>
                <th>'.number_format($totalExento).'</th>
                <th>0</th>    
              </tr>
              <tr>
                <th>19%</th>
                <th>'.number_format($totalIva19).'</th>
                <th>'.number_format($val19T).'</th>
              </tr>
              <tr>
                <th>5%</th>
                <th>'.number_format($totalIva5).'</th>
                <th>'.number_format($val5T).'</th>
              </tr>
              <tr>
                <th>Total</th>
                <th>'.number_format($totalTotal).'</th>
                <th>'.number_format($totalIvaTo).'</th>

              </tr>
          </table>
          
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