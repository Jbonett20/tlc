<?php 
  //require_once('pdf/scr/mpdf.php');
  require_once __DIR__ . '/pdf/vendor/autoload.php';
  require_once '../../app/conexion.php';
  use Mpdf\Mpdf;
   extract($_REQUEST);
    $sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
    $filaempresa = mysqli_fetch_array($sql_empresa);

  
$titulo='<h4 class="cabecera"> '.$filaempresa['nombre_empresa'].'<br>
               Nit: '.$filaempresa['nit_empresa'].'<br>
               Reporte de Inventario por Categoria</h4> ';

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
 <p>Inventario Por Categoria</p>
  ';
    $sqlinventariogeneral =  mysqli_query($link,"SELECT p.*,p.descripcion,p.codigo_producto,c.nombre_categoria,i.stock,i.Unidad FROM tbl_producto p,tbl_categoria c, tbl_inventario i WHERE i.id_producto=p.id_producto and p.id_categoria=c.id_categoria and p.id_categoria='$id_categoria'");

      if (mysqli_num_rows($sqlinventariogeneral) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
               $variable_html.='           
                  
                     <table>
                  <thead>
                    <tr>
                        
                        <th>Codigo de Producto</th>
                        <th>Descripcion</th>
                       
                        <th>Caja</th>
                        <th>Unidad</th>
                         
                    </tr>
                  </thead>    
                  <tbody>
                   ';

        while ($respuesta = mysqli_fetch_array($sqlinventariogeneral))
        { 
          
                $variable_html.='  
                    <tr>         
                    <td>'.$respuesta['codigo_producto'].'</td>
                      <td>'.$respuesta['descripcion'].'</td>';
                      if ($respuesta['fraccion']!=0) {
                       $variable_html.=' 

                     <td>'.$respuesta['Unidad'].'</td>
                     <td>'.$respuesta['stock'].'</td>';
                      }else if ($respuesta['fraccion']==0) {
                       $variable_html.=' 

                     <td></td>
                     <td>'.$respuesta['Unidad'].'</td>';
                      }
                        $variable_html.=' 
 
                    </tr>
                   ';
        }

      }

    $variable_html.='
      </tbody>
    </table>
  </body>
</html>';

//$mpdf=new mPDF('c','A4','','' , 16, 16, 38 , 10, 10 , 10);
ini_set('pcre.backtrack_limit', '2000000');
$mpdf = new Mpdf([
  'format' => [210, 297],           
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



