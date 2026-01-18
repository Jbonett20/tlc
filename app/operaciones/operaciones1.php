<?php 
session_start();
include('../conexion.php');
extract($_REQUEST);
ini_set('date.timezone','America/Bogota'); 


if ($variable=='ingresos')
{
		if($operacion == "UpdateNombreFacturaSelect"  ){

			$datos = json_decode(file_get_contents("php://input"));
		
		$nombre = $datos->nombre;	
		$id = $datos->id;	
		$sql_actualizarFacturaNombre = mysqli_query ($link, "UPDATE tbl_ingresofactura SET nombre_factura ='$nombre' WHERE id_ingresofactura='$id'" );
			if (!$sql_actualizarFacturaNombre)
			{
				echo "fallo";
			}
			else{

				echo "exito";
				}


		} else if ($operacion == "fechaCaducidadDetalle") {
		$datos = json_decode(file_get_contents("php://input"));
		
		$lote = $datos->lote;	
		$referencia = $datos->referencia;	
		$cantidad = $datos->cantidad;	
		$fechaCaducidad = $datos->fechaCaducidad;	
		$id_fechacaducidad = $datos->id_fechacaducidad;	

$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_fechacaducidaddetalle VALUES (NULL, '$id_fechacaducidad','$lote','$referencia','$cantidad','$fechaCaducidad')" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else{
				// SELECT p.*, sum(fcd.cantidad) as Cantidad,fcd.fechaCaducidad from tbl_fechacaducidaddetalle fcd,tbl_fechacaducidad fc,tbl_producto p WHERE fcd.id_fechaCaducidad=fc.id_fechaCaducidad and p.id_producto=fc.id_producto and fcd.fechaCaducidad=fcd.fechaCaducidad
				$sql_busqueda = mysqli_query ($link, "SELECT * FROM tbl_fechacaducidaddetalle WHERE id_fechacaducidad='$id_fechacaducidad' order by fechaCaducidad ASC" );
				$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_busqueda))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
			}

		
	}

	else if ($operacion == 'listaRangoFactura') {
		
		$sql_busqueda = mysqli_query ($link, "SELECT * FROM tbl_rangofactura" );
				$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_busqueda))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
			
	}
	else if ($operacion == 'OperacionesRangoFactura') {
		$datos = json_decode(file_get_contents("php://input"));
		
		$rangoFacturaInicial = $datos->rangoFacturaInicial;	
		$rangoFacturaFinal = $datos->rangoFacturaFinal;
		$sql_busqueda = mysqli_query ($link, "SELECT * FROM tbl_rangofactura" );

		if (mysqli_num_rows($sql_busqueda)==0) {
			$sql_insert= mysqli_query ($link, "INSERT INTO tbl_rangofactura VALUES(null,'$rangoFacturaInicial','$rangoFacturaFinal')" );
			 if (!$sql_insert) {
			 	echo "NoInsertado";
			 }else{
			 	echo "Insertado";
			 }
		} else if (mysqli_num_rows($sql_busqueda)!=0) {
			$row=mysqli_fetch_array($sql_busqueda);

			$id=$row["id_rango"];

			$sql_update=mysqli_query ($link, "UPDATE tbl_rangofactura SET InicioFactura='$rangoFacturaInicial', FinalFactura='$rangoFacturaFinal' WHERE id_rango='$id'" );
			if (!$sql_update) {
				echo "NoActualizado";
			}else{
				echo "Actualizado";
			}
			
		} 
				

		
			
	}
 else if ($operacion == "fechaCaducidadDetalleLista") {
		

				// SELECT p.*, sum(fcd.cantidad) as Cantidad,fcd.fechaCaducidad from tbl_fechacaducidaddetalle fcd,tbl_fechacaducidad fc,tbl_producto p WHERE fcd.id_fechaCaducidad=fc.id_fechaCaducidad and p.id_producto=fc.id_producto and fcd.fechaCaducidad=fcd.fechaCaducidad
				$sql_busqueda = mysqli_query ($link, "SELECT p.*,fcd.* from tbl_fechacaducidaddetalle fcd,tbl_fechacaducidad fc,tbl_producto p WHERE fcd.id_fechaCaducidad=fc.id_fechaCaducidad and p.id_producto=fc.id_producto and fcd.fechaCaducidad=fcd.fechaCaducidad ORDER BY fcd.fechaCaducidad ASC" );
				$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_busqueda))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
			

		
	}

	else if($operacion == "fechaCaducidad"){

	$datos = json_decode(file_get_contents("php://input"));
		
		$id_producto = $datos->id_producto;	

		$sql_busqueda = mysqli_query ($link, "SELECT * FROM tbl_fechacaducidad WHERE id_producto='$id_producto' " );
		$respuesta = mysqli_num_rows($sql_busqueda);
		
		if ($respuesta >= 1)
		{
			$sql_busqueda = mysqli_query ($link, "SELECT * FROM tbl_fechacaducidad WHERE id_producto='$id_producto' " );
			while ($respuesta = mysqli_fetch_assoc($sql_busqueda))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);

		}else{
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_fechacaducidad VALUES (NULL, '$id_producto',current_date())" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else{
				$sql_busqueda = mysqli_query ($link, "SELECT * FROM tbl_fechacaducidad WHERE id_producto='$id_producto' " );
				$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_busqueda))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
			}
		}



	}
	if ($operacion == "insertadorIngresos") 
	{
		$datos = json_decode(file_get_contents("php://input"));
		if (!isset($datos->id_facturaD)) {
			$id_facturaD=0;
		}else{
		$id_facturaD = $datos->id_facturaD;	
		}
		
		$id_producto = $datos->id_producto;
		$cantidadUnidad = $datos->cantidadUnidad;
		$cantidadFraccion = $datos->cantidadFraccion;
		

		$sql_busquedaInventarios = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
		$sql_busquedaProducto = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE id_producto='$id_producto' " );
		$array=mysqli_fetch_array($sql_busquedaProducto);
		$respuesta = mysqli_num_rows($sql_busquedaInventarios);
		$rows = mysqli_fetch_array($sql_busquedaInventarios);
		if ($respuesta >= 1)
		{
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_ingresos VALUES (NULL, '$id_producto', '$cantidadUnidad','$cantidadFraccion', current_date(),'Ingreso')" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "guardo";}


				$fraccionProducto=$array['fraccion'];
				$id_inventario = $rows['id_inventario'];
				$unidad = $rows['Unidad'];
				$sumaUnidad=$unidad + $cantidadUnidad;
				if ($fraccionProducto==0) {

					$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_inventario SET  Unidad='$sumaUnidad' WHERE id_inventario='$id_inventario'" );
				if (!$sql_updateInventarios)
				{
					echo "fallo";
				}
				else
				{
					echo "guardo";

				}

					
				}else{

				if ($cantidadUnidad!=0) {
					
					$cantidad=$cantidadUnidad*$array['fraccion'];
					
				}else if($cantidadFraccion!=0){
					$cantidadF=$cantidadFraccion;
				}

				$id_inventario = $rows['id_inventario'];
				$unidad = $rows['Unidad'];
				$fraccion = $rows['stock'];
				$sumaFraccion=$fraccion + $cantidadFraccion;
				$sumaUnidad=$unidad + $cantidadUnidad;
				if ($sumaFraccion>=$fraccionProducto) {
					$NSumaFraccion=$sumaFraccion/$fraccionProducto;
					$sumaFraccion=$sumaFraccion%$fraccionProducto;
					
					$sumaUnidad=$sumaUnidad+floor($NSumaFraccion);


				}

				// $suma = $stock + $cantidad + $cantidadFraccion;

				$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$sumaFraccion', Unidad='$sumaUnidad' WHERE id_inventario='$id_inventario'" );
				if (!$sql_updateInventarios)
				{
					echo "fallo";
				}
				else
				{
					echo "guardo";

				}

			}
		}
	}
		else
		{
			echo "noseencontro";
			
		} 
		if ($id_facturaD !=0) {
			$sql_add = mysqli_query ($link, "UPDATE tbl_ingresofactura SET estado=1 WHERE id_ingresofactura='$id_facturaD' " );
		}
		
		
	}if ($operacion == "insertarIngresoFactura") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidadU = $datos->cantidadU;
		$cantidadF = $datos->cantidadF;
		$id_ingresoFac = $datos->id_ingresoFac;
		
$sql_verificar= mysqli_query ($link, "SELECT * FROM tbl_ingresosdetallefactura WHERE id_ingresofactura='$id_ingresoFac' and id_producto='$id_producto'" );
	$respuesta = mysqli_num_rows($sql_verificar);
	$resultad= mysqli_fetch_array($sql_verificar);
	$NewCantidadU=$resultad['cantidadUnidad']+$cantidadU;
	$NewCantidadF=$resultad['cantidadFraccion']+$cantidadF;
	if ($respuesta>=1) {
			
			$sql_insertingresos = mysqli_query ($link, "UPDATE  tbl_ingresosdetallefactura SET cantidadUnidad='$NewCantidadU', cantidadFraccion='$NewCantidadF' WHERE id_ingresofactura='$id_ingresoFac' and id_producto='$id_producto'" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else
			{
				echo "guardo";
				

			}
		}if ($respuesta==0) {
			
			
		
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_ingresosdetallefactura VALUES (NULL, '$id_ingresoFac', '$id_producto','$cantidadU','$cantidadF', current_date())" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else
			{
				echo "guardo";
				

			}
			}
		}
	if ($operacion == "cierreInv") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$VTotal = $datos->VTotal;
		$vVenta = $datos->vVenta;
		$unidadN = $datos->unidadN;
		$stockN = $datos->stockN;
		$utilidad = $vVenta - $VTotal;

			
		
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_cierreinventario VALUES (NULL, '$VTotal', '$vVenta','$utilidad','$unidadN','$stockN', current_date())" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else
			{
				echo "guardo";
				

			}
			
	}if ($operacion == "changeIngresoFactura") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidadU = $datos->cantidadU;
		$cantidadF = $datos->cantidadF;
		$id_ingresoFac = $datos->id_ingresoFac;


		$sql_listadoProducto = mysqli_query ($link, "UPDATE tbl_ingresosdetallefactura SET cantidadUnidad='$cantidadU', cantidadFraccion='$cantidadF' WHERE id_ingresofactura='$id_ingresoFac' and id_producto='$id_producto'" );	
		if (!$sql_listadoProducto) {
		echo "fallo";
		}else{
			echo "guardo";
		}

		
		
	}if ($operacion == "changeIngresoFacturaValor") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$valor_d = $datos->valor_d;
		$valor_ve = $datos->valor_ve;
		$valor_Un = $datos->valor_Un;
		$id_ingresoFac = $datos->id_ingresoFac;


		$rentabilidad=(($valor_ve - $valor_d)/$valor_ve)*100;
		$sql_listadoProducto = mysqli_query ($link, "UPDATE tbl_producto SET valor='$valor_d', valor_venta='$valor_ve', valor_unidad='$valor_Un',rentabilidad='$rentabilidad' WHERE  id_producto='$id_producto'" );	
		if (!$sql_listadoProducto) {
		echo "fallo";
		}else{
			echo "guardo";
		}

		
		
	}if ($operacion == "addbarraProducto") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$barra = $datos->barra;
		
		$sql_verificar= mysqli_query($link,"SELECT * FROM tbl_producto WHERE  id_producto='$id_producto'");
			if(mysqli_num_rows($sql_verificar)>0){
				$data=mysqli_fetch_array($sql_verificar);

				if ($data['codigo_barrasUno']==null) {
					$sql_listadoProducto = mysqli_query ($link, "UPDATE tbl_producto SET  codigo_barrasUno='$barra' WHERE  id_producto='$id_producto'" );	
		if (!$sql_listadoProducto) {
		echo "fallo";
		}else{
			echo "guardo";
		}
				}else if ($data['codigo_barrasUno']!=null && $data['codigo_barrasDos']==null) {
					
					$sql_listadoProducto = mysqli_query ($link, "UPDATE tbl_producto SET  codigo_barrasDos='$barra' WHERE  id_producto='$id_producto'" );
		if (!$sql_listadoProducto) {
		echo "fallo";
		}else{
			echo "guardo";
		}
				}
			
		}

	
		

		
		
	}if ($operacion == "listadodeSelectFactura") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_ingresofactura = $datos->id_ingresofactura;
		
		

		
		$sql_listadoProducto = mysqli_query ($link, "SELECT * FROM tbl_ingresosdetallefactura idf, tbl_ingresofactura ifa, tbl_producto p,tbl_iva i WHERE ifa.id_ingresofactura=idf.id_ingresofactura and i.id_iva=p.id_iva and idf.id_producto=p.id_producto and ifa.id_ingresofactura='$id_ingresofactura' ORDER BY idf.id_ingresosAdd DESC" );	

		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
		
	}if ($operacion == "listadodeOperacionInventario") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_cierreI = $datos->id_cierreI;
		$id_cierreF = $datos->id_cierreF;
		
		$sql_listadoCierreI= mysqli_query ($link, "SELECT fecha_Cierre FROM tbl_cierreInventario WHERE id_cierreInventario='$id_cierreI'" );	
		$dataCI=mysqli_fetch_array($sql_listadoCierreI);
		$sql_listadoCierreF = mysqli_query ($link, "SELECT fecha_Cierre FROM tbl_cierreInventario WHERE id_cierreInventario='$id_cierreF'" );	
		$dataCF=mysqli_fetch_array($sql_listadoCierreF);
		$FechaCI=$dataCI['fecha_Cierre'];
		$FechaCF=$dataCF['fecha_Cierre'];
		$sql_listadoProducto = mysqli_query ($link, "SELECT *  FROM tbl_factura f,tbl_detallefactura df,tbl_producto p,tbl_iva i,tbl_usuario_sistema us WHERE f.id_factura=df.id_factura and p.id_producto=df.id_producto and p.id_iva=i.id_iva and us.id_usuariosistema=f.id_vendedor and f.fecha_factura between '$FechaCI' and '$FechaCF' " );	

		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
		
	}if ($operacion == "listadoInventarioCierre") 
	{
		
		
		

		
		$sql_listadoProducto = mysqli_query ($link, "SELECT * FROM tbl_cierreinventario ORDER BY fecha_Cierre DESC" );	

		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
		
	}if ($operacion == "movimientodelProducto") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		
		

		
		$sql_listadoProductoI = mysqli_query ($link, "SELECT  i.id_ingresos as codigoD, i.operacion,i.cantidad,i.cantidadFraccion,i.fecha FROM tbl_producto p, tbl_ingresos i WHERE p.id_producto=i.id_producto  and p.id_producto='$id_producto 'ORDER BY i.fecha  DESC  " );	
$sql_listadoProductoDC = mysqli_query ($link, "SELECT c.codigoCredito as codigoD, dc.operacion,dc.cantidad,dc.cantidadFraccion,dc.fecha  FROM tbl_producto p, tbl_detalle_credito dc,tbl_credito c WHERE p.id_producto=dc.id_producto and c.id_credito=dc.id_credito and p.id_producto='$id_producto' ORDER BY dc.fecha DESC  " );	
$sql_listadoProductoDD = mysqli_query ($link, "SELECT  d.codigo_factura as codigoD, dd.operacion,dd.cantidad,dd.cantidadFraccion,dd.fecha  FROM tbl_producto p, tbl_detalledevoluciones dd,tbl_devolucion d WHERE p.id_producto=dd.id_producto and d.id_devolucion=dd.id_devolucion and p.id_producto='$id_producto' ORDER BY dd.fecha " );	
$sql_listadoProductoDF = mysqli_query ($link, "SELECT  f.codigo_factura as codigoD, df.operacion,df.cantidad,df.cantidadFraccion,df.fecha  FROM tbl_producto p, tbl_detallefactura df,tbl_factura f WHERE p.id_producto=df.id_producto and f.id_factura=df.id_factura and p.id_producto='$id_producto' ORDER BY df.fecha " );	

		
		$rows = array();
		$rows1 = array();
		$rows2 = array();
		$rows3 = array();
		$rows4 = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProductoI))
		{
			$rows1[] = $respuesta;
		}while ($respuesta = mysqli_fetch_assoc($sql_listadoProductoDC))
		{
			$rows2[] = $respuesta;
		}while ($respuesta = mysqli_fetch_assoc($sql_listadoProductoDD))
		{
			$rows3[] = $respuesta;
		}while ($respuesta = mysqli_fetch_assoc($sql_listadoProductoDF))
		{
			$rows4[] = $respuesta;
		}
		$rows= array_merge ($rows1,$rows2,$rows3,$rows4);
		echo $rows = json_encode($rows);
		mysqli_close($link);
		
	}if ($operacion == "vaciarProductoFacturaSelect") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_ingresosAdd = $datos->id_ingresosAdd;
		
		

		
		$sql_listadoProducto = mysqli_query ($link, "UPDATE tbl_ingresosdetallefactura SET cantidadUnidad=0, cantidadFraccion=0 WHERE id_ingresofactura='$id_ingresosAdd'" );	

		
		if (!$sql_listadoProducto) {
			echo "fallo";
		}else{
			echo "exito";
		}
		
	}if ($operacion == "eliminarProductoFacturaSelect") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_ingresosAdd = $datos->id_ingresosAdd;
		
		

		
		$sql_listadoProducto = mysqli_query ($link, "DELETE FROM  tbl_ingresosdetallefactura  WHERE id_ingresofactura='$id_ingresosAdd'" );	

		
		if (!$sql_listadoProducto) {
			echo "fallo";
		}else{
			echo "exito";
		}
		
	}if ($operacion == "eliminartotalProductoFacturaSelect") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_ingresosAdd = $datos->id_ingresosAdd;
		
		

		$sql_listadoProducto = mysqli_query ($link, "DELETE FROM  tbl_ingresofactura  WHERE id_ingresofactura='$id_ingresosAdd'" );
		$sql_listadoProducto = mysqli_query ($link, "DELETE FROM  tbl_ingresosdetallefactura  WHERE id_ingresofactura='$id_ingresosAdd'" );	

		
		if (!$sql_listadoProducto) {
			echo "fallo";
		}else{
			echo "exito";
		}
		
	}if ($operacion == "EliminarIngresoFactura") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$id_ingresoFac = $datos->id_ingresoFac;
		
		

		
		$sql_listadoProducto = mysqli_query ($link, "DELETE FROM tbl_ingresosdetallefactura  WHERE id_ingresofactura='$id_ingresoFac' and id_producto='$id_producto'" );	
		if (!$sql_listadoProducto) {
			echo "fallo";
		}else{
			echo "exito";
		}

	
		
	}if ($operacion == "insertadorIngresosProducto") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidadUnidad = $datos->cantidadUnidad;
		$cantidadFraccion = $datos->cantidadFraccion;
		

		$sql_busquedaInventarios = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
		$sql_busquedaProducto = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE id_producto='$id_producto' " );
		$array=mysqli_fetch_array($sql_busquedaProducto);
		$respuesta = mysqli_num_rows($sql_busquedaInventarios);
		$rows = mysqli_fetch_array($sql_busquedaInventarios);
		if ($respuesta >= 1)
		{
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_ingresos VALUES (NULL, '$id_producto', '$cantidadUnidad','$cantidadFraccion', current_date(),'Ingreso')" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			if ($array['fraccion']==0) {
				$id_inventario = $rows['id_inventario'];
				$unidad = $rows['Unidad'];
				
				$sumaUnidad=$unidad + $cantidadUnidad;

				$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_inventario SET Unidad='$sumaUnidad' WHERE id_inventario='$id_inventario'" );
				if (!$sql_updateInventarios)
				{
					echo "fallo";
				}
				else
				{
					echo "guardo";

				}


				
			}
			else
			{
				// echo "guardo";}
				$fraccionProducto=$array['fraccion'];

				if ($cantidadUnidad!=0) {
					
					$cantidad=$cantidadUnidad*$array['fraccion'];
					
				}else if($cantidadFraccion!=0){
					$cantidadF=$cantidadFraccion;
				}

			$id_inventario = $rows['id_inventario'];
				$unidad = $rows['Unidad'];
				$fraccion = $rows['stock'];
				$sumaFraccion=$fraccion + $cantidadFraccion;
				$sumaUnidad=$unidad + $cantidadUnidad;
				if ($sumaFraccion>=$fraccionProducto) {
					$NSumaFraccion=$sumaFraccion/$fraccionProducto;
					$sumaFraccion=$sumaFraccion%$fraccionProducto;
					
					$sumaUnidad=$sumaUnidad+floor($NSumaFraccion);


				}

				// $suma = $stock + $cantidad + $cantidadFraccion;

				$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$sumaFraccion', Unidad='$sumaUnidad' WHERE id_inventario='$id_inventario'" );
				if (!$sql_updateInventarios)
				{
					echo "fallo";
				}
				else
				{
					echo "guardo";

				}

			}
		}
		else
		{
			echo "noseencontro";
			
		} 
		
	} else if ($operacion == "insertadorIngresosProductoSerial") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$serial = $datos->serial;
		

		
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_productoserial VALUES (NULL, '$id_producto', '$serial', current_date())" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else
			{
				
				echo "guardo";
			}
		}
		 else if ($operacion == "insertarfacturaAdd") 
	{
		$datos = json_decode(file_get_contents("php://input"));

		
		$nombreAddFactura = $datos->nombreAddFactura;
		

		
			$sql_insertingresos = mysqli_query ($link, "INSERT INTO tbl_ingresofactura VALUES (NULL, '$nombreAddFactura',current_date(),0)" );
			if (!$sql_insertingresos)
			{
				echo "fallo";
			}
			else
			{
				
				echo "guardo";
			}
		}
		
	else if ($operacion == "actualizandoIngresos")
	{
		$datos = json_decode(file_get_contents("php://input"));

		$cantidad = $datos->cantidad;
		$cantidad_nueva = $datos->cantidad_nueva;
		$id_producto = $datos->id_producto;
		$id_inventario = $datos->id_inventario;
		$id_ingresos = $datos->id_ingresos;

		$sql_buscaringresiInventario = mysqli_query ($link, "SELECT * FROM tbl_inventario  WHERE id_inventario='".$datos->id_inventario."'" );
			$fila = mysqli_fetch_array($sql_buscaringresiInventario);

			$sql_cantidad = $fila['stock'];
			$resultado = $sql_cantidad - $datos->cantidad;

		// le restamos la cantidad que tenia anteriormente el registro del producto en el inventario
			$sql_elimnaringresos = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$resultado' WHERE id_inventario='".$datos->id_inventario."'" );
			if (!$sql_elimnaringresos)
			{
				echo "noActuaizo_elimno_resta";
			}
			else
			{
				$nuevostock = $resultado + $cantidad_nueva;
				// actualizamos el stock del producto en el inventario con el nuevo ingreso actualizado
				$sql_actualiInventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='".$datos->id_inventario."'" );
				if (!$sql_actualiInventario)
				{
					echo "noActuaizo";
				}
				else
				{
					
					$sql_actualiIngresos = mysqli_query ($link, "UPDATE tbl_ingresos SET cantidad='$cantidad_nueva' WHERE id_ingresos='".$datos->id_ingresos."'" );
					if (!$sql_actualiIngresos)
					{
						echo "noActuaizo";
					}
					else
					{
						echo "exito_Actualizo";
					}
				}
			}

	}
	else if ($operacion == "listadodeProductos")
	{
		$sql_listadoProducto = mysqli_query ($link, "SELECT sec.*,p.valor_venta*i.iva/100 as ivaValor, p.*,c.*,i.*,pro.*, inv.* FROM tbl_producto p, tbl_categoria c, tbl_iva i ,tbl_proveedor pro,tbl_inventario inv, tbl_seccion sec WHERE inv.id_producto=p.id_producto and p.id_categoria=c.id_categoria and sec.id_seccion=p.id_seccion and i.id_iva=p.id_iva and pro.id_proveedor=p.id_proveedor ORDER BY p.descripcion ASC" );	
		
		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodeProductosOrden")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$barra=$datos->barra;

		$sql_listadoProducto = mysqli_query ($link, "SELECT p.*,p.presentacion,i.Unidad,p.descripcion,p.fraccion,p.unidadCerrada,p.codigo_producto,c.nombre_categoria,i.stock,i.* FROM tbl_producto p,tbl_categoria c, tbl_inventario i WHERE i.id_producto=p.id_producto and p.id_categoria=c.id_categoria and p.descripcion LIKE '$barra%' ORDER BY p.descripcion ASC " );	
		
		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodecodigoproducto")
	{
		$sql_listadoProducto = mysqli_query ($link, "SELECT  * FROM tbl_producto  ORDER BY id_producto DESC LIMIT 1" );	
		
		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodeproductoUnico")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$codigoPro=$datos->codigoPro;
		$sql_listadoProducto = mysqli_query ($link, "SELECT  * FROM tbl_producto  WHERE codigo_producto='$codigoPro' " );	
		
		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}	else if ($operacion == "listadodeFacturaADD")
	{
		$sql_listadoFACTURAADD = mysqli_query ($link, "SELECT * FROM tbl_ingresofactura ORDER BY id_ingresofactura DESC" );	

		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoFACTURAADD))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodeProductosSeriales")
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_pro = $datos->id_producto;
		$sql_listadoProducto = mysqli_query ($link, "SELECT ps.id_productoserial, ps.serial,c.nombre_categoria,p.id_producto,p.nombre,p.codigo_producto,p.id_categoria,p.descripcion,p.valor,p.valor_venta FROM tbl_producto p, tbl_categoria c,tbl_productoserial ps WHERE p.id_categoria=c.id_categoria and ps.id_producto=p.id_producto and p.id_producto='$id_pro'" );	

		
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == "listadodeIngresos")
	{
		$sql_listadoingresos = mysqli_query ($link, "SELECT inv.id_inventario,i.id_ingresos,i.cantidad,i.cantidadFraccion,i.fecha,p.id_producto,p.fraccion,ca.nombre_categoria,p.codigo_producto,p.descripcion,p.valor,p.valor_venta FROM tbl_ingresos i, tbl_producto p, tbl_categoria ca, tbl_inventario inv WHERE i.id_producto=p.id_producto and p.id_categoria=ca.id_categoria and inv.id_producto=p.id_producto ORDER BY i.fecha DESC" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoingresos))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == "eliminaringresos")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_producto_ElimiIngre = $datos->id_producto_ElimiIngre;
		$cantidad_ElimiIngre = $datos->cantidad_ElimiIngre;
		$id_ingreso_ElimiIngre = $datos->id_ingreso_ElimiIngre;

		$sql_elimnaringresos = mysqli_query ($link, "DELETE FROM tbl_ingresos WHERE id_ingresos='$id_ingreso_ElimiIngre'" );
		if (!$sql_elimnaringresos)
		{
			echo "no elimno";
		}
		else
		{

			$sql_buscaringresiInventario = mysqli_query ($link, "SELECT * FROM tbl_inventario  WHERE id_producto='$id_producto_ElimiIngre'" );
			$fila = mysqli_fetch_array($sql_buscaringresiInventario);

			$sql_cantidad = $fila['stock'];
			$resultado = $sql_cantidad - $cantidad_ElimiIngre;


			$sql_elimnaringresos = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$resultado' WHERE id_producto='$id_producto_ElimiIngre'" );
			if (!$sql_elimnaringresos)
			{
				echo "noActuaizo_elimno";
			}
			else
			{
				echo "exitoelimno";
			}
		}
	}
	
}
else if ($variable == "facturar")
{
	if ($operacion == 'insertarplansepare')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
		$totalapagar_plansepare = $datos->totalapagar_plansepare;

		$fecha_inicioPlansepare = $datos->fecha_inicioPlansepare;
		$fechaFin_plansepare = $datos->fechaFin_plansepare;
		$valor_aumento = $datos->valor_aumento;

		$sumapago = $valor_aumento + $totalapagar_plansepare;

		$estadoproducto = "No Entregado";
			$sql_elimnar_Plansepare = mysqli_query ($link, "INSERT INTO tbl_plansepare VALUES (null,'$id_cliente','$valor_aumento','$sumapago','$sumapago','$fecha_inicioPlansepare','$fechaFin_plansepare','$estadoproducto')" );
			if (!$sql_elimnar_Plansepare)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimaplansepare = mysqli_query ($link, "SELECT * FROM tbl_plansepare order by id_plansepare DESC limit 1 " );
				$filaplansepare = mysqli_fetch_array($sql_ultimaplansepare);
				echo $id_plansepare = $filaplansepare['id_plansepare'];
			}
		
	}
	else if ($operacion == 'busquedaDetallaCuotas_Planes')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;

		$sql_lisdetallepagosplansepare = mysqli_query ($link, "SELECT dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.estadoproductos,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_lisdetallepagosplansepare))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'busquedaDetalle_Planes')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;

		$sql_lisdetallepagosplansepare = mysqli_query ($link, "SELECT abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,cl.cc_cliente,cl.nombre_cliente FROM tbl_plansepare pla, tbl_cliente cl, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and  pla.id_plansepare='$id_plansepare'" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_lisdetallepagosplansepare))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'actualizacionCuotaplansepare')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$cuotaanterior = $datos->cuotaanterior;
		$id_abonos_plansepare = $datos->id_abonos_plansepare;
		$id_plansepare = $datos->id_plansepare;
		$nuevacuota = $datos->nuevacuota;
		$descuento_abonos = $datos->descuento_abonos;

		$descuentoresta = $descuento_abonos + $cuotaanterior;
		$descuentorestados = $descuentoresta - $nuevacuota;

		$sql_actualizarPla = mysqli_query ($link, "UPDATE tbl_plansepare SET descuento_abonos='$descuentorestados' WHERE id_plansepare='$id_plansepare'" );
		if (!$sql_actualizarPla)
		{
			echo "erro1";
		}
		else
		{
			$sql_actualizarcuota = mysqli_query ($link, "UPDATE  tbl_abonos_plansepare SET valor_abono='$nuevacuota' WHERE id_abonos_plansepare='$id_abonos_plansepare'" );
			if (!$sql_actualizarcuota)
			{
				echo "erro2";
			}
			else
			{
				echo "exito";
			}
		}




	}
	else if ($operacion == 'busquedaPlanesPorfechaRango')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;
		
		$sql_listadoplansepare = mysqli_query ($link, "SELECT pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.estadoproductos,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.fecha_inicio>='$fechaInicialPansepare' and pla.fecha_inicio<='$fechaFinalPansepare' GROUP by pla.id_plansepare" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}

	else if ($operacion == 'eliminado_plansepare')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$estadoproductos = $datos->estadoproductos;


		$sql_BUSCARABONOS = mysqli_query ($link, "SELECT * FROM  tbl_abonos_plansepare WHERE id_plansepare='$id_plansepare'" );	
		if (mysqli_num_rows($sql_BUSCARABONOS) == 0)
		{
			if ($estadoproductos == 'Entregado')
				{
					
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );

					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];

				    	$buscarproductosInve = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );
				    	$filainventario = mysqli_fetch_array($buscarproductosInve);
				    	$id_inventario = $filainventario['id_inventario'];
				    	$stockinven = $filainventario['stock'];
				    	$nuevostock = $stockinven + $cantidad; 

				    	$sqlAtualizainventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );

				    	if (!$sqlAtualizainventario)
				    	{
				    		echo "error2";
				    	}
				    	else
				    	{
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );
				    	}
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }

				}
				else
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );


					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];
			    	
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );			    	
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }
				}
		}
		else
		{
			$sql_eliminarabonos = mysqli_query ($link, "DELETE FROM tbl_abonos_plansepare WHERE id_plansepare='$id_plansepare'" );	
			if (!$sql_eliminarabonos)
			{
				echo "error1";
			}
			else
			{
				if ($estadoproductos == 'Entregado')
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );
					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];

				    	$buscarproductosInve = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );
				    	$filainventario = mysqli_fetch_array($buscarproductosInve);
				    	$id_inventario = $filainventario['id_inventario'];
				    	$stockinven = $filainventario['stock'];
				    	$nuevostock = $stockinven + $cantidad; 

				    	$sqlAtualizainventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );

				    	if (!$sqlAtualizainventario)
				    	{
				    		echo "error2";
				    	}
				    	else
				    	{
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );
				    	}
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }

				}
				else
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );
					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];
			    	
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );			    	
				    }


				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }
				}
			}

		}

	}
	else if ($operacion == 'eliminado_planseparexcliente')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$estadoproductos = $datos->estadoproductos;


		$sql_BUSCARABONOS = mysqli_query ($link, "SELECT * FROM  tbl_abonos_plansepare WHERE id_plansepare='$id_plansepare'" );	
		if (mysqli_num_rows($sql_BUSCARABONOS) == 0)
		{
			if ($estadoproductos == 'Entregado')
				{
					
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );

					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];

				    	$buscarproductosInve = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );
				    	$filainventario = mysqli_fetch_array($buscarproductosInve);
				    	$id_inventario = $filainventario['id_inventario'];
				    	$stockinven = $filainventario['stock'];
				    	$nuevostock = $stockinven + $cantidad; 

				    	$sqlAtualizainventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );

				    	if (!$sqlAtualizainventario)
				    	{
				    		echo "error2";
				    	}
				    	else
				    	{
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );
				    	}
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "sisi";
				    	}
				    }

				}
				else
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );


					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];
			    	
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );			    	
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }
				}
		}
		else
		{
			$sql_eliminarabonos = mysqli_query ($link, "DELETE FROM tbl_abonos_plansepare WHERE id_plansepare='$id_plansepare'" );	
			if (!$sql_eliminarabonos)
			{
				echo "error1";
			}
			else
			{
				if ($estadoproductos == 'Entregado')
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );
					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];

				    	$buscarproductosInve = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );
				    	$filainventario = mysqli_fetch_array($buscarproductosInve);
				    	$id_inventario = $filainventario['id_inventario'];
				    	$stockinven = $filainventario['stock'];
				    	$nuevostock = $stockinven + $cantidad; 

				    	$sqlAtualizainventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );

				    	if (!$sqlAtualizainventario)
				    	{
				    		echo "error2";
				    	}
				    	else
				    	{
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );
				    	}
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }

				}
				else
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );
					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];
			    	
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );			    	
				    }


				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }
				}
			}

		}

	}
	else if ($operacion == 'busquedaPlanesPorCliente')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
	
		$sql_listadoplansepare = mysqli_query ($link, "SELECT pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_cliente'  GROUP by pla.id_plansepare" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'insertarDetallePlansepare')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidad = $datos->cantidad;
		$valorTotal = $datos->valorTotal;
		$id_plansepare = $datos->id_plansepare;

		$sql_detallefactura = mysqli_query ($link, "INSERT INTO tbl_detalle_plansepare VALUES (null,'$id_plansepare','$id_producto','$cantidad','$valorTotal')" );
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo "exito";
		}
	}else if ($operacion == 'ajusteInventarioU')
	{
		$datos = json_decode(file_get_contents("php://input"));
		

		$Unidad = $datos->Unidad;
		$fraccion = $datos->fraccion;
		$stock = $datos->stock;
		$id_inventario = $datos->id_inventario;
		
		$sql_consulta = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_inventario='$id_inventario'" );

		// if (mysqli_fetch_row($sql_consulta)>0) {
			
			$row=mysqli_fetch_array($sql_consulta);

			if (!$row) {
				echo "fallo2";
			}
			$id=$row['id_producto'];
			$sql_consultaPro = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE id_producto='$id'" );
			$diferenciaU=0;
			$diferenciaF=0;
			$rows=mysqli_fetch_array($sql_consultaPro);
			$producto=$rows['descripcion']." ".$rows['presentacion'];
			if ($fraccion==0) {
				$diferenciaU=$Unidad - $row['Unidad'];
			}else {
				$diferenciaU=$Unidad - $row['Unidad'];
				$diferenciaF=$stock - $row['stock'];

			}
			if ($stock>=$fraccion) {
					$NSumaFraccion=$stock/$fraccion;
					$stock=$stock%$fraccion;
					
					$Unidad=$Unidad+floor($NSumaFraccion);
				}


			// echo $row['Unidad'];
			$fechaHoy= date("Y-m-d");
				$hora=date(" h:i:s a");
				$sql_detallefactura = mysqli_query ($link, "UPDATE tbl_inventario SET Unidad='$Unidad', stock='$stock',diferenciaU='$diferenciaU', diferenciaF='$diferenciaF',fecha_movimiento='$fechaHoy' WHERE id_inventario='$id_inventario'" );
$cabeceras = "Content-type: text/html\r\n";
				$mensaje = '
<html>
<head>
  <title>Informacion de Productos modificados en Inventario</title>
</head>
<body>
  <p>¡Estos son los productos modificados!</p>
  <table>
    <tr>
      <th>Producto</th><th>Cantidad</th><th>Diferencia</th><th>hora</th>
    </tr>
    <tr>
      <td>'.$producto.'</td><td>'.$Unidad.'/'.$stock.'</td><td>'.$diferenciaU.'/'.$diferenciaF.'</td><td>'.$hora.'</td>
    </tr>
   
  </table>
</body>
</html>
';


		$bool = mail('cris123ecume@gmail.com', 'Modificacion de Inventario', $mensaje, $cabeceras);
if($bool){
    echo "Mensaje enviado";
}else{
    echo "Mensaje no enviado";
}
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo $row['Unidad'];
		}
		// }

	
	}
	else if ($operacion == "generarPagocuotaPlansepare")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$pagocuota_plansepare = $datos->pagocuota_plansepare;
		$deuda_actual = $datos->deuda_actual;
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;

		$deuda = $deuda_actual - $pagocuota_plansepare;

		

		$sql_guardar_pago = mysqli_query ($link, "INSERT INTO tbl_abonos_plansepare VALUES(null,'$id_plansepare','$id_cliente','$pagocuota_plansepare',current_date())" );	

		if (!$sql_guardar_pago) 
		{
			echo "fallo";
		}
		else
		{
			
			$sql_ac_deuda = mysqli_query ($link, "UPDATE tbl_plansepare SET descuento_abonos='$deuda' WHERE id_plansepare='$id_plansepare'" );	

			if (!$sql_ac_deuda) 
			{
				echo "fallo2";
			}
			else
			{

				$sql_listadoplansepare = mysqli_query ($link, "SELECT pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.fecha_inicio>='$fechaInicialPansepare' and pla.fecha_inicio<='$fechaFinalPansepare' GROUP by pla.id_plansepare" );	


				$rows = array();
				$conteo = 0;
				while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
				{

					$fecha_final_sql= strtotime($respuesta['fecha_fin']);
					$fecha_actual_sql= strtotime($respuesta['fechaactual']);

					if ($fecha_actual_sql > $fecha_final_sql) 
					{
						$estadocredito = "vencido";
					}
					else
					{
						$estadocredito = "novencido";
						

					}
					
					$rows[]=array(
						"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



					
				}

				// print_r($rows);
				echo $rows = json_encode($rows);
				mysqli_close($link);
			}
		}
		
	}

	else if ($operacion == "entregarProductosPl")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;

		$sql_lisadoDetallPlansepare = mysqli_query ($link, "SELECT dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.id_producto,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );	

		if (!$sql_lisadoDetallPlansepare) 
		{
			echo "fallo2";
		}
		else
		{
			while ($respuesta = mysqli_fetch_assoc($sql_lisadoDetallPlansepare))
			{
				$id_producto = $respuesta['id_producto'];
				$cantidad = $respuesta['cantidad'];


				$sql_productoInventario = mysqli_query ($link, "SELECT * FROM  tbl_inventario WHERE id_producto='$id_producto'" );	
				$filas = mysqli_fetch_array($sql_productoInventario);

				$stock = $filas['stock'];
				$id_inventario = $filas['id_inventario'];

				$nuevostock = $stock - $cantidad;

				$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );	

				if (!$sql_actualizaInventario) 
				{
					echo "fallo3";
				}
				else
				{	
					$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_plansepare SET estadoproductos='Entregado' WHERE id_plansepare='$id_plansepare'" );	

					if (!$sql_actualizaInventario) 
					{
						echo "fallo3";
					}
					else
					{

						$sql_listadoplansepare = mysqli_query ($link, "SELECT  pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_cliente' GROUP by pla.id_plansepare" );	


						$rows = array();
						$conteo = 0;
						while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
						{

							$fecha_final_sql= strtotime($respuesta['fecha_fin']);
							$fecha_actual_sql= strtotime($respuesta['fechaactual']);

							if ($fecha_actual_sql > $fecha_final_sql) 
							{
								$estadocredito = "vencido";
							}
							else
							{
								$estadocredito = "novencido";
								

							}
							
							$rows[]=array(
								"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);

						}

						// print_r($rows);
						echo $rows = json_encode($rows);
						mysqli_close($link);
					}
				}
			}
		}
		
	}
	else if ($operacion == "entregarProductosPlXrangofecha")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;

		$sql_lisadoDetallPlansepare = mysqli_query ($link, "SELECT dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.id_producto,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );	

		if (!$sql_lisadoDetallPlansepare) 
		{
			echo "fallo2";
		}
		else
		{
			while ($respuestados_a = mysqli_fetch_assoc($sql_lisadoDetallPlansepare))
			{
				$id_producto = $respuestados_a['id_producto'];
				$cantidad = $respuestados_a['cantidad'];


				$sql_productoInventario = mysqli_query ($link, "SELECT * FROM  tbl_inventario WHERE id_producto='$id_producto'" );	
				$filas = mysqli_fetch_array($sql_productoInventario);

				$stock = $filas['stock'];
				$id_inventario = $filas['id_inventario'];

				$nuevostock = $stock - $cantidad;

				$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );	

				if (!$sql_actualizaInventario) 
				{
					echo "fallo3";
				}
				else
				{	
					$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_plansepare SET estadoproductos='Entregado' WHERE id_plansepare='$id_plansepare'" );	

					if (!$sql_actualizaInventario) 
					{
						echo "fallo3";
					}
					else
					{

						echo "siactualizo";
					}
				}
			}
		}
		
	}
	else if ($operacion == "generarPagocuotaPlansepareXclientes")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$pagocuota_plansepare = $datos->pagocuota_plansepare;
		$deuda_actual = $datos->deuda_actual;
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;

		$deuda = $deuda_actual - $pagocuota_plansepare;

		

		$sql_guardar_pago = mysqli_query ($link, "INSERT INTO tbl_abonos_plansepare VALUES(null,'$id_plansepare','$id_cliente','$pagocuota_plansepare',current_date())" );	

		if (!$sql_guardar_pago) 
		{
			echo "fallo";
		}
		else
		{
			
			$sql_ac_deuda = mysqli_query ($link, "UPDATE tbl_plansepare SET descuento_abonos='$deuda' WHERE id_plansepare='$id_plansepare'" );	

			if (!$sql_ac_deuda) 
			{
				echo "fallo2";
			}
			else
			{

				$sql_listadoplansepare = mysqli_query ($link, "SELECT  pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_cliente' GROUP by pla.id_plansepare" );	


				$rows = array();
				$conteo = 0;
				while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
				{

					$fecha_final_sql= strtotime($respuesta['fecha_fin']);
					$fecha_actual_sql= strtotime($respuesta['fechaactual']);

					if ($fecha_actual_sql > $fecha_final_sql) 
					{
						$estadocredito = "vencido";
					}
					else
					{
						$estadocredito = "novencido";
						

					}
					
					$rows[]=array(
						"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



					
				}

				// print_r($rows);
				echo $rows = json_encode($rows);
				mysqli_close($link);
			}
		}
		
	}
	else if ($operacion == "listadodeclintesFactura")
	{
		$sql_listadoClientes_factura = mysqli_query ($link, "SELECT * FROM tbl_cliente" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoClientes_factura))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodeCanPro")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_seccion = $datos->id_seccion;
		$sql_listadoClientes_factura = mysqli_query ($link, "SELECT count(id_producto) as totalPro FROM tbl_producto WHERE id_seccion='$id_seccion'" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoClientes_factura))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodeStock")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_producto = $datos->id_producto;
		$sql_listadoClientes_factura = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoClientes_factura))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == "listadodeInventario")
	{
		$sql_listadoClientes_factura =  mysqli_query ($link, "SELECT p.*,p.presentacion,i.Unidad,p.descripcion,p.fraccion,p.unidadCerrada,p.codigo_producto,c.nombre_categoria,i.stock,i.* FROM tbl_producto p,tbl_categoria c, tbl_inventario i WHERE i.id_producto=p.id_producto and p.id_categoria=c.id_categoria ORDER BY p.descripcion ASC" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoClientes_factura))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'facturasXrangoFecha')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$fecha_inicio = $datos->fecha_inicio;
		$fecha_fin = $datos->fecha_fin;

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT us.*,f.hora,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_usuario_sistema us WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and us.id_usuariosistema=f.id_vendedor and  f.fecha_factura>='$fecha_inicio'  and f.fecha_factura<='$fecha_fin'  order by fecha_factura ASC" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'facturasXrangoFechaUnica')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$fecha_inicio = $datos->fecha_inicio;
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.hora,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente  and  f.fecha_factura='$fecha_inicio'  order by fecha_factura ASC" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'descuadreList')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$fecha_inicio = $datos->fecha_inicio;
		$fecha_fin = $datos->fecha_fin;

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT inv.*,pro.* FROM tbl_inventario inv,tbl_producto pro WHERE inv.id_producto=pro.id_producto and inv.diferenciaU<0  and inv.fecha_movimiento>'$fecha_inicio' and inv.fecha_movimiento<'$fecha_fin'" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'descuadreListNomodificado')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$fecha_inicio = $datos->fecha_inicio;
		$fecha_fin = $datos->fecha_fin;

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT inv.*,pro.* FROM tbl_inventario inv,tbl_producto pro WHERE inv.id_producto=pro.id_producto  and inv.fecha_movimiento <'$fecha_inicio' OR inv.fecha_movimiento>'$fecha_fin' " );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'ordenarCodigo')
	{
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT * FROM tbl_producto" );	
		$codigo=1;
		
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$id=$respuesta['id_producto'];
				$sql_listado_facturaxfechas = mysqli_query ($link, "UPDATE tbl_producto SET codigo_producto='$codigo' WHERE id_producto='$id'" );
						$codigo++;	
						echo "exito";
			}

			
			mysqli_close($link);
		
	}else if ($operacion == 'calcularGanancias')
	{
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT * FROM tbl_factura   " );	
		$codigo=1;
		
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$id=$respuesta['id_factura'];
				$ganancia=0;
				$sql_listado_facturaxfechasDD = mysqli_query ($link, "SELECT * FROM tbl_detallefactura df, tbl_factura f,tbl_producto pro WHERE pro.id_producto=df.id_producto and  df.id_factura=f.id_factura and f.id_factura='$id'  " );
				while ($respuestaDos = mysqli_fetch_assoc($sql_listado_facturaxfechasDD))
			{	
				$gananciaUnidad=0;
				$gananciaFRaccion=0;
				$valorU=$respuestaDos['valor_venta']/ $respuestaDos['fraccion'];
					$gananciaUnidad=($respuestaDos['valor_venta'] - $respuestaDos['valor']) * $respuestaDos['cantidad'];
					$gananciaFRaccion=($respuestaDos['valor_unidad'] - $valorU) * $respuestaDos['cantidadFraccion'];
					$ganancia=$gananciaUnidad ;
					echo $ganancia;
						
}
$sql_listado_facturaxfechaddd = mysqli_query ($link, "UPDATE tbl_factura SET ganacia='$ganancia' WHERE id_factura='$id' " );
	
			}

			// echo "exito";
			mysqli_close($link);
		
	}else if ($operacion == 'facturacodigo')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$codigo = $datos->codigo;
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT us.*,f.hora,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_usuario_sistema us WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and us.id_usuariosistema=f.id_vendedor and f.codigo_factura='$codigo' order by fecha_factura ASC" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'facturaListaDat')
	{
		
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT us.*,f.hora,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_usuario_sistema us WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and us.id_usuariosistema=f.id_vendedor  order by codigo_factura desc limit 10" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'devolucioneslistado')
	{
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT d.hora,us.nombre_usuario,d.id_devolucion,d.codigo_factura,d.fecha_factura,d.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_devolucion d, tbl_empresa em, tbl_cliente cli,tbl_usuario_sistema us WHERE d.id_empresa=em.id_empresa and d.id_cliente=cli.id_cliente and us.id_usuariosistema=id_vendedor  order by fecha_factura ASC" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'devolucionTotal')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;
		

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente  and  f.fecha_factura>='$fecha_inicio'  and f.fecha_factura<='$fecha_fin'  order by fecha_factura ASC" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}else if ($operacion == 'ultimaFacturaF')
	{
		
		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente order by id_factura DESC limit 1" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}
	else if ($operacion == 'ventasDelDia')
	{
		
		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.codigo_factura,f.fecha_factura,f.valor_pago, pro.descripcion,df.total_pago FROM tbl_factura f, tbl_empresa em,tbl_detallefactura df, tbl_producto pro WHERE f.id_empresa=em.id_empresa and df.id_factura=f.id_factura and df.id_producto=pro.id_producto and f.fecha_factura=current_date()" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}
	else if ($operacion == 'facturasXclienteseleccionado')
	{
		$datos = json_decode(file_get_contents("php://input"));

		
		$id_cliente = $datos->id_cliente;

		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT us.*,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_usuario_sistema us WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and us.id_usuariosistema=f.id_vendedor and f.id_cliente='$id_cliente'" );	

		if (mysqli_num_rows($sql_listado_facturaxfecha) == 0)
		{
			echo "nohay";
		}
		else
		{
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
		}
	}
	else if ($operacion == 'busqueda_facturaseleccinada')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;
	
		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.hora,f.ganacia,f.descuento,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_factura f, tbl_empresa em, tbl_cliente cli WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente  and  f.id_factura='$id_factura'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'busqueda_devolucionseleccinada')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_devolucion = $datos->id_devolucion;
	
		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT d.id_devolucion,d.codigo_factura,d.fecha_factura,d.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_devolucion d, tbl_empresa em, tbl_cliente cli WHERE d.id_empresa=em.id_empresa and d.id_cliente=cli.id_cliente  and  d.id_devolucion='$id_devolucion'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'busqueda_facturaseleccinadaProyecto')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;
	
		$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT fp.id_facturaproyecto,fp.codigo_factura,fp.fecha_factura,fp.valor_pago,cli.cc_cliente,cli.nombre_cliente FROM tbl_facturaproyecto fp, tbl_empresa em, tbl_cliente cli WHERE fp.id_empresa=em.id_empresa and fp.id_cliente=cli.id_cliente  and  fp.id_proyecto='$id_factura'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}
	else if ($operacion == 'busquedaDetallefacturaselecionada')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;
	
		$sql_listado_detalle_factura = mysqli_query ($link, "SELECT us.*,p.fraccion,p.valor_venta*i.iva/100 as  ivaVal,i.iva,f.id_factura,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.presentacion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.total_pago,p.valor_venta, df.cantidadFraccion,df.* FROM tbl_factura f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefactura df, tbl_categoria cat,tbl_iva i,tbl_usuario_sistema us WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_factura=f.id_factura and p.id_categoria=cat.id_categoria and i.id_iva=p.id_iva and us.id_usuariosistema=f.id_vendedor and df.id_factura='$id_factura'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_detalle_factura))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'busquedaDetalledevolucionesselecionada')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_devolucion = $datos->id_devolucion;
	
		$sql_listado_detalle_factura = mysqli_query ($link, "SELECT dd.hora,p.valor_venta*i.iva/100 as  ivaVal,i.iva,d.id_devolucion,d.codigo_factura,d.fecha_factura,d.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.descripcion,p.presentacion,p.codigo_producto,p.id_categoria,cat.nombre_categoria,dd.cantidad,dd.total_pago,p.valor_venta, dd.cantidadFraccion,dd.*,us.* FROM tbl_usuario_sistema us, tbl_devolucion d, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detalledevoluciones dd, tbl_categoria cat,tbl_iva i WHERE d.id_empresa=em.id_empresa and d.id_cliente=cli.id_cliente and dd.id_producto=p.id_producto and dd.id_devolucion=d.id_devolucion and p.id_categoria=cat.id_categoria and i.id_iva=p.id_iva and dd.id_vendedor=us.id_usuariosistema and dd.id_devolucion='$id_devolucion'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_detalle_factura))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == "eliminarFactura") {

		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;

		$sql_updateInventarios = mysqli_query ($link, "DELETE FROM tbl_factura WHERE id_factura='$id_factura'" );
		if (!$sql_updateInventarios) {
			echo "fallo";
		}else{
			echo "elimino";
		}
		
	}else if ($operacion == 'busquedaDetallefacturaselecionadaDevolucion')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;
		$id_detallefactura = $datos->id_detallefactura;
		$var_codigo_factura = $datos->var_codigo_factura;

  $sql_producto = mysqli_query ($link, "SELECT * FROM tbl_detallefactura WHERE id_detalleFactura='$id_detallefactura' " );
  $rows=mysqli_fetch_array($sql_producto);

  $id_producto=$rows['id_producto'];
  $cantidadUnidad=$rows['cantidad'];
  $cantidadFraccion=$rows['cantidadFraccion'];
  $pagoProducto=$rows['total_pago'];


		

		$sql_busquedaInventarios = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
		$sql_busquedaProducto = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE id_producto='$id_producto' " );
		$array=mysqli_fetch_array($sql_busquedaProducto);
		$respuesta = mysqli_num_rows($sql_busquedaInventarios);
		$rowsI = mysqli_fetch_array($sql_busquedaInventarios);
		if ($respuesta >= 1)
		{
			


				$fraccionProducto=$array['fraccion'];
				$id_inventario = $rowsI['id_inventario'];
				$unidad = $rowsI['Unidad'];
				$sumaUnidad=$unidad + $cantidadUnidad;
				if ($fraccionProducto==0) {

					$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_inventario SET  Unidad='$sumaUnidad' WHERE id_inventario='$id_inventario'" );
				if (!$sql_updateInventarios)
				{
					echo "fallo";
				}
				else
				{
					echo "guardod";
						$sql_busquedaFactura = mysqli_query ($link, "SELECT * FROM tbl_factura WHERE id_factura='$id_factura' " );
						$arr=mysqli_fetch_array($sql_busquedaFactura);
						$valorUp= $arr['valor_pago'] - $pagoProducto;	

						$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_factura  SET valor_pago='$valorUp' WHERE id_factura='$id_factura'" );
						$sql_updateInventarios = mysqli_query ($link, "DELETE FROM tbl_detallefactura WHERE id_detalleFactura='$id_detallefactura'" );

						$sql_busquedaDevolucion = mysqli_query ($link, "SELECT * FROM tbl_devolucion WHERE codigo_factura='$var_codigo_factura' " );
						
						ini_set('date.timezone','America/Bogota');
							$hoy =date("d-m-Y h:i:s");
							$hora=date(" h:i:s a");
						if (mysqli_fetch_row($sql_busquedaDevolucion)==0) {

							$sql_ingresarDevolucion = mysqli_query ($link, "INSERT INTO tbl_devolucion VALUES (null,'$var_codigo_factura','".$arr['id_empresa']."',current_date(),'$hora','".$arr['id_cliente']."','".$arr['valor_pago']."','".$arr['pagoCambio']."','".$arr['cambio']."','".$arr['id_vendedor']."')" );

						
						}else{
							$sql_busquedadetalleC = mysqli_query ($link, "SELECT * FROM tbl_devolucion WHERE codigo_factura='$var_codigo_factura' " );
								$arryC=mysqli_fetch_array($sql_busquedadetalleC);
							$valorUpC=$arryC['valor_pago'] + $pagoProducto;
							$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_devolucion  SET valor_pago='$valorUpC' WHERE codigo_factura='$var_codigo_factura'" );

						}
						$idUs=$_SESSION['id'];
							$sql_busquedadetalle = mysqli_query ($link, "SELECT * FROM tbl_devolucion WHERE codigo_factura='$var_codigo_factura' " );
							$arry=mysqli_fetch_array($sql_busquedadetalle);
							$sql_ingresarDevolucionDetalle = mysqli_query ($link, "INSERT INTO tbl_detalledevoluciones VALUES (null,'".$arry['id_devolucion']."','$id_producto','$cantidadUnidad','$cantidadFraccion','$pagoProducto','$idUs','Devolucion',current_date(),'$hora')" );
				}

					
				}else{

				if ($cantidadUnidad!=0) {
					
					$cantidad=$cantidadUnidad*$array['fraccion'];
					
				}else if($cantidadFraccion!=0){
					$cantidadF=$cantidadFraccion;
				}

				$id_inventario = $rowsI['id_inventario'];
				$unidad = $rowsI['Unidad'];
				$fraccion = $rowsI['stock'];
				$sumaFraccion=$fraccion + $cantidadFraccion;
				$sumaUnidad=$unidad + $cantidadUnidad;
				if ($sumaFraccion>=$fraccionProducto) {
					$NSumaFraccion=$sumaFraccion/$fraccionProducto;
					$sumaFraccion=$sumaFraccion%$fraccionProducto;
					
					$sumaUnidad=$sumaUnidad+floor($NSumaFraccion);


				}

				// $suma = $stock + $cantidad + $cantidadFraccion;

				$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$sumaFraccion', Unidad='$sumaUnidad' WHERE id_inventario='$id_inventario'" );
				if (!$sql_updateInventarios)
				{
					echo "fallo";
				}
				else
				{
					echo "guardot";
					$sql_busquedaFactura = mysqli_query ($link, "SELECT * FROM tbl_factura WHERE id_factura='$id_factura' " );
						$arr=mysqli_fetch_array($sql_busquedaFactura);
						$valorUp= $arr['valor_pago'] - $pagoProducto;					
						$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_factura  SET valor_pago='$valorUp' WHERE id_factura='$id_factura'" );
						$sql_updateInventarios = mysqli_query ($link, "DELETE FROM tbl_detallefactura WHERE id_detalleFactura='$id_detallefactura'" );

						$sql_busquedaDevolucion = mysqli_query ($link, "SELECT * FROM tbl_devolucion WHERE codigo_factura='$var_codigo_factura' " );
						ini_set('date.timezone','America/Bogota');
							$hoy =date("d-m-Y h:i:s");
							$hora=date(" h:i:s a");
						if (mysqli_fetch_row($sql_busquedaDevolucion)==0) {

							$sql_ingresarDevolucion = mysqli_query ($link, "INSERT INTO tbl_devolucion VALUES (null,'$var_codigo_factura','".$arr['id_empresa']."',current_date(),'$hora','".$arr['id_cliente']."','".$arr['valor_pago']."','".$arr['pagoCambio']."','".$arr['cambio']."','".$arr['id_vendedor']."')" );

						
						}else{
							$sql_busquedadetalle = mysqli_query ($link, "SELECT * FROM tbl_devolucion WHERE codigo_factura='$var_codigo_factura' " );
							$arryC=mysqli_fetch_array($sql_busquedadetalle);
							$valorUpC=$arryC['valor_pago'] + $pagoProducto;
							$sql_updateInventarios = mysqli_query ($link, "UPDATE tbl_devolucion  SET valor_pago='$valorUpC' WHERE codigo_factura='$var_codigo_factura'" );

						}
						$idUs=$_SESSION['id'];
							$sql_busquedadetalle = mysqli_query ($link, "SELECT * FROM tbl_devolucion WHERE codigo_factura='$var_codigo_factura' " );
							$arry=mysqli_fetch_array($sql_busquedadetalle);
							$sql_ingresarDevolucionDetalle = mysqli_query ($link, "INSERT INTO tbl_detalledevoluciones VALUES (null,'".$arry['id_devolucion']."','$id_producto','$cantidadUnidad','$cantidadFraccion','$pagoProducto','$idUs','Devolucion',current_date().'$hora')" );

				}

			}
		
	}
		else
		{
			echo "noseencontro";
			
		} 
	
		

	}else if ($operacion == 'busquedaDetallefacturaselecionadaProyecto')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_factura = $datos->id_factura;
	
		$sql_listado_detalle_factura = mysqli_query ($link, "SELECT f.id_facturaproyecto,f.codigo_factura,f.fecha_factura,f.valor_pago,cli.cc_cliente,cli.nombre_cliente,p.nombre,p.codigo_producto,p.id_categoria,cat.nombre_categoria,df.cantidad,df.total_pago,p.valor_venta FROM tbl_facturaproyecto f, tbl_empresa em, tbl_cliente cli, tbl_producto p, tbl_detallefacturaproyecto df, tbl_categoria cat WHERE f.id_empresa=em.id_empresa and f.id_cliente=cli.id_cliente and df.id_producto=p.id_producto and df.id_facturaproyecto=f.id_facturaproyecto and p.id_categoria=cat.id_categoria and df.id_facturaproyecto='$id_factura'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_detalle_factura))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}
	else if ($operacion == 'insertarfactura')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
		$totalpago = $datos->totalpago;
		$totalganancia = $datos->totalganancia;
		$cambio = $datos->cambio;
		$descuento = $datos->descuento;
		$pagoCambio = $datos->pagoCambio;
		$tipopago = $datos->tipopago;



		$sql_empresa = mysqli_query ($link, "SELECT * FROM tbl_empresa order by id_empresa DESC limit 1 " );
		$filaempresa = mysqli_fetch_array($sql_empresa);
		$id_empresa = $filaempresa['id_empresa'];

		$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_factura order by id_factura DESC limit 1 " );
		$filafactura = mysqli_fetch_array($sql_ultimafactura);
		$id_factura = $filafactura['id_factura'];
		$codigo_factura = $filafactura['codigo_factura'];
		ini_set('date.timezone','America/Bogota');
		$hoy =date("d-m-Y h:i:s");
		$hora=date(" h:i:s a");
		$sql_rangoFac = mysqli_query ($link, "SELECT * FROM tbl_rangofactura order by id_rango DESC limit 1 " );
			$filaRango = mysqli_fetch_array($sql_rangoFac);
		$horaString= (string)$hora;
		if (mysqli_num_rows($sql_ultimafactura) == 0)
		{
			
			$codigofactura = $filaRango['InicioFactura'];
			$idVendedor=(int)$_SESSION['id'];
			$sql_elimnaringresos = mysqli_query ($link, "INSERT INTO tbl_factura VALUES (null,'$codigofactura','$id_empresa',current_date(),'$hora','$id_cliente','$totalpago','$pagoCambio','$cambio','$descuento','$totalganancia','$idVendedor','$tipopago')" );
			if (!$sql_elimnaringresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_factura order by id_factura DESC limit 1 " );
				$filafactura = mysqli_fetch_array($sql_ultimafactura);
				echo $id_factura = $filafactura['id_factura'];
			}

		}
		else
		{	
			$idVendedor=(int)$_SESSION['id'];
			$codigofactura = $codigo_factura + 1;
			if ($codigofactura>$filaRango['FinalFactura']) {
				echo "Numero Factura LLena";
			}else{
			$sql_elimnaringresos = mysqli_query ($link, "INSERT INTO tbl_factura VALUES (null,'$codigofactura','$id_empresa',current_date(),'$hora','$id_cliente','$totalpago','$pagoCambio','$cambio','$descuento','$totalganancia','$idVendedor','$tipopago')" );
			if (!$sql_elimnaringresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_factura order by id_factura DESC limit 1 " );
				$filafactura = mysqli_fetch_array($sql_ultimafactura);
				echo $id_factura = $filafactura['id_factura'];
			}
		
		}
	}
	}else if ($operacion == 'insertarfacturaProyecto')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
		$totalpago = $datos->totalpago;
		$id_proyecto = $datos->id;



		$sql_empresa = mysqli_query ($link, "SELECT * FROM tbl_empresa order by id_empresa DESC limit 1 " );
		$filaempresa = mysqli_fetch_array($sql_empresa);
		$id_empresa = $filaempresa['id_empresa'];

		$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_facturaproyecto order by id_facturaproyecto DESC limit 1 " );
		$filafactura = mysqli_fetch_array($sql_ultimafactura);
		$id_factura = $filafactura['id_facturaproyecto'];
		$codigo_factura = $filafactura['codigo_factura'];

		if (mysqli_num_rows($sql_ultimafactura) == 0)
		{
			$codigofactura = 100001;
			$sql_elimnaringresos = mysqli_query ($link, "INSERT INTO tbl_facturaproyecto VALUES (null,'$codigofactura','$id_proyecto','$id_empresa',current_date(),'$id_cliente','$totalpago')" );
			if (!$sql_elimnaringresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_facturaproyecto order by id_facturaproyecto DESC limit 1 " );
				$filafactura = mysqli_fetch_array($sql_ultimafactura);
				echo $id_factura = $filafactura['id_facturaproyecto'];
			}

		}
		else
		{	
			$codigofactura = $codigo_factura + 1;
			$sql_elimnaringresos = mysqli_query ($link, "INSERT INTO tbl_facturaproyecto VALUES (null,'$codigofactura','$id_proyecto','$id_empresa',current_date(),'$id_cliente','$totalpago')" );
			if (!$sql_elimnaringresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_facturaproyecto order by id_facturaproyecto DESC limit 1 " );
				$filafactura = mysqli_fetch_array($sql_ultimafactura);
				echo $id_factura = $filafactura['id_facturaproyecto'];
			}
		
		}
	}else if ($operacion == 'insertarcotizacion')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
		$totalpago = $datos->totalpago;



		$sql_empresa = mysqli_query ($link, "SELECT * FROM tbl_empresa order by id_empresa DESC limit 1 " );
		$filaempresa = mysqli_fetch_array($sql_empresa);
		$id_empresa = $filaempresa['id_empresa'];

		$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_cotizacion order by id_cotizacion DESC limit 1 " );
		$filafactura = mysqli_fetch_array($sql_ultimafactura);
		$id_factura = $filafactura['id_cotizacion'];
		$codigo_factura = $filafactura['codigo_cotizacion'];

		if (mysqli_num_rows($sql_ultimafactura) == 0)
		{
			$codigofactura = 100001;
			$sql_elimnaringresos = mysqli_query ($link, "INSERT INTO tbl_cotizacion VALUES (null,'$codigofactura','$id_empresa',current_date(),'$id_cliente','$totalpago')" );
			if (!$sql_elimnaringresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_cotizacion order by id_cotizacion DESC limit 1 " );
				$filafactura = mysqli_fetch_array($sql_ultimafactura);
				echo $id_factura = $filafactura['id_cotizacion'];
			}

		}
		else
		{	
			$codigofactura = $codigo_factura + 1;
			$sql_elimnaringresos = mysqli_query ($link, "INSERT INTO tbl_cotizacion VALUES (null,'$codigofactura','$id_empresa',current_date(),'$id_cliente','$totalpago')" );
			if (!$sql_elimnaringresos)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimafactura = mysqli_query ($link, "SELECT * FROM tbl_cotizacion order by id_cotizacion DESC limit 1 " );
				$filafactura = mysqli_fetch_array($sql_ultimafactura);
				echo $id_factura = $filafactura['id_cotizacion'];
			}
		
		}
	}
	else if ($operacion == 'insertarDetallecotizacion')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidad = $datos->cantidad;
		$valorTotal = $datos->valorTotal;
		$id_cotizacion = $datos->id_cotizacion;

		$sql_detallefactura = mysqli_query ($link, "INSERT INTO tbl_detallecotizacion VALUES (null,'$id_cotizacion','$id_producto','$cantidad','$valorTotal')" );
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo "exito";
			// $sql_cantidadinvetario = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
			// 	$filainvetario = mysqli_fetch_array($sql_cantidadinvetario);
			// 	$stock = $filainvetario['stock'];
				
			// 	$nuevoStock = $stock - $cantidad;
				
			// $sql_cantidadinvetario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevoStock' WHERE id_producto='$id_producto'" );

		}
	

	}else if ($operacion == 'insertarDetallefactura')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidadU = $datos->cantidadU;
		$cantidadF = $datos->cantidadF;
		$valorTotal = $datos->valorTotal;
		$id_factura = $datos->id_factura;
		$descuento = $datos->descuento;
		$sql_detallefactura = mysqli_query ($link, "INSERT INTO tbl_detallefactura VALUES (null,'$id_factura','$id_producto','$cantidadU','$cantidadF','$valorTotal','$descuento','Factura',current_date())" );
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo "exito";
			$sql_cantidadinvetario = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
				$filainvetario = mysqli_fetch_array($sql_cantidadinvetario);
				$sql_producto = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE id_producto='$id_producto' " );
				$filaiproducto = mysqlI_fetch_array($sql_producto);
				$fraccionProducto=$filaiproducto['fraccion'];
				$fraccion = $filainvetario['stock'];
				$unidad = $filainvetario['Unidad'];


			 
				
				
				if ($cantidadF>$fraccion) {
					if ($cantidadF<=$fraccionProducto) {
					$NuevaUnidad=$unidad-1;
					$newFraccion=$fraccionProducto+$fraccion -$cantidadF;
				
					}else if ($cantidadF>$fraccionProducto) {
						$divicion=$cantidadF/$fraccionProducto;
					$entero=floor($divicion);
					$residuo=$cantidadF%$fraccionProducto;
					if ($residuo!=0) {
						$entero=$entero+1;
						$NuevaUnidad=$unidad-$entero;
					$newFraccion=($fraccionProducto * $entero)+$fraccion -$cantidadF;
					
					}else{
						$NuevaUnidad=$unidad-$entero;
					$newFraccion=($fraccionProducto * $entero)+$fraccion -$cantidadF;
					}
				}
					
					}else{
					$NuevaUnidad=$unidad-$cantidadU;
					$newFraccion=$fraccion-$cantidadF;
				}
				
			$sql_cantidadinvetario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$newFraccion',Unidad='$NuevaUnidad' WHERE id_producto='$id_producto'" );

		}
	

	}else if ($operacion == 'insertarSerialfactura')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$id_serial = $datos->id_serial;
		
		$id_factura = $datos->id_factura;

		$sql_detallefactura = mysqli_query ($link, "INSERT INTO tbl_detallefacturaserial VALUES (null,'$id_factura','$id_producto','$id_serial')" );
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo "exito";
			
				
			$sql_cantidadinvetario = mysqli_query ($link, "UPDATE tbl_productoserial SET estado='Vendido' WHERE id_productoserial='$id_serial'" );

		}
	

	}else if ($operacion == 'insertarDetallefacturaProyecto')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidad = $datos->cantidad;
		$valorTotal = $datos->valorTotal;
		$id_factura = $datos->id_factura;

		$sql_detallefactura = mysqli_query ($link, "INSERT INTO tbl_detallefacturaproyecto VALUES (null,'$id_factura','$id_producto','$cantidad','$valorTotal')" );
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo "exito";
			$sql_cantidadinvetario = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
				$filainvetario = mysqli_fetch_array($sql_cantidadinvetario);
				$stock = $filainvetario['stock'];
				
				$nuevoStock = $stock - $cantidad;
				
			$sql_cantidadinvetario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevoStock' WHERE id_producto='$id_producto'" );

		}
	

	}
	else if ($operacion == 'verificarstock_producto')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_producto = $datos->id_producto;
		$cantidadU = $datos->cantidadU;
		$cantidadF = $datos->cantidadF;

		$sql_cantidadinvetario = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
				// $filainvetario = mysqli_fetch_array($sql_cantidadinvetario);
				// echo $stock = $filainvetario['stock'];

				$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_cantidadinvetario))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
	}
}
else if ($variable == 'inventario') 
{
	if ($operacion == 'inventarioXprodcito') 
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
	
		$sql_inventarioXproducto = mysqli_query ($link, "SELECT p.*,p.descripcion,p.codigo_producto,c.nombre_categoria,i.stock,i.* FROM tbl_producto p,tbl_categoria c, tbl_inventario i WHERE i.id_producto=p.id_producto and p.id_categoria=c.id_categoria and p.id_producto='$id_producto'" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_inventarioXproducto))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'tododinero') 
	{
		
	
		$sql_inventarioXproducto = mysqli_query ($link, "SELECT pro.valor ,pro.valor_venta,inv.Unidad, inv.stock, (pro.valor/pro.fraccion) * inv.stock as ValorTotalF, pro.valor * inv.Unidad as ValorTotalU, pro.valor_unidad * inv.stock as valorVentaF,sum(pro.valor * inv.Unidad) as ValorTotalUnidad ,sum((pro.valor/pro.fraccion )* inv.stock) as ValorTotalFraccion,  sum( pro.valor_venta * inv.Unidad) as valorVentaUnidad,sum( pro.valor_unidad * inv.stock) as valorVentaFraccion,sum(inv.stock) as stockNum,sum(inv.Unidad) as unidadNum  from tbl_producto pro, tbl_inventario inv WHERE pro.id_producto=inv.id_producto" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_inventarioXproducto))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'tododineroAbono') 
	{
		
	
		$sql_inventarioXproducto = mysqli_query ($link, "SELECT  * FROM tbl_credito " );	

		// $sql_inventarioXproducto = mysqli_query ($link, "SELECT pro.valor ,pro.valor_venta, inv.stock, pro.valor * inv.stock as ValorTotal, pro.valor_venta * inv.stock as valorVenta,sum(pro.valor * inv.stock) as ValorTotal2 , sum( pro.valor_venta * inv.stock) as valorVenta2,sum(inv.stock) as stockNum,sum(inv.Unidad) as unidadNum  from tbl_producto pro, tbl_inventario inv WHERE pro.id_producto=inv.id_producto" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_inventarioXproducto))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'tododineroSemana') 
	{
		

		$date = date("d-m-Y");
		
//Restando 2 dias
$mod_date = strtotime($date."- 7 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(total_pago) as TotalSemana, sum(f.descuento) as ValorSemanaDescuento FROM tbl_detallefactura df, tbl_factura f WHERE f.id_factura=df.id_factura and  f.fecha_factura<= '$fechaHoy' and f.fecha_factura>='$fechaAtras'" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'tododineroAyer') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 1 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.codigo_factura,f.fecha_factura,f.valor_pago, pro.descripcion,SUM(df.total_pago) as TotalPago,f.ganacia,SUM(df.cantidad)  as cantidad,SUM(df.cantidadFraccion) as cantidadFraccion  FROM tbl_factura f, tbl_empresa em,tbl_detallefactura df, tbl_producto pro WHERE f.id_empresa=em.id_empresa and df.id_factura=f.id_factura and df.id_producto=pro.id_producto and f.fecha_factura='$fechaAtras' GROUP BY(pro.descripcion)" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDiasDescuento') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 1 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(descuento) as descuento  FROM tbl_factura WHERE fecha_factura='$fechaHoy'" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDiasGanancias') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 1 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(ganacia) as ganancia  FROM tbl_factura WHERE fecha_factura='$fechaHoy'" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDias') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 1 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT pro.id_producto,SUM(f.descuento) as descuentoTo,df.descuento,f.codigo_factura,f.fecha_factura,f.valor_pago,pro.fraccion,pro.descripcion,SUM(df.total_pago) as TotalPago,f.ganacia,SUM(df.cantidad)  as cantidad,SUM(df.cantidadFraccion) as cantidadFraccion  FROM tbl_factura f, tbl_empresa em,tbl_detallefactura df, tbl_producto pro WHERE f.id_empresa=em.id_empresa and df.id_factura=f.id_factura and df.id_producto=pro.id_producto and f.fecha_factura='$fechaHoy' GROUP BY(pro.descripcion) " );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDiasGana') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 1 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT ganacia FROM tbl_factura WHERE fecha_factura='$fechaHoy'" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDiasFecha') 
	{
		$datos = json_decode(file_get_contents("php://input"));
		$fecha_inicio=$datos->fecha_inicio;
		$fecha_final=$datos->fecha_final;

		
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT f.*,pro.*,f.codigo_factura,f.fecha_factura,f.valor_pago, pro.descripcion,SUM(df.total_pago) as TotalPago,f.ganacia,SUM(df.cantidad)  as cantidad,SUM(df.cantidadFraccion) as cantidadFraccion  FROM tbl_factura f, tbl_empresa em,tbl_detallefactura df, tbl_producto pro WHERE f.id_empresa=em.id_empresa and df.id_factura=f.id_factura and df.id_producto=pro.id_producto and f.fecha_factura>='$fecha_inicio' and f.fecha_factura<='$fecha_final' GROUP BY(pro.descripcion)" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDiasDescuentoFechas') 
	{
		$datos = json_decode(file_get_contents("php://input"));
		$fecha_inicio=$datos->fecha_inicio;
		$fecha_final=$datos->fecha_final;

		
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(descuento) as descuento  FROM tbl_factura  WHERE fecha_factura>='$fecha_inicio' and fecha_factura<='$fecha_final' " );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'ventaDelDiasFechaGanancia') 
	{
		$datos = json_decode(file_get_contents("php://input"));
		$fecha_inicio=$datos->fecha_inicio;
		$fecha_final=$datos->fecha_final;

		
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(ganacia) as ganancia  FROM tbl_factura  WHERE fecha_factura>='$fecha_inicio' and fecha_factura<='$fecha_final' " );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			
			
			mysqli_close($link);

	}else if ($operacion == 'tododineroMes') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 30 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(total_pago) as TotalMes, sum(f.descuento) as ValorMesDescuento FROM tbl_detallefactura df, tbl_factura f WHERE f.id_factura=df.id_factura and  f.fecha_factura<= '$fechaHoy' and f.fecha_factura>='$fechaAtras'" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}else if ($operacion == 'tododineroAnno') 
	{
		

		$date = date("d-m-Y");
//Restando 2 dias
$mod_date = strtotime($date."- 365 days");
$fechaAtras= date("Y-m-d",$mod_date);
	$fechaHoy= date("Y-m-d");
	$sql_listado_facturaxfecha = mysqli_query ($link, "SELECT sum(total_pago) as TotalAnno, sum(f.descuento) as TotalAnnoDescuento  FROM tbl_detallefactura df, tbl_factura f WHERE f.id_factura=df.id_factura and  f.fecha_factura<= '$fechaHoy' and f.fecha_factura>='$fechaAtras'" );

			
	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listado_facturaxfecha))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);

	}
	else if ($operacion == "catergoriaProductorBusqueda") 
	{
		$sql_listadocateroriasProduct = mysqli_query ($link, "SELECT * from tbl_categoria" );	

	
			$rows = array();
			while ($respuesta = mysqli_fetch_assoc($sql_listadocateroriasProduct))
			{
				$rows[] = $respuesta;
			}

			echo $rows = json_encode($rows);
			mysqli_close($link);
	}
}
if ($variable == "categoria")
{
	if ($operacion == 'insertar')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$nombreCategoria=$datos->nombreCategoria;

		
		
		
			$Insert_categoria = mysqli_query ($link, "INSERT INTO  tbl_categoria VALUES (null,'$nombreCategoria')" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
	
	if ($operacion == 'insertarProyectoSQL')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$nombreProyecto=$datos->nombreProyecto;
		$idCliente=$datos->idCliente;
		$manoObra=$datos->manoObra;

		
		
		
			$Insert_categoria = mysqli_query ($link, "INSERT INTO  tbl_proyecto VALUES (null,'$nombreProyecto','$idCliente','$manoObra',current_date(),'EN PROCESO')" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
	
	
	else if ($operacion == 'listadodeCategoria')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_categoria" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == 'listadodeCajas')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_usuario_sistema" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'listadodeProveedor')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_proveedor" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'listadodeIva')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_iva" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'listadodeProyecto')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_proyecto p, tbl_cliente c WHERE p.cliente=c.id_cliente" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == "actualizandoCategoria")
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_categoria = $datos->id_categoriaActualizar;
		$nombre_categoria = $datos->nombreCategoriaActualizar;
		

		
			$Insert_categoria = mysqli_query ($link, "UPDATE  tbl_categoria SET nombre_categoria= '$nombre_categoria' WHERE id_categoria='$id_categoria'" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
	}else if ($operacion == "actualizandoEstadoSQl")
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id = $datos->id;
		$estado = $datos->estado;
		

		
			$Insert_categoria = mysqli_query ($link, "UPDATE  tbl_proyecto SET estado= '$estado' WHERE id_proyecto='$id'" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
				
				
				
	}
	else if ($operacion == "eliminarcategoria")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id = $datos->idEliminarCategoria; 
		
			$updateCategoria = mysqli_query ($link, "UPDATE tbl_producto SET id_categoria='1' WHERE id_categoria='$id'" );


		$eliminarcategoria = mysqli_query ($link, "DELETE  FROM tbl_categoria WHERE 	id_categoria='$id'" );
			if (!$eliminarcategoria)
			{
				echo "fallo";
			}
			else
			{
				echo "exito";	
			}
	}

}


// ==========================================================================//

if ($variable == "empresa")
{
	if ($operacion == 'insertar')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$nitEmpresa=$datos->nitEmpresa;
		$nombreEmpresa=$datos->nombreEmpresa;
		$direccionEmpresa=$datos->direccionEmpresa;
		$telefonoEmpresa=$datos->telefonoEmpresa;

		
		
		
			$Insert_empresa = mysqli_query ($link, "INSERT INTO  tbl_empresa VALUES (null,'$nitEmpresa','$nombreEmpresa','$direccionEmpresa','$telefonoEmpresa')" );
				if (!$Insert_empresa)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
	
	
	else if ($operacion == 'listadodeEmpresa')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_empresa" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == "actualizandoEmpresa")
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_empresa = $datos->id_empresaActualizar;
		$nombre_empresa = $datos->nombreEmpresaActualizar;
		$nit_empresa = $datos->nitEmpresactualizar;
		
	
		
			$Upadate_empresa = mysqli_query ($link, "UPDATE  tbl_empresa SET nit_empresa= '$nit_empresa', nombre_empresa='$nombre_empresa' WHERE id_empresa='$id_empresa'" );
				if (!$Upadate_empresa)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
	}
	else if ($operacion == "eliminarempresa")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id = $datos->idEliminarEmpresa; 
		

		$eliminarempresa = mysqli_query ($link, "DELETE  FROM tbl_empresa WHERE 	id_empresa='$id'" );
			if (!$eliminarempresa)
			{
				echo "fallo";
			}
			else
			{
				echo "exito";	
			}
	}

}

// ==========================================================================//
if($variable == "egreso"){

	if ($operacion == 'insertarTegreso')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$nombreEgreso=$datos->nombreEgreso;
		$codigoEgreso=$datos->codigoEgreso;
		$concepto=$datos->concepto;

		
		
		
			$Insert_categoria = mysqli_query ($link, "INSERT INTO  tbl_tipoegreso VALUES (null,'$codigoEgreso','$nombreEgreso','$concepto')" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}


if ($operacion == 'egreso')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$idtipoEgreso=$datos->idTipoEgreso;
		$valorEgreso=$datos->valorEgreso;
		$pagado=$datos->pagado;
		$mes=$datos->mes;

		
		
		
			$Insert_categoria = mysqli_query ($link, "INSERT INTO  tbl_egresos VALUES (null,'$idtipoEgreso','$pagado','$valorEgreso',current_date(),'$mes')" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
	
	if ($operacion == 'egresoProyecto')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$pagado=$datos->pagadoProyecto;
		$valor=$datos->valorEgresoProyecto;
		$idpro=$datos->idpro;
		

		
		
		
			$Insert_categoria = mysqli_query ($link, "INSERT INTO  tbl_egresoproyecto VALUES (null,'PAGO POR SERVICIO','$pagado','$valor',current_date(),'$idpro')" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
	
	
	 if ($operacion == 'listadodeEgreso')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_tipoegreso ORDER BY id_tipoEgreso DESC" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}

else if ($operacion == 'listadodeegresos')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_egresos e, tbl_tipoegreso te WHERE e.id_tipoEgreso=te.id_tipoEgreso  ORDER BY e.id_egreso DESC" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}


}

// ==========================================================================//

if ($variable == "cliente")
{
	if ($operacion == 'insertar')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$ccCliente=$datos->ccCliente;
		$nombreCliente=$datos->nombreCliente;
		$direccionCliente=$datos->direccionCliente;
		$telefonoCliente=$datos->telefonoCliente;

		
		$verificarCodigoProducto=mysqli_query ($link, "SELECT cc_cliente FROM tbl_cliente WHERE cc_cliente='$ccCliente'" );
		if(mysqli_num_rows($verificarCodigoProducto)>0){
			echo "duplicado";

		}else {

		
			$Insert_empresa = mysqli_query ($link, "INSERT INTO  tbl_cliente VALUES (null,'$ccCliente','$nombreCliente','$direccionCliente','$telefonoCliente')" );
				if (!$Insert_empresa)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
	}
	
	
	else if ($operacion == 'listadodeClientes')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_cliente" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == "actualizandoClientes")
	{
		$datos = json_decode(file_get_contents("php://input"));
;
		$id=$datos->id_clienteActualizar;
		$cc=$datos->ccClienteActualizar;
		$nombre=$datos->nombreClienteActualizar;
		$direccion=$datos->direccionClienteActualizar;
		$telefono=$datos->telefonoClienteActualizar;
		
	
		
			$Upadate_empresa = mysqli_query ($link, "UPDATE  tbl_cliente SET cc_cliente= '$cc', nombre_cliente='$nombre', direccion='$direccion',telefono='$telefono' WHERE id_cliente='$id'" );
				if (!$Upadate_empresa)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
	}
	else if ($operacion == "eliminarcliente")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id = $datos->idEliminarCliente; 
		

		$eliminarempresa = mysqli_query ($link, "DELETE  FROM tbl_cliente WHERE 	id_cliente='$id'" );
			if (!$eliminarempresa)
			{
				echo "fallo";
			}
			else
			{
				echo "exito";	
			}
	}

}

// ==========================================================================//

if ($variable == "producto")
{
	if ($operacion == 'insertar')
	{
		$datos = json_decode(file_get_contents("php://input"));
		
		$CodigoProducto=$datos->CodigoProducto;
		$CodigoBarras=$datos->CodigBarras;
		$DescripcionProducto=$datos->DescripcionProducto;
		$presentacion=$datos->presentacion;
		$marca=$datos->marcaProducto;
		$idProveedor=$datos->idProveedor;
		$idCategoria=$datos->idCategoria;
		$unidadCerrada=$datos->unidadCerrada;
		$fraccion=$datos->fraccion;
		$idIva=$datos->idIva;
		$idSeccion=$datos->idSeccion;
		$valorProducto=$datos->valorProducto;
		$valorVentaProducto=$datos->valorVentaProducto;
		$valorVentaProductoUnidad=$datos->valorVentaProductoUnidad;
		$stockMin=$datos->stockMin;
		$renta=$datos->renta;
		$editable=$datos->editable;
		$CodigoProductoFALSO=-10;
		// $serial=$datos->serialProducto;
			if ($idSeccion=="") {
				$idSeccion=1;
			}
		$Insert_empresa = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE codigo_producto='$CodigoProductoFALSO'" );

		if (mysqli_fetch_row($Insert_empresa)>0) {
			echo "duplicadoCodigo";
		}else{


			$codigoProd=mysqli_query ($link, "SELECT codigo_producto FROM tbl_producto ORDER BY codigo_producto DESC limit 1" );
			$codigo=mysqli_fetch_array($codigoProd);
				$CodigoProducto=$codigo[0]+1;
			$Insert_empresa = mysqli_query ($link, "INSERT INTO  tbl_producto VALUES(null,'$CodigoProducto','$CodigoBarras',null,null,'$DescripcionProducto','$presentacion','$marca','$idProveedor','$idCategoria','$idIva','$idSeccion','$unidadCerrada','$fraccion','$valorProducto','$valorVentaProducto','$valorVentaProductoUnidad','$renta','$stockMin','$editable')" );
				if (!$Insert_empresa)
				{
					echo "fallo";
				}
				else
				{
				$sql_ultimoproducto = mysqli_query ($link, "SELECT * FROM tbl_producto ORDER by id_producto DESC limit 1 " );
				$filaproducto = mysqli_fetch_array($sql_ultimoproducto);
				$id_producto=$filaproducto['id_producto'];
				$Insertar_inventario=mysqli_query ($link, "INSERT INTO tbl_inventario VALUES(null,'$id_producto',0,0,0,0,current_date())" );
					if(!$Insertar_inventario){
						echo "fallo2";
					}else{

						echo "exito";
					}
				} 
		}
	}
	if ($operacion == 'insertarSeccionD')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$seccion=$datos->seccion;

		
		
		
			$Insert_categoria = mysqli_query ($link, "INSERT INTO  tbl_seccion VALUES (null,'$seccion')" );
				if (!$Insert_categoria)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
		}
		else if ($operacion == 'listadodeSeccion')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM  tbl_seccion" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	
	if ($operacion == 'insertarProveedor')
	{
		$datos = json_decode(file_get_contents("php://input"));
		
		$CodigoProveedor=$datos->CodigoProveedor;
		$NombreProveedor=$datos->NombreProveedor;
		$responsable=$datos->responsable;
		$direccionProveedor=$datos->direccionProveedor;
		$telefonoProveedor=$datos->telefonoProveedor;
		$departamento=$datos->departamento;
		
		$rentabilidad=$datos->rentabilidad;
		$diasPago=$datos->diasPago;
		
		// $serial=$datos->serialProducto;

		
		$verificarCodigoProducto=mysqli_query ($link, "SELECT codigo_proveedor FROM tbl_proveedor WHERE codigo_proveedor='$CodigoProveedor'" );
		if(mysqli_num_rows($verificarCodigoProducto)>0){
			echo "duplicado";

		}else {

		
			$Insert_empresa = mysqli_query ($link, "INSERT INTO  tbl_proveedor VALUES(null,'$CodigoProveedor','$NombreProveedor','$responsable','$direccionProveedor','$telefonoProveedor','$departamento',1,'$rentabilidad','$diasPago')" );
				if (!$Insert_empresa)
				{
					echo "fallo";
				}
				else
				{
				echo "exito";
				} 
		}
	}
	
	else if ($operacion == 'listadodeProductos')
	{
		$sql_listadoProducto = mysqli_query ($link, "SELECT sec.*,p.valor_venta*i.iva/100 as ivaValor, p.*,c.*,i.*,pro.*,inv.* FROM tbl_producto p, tbl_categoria c, tbl_iva i,tbl_proveedor pro,tbl_inventario inv,tbl_seccion sec WHERE inv.id_producto=p.id_producto and p.id_categoria=c.id_categoria and i.id_iva=p.id_iva and sec.id_seccion=p.id_seccion and pro.id_proveedor=p.id_proveedor ORDER BY p.descripcion ASC" );
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == 'listadodeProductosBarra')
	{
		$datos = json_decode(file_get_contents("php://input"));
			$barra=$datos->barra;	

		$sql_listadoProducto = mysqli_query ($link, "SELECT p.valor_venta*i.iva/100 as ivaValor, p.*,c.*,i.*,pro.*,inv.* FROM tbl_producto p, tbl_categoria c, tbl_iva i,tbl_proveedor pro,tbl_inventario inv WHERE inv.id_producto=p.id_producto and p.id_categoria=c.id_categoria and i.id_iva=p.id_iva and pro.id_proveedor=p.id_proveedor and p.descripcion like '$barra%' ORDER BY p.descripcion ASC" );
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
else if ($operacion == 'listadoPorProducto')
	{
		
 
		
		$sql_listadoProducto = mysqli_query ($link, "SELECT * FROM tbl_producto " );


		
		$rows = array();

		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{


			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == 'listadoPorOrdenFechaProductoTopOperacionGlobal')
	{
		
 $fechaAtras= date('Y-m-d', strtotime('-1 week')) ;
		// $fechaHoy= date("Y-m-d");
		$sql_listadoProducto = mysqli_query ($link, "SELECT iv.*,pro.*,pro.valor_venta*iv.iva/100 as ivaValor,pro.editableValor,pro.id_producto,SUM(f.descuento) as descuentoTo,df.descuento,f.codigo_factura,f.fecha_factura,f.valor_pago,pro.fraccion,pro.descripcion,SUM(df.total_pago) as TotalPago,f.ganacia,SUM(df.cantidad)  as cantidad,SUM(df.cantidadFraccion) as cantidadFraccion  FROM tbl_factura f, tbl_empresa em,tbl_detallefactura df, tbl_producto pro,tbl_iva iv WHERE f.id_empresa=em.id_empresa and df.id_factura=f.id_factura and iv.id_iva=pro.id_iva and df.id_producto=pro.id_producto  GROUP BY(pro.descripcion) ORDER BY cantidad DESC limit 10"  );


		
		$rows = array();

		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{


			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == 'listadoPorOrdenFechaProductoTopOperacion')
	{
		
 $fechaAtras= date('Y-m-d', strtotime('-1 week')) ;
		// $fechaHoy= date("Y-m-d");
		$sql_listadoProducto = mysqli_query ($link, "SELECT iv.*,pro.*,pro.valor_venta*iv.iva/100 as ivaValor,pro.editableValor,pro.id_producto,SUM(f.descuento) as descuentoTo,df.descuento,f.codigo_factura,f.fecha_factura,f.valor_pago,pro.fraccion,pro.descripcion,SUM(df.total_pago) as TotalPago,f.ganacia,SUM(df.cantidad)  as cantidad,SUM(df.cantidadFraccion) as cantidadFraccion  FROM tbl_factura f, tbl_empresa em,tbl_detallefactura df, tbl_producto pro,tbl_iva iv WHERE f.id_empresa=em.id_empresa and df.id_factura=f.id_factura and iv.id_iva=pro.id_iva and df.id_producto=pro.id_producto and f.fecha_factura='$fechaAtras' GROUP BY(pro.descripcion) ORDER BY cantidad DESC limit 5"  );


		
		$rows = array();

		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{


			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == 'listadodeProductosChange')
	{

		$datos = json_decode(file_get_contents("php://input"));
			$barra=$datos->barra;	
		$sql_listadoProducto = mysqli_query ($link, "SELECT p.valor_venta*i.iva/100 as ivaValor, p.*,c.*,i.*,pro.* FROM tbl_producto p, tbl_categoria c, tbl_iva i,tbl_proveedor pro WHERE p.id_categoria=c.id_categoria and i.id_iva=p.id_iva and pro.id_proveedor=p.id_proveedor and p.codigo_barras='$barra' or p.codigo_barrasUno='$barra' or p.codigo_barrasDos='$barra'"  );
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}else if ($operacion == 'listadodeProductosChangeLetra')
	{

		$datos = json_decode(file_get_contents("php://input"));
			$barra=$datos->barra;	
		$sql_listadoProducto = mysqli_query ($link, "SELECT p.valor_venta*i.iva/100 as ivaValor, p.*,c.*,i.*,pro.* FROM tbl_producto p, tbl_categoria c, tbl_iva i,tbl_proveedor pro WHERE p.id_categoria=c.id_categoria and i.id_iva=p.id_iva and pro.id_proveedor=p.id_proveedor and p.descripcion LIKE '%".$barra."%'"  );
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
else if ($operacion == 'listadodeProductoskeypress')
	{

		$datos = json_decode(file_get_contents("php://input"));
			$codigo=$datos->codigo;	
		$sql_listadoProducto = mysqli_query ($link, "SELECT p.valor_venta*i.iva/100 as ivaValor, p.*,c.*,i.*,pro.* FROM tbl_producto p, tbl_categoria c, tbl_iva i,tbl_proveedor pro WHERE p.id_categoria=c.id_categoria and i.id_iva=p.id_iva and pro.id_proveedor=p.id_proveedor and p.codigo_producto='$codigo' "  );
		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_listadoProducto))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}

	else if ($operacion == 'listadodeProveedor')
	{
		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM tbl_proveedor" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}


	else if ($operacion == 'listadodeEgresoProyecto')

	{

			$datos = json_decode(file_get_contents("php://input"));
			$id=$datos->id;	

		$sql_todoCategoria =  mysqli_query ($link, "SELECT * FROM tbl_egresoproyecto WHERE id_proyecto='$id'" );

		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_todoCategoria))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == "actualizandoProducto")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_producto=$datos->id_ProductoActualizar;
		$CodigoProducto=$datos->CodigoProducto;
		$CodigoBarras=$datos->CodigBarras;
		$CodigoBarrasU=$datos->CodigBarrasU;
		$CodigoBarrasD=$datos->CodigBarrasD;
		$DescripcionProducto=$datos->DescripcionProducto;
		$presentacion=$datos->presentacion;
		$marca=$datos->marcaProducto;
		$idProveedor=$datos->idProveedor;
		$idCategoria=$datos->idCategoria;
		$idIva=$datos->idIva;
		$idSeccion=$datos->idSeccion;
		$unidadCerrada=$datos->unidadCerrada;
		$fraccion=$datos->fraccion;
		$valorProducto=$datos->valorProducto;
		$valorVentaProducto=$datos->valorVentaProducto;
		$valorUnidadProducto=$datos->valorUnidadProducto;
		$stockMin=$datos->stockMin;
		$rentabilidad=$datos->rentabilidad;

		// $verificarCodigoProducto=mysqli_query ($link, "SELECT codigo_producto FROM tbl_producto WHERE codigo_producto='$CodigoProducto' OR codigo_barras='$CodigoBarras' AND id_producto!='$id_producto'" );
		// if(mysqli_num_rows($verificarCodigoProducto)>0){
		// 	echo "duplicado";

		// }else {

	
		
			$Upadate_producto = mysqli_query ($link, "UPDATE  tbl_producto SET  codigo_producto= '$CodigoProducto',codigo_barras='$CodigoBarras',codigo_barrasUno='$CodigoBarrasU',codigo_barrasDos='$CodigoBarrasD',descripcion='$DescripcionProducto',presentacion='$presentacion',marca='$marca',id_proveedor='$idProveedor',id_categoria='$idCategoria',id_iva='$idIva',id_seccion='$idSeccion',unidadCerrada='$unidadCerrada',fraccion='$fraccion',valor='$valorProducto', valor_venta='$valorVentaProducto' , valor_unidad='$valorUnidadProducto',stockMinimo='$stockMin',rentabilidad='$rentabilidad' WHERE id_producto='$id_producto'" );
				if (!$Upadate_producto)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
			// }
	}
	else if ($operacion == "actualizandoProveedor")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_proveedor=$datos->id_proveedor;
		$CodigoProveedor=$datos->CodigoProveedor;
		$NombreProveedor=$datos->NombreProveedor;
		$responsable=$datos->responsable;
		$direccionProveedor=$datos->direccionProveedor;
		$telefonoProveedor=$datos->telefonoProveedor;
		$departamento=$datos->departamento;
		$estado=$datos->estado;
		$rentabilidad=$datos->rentabilidad;
		$diasPago=$datos->diasPago;

		// $verificarCodigoProducto=mysqli_query ($link, "SELECT codigo_producto FROM tbl_producto WHERE codigo_producto='$CodigoProducto' OR codigo_barras='$CodigoBarras' AND id_producto!='$id_producto'" );
		// if(mysqli_num_rows($verificarCodigoProducto)>0){
		// 	echo "duplicado";

		// }else {

	
		
			$Upadate_producto = mysqli_query ($link, "UPDATE  tbl_proveedor SET  codigo_proveedor='$CodigoProveedor',nombre_proveedor='$NombreProveedor',responsable='$responsable',direccion='$direccionProveedor',telefono='$telefonoProveedor',Departamento='$departamento',estado='$estado',rentabilidadpro='$rentabilidad',diasPago='$diasPago' WHERE id_proveedor='$id_proveedor'" );
				if (!$Upadate_producto)
				{
					echo "fallo";
				}
				else
				{
					echo "exito";
				} 
			// }
	}
	else if ($operacion == "eliminarproducto")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id = $datos->idEliminarProducto; 
		

		$eliminarempresa = mysqli_query ($link, "DELETE  FROM tbl_producto WHERE id_producto='$id'" );
			if (!$eliminarempresa)
			{
				echo "fallo";
			}
			else
			{
				echo "exito";	
			}
	}
else if ($operacion == "eliminarproveedor")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id = $datos->idEliminarProveedor; 
		

		$eliminarempresa = mysqli_query ($link, "DELETE  FROM tbl_proveedor WHERE id_proveedor='$id'" );
			if (!$eliminarempresa)
			{
				echo "fallo";
			}
			else
			{
				echo "exito";	
			}
	}


}

// ===========================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================
	


else if ($variable == "credito")
{

	if ($operacion == 'noCreditoList') {
		
		$sql_ultimacredito = mysqli_query ($link, "SELECT * FROM tbl_credito order by id_credito DESC limit 1 " );
		$filacredito = mysqli_fetch_array($sql_ultimacredito);
		 $codigocredito = $filacredito['codigoCredito'];
		 echo $codigocredito +1;
	}

	if ($operacion == 'insertarcredito')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
		$totalapagar_plansepare = $datos->totalapagar_plansepare;

		$fecha_inicioPlansepare = $datos->fecha_inicioPlansepare;
		$fechaFin_plansepare = $datos->fechaFin_plansepare;
		$valor_aumento = $datos->valor_aumento;

		$sumapago = $valor_aumento + $totalapagar_plansepare;

		$sql_ultimacredito = mysqli_query ($link, "SELECT * FROM tbl_credito order by id_credito DESC limit 1 " );
		$filacredito = mysqli_fetch_array($sql_ultimacredito);
		 $codigocredito = $filacredito['codigoCredito']+1;

		$estadoproducto = "No Entregado";
			$sql_insertar_credito = mysqli_query ($link, "INSERT INTO tbl_credito VALUES (null,'$codigocredito','$id_cliente','$valor_aumento','$sumapago','$sumapago','$fecha_inicioPlansepare','$fechaFin_plansepare','$estadoproducto')" );
			if (!$sql_insertar_credito)
			{
				echo "fallo";
			}
			else
			{
				// echo "exito";
				$sql_ultimacredito = mysqli_query ($link, "SELECT * FROM tbl_credito order by id_credito DESC limit 1 " );
				$filacredito = mysqli_fetch_array($sql_ultimacredito);
				echo $id_credito = $filacredito['id_credito'];

				$id_cliente = $filacredito['id_cliente'];

				$sql_guardar_pago = mysqli_query ($link, "INSERT INTO tbl_abonos_credito VALUES(null,'$id_credito','$id_cliente',0,current_date())" );
			}
		
	}
	else if ($operacion == 'busquedaDetallaCuotas_Planes')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_credito = $datos->id_credito;

		$sql_lisdetallepagosplansepare = mysqli_query ($link, "SELECT dpl.cantidad,dpl.cantidadFraccion,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_credito,abp.valor_abono,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.total_pagosepare,pla.estadoproductos,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_credito abp WHERE abp.id_credito=pla.id_credito and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_credito='$id_credito' GROUP BY dpl.id_producto" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_lisdetallepagosplansepare))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'busquedaDetalle_Planes')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_credito = $datos->id_credito;

		$sql_lisdetallepagosplansepare = mysqli_query ($link, "SELECT abp.fecha_abono,abp.id_abonos_credito,abp.valor_abono,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,cl.cc_cliente,cl.nombre_cliente FROM tbl_credito pla, tbl_cliente cl, tbl_abonos_credito abp WHERE abp.id_credito=pla.id_credito and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and  pla.id_credito='$id_credito'" );	


		$rows = array();
		while ($respuesta = mysqli_fetch_assoc($sql_lisdetallepagosplansepare))
		{
			$rows[] = $respuesta;
		}

		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'actualizacionCuotaplansepare')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$cuotaanterior = $datos->cuotaanterior;
		$id_abonos_credito = $datos->id_abonos_credito;
		$id_credito = $datos->id_credito;
		$nuevacuota = $datos->nuevacuota;
		$descuento_abonos = $datos->descuento_abonos;

		$descuentoresta = $descuento_abonos + $cuotaanterior;
		$descuentorestados = $descuentoresta - $nuevacuota;

		$sql_actualizarPla = mysqli_query ($link, "UPDATE tbl_credito SET descuento_abonos='$descuentorestados' WHERE id_credito='$id_credito'" );
		if (!$sql_actualizarPla)
		{
			echo "erro1";
		}
		else
		{
			$sql_actualizarcuota = mysqli_query ($link, "UPDATE  tbl_abonos_credito SET valor_abono='$nuevacuota' WHERE id_abonos_credito='$id_abonos_credito'" );
			if (!$sql_actualizarcuota)
			{
				echo $id_credito;
			}
			else
			{
				echo "exito";
			}
		}




	}
	else if ($operacion == 'busquedaCreditoPorfechaRango')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;
		
		$sql_listadocreditos = mysqli_query ($link, "SELECT pla.codigoCredito, pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.estadoproductos,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.fecha_inicio>='$fechaInicialPansepare' and pla.fecha_inicio<='$fechaFinalPansepare' GROUP by pla.id_credito" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadocreditos))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"codigoCredito" => $respuesta['codigoCredito'],"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_credito" => $respuesta['id_credito'],"valor_aumeto" => $respuesta['valor_aumeto'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}

	else if ($operacion == 'busquedaCreditoListo')
	{
		
		
		
		$sql_listadocreditos = mysqli_query ($link, "SELECT pla.codigoCredito,pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.estadoproductos,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria GROUP by pla.id_credito" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadocreditos))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"codigoCredito" => $respuesta['codigoCredito'],"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_credito" => $respuesta['id_credito'],"valor_aumeto" => $respuesta['valor_aumeto'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}

	else if ($operacion == 'busquedaCreditoPorcodigo')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$codigoCredito = $datos->codigoCredito;
		
		
		$sql_listadocreditos = mysqli_query ($link, "SELECT pla.codigoCredito,pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.estadoproductos,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.codigoCredito='$codigoCredito' GROUP by pla.id_credito" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadocreditos))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"codigoCredito" => $respuesta['codigoCredito'],"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_credito" => $respuesta['id_credito'],"valor_aumeto" => $respuesta['valor_aumeto'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
else if ($operacion == 'busquedaCreditoPorCliente')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_Cliente = $datos->id_Cliente;
		
		
		$sql_listadocreditos = mysqli_query ($link, "SELECT pla.codigoCredito,pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.estadoproductos,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_Cliente' GROUP by pla.id_credito" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadocreditos))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"codigoCredito" => $respuesta['codigoCredito'],"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_credito" => $respuesta['id_credito'],"valor_aumeto" => $respuesta['valor_aumeto'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}

	else if ($operacion == 'eliminado_plansepare')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$estadoproductos = $datos->estadoproductos;


		$sql_BUSCARABONOS = mysqli_query ($link, "SELECT * FROM  tbl_abonos_plansepare WHERE id_plansepare='$id_plansepare'" );	
		if (mysqli_num_rows($sql_BUSCARABONOS) == 0)
		{
			if ($estadoproductos == 'Entregado')
				{
					
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );

					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];

				    	$buscarproductosInve = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );
				    	$filainventario = mysqli_fetch_array($buscarproductosInve);
				    	$id_inventario = $filainventario['id_inventario'];
				    	$stockinven = $filainventario['stock'];
				    	$nuevostock = $stockinven + $cantidad; 

				    	$sqlAtualizainventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );

				    	if (!$sqlAtualizainventario)
				    	{
				    		echo "error2";
				    	}
				    	else
				    	{
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );
				    	}
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }

				}
				else
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );


					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];
			    	
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );			    	
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }
				}
		}
		else
		{
			$sql_eliminarabonos = mysqli_query ($link, "DELETE FROM tbl_abonos_plansepare WHERE id_plansepare='$id_plansepare'" );	
			if (!$sql_eliminarabonos)
			{
				echo "error1";
			}
			else
			{
				if ($estadoproductos == 'Entregado')
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );
					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];

				    	$buscarproductosInve = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto'" );
				    	$filainventario = mysqli_fetch_array($buscarproductosInve);
				    	$id_inventario = $filainventario['id_inventario'];
				    	$stockinven = $filainventario['stock'];
				    	$nuevostock = $stockinven + $cantidad; 

				    	$sqlAtualizainventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );

				    	if (!$sqlAtualizainventario)
				    	{
				    		echo "error2";
				    	}
				    	else
				    	{
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );
				    	}
				    }

				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }

				}
				else
				{
					$sqlplanseparedetalle =  mysqli_query ($link, "SELECT dpl.id_detalle_plansepare,dpl.cantidad,dpl.valor_actual_producto,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.id_producto,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE  pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );
					$variablelimina = 0;
					while ($respuesta_detalla = mysqli_fetch_assoc($sqlplanseparedetalle))
				    {
				    	$variablelimina = 1;
				    	$id_detalle_plansepare = $respuesta_detalla['id_detalle_plansepare'];
				    	$id_producto = $respuesta_detalla['id_producto'];
				    	$cantidad = $respuesta_detalla['cantidad'];
			    	
				    		$sql_elimnaDetallePlan = mysqli_query ($link, "DELETE FROM tbl_detalle_plansepare WHERE id_detalle_plansepare='$id_detalle_plansepare'" );			    	
				    }


				    if ($variablelimina == 1)
				    {
				    	$sql_eliminaplansepare = mysqli_query ($link, "DELETE FROM tbl_plansepare WHERE id_plansepare='$id_plansepare'" );	
				    	if (!$sql_eliminaplansepare)
				    	{
				    		echo "noelimino";
				    	}
				    	else
				    	{
				    		echo "exito";
				    	}
				    }
				}
			}

		}

	}
	else if ($operacion == 'eliminado_creditoxcliente')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_credito = $datos->id_credito;
		$id_cliente = $datos->id_cliente;
		$estadoproductos = $datos->estadoproductos;


		$eliminarcredito=mysqli_query ($link, "DELETE FROM tbl_credito WHERE id_credito='$id_credito'" );
		if(!$eliminarcredito){
			echo "fallo";

		}else{
			$eliminarabonoscredito=mysqli_query ($link, "DELETE FROM tbl_abonos_credito WHERE id_credito='$id_credito'" );
			if(!$eliminarabonoscredito){
				echo "falloabono";

			}else {
				$eliminardetallecredito=mysqli_query ($link, "DELETE FROM tbl_detalle_credito WHERE id_credito='$id_credito'" );
			if(!$eliminardetallecredito){
				echo "fallodetalle";

			}else {
				echo "exito";
			}
			}
		}
	}
	else if ($operacion == 'busquedaPlanesPorCliente')
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_cliente = $datos->id_cliente;
	
		$sql_listadoplansepare = mysqli_query ($link, "SELECT pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_cliente'  GROUP by pla.id_plansepare" );	


		$rows = array();
		$conteo = 0;
		while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
		{

			$fecha_final_sql= strtotime($respuesta['fecha_fin']);
			$fecha_actual_sql= strtotime($respuesta['fechaactual']);

			if ($fecha_actual_sql > $fecha_final_sql) 
			{
				$estadocredito = "vencido";
			}
			else
			{
				$estadocredito = "novencido";
				

			}
			
			$rows[]=array(
				"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



			
		}

		// print_r($rows);
		echo $rows = json_encode($rows);
		mysqli_close($link);
	}
	else if ($operacion == 'insertarDetalleCredito')
	{
		$datos = json_decode(file_get_contents("php://input"));

		$id_producto = $datos->id_producto;
		$cantidadU = $datos->cantidadU;
		$cantidadF = $datos->cantidadF;
		$valorTotal = $datos->valorTotal;
		$id_credito = $datos->id_credito;

		$sql_detallefactura = mysqli_query ($link, "INSERT INTO tbl_detalle_credito VALUES (null,'$id_credito','$id_producto','$cantidadU','$cantidadF','$valorTotal','Credito',current_date())" );
		if (!$sql_detallefactura)
		{
			echo "fallo";
		}
		else
		{
			echo "exito";
			$sql_cantidadinvetario = mysqli_query ($link, "SELECT * FROM tbl_inventario WHERE id_producto='$id_producto' " );
				$filainvetario = mysqli_fetch_array($sql_cantidadinvetario);
				$sql_producto = mysqli_query ($link, "SELECT * FROM tbl_producto WHERE id_producto='$id_producto' " );
				$filaiproducto = mysqli_fetch_array($sql_producto);
				$fraccionProducto=$filaiproducto['fraccion'];
				$fraccion = $filainvetario['stock'];
				$unidad = $filainvetario['Unidad'];
				
				
				if ($cantidadF>$fraccion) {
					if ($cantidadF<=$fraccionProducto) {
					$NuevaUnidad=$unidad-1;
					$newFraccion=$fraccionProducto+$fraccion -$cantidadF;
				
					}else if ($cantidadF>$fraccionProducto) {
						$divicion=$cantidadF/$fraccionProducto;
					$entero=floor($divicion);
					$residuo=$cantidadF%$fraccionProducto;
					if ($residuo!=0) {
						$entero=$entero+1;
						$NuevaUnidad=$unidad-$entero;
					$newFraccion=($fraccionProducto * $entero)+$fraccion -$cantidadF;
					
					}else{
						$NuevaUnidad=$unidad-$entero;
					$newFraccion=($fraccionProducto * $entero)+$fraccion -$cantidadF;
					}
				}
					
					}else{
					$NuevaUnidad=$unidad-$cantidadU;
					$newFraccion=$fraccion-$cantidadF;
				}
				
			$sql_cantidadinvetario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$newFraccion',Unidad='$NuevaUnidad' WHERE id_producto='$id_producto'" );
}
	}
	else if ($operacion == "generarPagocuotaCredito")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_credito = (int)$datos->id_credito;
		$id_cliente = (int)$datos->id_cliente;
		$pagocuota_plansepare = (double)$datos->pagocuota_plansepare;
		$deuda_actual = (double)$datos->deuda_actual;
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;

		$deuda = $deuda_actual - $pagocuota_plansepare;
	if ($deuda_actual< $pagocuota_plansepare) {
		echo "deudamenor";
	}else{


		$sql_guardar_pago = mysqli_query ($link, "INSERT INTO tbl_abonos_credito VALUES(null,'$id_credito','$id_cliente','$pagocuota_plansepare',current_date())" );	

		if (!$sql_guardar_pago) 
		{
			echo "fallo";
		}
		else
		{
			
			$sql_ac_deuda = mysqli_query ($link, "UPDATE tbl_credito SET descuento_abonos='$deuda' WHERE id_credito='$id_credito'" );	

			if (!$sql_ac_deuda) 
			{
				echo "fallo2";
			}
			else
			{

				$sql_listadoplansepare = mysqli_query ($link, "SELECT pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_credito,cl.id_cliente,pla.valor_aumeto,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_credito pla, tbl_detalle_credito dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_credito=pla.id_credito and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.fecha_inicio>='$fechaInicialPansepare' and pla.fecha_inicio<='$fechaFinalPansepare' GROUP by pla.id_credito" );	


				$rows = array();
				$conteo = 0;
				while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
				{

					$fecha_final_sql= strtotime($respuesta['fecha_fin']);
					$fecha_actual_sql= strtotime($respuesta['fechaactual']);

					if ($fecha_actual_sql > $fecha_final_sql) 
					{
						$estadocredito = "vencido";
					}
					else
					{
						$estadocredito = "novencido";
						

					}
					
					$rows[]=array(
						"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_credito" => $respuesta['id_credito'],"valor_aumetoplansepare" => $respuesta['valor_aumeto'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



					
				}

				// print_r($rows);
				echo $rows = json_encode($rows);
				mysqli_close($link);
			}
		}
		
	}
}
	else if ($operacion == "entregarProductosPl")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;

		$sql_lisadoDetallPlansepare = mysqli_query ($link, "SELECT dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.id_producto,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );	

		if (!$sql_lisadoDetallPlansepare) 
		{
			echo "fallo2";
		}
		else
		{
			while ($respuesta = mysqli_fetch_assoc($sql_lisadoDetallPlansepare))
			{
				$id_producto = $respuesta['id_producto'];
				$cantidad = $respuesta['cantidad'];


				$sql_productoInventario = mysqli_query ($link, "SELECT * FROM  tbl_inventario WHERE id_producto='$id_producto'" );	
				$filas = mysqli_fetch_array($sql_productoInventario);

				$stock = $filas['stock'];
				$id_inventario = $filas['id_inventario'];

				$nuevostock = $stock - $cantidad;

				$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );	

				if (!$sql_actualizaInventario) 
				{
					echo "fallo3";
				}
				else
				{	
					$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_plansepare SET estadoproductos='Entregado' WHERE id_plansepare='$id_plansepare'" );	

					if (!$sql_actualizaInventario) 
					{
						echo "fallo3";
					}
					else
					{

						$sql_listadoplansepare = mysqli_query ($link, "SELECT  pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_cliente' GROUP by pla.id_plansepare" );	


						$rows = array();
						$conteo = 0;
						while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
						{

							$fecha_final_sql= strtotime($respuesta['fecha_fin']);
							$fecha_actual_sql= strtotime($respuesta['fechaactual']);

							if ($fecha_actual_sql > $fecha_final_sql) 
							{
								$estadocredito = "vencido";
							}
							else
							{
								$estadocredito = "novencido";
								

							}
							
							$rows[]=array(
								"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);

						}

						// print_r($rows);
						echo $rows = json_encode($rows);
						mysqli_close($link);
					}
				}
			}
		}
		
	}
	else if ($operacion == "entregarProductosPlXrangofecha")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;

		$sql_lisadoDetallPlansepare = mysqli_query ($link, "SELECT dpl.cantidad,dpl.valor_actual_producto,abp.fecha_abono,abp.id_abonos_plansepare,abp.valor_abono,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.id_producto,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c, tbl_abonos_plansepare abp WHERE abp.id_plansepare=pla.id_plansepare and abp.id_cliente=cl.id_cliente and pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and pla.id_plansepare='$id_plansepare' GROUP BY dpl.id_producto" );	

		if (!$sql_lisadoDetallPlansepare) 
		{
			echo "fallo2";
		}
		else
		{
			while ($respuestados_a = mysqli_fetch_assoc($sql_lisadoDetallPlansepare))
			{
				$id_producto = $respuestados_a['id_producto'];
				$cantidad = $respuestados_a['cantidad'];


				$sql_productoInventario = mysqli_query ($link, "SELECT * FROM  tbl_inventario WHERE id_producto='$id_producto'" );	
				$filas = mysqli_fetch_array($sql_productoInventario);

				$stock = $filas['stock'];
				$id_inventario = $filas['id_inventario'];

				$nuevostock = $stock - $cantidad;

				$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_inventario SET stock='$nuevostock' WHERE id_inventario='$id_inventario'" );	

				if (!$sql_actualizaInventario) 
				{
					echo "fallo3";
				}
				else
				{	
					$sql_actualizaInventario = mysqli_query ($link, "UPDATE tbl_plansepare SET estadoproductos='Entregado' WHERE id_plansepare='$id_plansepare'" );	

					if (!$sql_actualizaInventario) 
					{
						echo "fallo3";
					}
					else
					{

						echo "siactualizo";
					}
				}
			}
		}
		
	}
	else if ($operacion == "generarPagocuotaPlansepareXclientes")
	{
		$datos = json_decode(file_get_contents("php://input"));
		$id_plansepare = $datos->id_plansepare;
		$id_cliente = $datos->id_cliente;
		$pagocuota_plansepare = $datos->pagocuotia_plansepare;
		$deuda_actual = $datos->deuda_actual;
		$fechaInicialPansepare = $datos->fechaInicialPansepare;
		$fechaFinalPansepare = $datos->fechaFinalPansepare;

		$deuda = $deuda_actual - $pagocuota_plansepare;

		

		$sql_guardar_pago = mysqli_query ($link, "INSERT INTO tbl_abonos_plansepare VALUES(null,'$id_plansepare','$id_cliente','$pagocuota_plansepare',current_date())" );	

		if (!$sql_guardar_pago) 
		{
			echo "fallo";
		}
		else
		{
			
			$sql_ac_deuda = mysqli_query ($link, "UPDATE tbl_plansepare SET descuento_abonos='$deuda' WHERE id_plansepare='$id_plansepare'" );	

			if (!$sql_ac_deuda) 
			{
				echo "fallo2";
			}
			else
			{

				$sql_listadoplansepare = mysqli_query ($link, "SELECT  pla.estadoproductos,pla.estadoproductos as estadoPrEntregados,pla.id_plansepare,cl.id_cliente,pla.valor_aumetoplansepare,pla.total_pagosepare,pla.descuento_abonos,pla.fecha_inicio,pla.fecha_fin,pr.nombre,pr.codigo_producto,pr.descripcion,pr.valor,pr.valor_venta,c.nombre_categoria,cl.cc_cliente,cl.nombre_cliente,pla.descuento_abonos as estado,pla.descuento_abonos as vencido,current_date() as fechaactual,pla.fecha_fin as estadocredito FROM tbl_plansepare pla, tbl_detalle_plansepare dpl, tbl_cliente cl, tbl_producto pr, tbl_categoria c WHERE pla.id_cliente=cl.id_cliente and dpl.id_plansepare=pla.id_plansepare and dpl.id_producto=pr.id_producto and pr.id_categoria=c.id_categoria and cl.id_cliente='$id_cliente' GROUP by pla.id_plansepare" );	


				$rows = array();
				$conteo = 0;
				while ($respuesta = mysqli_fetch_assoc($sql_listadoplansepare))
				{

					$fecha_final_sql= strtotime($respuesta['fecha_fin']);
					$fecha_actual_sql= strtotime($respuesta['fechaactual']);

					if ($fecha_actual_sql > $fecha_final_sql) 
					{
						$estadocredito = "vencido";
					}
					else
					{
						$estadocredito = "novencido";
						

					}
					
					$rows[]=array(
						"estadoproductos" => $respuesta['estadoproductos'],"estadoPrEntregados" => $respuesta['estadoPrEntregados'],"id_cliente" => $respuesta['id_cliente'],"id_plansepare" => $respuesta['id_plansepare'],"valor_aumetoplansepare" => $respuesta['valor_aumetoplansepare'] ,"total_pagosepare" => $respuesta['total_pagosepare'] ,"descuento_abonos" => $respuesta['descuento_abonos'] ,"fecha_inicio" => $respuesta['fecha_inicio'] ,"fecha_fin" => $respuesta['fecha_fin'] ,"nombre" => $respuesta['nombre'] ,"codigo_producto" => $respuesta['codigo_producto'] ,"descripcion" => $respuesta['descripcion'] ,"valor" => $respuesta['valor'] ,"valor_venta" => $respuesta['valor_venta'] ,"nombre_categoria" => $respuesta['nombre_categoria'] ,"cc_cliente" => $respuesta['cc_cliente'] ,"nombre_cliente" => $respuesta['nombre_cliente'] ,"estado" => $respuesta['estado'] ,"vencido" => $respuesta['vencido'] ,"fechaactual" => $respuesta['fechaactual'] ,"estadocredito" => $estadocredito);



					
				}

				// print_r($rows);
				echo $rows = json_encode($rows);
				mysqli_close($link);
			}
		}
		}
	}

?>