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

    $sqlinventariogeneral =  mysqli_query($link,"SELECT ifc.*,idf.*,p.* FROM tbl_ingresofactura ifc, tbl_ingresosdetallefactura idf, tbl_producto p WHERE ifc.id_ingresofactura=idf.id_ingresofactura and idf.id_producto=p.id_producto and ifc.id_ingresofactura='$factura'");

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
    factura :'.$respuesta['nombre_factura'].'<br>
    fecha :'.$respuesta['fecha'].'<br>
    
    </h4>    
  <p>=============================</p>
    <table>
        <tr>
          <th>Producto</th>
          <th>Cantidad Unidad</th>
          <th>Cantidad fraccion </th>
        
        </tr>';
        $sql_detallefactura =  mysqli_query($link,"SELECT ifc.*,idf.*,p.* FROM tbl_ingresofactura ifc, tbl_ingresosdetallefactura idf, tbl_producto p WHERE ifc.id_ingresofactura=idf.id_ingresofactura and idf.id_producto=p.id_producto and ifc.id_ingresofactura='$factura'");
      
     
        while ($respuestadetalle = mysqli_fetch_assoc($sql_detallefactura))
        { 

    $variable_html .= '                 
        <tr class="productos">
          <td><strong>'.$respuestadetalle['descripcion'].'</strong></td>
          <td><strong>'.$respuestadetalle['cantidadUnidad'].'</strong></td>
          <td><strong>'.$respuestadetalle['cantidadFraccion'].'</strong></td>
        
        </tr>';
      }
      $subtotal=$totalvalor - $ivaV;
      $variable_html .= '
    </table>
  <p>=============================</p>  
   
    <h4 class="cabecera">
    Direccion:<br>'.$telefono .'<br>
    Telefono: <br>'.$direccion.' <br>';
  }
    $variable_html.='

   == LISTADO DE LA FACTURA ==
    </h4>
    
  </body>
</html>';
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
$variable_html = mb_convert_encoding($variable_html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($variable_html);
$mpdf->Output();