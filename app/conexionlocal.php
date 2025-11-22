<?php 

	$link=0;
	//include('config.php');
	//Conectar con la BD
	//if (!($link=mysqli_connect($Direccion_Servidor,$Nombre_Usuario_BD,"hiJygV4726")))
	if (!($link=mysqli_connect("localhost","root","")))
	{
	  echo "Error conectando a la base de datos.";
	}
	

	
	if (!mysqli_select_db($link,"bd_turing"))
	{
	  echo "Error seleccionando la base de datos. ";
	}
