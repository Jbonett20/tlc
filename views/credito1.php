<?php   session_start();
//$_SESSION['ejecutado'];
?>
<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">list_alt</i>Crear Credito
</uib-tab-heading>
<form  id="Form_insertarIngresos">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">account_box</i>
				</div>
				<h3 class="card-title">Cliente</h3>
			</div>
			<div class="card-body">
				
				<input type="hidden" name="id_cliente" id="id_cliente" ng-model="insertarplansepare.id_cliente">
				<div class="input-group">
					<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="insertarplansepare.identificacion" disabled>
					<!-- <span class="input-group-btn"> -->
					<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_clientes_Factura"><span class="icon-search"></span> Buscar</button>
					<!-- </span> -->
				</div>
				
				<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="insertarplansepare.nombre_clientes" disabled>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">inbox</i>
			</div>
			<h3 class="card-title">Productos</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
					<div class="container-3">
						<span class="icon"><i class="material-icons">search</i></span>
						<input type="search" id="search" placeholder="Buscar Producto..."  onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroProductoIngreso" ng-keypress="listadotodos_ProductoCreditoKeypress(e,filtroProductoIngreso)" ng-change="listadotodos_ProductoCreditoChange(filtroProductoIngreso)" >
					</div>
				</div>
			<!-- <div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" id="search" placeholder="Buscar Producto..."  onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
				</div>
			</div> -->
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Cantidad</th>
								<th>Nombre Producto</th>
								<th>Cantidad</th>
								<th>Agregar</th>
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listado in filterDatProducIngreso = (listadodetodos_Producto | filter : filtroProductoIngreso) | limitTo:5:5*(pagelistadodeProductos_Ingreso-1)" ng-class="{'ctr': listado.stockMinimo>=listado.Unidad}">
								<td>
									<div  class="col-md-12 btn_sesion">
										<li class="dropdown mega-dropdown btn_li">
											<a href="" class="btn_log btn btn-info btn-sm" class="dropdown-toggle" data-toggle="dropdown" ng-click="verificarStock(listado.id_producto)">Cantidad  <span class="caret"></span></a>
											<ul class="dropdown-menu  mega-dropdown-menu  row">
												<li>
													<div class="col-md-12">
														<div class="table-table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th>Cantidad</th>
																		<th>Fraccion</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>{{ActualUnidad}}</td>
																		<td>{{ActualFracccion}}</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</li>
											</ul>
										</li>
										
									</div>
								</td>
								<td>{{listado.descripcion}}</td>
								<td>
									<div class="col-sm-4">
										<input type="number" name="cantidadU" class=" form-control input-sm"  ng-model="cant.cantidadU">
									</div>
									<div class="col-sm-4">
										<input type="number" name="cantidadF" class=" form-control input-sm"  ng-model="cant.cantidadF" ng-if="listado.fraccion!=0">
									</div>
								</td>
								<td>
									<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarProductoPlansepareForm(listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor_venta,listado.valor_unidad,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,cant)">
									<span class="icon-cart-plus"></span>Agregar</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">inbox</i>
			</div>
			<h3 class="card-title">Productos</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Codigo</th>
								<th>Producto</th>
								<th>Presentación</th>
								<th>Cantidad Unidad</th>
								<th>Cantidad Fraccion</th>
								<th>Valor Un.</th>
								<th>Iva.</th>
								<th>Total</th>
								<th></th>
								
								
							</tr>
						</thead>
						<tbody class="btl-normal">
							<tr ng-repeat="listado in filterproducDetalles = (listaProductosPlan_separe)">
								<td data-toggle="modal" data-target="#myModalSerial" ng-click="AddSerialList(listado.id_producto,listado.codigo_,listado.nombre,listado.id_categoria,listado.descripcion,listado.valor,listado.valor_venta)" >{{listado.codigoProducto}}</td>
								<td>{{listado.descripcion}}</td>
								<td>{{listado.presentacion}}</td>
								<td>{{listado.cantidadU}}</td>
								<td>{{listado.cantidadF}}</td>
								<td>{{listado.valor_venta - listado.ivaV}}</td>
								<td>{{listado.ivaV}} - ({{listado.iva}} %) </td>
								<td>{{listado.valorTotal}}  </td>
								<td>
								<button type="button" class="btn btn-danger btn-sm" ng-click="eliminarProductoPlansepare(listado.id_producto,listado.valorTotal)"><i class="material-icons">delete</span></button>
							</td>
							
							
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<th>Total a Pagar</th>
							<th>{{totalapagarSepare}}</th>
						</tr>
					</tbody>
					
				</table>
				
			</div>
		</div>
	<div class="row">
	<label class="col-md-5 col-form-label"><strong>Valor Aumeto Plan Sepate </strong></label>
	<div class="col-md-3">
		<div class="form-group">
			<input type="number" placeholder="Valor Aumeto Plan Sepate" class="form-control input-sm"  ng-model="insertarplansepare.valor_aumento" name="valor_aumento">
		</div>
	</div>
	</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h3 class="card-title">Fecha Inicio</h3>
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="date" placeholder="Fecha Inicio" class="form-control"  ng-model="insertarplansepare.fecha_inicioPlansepare" name="fecha_inicioPlansepare">
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h3 class="card-title">Fecha Fin</h3>
			</div>
			<div class="card-body">
				
				<div class="form-group">
					<input type="date" placeholder="Fecha Fin" class="form-control"  ng-model="insertarplansepare.fechaFin_plansepare" name="fechaFin_plansepare">
				</div>
			</div>
		</div>
	</div>

</div>

<div class="col-md-12">
	<button type="button" class="btn btn-primary" ng-click="guardar_credito(insertarplansepare)">
	Guardar
	</button>
</div>
</form>
<!-- Ininio ventana modal de clientes -->
<div id="modal_clientes_Factura" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Clientes</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<input type="text" class="form-control input-sm" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
				</div>
				<div class="col-md-12">
					<uib-pagination class="pagination-mod" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
				</div>
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Identificación</th>
									<th>Nombre Cliente</th>
									<th>Agregar</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterDatProducclientFactura = (listadodetodos_clientesFactu | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodetodos_clientesFactu-1)">
									<td>{{listado.cc_cliente}}</td>
									<td>{{listado.nombre_cliente}}</td>
									<td>
										<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarClienteplansepare(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,insertarplansepare)">Agregar</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</div>
<!-- fin ventana modal de clientes -->
<!-- Ininio ver agregar nuevos producto y cantidad -->
<div id="modal-agregar_productoFactura" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Agregar Productos</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12 col-espacio">
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-productoFactura"><span class="icon-cart-arrow-down"></span>Agregar Producto</button>
				</div>
				<div class="col-md-4" >
					<label for="">Codigo</label>
					<input type="hidden" name="id_productoFactura" id="id_productoFactura" ng-model="agregarInsertProduFactura.id_productoFactura">
					<input type="text" class="form-control btn-sm" name="codigo_productoFactura" id="codigo_productoFactura" ng-model="agregarInsertProduFactura.codigo_productoFactura" disabled>
					
				</div>
				<div class="col-md-4">
					<label for="">producto</label>
					<input type="text" class="form-control btn-sm" name="nombre_productoFactura" id="nombre_productoFactura" ng-model="agregarInsertProduFactura.nombre_productoFactura" disabled>
					
				</div>
				<div class="col-md-4 col-espacio">
					<label for="">valor Unidad</label>
					<input type="text"  class="form-control btn-sm" name="valor_venta" id="valor_venta" ng-model="agregarInsertProduFactura.valor_venta" disabled>
				</div>
				<div class="col-md-4">
					<label for="">Cantidad de Productos</label>
					<input type="number" class="form-control btn-sm"  name="cantidad_productoFactura" id="cantidad_productoFactura" ng-model="agregarInsertProduFactura.cantidad_productoFactura" ng-keypress='agregarProductoPlansepareForm(e,agregarInsertProduFactura)'>
					
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</div>
<!-- fin ver agregar nuevos producto y cantidad -->
<!-- Ininio ventana modal de productos -->
<div id="modal-productoFactura" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Productos</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<input type="text" class="form-control input-sm" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
				</div>
				<div class="col-md-12">
					<uib-pagination class="pagination-sm pagination" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
				</div>
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nombre Producto</th>
									<th>nombre_categoria</th>
									<th>codigo</th>
									<th>Agregar</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
									<td>{{listado.descripcion}}</td>
									<td>{{listado.nombre_categoria}}</td>
									<td>{{listado.codigo_producto}}</td>
									<td>
										<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarProductofacturaForm(listado.id_producto,listado.nombre,listado.codigo_producto,listado.valor_venta,agregarInsertProduFactura)">
										<span class="icon-cart-plus"></span>Agregar</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- fin ver agregar nuevos producto y cantidad -->
<!-- Ininio ventana modal de productos -->
<div id="modal-productoFactura" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Productos</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<input type="text" class="form-control input-sm" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
				</div>
				<div class="col-md-12">
					<uib-pagination class="pagination-sm pagination" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
				</div>
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nombre Producto</th>
									<th>nombre_categoria</th>
									<th>codigo</th>
									<th>Agregar</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
									<td>{{listado.nombre}}</td>
									<td>{{listado.nombre_categoria}}</td>
									<td>{{listado.codigo_producto}}</td>
									<td>
										<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarProductofacturaForm(listado.id_producto,listado.nombre,listado.codigo_producto,listado.valor_venta,agregarInsertProduFactura)">
										<span class="icon-cart-plus"></span>Agregar</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
</uib-tab>
<!-- --------------------- SEGUNDO TAP  -->
<uib-tab index="1">
<uib-tab-heading>
<i class="material-icons">list_alt</i>Lista De Creditos
</uib-tab-heading>
<div class="row">
<div class="col-md-4">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">send</i>
			</div>
			<h3 class="card-title">codigo Egreso</h3>
		</div>
		<div class="card-body">
			<input type="number" class="form-control"  ng-model="codigoCredito" ng-keypress="buscarCreditoporcodigo(e,codigoCredito)">
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">today</i>
			</div>
			<h3 class="card-title">Fecha inicial</h3>
		</div>
		<div class="card-body">
			<input type="date" class="form-control" name="fechaInicialPansepare" id="fechaInicialPansepare" ng-model="listar_credito.fechaInicialPansepare">
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">today</i>
			</div>
			<h3 class="card-title">Fecha Final</h3>
		</div>
		<div class="card-body">
			<input type="date" class="form-control" name="fechaFinalPansepare" id="fechaFinalPansepare" ng-model="listar_credito.fechaFinalPansepare">
		</div>
	</div>
</div>
</div>
<div class="col-md-6">
<button type="button" class="btn btn-info btn-sm" ng-click="buscarCreditoporfecha(listar_credito)"><span class="icon-search"></span>Buscar</button>
</div>
<div class="col-md-12">
<span><i>{{"Registros Encontrados"}}</i></span>
<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
	{{ListaPlanesDados.length}}
</span>
</div>
<div class="col-md-12">
<div class="container-3">
	<span class="icon"><i class="material-icons">search</i></span>
	<input type="text" class="form-control" ng-model="filtroLiistaPl" id="search">
</div>
</div>
<div class="col-md-12">
<uib-pagination class="pagination-mod" total-items="filterRangoFechasPl.length" ng-model="pageListaPlanesDados" ng-change="paginaListaPlanesDados()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=25></uib-pagination>
</div>
<!-- 	<div class="col-md-12">
<button type="button" class="btn btn-info" ng-click="generar_reportePDFfacturaXfecha(agregarbusquedaFacturaXf)">Generar Reporte</button>
</div>
-->
<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Identificacion</th>
				<th>Nombres</th>
				<th>Fecha inical</th>
				<th>Fecha final</th>
				<th>total apagar</th>
				<th>Deuda</th>
				<th>Estado</th>
				<th>vencido</th>
				<th colspan="2">Operaciones</th>
			</tr>
		</thead>
		<tbody class="tbl-normal">
			<!-- <tr ng-repeat="listado in filterfacturXfechaRango = (ListaPlanesDados | filter : filtroProductoIngreso)"> -->
			<tr ng-repeat="listado in filterRangoFechasPl = (ListaPlanesDados | filter : filtroLiistaPl) | limitTo:25:25*(pageListaPlanesDados-1)">
				
				<td>{{listado.cc_cliente}}</td>
				<td>{{listado.nombre_cliente}}</td>
				<td>{{listado.fecha_inicio}}</td>
				<td>{{listado.fecha_fin}}</td>
				
				<td>{{listado.total_pagosepare}}</td>
				<td>{{listado.descuento_abonos}}</td>
				<td>{{listado.estado}}</td>
				<td>{{listado.estadocredito}}</td>
				<td>
					<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-detallePagos_planSeare" ng-click="verdetalleCredito(listado.id_credito,listado.id_cliente)"><span class="icon-eye"></span>Ver Detalle</button>
				</td>
				<td>
					<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_cuotas_listaPlansepare"  ng-click="cuotas_listacredito(listado.descuento_abonos,listado.id_credito,listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,cuotas_credito)"><span class="icon-file-pdf"></span>Genera Pago</button>
				</td>
				<td>
					<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ConfirmEliminacionPlansepare" ng-click="Confirmaeliminar_ProductoCreditoreXfechas(listado.id_credito,listado.id_cliente,listar_credito.fechaInicialPansepare,listar_credito.fechaFinalPansepare,listado.estadoproductos,confirmaeliminacionPlan)" > <i class="material-icons"></i></button>
				</td>
			</tr>
			
		</tbody>
	</table>
</div>
</div>
<!-- Ininio ventana modal de abonos del plan separe -->
<div id="modal_cuotas_listaPlansepare" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Pago Cuotas Plan Separe</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				
				
				<div class="col-md-6">
					<label for="">cc cliente</label>
					<input type="hidden" name="id_cliente" id="id_cliente" ng-model="cuotas_credito.id_cliente">
					<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="cuotas_credito.identificacion" disabled>
					
				</div>
				<div class="col-md-6">
					<label for="">nombre cliente</label>
					<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="cuotas_credito.nombre_clientes" disabled>
					
				</div>
				<div class="col-md-4">
					<label for="">Deuda Actual</label>
					<input type="text" class="form-control" name="deuda_actual" id="deuda_actual" ng-model="cuotas_credito.deuda_actual" disabled>
					<input type="hidden" class="form-control" name="id_credito" id="id_credito" ng-model="cuotas_credito.id_credito" >
				</div>
				<div class="col-md-4">
					<label for="">Pago</label>
					<input type="text" class="form-control" name="pagocuota_plansepare" id="pagocuota_plansepare" ng-model="cuotas_credito.pagocuota_plansepare">
					
				</div>
				
				<div class="col-md-12">
					<button type="button" class="btn btn-info btn-md" data-dismiss="modal" ng-click="guardar_CuotaPagoCredito(cuotas_credito,listar_credito)">
					<span class="icon-doc"></span> Guardar
					</button>
				</div>
				
				
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
</div>
<!-- fin ventana modal de abonos del plan separe -->
<!-- Ininio ventana que mostrara el detalle o lista de cuotas de pago -->
<div id="modal-detallePagos_planSeare" class="modal fade" role="dialog">
<div class="modal-dialog ta_modal">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Detalles de Cuotas de Pago </h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-4">
					<label>Identificacion: </label>
					{{cc_cliente_sql}}
					
				</div>
				<div class="col-md-4">
					<label>Nombre Cliente:</label>
					{{nombre_cliente_sql}}
					
				</div>
				<div class="col-md-4">
					<label>Tota Apagar:</label>
					{{total_pagosepare_sql}}
					
				</div>
				<div class="col-md-4">
					<label>Valor Aumento</label>
					{{valor_aumetoplansepare_sql}}
					
				</div>
				<div class="col-md-4">
					<label>Fecha Inicio</label>
					{{fecha_inicio_sql}}
					
				</div>
				<div class="col-md-4">
					<label>Fecha Fin</label>
					{{fecha_fin_sql}}
					
				</div>
				
				
				<!-- listado de producto del plan separe -->
				<div class="col-md-12">
					<h4>Producto Del Plan Separe </h4>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Codigo Producto </th>
									<th>Nombre </th>
									<th>Nombre Categoria </th>
									<th>Valor Venta </th>
									<th>Unidad </th>
									<th>Fraccion </th>
									<th>Valor actual producto </th>
									
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaPagosPlanes)">
									<td>{{listado.codigo_producto}}</td>
									<td>{{listado.descripcion}}</td>
									<td>{{listado.nombre_categoria}}</td>
									<td>{{listado.valor_venta}}</td>
									<td>{{listado.cantidad}}</td>
									<td>{{listado.cantidadFraccion}}</td>
									<td>{{listado.valor_actual_producto}}</td>
									
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- listado de cuotas pagadas al plan separa  -->
				<div class="col-md-12">
					<h4>Datos Pago</h4>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Valor Pago</th>
									<th>fecha_abono</th>
									<th>Actualizar</th>
									
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaProductosPlanSepare)">
									<td>{{listado.valor_abono}}</td>
									<td>{{listado.fecha_abono}}</td>
									<td>
										<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-actualizacionCuotaplansepare"  ng-click="verinformacionCuotaActualizarCredito(listado.id_abonos_credito,listado.id_credito,listado.valor_abono,listado.id_cliente,listado.descuento_abonos,actualizacion_cuotas_credito)"  data-dismiss="modal"><span class="icon-arrows-cw"></span>Actualizar</button>
									</td>
									<td>
										<button type="button" class="btn btn-success"   ng-click="imprimmirRecibocuptaCredito(listado.id_abonos_credito,listado.id_credito)"><span class="icon-file-pdf"></span>Imprimir</button>
									</td>
									
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-4">
					<h6>Total Apagar: <span class="letra">{{total_pagosepare_sql}}</span></h6>
				</div>
				<div class="col-md-4">
					<h6>Total Deuda: <span class="letra">{{descuento_abonos_sql}}</span></h6>
				</div>
				<div class="col-md-3">
					<h6>Total Abonos: <span class="letra">{{sumacuotas}}</span></h6>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</div>
<!-- fin ventana que mostrara el detalle o lista de cuotas de pago -->
<!-- Ininio ventana modal actualizacion de la cuota del plan separe -->
<div id="modal-actualizacionCuotaplansepare" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Actualizar Cuotas Plan Separe</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				
				<div class="col-md-6">
					<label for="">Cuota Anterior</label>
					<input type="text" class="form-control input-sm" name="cuotaanterior" id="cuotaanterior" ng-model="actualizacion_cuotas_credito.cuotaanterior" disabled>
					
				</div>
				
				<div class="col-md-6 col-espacio">
					<label for="">Nueva Cuota</label>
					<input type="hidden" name="id_abonos_credito" id="id_abonos_credito" ng-model="actualizacion_cuotas_credito.id_abonos_credito" disabled>
					<input type="hidden" name="id_credito" id="id_credito" ng-model="actualizacion_cuotas_credito.id_credito" disabled>
					<input type="hidden" name="descuento_abonos" id="descuento_abonos" ng-model="actualizacion_cuotas_credito.descuento_abonos" disabled>
					<input type="number" class="form-control input-sm" name="nuevacuota" placeholder="identificación" id="nuevacuota" ng-model="actualizacion_cuotas_credito.nuevacuota" >
					
				</div>
				
				<div class="col-md-12">
					<button type="button" class="btn btn-info btn-md"  data-dismiss="modal" ng-click="actualizar_CuotaCredito(actualizacion_cuotas_credito,listar_credito)">
					Guardar
					</button>
				</div>
				
				
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
</div>
<!-- fin ventana modal actualizacion de la cuota del plan separe -->
<!-- Ininio ventana modal conformar eliminacion del plan separe -->
<div id="modal-ConfirmEliminacionPlansepare" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Eliminar Credito</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				
				<div class="col-md-12">
					
					<input type="hidden" name="id_credito" id="id_credito" ng-model="confirmaeliminacionPlan.id_credito" disabled>
					<input type="hidden" name="id_cliente" id="id_cliente" ng-model="confirmaeliminacionPlan.id_cliente" disabled>
					<input type="hidden" name="fechaInicialPansepare" id="fechaInicialPansepare" ng-model="confirmaeliminacionPlan.fechaInicialPansepare" disabled>
					<input type="hidden" name="fechaFinalPansepare" id="fechaFinalPansepare" ng-model="confirmaeliminacionPlan.fechaFinalPansepare" disabled>
					<input type="hidden" class="form-control input-sm" name="estadoproductos" placeholder="estadoproductos" id="estadoproductos" ng-model="confirmaeliminacionPlan.estadoproductos" >
					
				</div>
				<div class="col-md-12">
					<h3>
					Realmente desea eliminar el plan separe seleccionado,<b> toda la información se perderá</b>; por favor verifique que no tenga cuotas o que el producto ya se ha entregado
					</h3>
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-danger btn-sm" ng-click="eliminar_ProductoCreditoXfechas(confirmaeliminacionPlan,listar_credito)" data-dismiss="modal">
					<span class="icon-doc"></span> Aceptar
					</button>
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
				</div>
				
				
			</div>
		</div>
		<!--  <div class="modal-footer">
																							<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
		</div> -->
	</div>
</div>
</div>
<!-- fin ventana modal conformar eliminacion del plan separe -->
</uib-tab>
</uib-tabset>