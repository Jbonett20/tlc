<?php 
  //require_once('pdf/scr/mpdf.php');
  require_once __DIR__ . '/pdf/vendor/autoload.php';
  require_once '../../app/conexion.php';
  use Mpdf\Mpdf;

   extract($_REQUEST);
    $sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
    $filaempresa = mysqli_fetch_array($sql_empresa);
  
$titulo='<div class="titulo">
              <h4 class="cabecera"> '.$filaempresa['nombre_empresa'].'<br>
               Nit: '.$filaempresa['nit_empresa'].'<br>
              REPORTES GLOBALES DE REGISTROS DE INGRESOS POR FECHAS<br>
              Inicio:'.$fecha_inicio.' - Final: '.$fecha_fin.'</h4>';
              
$variable_html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte</title>
    <link rel="icon" type="image/png" href="img/icono.ico" />
    <link rel="stylesheet" href="estilo.css" media="all" />
  </head>
  <body>
 <p>REPORTES GLOBALES DE REGISTROS DE INGRESOS POR FECHAS</p>
  ';

  

    $sql_ingresosXfecha =  mysqli_query($link,"SELECT i.id_ingresos,i.cantidad,i.cantidadFraccion,i.fecha,p.id_producto,ca.nombre_categoria,p.presentacion,p.codigo_producto,p.descripcion,p.valor,p.valor_venta FROM tbl_ingresos i, tbl_producto p, tbl_categoria ca WHERE i.id_producto=p.id_producto and p.id_categoria=ca.id_categoria and i.fecha>='$fecha_inicio' and i.fecha<='$fecha_fin' order by i.fecha,p.id_producto asc");

       
      if (mysqli_num_rows($sql_ingresosXfecha) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
            $variable_html.='           
                  <table>
                 
                    <thead>
                      <tr>
                       <th> Categoria</th>
                       <th> C. Prod</th>
                        <th> Nombre</th>
                        <th> Cantidad</th>
                        <th> Fraccion</th>
                        <th> Fecha </th>
                      </tr>
                    </thead>
                     <tbody>
                  ';

             while ($respuesta = mysqli_fetch_assoc($sql_ingresosXfecha))
              {

                $total_pago = $total_pago + $respuesta['total_pago'];

                $variable_html.=' 
                <tr> <td>'.$respuesta['nombre_categoria'].'</td>
                <td>'.$respuesta['codigo_producto'].'</td>
                      <td>'.$respuesta['descripcion'].'</td>
                      <td> '.$respuesta['cantidad'].'</td>
                      <td> '.$respuesta['cantidadFraccion'].'</td>
                      <td>'.$respuesta['fecha'].'</td>
                 </tr> ';         
              
          }
      }
    $variable_html.='
    </tbody>    
    </table>
    
  </body>
</html>';

  // $mpdf= new mPDF('c','A4');
  // $mpdf->writeHTML($variable_html);
 //  $mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
 //  $mpdf->SetFooter('Document Title|Center Text|{PAGENO}');

 //  $mpdf->Output('reporte.pdf','I');

//$mpdf=new mPDF('c','A4','','' , 16, 16, 38 , 10, 10 , 10);
$mpdf = new Mpdf([
  'format' => [210, 297],           //averguar datos correcto para A4
  'margin_left' => 16,
  'margin_right' => 16,
  'margin_top' => 38,
  'margin_bottom' => 10,
  'margin_header' => 10, 
  'margin_footer' => 10
]);
$mpdf->SetHTMLHeader($titulo);
$mpdf->SetHTMLFooter('
<div width="100%"  align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</div>
');
$mpdf->WriteHTML($variable_html);
$mpdf->Output();
$mpdf = new mPDF();