<?php
session_start();

$user = json_decode(file_get_contents('php://input'));

if (((isset($user->usuario) == "") or (isset($user->usuario) == null)) or ((isset($user->clave) == "") or (isset($user->clave) == null))) {
	echo "Datos Ingresados Incorrectos";
	// echo $user->usuario;
	// echo $user->clave;
} else {
	include '../app/conexion.php';

	echo "1";
	// error select
	$sql_miracles = mysqli_query($link, "SELECT * FROM tbl_usuario_sistema WHERE nombre_usuario='" . $user->usuario . "' and password='" . $user->clave . "'");
	$datos_Respuesta = mysqli_num_rows($sql_miracles);
	// error en el if
	if ($datos_Respuesta == 0) {
		echo "Datos Ingresados Incorrectos";
	} else {
		// definimos el fetch array detro de la variable $row 
		$row = mysqli_fetch_array($sql_miracles);

		// fecha actual buscaba desde la base de datos
		$fecha = mysqli_query($link, "select CURDATE()");
		$fil = mysqli_fetch_array($fecha);
		$fac = $fil['CURDATE()'];
		$fecha_actual = strtotime($fac);

		// comparamos si la fecha actual es mayor o igual a la fecha inicio
		$fechaini_sql = $row['fecha_inicial'];
		$fecha_inicial = strtotime($fechaini_sql);

		$fechafin_sql = $row['fecha_final'];
		$fecha_final = strtotime($fechafin_sql);

		// capturamos la variable estado que viene de base de datos
		$estado = $row['estado'];

		if (($fecha_actual >= $fecha_inicial) and ($fecha_actual <= $fecha_final)) {
			// echo  $estado."si cumple";
			if ($estado == '0') {
				/*variables de comparacion*/
				$nombre_usuario  =  $row['nombre_usuario'];
				$img  =  $row['img'];

				$_SESSION['nombre_usuario'] = $nombre_usuario;

				$id = $row['id_usuariosistema'];
				$_SESSION['id'] = $id;
				$tipoo = $row['tipo'];
				$_SESSION['tipo'] = $tipoo;
				$_SESSION['img'] = $img;

				$_SESSION['uid'] = uniqid('ang_');

				echo $_SESSION['uid'].'-'.$_SESSION['tipo'];
			} elseif ($estado == '1') {
				echo "Negado";
			} elseif ($estado == '2') {
				echo 'Desactivado';
			} else {
				echo "error estado";
			}
		} else {
			echo "no cumple";
		}
	}
 }
