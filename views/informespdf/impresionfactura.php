<?php
//require_once('pdf/scr/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
require_once'../../app/conexion.php';
use Mpdf\Mpdf;
extract($_REQUEST);

$sql_empresa = mysqli_query($link,"SELECT * FROM tbl_empresa");
$filaempresa = mysqli_fetch_array($sql_empresa);
$titulo='<div class="titulo">
  
</div>

'
;
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
    <h5 class="cabecera">Drogas Alex<br>Nit: '.$filaempresa['nit_empresa'].'<br> Telefono: '.$filaempresa['telefono'].' <br> Direccion:'.$filaempresa['direccion'].'</h5>
    
    ';
    $sqlinventariogeneral =  mysqli_query($link,"SELECT p.descripcion,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.nombre,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.total_pago,p.valor_venta FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and p.id_categoria=cat.id_categoria and df.id_factura='$factura'");
    if (mysqli_num_rows($sqlinventariogeneral) == 0)
    {
    $variable_html.='No se encontraron resultados';
    }
    else
    {
    $respuesta = mysqli_fetch_array($sqlinventariogeneral);
    $variable_html.='
    <table  class="cabecera" border="1">
      <tr>
        <td colspan="4" rowspan="" headers=""> <p>Regimen Simplificado</p>  <p>Factura de Venta</p> <br><h3 >N° '.$respuesta['codigo_factura'].'</h3></td>
      </tr>
    </table>
    
    <table  class="cabeceraDOs sep" border="1" id="textodelado">
      <tr>
        
        <th id="textodelado">Fecha :'.$respuesta['fecha_factura'].'</th>
      </tr>
      <tr >
        <th id="textodelado">Cc : '.$respuesta['cc_cliente'].'</th>
      </tr>
      <tr>
        <th id="textodelado">Nombre : '.$respuesta['nombre_cliente'].'</th>
      </tr>
      
    </thead>
    <tbody>
      ';
      
      $variable_html.='
    </tbody>
  </table>';
  $variable_html.='
  <table  class="cabecera sep" border="1">
    
    <thead>
      <tr>
        <th colspan="9" rowspan="" headers="" scope="">Datos Producto</th>
      </tr>
      <tr>
        <th>Serial / Marca</th>
        <th>Producto</th>
        <th>Descripcion</th>
        
        <th>Cantidad</th>
        <th>Precio</th>
        <th>SubTotal</th>
        <th>% Descuento</th>
        <th>Descuento</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      
      ';
      $sql_detallefactura =  mysqli_query($link,"SELECT ps.serial, f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.nombre,p.codigo_producto,p.descripcion,p.marca,p.id_categoria,cat.nombre_categoria,df.cantidad,df.total_pago,p.valor_venta FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat, tbl_detallefacturaserial dfs,tbl_productoserial ps WHERE dfs.id_factura=f.id_factura and dfs.id_serial=ps.id_productoserial and f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and p.id_categoria=cat.id_categoria and df.id_factura='$factura'");
      
      $totalvalor=0;
      while ($respuestadetalle = mysqli_fetch_assoc($sql_detallefactura))
      {
      
      $totalvalor=$totalvalor+$respuestadetalle['total_pago'];
      $variable_html.='
      <tr>
        <td> '.$respuestadetalle['serial'].'/'.$respuestadetalle['marca'].'</td>
        <td>'.$respuestadetalle['nombre'].'</td>
        <td>'.$respuestadetalle['descripcion'].'</td>
        <td>'.$respuestadetalle['cantidad'].'</td>
        <td>'.$respuestadetalle['valor_venta'].'</td>
        <td>'.$respuestadetalle['valor_venta'] * $respuestadetalle['cantidad'].'</td>
        <td>%0</td>
        <td>0</td>
        <td>'.$respuestadetalle['valor_venta']*$respuestadetalle['cantidad'].'</td>
      </tr>
      ';
      
      }
      setlocale(LC_MONETARY,"es_ES");
      $variable_html.='
    </tbody>
  </table><table  class="cabeza">
  <tr>
    <th></th>
  </tr>
</table>
<table class="cabecera sep" border="1">
  <tbody>
    <tr >
      
      <th colspan="7">Total a pagar : </th>
      <th> $'.$totalvalor.'</th>
    </tr>
  </tbody>
</table>';
}
$variable_html.='
<p align="center">  ¡Gracias por preferirnos! </p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa adipisci nisi dolores laborum illum velit amet. Aperiam, ea! Quas ab aliquam voluptate, modi similique repudiandae ullam illum reprehenderit nemo ex?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati ut impedit molestias, cum laudantium placeat quaerat, at aliquid quasi pariatur. Nam nisi nihil molestias praesentium sint sequi animi voluptatum, ab.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque harum voluptatibus molestiae voluptates distinctio officiis tempora voluptatum, accusantium suscipit repellat porro explicabo ea nulla maxime saepe blanditiis temporibus ducimus sed.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis enim cupiditate facere, tempora obcaecati beatae modi a perferendis fuga numquam est perspiciatis, magnam deleniti ex magni molestias atque iste illo?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta repudiandae, culpa obcaecati, hic doloribus facilis. Debitis aspernatur est, fuga dolores, obcaecati adipisci, odit voluptate enim aliquid voluptates id maxime doloribus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt enim tempora, explicabo magni iure consequuntur minima pariatur dolores ex ab suscipit quo assumenda ratione. Optio, libero beatae deleniti minus repellendus? <span> lorem Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia nesciunt tempora ipsam, iure, iusto ea consequatur, unde nobis similique beatae qui? Laboriosam aliquid repellendus saepe voluptatibus autem reiciendis perspiciatis provident!</span> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis, fugit excepturi. Facilis fugiat, error repellat nisi rem eaque temporibus, atque molestias architecto commodi, nulla. Veritatis a quis explicabo possimus voluptatum.</span>
<span>Doloremque eaque possimus illo excepturi nesciunt provident, quisquam ipsum, explicabo ad expedita ipsa qui veritatis veniam odio minus quis ullam nemo autem ut odit suscipit temporibus. Quibusdam, dolorem. Autem, eaque.</span>
<span>Error perferendis deserunt sed ad autem, tenetur ex reprehenderit, aspernatur nostrum repellat eos, libero, incidunt. Reprehenderit laudantium quae dolores eos porro. Ex voluptatibus soluta vel sequi ad enim similique ipsam!</span>
<span>Ratione fugit beatae ea omnis et dolores blanditiis impedit iure quam perferendis, doloribus ipsa est architecto, laborum accusamus natus dignissimos, unde ducimus ullam laudantium asperiores culpa libero. Fuga, excepturi, facilis.</span>
<span>Incidunt laborum expedita animi eum blanditiis temporibus asperiores, sapiente totam similique? Itaque ullam dolore, voluptate optio nihil, voluptas aut praesentium repellendus numquam dolorem omnis iure reiciendis, inventore consequatur ipsum molestias!</span>
<span>Maxime facilis, dolor, voluptatibus ducimus necessitatibus quisquam, harum cum id architecto voluptatem perspiciatis ut ad esse eos adipisci. Magnam culpa sunt laboriosam maxime impedit numquam sit voluptate non consequuntur! Deleniti.</span>
<span>Harum autem, officiis, earum esse, in excepturi quidem minus pariatur repellendus labore perspiciatis. Temporibus, maiores, eum. Aperiam unde quidem alias aspernatur, sed repellat cumque repudiandae praesentium quae. Officiis, porro, unde?</span>
<span>At beatae consectetur aperiam blanditiis, asperiores officiis est, dolore vel ut velit corporis aspernatur debitis expedita reprehenderit soluta nihil delectus quas minima repudiandae perspiciatis sunt fugiat ea. Placeat, commodi, sapiente?</span>
<span>Sapiente deleniti ea aliquid quaerat incidunt doloribus, similique consequuntur sed, neque totam mollitia recusandae facilis, voluptatum magnam animi voluptate quam quo. Repellendus quidem obcaecati corporis culpa hic rem veritatis doloremque.</span>
<span>Pariatur, quasi voluptates dolorum aperiam ex deserunt distinctio a deleniti blanditiis vel nostrum sequi dolores maxime, optio vero adipisci unde corporis tempore, labore esse. Sapiente fugit porro deleniti quisquam aliquid?</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia repellat, soluta ipsam doloribus eligendi tenetur animi est quibusdam magnam consequatur unde labore tempore corporis delectus dolor beatae consequuntur? Et, odio?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia nulla, saepe sed debitis rerum enim odit minus fuga laudantium, blanditiis nesciunt non magni quae alias dolorem. Deserunt in nesciunt accusantium.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum neque deserunt alias eos provident, odit perferendis unde consectetur. Vitae fugiat, ad ducimus facere odit libero reiciendis nostrum provident asperiores aspernatur.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis ipsa inventore, voluptatibus quas dolor labore mollitia, architecto, illum fugiat a nesciunt tempore, sint debitis ea voluptates obcaecati ad earum aperiam!
<span>Commodi a saepe debitis, voluptatum velit ut tenetur. Natus magnam saepe ipsam voluptas! Quasi nam dolor ipsam architecto laudantium similique et, aspernatur, maxime sed quidem dignissimos consectetur, illo doloribus libero.</span>
<span>Fugit sapiente adipisci sequi, consequuntur cum eligendi expedita. Eaque voluptatum saepe aut sunt impedit aspernatur autem nam placeat vitae voluptate consequuntur, fuga doloremque numquam ut error aliquid eius laudantium delectus?</span>
<span>Velit eum laboriosam fugit dicta non corporis tempore, aperiam illum molestias praesentium expedita, corrupti iusto, cumque rerum sapiente deleniti id consequuntur? Voluptas facilis pariatur rem beatae, ut ad, adipisci consectetur!</span>
<span>Alias suscipit debitis corrupti ipsam aliquid non ex nobis mollitia earum! Maiores natus eos eveniet facilis similique, aperiam repudiandae nesciunt ipsum, sunt delectus dolores repellat dolorum, atque quo maxime beatae.</span>
<span>Voluptatibus aspernatur temporibus corrupti, atque ad! Asperiores assumenda voluptatem suscipit dolores dignissimos dolorum eveniet eaque amet, fugit aliquid, maxime sapiente perferendis earum molestias minus quam tenetur repellat repellendus. Debitis, fuga!</span>
<span>Vel, eveniet dolorem excepturi incidunt! Soluta, quisquam voluptate pariatur odio quidem totam quasi cum qui maiores dolorem assumenda vero vitae cumque doloremque, aliquam ipsam numquam hic, earum ipsum tenetur dolorum.</span>
<span>Nihil obcaecati eius fugiat quam voluptatibus nostrum eos omnis, beatae exercitationem aliquid, modi iure facere, eum velit voluptas eaque dolorum aperiam suscipit, minus praesentium perferendis pariatur nulla ex. Cupiditate, omnis.</span>
<span>Reiciendis maxime dicta impedit rem eius assumenda atque, architecto suscipit, exercitationem at. Quod quae nemo voluptate, voluptas nulla earum illum laboriosam aliquam odio accusantium nobis soluta dolor esse vero, hic?</span>
<span>Repellendus, harum deserunt laborum error officia ab magnam maxime, dolore quisquam temporibus perspiciatis ducimus dignissimos sequi at numquam unde dicta provident vel possimus tenetur nobis hic? Perferendis eum, perspiciatis incidunt.</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates vitae non quia debitis sint aliquid soluta, cupiditate vel esse provident, suscipit, modi aspernatur quos eaque. Sequi omnis autem aliquam, quis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex debitis possimus iste qui reprehenderit eos quisquam officia nobis cumque perferendis! Voluptates distinctio culpa fugit natus non soluta, blanditiis neque aliquid?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit nihil pariatur vero quam, cumque laborum illum quaerat, asperiores atque veritatis nostrum earum distinctio deleniti fugiat dicta temporibus omnis! Vitae, repudiandae.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi minima laudantium officia commodi, vitae ratione! Eligendi dignissimos tenetur cupiditate non illum voluptatem ipsa, ullam quibusdam optio nisi quis eaque necessitatibus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum voluptate in rem, laboriosam. Libero consequatur quam quas tenetur suscipit, aliquam placeat. Necessitatibus quas beatae, cum nesciunt delectus sunt commodi iure!</p>
</body>
<script type="text/javascript">
if (document.body)
{
var ancho = (document.body.clientWidth);
var alto = (document.body.clientHeight);
}
else
{
var ancho = (window.innerWidth);
var alto = (window.innerHeight);
}
document.write("El tamaño de la ventana actual: " + ancho + " de ancho "+alto+" de alto");
</script>
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
$mpdf->WriteHTML($variable_html);
$mpdf->Output();
?>
