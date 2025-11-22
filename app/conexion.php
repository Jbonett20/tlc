<?php 

	$link=0;
	$db_host="localhost";
	$db_user="u288390626_lubricantes";
	$db_contrasena="JaMbs-3013851992%";
	$db= "u288390626_lubricantes"; //"ferroami_bd_turing";
	$link = mysqli_connect($db_host,$db_user,$db_contrasena,$db);

if (!$link)
	{
	  echo "Error conectando a la base de datos.";
	}
	
	if (!mysqli_select_db($link, $db))
	{
	  echo "Error seleccionando la base de datos. ";
	}
 