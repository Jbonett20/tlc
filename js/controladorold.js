

//CONTROLADOR DE ARCHIVO HOME.PHP   //////////////////////////////////////////
app.controller('homeCtrl', function($scope, loginService){
    $scope.txt="Welcome";
    $scope.logout = function()
    {
        loginService.logout();
    }
});


// CONTROLADOR DE LOGIN /////////////////////////////////////////////////////////
app.controller('loginCtrl', function($scope,$http, loginService)
{
	$scope.verlogoLogin2 = true;
 	$scope.login = function(user)
	{
		
		loginService.login(user,$scope);
	}

$scope.loginkey = function(elEvento,user)
	{
		elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
		loginService.login(user,$scope);
	}
	}

	// $scope.login_pin = function (user)
	// {
		
	// 	$scope.pin = user.pin;
		
	// 	$http.post('admin/conexion.php',
	// 		{
	// 			'pin':$scope.pin
	// 		}).success(function(resultado)
	// 		{
		       

	// 			console.log(resultado);
	// 			if (resultado == 'no hay nada')
	// 			{		
						
						
	// 					console.log("no hay nada de eso");
	// 					document.getElementById('Pin').removeAttribute('disabled');
						
	// 			}else if (resultado == '')
	// 			{
	// 				$scope.vista_formlogin = true;
	        		
	        		
	//         		document.getElementById("boton1login").className = "oculta_botonlogin";
	//         		document.getElementById('Pin').setAttribute('disabled', 'disabled');
	//         		$http.post('app/operaciones/operaciones.php?variable=buscarlogoAlcardia&operacion=logo',
	// 					{
	// 						'pin':$scope.pin
	// 					}).success(function(datos)
	// 					{
					       

	// 						//console.log(datos);
	// 						if (datos == "no hay nada")
	// 						{
	// 				        		$scope.verlogoLogin1 = false;
	// 								$scope.verlogoLogin2 = true;
	// 						}
	// 						else
	// 						{		
	// 								$scope.verlogoLogin1 = true;
	// 								$scope.verlogoLogin2 = false;

	// 								//console.log(datos);
	// 								$scope.logoAlcadia = "app/operaciones/"+datos;
	// 								console.log($scope.logoAlcadia);
	// 						}
	// 				      }).
	// 				      error(function(datos) {
	// 				      	console.log("echo todo mal");
	// 				        // called asynchronously if an error occurs
	// 				        // or server returns response with an error status.
	// 				    });
	// 			}
	// 			else
	// 			{
	// 				// console.log('mairon medez');
	// 				$('#pin_login_error').modal({
 //                        keyboard: false
 //                      });
	// 				$scope.vista_formlogin = false;

	// 			}
				
	// 	      }).
	// 	      error(function(resultado) {
	// 	      	console.log("echo todo mal");
	// 	        // called asynchronously if an error occurs
	// 	        // or server returns response with an error status.
	// 	    });
	// }
});

 
app.controller('ventas', ['$scope','$http', function ($scope ,$http)
{	
	// =============================== TODO LO REFERENTE INSERTAR INGRESOS ==========================

	$scope.insertIngresos =  
	{
		id_producto:'',
		codigo_producto:'',
		nombre_producto:'',
		cantidadUnidad:0,
		cantidadFraccion:0
	}
	//funcion que va a agregar el producto seleccionado al nuevo ingreso
	$scope.agregarProductoIngresosInsert =  function(id_producto,nombre,codigo_producto,fraccion,insertIngresos)
	{
		/*console.log(id_producto);
		console.log(codigo_producto);
		*/console.log(nombre);

		insertIngresos.id_producto = id_producto;
		insertIngresos.codigo_producto = codigo_producto;
		insertIngresos.nombre_producto = nombre;
		insertIngresos.fraccion = fraccion;
	}
	// funcion que va a guardar los registros de ingresos del producto
	$scope.guardarIngresos  = function (insertIngresos)
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertadorIngresos",insertIngresos)
		.success(function (datos)
		{		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'guardo')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha guardado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeIngresos")
				.success(function (datos)
				{		
					$scope.listadodetodos_Ingreso = datos;
									
					console.log(datos);

					$scope.pagelistadodetodos_Ingreso = 1;
				

					$scope.itemslistadodetodos_Ingreso = $scope.listadodetodos_Ingreso.slice(0, 4);
					
					$scope.paginalistadodetodos_Ingreso = function() {
					  var startPos = ($scope.pagelistadodetodos_Ingreso - 1) * 4;
					  console.log($scope.pagelistadodetodos_Ingreso);
					}
					
				}).error(function(datos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error al tratar de listar los cursos',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });
			    $scope.insertIngresos =  
	{
		id_producto:'',
		codigo_producto:'',
		nombre_producto:'',
		cantidadUnidad:0,
		cantidadFraccion:0
	}

			}
			else if (datos == 'noseencontro')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha encontrado Registro en el inventario de l prodcuto seleccionado',
					
					styling: 'bootstrap3'
				});
			}
			else
			{
				new PNotify({
					title: 'Error!',
					text: 'error de operacion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });


	}
	$scope.showVista = {}
	$scope.showVistaF = {}
$scope.showVista.show=true;
$scope.showVistaF.show=false;
	$scope.showVistaJS = function(){
		$scope.showVista.show = !$scope.showVista.show;
		// alert("show");
	}
	$scope.showVistaJSF = function(){
		$scope.showVistaF.show = !$scope.showVistaF.show;
		// alert("show");
	}
	
	$scope.AgregarCantidadProducto={
		AddCantidadUnidad:0,
		AddCantidadFraccion:0
	}

$scope.guardarIngresosProducto  = function (id,AgregarCantidadProducto)
	{
		// console.log(AgregarCantidadProducto);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertadorIngresosProducto",{
			'id_producto':id,
			'cantidadUnidad':AgregarCantidadProducto.AddCantidadUnidad,
			'cantidadFraccion':AgregarCantidadProducto.AddCantidadFraccion
		})
		.success(function (datos)
		{		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'guardo')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha guardado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				// $scope.fromIngresosCantidad.show = !$scope.fromIngresosCantidad.show;
				// $scope.fromIngresosSerial.show = !$scope.fromIngresosSerial.show;
				// $scope.fromIngresosCantidadBotton.show = !$scope.fromIngresosCantidadBotton.show;
				// $scope.fromIngresosSerialBotton.show = !$scope.fromIngresosSerialBotton.show;
				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeIngresos")
				.success(function (datos)
				{		
					$scope.listadodetodos_Ingreso = datos;
								
							
					console.log(datos);

					$scope.pagelistadodetodos_Ingreso = 1;
				

					$scope.itemslistadodetodos_Ingreso = $scope.listadodetodos_Ingreso.slice(0, 40);
					
					$scope.paginalistadodetodos_Ingreso = function() {
					  var startPos = ($scope.pagelistadodetodos_Ingreso - 1) * 40;
					  console.log($scope.pagelistadodetodos_Ingreso);
					}
					
				}).error(function(datos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error al tratar de listar los cursos',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

			}
			else if (datos == 'noseencontro')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha encontrado Registro en el inventario de l prodcuto seleccionado',
					
					styling: 'bootstrap3'
				});
			}
			else
			{
				new PNotify({
					title: 'Error!',
					text: 'error de operacion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });

	}
	
$scope.guardarIngresosProductoSerial  = function (id,AgregarCantidadProducto)
	{
		// console.log(AgregarCantidadProducto);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertadorIngresosProductoSerial",{
			'id_producto':id,
			'serial':AgregarCantidadProducto.AddSerial
		})
		.success(function (datos)
		{		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'guardo')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha guardado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				// $scope.fromIngresosCantidad.show = !$scope.fromIngresosCantidad.show;
				// $scope.fromIngresosSerial.show = !$scope.fromIngresosSerial.show;
				// $scope.fromIngresosCantidadBotton.show = !$scope.fromIngresosCantidadBotton.show;
				// $scope.fromIngresosSerialBotton.show = !$scope.fromIngresosSerialBotton.show;
				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeIngresos")
				.success(function (datos)
				{		
					$scope.listadodetodos_Ingreso = datos;
									
					console.log(datos);

					$scope.pagelistadodetodos_Ingreso = 1;
				

					$scope.itemslistadodetodos_Ingreso = $scope.listadodetodos_Ingreso.slice(0, 4);
					
					$scope.paginalistadodetodos_Ingreso = function() {
					  var startPos = ($scope.pagelistadodetodos_Ingreso - 1) * 4;
					  console.log($scope.pagelistadodetodos_Ingreso);
					}
					
				}).error(function(datos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error al tratar de listar los cursos',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

			}
			else if (datos == 'noseencontro')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha encontrado Registro en el inventario de l prodcuto seleccionado',
					
					styling: 'bootstrap3'
				});
			}
			else
			{
				new PNotify({
					title: 'Error!',
					text: 'error de operacion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });

	}

$scope.fromIngresosCantidad = {}
$scope.fromIngresosCantidad.show=true;
$scope.fromIngresosCantidadBotton = {}
$scope.fromIngresosCantidadBotton.show=true;
$scope.fromIngresosSerial = {}
$scope.fromIngresosSerial.show=false;
$scope.fromIngresosSerialBotton = {}
$scope.fromIngresosSerialBotton.show=false;
	//funcion que va a listar todos los productos
	$scope.listadoProducto_Ingresos  = function (insertIngresos)
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeProductos")
		.success(function (datos)
		{		
			$scope.listadodeProductos_Ingreso = datos;
							
			console.log(datos);

			$scope.pagelistadodeProductos_Ingreso = 1;
		

			$scope.itemslistadodeProductos_Ingreso = $scope.listadodeProductos_Ingreso.slice(0, 20);
			
			$scope.paginalistadodeProductos_Ingreso = function() {
			  var startPos = ($scope.pagelistadodeProductos_Ingreso - 1) * 20;
			  console.log($scope.pagelistadodeProductos_Ingreso);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

	$scope.listadoProducto_Ingresos();

$scope.cant={
		cantidadU:0,
		cantidadF:0
	}
	//funcion que va a listar todos los ingresos
	$scope.listadotodos_Ingresos  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeIngresos")
		.success(function (datos)
		{		
			$scope.listadodetodos_Ingreso = datos;
							
			console.log(datos);

			$scope.pagelistadodetodos_Ingreso = 1;
		

			$scope.itemslistadodetodos_Ingreso = $scope.listadodetodos_Ingreso.slice(0, 4);
			
			$scope.paginalistadodetodos_Ingreso = function() {
			  var startPos = ($scope.pagelistadodetodos_Ingreso - 1) * 4;
			  console.log($scope.pagelistadodetodos_Ingreso);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
$scope.listadotodos_Ingresos();

	//==================== TODO LO REFERENTE A ELIMINACION DE INGRESOS ================


	$scope.confirmaEminaIngreso = 
	{
		id_producto_ElimiIngre:'',
		cantidad_ElimiIngre:'',
		id_ingreso_ElimiIngre:''
	}

	// fuuncion que va a confirmar la eliminacion del ingreso 
	$scope.confirmaEliminar_IngresosProducto = function(id_producto,id_ingresos,cantidad,confirmaEminaIngreso)
	{
		confirmaEminaIngreso.id_producto_ElimiIngre = id_producto;
		confirmaEminaIngreso.id_ingreso_ElimiIngre = id_ingresos;
		confirmaEminaIngreso.cantidad_ElimiIngre = cantidad;
	}

	// funcion que va a eliminar el registro de ingresos
	$scope.Eliminar_IngresosProducto = function(confirmaEminaIngreso)
	{
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=eliminaringresos",confirmaEminaIngreso)
		.success(function (datos)
		{		
			console.log(datos);
			if (datos == 'no elimno')
			{
				new PNotify({
					title: 'Error!',
					text: 'Se ha eliminado con exito',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'noActuaizo_elimno')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha eliminado correctamente; verifique el inventario!',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exitoelimno')
			{
				new PNotify({
					title: 'Exito!',
					text: 'SE ha eliminado con exito',
					type: 'success',
					styling: 'bootstrap3'
				});

				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeIngresos")
				.success(function (datos)
				{		
					$scope.listadodetodos_Ingreso = datos;
									
					console.log(datos);

					$scope.pagelistadodetodos_Ingreso = 1;
				

					$scope.itemslistadodetodos_Ingreso = $scope.listadodetodos_Ingreso.slice(0, 4);
					
					$scope.paginalistadodetodos_Ingreso = function() {
					  var startPos = ($scope.pagelistadodetodos_Ingreso - 1) * 4;
					  console.log($scope.pagelistadodetodos_Ingreso);
					}
					
				}).error(function(datos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error al tratar de listar los cursos',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });
			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'ha ocurrido un error de operacion Eliminar_IngresosProducto',
					
					styling: 'bootstrap3'
				});
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'ha ocurrido un error de funcion Eliminar_IngresosProducto',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}

	//======= TODO LO REFERENTE A ACTUALIZACION DE INGRESOS ========

	$scope.updateIngresos  = 
	{
		id_producto:'',
		id_ingresos:'',
		codigo_producto:'',
		nombre_producto:'',
		id_inventario:'',
		cantidad_nueva:'',
		cantidad:0
	}

	// funcion que va a ver los datos del registro de ingreso que se va a actualizar
	$scope.verInfo_ingresoActualizar  = function (id_inventario,id_ingresos,id_producto,nombre,codigo_producto,cantidad,updateIngresos)
	{
		updateIngresos.id_producto = id_producto;
		updateIngresos.id_ingresos = id_ingresos;
		updateIngresos.codigo_producto = codigo_producto;
		updateIngresos.nombre_producto = nombre;
		updateIngresos.id_inventario = id_inventario;
		updateIngresos.cantidad = parseInt(cantidad);
		updateIngresos.cantidad_nueva = parseInt(cantidad);
	}

	// funcion que va a actualizar el registro de ingreso
	$scope.actualizar_Ingresos = function(updateIngresos)
	{
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=actualizandoIngresos",updateIngresos)
		.success(function (datos)
		{		
			console.log(updateIngresos);
			console.log(datos);
			if (datos == 'noActuaizo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito_Actualizo')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeIngresos")
				.success(function (datos)
				{		
					$scope.listadodetodos_Ingreso = datos;
									
					console.log(datos);

					$scope.pagelistadodetodos_Ingreso = 1;
				

					$scope.itemslistadodetodos_Ingreso = $scope.listadodetodos_Ingreso.slice(0, 4);
					
					$scope.paginalistadodetodos_Ingreso = function() {
					  var startPos = ($scope.pagelistadodetodos_Ingreso - 1) * 4;
					  console.log($scope.pagelistadodetodos_Ingreso);
					}
					
				}).error(function(datos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error al tratar de listar los cursos',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });
			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_Ingresos',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}


	//funcion que va a buscar los ingresos en un rando de fecha especifico
	$scope.generar_reportePDFingresosgenral = function(fecha_icial,fechafinal)
	{
		var fechauno = new Date(fecha_icial).toISOString();
		var fechados = new Date(fechafinal).toISOString();
		window.open('views/informespdf/reporteingresosGlobalXfecha.php?fecha_inicio='+fechauno+'&fecha_fin='+fechados,'_blank');
	}

	$scope.busquedaingresosXproducto  = 
	{
		id_producto:'',
		codigo_producto:'',
		nombre_producto:'',
		fechaInicial_ingresoXproduct:'',
		fechaFinal_ingresoXproduct:''
	}

	$scope.agregarProductXreproteInsert = function(id_producto,nombre,codigo_producto,busquedaingresosXproducto)
	{
		busquedaingresosXproducto.id_producto = id_producto;
		busquedaingresosXproducto.nombre_producto = nombre;
		busquedaingresosXproducto.codigo_producto = codigo_producto;
	}

	//funcion que va a buscar los ingresos por prodcuto
	$scope.generar_reportePDFingresosXproducto = function(id_producto,fechaInicial_ingresoXproduct,fechaFinal_ingresoXproduct)
	{
		var fechauno = new Date(fechaInicial_ingresoXproduct).toISOString();
		var fechados = new Date(fechaFinal_ingresoXproduct).toISOString();
		window.open('views/informespdf/reporteingresoXproducto.php?fecha_inicio='+fechauno+'&fecha_fin='+fechados+'&id_producto='+id_producto,'_blank');
	}


	//  =================================== TODO LO REFERENTE A INVENTARIOS ============

	$scope.busquedainventarioXproducto  = 
	{
		id_producto:'',
		codigo_producto:'',
		nombre_producto:'',
	}

		$scope.agregarinvemtario_ProductXreprote = function(id_producto,nombre,codigo_producto,busquedainventarioXproducto)
	{
		busquedainventarioXproducto.id_producto = id_producto;
		busquedainventarioXproducto.nombre_producto = nombre;
		busquedainventarioXproducto.codigo_producto = codigo_producto;
	}

	// buscar inventario pro producto
	$scope.busquedainventarioXproducto = function(id_producto)
	{
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=inventarioXprodcito",
		{
			'id_producto':id_producto
		})
		.success(function (datos)
		{		
			$scope.listainventarioXproducto = datos;
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}



	// lista de categorias
	$scope.listacagoriasProductos = function(id_producto)
	{
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=catergoriaProductorBusqueda")
		.success(function (datos)
		{		
			$scope.listCategoriasProdcuto = datos;

			console.log(datos);

			$scope.pagelistCategoriasProdcuto = 1;
		

			$scope.itemslistCategoriasProdcuto = $scope.listCategoriasProdcuto.slice(0, 4);
			
			$scope.paginalistCategoriasProdcuto = function() {
			  var startPos = ($scope.pagelistCategoriasProdcuto - 1) * 4;
			  console.log($scope.pagelistCategoriasProdcuto);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error listacagoriasProductos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}

	$scope.listacagoriasProductos();

	$scope.busquedainventarioXcategira  = 
	{
		id_categoria:'',
		nombre_categoria:''

	}

	// funcion que va a agregar la categoria al campo seleccionado
	$scope.agregarcartegoriaFormu = function(id_categoria,nombre_categoria,busquedainventarioXcategira)
	{
		busquedainventarioXcategira.id_categoria = id_categoria;
		busquedainventarioXcategira.nombre_categoria = nombre_categoria;
		
	}

	// generar reporte de inventario por categoria
	$scope.busquedainventarioXcategorias = function(id_categoria)
	{
		
		window.open('views/informespdf/reporteinventarioXcategoriaproducto.php?id_categoria='+id_categoria,'_blank');
	}

	//funcion que va a buscar el inevtarios
	$scope.generar_reportePDFinevtariosgenral = function()
	{
		window.open('views/informespdf/reporteInventarioporRangofecha.php','_blank');
	}

	//==================== TODO LO REFERENTE A FACTURAR ======================

	// ------------------- crear nuevo plansepare ---------------

	$scope.insertarplansepare =
	{
		valor_aumento:0,
		fecha_inicioPlansepare:'',
		fechaFin_plansepare:'',
		id_cliente:'',
		identificacion:'',
		nombre_clientes:''
	}

	$scope.guardar_plansepare  = function(insertarplansepare)
	{
		console.log(insertarplansepare);
		if (insertarplansepare.id_cliente == "") 
		{
			new PNotify({
				title: 'Error!',
				text: 'Debe seleccionar un cliente',
				
				styling: 'bootstrap3'
			});
		}
		else if (insertarplansepare.fecha_inicioPlansepare == "") 
		{
			new PNotify({
				title: 'Error!',
				text: 'Debe seleccionar la fecha inicial del plan separe',
				
				styling: 'bootstrap3'
			});
		}
		else if (insertarplansepare.fechaFin_plansepare == "") 
		{
			new PNotify({
				title: 'Error!',
				text: 'Debe seleccionar la fecha final del plan separe',
				
				styling: 'bootstrap3'
			});	
		}
		
		else
		{
			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarplansepare",
			{
				'id_cliente':insertarplansepare.id_cliente,
				'fecha_inicioPlansepare':insertarplansepare.fecha_inicioPlansepare,
				'fechaFin_plansepare':insertarplansepare.fechaFin_plansepare,
				'totalapagar_plansepare':$scope.totalapagar_plansepare,
				'valor_aumento':insertarplansepare.valor_aumento
			})
			.success(function (datos)
			{		
				console.log(datos);
				var id_plansepare = datos;

				for (var b = 0; b < $scope.listaProductosPlan_separe.length; b++)
				{
					$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarDetallePlansepare",
					{
						'id_producto':$scope.listaProductosPlan_separe[b].id_producto,
						'cantidad':$scope.listaProductosPlan_separe[b].cantidad,
						'valorTotal':$scope.listaProductosPlan_separe[b].valorTotal,
						'id_plansepare':id_plansepare
					})
					.success(function (respuesta)
					{		
						console.log(respuesta);

						
						if (respuesta == 'exito')
						{
							new PNotify({
								title: 'Exito!',
								text: 'Se ha guardado con exito el registro de los productos',
								type: 'success',
								styling: 'bootstrap3'
							});


						}
						else if (respuesta == 'fallo') 
						{
							
							new PNotify({
								title: 'Error!',
								text: 'No se ha podido guardar el registro de los productos',
								type: 'error',
								styling: 'bootstrap3'
							});
						}
						else
						{
							
							new PNotify({
								title: 'Exito!',
								text: 'Eror! No se ha guardado registro de los productos',
								type: 'error',
								styling: 'bootstrap3'
							});

						}
						


					}).error(function(respuesta, status, headers, config)
					{
				      //	console.log("echo todo mal");
				      	new PNotify({
								title: 'Error!',
								text: 'Ha ocurrido un error de funcion guardar Factura',
								type: 'error',
								styling: 'bootstrap3'
							});
				    });

					
				}



				// window.open('views/informespdf/impresionfactura.php?factura='+id_factura,'_blank');


				
			}).error(function(datos, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion guardarFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
		}



	}
	// funcion que va a gregar el cliente en el formulario de facturacion
	$scope.agregarClienteplansepare = function(id_cliente,cc_cliente,nombre_cliente,insertarplansepare)
	{
		insertarplansepare.id_cliente = id_cliente;
		insertarplansepare.identificacion = cc_cliente;
		insertarplansepare.nombre_clientes = nombre_cliente;
	}


	$scope.listar_plansepare = 
	{
		fechaInicialPansepare:'',
		fechaFinalPansepare:''
	}



	$scope.listar_plansepareXcliente = 
	{
		id_cliente:'',
		identificacion:'',
		nombre_clientes:'',
	
	}

	$scope.agregarClienteListado_Plansepare = function(id_cliente,cc_cliente,nombre_cliente,listar_plansepareXcliente)
	{
		listar_plansepareXcliente.id_cliente = id_cliente;
		listar_plansepareXcliente.identificacion = cc_cliente;
		listar_plansepareXcliente.nombre_clientes = nombre_cliente;
	}

	

	// busqueda de planes por rango de fecha
	$scope.buscarPlanesSepareporfecha = function(listar_plansepare)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorfechaRango",
		{
			'fechaInicialPansepare':listar_plansepare.fechaInicialPansepare,
			'fechaFinalPansepare':listar_plansepare.fechaFinalPansepare
		})
		.success(function (Dattos)
		{
			$scope.ListaPlanesDados = Dattos;

			$scope.pageListaPlanesDados  = 1;
			
			$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
			
			$scope.paginaListaPlanesDados  = function() {
			 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
			 console.log($scope.pageListaPlanesDados );
			};

			
				for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
				{
					if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
					{
						$scope.ListaPlanesDados[b].estado = "Pagando";		
					}
					else
					{
						$scope.ListaPlanesDados[b].estado = "Pagando...";	
					}


					if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
					{
						$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
					}
					else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
					{
						$scope.ListaPlanesDados[b].estadocredito = "Activo";	

					}

					if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
					{
						$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
					}
					else
					{
						$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
					}

				}

				console.log($scope.ListaPlanesDados);
			
		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}



	// busqueda de planes por cliente seleccionado
	$scope.buscarPlanesSepareXcliente = function(id_cliente)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorCliente",
		{
			'id_cliente':id_cliente
		})
		.success(function (Dattos)
		{
			$scope.ListaPlanesDadosXcliente = Dattos;
			
				for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
				{
					console.log($scope.ListaPlanesDadosXcliente[b].estadoproductos);
					if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
					{
						$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
					}
					else
					{
						$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
					}


					if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
					{
						$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
					}
					else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
					{
						$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

					}

					if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
					{
						$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
					}
					else
					{
						$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
					}

					

				}

				console.log($scope.ListaPlanesDadosXcliente);
			
		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}

	$scope.cuotas_Plansepare = 
	{
		deuda_actual:'',
		id_plansepare:'',
		id_cliente:'',
		identificacion:'',
		nombre_clientes:'',
		pagocuota_plansepare:0
	}

	// funcion que va a descontar el producto del inventario
	$scope.entregarelProductoPlansepare = function(id_plansepare,id_cliente)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=entregarProductosPl",
		{
			'id_plansepare':id_plansepare,
			'id_cliente':id_cliente
		})
		.success(function (Dattos)
		{
			console.log('Dattos');
			console.log(Dattos);
			if (Dattos == 'fallo2')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al guardar el Producto 1',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (Dattos == 'fallo3')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al guardar el Producto',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else
			{
				$scope.ListaPlanesDadosXcliente = Dattos;
			
				for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
				{
					
					if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
					{
						$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
					}
					else
					{
						$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
					}


					if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
					{
						$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
					}
					else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
					{
						$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

					}

					if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
					{
						$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
					}
					else
					{
						$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
					}

					

				}

				console.log($scope.ListaPlanesDadosXcliente);
			}

		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion entregarelProductoPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}



	// funcion que va a descontar el producto del inventario
	$scope.entregarelProductoPlansepareXfechas = function(id_plansepare,id_cliente,fechaInicialPansepare,fechaFinalPansepare)
	{
		console.log(id_plansepare);
		console.log(id_cliente);
		console.log(fechaInicialPansepare);
		console.log(fechaFinalPansepare);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=entregarProductosPlXrangofecha",
		{
			'id_plansepare':id_plansepare,
			'id_cliente':id_cliente,
			'fechaInicialPansepare':fechaInicialPansepare,
			'fechaFinalPansepare':fechaFinalPansepare
		})
		.success(function (respuesta)
		{
			console.log('respuesta');
			console.log(respuesta);
			
			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorfechaRango",
			{
				'fechaInicialPansepare':fechaInicialPansepare,
				'fechaFinalPansepare':fechaFinalPansepare
			})
			.success(function (Dattos)
			{
				$scope.ListaPlanesDados = Dattos;

				$scope.pageListaPlanesDados  = 1;
				

				$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
				
				$scope.paginaListaPlanesDados  = function() {
				 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
				 console.log($scope.pageListaPlanesDados );
				};

				
					for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
					{
						if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
						{
							$scope.ListaPlanesDados[b].estado = "Pagando";		
						}
						else
						{
							$scope.ListaPlanesDados[b].estado = "Pagando...";	
						}


						if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
						{
							$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
						}
						else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
						{
							$scope.ListaPlanesDados[b].estadocredito = "Activo";	

						}

						if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
						{
							$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
						
						}
						else
						{
							$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
						
						}

					}

					console.log($scope.ListaPlanesDados);
				
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion guardarFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion entregarelProductoPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}


	// funcion que va a mostrar los datos en el modal de pago de cuotas
	$scope.cuotas_listaPlansepare = function(descuento_abonos,id_plansepare,id_cliente,cc_cliente,nombre_cliente,cuotas_Plansepare)
	{
		// console.log(id_plansepare);
		// console.log(id_cliente);
		cuotas_Plansepare.deuda_actual = descuento_abonos;
		cuotas_Plansepare.id_plansepare = id_plansepare;
		cuotas_Plansepare.id_cliente = id_cliente;
		cuotas_Plansepare.identificacion = cc_cliente;
		cuotas_Plansepare.nombre_clientes = nombre_cliente;
	}

	// funcion que va a imprimir la factura de la cuota seleccionada
	$scope.imprimmirRecibocuptaPlan = function(id_abonos_plansepare,id_plansepare)
	{
		window.open('views/informespdf/impresionCuotasPlanXuna.php?plansepare='+id_plansepare+'&cuota='+id_abonos_plansepare,'_blank');


	}


	$scope.guardar_CuotaPagoPlansepare = function(cuotas_Plansepare,listar_plansepare)
	{
		console.log(cuotas_Plansepare);
		console.log(listar_plansepare);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=generarPagocuotaPlansepare",
		{
			
			'id_plansepare':cuotas_Plansepare.id_plansepare,
			'deuda_actual':cuotas_Plansepare.deuda_actual,
			'id_cliente':cuotas_Plansepare.id_cliente,
			'pagocuota_plansepare':cuotas_Plansepare.pagocuota_plansepare,
			'fechaInicialPansepare':listar_plansepare.fechaInicialPansepare,
			'fechaFinalPansepare':listar_plansepare.fechaFinalPansepare
		})
		.success(function (Dattos)
		{
			if (Dattos == "fallo")
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardarel pago',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}
			else
			{

				new PNotify({
					title: 'Exito!',
					text: 'SE guardo con exito el pago',
					type: 'success',
					styling: 'bootstrap3'
				});

				$scope.ListaPlanesDados = Dattos;


				// $scope.ListaPlanesDados[0].
				// $scope.ListaPlanesDados[0].
				// $scope.ListaPlanesDados[0].


			
				for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
				{
					if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
					{
						$scope.ListaPlanesDados[b].estado = "Pagando";		
					}
					else
					{
						$scope.ListaPlanesDados[b].estado = "Pagando...";	
					}


					if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
					{
						$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
					}
					else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
					{
						$scope.ListaPlanesDados[b].estadocredito = "Activo";	

					}

					if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
					{
						$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
					}
					else
					{
						$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
					}

				}

				console.log($scope.ListaPlanesDados);
				
				window.open('views/informespdf/impresionCuotasPlanSepare.php?plansepare='+cuotas_Plansepare.id_plansepare,'_blank');




			}

		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardar_CuotaPagoPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}


	$scope.guardar_CuotaPagoPlansepareXcliente = function(cuotas_Plansepare,listar_plansepare)
	{
		console.log(cuotas_Plansepare);
		console.log(listar_plansepare);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=generarPagocuotaPlansepareXclientes",
		{
			
			'id_plansepare':cuotas_Plansepare.id_plansepare,
			'deuda_actual':cuotas_Plansepare.deuda_actual,
			'id_cliente':cuotas_Plansepare.id_cliente,
			'pagocuota_plansepare':cuotas_Plansepare.pagocuota_plansepare,
			'fechaInicialPansepare':listar_plansepare.fechaInicialPansepare,
			'fechaFinalPansepare':listar_plansepare.fechaFinalPansepare
		})
		.success(function (Dattos)
		{
			if (Dattos == "fallo")
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardarel pago',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}
			else
			{

				new PNotify({
					title: 'Exito!',
					text: 'SE guardo con exito el pago',
					type: 'success',
					styling: 'bootstrap3'
				});

				$scope.ListaPlanesDadosXcliente = Dattos;


				// $scope.ListaPlanesDadosXcliente[0].
				// $scope.ListaPlanesDadosXcliente[0].
				// $scope.ListaPlanesDadosXcliente[0].


			
				for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
				{
					if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
					{
						$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
					}
					else
					{
						$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
					}


					if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
					{
						$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
					}
					else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
					{
						$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

					}

					if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
					{
						$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
					}
					else
					{
						$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
					}

				}

				console.log($scope.ListaPlanesDadosXcliente);
				
				window.open('views/informespdf/impresionCuotasPlanSepare.php?plansepare='+cuotas_Plansepare.id_plansepare,'_blank');




			}

		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardar_CuotaPagoPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}


	// funcion que va a buscar el detalle de los pagos que se han hecho del plan separe
	$scope.verdetallePlanSepare = function(id_plansepare,id_cliente)
	{	
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallaCuotas_Planes",
		{
			'id_plansepare':id_plansepare
		})
		.success(function (Dattos)
		{	
			// alert("entro");
			$scope.ListaPagosPlanes = Dattos;
			console.log($scope.ListaPagosPlanes);

			
			$scope.id_plansepare_sql = $scope.ListaPagosPlanes[0].id_plansepare;
			$scope.total_pagosepare_sql = $scope.ListaPagosPlanes[0].total_pagosepare;
			$scope.valor_aumetoplansepare_sql = $scope.ListaPagosPlanes[0].valor_aumetoplansepare;
			$scope.fecha_inicio_sql = $scope.ListaPagosPlanes[0].fecha_inicio;
			$scope.fecha_fin_sql = $scope.ListaPagosPlanes[0].fecha_fin;
			$scope.descuento_abonos_sql = $scope.ListaPagosPlanes[0].descuento_abonos;
			$scope.id_cliente_sql = $scope.ListaPagosPlanes[0].id_cliente;
			$scope.cc_cliente_sql = $scope.ListaPagosPlanes[0].cc_cliente;
			$scope.nombre_cliente_sql = $scope.ListaPagosPlanes[0].nombre_cliente;



			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetalle_Planes",
			{
				'id_plansepare':id_plansepare
			})
			.success(function (respuesta)
			{	
				$scope.ListaProductosPlanSepare = respuesta;


				$scope.sumacuotas = 0;
				for (var b = 0; b < $scope.ListaProductosPlanSepare.length; b++)
				{
					
					$scope.sumacuotas = parseInt($scope.sumacuotas) + parseInt($scope.ListaProductosPlanSepare[b].valor_abono);
				}

				$scope.sumacuotas;
			

			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion verdetallePlanSepare segunda',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion verdetallePlanSepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}


	$scope.actualizacion_cuotas_Plansepare = 
	{
		cuotaanterior:'',
		id_abonos_plansepare:'',
		nuevacuota:0,
		descuento_abonos:0,
		id_cliente:0,
		id_plansepare:''
	}

	//funcion que va amostrar los datos del abono seleccionado
	$scope.verinformacionCuotaActuali  = function(id_abonos_plansepare,id_plansepare,valor_abono,id_cliente,descuento_abonos,actualizacion_cuotas_Plansepare)
	{
		actualizacion_cuotas_Plansepare.cuotaanterior = valor_abono;
		actualizacion_cuotas_Plansepare.id_abonos_plansepare = id_abonos_plansepare;
		actualizacion_cuotas_Plansepare.id_plansepare = id_plansepare;
		actualizacion_cuotas_Plansepare.descuento_abonos = descuento_abonos;
		actualizacion_cuotas_Plansepare.nuevacuota = valor_abono;
		actualizacion_cuotas_Plansepare.id_cliente = id_cliente;
	}

	// funcion que va a actualizar en base de datos la cuota seleccionada
	$scope.actualizar_CuotaPlansepare  = function(actualizacion_cuotas_Plansepare,listar_plansepare)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=actualizacionCuotaplansepare",
		{
			'cuotaanterior':actualizacion_cuotas_Plansepare.cuotaanterior,
			'id_abonos_plansepare':actualizacion_cuotas_Plansepare.id_abonos_plansepare,
			'id_plansepare':actualizacion_cuotas_Plansepare.id_plansepare,
			'nuevacuota':actualizacion_cuotas_Plansepare.nuevacuota,
			'descuento_abonos':actualizacion_cuotas_Plansepare.descuento_abonos
			
		})
		.success(function (respuestaDatos)
		{	
			console.log(respuestaDatos);
			if (respuestaDatos == 'erro1')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de acualizar la cuota',
					type: 'error',
					styling: 'bootstrap3'
					
				});
			}
			else if (respuestaDatos == 'erro2')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de acualizar la cuota',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaDatos == 'exito')
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallaCuotas_Planes",
				{
					'id_plansepare':actualizacion_cuotas_Plansepare.id_plansepare
				})
				.success(function (Dattos)
				{	
					// alert("entro");
					$scope.ListaPagosPlanes = Dattos;
					console.log($scope.ListaPagosPlanes);

					
					$scope.id_plansepare_sql = $scope.ListaPagosPlanes[0].id_plansepare;
					$scope.total_pagosepare_sql = $scope.ListaPagosPlanes[0].total_pagosepare;
					$scope.valor_aumetoplansepare_sql = $scope.ListaPagosPlanes[0].valor_aumetoplansepare;
					$scope.fecha_inicio_sql = $scope.ListaPagosPlanes[0].fecha_inicio;
					$scope.fecha_fin_sql = $scope.ListaPagosPlanes[0].fecha_fin;
					$scope.descuento_abonos_sql = $scope.ListaPagosPlanes[0].descuento_abonos;
					$scope.id_cliente_sql = $scope.ListaPagosPlanes[0].id_cliente;
					$scope.cc_cliente_sql = $scope.ListaPagosPlanes[0].cc_cliente;
					$scope.nombre_cliente_sql = $scope.ListaPagosPlanes[0].nombre_cliente;



					$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetalle_Planes",
					{
						'id_plansepare':actualizacion_cuotas_Plansepare.id_plansepare
					})
					.success(function (respuesta)
					{	
						$scope.ListaProductosPlanSepare = respuesta;


						$scope.sumacuotas = 0;
						for (var b = 0; b < $scope.ListaProductosPlanSepare.length; b++)
						{
							
							$scope.sumacuotas = parseInt($scope.sumacuotas) + parseInt($scope.ListaProductosPlanSepare[b].valor_abono);
						}

						$scope.sumacuotas;

						$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorfechaRango",
						{
							'fechaInicialPansepare':listar_plansepare.fechaInicialPansepare,
							'fechaFinalPansepare':listar_plansepare.fechaFinalPansepare
						})
						.success(function (datosxrangofech)
						{
							$scope.ListaPlanesDados = datosxrangofech;


							$scope.pageListaPlanesDados  = 1;
							

							$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
							
							$scope.paginaListaPlanesDados  = function() {
							 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
							 console.log($scope.pageListaPlanesDados );
							};

							
								for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
								{
									if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
									{
										$scope.ListaPlanesDados[b].estado = "Pagando";		
									}
									else
									{
										$scope.ListaPlanesDados[b].estado = "Pagando...";	
									}


									if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
									{
										$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
									}
									else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
									{
										$scope.ListaPlanesDados[b].estadocredito = "Activo";	

									}

									if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
									{
										$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
									
									}
									else
									{
										$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
									
									}

								}

								console.log($scope.ListaPlanesDados);
							
						}).error(function(datosxrangofech, status, headers, config)
						{
					      //	console.log("echo todo mal");
					      	new PNotify({
									title: 'Error!',
									text: 'Ha ocurrido un error de funcion guardarFactura',
									type: 'error',
									styling: 'bootstrap3'
								});
					    });
					

					}).error(function(respuesta, status, headers, config)
					{
				      //	console.log("echo todo mal");
				      	new PNotify({
								title: 'Error!',
								text: 'Ha ocurrido un error de funcion verdetallePlanSepare segunda',
								type: 'error',
								styling: 'bootstrap3'
							});
				    });
				}).error(function(Dattos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion verdetallePlanSepare',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });
			}
			else
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacion segunda',
					type: 'error',
					styling: 'bootstrap3'
				});
			}

		}).error(function(respuestaDatos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion actualizar_CuotaPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}	

	$scope.confirmaeliminacionPlanXcliente = 
	{
		id_plansepare:'',
		id_cliente:'',
		fechaInicialPansepare:'',
		fechaFinalPansepare:'',
		estadoproductos:''
	}

	// funcion que va a eliminar el plan separe seleccionado
	$scope.Confirmaeliminar_ProductoPlansepareXcliente = function(id_plansepare,id_cliente,fechaInicialPansepare,fechaFinalPansepare,estadoproductos,confirmaeliminacionPlanXcliente)
	{
		/*console.log(id_plansepare);
		console.log(id_cliente);
		console.log(fechaInicialPansepare);
		console.log(fechaFinalPansepare);
		console.log(estadoproductos);*/
		confirmaeliminacionPlanXcliente.id_plansepare = id_plansepare;
		confirmaeliminacionPlanXcliente.id_cliente = id_cliente;
		confirmaeliminacionPlanXcliente.fechaInicialPansepare = fechaInicialPansepare;
		confirmaeliminacionPlanXcliente.fechaFinalPansepare = fechaFinalPansepare;
		confirmaeliminacionPlanXcliente.estadoproductos = estadoproductos;
	}
	

	
	$scope.confirmaeliminacionPlan = 
	{
		id_plansepare:'',
		id_cliente:'',
		fechaInicialPansepare:'',
		fechaFinalPansepare:'',
		estadoproductos:''
	}

	// funcion que va a eliminar el plan separe seleccionado
	$scope.Confirmaeliminar_ProductoPlansepareXfechas = function(id_plansepare,id_cliente,fechaInicialPansepare,fechaFinalPansepare,estadoproductos,confirmaeliminacionPlan)
	{
		/*console.log(id_plansepare);
		console.log(id_cliente);
		console.log(fechaInicialPansepare);
		console.log(fechaFinalPansepare);
		console.log(estadoproductos);*/
		confirmaeliminacionPlan.id_plansepare = id_plansepare;
		confirmaeliminacionPlan.id_cliente = id_cliente;
		confirmaeliminacionPlan.fechaInicialPansepare = fechaInicialPansepare;
		confirmaeliminacionPlan.fechaFinalPansepare = fechaFinalPansepare;
		confirmaeliminacionPlan.estadoproductos = estadoproductos;
	}
	

	// funcion que va a eliminar el plan separe seleccionado
	$scope.eliminar_ProductoPlansepareXfechas = function(confirmaeliminacionPlan,listar_plansepare)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=eliminado_planseparexcliente",
		{
			'id_plansepare':confirmaeliminacionPlan.id_plansepare,
			'id_cliente':confirmaeliminacionPlan.id_cliente,
			'estadoproductos':confirmaeliminacionPlan.estadoproductos
			
		})
		.success(function (respuestaSQl)
		{	

			console.log(respuestaSQl);
			if (respuestaSQl == 'error1')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de eliminar el plan',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaSQl == 'error2')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de eliminar el plan',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaSQl == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se a eliminado con exito',
					type: 'success',
					styling: 'bootstrap3'
				});

				
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorfechaRango",
				{
					'fechaInicialPansepare':listar_plansepare.fechaInicialPansepare,
					'fechaFinalPansepare':listar_plansepare.fechaFinalPansepare
				})
				.success(function (Dattos)
				{
					$scope.ListaPlanesDados = Dattos;


					$scope.pageListaPlanesDados  = 1;
					

					$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
					
					$scope.paginaListaPlanesDados  = function() {
					 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
					 console.log($scope.pageListaPlanesDados );
					};

					
						for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
						{
							if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
							{
								$scope.ListaPlanesDados[b].estado = "Pagando";		
							}
							else
							{
								$scope.ListaPlanesDados[b].estado = "Pagando...";	
							}


							if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
							{
								$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
							}
							else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
							{
								$scope.ListaPlanesDados[b].estadocredito = "Activo";	

							}

							if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
							{
								$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
							
							}
							else
							{
								$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
							
							}

						}

						console.log($scope.ListaPlanesDados);
					
				}).error(function(Dattos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

			}

		}).error(function(respuestaSQl, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	

	}



// funcion que va a eliminar el plan separe seleccionado
	$scope.eliminar_ProductoPlansepareXclientes = function(confirmaeliminacionPlanXcliente,listar_plansepare)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=eliminado_plansepare",
		{
			'id_plansepare':confirmaeliminacionPlanXcliente.id_plansepare,
			'id_cliente':confirmaeliminacionPlanXcliente.id_cliente,
			'estadoproductos':confirmaeliminacionPlanXcliente.estadoproductos
			
		})
		.success(function (respuestaSQl)
		{	

			console.log(respuestaSQl);
			if (respuestaSQl == 'error1')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de eliminar el plan',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaSQl == 'error2')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de eliminar el plan',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaSQl == 'exito')
			{	

				new PNotify({
					title: 'Exito!',
					text: 'Se a eliminado con exito',
					type: 'success',
					styling: 'bootstrap3'
				});


				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorCliente",
				{
					'id_cliente':confirmaeliminacionPlanXcliente.id_cliente
				})
				.success(function (Dattos)
				{
					$scope.ListaPlanesDadosXcliente = Dattos;
					
						for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
						{
							console.log($scope.ListaPlanesDadosXcliente[b].estadoproductos);
							if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
							{
								$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
							}
							else
							{
								$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
							}


							if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
							{
								$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
							}
							else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
							{
								$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

							}

							if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
							{
								$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
							
							}
							else
							{
								$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
							
							}

							

						}

						console.log($scope.ListaPlanesDadosXcliente);
					
				}).error(function(Dattos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });


			}

		}).error(function(respuestaSQl, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	

	}


	$scope.actualizacion_cuotas_PlansepareXcli = 
	{
		cuotaanterior:'',
		id_abonos_plansepare:'',
		nuevacuota:0,
		descuento_abonos:0,
		id_cliente:0,
		id_plansepare:''
	}
	

	//funcion que va amostrar los datos del abono seleccionado
	$scope.verinformacionCuotaActualiXcliente  = function(id_abonos_plansepare,id_plansepare,valor_abono,id_cliente,descuento_abonos,actualizacion_cuotas_PlansepareXcli)
	{
		actualizacion_cuotas_PlansepareXcli.cuotaanterior = valor_abono;
		actualizacion_cuotas_PlansepareXcli.id_abonos_plansepare = id_abonos_plansepare;
		actualizacion_cuotas_PlansepareXcli.id_plansepare = id_plansepare;
		actualizacion_cuotas_PlansepareXcli.descuento_abonos = descuento_abonos;
		actualizacion_cuotas_PlansepareXcli.nuevacuota = valor_abono;
		actualizacion_cuotas_PlansepareXcli.id_cliente = id_cliente;
	}

	// funcion que va a actualizar en base de datos la cuota seleccionada
	$scope.actualizar_CuotaPlansepareZcliente  = function(actualizacion_cuotas_PlansepareXcli)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=actualizacionCuotaplansepare",
		{
			'cuotaanterior':actualizacion_cuotas_PlansepareXcli.cuotaanterior,
			'id_abonos_plansepare':actualizacion_cuotas_PlansepareXcli.id_abonos_plansepare,
			'id_plansepare':actualizacion_cuotas_PlansepareXcli.id_plansepare,
			'nuevacuota':actualizacion_cuotas_PlansepareXcli.nuevacuota,
			'descuento_abonos':actualizacion_cuotas_PlansepareXcli.descuento_abonos
			
		})
		.success(function (respuestaDatos)
		{	
			console.log(respuestaDatos);
			if (respuestaDatos == 'erro1')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de acualizar la cuota',
					type: 'error',
					styling: 'bootstrap3'

				});
			}
			else if (respuestaDatos == 'erro2')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de acualizar la cuota',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaDatos == 'exito')
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallaCuotas_Planes",
				{
					'id_plansepare':actualizacion_cuotas_PlansepareXcli.id_plansepare
				})
				.success(function (Dattos)
				{	
					// alert("entro");
					$scope.ListaPagosPlanes = Dattos;
					console.log($scope.ListaPagosPlanes);

					
					$scope.id_plansepare_sql = $scope.ListaPagosPlanes[0].id_plansepare;
					$scope.total_pagosepare_sql = $scope.ListaPagosPlanes[0].total_pagosepare;
					$scope.valor_aumetoplansepare_sql = $scope.ListaPagosPlanes[0].valor_aumetoplansepare;
					$scope.fecha_inicio_sql = $scope.ListaPagosPlanes[0].fecha_inicio;
					$scope.fecha_fin_sql = $scope.ListaPagosPlanes[0].fecha_fin;
					$scope.descuento_abonos_sql = $scope.ListaPagosPlanes[0].descuento_abonos;
					$scope.id_cliente_sql = $scope.ListaPagosPlanes[0].id_cliente;
					$scope.cc_cliente_sql = $scope.ListaPagosPlanes[0].cc_cliente;
					$scope.nombre_cliente_sql = $scope.ListaPagosPlanes[0].nombre_cliente;



					$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetalle_Planes",
					{
						'id_plansepare':actualizacion_cuotas_PlansepareXcli.id_plansepare
					})
					.success(function (respuesta)
					{	
						$scope.ListaProductosPlanSepare = respuesta;


						$scope.sumacuotas = 0;
						for (var b = 0; b < $scope.ListaProductosPlanSepare.length; b++)
						{
							
							$scope.sumacuotas = parseInt($scope.sumacuotas) + parseInt($scope.ListaProductosPlanSepare[b].valor_abono);
						}

						$scope.sumacuotas;

						$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorCliente",
						{
							'id_cliente':actualizacion_cuotas_PlansepareXcli.id_cliente
						})
						.success(function (datosxcliente)
						{
							$scope.ListaPlanesDadosXcliente = datosxcliente;
							
								for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
								{
									console.log($scope.ListaPlanesDadosXcliente[b].estadoproductos);
									if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
									{
										$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
									}
									else
									{
										$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
									}


									if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
									{
										$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
									}
									else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
									{
										$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

									}

									if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
									{
										$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
									
									}
									else
									{
										$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
									
									}

									

								}

								console.log($scope.ListaPlanesDadosXcliente);
							
						}).error(function(datosxcliente, status, headers, config)
						{
					      //	console.log("echo todo mal");
					      	new PNotify({
									title: 'Error!',
									text: 'Ha ocurrido un error de funcion guardarFactura',
									type: 'error',
									styling: 'bootstrap3'
								});
					    });
					

					}).error(function(respuesta, status, headers, config)
					{
				      //	console.log("echo todo mal");
				      	new PNotify({
								title: 'Error!',
								text: 'Ha ocurrido un error de funcion verdetallePlanSepare segunda',
								type: 'error',
								styling: 'bootstrap3'
							});
				    });
				}).error(function(Dattos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion verdetallePlanSepare',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });
			}
			else
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacion segunda',
					type: 'error',
					styling: 'bootstrap3'
				});
			}

		}).error(function(respuestaDatos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion actualizar_CuotaPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}	

	// ------------------- crear nueva factura ---------------

	$scope.insertClientes =  
	{
		id_cliente:18,
		identificacion:'12345',
		nombre_clientes:'cliente Estandar'
	}

	// funcion que va a gregar el cliente en el formulario de facturacion
	$scope.agregarClienteFactura = function(id_cliente,cc_cliente,nombre_cliente,insertClientes)
	{
		insertClientes.id_cliente = id_cliente;
		insertClientes.identificacion = cc_cliente;
		insertClientes.nombre_clientes = nombre_cliente;
	}



	$scope.agregarInsertProduFactura = 
	{
		id_productoFactura:'',
		codigo_productoFactura:0,
		nombre_productoFactura:'',
		cantidad_productoFactura:0,
		valor_venta:0
	}


	// agregar al producto para ser insertado en el detalle da a factura
	$scope.agregarProductofacturaForm = function(id_producto,nombre,codigo_producto,valor_venta,agregarInsertProduFactura)
	{
		/*console.log(id_producto);
		console.log(nombre);
		console.log(codigo_producto);
		console.log(valor_venta);*/
		agregarInsertProduFactura.id_productoFactura = id_producto;
		agregarInsertProduFactura.nombre_productoFactura = nombre;
		agregarInsertProduFactura.codigo_productoFactura = codigo_producto;
		agregarInsertProduFactura.cantidad_productoFactura = 1;
		agregarInsertProduFactura.valor_venta = valor_venta;
	}

	// funcion que va a agregar el producto para se el plan
	$scope.listaProductosPlan_separe = [];
	$scope.agregarProductoPlansepareForm = function(id_producto,descripcion,codigo_producto,valor_venta,ivaV,iva,presentacion,fraccion,cant)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=verificarstock_producto",
			{
				'id_producto':id_producto,
				'cantidadU':cant.cantidadU,
				'cantidadF':cant.cantidadF
			})
			.success(function (Dattos)
			{	
				var cantidaddelInventario = Dattos;
				console.log(Dattos);
				console.log(cantidaddelInventario[0].Unidad);

				if (cantidaddelInventario[0].Unidad<cant.cantidadU) {
									new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario de Unidades',
									type: 'error',
									styling: 'bootstrap3'
								});


				


				}else {

				// /*console.log('estadentro');
				// console.log(Dattos);*/
				
				// console.log(cantidaddelInventario);
		        	if (id_producto!= '')
		        	{	
		        		
		        			if ($scope.listaProductosPlan_separe == '') 
		        		{
		        			// alert('eje');
		        			// if (cant.cantidad <= cantidaddelInventario) 
		        			// {
		        				if (fraccion!=0) {
		        					console.log("fraccion !=0");
		        				var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;
		        				if (totalUnidad>cant.cantidadU) {

		        					console.log("fraccion !=0 + cantidad unidad bien ");
		        				
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosPlan_separe.push(
								{
									id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								
								}
						

							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario Por Fraccion',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosPlan_separe);	
						}else if (cant.cantidadU!=0 && cant.cantidadF==0 && fraccion==0){
							console.log("fraccion =0 + unidad !=0");
							var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			// var totalvalorXFraccin = cant.cantidadF * (valor_venta/fraccion);
			        			var totalvalorXcantidad = totalvalorSinIva;
			        			
				        		console.log(typeof(totalMenosIva));
				        		$scope.listaProductosPlan_separe.push(
								{
									id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								
								}else if (fraccion==0){
									new PNotify({
									title: 'Error!',
									text: 'El producto no es fraccionado',
									type: 'error',
									styling: 'bootstrap3'
								});

								}
						


						}
		        		
		        		else
		        		{
							var variablecontador = 0;
							var variablecontadordos = 0;
		        			for (var i = 0; i < $scope.listaProductosPlan_separe.length; i++)
							{
		        			console.log("producto !=0");
								if ($scope.listaProductosPlan_separe[i].id_producto == id_producto) 
								{
									console.log("la lista ya esta llena");
									console.log(cantidaddelInventario[0].stock);
									if ((cant.cantidadU + $scope.listaProductosPlan_separe[i].cantidadU) <= cantidaddelInventario[0].Unidad) 
									{
										console.log("todavia hay inventario");
										if ((cant.cantidadF + $scope.listaProductosPlan_separe[i].cantidadF) <= cantidaddelInventario[0].stock && fraccion!=0) 
									{
										console.log("todavia hay fraccion");
											console.log(cant.cantidadF + $scope.listaProductosPlan_separe[i].cantidadF);
										$scope.listaProductosPlan_separe[i].cantidadU = cant.cantidadU + $scope.listaProductosPlan_separe[i].cantidadU;
										$scope.listaProductosPlan_separe[i].cantidadF = cant.cantidadF + $scope.listaProductosPlan_separe[i].cantidadF;
										var totalMenosIva= valor_venta - ivaV;
						        			var totalvalorXunidad = $scope.listaProductosPlan_separe[i].cantidadU * valor_venta;
						        			var totalvalorXFraccin = $scope.listaProductosPlan_separe[i].cantidadF * (valor_unidad);
						        			var nuevototalvalorXcantidad = totalvalorXunidad + totalvalorXFraccin;
						        		
										$scope.listaProductosPlan_separe[i].valorTotal = nuevototalvalorXcantidad;

										variablecontadordos = variablecontadordos + 1;
										} else if ((cant.cantidadF + $scope.listaProductosPlan_separe[i].cantidadF) > cantidaddelInventario[0].stock && fraccion!=0) 
									{

										console.log("fraccion de inventario es menor");
											var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;

											if (totalUnidad>(cant.cantidadF + $scope.listaProductosPlan_separe[i].cantidadF)) {

											cantidaddelInventario[0].stock=cantidaddelInventario[0].stock+fraccion;
										$scope.listaProductosPlan_separe[i].cantidadU = cant.cantidadU + $scope.listaProductosPlan_separe[i].cantidadU;
										$scope.listaProductosPlan_separe[i].cantidadF = cant.cantidadF + $scope.listaProductosPlan_separe[i].cantidadF;
										var totalMenosIva= valor_venta - ivaV;
						        			var totalvalorXunidad = $scope.listaProductosPlan_separe[i].cantidadU * valor_venta;
						        			var totalvalorXFraccin = $scope.listaProductosPlan_separe[i].cantidadF * (valor_unidad);
						        			var nuevototalvalorXcantidad = totalvalorXunidad + totalvalorXFraccin;
						        		
										$scope.listaProductosPlan_separe[i].valorTotal = nuevototalvalorXcantidad;

										variablecontadordos = variablecontadordos + 1;
										}
										else{
										new PNotify({
											title: 'Error!',
											text: 'La cantidad dijitada excede el inventario de Fraacion',
											type: 'error',
											styling: 'bootstrap3'
										});
									}
									}else if (fraccion==0) 
									{

										console.log("fraccion es cero pero la lista esta llena");
											

											
										$scope.listaProductosPlan_separe[i].cantidadU = cant.cantidadU + $scope.listaProductosPlan_separe[i].cantidadU;
										
										var totalMenosIva= valor_venta - ivaV;
						        			var totalvalorXunidad = $scope.listaProductosPlan_separe[i].cantidadU * valor_venta;
						        		
						        			var nuevototalvalorXcantidad = totalvalorXunidad ;
						        		
										$scope.listaProductosPlan_separe[i].valorTotal = nuevototalvalorXcantidad;

										variablecontadordos = variablecontadordos + 1;
										
									
									}else{
										new PNotify({
											title: 'Error!',
											text: 'La cantidad dijitada excede el inventario',
											type: 'error',
											styling: 'bootstrap3'
										});
									}
									}
									else
							        {
							        	new PNotify({
											title: 'Error!',
											text: 'La cantidad dijitada excede el inventario20',
											type: 'error',
											styling: 'bootstrap3'
										});
							        }
								}	
								else
								{
									// sumamos uno a la varible para identificar que no exixte este registro ya en el arreglo que tenemos
									variablecontador = variablecontador + 1;

								}
								
							}

							// si la variable es mayor que 0 quiere decir qie el registro ya exite
							if (variablecontadordos == 0) 
							{
								console.log("variablecontadordos =0");
								
								if (variablecontador > 0) 
								{
									console.log("variablecontador =0");

									// if (cant.cantidad <= cantidaddelInventario) 
		       //  					{
									var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin = cant.cantidadF * valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
						        		console.log(totalvalorXcantidad);
						        		$scope.listaProductosPlan_separe.push(
										{
											id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion,  cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: totalMenosIva,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
										);

										console.log($scope.listaProductosPlan_separe);
										
									// }
									// else
							  //       {
							  //       	new PNotify({
									// 		title: 'Error!',
									// 		text: 'La cantidad dijitada excede el inventario',
									// 		type: 'error',
									// 		styling: 'bootstrap3'
									// 	});
							  //       }
								}
							}


						}

						$scope.totalapagar = 0;
						for (var k = 0; k < $scope.listaProductosPlan_separe.length; k++)
						{
							$scope.totalapagar = $scope.listaProductosPlan_separe[k].valorTotal + $scope.totalapagar;
						}
		        		var TotalPagarJS=$scope.totalapagar;
		        	}
		        	else
		        	{
		        		new PNotify({
							title: 'Error!',
							text: 'No ha seleccionado ningun producto',
							type: 'error',
							styling: 'bootstrap3'
						});
		        	}
		       }
	        }).error(function(Dattos, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion agregarProductoFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
        // }
        // puedes limpiar el formulario con la tecla B
        // else if (k == 98)
        // {
   //      	agregarInsertProduFactura.id_productoFactura = '';
			// agregarInsertProduFactura.codigo_productoFactura = 0;
			// agregarInsertProduFactura.nombre_productoFactura = '';
			// agregarInsertProduFactura.valor_venta = 0;
			// agregarInsertProduFactura.cantidad_productoFactura = 0;
        // }
      
	}  
      
	

	// funcion que va a gregar el producto al arreglo de detalle factura
	$scope.listaProductosDetalleFactura = [];
	$scope.agregarProductoFactura = function(elEvento,id_producto,descripcion,codigo_producto,valor_venta,ivaV,iva,presentacion,fraccion,valor_unidad,cant)
	{
		elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
        		
        	if (cant.cantidadU<=0 && cant.cantidadF<=0 ) {
        			new PNotify({
									title: 'Error!',
									text: 'Las cantidades estan en Cero (0)',
									type: 'error',
									styling: 'bootstrap3'
								});

        	}else{
        		if (fraccion==0) {
        			cant.cantidadF=0;
        		}


        	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=verificarstock_producto",
			{
				'id_producto':id_producto,
				'cantidadU':cant.cantidadU,
				'cantidadF':cant.cantidadF
			})
			.success(function (Dattos)
			{	
				var cantidaddelInventario = Dattos;
				console.log(Dattos);
				console.log(cantidaddelInventario[0].Unidad);
				console.log(cant.cantidadU);

				if (cantidaddelInventario[0].Unidad<cant.cantidadU) {
									new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario de Unidades3',
									type: 'error',
									styling: 'bootstrap3'
								});


				}else {
					
				// /*console.log('estadentro');
				// console.log(Dattos);*/
				var cantidaddelInventario = Dattos;
				console.log(cantidaddelInventario);
		        	if (id_producto!= '')
		        	{	
		        		if ($scope.listaProductosDetalleFactura == '') 
		        		{
		        			$scope.showVistaF.show=false;
		        			$scope.numeroPro=1
		        			// alert('eje');
		        			// if (cant.cantidad <= cantidaddelInventario) 
		        			// {
		        				if (fraccion!=0) {
		        					var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;
		        					console.log("fraccion !=0");
		        					console.log(totalUnidad);
		        					console.log(cant.cantidadU);
		        					console.log(cantidaddelInventario[0].stock);
		        					console.log(cant.cantidadF);
		        				
		        				if (totalUnidad>cant.cantidadU) {

		        					console.log("fraccion !=0 + cantidad unidad bien ");
		        				
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								
								}else if (totalUnidad<=cant.cantidadU && cantidaddelInventario[0].stock>cant.cantidadF) {

									console.log("fraccion !=0 + cantidad fraccion bien ");
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
						

							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario Por Fraccion',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosDetalleFactura);	
						}else if (cant.cantidadU!=0 && cant.cantidadF==0 && fraccion==0){
							console.log("fraccion =0 + unidad !=0");
							var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			// var totalvalorXFraccin = cant.cantidadF * (valor_venta/fraccion);
			        			var totalvalorXcantidad = totalvalorSinIva;
			        			
				        		console.log(typeof(totalMenosIva));
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
								);
								
								$scope.numeroPro++;
								}else if (fraccion==0){
									new PNotify({
									title: 'Error!',
									text: 'El producto no es fraccionado',
									type: 'error',
									styling: 'bootstrap3'
								});

								}
						


						}
		        		
		        		else
		        		{
		        			$scope.showVistaF.show=false;
		        			$scope.numeroPro=$scope.numeroPro;
							var variablecontador = 0;
							var variablecontadordos = 0;
		        			if (fraccion!=0) {
		        					console.log("fraccion !=0");
		        				var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;
		        				if (totalUnidad>cant.cantidadU) {

		        					console.log("fraccion !=0 + cantidad unidad bien ");
		        				
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log($scope.numeroPro);
				        		var numeroProN =$scope.listaProductosDetalleFactura.numeroPro+1;
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
								else if (totalUnidad<=cant.cantidadU && cantidaddelInventario[0].stock>cant.cantidadF) {

									console.log("fraccion !=0 + cantidad fraccion bien ");
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));
				        			var numeroProN =$scope.listaProductosDetalleFactura.numeroPro+1;
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
						

							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario Por Fraccion',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosDetalleFactura);	
						}else if (cant.cantidadU!=0 && cant.cantidadF==0 && fraccion==0){
							console.log("fraccion =0 + unidad !=0");
							var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			// var totalvalorXFraccin = cant.cantidadF * (valor_venta/fraccion);
			        			var totalvalorXcantidad = totalvalorSinIva;
			        			var numeroPro =numeroPro+1;
				        		console.log(numeroPro);
				        		console.log($scope.listaProductosDetalleFactura.numeroPro);
				        		var numeroProN =$scope.listaProductosDetalleFactura.numeroPro+1;
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
								);
								$scope.numeroPro++;
								}else if (fraccion==0){
									new PNotify({
									title: 'Error!',
									text: 'El producto no es fraccionado',
									type: 'error',
									styling: 'bootstrap3'
								});

								}
						
}
						$scope.totalapagar = 0;
						for (var k = 0; k < $scope.listaProductosDetalleFactura.length; k++)
						{
							$scope.totalapagar = $scope.listaProductosDetalleFactura[k].valorTotal + $scope.totalapagar;
						}
		        		var TotalPagarJS=$scope.totalapagar;
		        	}
		        	else
		        	{
		        		new PNotify({
							title: 'Error!',
							text: 'No ha seleccionado ningun producto',
							type: 'error',
							styling: 'bootstrap3'
						});
		        	}
		       }

	        }).error(function(Dattos, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion agregarProductoFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
        // }
        // puedes limpiar el formulario con la tecla B
        // else if (k == 98)
        // {
   //      	agregarInsertProduFactura.id_productoFactura = '';
			// agregarInsertProduFactura.codigo_productoFactura = 0;
			// agregarInsertProduFactura.nombre_productoFactura = '';
			// agregarInsertProduFactura.valor_venta = 0;
			// agregarInsertProduFactura.cantidad_productoFactura = 0;
        // }
      
	}  
}
}
// funcion que va a gregar el producto al arreglo de detalle factura

	$scope.agregarProductoFacturaPress = function(id_producto,descripcion,codigo_producto,valor_venta,ivaV,iva,presentacion,fraccion,valor_unidad,cant)
	{
			// elEvento,
		//  evento = elEvento || window.Event;
  //        k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
  //       if (k == 13)
  //       {
        	// alert("ok");
        	// console.log(agregarInsertProduFactura);
        	if (cant.cantidadU<=0 && cant.cantidadF<=0 ) {
        			new PNotify({
									title: 'Error!',
									text: 'Las cantidades estan en Cero (0)',
									type: 'error',
									styling: 'bootstrap3'
								});

        	}else{

        		if (fraccion==0) {
        			cant.cantidadF=0;
        		}

        	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=verificarstock_producto",
			{
				'id_producto':id_producto,
				'cantidadU':cant.cantidadU,
				'cantidadF':cant.cantidadF
			})
			.success(function (Dattos)
			{	
				var cantidaddelInventario = Dattos;
				console.log(Dattos);
				console.log(cantidaddelInventario[0].Unidad);
				console.log(cant.cantidadU);

				if (cantidaddelInventario[0].Unidad<cant.cantidadU) {
									new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario de Unidades3',
									type: 'error',
									styling: 'bootstrap3'
								});


				}else {
					
				// /*console.log('estadentro');
				// console.log(Dattos);*/
				var cantidaddelInventario = Dattos;
				console.log(cantidaddelInventario);
		        	if (id_producto!= '')
		        	{	
		        		if ($scope.listaProductosDetalleFactura == '') 
		        		{
		        			$scope.showVistaF.show=false;
		        			$scope.numeroPro=1
		        			// alert('eje');
		        			// if (cant.cantidad <= cantidaddelInventario) 
		        			// {
		        				if (fraccion!=0) {
		        					var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;
		        					console.log("fraccion !=0");
		        					console.log(totalUnidad);
		        					console.log(cant.cantidadU);
		        					console.log(cantidaddelInventario[0].stock);
		        					console.log(cant.cantidadF);
		        				
		        				if (totalUnidad>cant.cantidadU) {

		        					console.log("fraccion !=0 + cantidad unidad bien ");
		        				
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								
								}else if (totalUnidad<=cant.cantidadU && cantidaddelInventario[0].stock>cant.cantidadF) {

									console.log("fraccion !=0 + cantidad fraccion bien ");
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
						

							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario Por Fraccion',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosDetalleFactura);	
						}else if (cant.cantidadU!=0 && cant.cantidadF==0 && fraccion==0){
							console.log("fraccion =0 + unidad !=0");
							var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			// var totalvalorXFraccin = cant.cantidadF * (valor_venta/fraccion);
			        			var totalvalorXcantidad = totalvalorSinIva;
			        			
				        		console.log(typeof(totalMenosIva));
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
								);
								
								$scope.numeroPro++;
								}else if (fraccion==0){
									new PNotify({
									title: 'Error!',
									text: 'El producto no es fraccionado',
									type: 'error',
									styling: 'bootstrap3'
								});

								}
						


						}
		        		
		        		else
		        		{
		        			$scope.showVistaF.show=false;
		        			$scope.numeroPro=$scope.numeroPro;
							var variablecontador = 0;
							var variablecontadordos = 0;
		        			if (fraccion!=0) {
		        					console.log("fraccion !=0");
		        				var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;
		        				if (totalUnidad>cant.cantidadU) {

		        					console.log("fraccion !=0 + cantidad unidad bien ");
		        				
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log($scope.numeroPro);
				        		var numeroProN =$scope.listaProductosDetalleFactura.numeroPro+1;
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
								else if (totalUnidad<=cant.cantidadU && cantidaddelInventario[0].stock>cant.cantidadF) {

									console.log("fraccion !=0 + cantidad fraccion bien ");
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));
				        			var numeroProN =$scope.listaProductosDetalleFactura.numeroPro+1;
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
						

							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario Por Fraccion',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosDetalleFactura);	
						}else if (cant.cantidadU!=0 && cant.cantidadF==0 && fraccion==0){
							console.log("fraccion =0 + unidad !=0");
							var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			// var totalvalorXFraccin = cant.cantidadF * (valor_venta/fraccion);
			        			var totalvalorXcantidad = totalvalorSinIva;
			        			var numeroPro =numeroPro+1;
				        		console.log(numeroPro);
				        		console.log($scope.listaProductosDetalleFactura.numeroPro);
				        		var numeroProN =$scope.listaProductosDetalleFactura.numeroPro+1;
				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,valor_unidad:valor_unidad,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
								);
								$scope.numeroPro++;
								}else if (fraccion==0){
									new PNotify({
									title: 'Error!',
									text: 'El producto no es fraccionado1',
									type: 'error',
									styling: 'bootstrap3'
								});

								}
						
}
						$scope.totalapagar = 0;
						for (var k = 0; k < $scope.listaProductosDetalleFactura.length; k++)
						{
							$scope.totalapagar = $scope.listaProductosDetalleFactura[k].valorTotal + $scope.totalapagar;
						}
		        		var TotalPagarJS=$scope.totalapagar;
		        	}
		        	else
		        	{
		        		new PNotify({
							title: 'Error!',
							text: 'No ha seleccionado ningun producto',
							type: 'error',
							styling: 'bootstrap3'
						});
		        	}
		       }

	        }).error(function(Dattos, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion agregarProductoFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
        // }
        // puedes limpiar el formulario con la tecla B
        // else if (k == 98)
        // {
   //      	agregarInsertProduFactura.id_productoFactura = '';
			// agregarInsertProduFactura.codigo_productoFactura = 0;
			// agregarInsertProduFactura.nombre_productoFactura = '';
			// agregarInsertProduFactura.valor_venta = 0;
			// agregarInsertProduFactura.cantidad_productoFactura = 0;
        // }
      
	}  
}

// funcion que va a gregar el producto al arreglo de detalle factura

	$scope.agregarProductoFacturaChange = function(numeroPro,id_producto,descripcion,codigo_producto,valor_venta,ivaV,iva,presentacion,fraccion,valor_unidad,cantidadU,cantidadF)
	{
		// elEvento,
		//  evento = elEvento || window.Event;
  //        k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
  //       if (k == 13)
  //       {
        	// alert("ok");
        	console.log(id_producto,descripcion,codigo_producto,valor_venta,ivaV,iva,presentacion,fraccion,valor_unidad,cantidadU,cantidadF);
        	if (cantidadU<=0 && cantidadF<=0 ) {
        			new PNotify({
									title: 'Error!',
									text: 'Las cantidades estan en Cero (0)',
									type: 'error',
									styling: 'bootstrap3'
								});

        	}else{


        	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=verificarstock_producto",
			{
				'id_producto':id_producto,
				'cantidadU':cantidadU,
				'cantidadF':cantidadF
			})
			.success(function (Dattos)
			{	
				var cantidaddelInventario = Dattos;
				console.log(Dattos);
				console.log(cantidaddelInventario[0].Unidad);

				if (cantidaddelInventario[0].Unidad<cantidadU) {
									new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario de Unidades',
									type: 'error',
									styling: 'bootstrap3'
								});


				}else {
				// /*console.log('estadentro');
				// console.log(Dattos);*/
				var cantidaddelInventario = Dattos;
				console.log(cantidaddelInventario);
		        	if (id_producto!= '')
		        	{	
		        		if ($scope.listaProductosDetalleFactura == '') 
		        		{
		        			// alert('eje');
		        			// if (cant.cantidad <= cantidaddelInventario) 
		        			// {
		        				if (fraccion!=0) {
		        					console.log("fraccion !=0");
		        				var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;
		        				if (totalUnidad>cantidadU) {

		        					console.log("fraccion !=0 + cantidad unidad bien ");
		        				
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro,id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cantidadU,cantidadF:cantidadF, valor_venta: valor_venta,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
								);
								$scope.numeroPro++;
								}else if (totalUnidad<=cant.cantidadU && cantidaddelInventario[0].stock>cant.cantidadF) {

									console.log("fraccion !=0 + cantidad fraccion bien ");
		        				var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cant.cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cant.cantidadU * valor_venta;
			        			var totalvalorXFraccin =  cant.cantidadF *valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
				        		console.log(typeof(totalMenosIva));

				        		$scope.listaProductosDetalleFactura.push(
								{
									numeroPro:$scope.numeroPro, id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU: cant.cantidadU,cantidadF:cant.cantidadF, valor_venta: valor_venta,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad, fraccion: fraccion}
								);
								$scope.numeroPro++;
								}
						
						

							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'La cantidad dijitada excede el inventario Por Fraccion',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosDetalleFactura);	
						}else if (cantidadU!=0 && cantidadF==0 && fraccion==0){
							console.log("fraccion =0 + unidad !=0");
							var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cantidadU * valor_venta;
			        			// var totalvalorXFraccin = cant.cantidadF * (valor_venta/fraccion);
			        			var totalvalorXcantidad = totalvalorSinIva;
			        			
				        		console.log(typeof(totalMenosIva));
				        		$scope.listaProductosDetalleFactura.push(
								{
									id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion, cantidadU:cantidadU,cantidadF:cantidadF, valor_venta: valor_venta,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
								);
								
								}else if (fraccion==0){
									new PNotify({
									title: 'Error!',
									text: 'El producto no es fraccionado',
									type: 'error',
									styling: 'bootstrap3'
								});

								}
						


						}
		        		
		        		else
		        		{
							var variablecontador = 0;
							var variablecontadordos = 0;
		        			for (var i = 0; i < $scope.listaProductosDetalleFactura.length; i++)
							{
		        			console.log("producto !=0");
								if ($scope.listaProductosDetalleFactura[i].id_producto == id_producto && $scope.listaProductosDetalleFactura[i].numeroPro==numeroPro) 
								{
									console.log("la lista ya esta llena");
									console.log(cantidaddelInventario[0].stock);
									if ((cantidadU) <= cantidaddelInventario[0].Unidad) 
									{
										console.log("todavia hay inventario");
										if (cantidadF  <= cantidaddelInventario[0].stock && fraccion!=0) 
									{
										console.log("todavia hay fraccion");
										console.log(cantidadU);
											console.log(cantidadF + $scope.listaProductosDetalleFactura[i].cantidadF);
										$scope.listaProductosDetalleFactura[i].cantidadU = cantidadU;
										$scope.listaProductosDetalleFactura[i].cantidadF = cantidadF;
										var totalMenosIva= valor_venta - ivaV;
						        			var totalvalorXunidad = $scope.listaProductosDetalleFactura[i].cantidadU * valor_venta;
						        			var totalvalorXFraccin = $scope.listaProductosDetalleFactura[i].cantidadF * (valor_unidad);
						        			var nuevototalvalorXcantidad = totalvalorXunidad + totalvalorXFraccin;
						        		console.log(nuevototalvalorXcantidad);
										$scope.listaProductosDetalleFactura[i].valorTotal = nuevototalvalorXcantidad;

										variablecontadordos = variablecontadordos + 1;
										} else if (cantidadF  > cantidaddelInventario[0].stock && fraccion!=0) 
									{

										console.log("fraccion de inventario es menor");
											var totalUnidad=cantidaddelInventario[0].Unidad * fraccion;

											if (totalUnidad>(cantidadF)) {

											cantidaddelInventario[0].stock=cantidaddelInventario[0].stock+fraccion;
										$scope.listaProductosDetalleFactura[i].cantidadU = cantidadU;
										$scope.listaProductosDetalleFactura[i].cantidadF = cantidadF;
										var totalMenosIva= valor_venta - ivaV;
						        			var totalvalorXunidad = $scope.listaProductosDetalleFactura[i].cantidadU * valor_venta;
						        			var totalvalorXFraccin = $scope.listaProductosDetalleFactura[i].cantidadF * (valor_unidad);
						        			var nuevototalvalorXcantidad = totalvalorXunidad + totalvalorXFraccin;
						        		
										$scope.listaProductosDetalleFactura[i].valorTotal = nuevototalvalorXcantidad;

										variablecontadordos = variablecontadordos + 1;
										}
										else{
										new PNotify({
											title: 'Error!',
											text: 'La cantidad dijitada excede el inventario de Fraacion',
											type: 'error',
											styling: 'bootstrap3'
										});
									}
									}else if (fraccion==0) 
									{

										console.log("fraccion es cero pero la lista esta llena");
											

											
										$scope.listaProductosDetalleFactura[i].cantidadU = cantidadU;
										
										var totalMenosIva= valor_venta - ivaV;
						        			var totalvalorXunidad = $scope.listaProductosDetalleFactura[i].cantidadU * valor_venta;
						        		
						        			var nuevototalvalorXcantidad = totalvalorXunidad;
						        		
										$scope.listaProductosDetalleFactura[i].valorTotal = nuevototalvalorXcantidad;

										variablecontadordos = variablecontadordos + 1;
										
									
									}else{
										new PNotify({
											title: 'Error!',
											text: 'La cantidad dijitada excede el inventario',
											type: 'error',
											styling: 'bootstrap3'
										});
									}
									}
									else
							        {
							        	new PNotify({
											title: 'Error!',
											text: 'La cantidad dijitada excede el inventario204',
											type: 'error',
											styling: 'bootstrap3'
										});
							        }
								}	
								else
								{
									// sumamos uno a la varible para identificar que no exixte este registro ya en el arreglo que tenemos
									variablecontador = variablecontador + 1;

								}
								
							}

							// si la variable es mayor que 0 quiere decir qie el registro ya exite
							if (variablecontadordos == 0) 
							{
								console.log("variablecontadordos =0");
								
								if (variablecontador > 0) 
								{
									console.log("variablecontador =0");

									// if (cant.cantidad <= cantidaddelInventario) 
		       //  					{
									var totalMenosIva= parseInt(valor_venta) - parseInt(ivaV);
			        			var totalvalorXunidad = cantidadU * totalMenosIva;
			        			var totalvalorSinIva = cantidadU * valor_venta;
			        			var totalvalorXFraccin = cantidadF * valor_unidad;
			        			var totalvalorXcantidad = totalvalorSinIva +parseInt(totalvalorXFraccin);
						        		console.log(totalvalorXcantidad);
						        		$scope.listaProductosDetalleFactura.push(
										{
											id_producto: id_producto,codigoProducto: codigo_producto, descripcion: descripcion,  cantidadU: cantidadU,cantidadF:cantidadF, valor_venta: totalMenosIva,iva: iva,ivaV: ivaV,presentacion: presentacion, valorTotal: totalvalorXcantidad,fraccion: fraccion}
										);

										console.log($scope.listaProductosDetalleFactura);
										
									// }
									// else
							  //       {
							  //       	new PNotify({
									// 		title: 'Error!',
									// 		text: 'La cantidad dijitada excede el inventario',
									// 		type: 'error',
									// 		styling: 'bootstrap3'
									// 	});
							  //       }
								}
							}


						}

						$scope.totalapagar = 0;
						for (var k = 0; k < $scope.listaProductosDetalleFactura.length; k++)
						{
							$scope.totalapagar = $scope.listaProductosDetalleFactura[k].valorTotal + $scope.totalapagar;
						}
		        		var TotalPagarJS=$scope.totalapagar;
		        	}
		        	else
		        	{
		        		new PNotify({
							title: 'Error!',
							text: 'No ha seleccionado ningun producto',
							type: 'error',
							styling: 'bootstrap3'
						});
		        	}
		       }
	        }).error(function(Dattos, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion agregarProductoFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
        // }
        // puedes limpiar el formulario con la tecla B
        // else if (k == 98)
        // {
   //      	agregarInsertProduFactura.id_productoFactura = '';
			// agregarInsertProduFactura.codigo_productoFactura = 0;
			// agregarInsertProduFactura.nombre_productoFactura = '';
			// agregarInsertProduFactura.valor_venta = 0;
			// agregarInsertProduFactura.cantidad_productoFactura = 0;
        // }
      
	}  
}

// funcion que va a gregar el producto al arreglo de detalle factura



	$scope.listaSerialDetalleFactura = [];
$scope.cambioFacturaDinero={
	Pagocambio:0,
	cambio:0
}

	$scope.cambioFactura = function(cambioFacturaDinero){
		var pago=parseFloat(cambioFacturaDinero.Pagocambio);
		console.log(pago);

		cambioFacturaDinero.cambio=cambioFacturaDinero.Pagocambio - $scope.totalapagar;


	}
	$scope.agregarSerialFactura = function(id_serial,id_producto,nombre,serial)
	{
		
   //      	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=verificarstock_producto",
			// {
			// 	'id_producto':id_producto,
			// 	'cantidad':cant.cantidad
			// })
			// .success(function (Dattos)
			// {	
				/*console.log('estadentro');
				console.log(Dattos);*/
				// var cantidaddelInventario = Dattos;
				// console.log(cantidaddelInventario);
		        	if (id_serial!= '')
		        	{	
		        		if ($scope.listaSerialDetalleFactura == '') 
		        		{
		        			// alert('eje');
		        			
			        			
				        		$scope.listaSerialDetalleFactura.push(
								{
									id_serial:id_serial,id_producto:id_producto,nombre:nombre,serial:serial}
								);
								

							
				        			}else{
				        				$scope.listaSerialDetalleFactura.push(
								{
									id_serial:id_serial,id_producto:id_producto,nombre:nombre,serial:serial}
								);
				        			}
				        		}
							else
					        {
					        	new PNotify({
									title: 'Error!',
									text: 'Algo pasa Con el Serial Seleccionado',
									type: 'error',
									styling: 'bootstrap3'
								});
					        }

							// console.log($scope.listaProductosDetalleFactura);	
		        		
		        	
		        		
		        	console.log($scope.listaSerialDetalleFactura);
		       
	  //       }).error(function(Dattos, status, headers, config)
			// {
		 //      //	console.log("echo todo mal");
		 //      	new PNotify({
			// 			title: 'Error!',
			// 			text: 'Ha ocurrido un error de funcion agregarProductoFactura',
			// 			type: 'error',
			// 			styling: 'bootstrap3'
			// 		});
		 //    });
        // }
        // puedes limpiar el formulario con la tecla B
        // else if (k == 98)
        // {
   //      	agregarInsertProduFactura.id_productoFactura = '';
			// agregarInsertProduFactura.codigo_productoFactura = 0;
			// agregarInsertProduFactura.nombre_productoFactura = '';
			// agregarInsertProduFactura.valor_venta = 0;
			// agregarInsertProduFactura.cantidad_productoFactura = 0;
        // }
      
	}  

	//funcion que va aeliminar el registro del arreglo de productos a facturar
	$scope.eliminarProductoProFacturar  = function (numeroPro,id_producto,valorTotal)
	{

		// eliminamos el producto
		for (var b = 0; b < $scope.listaProductosDetalleFactura.length; b++)
		{
			if (($scope.listaProductosDetalleFactura[b].id_producto == id_producto && $scope.listaProductosDetalleFactura[b].numeroPro == numeroPro ))
			{
				$scope.listaProductosDetalleFactura.splice(b,1);
			}
			
		}

		$scope.totalapagar = 0;
		for (var k = 0; k < $scope.listaProductosDetalleFactura.length; k++)
		{
			$scope.totalapagar = $scope.listaProductosDetalleFactura[k].valorTotal + $scope.totalapagar;
		}

		new PNotify({
			title: 'Error!',
			text: 'Se ha eliminado con exito el registro',
			type: 'success',
			styling: 'bootstrap3'
		});
	}
$scope.eliminarSerialProducto  = function (id_productoserial)
	{
		// eliminamos el producto
		console.log(id_productoserial);
		for (var b = 0; b < $scope.listaSerialDetalleFactura.length; b++)
		{
			if (($scope.listaSerialDetalleFactura[b].id_serial == id_productoserial))
			{
				$scope.listaSerialDetalleFactura.splice(b,1);
			}
			
		}

		

		new PNotify({
			title: 'Error!',
			text: 'Se ha eliminado con exito',
			type: 'success',
			styling: 'bootstrap3'
		});
	}

	//funcion que va aeliminar el registro del arreglo de productos a para plansepare
	$scope.eliminarProductoPlansepare  = function (id_producto,valorTotal)
	{
		// eliminamos el producto
		for (var b = 0; b < $scope.listaProductosPlan_separe.length; b++)
		{
			if (($scope.listaProductosPlan_separe[b].id_producto == id_producto))
			{
				$scope.listaProductosPlan_separe.splice(b,1);
			}
			
		}

		$scope.totalapagar = 0;
		for (var k = 0; k < $scope.listaProductosPlan_separe.length; k++)
		{
			$scope.totalapagar = $scope.listaProductosPlan_separe[k].valorTotal + $scope.totalapagar;
		}

		new PNotify({
			title: 'Error!',
			text: 'Se ha eliminado con exito el registro',
			type: 'success',
			styling: 'bootstrap3'
		});
	}
$scope.guardarFacturaSelect=function(AddFacturaSelect){

	var txt;
var r = confirm("¿Relamente Desea Pasar esta Factura a Invetario ?!");
if (r == true) {
   for (var b = 0; b < $scope.listadodetodos_SelectFacturaAdd.length; b++)
			{
				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertadorIngresos",{
					'id_facturaD':AddFacturaSelect.id_ingresosAdd,
					'id_producto':$scope.listadodetodos_SelectFacturaAdd[b].id_producto,
					'cantidadUnidad':$scope.listadodetodos_SelectFacturaAdd[b].cantidadUnidad,
					'cantidadFraccion':$scope.listadodetodos_SelectFacturaAdd[b].cantidadFraccion,
				})
		.success(function (datos)
		{		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'guardo')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha guardado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				
					// alert("Desea eliminar los registros ?")
			}
			


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });
				
			}
} else {
    
}
	
}
$scope.vaciarFacturaSelect=function(AddFacturaSelect){
	
				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=vaciarProductoFacturaSelect",{
					'id_ingresosAdd':AddFacturaSelect.id_ingresosAdd,
					
				})
		.success(function (datos)
		{		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha vaciado los productos',
					type: 'success',
					styling: 'bootstrap3'
				});
				$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
				
					// alert("Desea eliminar los registros ?")
			}
			


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });
				
}
$scope.EliminarFacturaSelect=function(AddFacturaSelect){
	
				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=eliminarProductoFacturaSelect",{
					'id_ingresosAdd':AddFacturaSelect.id_ingresosAdd,
					
				})
		.success(function (datos)
		{		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha ELiminado los productos',
					type: 'success',
					styling: 'bootstrap3'
				});
				$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
				
					// alert("Desea eliminar los registros ?")
			}
			


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });
				
}
$scope.EliminarTotalFacturaSelect=function(id_ingresofactura){
	
				$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=eliminartotalProductoFacturaSelect",{
					'id_ingresosAdd':id_ingresofactura
					
				}).success(function (datos){		
			console.log(datos);

			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'No se ha guardado con exito el registro',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'se ha ELiminado los productos',
					type: 'success',
					styling: 'bootstrap3'
				});
				// $scope.listadodetodos_SelectFacturaAdd={};
				$scope.listadotodos_IngresosFacturaAdd();
				// $scope.AddFacturaSelect={};
					// alert("Desea eliminar los registros ?")
				}
			
			


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'error de funcion guardarIngresos',
					type: 'error',
					styling: 'bootstrap3'
				});	
	    });
				
}

	// funcion que va a guardar la factura y el detalle de los productos a facturar
	$scope.guardarFacturaPress = function(insertClientes,cambioFacturaDinero)
	{
	
// SELECT * FROM tbl_producto pro, tbl_factura fac, tbl_detallefactura def, tbl_iva iva WHERE def.id_factura=fac.id_factura AND def.id_producto=pro.id_producto AND pro.id_iva=iva.id_iva AND iva.iva=0
	
		if ($scope.listaProductosDetalleFactura!="") {
		console.log(cambioFacturaDinero);
		var pagoFactura=parseInt(cambioFacturaDinero.Pagocambio);
		console.log(pagoFactura);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarfactura",
		{
			'id_cliente':insertClientes.id_cliente,
			'totalpago':$scope.totalapagar,
			'pagoCambio':cambioFacturaDinero.Pagocambio,
			'cambio':cambioFacturaDinero.cambio
		})
		.success(function (datos)
		{		
			console.log(datos);
			var id_factura = datos;

			for (var b = 0; b < $scope.listaProductosDetalleFactura.length; b++)
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarDetallefactura",
				{
					'id_producto':$scope.listaProductosDetalleFactura[b].id_producto,
					'cantidadU':$scope.listaProductosDetalleFactura[b].cantidadU,
					'cantidadF':$scope.listaProductosDetalleFactura[b].cantidadF,
					'valorTotal':$scope.listaProductosDetalleFactura[b].valorTotal,
					'id_factura':id_factura
				})
				.success(function (respuesta)
				{		
					console.log(respuesta);

					var mensajeexito = 0
					if (respuesta == 'exito')
					{
						new PNotify({
							title: 'Exito!',
							text: 'Se ha guardado con exito el registro de los productos',
							type: 'success',
							styling: 'bootstrap3'
						});
					}
					else if (respuesta == 'fallo') 
					{
						new PNotify({
							title: 'Error!',
							text: 'No se ha podido guardar el registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});
					}
					else
					{
						new PNotify({
							title: 'Exito!',
							text: 'Eror! No se ha guardado registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});



					}


				}).error(function(respuesta, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

				
			}
			$scope.listaProductosDetalleFactura=[];
			// for (var k = 0; k < $scope.listaProductosDetalleFactura.length; k++)
			// 			{

			// 				var pos = $scope.listaProductosDetalleFactura.indexOf(k);
			// 				 $scope.listaProductosDetalleFactura.splice(pos);
							 

			// 			}
						$scope.totalapagar=0;
						cambioFacturaDinero.Pagocambio=0;
						cambioFacturaDinero.cambio=0;

			for (var b = 0; b < $scope.listaSerialDetalleFactura.length; b++)
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarSerialfactura",
				{
					'id_producto':$scope.listaSerialDetalleFactura[b].id_producto,
					'id_serial':$scope.listaSerialDetalleFactura[b].id_serial,
					'id_factura':id_factura
				})
				.success(function (respuesta)
				{		
					console.log(respuesta);

					var mensajeexito = 0
					if (respuesta == 'exito')
					{
						new PNotify({
							title: 'Exito!',
							text: 'Se ha guardado con exito el registro de los productos',
							type: 'success',
							styling: 'bootstrap3'
						});
					}
					else if (respuesta == 'fallo') 
					{
						new PNotify({
							title: 'Error!',
							text: 'No se ha podido guardar el registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});
					}
					else
					{
						new PNotify({
							title: 'Exito!',
							text: 'Eror! No se ha guardado registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});

					}


				}).error(function(respuesta, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

				
			}

			window.open('views/informespdf/BaseFactura.php?factura='+id_factura,'_blank');


			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=ultimaFacturaF")
		.success(function (datos)
		{		
			
				$scope.ultimaFacturaDatos = datos;
								
				console.log(datos);

				$scope.pageultimaFacturaDatos = 1;
			

				$scope.itemsultimaFacturaDatos = $scope.ultimaFacturaDatos.slice(0, 25);
				
				$scope.paginaultimaFacturaDatos = function() {
				  var startPos = ($scope.pageultimaFacturaDatos - 1) * 25;
				  console.log($scope.pageultimaFacturaDatos);
				}
			 $scope.ventaDia();
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
}

	}// funcion que va a guardar la factura y el detalle de los productos a facturar
	// funcion que va a guardar la factura y el detalle de los productos a facturar
	$scope.guardarFactura = function(elEvento,insertClientes,cambioFacturaDinero)
	{
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
		if ($scope.listaProductosDetalleFactura!="") {
		console.log(cambioFacturaDinero);
		var pagoFactura=parseInt(cambioFacturaDinero.Pagocambio);
		console.log(pagoFactura);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarfactura",
		{
			'id_cliente':insertClientes.id_cliente,
			'totalpago':$scope.totalapagar,
			'pagoCambio':cambioFacturaDinero.Pagocambio,
			'cambio':cambioFacturaDinero.cambio
		})
		.success(function (datos)
		{		
			console.log(datos);
			var id_factura = datos;

			for (var b = 0; b < $scope.listaProductosDetalleFactura.length; b++)
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarDetallefactura",
				{
					'id_producto':$scope.listaProductosDetalleFactura[b].id_producto,
					'cantidadU':$scope.listaProductosDetalleFactura[b].cantidadU,
					'cantidadF':$scope.listaProductosDetalleFactura[b].cantidadF,
					'valorTotal':$scope.listaProductosDetalleFactura[b].valorTotal,
					'id_factura':id_factura
				})
				.success(function (respuesta)
				{		
					console.log(respuesta);

					var mensajeexito = 0
					if (respuesta == 'exito')
					{
						new PNotify({
							title: 'Exito!',
							text: 'Se ha guardado con exito el registro de los productos',
							type: 'success',
							styling: 'bootstrap3'
						});
					}
					else if (respuesta == 'fallo') 
					{
						new PNotify({
							title: 'Error!',
							text: 'No se ha podido guardar el registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});
					}
					else
					{
						new PNotify({
							title: 'Exito!',
							text: 'Eror! No se ha guardado registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});



					}


				}).error(function(respuesta, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

				
			}
			$scope.listaProductosDetalleFactura=[];
			// for (var k = 0; k < $scope.listaProductosDetalleFactura.length; k++)
			// 			{

			// 				var pos = $scope.listaProductosDetalleFactura.indexOf(k);
			// 				 $scope.listaProductosDetalleFactura.splice(pos);
							 

			// 			}
						$scope.totalapagar=0;
						cambioFacturaDinero.Pagocambio=0;
						cambioFacturaDinero.cambio=0;

			for (var b = 0; b < $scope.listaSerialDetalleFactura.length; b++)
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarSerialfactura",
				{
					'id_producto':$scope.listaSerialDetalleFactura[b].id_producto,
					'id_serial':$scope.listaSerialDetalleFactura[b].id_serial,
					'id_factura':id_factura
				})
				.success(function (respuesta)
				{		
					console.log(respuesta);

					var mensajeexito = 0
					if (respuesta == 'exito')
					{
						new PNotify({
							title: 'Exito!',
							text: 'Se ha guardado con exito el registro de los productos',
							type: 'success',
							styling: 'bootstrap3'
						});
					}
					else if (respuesta == 'fallo') 
					{
						new PNotify({
							title: 'Error!',
							text: 'No se ha podido guardar el registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});
					}
					else
					{
						new PNotify({
							title: 'Exito!',
							text: 'Eror! No se ha guardado registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});

					}


				}).error(function(respuesta, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

				
			}

			var r =confirm("¿Desea Imprimir Recibo ? \n OK or Cancel.");
			if (r==true) {
				window.open('views/informespdf/BaseFactura.php?factura='+id_factura,'_blank');
			}
			


			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=ultimaFacturaF")
		.success(function (datos)
		{		
			
				$scope.ultimaFacturaDatos = datos;
								
				console.log(datos);

				$scope.pageultimaFacturaDatos = 1;
			

				$scope.itemsultimaFacturaDatos = $scope.ultimaFacturaDatos.slice(0, 25);
				
				$scope.paginaultimaFacturaDatos = function() {
				  var startPos = ($scope.pageultimaFacturaDatos - 1) * 25;
				  console.log($scope.pageultimaFacturaDatos);
				}
			 $scope.ventaDia();
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
}
}
	}// funcion que va a guardar la factura y el detalle de los productos a facturar
	// $scope.guardarFacturaProyecto = function(id_Proyecto,id_cliente)
	// {
	// 	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarfacturaProyecto",
	// 	{
	// 		'id_cliente':id_cliente,
	// 		'totalpago':$scope.totalapagar,
	// 		'id':id_Proyecto
	// 	})
	// 	.success(function (datos)
	// 	{		
	// 		console.log(datos);
	// 		var id_facturaproyecto = datos;

	// 		for (var b = 0; b < $scope.listaProductosDetalleFactura.length; b++)
	// 		{
	// 			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarDetallefacturaProyecto",
	// 			{
	// 				'id_producto':$scope.listaProductosDetalleFactura[b].id_producto,
	// 				'cantidad':$scope.listaProductosDetalleFactura[b].cantidad,
	// 				'valorTotal':$scope.listaProductosDetalleFactura[b].valorTotal,
	// 				'id_factura':id_facturaproyecto
	// 			})
	// 			.success(function (respuesta)
	// 			{		
	// 				console.log(respuesta);

	// 				var mensajeexito = 0
	// 				if (respuesta == 'exito')
	// 				{
	// 					new PNotify({
	// 						title: 'Exito!',
	// 						text: 'Se ha guardado con exito el registro de los productos',
	// 						type: 'success',
	// 						styling: 'bootstrap3'
	// 					});
	// 				}
	// 				else if (respuesta == 'fallo') 
	// 				{
	// 					new PNotify({
	// 						title: 'Error!',
	// 						text: 'No se ha podido gucardar el registro de los productos',
	// 						type: 'error',
	// 						styling: 'bootstrap3'
	// 					});
	// 				}
	// 				else
	// 				{
	// 					new PNotify({
	// 						title: 'Exito!',
	// 						text: 'Eror! No se ha guardado registro de los productos',
	// 						type: 'error',
	// 						styling: 'bootstrap3'
	// 					});

	// 				}


	// 			}).error(function(respuesta, status, headers, config)
	// 			{
	// 		      //	console.log("echo todo mal");
	// 		      	new PNotify({
	// 						title: 'Error!',
	// 						text: 'Ha ocurrido un error de funcion guardarFactura',
	// 						type: 'error',
	// 						styling: 'bootstrap3'
	// 					});
	// 		    });

				
	// 		}

	// 		// window.open('views/informespdf/impresionfactura.php?factura='+id_factura,'_blank');


			
	// 	}).error(function(datos, status, headers, config)
	// 	{
	//       //	console.log("echo todo mal");
	//       	new PNotify({
	// 				title: 'Error!',
	// 				text: 'Ha ocurrido un error de funcion guardarFactura',
	// 				type: 'error',
	// 				styling: 'bootstrap3'
	// 			});
	//     });

	// 	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=ultimaFacturaF")
	// 	.success(function (datos)
	// 	{		
			
	// 			$scope.ultimaFacturaDatos = datos;
								
	// 			console.log(datos);

	// 			$scope.pageultimaFacturaDatos = 1;
			

	// 			$scope.itemsultimaFacturaDatos = $scope.ultimaFacturaDatos.slice(0, 25);
				
	// 			$scope.paginaultimaFacturaDatos = function() {
	// 			  var startPos = ($scope.pageultimaFacturaDatos - 1) * 25;
	// 			  console.log($scope.pageultimaFacturaDatos);
	// 			}
	// 		 $scope.ventaDia();
				
	// 	}).error(function(datos, status, headers, config)
	// 	{
	//       //	console.log("echo todo mal");
	//       	new PNotify({
	// 				title: 'Error!',
	// 				text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
	// 				type: 'error',
	// 				styling: 'bootstrap3'
	// 			});
	//     });

	// }
// funcion que va a guardar la factura y el detalle de los productos a facturar
	$scope.guardarCotizacion= function(insertClientes)
	{
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarcotizacion",
		{
			'id_cliente':insertClientes.id_cliente,
			'totalpago':$scope.totalapagar
		})
		.success(function (datos)
		{		
			console.log(datos);
			var id_cotizacion = datos;

			for (var b = 0; b < $scope.listaProductosDetalleFactura.length; b++)
			{
				$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=insertarDetallecotizacion",
				{
					'id_producto':$scope.listaProductosDetalleFactura[b].id_producto,
					'cantidad':$scope.listaProductosDetalleFactura[b].cantidad,
					'valorTotal':$scope.listaProductosDetalleFactura[b].valorTotal,
					'id_cotizacion':id_cotizacion
				})
				.success(function (respuesta)
				{		
					console.log(respuesta);

					var mensajeexito = 0
					if (respuesta == 'exito')
					{
						new PNotify({
							title: 'Exito!',
							text: 'Se ha guardado con exito el registro de los productos',
							type: 'success',
							styling: 'bootstrap3'
						});
					}
					else if (respuesta == 'fallo') 
					{
						new PNotify({
							title: 'Error!',
							text: 'No se ha podido guardar el registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});
					}
					else
					{
						new PNotify({
							title: 'Exito!',
							text: 'Eror! No se ha guardado registro de los productos',
							type: 'error',
							styling: 'bootstrap3'
						});

					}


				}).error(function(respuesta, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

				
			}

			// window.open('views/informespdf/impresionfactura.php?factura='+id_factura,'_blank');


			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=ultimaFacturaF")
		.success(function (datos)
		{		
			
				$scope.ultimaFacturaDatos = datos;
								
				console.log(datos);

				$scope.pageultimaFacturaDatos = 1;
			

				$scope.itemsultimaFacturaDatos = $scope.ultimaFacturaDatos.slice(0, 25);
				
				$scope.paginaultimaFacturaDatos = function() {
				  var startPos = ($scope.pageultimaFacturaDatos - 1) * 25;
				  console.log($scope.pageultimaFacturaDatos);
				}
			 $scope.ventaDia();
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

	// funcion que va a gerear la factura para ser impresa
	$scope.generarfactura = function(id_factura)
	{
		window.open('views/informespdf/BaseFactura.php?factura='+id_factura,'_blank');
	}
	$scope.generarInforme = function(id_facturaAdd)
	{
		window.open('views/informespdf/BaseFacturaAdd.php?factura='+id_facturaAdd,'_blank');
	}


	// funcion que va a generar el reporte de facturas por fecha
	$scope.generar_reportePDFfacturaXfecha = function(agregarbusquedaFacturaXf)
	{
		

		var fechauno = new Date(agregarbusquedaFacturaXf.fechaInicialFactura).toISOString();
		var fechados = new Date(agregarbusquedaFacturaXf.fechaFinalFactura).toISOString();
		window.open('views/informespdf/reporteporRangofecha.php?fecha_inicio='+fechauno+'&fecha_fin='+fechados,'_blank');
	}

$scope.agregarbusquedaFacturaXf={
	fechaInicialFactura:'',
	fechaFinalFactura:''
}
	// funcion que va a buscar las facturas por rango de fecha
	$scope.buscarfacturaXfecha = function(agregarbusquedaFacturaXf)
	{
		console.log(agregarbusquedaFacturaXf.fechaInicialFactura);
		console.log(agregarbusquedaFacturaXf.fechaFinalFactura);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=facturasXrangoFecha",
		{
			'fecha_inicio':agregarbusquedaFacturaXf.fechaInicialFactura,
			'fecha_fin':agregarbusquedaFacturaXf.fechaFinalFactura

		})
		.success(function (datos)
		{		
			if (datos == 'nohay') 
			{
				new PNotify({
					title: 'Error!',
					text: 'No se han encontrado facturas en el rango de fecha especificado',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}
			else
			{
				$scope.listadofacturasXfechas = datos;
								
				console.log(datos);

				$scope.pagelistadofacturasXfechas = 1;
			

				$scope.itemslistadofacturasXfechas = $scope.listadofacturasXfechas.slice(0, 25);
				
				$scope.paginalistadofacturasXfechas = function() {
				  var startPos = ($scope.pagelistadofacturasXfechas - 1) * 25;
				  console.log($scope.pagelistadofacturasXfechas);
				}
			}
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	// funcion que va a buscar las facturas por rango de fecha
	$scope.buscaDevoluciones = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=devolucioneslistado")
		.success(function (datos)
		{		
			if (datos == 'nohay') 
			{
				new PNotify({
					title: 'Error!',
					text: 'No se han encontrado facturas en el rango de fecha especificado',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}
			else
			{
				$scope.listadodevoluciones = datos;
								
				console.log(datos);

				$scope.pagelistadodevoluciones = 1;
			

				$scope.itemslistadodevoluciones = $scope.listadodevoluciones.slice(0, 25);
				
				$scope.paginalistadodevoluciones = function() {
				  var startPos = ($scope.pagelistadodevoluciones - 1) * 25;
				  console.log($scope.pagelistadodevoluciones);
				}
			}
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	$scope.buscaDevoluciones();

	$scope.SuccessDevolucionUnidad = function(id_factura,id_detalleFactura,var_codigo_factura){

		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallefacturaselecionadaDevolucion",
			{
				'id_factura':id_factura,
				'id_detallefactura':id_detalleFactura,
				'var_codigo_factura':var_codigo_factura
			})
			.success(function (respuesta)
			{		
				console.log(respuesta);
				
				
						$scope.verdetalleFacturaSelect(id_factura);		
						new PNotify({
						title: 'Exito!',
						text: 'El producto Se ha Devuelto',
						type: 'success',
						styling: 'bootstrap3'
					});	
					
					
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

	}

	$scope.SuccessDevolucionTotal = function(id_factura,codigo_facturaD){

		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallefacturaselecionada",
			{
				'id_factura':id_factura
			})
			.success(function (respuesta)
			{		
				console.log(respuesta);
				
					$scope.listadoDetallefacturasD = respuesta;

					for (var i = 0; i < $scope.listadoDetallefacturasD.length; i++)
							{

									$scope.SuccessDevolucionUnidad(id_factura,$scope.listadoDetallefacturasD[i].id_detalleFactura,codigo_facturaD);
							}


			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=eliminarFactura",
			{
				'id_factura':id_factura
			})
			.success(function (respuesta)
			{		
				console.log(respuesta);
				
				if (respuesta=="fallo") {

						new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error al eliminar la factura',
						type: 'error',
						styling: 'bootstrap3'
					});
				}else if(respuesta=="elimino"){
						new PNotify({
						title: 'Exito!',
						text: 'Se ha eliminado la Factura',
						type: 'success',
						styling: 'bootstrap3'
					});

						$scope.buscarfacturaXfecha($scope.agregarbusquedaFacturaXf);
				}

							
									
					
					
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

									
					
					
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

	}

	$scope.DevolucionTotal = function(id_factura,codigo_factura,cc_cliente,nombre_cliente,fecha_factura){
		$scope.id_facturaD=id_factura;
		$scope.codigo_facturaD=codigo_factura;
		$scope.cc_clienteD=cc_cliente;
		$scope.nombre_clienteD=nombre_cliente;
		$scope.fecha_facturaD=fecha_factura;
		console.log("aqui");
	}

	// funcio que va a mostrar el detalle de la factura seleccionada 
	$scope.verdetalleFacturaSelect = function(id_factura)
	{
		
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busqueda_facturaseleccinada",
		{
			'id_factura':id_factura
			
		})
		.success(function (datos)
		{		
			console.log(datos);
			
			$scope.var_codigo_factura = datos[0].codigo_factura;
			$scope.var_fecha_factura = datos[0].fecha_factura;
			$scope.var_valor_pago = datos[0].valor_pago;
			$scope.var_cc_cliente = datos[0].cc_cliente;
			$scope.var_nombre_cliente = datos[0].nombre_cliente;
			


			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallefacturaselecionada",
			{
				'id_factura':id_factura
			})
			.success(function (respuesta)
			{		
				console.log(respuesta);
				
					$scope.listadoDetallefacturas = respuesta;
									
					
					
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	$scope.verdetalleDevolucionSelect = function(id_devolucion)
	{
		
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busqueda_devolucionseleccinada",
		{
			'id_devolucion':id_devolucion
			
		})
		.success(function (datos)
		{		
			console.log(datos);
			
			$scope.var_codigo_devolucion = datos[0].codigo_factura;
			$scope.var_fecha_devolucion = datos[0].fecha_factura;
			$scope.var_valor_pago = datos[0].valor_pago;
			$scope.var_cc_cliente = datos[0].cc_cliente;
			$scope.var_nombre_cliente = datos[0].nombre_cliente;
			


			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetalledevolucionesselecionada",
			{
				'id_devolucion':id_devolucion
			})
			.success(function (respuesta)
			{		
				console.log(respuesta);
				
					$scope.listadoDetalledevoluciones = respuesta;
									
					
					
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}// funcio que va a mostrar el detalle de la factura seleccionada 
	$scope.verdetalleFacturaProyectoSelec = function(id_proyecto)
	{
		
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busqueda_facturaseleccinadaProyecto",
		{
			'id_factura':id_proyecto
			
		})
		.success(function (datos)
		{		
			console.log(datos);
			
			$scope.var_codigo_facturaP = datos[0].codigo_factura;
			$scope.var_fecha_facturaP = datos[0].fecha_factura;
			$scope.var_valor_pagoP = datos[0].valor_pago;
			$scope.var_cc_clienteP = datos[0].cc_cliente;
			$scope.var_nombre_clienteP = datos[0].nombre_cliente;
			$scope.var_id_facturaproyecto = datos[0].id_facturaproyecto;
			


			$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetallefacturaselecionadaProyecto",
			{
				'id_factura':$scope.var_id_facturaproyecto
			})
			.success(function (respuesta)
			{		
				console.log(respuesta);
				
					$scope.listadoDetallefacturasProyecto = respuesta;
									
					
					
			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });

				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

	$scope.busquedaFactXcliente = 
	{
		id_cliente:'',
		identificacion:'',
		nombre_clientes:''
		
	}

	// funcion que va a gregar el cliente al formulario de busqueda por clientes
	$scope.agregarclienteBusqueDetalleFactu = function(id_cliente,cc_cliente,nombre_cliente,busquedaFactXcliente)
	{
		busquedaFactXcliente.id_cliente = id_cliente;
		busquedaFactXcliente.identificacion = cc_cliente;
		busquedaFactXcliente.nombre_clientes = nombre_cliente;
		
	}

	// funcion que va a buscar facutras pro cliente seleccionado
	$scope.buscarfacturaXclienteseleccionado = function(id_cliente)
	{
		
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=facturasXclienteseleccionado",
		{
			'id_cliente':id_cliente
			

		})
		.success(function (datos)
		{		
			if (datos == 'nohay') 
			{
				new PNotify({
					title: 'Error!',
					text: 'No se han encontrado facturas para el cliente seleccionado especificado',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}
			else
			{
				$scope.listadofacturasXclienteSelect = datos;
								
				console.log(datos);

				$scope.pagelistadofacturasXclienteSelect = 1;
			

				$scope.itemslistadofacturasXclienteSelect = $scope.listadofacturasXclienteSelect.slice(0, 25);
				
				$scope.paginalistadofacturasXclienteSelect = function() {
				  var startPos = ($scope.pagelistadofacturasXclienteSelect - 1) * 25;
				  console.log($scope.pagelistadofacturasXclienteSelect);
				}
			}
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion buscarfacturaXclienteseleccionado',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}


	//funcion que va a listar todos loo clientes
	$scope.verificarStock  = function (id_producto)
	{
		console.log(id_producto);
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=listadodeStock",{
			'id_producto':id_producto

		})
		.success(function (datos)
		{		
			$scope.listadodetodos_stock = datos;
							$scope.ActualUnidad=$scope.listadodetodos_stock[0].Unidad;
							$scope.ActualFracccion=$scope.listadodetodos_stock[0].stock;
			console.log(datos);

			$scope.pagelistadodetodos_stock = 1;
		

			$scope.itemslistadodetodos_stock = $scope.listadodetodos_stock.slice(0, 4);
			
			$scope.paginalistadodetodos_stock = function() {
			  var startPos = ($scope.pagelistadodetodos_stock - 1) * 4;
			  console.log($scope.pagelistadodetodos_stock);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clienteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

	

	//funcion que va a listar todos loo clientes
	$scope.listadotodos_clienteFacturas  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=listadodeclintesFactura")
		.success(function (datos)
		{		
			$scope.listadodetodos_clientesFactu = datos;
							
			console.log(datos);

			$scope.pagelistadodetodos_clientesFactu = 1;
		

			$scope.itemslistadodetodos_clientesFactu = $scope.listadodetodos_clientesFactu.slice(0, 4);
			
			$scope.paginalistadodetodos_clientesFactu = function() {
			  var startPos = ($scope.pagelistadodetodos_clientesFactu - 1) * 4;
			  console.log($scope.pagelistadodetodos_clientesFactu);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clienteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}


$scope.ajusteInventario= function(elEvento,Unidad,stock,id_inventario,fraccion){

		elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=ajusteInventarioU",{
		'Unidad':Unidad,
		'fraccion':fraccion,
		'stock':stock,
		'id_inventario':id_inventario
	})
		.success(function (datos)
		{		
			console.log(datos);
			$scope.listadotodos_Inventario();
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clienteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
}
}
	$scope.listadotodos_clienteFacturas();
	$scope.listadotodos_Inventario  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=listadodeInventario")
		.success(function (datos)
		{		
			$scope.listadodetodos_inventariioList = datos;
							
			console.log(datos);

			$scope.pagelistadodetodos_inventariioList = 1;
		

			$scope.itemslistadodetodos_inventariioList = $scope.listadodetodos_inventariioList.slice(0, 100);
			
			$scope.paginalistadodetodos_inventariioList = function() {
			  var startPos = ($scope.pagelistadodetodos_inventariioList - 1) * 10000;
			  console.log($scope.pagelistadodetodos_inventariioList);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clienteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

	$scope.listadotodos_Inventario();
	
$scope.listadotodos_IngresosFacturaAdd  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeFacturaADD")
		.success(function (datos)
		{		
			$scope.listadodetodos_addFactura = datos;
							
			console.log(datos);

			$scope.pagelistadodetodos_addFactura = 1;
		

			$scope.itemslistadodetodos_addFactura = $scope.listadodetodos_addFactura.slice(0, 10);
			
			$scope.paginalistadodetodos_addFactura = function() {
			  var startPos = ($scope.pagelistadodetodos_addFactura - 1) * 10;
			  console.log($scope.pagelistadodetodos_addFactura);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clienteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

	$scope.listadotodos_IngresosFacturaAdd();
	

// // 	//AQUI COMIENZA CATEGORIA 

	$scope.insertarCategoria={
	nombreCategoria:''
}
$scope.AddFactura={
	nombreAddFactura:''
}
$scope.guardarFacturaAdd=function (AddFactura)
{
	console.log(AddFactura)

	if (AddFactura.nombreAddFactura=="") {

			new PNotify({
					title: 'Error!',
					text: 'EL campo se encuentra vacio',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertarfacturaAdd",AddFactura).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			$scope.listadotodos_IngresosFacturaAdd();
	$scope.AddFactura={
	nombreAddFactura:''
}

			new PNotify({
					title: 'Oh Yes!',
					text: 'La Operacion se realizo con exito',
					type: 'succes',
					styling: 'bootstrap3'
				});
		
		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}
$scope.AddFacturaSelect={
	id_ingresosAdd:'',
	nombre_facturaSelect:''
}
$scope.SelectFacturaAdd=function (nombre_factura,id_ingresofactura,AddFacturaSelect){
AddFacturaSelect.id_ingresosAdd=id_ingresofactura;
AddFacturaSelect.nombre_facturaSelect=nombre_factura;

$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeSelectFactura",{
	'id_ingresofactura':id_ingresofactura
}).success(function (datoss)
		{		
			$scope.listadodetodos_SelectFacturaAdd = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_SelectFacturaAdd = 1;
		

			$scope.itemslistadodetodos_SelectFacturaAdd = $scope.listadodetodos_SelectFacturaAdd.slice(0, 1000);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_SelectFacturaAdd - 1) * 1000;
			  console.log($scope.pagelistadodetodos_SelectFacturaAdd);
			}
			var valorGanancia=0;
			var valorVentas=0;
			var valorInversion=0;
			for (var i = 0; i < $scope.listadodetodos_SelectFacturaAdd.length; i++)
							{
					
					valorGanancia=valorGanancia+parseInt(($scope.listadodetodos_SelectFacturaAdd[i].valor_venta - $scope.listadodetodos_SelectFacturaAdd[i].valor) * $scope.listadodetodos_SelectFacturaAdd[i].cantidadUnidad);
				valorVentas=valorVentas+parseInt(($scope.listadodetodos_SelectFacturaAdd[i].valor_venta * $scope.listadodetodos_SelectFacturaAdd[i].cantidadUnidad) +( $scope.listadodetodos_SelectFacturaAdd[i].cantidadFraccion * $scope.listadodetodos_SelectFacturaAdd[i].valor_unidad)) ;
				valorInversion=valorInversion+parseInt($scope.listadodetodos_SelectFacturaAdd[i].valor * $scope.listadodetodos_SelectFacturaAdd[i].cantidadUnidad);
				console.log("LA GANACIA ES = "+valorGanancia);

							}

							$scope.valorGanancia=valorGanancia;
							$scope.valorVentas=valorVentas;
							$scope.valorInversion=valorInversion;

			
			console.log(valorInversion);
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			// new PNotify({
			// 		title: 'Exito!',
			// 		text: 'Se ha guardado el formulario exitosamente ',
			// 		type: 'success',
			// 		styling: 'bootstrap3'
			// 	});


}
$scope.SelectFacturaAddResulta=function (id_ingresofactura){


$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeSelectFactura",{
	'id_ingresofactura':id_ingresofactura
}).success(function (datoss)
		{		
			$scope.listadodetodos_SelectFacturaAdd = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_SelectFacturaAdd = 1;
		

			$scope.itemslistadodetodos_SelectFacturaAdd = $scope.listadodetodos_SelectFacturaAdd.slice(0, 1000);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_SelectFacturaAdd - 1) * 1000;
			  console.log($scope.pagelistadodetodos_SelectFacturaAdd);
			}


			var valorGanancia=0;
			var valorVentas=0;
			var valorInversion=0;
			for (var i = 0; i < $scope.listadodetodos_SelectFacturaAdd.length; i++)
							{
					
					valorGanancia=valorGanancia+parseInt(($scope.listadodetodos_SelectFacturaAdd[i].valor_venta - $scope.listadodetodos_SelectFacturaAdd[i].valor) * $scope.listadodetodos_SelectFacturaAdd[i].cantidadUnidad);
				valorVentas=valorVentas+parseInt(($scope.listadodetodos_SelectFacturaAdd[i].valor_venta * $scope.listadodetodos_SelectFacturaAdd[i].cantidadUnidad) +( $scope.listadodetodos_SelectFacturaAdd[i].cantidadFraccion * $scope.listadodetodos_SelectFacturaAdd[i].valor_unidad)) ;
				valorInversion=valorInversion+parseInt($scope.listadodetodos_SelectFacturaAdd[i].valor * $scope.listadodetodos_SelectFacturaAdd[i].cantidadUnidad);
				console.log("LA GANACIA ES = "+valorGanancia);

							}

							$scope.valorGanancia=valorGanancia;
							$scope.valorVentas=valorVentas;
							$scope.valorInversion=valorInversion;

			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			// new PNotify({
			// 		title: 'Exito!',
			// 		text: 'Se ha guardado el formulario exitosamente ',
			// 		type: 'success',
			// 		styling: 'bootstrap3'
			// 	});


}
$scope.agregarProductoFacturaADD=function (id_producto,cant,AddFacturaSelect)
{
	console.log(cant)

	if (cant.cantidadU=="" && cant.cantidadF=="" ) {

			new PNotify({
					title: 'Error!',
					text: 'EL campo se encuentra vacio1',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}if (AddFacturaSelect.id_ingresosAdd=="") {

			new PNotify({
					title: 'Error!',
					text: 'No ha seleecionado una Factura',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertarIngresoFactura",{
	'id_producto':id_producto,
	'cantidadU':cant.cantidadU,
	'cantidadF':cant.cantidadF,
	'id_ingresoFac':AddFacturaSelect.id_ingresosAdd
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
			$scope.showVistaF.show=false;
		
			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}
$scope.agregarProductoFacturaADDKey=function (elEvento,id_producto,cant,AddFacturaSelect)
{
	elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
	console.log(cant)

	if (cant.cantidadU=="" && cant.cantidadF=="" ) {

			new PNotify({
					title: 'Error!',
					text: 'EL campo se encuentra vacio',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}if (AddFacturaSelect.id_ingresosAdd=="") {

			new PNotify({
					title: 'Error!',
					text: 'No ha seleecionado una Factura',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=insertarIngresoFactura",{
	'id_producto':id_producto,
	'cantidadU':cant.cantidadU,
	'cantidadF':cant.cantidadF,
	'id_ingresoFac':AddFacturaSelect.id_ingresosAdd
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
			$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Categoria = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 10;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}
}
$scope.EditarProductoFacturaADD=function (elEvento,id_producto,cantidadUnidad,cantidadFraccion,AddFacturaSelect)
{

	elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
	
	console.log(id_producto,cantidadUnidad,cantidadFraccion,AddFacturaSelect);
		  var cantidadUN= parseInt(cantidadUnidad); 
		  var cantidadFR= parseInt(cantidadFraccion); 
	if (AddFacturaSelect.id_ingresosAdd=="") {

			new PNotify({
					title: 'Error!',
					text: 'No ha seleecionado una Factura',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=changeIngresoFactura",{
	'id_producto':id_producto,
	'cantidadU':cantidadUN,
	'cantidadF':cantidadFR,
	'id_ingresoFac':AddFacturaSelect.id_ingresosAdd
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
			
			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}
}
$scope.addBarraProductoActualizar=function (id_producto,barra)
{
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=addbarraProducto",{
	'id_producto':id_producto,
	'barra':barra
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			
			
			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}


$scope.barraNew=0;

	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });


}

$scope.barraNew=0;
$scope.EditarProductoFacturaADDValores=function (elEvento,id_producto,valor,valor_venta,valor_unidad,AddFacturaSelect)
{

	elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
	
	// console.log(id_producto,cantidadUnidad,cantidadFraccion,AddFacturaSelect);
		  var valor_d= parseInt(valor); 
		  var valor_ve= parseInt(valor_venta); 
		  var valor_Un= parseInt(valor_unidad); 
		  
		  if (valor_d>valor_ve) {

		  		new PNotify({
					title: 'Error!',
					text: ' Sin ganacias',
					type: 'error',
					styling: 'bootstrap3'
				});

		  


		  }else if (AddFacturaSelect.id_ingresosAdd=="") {

			new PNotify({
					title: 'Error!',
					text: 'No ha seleecionado una Factura',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=changeIngresoFacturaValor",{
	'id_producto':id_producto,
	'valor_d':valor_d,
	'valor_ve':valor_ve,
	'valor_Un':valor_Un,
	'id_ingresoFac':AddFacturaSelect.id_ingresosAdd
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
			
			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}
}
$scope.EditarProductoIngreso=function (id_inventario,id_ingresos,id_producto,nombre,codigo_producto,cantidadUnidad,cantidadFraccion)
{
	
	
		  var cantidadUN= parseInt(cantidadUnidad); 
		  var cantidadFR= parseInt(cantidadFraccion); 
	
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=changeIngresoFactura",{
	'id_producto':id_producto,
	'cantidadU':cantidadUN,
	'cantidadF':cantidadFR,
	'id_ingresoFac':AddFacturaSelect.id_ingresosAdd
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="guardo"){
			$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
			$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Categoria = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 10;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}

 $scope.EliminarProductoFacturaADD=function (id_producto,AddFacturaSelect)
{
	

	
$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=EliminarIngresoFactura",{
	'id_producto':id_producto,
	'id_ingresoFac':AddFacturaSelect.id_ingresosAdd
}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			$scope.SelectFacturaAddResulta(AddFacturaSelect.id_ingresosAdd);
			
			new PNotify({
					title: 'Error!',
					text: 'Se ha Eliminado exitosamente ',
					type: 'error',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });


}
$scope.guardarCategoria=function (insertarCategoria)
{
	console.log(insertarCategoria)

	if (insertarCategoria.nombreCategoria=="") {

			new PNotify({
					title: 'Error!',
					text: 'EL campo se encuentra vacio',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=insertar",insertarCategoria).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Categoria = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 10;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}
$scope.guardarProyectoDos=function (insertarProyecto)
{
	
$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=insertarProyectoSQL",insertarProyecto).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			


			$scope.listadotodos_Proyecto();
			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}

//funcion que va a listar todas las categorias
	$scope.listadotodos_Categoria  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Categoria = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 10;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	$scope.actualizarCategoria={
		id_categoriaActualizar:'null',
		nombreCategoriaActualizar:'null'


	}

	$scope.listadotodos_Categoria();
//funcion que va a listar todas las categorias
	$scope.listadotodos_Proveedor  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeProveedor")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Proveedor = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Proveedor = 1;
		

			$scope.itemslistadodetodos_Proveedor = $scope.listadodetodos_Proveedor.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Proveedor - 1) * 10;
			  console.log($scope.pagelistadodetodos_Proveedor);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los proveedores',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	

	$scope.listadotodos_Proveedor();
//funcion que va a listar todas las categorias
	$scope.listadotodos_Proyecto  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeProyecto")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Proyecto = datoss;
							

					
			console.log(datoss);

			$scope.pagelistadodetodos_Proyecto = 1;
		

			$scope.itemslistadodetodos_Proyecto = $scope.listadodetodos_Proyecto.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Proyecto - 1) * 10;
			  console.log($scope.pagelistadodetodos_Proyecto);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	$scope.actualizarCategoria={
		id_categoriaActualizar:'null',
		nombreCategoriaActualizar:'null'


	}

	$scope.listadotodos_Proyecto();

	// actualizacion de categoria 
	$scope.verCategoria=function(id,categoria,actualizarCategoria){

		actualizarCategoria.id_categoriaActualizar=id;
		actualizarCategoria.nombreCategoriaActualizar=categoria;
		// actualizarSubMateria.id_materias=id_materia;
		// actualizarSubMateria.id_submateria=id;
		// actualizarSubMateria.nombremateria=materia;
		// actualizarSubMateria.nombreSubMateria=submateria;
		// actualizarSubMateria.descripcionSubMateria=descripcionSubMateria;
		
		

	}

	// funcion que va a actualizar el registro de ingreso
	$scope.Actualizar_Categoria = function(actualizarCategoria)
	{
		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=actualizandoCategoria",actualizarCategoria)
		.success(function (datos)
		{		
			
			console.log(datos);
			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Categoria = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 4);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 4;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_Ingresos',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}
	// fin de actualizacion 
	$scope.confirmaEminarCateoria={
		idEliminarCategoria:'null'

	}	

	$scope.confirmaEliminar_Categoria = function(id_categoria,categoria,idEliminarCategoria)
	{
		console.log(id_categoria,categoria);
		$scope.idEliminarCategoria = id_categoria;
		$scope.nombre_categoria=categoria;
		
	}

	$scope.EliminarCategoria=function(id){
		console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=eliminarcategoria",
		{
			'idEliminarCategoria':id
		})
		.success(function(datosssss)
		{

			console.log(datosssss);
			if (datosssss=="fallo") {
				new PNotify({
					title: 'Alerta!',
					text: 'La cateoria se encuentra asociados a otras tablas ',
					type:'error',
					styling: 'bootstrap3'
				});
				console.log("si fallo");
			}
			else if(datosssss=="exito")
			{
				console.log("si funciono");
				$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
				.success(function (DatosEliminar)
				{
					$scope.listadodetodos_Categoria = DatosEliminar;
							
			console.log(datosssss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 4);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 4;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			

				}).error(function(Datos, status, headers, config)
				{
					console.log("echo todo mal");

				});
				new PNotify({
					title: 'Exito!',
					text: 'Se elimino la categoria',
					type: 'error',
					styling: 'bootstrap3'
				});

			}else
			{
				console.log("esto salio mal aqui estoy");
			}

		}).error(function(datos){
			console.log("alo salio mal ");
		});



	}
// 	//AQUI TERMINA CATEORIA 


// AQUI COMIENZA TODO DE LA EMPRESA
$scope.guardarEmpresa=function (insertarEmpresa)
{
	console.log(insertarEmpresa);
$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=insertar",insertarEmpresa).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			console.log("echo realizado");
			
			$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=listadodeEmpresa")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Empresa = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Empresa = 1;
		

			$scope.itemslistadodetodos_Empresa = $scope.listadodetodos_Empresa.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Empresa - 1) * 10;
			  console.log($scope.pagelistadodetodos_Empresa);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			new PNotify({
					title: 'Exito!',
					text: 'Se ha guardado el formulario exitosamente ',
					type: 'success',
					styling: 'bootstrap3'
				});

		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}

//funcion que va a listar todas las categorias
	$scope.listadotodos_Empresa  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=listadodeEmpresa")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Empresa = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Empresa = 1;
		

			$scope.itemslistadodetodos_Empresa = $scope.listadodetodos_Empresa.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Empresa - 1) * 10;
			  console.log($scope.pagelistadodetodos_Empresa);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	
	$scope.listadotodos_Empresa();

	$scope.actualizarEmpresa={
		id_empresaActualizar:'null',
		nitEmpresactualizar:'null',
		nombreEmpresaActualizar:'null'
		


	}

	$scope.verEmpresa=function(id,nit,nombre,actualizarEmpresa){

		actualizarEmpresa.id_empresaActualizar=id;
		actualizarEmpresa.nitEmpresactualizar=nit;
		actualizarEmpresa.nombreEmpresaActualizar=nombre;
		// actualizarSubMateria.id_materias=id_materia;
		// actualizarSubMateria.id_submateria=id;
		// actualizarSubMateria.nombremateria=materia;
		// actualizarSubMateria.nombreSubMateria=submateria;
		// actualizarSubMateria.descripcionSubMateria=descripcionSubMateria;
		
		

	}

	// funcion que va a actualizar el registro de ingreso
	$scope.Actualizar_Empresa = function(actualizarEmpresa)
	{
			console.log(actualizarEmpresa);
		$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=actualizandoEmpresa",actualizarEmpresa)
		.success(function (datos)
		{		
			
			console.log(datos);
			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				
			$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=listadodeEmpresa")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Empresa = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Empresa = 1;
		

			$scope.itemslistadodetodos_Empresa = $scope.listadodetodos_Empresa.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Empresa - 1) * 10;
			  console.log($scope.pagelistadodetodos_Empresa);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las categorias',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_Ingresos',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}
	
	// fin de actualizacion 
	$scope.EliminarEmpresa=function(id){
		console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=eliminarempresa",
		{
			'idEliminarEmpresa':id
		})
		.success(function(datosssss)
		{

			console.log(datosssss);
			if (datosssss=="fallo") {
				new PNotify({
					title: 'Alerta!',
					text: 'La cateoria se encuentra asociados a otras tablas ',
					type:'error',
					styling: 'bootstrap3'
				});
				console.log("si fallo");
			}
			else if(datosssss=="exito")
			{
				console.log("si funciono");
					
			$http.post("app/operaciones/operaciones.php?variable=empresa&operacion=listadodeEmpresa")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Empresa = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Empresa = 1;
		

			$scope.itemslistadodetodos_Empresa = $scope.listadodetodos_Empresa.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Empresa - 1) * 10;
			  console.log($scope.pagelistadodetodos_Empresa);
			}

				}).error(function(Datos, status, headers, config)
				{
					console.log("echo todo mal");

				});
				new PNotify({
					title: 'Exito!',
					text: 'Se elimino la categoria',
					type: 'error',
					styling: 'bootstrap3'
				});

			}else
			{
				console.log("esto salio mal aqui estoy");
			}

		}).error(function(datos){
			console.log("alo salio mal ");
		});



	}
	$scope.confirmaEliminar_Empresa = function(id_empresa,nit,empresa,idEliminarEmpresa)
	{
		
		$scope.idEliminarEmpresa = id_empresa;
		$scope.nombre_empresa=empresa;
		$scope.nit_empresa=nit;
		
	}

	// AQUI TERMINA TODO LO DE EMPRESA

// 	//=======================================================================================

	// AQUI COMIENZA LO DEL CLIENTE 

	// AQUI COMIENZA TODO DE LA EMPRESA
	
	$scope.insertarCliente={
		ccCliente:0,
		nombreCliente:'',
		direccionCliente:'',
		telefonoCliente:''
	}
$scope.guardarCliente=function (insertarCliente)
{
	console.log(insertarCliente);

	if (insertarCliente.ccCliente==0 || insertarCliente.nombreCliente=="") {

			new PNotify({
					title: 'Error!',
					text: 'EL campo se encuentra vacio',
					type: 'error',
					styling: 'bootstrap3'
				});
	   
	}else{
$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=insertar",insertarCliente).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="duplicado"){
			
			new PNotify({
					title: 'Oh No!',
					text: 'El documento a se encuentra duplicado',
					type: 'error',
					styling: 'bootstrap3'
				});
		}else if(datos=="exito"){
			console.log("echo realizado");
			new PNotify({
					title: 'Oh No!',
					text: 'El registro se guardo exitosamente',
					type: 'success',
					styling: 'bootstrap3'
				});
		$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=listadodeClientes")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Cliente = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Cliente = 1;
		

			$scope.itemslistadodetodos_Cliente = $scope.listadodetodos_Cliente.slice(0, 10);
			
			$scope.paginalistadodetodos_Cliente = function() {
			  var startPos = ($scope.pagelistadodetodos_Cliente - 1) * 10;
			  console.log($scope.pagelistadodetodos_Cliente);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	    $http.post("app/operaciones/operaciones.php?variable=facturar&operacion=listadodeclintesFactura")
		.success(function (datos)
		{		
			$scope.listadodetodos_clientesFactu = datos;
							
			console.log(datos);

			$scope.pagelistadodetodos_clientesFactu = 1;
		

			$scope.itemslistadodetodos_clientesFactu = $scope.listadodetodos_clientesFactu.slice(0, 4);
			
			$scope.paginalistadodetodos_clientesFactu = function() {
			  var startPos = ($scope.pagelistadodetodos_clientesFactu - 1) * 4;
			  console.log($scope.pagelistadodetodos_clientesFactu);
			}
			
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clienteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });



}
	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	$scope.fromVisibility=false;
	
	console.log("aqui estoy");

}
}

//funcion que va a listar todas las categorias
	$scope.listadotodos_Clientes  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=listadodeClientes")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Cliente = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Cliente = 1;
		

			$scope.itemslistadodetodos_Cliente = $scope.listadodetodos_Cliente.slice(0, 10);
			
			$scope.paginalistadodetodos_Cliente = function() {
			  var startPos = ($scope.pagelistadodetodos_Cliente - 1) * 10;
			  console.log($scope.pagelistadodetodos_Cliente);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	
	$scope.listadotodos_Clientes();

	$scope.actualizarCliente={
		id_clienteActualizar:'null',
		ccClienteActualizar:'null',
		nombreClienteActualizar:'null',
		direccionClienteActualizar:'null',
		telefonoClienteActualizar:'null'
		
		


	}

	$scope.verCliente=function(id,cc,nombre,direccion,telefono,actualizarCliente){

		actualizarCliente.id_clienteActualizar=id;
		actualizarCliente.ccClienteActualizar=cc;
		actualizarCliente.nombreClienteActualizar=nombre;
		actualizarCliente.direccionClienteActualizar=direccion;
		actualizarCliente.telefonoClienteActualizar=telefono;
		
	
	}

	// funcion que va a actualizar el registro de ingreso
	$scope.Actualizar_Cliente = function(actualizarCliente)
	{
			console.log(actualizarCliente);
		$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=actualizandoClientes",actualizarCliente)
		.success(function (datos)
		{		
			
			console.log(datos);
			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				
			$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=listadodeClientes")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Cliente = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Cliente = 1;
		

			$scope.itemslistadodetodos_Cliente = $scope.listadodetodos_Cliente.slice(0, 10);
			
			$scope.paginalistadodetodos_Cliente = function() {
			  var startPos = ($scope.pagelistadodetodos_Cliente - 1) * 10;
			  console.log($scope.pagelistadodetodos_Cliente);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_Ingresos',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}
	
	// fin de actualizacion 
	$scope.EliminarCliente=function(id){
		console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=eliminarcliente",
		{
			'idEliminarCliente':id
		})
		.success(function(datosssss)
		{

			console.log(datosssss);
			if (datosssss=="fallo") {
				new PNotify({
					title: 'Alerta!',
					text: 'La cateoria se encuentra asociados a otras tablas ',
					type:'error',
					styling: 'bootstrap3'
				});
				console.log("si fallo");
			}
			else if(datosssss=="exito"){
					new PNotify({
					title: 'Error!',
					text: 'Se elimino Correctamente',
					type: 'error',
					styling: 'bootstrap3'
				});
			
				console.log("si funciono");
					
				$http.post("app/operaciones/operaciones.php?variable=cliente&operacion=listadodeClientes")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Cliente = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Cliente = 1;
		

			$scope.itemslistadodetodos_Cliente = $scope.listadodetodos_Cliente.slice(0, 10);
			
			$scope.paginalistadodetodos_Cliente = function() {
			  var startPos = ($scope.pagelistadodetodos_Cliente - 1) * 10;
			  console.log($scope.pagelistadodetodos_Cliente);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			}else
			{
				console.log("esto salio mal aqui estoy");
			}

		}).error(function(datos){
			console.log("alo salio mal ");
		});



	}
	$scope.confirmaEliminar_Cliente = function(id_cliente,cc,nombre,idEliminarCliente)
	{
		
		$scope.idEliminarCliente = id_cliente;
		$scope.nombre_cliente=nombre;
		$scope.cc_cliente=cc;
		
	}

//### Aqui termina todo de clientes

//==========================================================================================================================================
//
//
$scope.guardarEgresoDos=function (insertarEgreso)

{

	console.log(insertarEgreso);
$http.post("app/operaciones/operaciones.php?variable=egreso&operacion=egreso",insertarEgreso).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
					
				});
		}
 else if(datos=="exito"){
			console.log("echo realizado");
			// new PNotify({
			// 		title: 'Oh SI!',
			// 		text: 'El registro se guardo exitosamente',
			// 		type: 'success',
			// 		styling: 'bootstrap3'
			// 	});
			var percent = 0;
    var notice = new PNotify({
        text: "Por favor espere",
        type: 'info',
        icon: 'fa fa-spinner fa-spin',
        hide: false,
        buttons: {
            closer: false,
            sticker: false
        },
        shadow: false,
        width: "170px",
        styling: 'bootstrap3'
    });

    setTimeout(function() {
        notice.update({
            title: false
        });
        var interval = setInterval(function() {
            percent += 2;
            var options = {
                text: percent + "% completo."
            };
            if (percent == 80) options.title = "Estamos terminando";
            if (percent >= 100) {
                window.clearInterval(interval);
                options.title = "Guardado!";
                options.type = "success";
                options.hide = true;
                options.buttons = {
                    closer: true,
                    sticker: true
                };
                options.icon = 'fa fa-check';
                options.shadow = true;
                options.width = PNotify.prototype.options.width;
            }
            notice.update(options);
        }, 5);
    }, 2000);

			
			$scope.insertarEgreso={
				idTipoEgreso:'',
				valorEgreso:'',
				mes:'',

			}

$scope.listadotodos_EgresoLista();

}
	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
$scope.guardarEgresoProyectoDos=function (insertarEgresoProyecto,id_pro)

{

	console.log(insertarEgresoProyecto);
$http.post("app/operaciones/operaciones.php?variable=egreso&operacion=egresoProyecto",{
		'idpro':id_pro,
		'pagadoProyecto':insertarEgresoProyecto.pagadoProyecto,
		'valorEgresoProyecto':insertarEgresoProyecto.valorEgresoProyecto


}).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
					
				});
		}
 else if(datos=="exito"){
			console.log("echo realizado");
			// new PNotify({
			// 		title: 'Oh SI!',
			// 		text: 'El registro se guardo exitosamente',
			// 		type: 'success',
			// 		styling: 'bootstrap3'
			// 	});
			var percent = 0;
    var notice = new PNotify({
        text: "Por favor espere",
        type: 'info',
        icon: 'fa fa-spinner fa-spin',
        hide: false,
        buttons: {
            closer: false,
            sticker: false
        },
        shadow: false,
        width: "170px",
        styling: 'bootstrap3'
    });

    setTimeout(function() {
        notice.update({
            title: false
        });
        var interval = setInterval(function() {
            percent += 2;
            var options = {
                text: percent + "% completo."
            };
            if (percent == 80) options.title = "Estamos terminando";
            if (percent >= 100) {
                window.clearInterval(interval);
                options.title = "Guardado!";
                options.type = "success";
                options.hide = true;
                options.buttons = {
                    closer: true,
                    sticker: true
                };
                options.icon = 'fa fa-check';
                options.shadow = true;
                options.width = PNotify.prototype.options.width;
            }
            notice.update(options);
        }, 5);
    }, 2000);

			
			$scope.insertarEgreso={
				idTipoEgreso:'',
				valorEgreso:'',
				mes:'',

			}

$scope.listadotodos_EgresoLista();

}
	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}

$scope.listadotodos_EgresoLista  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=egreso&operacion=listadodeegresos")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Elista = datoss;
							
			console.log(datoss);

 var Enero=0;
			 var Febrero=0;
			 var Marzo=0;
			 var Abril=0;
			 var Mayo=0;
			 var Junio=0;
			 var Julio=0;
			 var Agosto=0;
			 var Septiembre=0;
			 var Octubre=0;
			 var Noviembre=0;
			 var Diciembre=0;
			for(var i=0; i< $scope.listadodetodos_Elista.length; i++){

				if ($scope.listadodetodos_Elista[i].mes=="Enero") {

					Enero=Enero+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Febrero") {

					Febrero=Febrero+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Marzo") {

					Marzo=Marzo+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Abril") {

					Abril=Abril+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Mayo") {

					Mayo=Mayo+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Junio") {

					Junio=Junio+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Julio") {

					Julio=Julio+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Agosto") {

					Agosto=Agosto+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Septiembre") {

					Septiembre=Septiembre+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Octubre") {

					Octubre=Octubre+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Noviembre") {

					Noviembre=Noviembre+parseInt($scope.listadodetodos_Elista[i].valor)

				}if ($scope.listadodetodos_Elista[i].mes=="Diciembre") {

					Diciembre=Diciembre+parseInt($scope.listadodetodos_Elista[i].valor)

				}

			}
		var fecha = new Date();
var anno = fecha.getFullYear();
			$scope.annioActual=anno;
			 $scope.vEnero=Enero;
			 $scope.vFebrero=Febrero;
			 $scope.vMarzo=Marzo;
			 $scope.vAbril=Abril;
			 $scope.vMayo=Mayo;
			 $scope.vJunio=Junio;
			 $scope.vJulio=Julio;
			 $scope.vAgosto=Agosto;
			 $scope.vSeptiembre=Septiembre;
			 $scope.vOctubre=Octubre;
			 $scope.vNoviembre=Noviembre;
			 $scope.vDiciembre=Diciembre;
			 $scope.EgresoTotal=Enero+Febrero+Marzo+Abril+Mayo+Junio+Julio+Agosto+Septiembre+Octubre+Noviembre+Diciembre;
			$scope.pagelistadodetodos_Elista = 1;
		

			$scope.itemslistadodetodos_Elista = $scope.listadodetodos_Elista.slice(0, 10);
			
			$scope.paginalistadodetodos_Elista = function() {
			  var startPos = ($scope.pagelistadodetodos_Elista - 1) * 10;
			  console.log($scope.pagelistadodetodos_Elista);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las cursoyservicios',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

$scope.listadotodos_EgresoLista();
$scope.listadotodos_Egresos  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=egreso&operacion=listadodeEgreso")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Egresos = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Egresos = 1;

			$scope.itemslistadodetodos_Egresos = $scope.listadodetodos_Egresos.slice(0, 10);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Egresos - 1) * 10;
			  console.log($scope.pagelistadodetodos_Egresos);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar las Egresoss',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}

$scope.listadotodos_Egresos();

$scope.guardarTipoEgresoDos=function (insertarTipoEgreso)
{
	
$http.post("app/operaciones/operaciones.php?variable=egreso&operacion=insertarTegreso",insertarTipoEgreso).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			

			var percent = 0;
    var notice = new PNotify({
        text: "Por favor espere",
        type: 'info',
        icon: 'fa fa-spinner fa-spin',
        hide: false,
        buttons: {
            closer: false,
            sticker: false
        },
        shadow: false,
        width: "170px",
        styling: 'bootstrap3'
    });

    setTimeout(function() {
        notice.update({
            title: false
        });
        var interval = setInterval(function() {
            percent += 2;
            var options = {
                text: percent + "% completo."
            };
            if (percent == 80) options.title = "Estamos terminando";
            if (percent >= 100) {
                window.clearInterval(interval);
                options.title = "Guardado!";
                options.type = "success";
                options.hide = true;
                options.buttons = {
                    closer: true,
                    sticker: true
                };
                options.icon = 'fa fa-check';
                options.shadow = true;
                options.width = PNotify.prototype.options.width;
            }
            notice.update(options);
        }, 5);
    }, 2000);

$scope.listadotodos_Egresos();
    $scope.insertarTipoEgreso={

    	codigoEgreso:'',
		nombreEgreso:'',
    }



		}




	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}

$scope.EliminarEgreso=function(id){
		console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=alumno&operacion=eliminaregreso",
		{
			'idEliminarEgreso':id
		})
		.success(function(datosssss)
		{

			console.log(datosssss);
			if (datosssss=="fallo") {
				new PNotify({
					title: 'Alerta!',
					text: 'La cateoria se encuentra asociados a otras tablas ',
					type:'error',
					styling: 'bootstrap3'
				});
				console.log("si fallo");
			}
			else if(datosssss=="exito")
			{
				console.log("si funciono");
				$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeCategoria")
				.success(function (DatosEliminar)
				{
					$scope.listadodetodos_Categoria = DatosEliminar;
							
			console.log(datosssss);

			$scope.pagelistadodetodos_Categoria = 1;
		

			$scope.itemslistadodetodos_Categoria = $scope.listadodetodos_Categoria.slice(0, 4);
			
			$scope.paginalistadodetodos_Cateoria = function() {
			  var startPos = ($scope.pagelistadodetodos_Categoria - 1) * 4;
			  console.log($scope.pagelistadodetodos_Categoria);
			}
			

				}).error(function(Datos, status, headers, config)
				{
					console.log("echo todo mal");

				});
				new PNotify({
					title: 'Exito!',
					text: 'Se elimino la categoria',
					type: 'error',
					styling: 'bootstrap3'
				});

			}else
			{
				console.log("esto salio mal aqui estoy");
			}

		}).error(function(datos){
			console.log("alo salio mal ");
		});


$scope.listadotodos_Egresos();
	}


$scope.confirmaEliminar_Egreso = function(id,nombre,idEliminarEgreso)
	{
		
		$scope.idEliminarEgreso = id;
		$scope.nombre_Egreso=nombre;
		
	}

$scope.verTipoEgreso=function(id,tipo,codigo,actualizarEgreso){

		actualizarEgreso.id_categoriaActualizar=id;
		actualizarEgreso.nombreCategoriaActualizar=categoria;
		// actualizarSubMateria.id_materias=id_materia;
		// actualizarSubMateria.id_submateria=id;
		// actualizarSubMateria.nombremateria=materia;
		// actualizarSubMateria.nombreSubMateria=submateria;
		// actualizarSubMateria.descripcionSubMateria=descripcionSubMateria;
		
		

	}
$scope.verdetalleegresoProyecto=function(id){

			$scope.id_Pro=id;
				console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeEgresoProyecto",{
			'id':id
		}).success(function (datoss)
	{		
			$scope.listadodetodos_EProducto = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_EProducto = 1;
		

			$scope.itemslistadodetodos_EProducto = $scope.listadodetodos_EProducto.slice(0, 10);
			
			$scope.paginalistadodetodos_EProducto = function() {
			  var startPos = ($scope.pagelistadodetodos_EProducto - 1) * 10;
			  console.log($scope.pagelistadodetodos_EProducto);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
		

	}

	// AQUI COMIENZA TODO DE Producto
$scope.guardarProductoDos=function (insertarProducto)
{

var divicion= insertarProducto.valorVentaProducto/insertarProducto.fraccion;
	if ( insertarProducto.fraccion !=0 || insertarProducto.valorProducto >  insertarProducto.valorVentaProducto && divicion > insertarProducto.valorVentaProductoUnidad ) {
			new PNotify({
					title: 'Oh No!',
					text: 'El producto no se puede vender por  de bajo del precio del producto !No deja Ganacias¡',
					type: 'error',
					styling: 'bootstrap3'
				});




	}else if (insertarProducto.fraccion==0 && insertarProducto.valorProducto >  insertarProducto.valorVentaProducto){

		new PNotify({
					title: 'Oh No!',
					text: 'El producto no se puede vender por  de bajo del precio del producto !No deja Ganacias¡',
					type: 'error',
					styling: 'bootstrap3'
				});

	}else {
	console.log(insertarProducto);
$http.post("app/operaciones/operaciones.php?variable=producto&operacion=insertar",insertarProducto).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="fallo2"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario en inventario',
					type: 'error',
					styling: 'bootstrap3'
				});
		}else if(datos=="duplicado"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error !el codigo del producto esta Duplicado',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			console.log("se realizo¨");
			new PNotify({
					title: 'Oh SI!',
					text: 'Sea guardado el Producto Exitosamente',
					type: 'success',
					styling: 'bootstrap3'
				});
		$scope.listadotodos_Producto();
		$scope.insertarProducto={
	CodigoProducto:0,
	CodigBarras:0,
	DescripcionProducto:"",
	presentacion:"",
	marcaProducto:"",
	unidadCerrada:1,
	fraccion:0,
	valorProducto:0,
	valorProductoUnidad:0,
	valorVentaProducto:0,
	valorVentaProductoUnidad:0,
	stockMin:0,

}


}
	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
}

$scope.dataTableOpt = {
   //custom datatable options 
  // or load data through ajax call also
  "aLengthMenu": [[10, 50, 100,-1], [10, 50, 100,'All']],
  };

// AQUI COMIENZA TODO DE Producto
$scope.guardarProveedor=function (insertarProveedor)
{
	console.log(insertarProveedor);
$http.post("app/operaciones/operaciones.php?variable=producto&operacion=insertarProveedor",insertarProveedor).success(function (datos) {

		console.log(datos);
		if(datos=="fallo"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="fallo2"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error no se pudo guardar el formulario en inventario',
					type: 'error',
					styling: 'bootstrap3'
				});
		}else if(datos=="duplicado"){

			new PNotify({
					title: 'Oh No!',
					text: 'Error !el codigo del Codigo del Proveedor esta Duplicado',
					type: 'error',
					styling: 'bootstrap3'
				});
		} else if(datos=="exito"){
			console.log("se realizo¨");
			new PNotify({
					title: 'Oh No!',
					text: 'Sea guardado el Proveedor Exitosamente',
					type: 'success',
					styling: 'bootstrap3'
				});
		$scope.listadotodos_ProveedoresList();


}
	
	}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardar en la base de datos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

}
$scope.insertarProducto={
	CodigoProducto:0,
	CodigBarras:0,
	DescripcionProducto:"",
	presentacion:"",
	marcaProducto:"",
	unidadCerrada:1,
	fraccion:0,
	valorProducto:0,
	valorProductoUnidad:0,
	valorVentaProducto:0,
	valorVentaProductoUnidad:0,
	stockMin:0,
	renta:0

}
$scope.valorUnidad = function(fraccion,valor,valorventa,insertarProducto){
	console.log(insertarProducto);

	if (fraccion!=0) {
insertarProducto.valorProductoUnidad=valor/fraccion;
insertarProducto.valorVentaProductoUnidad= Math.ceil(valorventa/fraccion);

	}else if (fraccion==0){
		insertarProducto.valorProductoUnidad=valor;
insertarProducto.valorVentaProductoUnidad=valorventa;
	}

insertarProducto.renta=((valorventa-valor)/valorventa)*100
}

//funcion que va a listar todas las categorias
	$scope.listadotodos_ProductoChange  = function (barras)
	{
		var letras="abcdefghyjklmnñopqrstuvwxyz";
		console.log(barras.length);
		var contador=0;
		barras = barras.toLowerCase();
   for(i=0; i<barras.length; i++){
      if (letras.indexOf(barras.charAt(i),0)!=-1){
         contador++;
      }
   }
if (barras.length==0) {
	$scope.showVistaF.show = false;
}
else if (contador>0) {
$scope.showVistaF.show = true;

}else{


		if (barras.length<5) {


		}else{


		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProductosChange",{
			'barra':barras
		})
		.success(function (datoss)
		{		
			$scope.listadodetodos_ProductoC = datoss;
							
			console.log(datoss);

			
			if ($scope.listadodetodos_ProductoC=="") {
				$scope.barraNew=1;
			}else{




			$scope.cant={
		cantidadU:1,
		cantidadF:0
	}
			$scope.agregarProductoFacturaPress($scope.listadodetodos_ProductoC[0].id_producto,$scope.listadodetodos_ProductoC[0].descripcion,$scope.listadodetodos_ProductoC[0].codigo_producto,$scope.listadodetodos_ProductoC[0].valor_venta,$scope.listadodetodos_ProductoC[0].ivaValor,$scope.listadodetodos_ProductoC[0].iva,$scope.listadodetodos_ProductoC[0].presentacion,$scope.listadodetodos_ProductoC[0].fraccion,$scope.listadodetodos_ProductoC[0].valor_unidad,$scope.cant);
			// $scope.listadodetodos_ProductoC = 1;
		}

			// $scope.itemslistadodetodos_ProductoC = $scope.listadodetodos_ProductoC.slice(0, 200);
			
			// $scope.paginalistadodetodos_ProductoC = function() {
			//   var startPos = ($scope.pagelistadodetodos_ProductoC - 1) * 200;
			//   console.log($scope.pagelistadodetodos_ProductoC);
			// }

			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
}
}
	$scope.listadotodos_Producto  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeProductos")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Producto = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Producto = 1;
		

			$scope.itemslistadodetodos_Producto = $scope.listadodetodos_Producto.slice(0, 200);
			
			$scope.paginalistadodetodos_Producto = function() {
			  var startPos = ($scope.pagelistadodetodos_Producto - 1) * 200;
			  console.log($scope.pagelistadodetodos_Producto);
			}

			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	$scope.listadotodos_Producto();
	$scope.listadotodos_ProductoKeypress  = function (elEvento,elcodigoProd)
	{
		
		elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProductoskeypress",{
			'codigo':elcodigoProd
		})
		.success(function (datoss)
		{		
			$scope.listadodetodos_ProductoC = datoss;
							
			console.log($scope.listadodetodos_ProductoC[0].fraccion);

if ($scope.listadodetodos_ProductoC[0].fraccion!=0) {
	$scope.cant={
		cantidadU:0,
		cantidadF:1
	}
	console.log("fracccion diferente de cero");
}else{
		$scope.cant={
		cantidadU:1,
		cantidadF:0
	}
	console.log("fracccion iguall a cero");
}
		
			$scope.agregarProductoFacturaPress($scope.listadodetodos_ProductoC[0].id_producto,$scope.listadodetodos_ProductoC[0].descripcion,$scope.listadodetodos_ProductoC[0].codigo_producto,$scope.listadodetodos_ProductoC[0].valor_venta,$scope.listadodetodos_ProductoC[0].ivaValor,$scope.listadodetodos_ProductoC[0].iva,$scope.listadodetodos_ProductoC[0].presentacion,$scope.listadodetodos_ProductoC[0].fraccion,$scope.listadodetodos_ProductoC[0].valor_unidad,$scope.cant);
			// $scope.listadodetodos_ProductoC = 1;
		

			// $scope.itemslistadodetodos_ProductoC = $scope.listadodetodos_ProductoC.slice(0, 200);
			
			// $scope.paginalistadodetodos_ProductoC = function() {
			//   var startPos = ($scope.pagelistadodetodos_ProductoC - 1) * 200;
			//   console.log($scope.pagelistadodetodos_ProductoC);
			// }

			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
}
	$scope.listadotodos_ProductoKeypressAdd  = function (elEvento,elcodigoProd,AddFacturaSelect)
	{
		
		elEvento,
		 evento = elEvento || window.Event;
         k=evento.keyCode; //número de código de la tecla. para el enter debe ser 13
         
        if (k == 13)
        {
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProductoskeypress",{
			'codigo':elcodigoProd
		})
		.success(function (datoss)
		{		
			$scope.listadodetodos_ProductoC = datoss;
							
			console.log(datoss);

			$scope.cant={
		cantidadU:1,
		cantidadF:0
	}
			$scope.agregarProductoFacturaADD($scope.listadodetodos_ProductoC[0].id_producto,$scope.cant,AddFacturaSelect);
			

			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
}
	$scope.listadotodos_ProductoChangeAdd  = function (barras,AddFacturaSelect)
	{

		var letras="abcdefghyjklmnñopqrstuvwxyz";
		console.log(barras.length);
		var contador=0;
		barras = barras.toLowerCase();
   for(i=0; i<barras.length; i++){
      if (letras.indexOf(barras.charAt(i),0)!=-1){
         contador++;
      }
   }
if (barras.length==0) {
	$scope.showVistaF.show = false;
}
else if (contador>0) {
$scope.showVistaF.show = true;

}else{


		if (barras.length<5) {


		}else{

	
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProductosChange",{
			'barra':barras
		})
		.success(function (datoss)
		{		
			$scope.listadodetodos_ProductoC = datoss;
							
			console.log(datoss);

			if ($scope.listadodetodos_ProductoC=="") {
				$scope.barraNew=1;
			}else{


			$scope.cant={
		cantidadU:1,
		cantidadF:0
	}
			$scope.agregarProductoFacturaADD($scope.listadodetodos_ProductoC[0].id_producto,$scope.cant,AddFacturaSelect);
			
}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
}
}


$scope.noBarraNew=function(){
	$scope.barraNew=0;
}
	$scope.showBarra=function(barra){
		$scope.barraView=barra;
}
	
//funcion que va a listar todas las categorias
	$scope.listadotodos_ProveedoresList  = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProveedor")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Proveedores = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Proveedores = 1;
		

			$scope.itemslistadodetodos_Proveedores = $scope.listadodetodos_Proveedores.slice(0, 1000);
			
			$scope.paginalistadodetodos_Proveedores = function() {
			  var startPos = ($scope.pagelistadodetodos_Proveedores - 1) * 1000;
			  console.log($scope.pagelistadodetodos_Proveedores);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	
	$scope.listadotodos_ProveedoresList();

	$scope.listadotodos_ivaList = function ()
	{
		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=listadodeIva")
		.success(function (datoss)
		{		
			$scope.listadodetodos_iva = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_iva = 1;
		

			$scope.itemslistadodetodos_iva = $scope.listadodetodos_iva.slice(0, 10);
			
			$scope.paginalistadodetodos_iva = function() {
			  var startPos = ($scope.pagelistadodetodos_iva - 1) * 10;
			  console.log($scope.pagelistadodetodos_iva);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
	
	$scope.listadotodos_ivaList();

	$scope.actualizarProducto={
		id_ProductoActualizar:'null',
		CodigoProductoActualizar:'null',
		nombreProductoActualizar:'null',
		idCategoriaActualizar:'null',
		DescripcionProductoActualizar:'null',
		valorProductoActualizar:'null',
		valorVentaProductoActualizar:'null'
		
		


	}

	$scope.actualizarProveedor={
		id_proveedor:'null',
		CodigoProveedor:0,
		NombreProveedor:'null',
		responsable:'null',
		direccionProveedor:'null',
		telefonoProveedor:'null',
		departamento:'null',
		estado:0,
		rentabilidad:0,
		diasPago:'null'
	}
	

	$scope.actualizarProducto={
		id_ProductoActualizar:'',
		CodigoProducto:0,
		CodigBarras:0,
		DescripcionProducto:'',
		presentacion:'',
		marcaProducto:'',
		idProveedor:'',
		idCategoria:'',
		idIva:'',
		unidadCerrada:0,
		fraccion:0,
		valorProducto:0,
		valorVentaProducto:0,
		stockMin:0,
		rentabilidad:0,
		fraccion:0,
		
		


	}

$scope.valorUnidadUp = function(fraccion,valor,valorventa,actualizarProducto){
	console.log(actualizarProducto);

	if (fraccion!=0) {
actualizarProducto.valorProductoUnidad=valor/fraccion;
actualizarProducto.valorUnidadProducto= Math.ceil(valorventa/fraccion);

	}else if (fraccion==0){
		actualizarProducto.valorProductoUnidad=valor;
actualizarProducto.valorVentaProductoUnidad=valorventa;
	}

var ren=((valorventa-valor)/valorventa)*100;
actualizarProducto.rentabilidad=ren;
}
	$scope.verProducto=function(id_producto,codigo_producto,codigo_barras,codigo_barrasUno,codigo_barrasDos,descripcion,presentacion,marca,id_proveedor,id_categoria,id_iva,unidadCerrada,fraccion,valor,valor_venta,valor_unidad,stockMin,renta,actualizarProducto){
		console.log(actualizarProducto);
		var numCOdPro= parseInt(codigo_producto);
		var numCOdBar= parseInt(codigo_barras);
		var numCOdBarU= parseInt(codigo_barrasUno);
		var numCOdBarD= parseInt(codigo_barrasDos);
		var numUnidad= parseInt(unidadCerrada);
		var numfracc= parseInt(fraccion);
		var numValor= parseInt(valor);
		var numValorV= parseInt(valor_venta);
		var numValorU= parseInt(valor_unidad);
		var atockMN= parseInt(stockMin);
		var rentaN= parseInt(renta);
		var fraccionD= parseInt(fraccion);

		actualizarProducto.id_ProductoActualizar=id_producto;
		actualizarProducto.CodigoProducto=numCOdPro;
		actualizarProducto.CodigBarras=numCOdBar;
		actualizarProducto.CodigBarrasU=numCOdBarU;
		actualizarProducto.CodigBarrasD=numCOdBarD;
		actualizarProducto.DescripcionProducto=descripcion;
		actualizarProducto.presentacion=presentacion;
		actualizarProducto.marcaProducto=marca;
		actualizarProducto.idProveedor=id_proveedor;
		actualizarProducto.idCategoria=id_categoria;
		actualizarProducto.idIva=id_iva;
		actualizarProducto.unidadCerrada=numUnidad;
		actualizarProducto.fraccion=numfracc;
		actualizarProducto.valorProducto=numValor;
		actualizarProducto.valorVentaProducto=numValorV;
		actualizarProducto.valorUnidadProducto=numValorU;
		actualizarProducto.stockMin =atockMN;
		actualizarProducto.rentabilidad =rentaN;
		actualizarProducto.fraccion =fraccionD;
		
	
	}

	$scope.verProveedor=function(id_proveedor,codigo_proveedor,nombre_proveedor,responsable,direccion,telefono,Departamento,estado,rentabilidad,diasPago,actualizarProveedor){
		console.log(actualizarProveedor);
		typeof(actualizarProveedor.diasPago);
		var codProv= parseInt(codigo_proveedor);
		var estadoNum= parseInt(estado);
		var rentabilidadNm= parseInt(rentabilidad);
		// var numfracc= parseInt(fraccion);
		// var numValor= parseInt(valor);
		// var numValorV= parseInt(valor_venta);

		actualizarProveedor.id_proveedor=id_proveedor;;
		actualizarProveedor.CodigoProveedor=codProv;
		actualizarProveedor.NombreProveedor=nombre_proveedor;
		actualizarProveedor.responsable=responsable;
		actualizarProveedor.direccionProveedor=direccion;
		actualizarProveedor.telefonoProveedor=telefono;
		actualizarProveedor.departamento=Departamento;
		actualizarProveedor.estado=estadoNum;
		actualizarProveedor.rentabilidad=rentabilidadNm;
		actualizarProveedor.diasPago=diasPago;
	
		
	
	}
	$scope.verAgregarProducto=function(id,codigo,nombre,categoria,descripcion,valor,valorventa,fraccion){
		var valorVenA= parseInt(valorventa);
		var valorVA= parseInt(valor);
		var codigoVA= parseInt(codigo);

		$scope.id_ProductoAgregar=id;
		$scope.CodigoProductoAgregar=codigoVA;
		$scope.nombreProductoAgregar=nombre;
		$scope.idCategoriaAgregar=categoria;
		$scope.DescripcionProductoAgregar=descripcion;
		$scope.valorProductoAgregar=valorVA;
		$scope.valorVentaProductoAgregar=valorVenA;
		$scope.fraccionAdd=fraccion;
		
	
	}
	$scope.AddSerialList=function(id,codigo,nombre,categoria,descripcion,valor,valorventa){
		var valorVenAA= parseInt(valorventa);
		var valorVAA= parseInt(valor);
		var codigoVAA= parseInt(codigo);

		$scope.id_ProductoSerial=id;
		$scope.CodigoProductoSerial=codigoVAA;
		$scope.nombreProductoSerial=nombre;
		$scope.idCategoriaSerial=categoria;
		$scope.DescripcionProductoSerial=descripcion;
		$scope.valorProductoSerial=valorVAA;
		$scope.valorVentaProductoSerial=valorVenAA;

		// console.log(insertIngresos);
		$http.post("app/operaciones/operaciones.php?variable=ingresos&operacion=listadodeProductosSeriales",{
			'id_producto':id
		})
		.success(function (datoss)
		{		
			$scope.listadodetodos_ProductoSeriales = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_ProductoSeriales = 1;
		

			$scope.itemslistadodetodos_ProductoSeriales = $scope.listadodetodos_ProductoSeriales.slice(0, 10);
			
			$scope.paginalistadodetodos_ProductoSeriales = function() {
			  var startPos = ($scope.pagelistadodetodos_ProductoSeriales - 1) * 5;
			  console.log($scope.pagelistadodetodos_ProductoSeriales);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
		
	
	}
$scope.verProyecto=function(id_proyecto,id_cliente,nombre,nombre_cliente,manoObra,fecha,estado){
		
		$scope.id_Proyecto=id_proyecto;
		$scope.nombre=nombre;
		$scope.nombre_cliente=nombre_cliente;
		$scope.manoObra=manoObra;
		$scope.fecha=fecha;
		$scope.estado=estado;
		$scope.id_cliente=id_cliente;
		
	
	}
$scope.CambiarEstadoProyecto=function(id_proyecto,id_cliente,nombre,nombre_cliente,manoObra,fecha,estado,actualizarEstado){
		

		$scope.id_proyectoE=id_proyecto;
		$scope.nombreE=nombre;
		$scope.nombre_clienteE=nombre_cliente;
		$scope.manoObraE=manoObra;
		$scope.fechaE=fecha;
		$scope.estadoE=estado;
		// actualizarEstado.id_proyectoE=id_proyecto;
		
	
	}

	// funcion que va a actualizar el registro de ingreso
	$scope.Actualizar_Producto = function(actualizarProducto)
	{
			console.log(actualizarProducto);
			console.log(typeof actualizarProducto.valorVentaProductoActualizar);
var unidadVal=actualizarProducto.valorVentaProducto/actualizarProducto.fraccion;
if (actualizarProducto.valorProducto>actualizarProducto.valorVentaProducto) {

new PNotify({
					title: 'Error!',
					text: 'Sin ganancias ',
					type: 'error',
					styling: 'bootstrap3'
				});

}else if (actualizarProducto.valorUnidadProducto < unidadVal && actualizarProducto.fraccion!=0) {

new PNotify({
					title: 'Error!',
					text: 'Sin ganancias por Unidad ',
					type: 'error',
					styling: 'bootstrap3'
				});
}else {


		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=actualizandoProducto",actualizarProducto)
		.success(function (datos)
		{		
			
			console.log(datos);
			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

$scope.actualizarProducto={
		id_ProductoActualizar:'',
		CodigoProducto:0,
		CodigBarras:0,
		DescripcionProducto:'',
		presentacion:'',
		marcaProducto:'',
		idProveedor:'',
		idCategoria:'',
		idIva:'',
		unidadCerrada:0,
		fraccion:0,
		valorProducto:0,
		valorVentaProducto:0,
		stockMin:0,
		rentabilidad:0,
		fraccion:0,
		
		


	}
				
			$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProductos")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Producto = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Producto = 1;
		

			$scope.itemslistadodetodos_Producto = $scope.listadodetodos_Producto.slice(0, 10);
			
			$scope.paginalistadodetodos_Producto = function() {
			  var startPos = ($scope.pagelistadodetodos_Producto - 1) * 10;
			  console.log($scope.pagelistadodetodos_Producto);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_Ingresos',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}
}
	// funcion que va a actualizar el registro de ingreso
	$scope.UpdateProveedor = function(actualizarProveedor)
	{
			console.log(actualizarProveedor);
			

		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=actualizandoProveedor",actualizarProveedor)
		.success(function (datos)
		{		
			
			console.log(datos);
			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

	$scope.listadotodos_ProveedoresList();		

			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_IProveedor',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}
	// funcion que va a actualizar el registro de ingreso
	$scope.Actualizar_Estado = function(id_proyectoE,actualizarEstado)
	{
			

		$http.post("app/operaciones/operaciones.php?variable=categoria&operacion=actualizandoEstadoSQl",{

			'id':id_proyectoE,
			'estado':actualizarEstado.estadoNuevo
		})
		.success(function (datos)
		{		
			
			console.log(datos);
			if (datos == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de actualizar el registro ',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (datos == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se ha actualizado con exito el registro',
					type: 'success',
					styling: 'bootstrap3'
				});

				
			$scope.listadotodos_Proyecto();

			}
			else 
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacione actualizar_Ingresos',
					type: 'error',
					styling: 'bootstrap3'
				});
			}


		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
				title: 'Error!',
				text: 'Ha ocurrido un error de funcion actualizar_Ingresos',
				type: 'error',
				styling: 'bootstrap3'
			});
	    });
	}
	
	// fin de actualizacion 
	$scope.EliminarProducto=function(id){
		console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=eliminarproducto",
		{
			'idEliminarProducto':id
		})
		.success(function(datosssss)
		{

			console.log(datosssss);
			if (datosssss=="fallo") {
				new PNotify({
					title: 'Alerta!',
					text: 'La cateoria se encuentra asociados a otras tablas ',
					type:'error',
					styling: 'bootstrap3'
				});
				console.log("si fallo");
			}
			else if(datosssss=="exito"){
					new PNotify({
					title: 'Error!',
					text: 'Se elimino Correctamente',
					type: 'error',
					styling: 'bootstrap3'
				});
			
				console.log("si funciono");
					
				$http.post("app/operaciones/operaciones.php?variable=producto&operacion=listadodeProductos")
		.success(function (datoss)
		{		
			$scope.listadodetodos_Producto = datoss;
							
			console.log(datoss);

			$scope.pagelistadodetodos_Producto = 1;
		

			$scope.itemslistadodetodos_Producto = $scope.listadodetodos_Producto.slice(0, 10);
			
			$scope.paginalistadodetodos_Producto = function() {
			  var startPos = ($scope.pagelistadodetodos_Producto - 1) * 10;
			  console.log($scope.pagelistadodetodos_Producto);
			}
			
		}).error(function(datoss, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar Clientes',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
			}else
			{
				console.log("esto salio mal aqui estoy");
			}

		}).error(function(datos){
			console.log("alo salio mal ");
		});


}
		$scope.EliminarProveedor=function(id){
		console.log(id);
		$http.post("app/operaciones/operaciones.php?variable=producto&operacion=eliminarproveedor",
		{
			'idEliminarProveedor':id
		})
		.success(function(datosssss)
		{

			console.log(datosssss);
			if (datosssss=="fallo") {
				new PNotify({
					title: 'Alerta!',
					text: 'La cateoria se encuentra asociados a otras tablas ',
					type:'error',
					styling: 'bootstrap3'
				});
				console.log("si fallo");
			}
			else if(datosssss=="exito"){
					new PNotify({
					title: 'Error!',
					text: 'Se elimino Correctamente',
					type: 'error',
					styling: 'bootstrap3'
				});
			
				console.log("si funciono");
					$scope.listadotodos_ProveedoresList();
				
			}else
			{
				console.log("esto salio mal aqui estoy");
			}

		}).error(function(datos){
			console.log("alo salio mal ");
		});



	}
	$scope.confirmaEliminar_Producto = function(id_producto,codigo,nombre,idEliminarProducto)
	{
		
		$scope.idEliminarProducto = id_producto;
		$scope.nombre=nombre;
		$scope.codigo=codigo;
		
	}
$scope.confirmaEliminar_Proveedor = function(id_producto,codigo,nombre,idEliminarProveedor)
	{
		
		$scope.idEliminarProveedor = id_producto;
		$scope.nombre_proveedorEl=nombre;
		$scope.codigo_proveedorEl=codigo;
		
	}






	// ===========================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================
	


	// ------------------- crear nuevo plansepare ---------------

	// $scope.insertarplansepare =
	// {
	// 	valor_aumento:0,
	// 	fecha_inicioPlansepare:'',
	// 	fechaFin_plansepare:'',
	// 	id_cliente:'',
	// 	identificacion:'',
	// 	nombre_clientes:''
	// }

	$scope.guardar_credito  = function(insertarplansepare)
	{
		console.log(insertarplansepare);
		if (insertarplansepare.id_cliente == "") 
		{
			new PNotify({
				title: 'Error!',
				text: 'Debe seleccionar un cliente',
				
				styling: 'bootstrap3'
			});
		}
		else if (insertarplansepare.fecha_inicioPlansepare == "") 
		{
			new PNotify({
				title: 'Error!',
				text: 'Debe seleccionar la fecha inicial del plan separe',
				
				styling: 'bootstrap3'
			});
		}
		else if (insertarplansepare.fechaFin_plansepare == "") 
		{
			new PNotify({
				title: 'Error!',
				text: 'Debe seleccionar la fecha final del plan separe',
				
				styling: 'bootstrap3'
			});	
		}
		
		else
		{
			$http.post("app/operaciones/operaciones.php?variable=credito&operacion=insertarcredito",
			{
				'id_cliente':insertarplansepare.id_cliente,
				'fecha_inicioPlansepare':insertarplansepare.fecha_inicioPlansepare,
				'fechaFin_plansepare':insertarplansepare.fechaFin_plansepare,
				'totalapagar_plansepare':$scope.totalapagarSepare,
				'valor_aumento':insertarplansepare.valor_aumento
			})
			.success(function (datos)
			{		
				console.log(datos);
				var id_credito = datos;

				for (var b = 0; b < $scope.listaProductosPlan_separe.length; b++)
				{
					$http.post("app/operaciones/operaciones.php?variable=credito&operacion=insertarDetalleCredito",
					{
						'id_producto':$scope.listaProductosPlan_separe[b].id_producto,
						'cantidadU':$scope.listaProductosPlan_separe[b].cantidadU,
						'cantidadF':$scope.listaProductosPlan_separe[b].cantidadF,
						'valorTotal':$scope.listaProductosPlan_separe[b].valorTotal,
						'id_credito':id_credito
					})
					.success(function (respuesta)
					{		
						console.log(respuesta);

						
						if (respuesta == 'exito')
						{
							new PNotify({
								title: 'Exito!',
								text: 'Se ha guardado con exito el registro de los productos',
								type: 'success',
								styling: 'bootstrap3'
							});


						}
						else if (respuesta == 'fallo') 
						{
							
							new PNotify({
								title: 'Error!',
								text: 'No se ha podido guardar el registro de los productos',
								type: 'error',
								styling: 'bootstrap3'
							});
						}
						else
						{
							
							new PNotify({
								title: 'Exito!',
								text: 'Eror! No se ha guardado registro de los productos',
								type: 'error',
								styling: 'bootstrap3'
							});

						}
						


					}).error(function(respuesta, status, headers, config)
					{
				      //	console.log("echo todo mal");
				      	new PNotify({
								title: 'Error!',
								text: 'Ha ocurrido un error de funcion guardarFactura',
								type: 'error',
								styling: 'bootstrap3'
							});
				    });

					
				}



				// window.open('views/informespdf/impresionfactura.php?factura='+id_factura,'_blank');


				
			}).error(function(datos, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion guardarFactura',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
		}



	}
	// // funcion que va a gregar el cliente en el formulario de facturacion
	

	$scope.listar_credito = 
	{
		fechaInicialPansepare:'',
		fechaFinalPansepare:''
	}



	// $scope.listar_plansepareXcliente = 
	// {
	// 	id_cliente:'',
	// 	identificacion:'',
	// 	nombre_clientes:'',
	
	// }

	// $scope.agregarClienteListado_Plansepare = function(id_cliente,cc_cliente,nombre_cliente,listar_plansepareXcliente)
	// {
	// 	listar_plansepareXcliente.id_cliente = id_cliente;
	// 	listar_plansepareXcliente.identificacion = cc_cliente;
	// 	listar_plansepareXcliente.nombre_clientes = nombre_cliente;
	// }
	$scope.actualizacion_cuotas_credito={
		cuotaanterior:'',
		id_abonos_credito:'',
		id_credito:'',
		descuento_abonos:'',
		nuevacuota:'',
		id_cliente:''
	}
$scope.verinformacionCuotaActualizarCredito  = function(id_abonos_credito,id_credito,valor_abono,id_cliente,descuento_abonos,actualizacion_cuotas_credito)
	{
		actualizacion_cuotas_credito.cuotaanterior = valor_abono;
		actualizacion_cuotas_credito.id_abonos_credito = id_abonos_credito;
		actualizacion_cuotas_credito.id_credito = id_credito;
		actualizacion_cuotas_credito.descuento_abonos = descuento_abonos;
		actualizacion_cuotas_credito.nuevacuota = valor_abono;
		actualizacion_cuotas_credito.id_cliente = id_cliente;
	}
	

	// busqueda de planes por rango de fecha
	$scope.buscarCreditoporfecha = function(listar_credito)
	{
		console.log(listar_credito);
		$http.post("app/operaciones/operaciones.php?variable=credito&operacion=busquedaCreditoPorfechaRango",
		{
			'fechaInicialPansepare':listar_credito.fechaInicialPansepare,
			'fechaFinalPansepare':listar_credito.fechaFinalPansepare
		})
		.success(function (Dattos)
		{
			$scope.ListaPlanesDados = Dattos;

			$scope.pageListaPlanesDados  = 1;
			
			$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
			
			$scope.paginaListaPlanesDados  = function() {
			 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
			 console.log($scope.pageListaPlanesDados );
			};

			
				for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
				{
					if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
					{
						$scope.ListaPlanesDados[b].estado = "Pagando";		
					}
					else
					{
						$scope.ListaPlanesDados[b].estado = "Pagando...";	
					}


					if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
					{
						$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
					}
					else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
					{
						$scope.ListaPlanesDados[b].estadocredito = "Activo";	

					}

					if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
					{
						$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
					}
					else
					{
						$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
					}

				}

				console.log($scope.ListaPlanesDados);
			
		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}

// funcion que va a buscar el detalle de los pagos que se han hecho del plan separe
	$scope.verdetalleCredito = function(id_credito,id_cliente)
	{	
		console.log(id_credito);
		$http.post("app/operaciones/operaciones.php?variable=credito&operacion=busquedaDetallaCuotas_Planes",
		{
			'id_credito':id_credito
		})
		.success(function (Dattos)
		{	
			// alert("entro");
			$scope.ListaPagosPlanes = Dattos;
			console.log($scope.ListaPagosPlanes);

			
			$scope.id_credito_sql = $scope.ListaPagosPlanes[0].id_credito;
			$scope.total_pagosepare_sql = $scope.ListaPagosPlanes[0].total_pagosepare;
			$scope.valor_aumetoplansepare_sql = $scope.ListaPagosPlanes[0].valor_aumetoplansepare;
			$scope.fecha_inicio_sql = $scope.ListaPagosPlanes[0].fecha_inicio;
			$scope.fecha_fin_sql = $scope.ListaPagosPlanes[0].fecha_fin;
			$scope.descuento_abonos_sql = $scope.ListaPagosPlanes[0].descuento_abonos;
			$scope.id_cliente_sql = $scope.ListaPagosPlanes[0].id_cliente;
			$scope.cc_cliente_sql = $scope.ListaPagosPlanes[0].cc_cliente;
			$scope.nombre_cliente_sql = $scope.ListaPagosPlanes[0].nombre_cliente;



			$http.post("app/operaciones/operaciones.php?variable=credito&operacion=busquedaDetalle_Planes",
			{
				'id_credito':id_credito
			})
			.success(function (respuesta)
			{	
				$scope.ListaProductosPlanSepare = respuesta;


				$scope.sumacuotas = 0;
				for (var b = 0; b < $scope.ListaProductosPlanSepare.length; b++)
				{
					
					$scope.sumacuotas = parseInt($scope.sumacuotas) + parseInt($scope.ListaProductosPlanSepare[b].valor_abono);
				}

				$scope.sumacuotas;
			

			}).error(function(respuesta, status, headers, config)
			{
		      //	console.log("echo todo mal");
		      	new PNotify({
						title: 'Error!',
						text: 'Ha ocurrido un error de funcion verdetallePlanSepare segunda',
						type: 'error',
						styling: 'bootstrap3'
					});
		    });
		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion verdetallePlanSepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.cuotas_credito={
		deuda_actual:'',
		id_credito:'',
		id_cliente:'',
		identificacion:'',
		nombre_clientes:'',
	}
$scope.cuotas_listacredito = function(descuento_abonos,id_credito,id_cliente,cc_cliente,nombre_cliente,cuotas_credito)
	{
		// console.log(id_plansepare);
		// console.log(id_cliente);
		cuotas_credito.deuda_actual = descuento_abonos;
		cuotas_credito.id_credito = id_credito;
		cuotas_credito.id_cliente = id_cliente;
		cuotas_credito.identificacion = cc_cliente;
		cuotas_credito.nombre_clientes = nombre_cliente;
	}
$scope.guardar_CuotaPagoCredito = function(cuotas_credito,listar_credito)
	{
		console.log(cuotas_credito);
		console.log(listar_credito);
		$http.post("app/operaciones/operaciones.php?variable=credito&operacion=generarPagocuotaCredito",
		{
			
			'id_credito':cuotas_credito.id_credito,
			'deuda_actual':cuotas_credito.deuda_actual,
			'id_cliente':cuotas_credito.id_cliente,
			'pagocuota_plansepare':cuotas_credito.pagocuota_plansepare,
			'fechaInicialPansepare':listar_credito.fechaInicialPansepare,
			'fechaFinalPansepare':listar_credito.fechaFinalPansepare
		})
		.success(function (Dattos)
		{
			console.log(Dattos);
			if (Dattos == "fallo")
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de guardarel pago',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}if (Dattos == "fallo2")
			{
				new PNotify({
					title: 'Error!',
					text: 'error dos',
					type: 'error',
					styling: 'bootstrap3'
				});	
			}
			else
			{

				new PNotify({
					title: 'Exito!',
					text: 'SE guardo con exito el pago',
					type: 'success',
					styling: 'bootstrap3'
				});

			$scope.buscarCreditoporfecha(listar_credito);

			}

		}).error(function(Dattos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardar_CuotaPagoPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}

	// funcion que va a actualizar en base de datos la cuota seleccionada
	$scope.actualizar_CuotaCredito  = function(actualizacion_cuotas_credito,listar_credito)
	{
		console.log(actualizacion_cuotas_credito);
		$http.post("app/operaciones/operaciones.php?variable=credito&operacion=actualizacionCuotaplansepare",
		{
			'cuotaanterior':actualizacion_cuotas_credito.cuotaanterior,
			'id_abonos_credito':actualizacion_cuotas_credito.id_abonos_credito,
			'id_credito':actualizacion_cuotas_credito.id_credito,
			'nuevacuota':actualizacion_cuotas_credito.nuevacuota,
			'descuento_abonos':actualizacion_cuotas_credito.descuento_abonos
			
		})
		.success(function (respuestaDatos)
		{	
			console.log(respuestaDatos);
			if (respuestaDatos == 'erro1')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de acualizar la cuota',
					type: 'error',
					styling: 'bootstrap3'
					
				});
			}
			else if (respuestaDatos == 'erro2')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de acualizar la cuota',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaDatos == 'exito')
			{
				$http.post("app/operaciones/operaciones.php?variable=credito&operacion=busquedaDetallaCuotas_Planes",
		{
			'id_credito':actualizacion_cuotas_credito.id_credito
		})
		.success(function (Dattos)
		{	
			// alert("entro");
			$scope.ListaPagosPlanes = Dattos;
			console.log($scope.ListaPagosPlanes);

			
			$scope.id_credito_sql = $scope.ListaPagosPlanes[0].id_credito;
			$scope.total_pagosepare_sql = $scope.ListaPagosPlanes[0].total_pagosepare;
			$scope.valor_aumetoplansepare_sql = $scope.ListaPagosPlanes[0].valor_aumetoplansepare;
			$scope.fecha_inicio_sql = $scope.ListaPagosPlanes[0].fecha_inicio;
			$scope.fecha_fin_sql = $scope.ListaPagosPlanes[0].fecha_fin;
			$scope.descuento_abonos_sql = $scope.ListaPagosPlanes[0].descuento_abonos;
			$scope.id_cliente_sql = $scope.ListaPagosPlanes[0].id_cliente;
			$scope.cc_cliente_sql = $scope.ListaPagosPlanes[0].cc_cliente;
			$scope.nombre_cliente_sql = $scope.ListaPagosPlanes[0].nombre_cliente;



					$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaDetalle_Planes",
					{
						'id_credito':actualizacion_cuotas_credito.id_credito
					})
					.success(function (respuesta)
					{	
						$scope.ListaProductosPlanSepare = respuesta;


						$scope.sumacuotas = 0;
						for (var b = 0; b < $scope.ListaProductosPlanSepare.length; b++)
						{
							
							$scope.sumacuotas = parseInt($scope.sumacuotas) + parseInt($scope.ListaProductosPlanSepare[b].valor_abono);
						}

						$scope.sumacuotas;

						$http.post("app/operaciones/operaciones.php?variable=credito&operacion=busquedaCreditoPorfechaRango",
						{
							'fechaInicialPansepare':listar_credito.fechaInicialPansepare,
							'fechaFinalPansepare':listar_credito.fechaFinalPansepare
						})
						.success(function (datosxrangofech)
						{
							$scope.ListaPlanesDados = datosxrangofech;


							$scope.pageListaPlanesDados  = 1;
							

							$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
							
							$scope.paginaListaPlanesDados  = function() {
							 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
							 console.log($scope.pageListaPlanesDados );
							};

							
								// for (var b = 0; b < $scope.ListaPlanesDados.length; b++)
								// {
								// 	if ($scope.ListaPlanesDados[b].descuento_abonos == 0)
								// 	{
								// 		$scope.ListaPlanesDados[b].estado = "Pagando";		
								// 	}
								// 	else
								// 	{
								// 		$scope.ListaPlanesDados[b].estado = "Pagando...";	
								// 	}


								// 	if ($scope.ListaPlanesDados[b].estadocredito == 'vencido')
								// 	{
								// 		$scope.ListaPlanesDados[b].estadocredito = "Vencido";	
								// 	}
								// 	else if ($scope.ListaPlanesDados[b].estadocredito == 'novencido')
								// 	{
								// 		$scope.ListaPlanesDados[b].estadocredito = "Activo";	

								// 	}

								// 	if ($scope.ListaPlanesDados[b].estadoproductos == 'No Entregado')
								// 	{
								// 		$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
									
								// 	}
								// 	else
								// 	{
								// 		$scope.ListaPlanesDados[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
									
								// 	}

								// }

								console.log($scope.ListaPlanesDados);
							
						}).error(function(datosxrangofech, status, headers, config)
						{
					      //	console.log("echo todo mal");
					      	new PNotify({
									title: 'Error!',
									text: 'Ha ocurrido un error de funcion guardarFactura',
									type: 'error',
									styling: 'bootstrap3'
								});
					    });
					

					}).error(function(respuesta, status, headers, config)
					{
				      //	console.log("echo todo mal");
				      	new PNotify({
								title: 'Error!',
								text: 'Ha ocurrido un error de funcion verdetallePlanSepare segunda',
								type: 'error',
								styling: 'bootstrap3'
							});
				    });
				}).error(function(Dattos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion verdetallePlanSepare',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });
			}
			else
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de operacion segunda',
					type: 'error',
					styling: 'bootstrap3'
				});
			}

		}).error(function(respuestaDatos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion actualizar_CuotaPlansepare',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}	
$scope.confirmaeliminacionPlan = 
	{
		id_credito:'',
		id_cliente:'',
		fechaInicialPansepare:'',
		fechaFinalPansepare:'',
		estadoproductos:''
	}

$scope.Confirmaeliminar_ProductoCreditoreXfechas = function(id_credito,id_cliente,fechaInicialPansepare,fechaFinalPansepare,estadoproductos,confirmaeliminacionPlan)
	{
		/*console.log(id_credito);
		console.log(id_cliente);
		console.log(fechaInicialPansepare);
		console.log(fechaFinalPansepare);
		console.log(estadoproductos);*/
		confirmaeliminacionPlan.id_credito = id_credito;
		confirmaeliminacionPlan.id_cliente = id_cliente;
		confirmaeliminacionPlan.fechaInicialPansepare = fechaInicialPansepare;
		confirmaeliminacionPlan.fechaFinalPansepare = fechaFinalPansepare;
		confirmaeliminacionPlan.estadoproductos = estadoproductos;
	}




	$scope.eliminar_ProductoCreditoXfechas = function(confirmaeliminacionPlan,listar_credito)
	{
		$http.post("app/operaciones/operaciones.php?variable=credito&operacion=eliminado_creditoxcliente",
		{
			'id_credito':confirmaeliminacionPlan.id_credito,
			'id_cliente':confirmaeliminacionPlan.id_cliente,
			'estadoproductos':confirmaeliminacionPlan.estadoproductos
			
		})
		.success(function (respuestaSQl)
		{	

			console.log(respuestaSQl);
			if (respuestaSQl == 'fallo')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de eliminar el plan',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaSQl == 'falloabono')
			{
				new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de eliminar el plan',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else if (respuestaSQl == 'exito')
			{
				new PNotify({
					title: 'Exito!',
					text: 'Se a eliminado con exito',
					type: 'success',
					styling: 'bootstrap3'
				});

				
				$http.post("app/operaciones/operaciones.php?variable=credito&operacion=busquedaCreditoPorfechaRango",
				{
					'fechaInicialPansepare':listar_credito.fechaInicialPansepare,
					'fechaFinalPansepare':listar_credito.fechaFinalPansepare
				})
				.success(function (Dattos)
				{
					$scope.ListaPlanesDados = Dattos;


					$scope.pageListaPlanesDados  = 1;
					

					$scope.itemsListaPlanesDados  = $scope.ListaPlanesDados .slice(0, 25);
					
					$scope.paginaListaPlanesDados  = function() {
					 var startPos = ($scope.pageListaPlanesDados  - 1) * 25;
					 console.log($scope.pageListaPlanesDados );
					};

					
						
						console.log($scope.ListaPlanesDados);
					
				}).error(function(Dattos, status, headers, config)
				{
			      //	console.log("echo todo mal");
			      	new PNotify({
							title: 'Error!',
							text: 'Ha ocurrido un error de funcion guardarFactura',
							type: 'error',
							styling: 'bootstrap3'
						});
			    });

			}

		}).error(function(respuestaSQl, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion guardarFactura',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	

	}
	$scope.imprimmirRecibocuptaCredito = function(id_abonos_credito,id_credito)
	{
		window.open('views/informespdf/impresionCuotasCreditoXuna.php?credito='+id_credito+'&cuota='+id_abonos_credito,'_blank');


	}
	$scope.listadoGeneral={
		fechaInicialFactura:'',
		fechaFinalFactura:''
	}
	$scope.buscarfacturaXfechaGeneral = function(listadoGeneral)
	{
		window.open('views/informespdf/BaseFacturaGeneral.php?inicio='+listadoGeneral.fechaInicialFactura+'&final='+listadoGeneral.fechaFinalFactura,'_blank');


	}
	$scope.buscarfacturaXfechaHoy = function(fechaAA)
	{
		$scope.fechaActual = new Date();
		window.open('views/informespdf/BaseFacturaHoy.php?fecha='+fechaAA,'_blank');


	}
	$scope.showFrom = function()
	{
		$scope.fromVisibility=true;
		console.log($scope.fromVisibility);

	}


$scope.ultimaFactura = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=ultimaFacturaF")
		.success(function (datosFac)
		{		
			
			if (datosFac=="nohay") {

				$scope.ultimaFacturaDatos='';

				
			}else {

				$scope.ultimaFacturaDatos = datosFac;
								
				console.log(datosFac);

				$scope.pageultimaFacturaDatos = 1;
			

				$scope.itemsultimaFacturaDatos = $scope.ultimaFacturaDatos.slice(0, 25);
				
				$scope.paginaultimaFacturaDatos = function() {
				  var startPos = ($scope.pageultimaFacturaDatos - 1) * 25;
				  console.log($scope.pageultimaFacturaDatos);
				}

				
			}

			
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
$scope.ultimaFactura();

function sumarDias(fecha, dias){
  fecha.setDate(fecha.getDate() + dias);
  return fecha;
}

var d = new Date();
var fechaSemana=sumarDias(d,-7);
console.log(fechaSemana);
$scope.ventaDia = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=ventaDelDias")
		.success(function (datos)
		{		
			
			if (datos=="nohay") {

				$scope.delDia='';

				

			}else {
				

				$scope.delDia = datos;
								
				console.log(datos);
				var totaltotal=0;
for (var i = 0; i < $scope.delDia.length; i++)
							{
					totaltotal=totaltotal+parseInt($scope.delDia[i].total_pago);
					


							}

							$scope.Vtotaltotal=totaltotal;
							console.log(totaltotal);
							$scope.fechaActual= new Date().toJSON().slice(0,10);
							console.log($scope.fechaActual);
				
				$scope.pagedelDia = 1;
			

				$scope.itemsdelDia = $scope.delDia.slice(0, 25);
				
				$scope.paginadelDia = function() {
				  var startPos = ($scope.pagedelDia - 1) * 25;
				  console.log($scope.pagedelDia);
				}
			}

			
				
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error de funcion listadotodos_clineteFacturas',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });

	}
$scope.ventaDia();

$scope.busquedatododinero = function()
	{
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=tododinero")
		.success(function (datos)
		{		
			$scope.listatododinero = datos;

			$scope.VTotal=$scope.listatododinero[0].ValorTotal2;
			$scope.vVenta=$scope.listatododinero[0].valorVenta2;
			$scope.stockN=$scope.listatododinero[0].stockNum;
			$scope.unidadN=$scope.listatododinero[0].unidadNum;
			console.log($scope.VTotal);
			console.log($scope.vVenta);
			console.log($scope.stockN);
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.busquedatododinero();

	$scope.busquedatododineroSemana = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=tododineroSemana")
		.success(function (datos)
		{		
			$scope.listatododineroSemana = datos;
			$scope.ValorSemana=$scope.listatododineroSemana[0].TotalSemana;

			console.log(datos);
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.busquedatododineroSemana();
	$scope.busquedatododineroAyer = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=tododineroAyer")
		.success(function (datos)
		{		
			
				$scope.delDiadeAyer = datos;
								
				console.log(datos);
				var totaltotal=0;
for (var i = 0; i < $scope.delDiadeAyer.length; i++)
							{
					totaltotal=totaltotal+parseInt($scope.delDiadeAyer[i].total_pago);
					


							}

							$scope.VtotaltotalAyer=totaltotal;
							console.log(totaltotal);

							var dt = new Date();


							var month = dt.getMonth()+1;
							var day = dt.getDate()-1;
							var year = dt.getFullYear();
							
							// $scope.fechaActualAyer= new Date().toJSON().slice(0,10);
							$scope.fechaActualAyer= year + '-' + month + '-' + day;
							console.log($scope.fechaActual);
				
				$scope.pagedelDiadeAyer = 1;
			

				$scope.itemsdelDiadeAyer = $scope.delDiadeAyer.slice(0, 25);
				
				$scope.paginadelDiadeAyer = function() {
				  var startPos = ($scope.pagedelDiadeAyer - 1) * 25;
				  console.log($scope.pagedelDiadeAyer);

			console.log(datos);
		}
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.busquedatododineroAyer();
	$scope.busquedatododineroMes = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=tododineroMes")
		.success(function (datos)
		{		
			$scope.listatododineroMes = datos;
			$scope.ValorMes=$scope.listatododineroMes[0].TotalMes;

			console.log(datos);
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.busquedatododineroMes();$scope.busquedatododineroMes = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=tododineroMes")
		.success(function (datos)
		{		
			$scope.listatododineroMes = datos;
			$scope.ValorMes=$scope.listatododineroMes[0].TotalMes;

			console.log(datos);
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.busquedatododineroMes();
	$scope.busquedatododineroAnno = function()
	{
		
		$http.post("app/operaciones/operaciones.php?variable=inventario&operacion=tododineroAnno")
		.success(function (datos)
		{		
			$scope.listatododineroAnno = datos;
			$scope.ValorAnno=$scope.listatododineroAnno[0].TotalAnno;

			console.log(datos);
		}).error(function(datos, status, headers, config)
		{
	      //	console.log("echo todo mal");
	      	new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error al tratar de listar los cursos',
					type: 'error',
					styling: 'bootstrap3'
				});
	    });
	}
	$scope.busquedatododineroAnno();
$scope.verificarCosas = function(pass,cosas){
 console.log(pass);
	if (pass!=10029) {

		new PNotify({
					title: 'Error!',
					text: 'Ha ocurrido un error ! Verifique la contraseña',
					type: 'error',
					styling: 'bootstrap3'
				});
		
	}else{
		$scope.fromVisibility=true;
		$scope.busquedatododinero();
	}

}

	// // busqueda de planes por cliente seleccionado
	// $scope.buscarPlanesSepareXcliente = function(id_cliente)
	// {
	// 	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=busquedaPlanesPorCliente",
	// 	{
	// 		'id_cliente':id_cliente
	// 	})
	// 	.success(function (Dattos)
	// 	{
	// 		$scope.ListaPlanesDadosXcliente = Dattos;
			
	// 			for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
	// 			{
	// 				console.log($scope.ListaPlanesDadosXcliente[b].estadoproductos);
	// 				if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
	// 				}
	// 				else
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
	// 				}


	// 				if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
	// 				}
	// 				else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

	// 				}

	// 				if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
	// 				}
	// 				else
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
	// 				}

					

	// 			}

	// 			console.log($scope.ListaPlanesDadosXcliente);
			
	// 	}).error(function(Dattos, status, headers, config)
	// 	{
	//       //	console.log("echo todo mal");
	//       	new PNotify({
	// 				title: 'Error!',
	// 				text: 'Ha ocurrido un error de funcion guardarFactura',
	// 				type: 'error',
	// 				styling: 'bootstrap3'
	// 			});
	//     });
	// }

	// $scope.cuotas_Plansepare = 
	// {
	// 	deuda_actual:'',
	// 	id_plansepare:'',
	// 	id_cliente:'',
	// 	identificacion:'',
	// 	nombre_clientes:'',
	// 	pagocuota_plansepare:0
	// }

	// // funcion que va a descontar el producto del inventario
	// $scope.entregarelProductoPlansepare = function(id_plansepare,id_cliente)
	// {
	// 	$http.post("app/operaciones/operaciones.php?variable=facturar&operacion=entregarProductosPl",
	// 	{
	// 		'id_plansepare':id_plansepare,
	// 		'id_cliente':id_cliente
	// 	})
	// 	.success(function (Dattos)
	// 	{
	// 		console.log('Dattos');
	// 		console.log(Dattos);
	// 		if (Dattos == 'fallo2')
	// 		{
	// 			new PNotify({
	// 				title: 'Error!',
	// 				text: 'Ha ocurrido un error al guardar el Producto 1',
	// 				type: 'error',
	// 				styling: 'bootstrap3'
	// 			});
	// 		}
	// 		else if (Dattos == 'fallo3')
	// 		{
	// 			new PNotify({
	// 				title: 'Error!',
	// 				text: 'Ha ocurrido un error al guardar el Producto',
	// 				type: 'error',
	// 				styling: 'bootstrap3'
	// 			});
	// 		}
	// 		else
	// 		{
	// 			$scope.ListaPlanesDadosXcliente = Dattos;
			
	// 			for (var b = 0; b < $scope.ListaPlanesDadosXcliente.length; b++)
	// 			{
					
	// 				if ($scope.ListaPlanesDadosXcliente[b].descuento_abonos == 0)
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estado = "Pagando";		
	// 				}
	// 				else
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estado = "Pagando...";	
	// 				}


	// 				if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'vencido')
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadocredito = "Vencido";	
	// 				}
	// 				else if ($scope.ListaPlanesDadosXcliente[b].estadocredito == 'novencido')
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadocredito = "Activo";	

	// 				}

	// 				if ($scope.ListaPlanesDadosXcliente[b].estadoproductos == 'No Entregado')
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success mostrarbotoProducto";	
					
	// 				}
	// 				else
	// 				{
	// 					$scope.ListaPlanesDadosXcliente[b].estadoPrEntregados = "btn btn-success NomostrarbotoProducto";	
					
	// 				}

					

	// 			}

	// 			console.log($scope.ListaPlanesDadosXcliente);
	// 		}

	// 	}).error(function(Dattos, status, headers, config)
	// 	{
	//       //	console.log("echo todo mal");
	//       	new PNotify({
	// 				title: 'Error!',
	// 				text: 'Ha ocurrido un error de funcion entregarelProductoPlansepare',
	// 				type: 'error',
	// 				styling: 'bootstrap3'
	// 			});
	//     });

}]);


