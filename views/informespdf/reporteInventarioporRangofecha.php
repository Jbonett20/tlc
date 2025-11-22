<?php 
  //require_once('pdf/scr/mpdf.php');
  require_once __DIR__ . '/pdf/vendor/autoload.php';  
  require_once '../../app/conexion.php';
  use Mpdf\Mpdf;


   extract($_REQUEST);
  
   $sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
    $filaempresa = mysqli_fetch_array($sql_empresa);
    $titulo='<div class="titulo">
              <h1 class="t_principal">'.$filaempresa['nombre_empresa'].'</h1>
               <h4 class="t_secundario">Nit: '.$filaempresa['nit_empresa'].'</h4>
              </div>';
$variable_html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte</title>
      <link rel="icon" type="image/png" href="img/icono.ico" />
     <link rel="stylesheet" href="../../css/jar/pdf_style.css" media="all" />
  </head>
  <body>
  <div style="">
  </div>
  ';



    $sqlinventariogeneral =  mysqli_query($link,"SELECT p.nombre,p.codigo_producto,c.nombre_categoria,i.stock FROM tbl_producto p,tbl_categoria c, tbl_inventario i WHERE i.id_producto=p.id_producto and p.id_categoria=c.id_categoria");

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
                        <th>Nombre</th>
                        <th>Codigo de Producto</th>
                        <th>Nombre Categoria</th>
                        <th>Stock</th>
                    </tr>
                  </thead>    
                  <tbody>
                  
                     
                  ';

              
      
        while ($respuesta = mysqli_fetch_array($sqlinventariogeneral))
        { 
          
                $variable_html.='   
                  <tr>
                      <td> '.$respuesta['nombre'].'</td>
                      <td>'.$respuesta['codigo_producto'].'</td>
                      <td>'.$respuesta['nombre_categoria'].'</td>
                      <td>'.$respuesta['stock'].'</td>

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

