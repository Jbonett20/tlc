<?php   session_start();
  //$_SESSION['ejecutado'];
?>

<div class="panel panel-body">

<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="icon-home"></em>
				</a></li>
			<li class="active">Plan Separe</li>
		</ol>
</div>	
	<h2>Plan Separe</h2>
	
	<uib-tabset active="active">
		<uib-tab index="0" heading="Crear Plan Separe">
			<form  id="Form_insertarIngresos">
				<div class="col-md-4">
					<input type="hidden" name="id_cliente" id="id_cliente" ng-model="insertarplansepare.id_cliente">
					<div class="input-group">
						<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="insertarplansepare.identificacion" disabled>
						<span class="input-group-btn">
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_clientes_Factura"><span class="icon-search"></span> Buscar</button>
						</span>
					</div>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="insertarplansepare.nombre_clientes" disabled>
					
				</div>

				

				<div class="col-md-4">
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-agregar_productoFactura"><span class="icon-cart-plus"></span> Agregar Producto</button>
				</div>

				<div class="col-md-10">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nombre Producto</th>
									<th>Codigo</th>
									<th>Cantidad</th>
									<th>Valor Un.</th>
									<th>Total</th>
									<th></th>
									
									
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterproducDetalles = (listaProductosPlan_separe)">
									<td>{{listado.nombre}}</td>
									<td>{{listado.codigoProducto}}</td>
									<td>{{listado.cantidad}}</td>
									<td>{{listado.valor_venta}}</td>
									<td>{{listado.valorTotal}}</td>
									<td>
										<button type="button" class="btn btn-danger" ng-click="eliminarProductoPlansepare(listado.id_producto,listado.valorTotal)"><span class="icon-trash"></span> Eliminar</button>
									</td>
									
									
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<th>Total a Pagar</th>
									<th>{{totalapagar_plansepare}}</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="">Valor Aumeto Plan Sepate</label>
						<input type="number" placeholder="Valor Aumeto Plan Sepate" class="form-control input-sm"  ng-model="insertarplansepare.valor_aumento" name="valor_aumento">
					</div>
				</div>	

				<div class="col-md-4">
					<div class="form-group">
						<label for="">Fecha Inicio</label>
						<input type="date" placeholder="Fecha Inicio" class="form-control input-sm"  ng-model="insertarplansepare.fecha_inicioPlansepare" name="fecha_inicioPlansepare">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="">Fecha Fin</label>
						<input type="date" placeholder="Fecha Fin" class="form-control input-sm"  ng-model="insertarplansepare.fechaFin_plansepare" name="fechaFin_plansepare">
					</div>
				</div>


				<div class="col-md-4">
					<button type="button" class="btn btn-info btn-md" ng-click="guardar_plansepare(insertarplansepare)">
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
						<uib-pagination class="pagination-sm pagination" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
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
			<!-- fin ventana modal de productos -->

		</uib-tab>
		<!-- --------------------- SEGUNDO TAP  -->
		<uib-tab index="1" heading="Lista Planes Separe">

			<div class="col-md-4">
				<label for="">Fecha inicial</label>
				<input type="date" class="form-control" name="fechaInicialPansepare" id="fechaInicialPansepare" ng-model="listar_plansepare.fechaInicialPansepare">
			</div>
			<div class="col-md-4 col-espacio">
				<label for="">Fecha final</label>
				<input type="date" class="form-control" name="fechaFinalPansepare" id="fechaFinalPansepare" ng-model="listar_plansepare.fechaFinalPansepare">
			</div>

			<div class="col-md-6">
				<button type="button" class="btn btn-info btn-sm" ng-click="buscarPlanesSepareporfecha(listar_plansepare)"><span class="icon-search"></span>Buscar</button>
			</div>
			
			<div class="col-md-12">
				<span><i>{{"Registros Encontrados"}}</i></span>
				<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
					{{ListaPlanesDados.length}}
				</span>
			</div>

			<div class="col-md-4 col-espacio">
				<label for="">Buscar</label>
				<input type="text" class="form-control" ng-model="filtroLiistaPl">
			</div>

			<div class="col-md-12">
				<uib-pagination class="pagination-sm pagination" total-items="filterRangoFechasPl.length" ng-model="pageListaPlanesDados" ng-change="paginaListaPlanesDados()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=25></uib-pagination>
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
						<tbody>
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
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-detallePagos_planSeare" ng-click="verdetallePlanSepare(listado.id_plansepare,listado.id_cliente)"><span class="icon-eye"></span>Ver Detalle</button>
								</td>
								<td>
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_cuotas_listaPlansepare"  ng-click="cuotas_listaPlansepare(listado.descuento_abonos,listado.id_plansepare,listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,cuotas_Plansepare)"><span class="icon-file-pdf"></span>Genera Pago</button>
								</td>
								<td>
									<button type="button" class="{{listado.estadoPrEntregados}} btn-warning btn-sm" ng-click="entregarelProductoPlansepareXfechas(listado.id_plansepare,listado.id_cliente,listar_plansepare.fechaInicialPansepare,listar_plansepare.fechaFinalPansepare)" ><span class="icon-cart-arrow-down"></span>Entregar</button>
								</td>
								<td>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ConfirmEliminacionPlansepare" ng-click="Confirmaeliminar_ProductoPlansepareXfechas(listado.id_plansepare,listado.id_cliente,listar_plansepare.fechaInicialPansepare,listar_plansepare.fechaFinalPansepare,listado.estadoproductos,confirmaeliminacionPlan)" > <span class="icon-trash"></span> 
									Eliminar</button>
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
							<input type="hidden" name="id_cliente" id="id_cliente" ng-model="cuotas_Plansepare.id_cliente">
							<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="cuotas_Plansepare.identificacion" disabled>
							
						</div>

						<div class="col-md-6">
							<label for="">nombre cliente</label>
							<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="cuotas_Plansepare.nombre_clientes" disabled>
							
						</div>

						<div class="col-md-4">
							<label for="">Deuda Actual</label>
							<input type="text" class="form-control" name="deuda_actual" id="deuda_actual" ng-model="cuotas_Plansepare.deuda_actual" disabled>
							<input type="hidden" class="form-control" name="id_plansepare" id="id_plansepare" ng-model="cuotas_Plansepare.id_plansepare" >
						</div>

						<div class="col-md-4">
							<label for="">Pago</label>
							<input type="text" class="form-control" name="pagocuota_plansepare" id="pagocuota_plansepare" ng-model="cuotas_Plansepare.pagocuota_plansepare">
							
						</div>


					
						<div class="col-md-12">
							<button type="button" class="btn btn-info btn-md" ng-click="guardar_CuotaPagoPlansepare(cuotas_Plansepare,listar_plansepare)">
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
			  <div class="modal-dialog">

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
										<th>Cantidad </th>
										<th>Valor actual producto </th>
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaPagosPlanes)">
										<td>{{listado.codigo_producto}}</td>
										<td>{{listado.nombre}}</td>
										<td>{{listado.nombre_categoria}}</td>
										<td>{{listado.valor_venta}}</td>
										<td>{{listado.cantidad}}</td>
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
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-actualizacionCuotaplansepare"  ng-click="verinformacionCuotaActuali(listado.id_abonos_plansepare,listado.id_plansepare,listado.valor_abono,listado.id_cliente,listado.descuento_abonos,actualizacion_cuotas_Plansepare)"><span class="icon-arrows-cw"></span>Actualizar</button>
										</td>
										<td>
											<button type="button" class="btn btn-success"   ng-click="imprimmirRecibocuptaPlan(listado.id_abonos_plansepare,listado.id_plansepare)"><span class="icon-file-pdf"></span>Imprimir</button>
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
							<input type="text" class="form-control input-sm" name="cuotaanterior" id="cuotaanterior" ng-model="actualizacion_cuotas_Plansepare.cuotaanterior" disabled>
							
						</div>
						
						<div class="col-md-6 col-espacio">
							<label for="">Nueva Cuota</label>
							<input type="hidden" name="id_abonos_plansepare" id="id_abonos_plansepare" ng-model="actualizacion_cuotas_Plansepare.id_abonos_plansepare" disabled>
							<input type="hidden" name="id_plansepare" id="id_plansepare" ng-model="actualizacion_cuotas_Plansepare.id_plansepare" disabled>
							<input type="hidden" name="descuento_abonos" id="descuento_abonos" ng-model="actualizacion_cuotas_Plansepare.descuento_abonos" disabled>
							<input type="number" class="form-control input-sm" name="nuevacuota" placeholder="identificación" id="nuevacuota" ng-model="actualizacion_cuotas_Plansepare.nuevacuota" >
							
						</div>


					
						<div class="col-md-12">
							<button type="button" class="btn btn-info btn-md" ng-click="actualizar_CuotaPlansepare(actualizacion_cuotas_Plansepare,listar_plansepare)">
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
			        <h2 class="tt_modal">Eliminar Plan Separe</h2>
			      </div>
			      <div class="modal-body">
			      	<div class="row">

				      						
						<div class="col-md-12">
							
							<input type="hidden" name="id_plansepare" id="id_plansepare" ng-model="confirmaeliminacionPlan.id_plansepare" disabled>
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
							<button type="button" class="btn btn-danger btn-sm" ng-click="eliminar_ProductoPlansepareXfechas(confirmaeliminacionPlan,listar_plansepare)">
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
		<!-- ---------------- TECER ITEMS -->

		<uib-tab index="2" heading="Plan Separe por Clientes">
			<div class="col-md-4">
				<input type="hidden" name="id_cliente" id="id_cliente" ng-model="listar_plansepareXcliente.id_cliente">
				<div class="input-group">
					<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="listar_plansepareXcliente.identificacion" disabled>
					<span class="input-group-btn">
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_clientes_listaPlansepare"><span class="icon-search"></span> Buscar</button>
					</span>
				</div>
			</div>

			<div class="col-md-6 col-espacio">
				<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="listar_plansepareXcliente.nombre_clientes" disabled>
			</div>

			<div class="col-md-6">
				<button type="button" class="btn btn-info btn-sm" ng-click="buscarPlanesSepareXcliente(listar_plansepareXcliente.id_cliente)"><span class="icon-search"></span>Buscar</button>
			</div>

			<div class="col-md-12">
				<span><i>{{"Registros Encontrados"}}</i></span>
				<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
					{{ListaPlanesDadosXcliente.length}}
				</span>
			</div>

			<div class="col-md-4 col-espacio">
				<label for="">Buscar</label>
				<input type="text" class="form-control" ng-model="filtroLiistaPl">
			</div>

			<div class="col-md-12">
				<uib-pagination class="pagination-sm pagination" total-items="filterPlanXcliente.length" ng-model="pageListaPlanesDadosXcliente" ng-change="paginaListaPlanesDadosXcliente()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=25></uib-pagination>
			</div>

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
						<tbody>
							<!-- <tr ng-repeat="listado in filterfacturXfechaRango = (ListaPlanesDadosXcliente | filter : filtroProductoIngreso)"> -->

								<tr ng-repeat="listado in filterPlanXcliente = (ListaPlanesDadosXcliente | filter : filtroLiistaPl) | limitTo:25:25*(pageListaPlanesDadosXcliente-1)">
								
								<td>{{listado.cc_cliente}}</td>
								<td>{{listado.nombre_cliente}}</td>
								<td>{{listado.fecha_inicio}}</td>
								<td>{{listado.fecha_fin}}</td>
								
								<td>{{listado.total_pagosepare}}</td>
								<td>{{listado.descuento_abonos}}</td>
								<td>{{listado.estado}}</td>
								<td>{{listado.estadocredito}}</td>
								<td>
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-detallePagos_planSeareXcliente" ng-click="verdetallePlanSepare(listado.id_plansepare,listado.id_cliente)"><span class="icon-eye"></span>Ver Detalle</button>
								</td>
								<td>
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_cuotas_listaPlansepareXcliente"  ng-click="cuotas_listaPlansepare(listado.descuento_abonos,listado.id_plansepare,listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,cuotas_Plansepare)"><span class="icon-file-pdf"></span>Generar Pago</button>
								</td>
								<td>
									<button type="button" class="{{listado.estadoPrEntregados}}" ng-click="entregarelProductoPlansepare(listado.id_plansepare,listado.id_cliente)" ><span class="icon-cart-arrow-down"></span>Entrega</button>
								</td>

								<td>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ConfirmEliminaPlanSepareXclien" ng-click="Confirmaeliminar_ProductoPlansepareXcliente(listado.id_plansepare,listado.id_cliente,listar_plansepare.fechaInicialPansepare,listar_plansepare.fechaFinalPansepare,listado.estadoproductos,confirmaeliminacionPlanXcliente)" ><span class="icon-trash"></span>Eliminar</button>
								</td>

							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Ininio ventana modal de abonos del plan separe -->
			<div id="modal_cuotas_listaPlansepareXcliente" class="modal fade" role="dialog">
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
							<input type="hidden" name="id_cliente" id="id_cliente" ng-model="cuotas_Plansepare.id_cliente">
							<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="cuotas_Plansepare.identificacion" disabled>
							
						</div>

						<div class="col-md-6">
							<label for="">nombre cliente</label>
							<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="cuotas_Plansepare.nombre_clientes" disabled>
							
						</div>

						<div class="col-md-4">
							<label for="">Deuda Actual</label>
							<input type="text" class="form-control" name="deuda_actual" id="deuda_actual" ng-model="cuotas_Plansepare.deuda_actual" disabled>
							<input type="hidden" class="form-control" name="id_plansepare" id="id_plansepare" ng-model="cuotas_Plansepare.id_plansepare" >
						</div>

						<div class="col-md-4 col-espacio">
							<label for="">Pago</label>
							<input type="text" class="form-control" name="pagocuota_plansepare" id="pagocuota_plansepare" ng-model="cuotas_Plansepare.pagocuota_plansepare">
							
						</div>


					
						<div class="col-md-12">
							<button type="button" class="btn btn-info btn-md" ng-click="guardar_CuotaPagoPlansepareXcliente(cuotas_Plansepare,listar_plansepare)">
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
			
			<!-- fin ventana modal de abonos del plan separe -->

			<!-- Ininio ventana que mostrara el detalle o lista de cuotas de pago -->
			<div id="modal-detallePagos_planSeareXcliente" class="modal fade" role="dialog">
			  <div class="modal-dialog">

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
										<th>codigo_producto </th>
										<th>nombre </th>
										<th>nombre_categoria </th>
										<th>valor_venta </th>
										<th>cantidad </th>
										<th>valor_actual_producto </th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaPagosPlanes)">
										<td>{{listado.codigo_producto}}</td>
										<td>{{listado.nombre}}</td>
										<td>{{listado.nombre_categoria}}</td>
										<td>{{listado.valor_venta}}</td>
										<td>{{listado.cantidad}}</td>
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
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaProductosPlanSepare)">
										<td>{{listado.valor_abono}}</td>
										<td>{{listado.fecha_abono}}</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-actualizacionCuotaplansepareXcliente"  ng-click="verinformacionCuotaActualiXcliente(listado.id_abonos_plansepare,listado.id_plansepare,listado.valor_abono,listado.id_cliente,listado.descuento_abonos,actualizacion_cuotas_PlansepareXcli)"><span class="icon-file-pdf"></span>Actualizar</button>
										</td>
										<td>
											<button type="button" class="btn btn-success"   ng-click="imprimmirRecibocuptaPlan(listado.id_abonos_plansepare,listado.id_plansepare)"><span class="icon-file-pdf"></span>Imprimir</button>
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
			<div id="modal-actualizacionCuotaplansepareXcliente" class="modal fade" role="dialog">
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
							<input type="text" name="cuotaanterior" id="cuotaanterior" ng-model="actualizacion_cuotas_PlansepareXcli.cuotaanterior" disabled>				
						</div>
						<div class="col-md-6">
							<label for="">Nueva Cuota</label>
						
							<input type="hidden" name="id_abonos_plansepare" id="id_abonos_plansepare" ng-model="actualizacion_cuotas_PlansepareXcli.id_abonos_plansepare" disabled>
							<input type="hidden" name="id_plansepare" id="id_plansepare" ng-model="actualizacion_cuotas_PlansepareXcli.id_plansepare" disabled>
							<input type="hidden" name="descuento_abonos" id="descuento_abonos" ng-model="actualizacion_cuotas_PlansepareXcli.descuento_abonos" disabled>
							<input type="number" class="form-control input-sm" name="nuevacuota" placeholder="identificación" id="nuevacuota" ng-model="actualizacion_cuotas_PlansepareXcli.nuevacuota">							
						</div>

					
						<div class="col-md-12">
							<button type="button" class="btn btn-info btn-md" ng-click="actualizar_CuotaPlansepareZcliente(actualizacion_cuotas_PlansepareXcli)">
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
			
			<!-- fin ventana modal actualizacion de la cuota del plan separe -->



			<!-- Ininio ventana modal de clientes -->
			<div id="modal_clientes_listaPlansepare" class="modal fade" role="dialog">
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
						<uib-pagination class="pagination-sm pagination" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
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
											<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarClienteListado_Plansepare(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,listar_plansepareXcliente)">Agregar</button>
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


			<!-- Ininio ventana modal conformar eliminacion del plan separe -->
			<div id="modal-ConfirmEliminaPlanSepareXclien" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h2 class="tt_modal">Eliminar Plan Separe</h2>
			      </div>
			      <div class="modal-body">
			      	<div class="row">

				      						
						<div class="col-md-12">
							
							<input type="hidden" name="id_plansepare" id="id_plansepare" ng-model="confirmaeliminacionPlanXcliente.id_plansepare" disabled>
							<input type="hidden" name="id_cliente" id="id_cliente" ng-model="confirmaeliminacionPlanXcliente.id_cliente" disabled>
							<input type="hidden" name="fechaInicialPansepare" id="fechaInicialPansepare" ng-model="confirmaeliminacionPlanXcliente.fechaInicialPansepare" disabled>
							<input type="hidden" name="fechaFinalPansepare" id="fechaFinalPansepare" ng-model="confirmaeliminacionPlanXcliente.fechaFinalPansepare" disabled>
							<input type="hidden" class="form-control input-sm" name="estadoproductos" placeholder="estadoproductos" id="estadoproductos" ng-model="confirmaeliminacionPlanXcliente.estadoproductos" >
							
						</div>
						<div class="col-md-12">
							<h3>
								Realmente desea eliminar el plan separe seleccionado,<b> toda la información se perderá</b>; por favor verifique que no tenga cuotas o que el producto ya se ha entregado  
							</h3>
						</div>
						<div class="col-md-6">
							<button type="button" class="btn btn-danger btn-ms" ng-click="eliminar_ProductoPlansepareXclientes(confirmaeliminacionPlanXcliente,listar_plansepareXcliente)">
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

		
</div>