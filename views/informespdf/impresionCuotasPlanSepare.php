<?php 
  //require_once('pdf/scr/mpdf.php');
  require_once __DIR__ . '/pdf/vendor/autoload.php';
  require_once'../../app/conexion.php';
  use Mpdf\Mpdf;

   extract($_REQUEST);
  
   $sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
    $filaempresa = mysqli_fetch_array($sql_empresa);
    $titulo='<div class="titulo">
              <h2 class="t_principal">'.$filaempresa['nombre_empresa'].'</h2>
               
              </div>';
$variable_html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte</title>
     <link rel="stylesheet" href="../../css/jar/pdf_style.css" media="all" />
  </head>
  <body>
  <h5 class="t_secundario">Nit: '.$filaempresa['nit_empresa'].'</h5>
  ';



    $sqlplansepare =  mysqli_query($link,"SELECT dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$plansepare' GROUP BY dpl.id_producto");



     $variable_html.='           
         <table>
          <caption  class="cliente">Datos Cliente</caption>
            <thead>
            <tr>
                <th colspan="4">==================================</th>
            </tr> 
              <tr>
                <th>CC</th>
                <th>Nombre</th>
                <th> Total a pagar </th>
              
              </tr>
            </thead>    
            <tbody>   
            ';

              
        $respuestaA = mysqli_fetch_array($sqlplansepare);
      
   
  
        $variable_html.='   
          <tr>
              <td>'.$respuestaA['cc_cliente'].'</td>
              <td>'.$respuestaA['nombre_cliente'].'</td>
              <td>'.$respuestaA['total_pagosepare'].'</td>
             
          </tr>
           </tbody>  
             </table>




              <table>
                <caption class="cliente">Datos Deuda</caption>
                <thead>
                <tr>
                <th colspan="5">=====================================</th>
                
                </tr> 
                  <tr>
                    
                    <th> Deuda </th>
                    <th>Total aumento </th>
                    <th>Fecha inicio </th>
                    <th>Fecha fin </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  
                    <td>'.$respuestaA['descuento_abonos'].'</td>
                    <td>'.$respuestaA['valor_aumetoplansepare'].'</td>
                    <td>'.$respuestaA['fecha_inicio'].'</td>
                    <td>'.$respuestaA['fecha_fin'].'</td>
                  </tr>
                </tbody>
              </table>';


    $sqlplanseparedetalle =  mysqli_query($link,"SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$plansepare' GROUP BY dpl.id_producto");

        $variable_html.='           
          <table>
           <caption class="cliente">Datos Producto</caption>
            <thead>
               <tr>
                <th colspan="5">========================================</th>
                </tr> 
              <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Categoria </th>
                <th>Valor venta </th>
                <th>Cantidad </th>
                <!--<th>valor actual producto </th>-->
                
              </tr>
            </thead>    
            <tbody>    
            ';

              
      
        
        while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
        {
  
          $variable_html.='   
            <tr>
                <td>'.$respuesta_detalla['codigo_producto'].'</td>
                <td>'.$respuesta_detalla['nombre'].'</td>
                <td>'.$respuesta_detalla['nombre_categoria'].'</td>
                <td>'.$respuesta_detalla['valor_venta'].'</td>
                <td>'.$respuesta_detalla['cantidad'].'</td>
               <!-- <td>'.$respuesta_detalla['valor_actual_producto'].'</td>-->
            </tr>
            ';


            
        }

         $variable_html.='     
         </tbody>  
               </table>';



         $variable_html.='           
             <table>
              <caption class="cliente"> Datos Abonos</caption>
                <thead>
                 <tr>
                <th colspan="5">=====================================</th>
                
                </tr> 
                  <tr>
                    <th>Valor</th>
                    <th>Fecha</th>
                  </tr>
                </thead>    
                <tbody>';

         $sql_listadoCuotasPlanSepare =  mysqli_query($link,"SELECT abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,cl.cc_cliente,cl.nombre_cliente FROM tbl_plansepare pla, tbl_cliente cl, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and  pla.id_plansepare='$plansepare' ORDER BY id_abonos_plansepare DESC limit 1 ");
        $totalSuma = 0;
        while ($respuestadetalleCuotas = mysqli_fetch_assoc($sql_listadoCuotasPlanSepare))
        { 
          
                $variable_html.='   
                  <tr>
                      <td> '.$respuestadetalleCuotas['valor_abono'].'</td>
                      <td>'.$respuestadetalleCuotas['fecha_abono'].'</td>
                  </tr>';

              $totalSuma = $totalSuma + $respuestadetalleCuotas['valor_abono'];

        
        }
               $variable_html.='
               <tr>
                <td colspan="2">
                  '.$totalSuma.'
                </td>
               </tr>
               </tbody>  
               </table>';

      
    
    
    
    $variable_html.='
    
  </body>
</html>';

  

//$mpdf=new mPDF('c','A7','','' , 5, 5, 10 , 0, 0 , 0); o
$mpdf = new Mpdf([
  'format' => [74, 105],           // Reemplaza 'jar' con un tamaño de papel válido (por ejemplo, 'A4', 'A5', etc.)
  'margin_left' => 5,
  'margin_right' => 5,
  'margin_top' => 10,
  'margin_bottom' => 0,
  'margin_header' => 0, 
  'margin_footer' => 0
]);
$mpdf->SetHTMLHeader($titulo);
$mpdf->SetHTMLFooter('
<!--<div width="100%"  align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</div>-->
');
$mpdf->WriteHTML($variable_html);
$mpdf->Output();
 $mpdf = new mPDF();