<?php
//require_once('pdf/scr/mpdf.php');
require_once __DIR__ . '/pdf/vendor/autoload.php';
use Mpdf\Mpdf;
extract($_REQUEST);

$variable_htm='Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam ratione aliquam cum obcaecati voluptatibus nihil accusantium, quae nostrum non, quam deleniti, eius! Similique quo, nam ducimus tempora quaerat, asperiores adipisci.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis voluptate quas atque ab culpa amet consequuntur accusantium consequatur quod mollitia, optio qui quo dolorem placeat? Totam adipisci sunt reprehenderit eligendi.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium beatae, nostrum optio atque quisquam cum! Voluptates accusamus voluptatem nemo enim laudantium, reprehenderit, obcaecati fugiat cum delectus ex culpa dolor tempore!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, eum nam minus numquam quaerat quas possimus facere praesentium ut explicabo repellendus laboriosam perferendis eius architecto mollitia asperiores error est sunt.';

//$mpdf=new mPDF('c','a7','','' , 5, 5, 7 , 0, 0 , 0);
$mpdf = new Mpdf([
    'format' => [74, 105],           // Reemplaza 'jar' con un tamaño de papel válido (por ejemplo, 'A4', 'A5', etc.)
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 7,
    'margin_bottom' => 0,
    'margin_header' => 0, 
    'margin_footer' => 0
  ]);
$mpdf->WriteHTML($variable_htm);
$mpdf->Output();