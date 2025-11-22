<?php 

$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 2 days");
echo date("Y-m-d",$mod_date) . "\n";
