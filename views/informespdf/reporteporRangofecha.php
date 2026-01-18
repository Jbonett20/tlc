<?php 
  //require_once('pdf/scr/mpdf.php');
  require_once __DIR__ . '/pdf/vendor/autoload.php';
  require_once '../../app/conexion.php';
  use Mpdf\Mpdf;
   extract($_REQUEST);
  
$variable_html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/icono.ico" />
    <title>Reporte</title>
    <link rel="stylesheet" href="estilo.css" media="all" />
  </head>
  <body>
  ';

    $sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
    $filaempresa = mysqli_fetch_array($sql_empresa);

    $titulo='
              <h4 class="cabecera"> '.$filaempresa['nombre_empresa'].'<br>
               Nit: '.$filaempresa['nit_empresa'].'<br>
               Reporte de Facturas por rango de Fechas</h4> ';
     

    $sqlalumnoXAuxilioTransporte =  mysqli_query($link,"SELECT f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente  and  f.fecha_factura>='$fecha_inicio'  and f.fecha_factura<='$fecha_fin'  order by fecha_factura ASC");

      if (mysqli_num_rows($sqlalumnoXAuxilioTransporte) == 0)
      {
        $variable_html.='No se encontraron resultados';
      }
      else
      {
        $totalingreso = 0;
        while ($respuesta = mysqli_fetch_array($sqlalumnoXAuxilioTransporte))
        { 
          $id_factura = $respuesta['id_factura'];
          $totalingreso = $totalingreso + $respuesta['valor_pago'];
         
          $variable_html.='           
              
                  <table>
                    <tbody>
                          <tr>
                            <th>N. Factura</th> 
                            <th> Fecha </th> 
                          </tr>

                          <tr>
                               <td>'.$respuesta['codigo_factura'].'</td>
                               <td> '.$respuesta['fecha_factura'].' </td>
                          </tr>


                    </tbody>
                  </table>';

                $variable_html.='           
                  
                  <table>
                    <thead>
                        <tr>
                          <th>Producto</th>
                          <th> Codigo</th>
                          <th> Cantidad </th>
                          <th>Total Pago</th>
                        </tr>
                    </thead>

                    <tbody>';
                

              $sql_listado_detalle_factura = mysqli_query($link,"SELECT f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.nombre,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.total_pago,p.valor_venta FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and p.id_categoria=cat.id_categoria and df.id_factura='$id_factura'");  

              $total_pago = 0;
              while ($respuesta = mysqli_fetch_assoc($sql_listado_detalle_factura))
              {

                $total_pago = $total_pago + $respuesta['total_pago'];

                    $variable_html.='
                        <tr>
                          <td> '.$respuesta['nombre'].'</td>
                          <td>'.$respuesta['codigo_producto'].'</td>
                          <td> '.$respuesta['cantidad'].'</td>
                          <td> '.$respuesta['total_pago'].'</td>
                        </tr>                
                  ';

              }

          $variable_html.='
           <tr>
                          <th class="total">Total</th> <td class="total"></td> <td class="total"></td> <td class="total"></td> <td class="total"> $' .$total_pago.'</td>
                        </tr>
                    </tbody>

                  </table>
              ';
        }

      }
      $variable_html.='
      <div>
         <div>
            <h3>Total Ingresos <span class="t_ingresos"> $'.$totalingreso.'</span></h3>
          </div>
      </div>';
    
    
    $variable_html.='
    
  </body>
</html>';

//$mpdf=new mPDF('c','Jar','','' , 16, 16, 38 , 10, 10 , 10);
$mpdf = new Mpdf([
  'format' => [210, 297],           //ojo la diferencia  jar - a4
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


