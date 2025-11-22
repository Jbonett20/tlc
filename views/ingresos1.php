<?php   session_start();
//$_SESSION['ejecutado'];
?>
<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">add_box</i>Crear Ingreso
</uib-tab-heading>
<!--productos Base-->
<form   name="Form_insertarIngresos" id="Form_insertarIngresos">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Ingresos</h3>
				</div>
				<div class="card-body">
					<div class="row" ng-class="{'has-error':Form_insertarIngresos.codigo_producto.$invalid && Form_insertarIngresos.codigo_producto.$dirty}">
						
						<label class="col-md-3 col-form-label">Codigo</label>
						<div class="col-md-5">
							<input type="hidden" name="id_producto" id="id_producto" ng-model="insertIngresos.id_producto">
							<div class="input-group">
								<input type="text" class="form-control" name="codigo_producto" id="codigo_producto" ng-model="insertIngresos.codigo_producto" disabled>
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="material-icons">search</i>Buscar</button>
								</span>
							</div>
						</div>
						
					</div>
					
					<div class="row" ng-class="{'has-error':Form_insertarIngresos.nombre_producto.$invalid && Form_insertarIngresos.nombre_producto.$dirty}">
						
						<label class="col-md-3 col-form-label"> Nombre Producto </label>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" class="form-control" name="nombre_producto" id="nombre_producto" ng-model="insertIngresos.nombre_producto" disabled>
							</div>
						</div>
						<input type="hidden" class="form-control input-sm" name="fraccion" id="fraccion" ng-model="insertIngresos.fraccion" disabled>
						
					</div>
					
					<div class="row" ng-class="{'has-error':Form_insertarIngresos.cantidad.$invalid && Form_insertarIngresos.cantidad.$dirty}">
						<label class="col-md-3 col-form-label">Cantidad Unidad</label>
						<div class="col-md-5">
							<div class="form-group">
								<input type="number" class="form-control" name="cantidad" id="cantidad" ng-model="insertIngresos.cantidadUnidad">
							</div>
						</div>
					</div>
					<div class="row" ng-class="{'has-error':Form_insertarIngresos.cantidad.$invalid && Form_insertarIngresos.cantidad.$dirty}" ng-if="insertIngresos.fraccion!=0">
						<label class="col-md-3 col-form-label">Cantidad Fraccion</label>
						<div class="col-md-5">
							<div class="form-group">
								<input type="number" class="form-control input-sm" name="cantidad" id="cantidad" ng-model="insertIngresos.cantidadFraccion">
							</div>
						</div>
					</div>
					
				</div>
				<div class="card-footer">
					<div class="col-md-12">
						<button type="button" class="btn btn-primary" ng-disabled="Form_insertarIngresos.$invalid"  ng-click="guardarIngresos(insertIngresos)">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- fin productos base -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog ta_modal">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Productos</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="container-3">
						<span class="icon"><i class="material-icons">search</i></span>
						<input type="text" class="form-control" placeholder="Buscar..." id="search" name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
					</div>
					
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre Producto</th>
										<th>Codigo</th>
										<th>Agregar</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
										<td>{{listado.descripcion}}</td>
										<td>{{listado.codigo_producto}}</td>
										<td>
											<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarProductoIngresosInsert(listado.id_producto,listado.descripcion,listado.codigo_producto,listado.fraccion,insertIngresos)">Agregar</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- fin ventana modal de productos -->
</uib-tab>
<uib-tab index="1">
<uib-tab-heading>
<i class="material-icons">add_box</i>Ingresos Por Factura
</uib-tab-heading>
<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Factura</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<label class="col-md-3 col-form-label">Nombre Factura</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control" id="nameFac" ng-model="AddFactura.nombreAddFactura">
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="col-md-12">
					<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="guardarFacturaAdd(AddFactura)">
					<span class="icon-cart-plus"></span>GUARDAR</button>
				</div>
			</div>
			
		</div>
	</div>
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroAddFactura" autofocus="autofocus">
				</div>
			</div>
			<div class="col-md-3 js-contenedor" ng-repeat="listadoADDF in filterADDF = (listadodetodos_addFactura | filter: filtroAddFactura)  | limitTo:4:10*(pagelistadodetodos_addFactura-10)">
				<div class="card">
					<div class="panel panel-body facturaOption" ng-click="SelectFacturaAdd(listadoADDF.nombre_factura,listadoADDF.id_ingresofactura,listadoADDF.estado,AddFacturaSelect)">
						<div class="card-header	card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">calendar_today</i>
							</div>
							<h4 class="card-title">Factura</h4>
						</div>
						<div class="card-body">
							
							<div class="col-md-12">	<h4 class="tfactura">{{listadoADDF.nombre_factura}}</h4></div>
						</div>
						<div class="card-footer">
							<span>Fecha:{{listadoADDF.fecha}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12" ng-if="AddFacturaSelect.id_ingresosAdd!=0">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">description</i>
			</div>
			<h4 class="card-title">Detalles</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<input type="hidden" class="form-control input-sm" ng-model="AddFacturaSelect.id_ingresosAdd">
					<div class="panel panel-body fact"><h4>Factura Seleccionada</h4> {{AddFacturaSelect.nombre_facturaSelect}}</div>
				</div>
				<div class="col-md-4">
					<input type="hidden" class="form-control input-sm" >
					<div class="panel panel-body fact"><h4> C. Productos </h4>{{listadodetodos_SelectFacturaAdd.length}}</div>
				</div>
				
				<div class="col-md-4" ng-if="claveInvetario!=0">
					<input type="hidden" class="form-control">
					<button class="btn btn-warning" name="enviar" ng-click="guardarFacturaSelect(AddFacturaSelect)"> Pasar A Inventario</button>
				</div>
			

			<div class="col-md-3" ng-if="AddFacturaSelect.estado!=0">
						<h4>Esta Factura Paso A invetario ¿Esta Seguro de volver hacerlo? </h4>
							<label for="">Contraseña </label><input type="password" name="passCurioso" ng-keypress="consultaClaveFactura(e,clave)" placeholder="Ingrese su contraseña" class="form-control input-sm"  ng-model="clave">
							<button type="button" class="btn btn-info btn-sm"  data-dismiss="modal">
		
				</div>
				</div>
			<!-- 			<div class="col-md-2">
				<input type="hidden" class="form-control input-sm" >
				<button class="btn btn-warning"  name="enviar" ng-click="vaciarFacturaSelect(AddFacturaSelect)" > Vaciar Productos</button>
			</div>
			<div class="col-md-2">
				<input type="hidden" class="form-control input-sm" >
				<button class="btn btn-danger"  name="enviar" ng-click="EliminarFacturaSelect(AddFacturaSelect)"> Eliminar Productos</button>
			</div> -->
		</div>
	</div>
</div>
<div class="col-md-12" ng-if="AddFacturaSelect.id_ingresosAdd!=0">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">add_shopping_cart</i>
			</div>
			<h3 class="card-tile">Productos</h3>
		</div>
		<div class="col-md-12">
			
			<div class="col-md-1">
				
				<button type="button" class="btn btn-info  btn-sm btn-tabla" data-dismiss="modal" ng-click="generarInforme(AddFacturaSelect.id_ingresosAdd)"><span class="material-icons">local_printshop</span> </button>
				
			</div>
		</div>
		
		
		<div class="card-body">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroProductoIngreso" autofocus="autofocus" ng-change="listadotodos_ProductoChangeAdd(filtroProductoIngreso,AddFacturaSelect)" ng-focus="noBarraNew()"  ng-keypress="listadotodos_ProductoKeypressAdd(e,filtroProductoIngreso,AddFacturaSelect)">
				</div>
			</div>
			
			<div class="col-md-4" ng-if="barraNew!=0">
				<h4>¿Desea Agregar Codigo de Barra a un Producto? </h4>
				<div class="col-md-1">
					<input type="submit" ng-click="showBarra(barra)"  data-toggle="modal" data-target="#myModalAddBarra" class="btn btn-info btn-sm"  value="Si!">
					
				</div>
				<div class="col-md-1 separar">
					<input type="submit" ng-click="noBarraNew()"  class="btn btn-danger btn-sm"  value="No!">
					
				</div>
			</div>
			<div  ng-show="showVistaF.show">
				
				<div class="col-md-12" >
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Stock</th>
									<th>Nombre Producto</th>
									<th ng-show="false">Barra</th>
									<th>Cantidad</th>
									<th>Frac.</th>
									<th>Valor Prod.</th>
									<th>Valor Unidad.</th>
									<th>Agregar</th>
								</tr>
							</thead>
							<tbody class="tbl-normal">
								<tr ng-repeat="listado in filterDatProducIngreso = (listadodetodos_Producto | filter : filtroProductoIngreso) | limitTo:10:10*(pagelistadodeProductos_Ingreso-10)" ng-class="{'ctr': listado.stockMinimo>=listado.Unidad}">
									<td>
										<div  class="col-md-12 btn_sesion">
											<li class="dropdown mega-dropdown btn_li">
												<a href="" class="btn_log btn btn-info btn-sm btn-tabla" class="dropdown-toggle" data-toggle="dropdown"  ng-click="verificarStock(listado.id_producto)">Opciones <span class="caret"></span></a>
												<ul class="dropdown-menu  mega-dropdown-menu  row">
													<li>
														<div class="col-md-12">
															<div class="table table-responsive">
																<table class="table">
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
									<td ng-show="false">{{listadoProducto.codigo_barras}}</td>
									<!-- <td>{{listado.nombre_categoria}}</td>
									<td>{{listado.codigo_producto}}</td> -->
									
									<td>
										<div class="input-tabla form-group form-group-sm">
											<input type="number" name="cantidadU" class="form-control input-sm tbl-fc"  ng-model="cant.cantidadU">
										</div>
									</td>
									<td>
										<div class="input-tabla form-group form-group-sm">
											<input type="number" name="cantidadF" class="form-control input-sm tbl-fc"  ng-model="cant.cantidadF" ng-if="listado.fraccion!=0" >
										</div>
									</td>
									<td>
										
										<!-- <h5><strong>V.Prod.</strong></h5> -->
										<div class="input-tabla form-group form-group-sm">
											<p><strong>${{listado.valor_venta | number:0}}</strong></p>
										</div>
										
									</td>
									<td>
										<div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">
											<!-- <h5><strong>Valor Unidad</strong></h5> -->
											<h4> <strong>${{listado.valor_unidad | number:0 }}</strong></h4>
											
										</div>
										
									</td>
									<td>
										<button type="button" class="btn btn-info btn-sm btn-tabla" data-dismiss="modal" ng-click="agregarProductoFacturaADD(listado.id_producto,cant,AddFacturaSelect)">
										<span class="icon-cart-plus"></span>Agregar</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped">
						<thead class="t-completa">
							<tr>
								<th>No.</th>
								<th>Nombre Producto</th>
								<th ng-show="false">Barra</th>
								<th>Descripcion</th>
								<th>Cant</th>
								<th>Frac</th>
								<th>Iva</th>
								<th>Costo</th>
								<th>Costo U.</th>
								<th>V.Venta</th>
								<th>V. Unid</th>
								<th>%Ren</th>
								<th>V.Renta</th>
								<th>Valor*U</th>
								<th>Gan.</th>
								
								<th>*</th>
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoADD in filterDatProducIngresoADD= (listadodetodos_SelectFacturaAdd | filter : filtroProductoIngresoADD) | limitTo:1000:1000*(pagelistadodeProductos_SelectFacturaAdd-1)">
								  <td>{{$index + 1}}</td>
								<td>{{listadoADD.descripcion}}</td>
								<td ng-show="false">{{listadoADD.codigo_barras}}</td>
								<!-- <td>{{listado.nombre_categoria}}</td>
								<td>{{listado.codigo_producto}}</td> -->
								<td> {{listadoADD.presentacion}} </td>
								<td>
									<div class="input-tabla form-group form-group-sm">
										<input type="text" name="cantidadU" class="form-control input-sm tbl-fc"  ng-model="listadoADD.cantidadUnidad" ng-keypress="EditarProductoFacturaADD(e,listadoADD.id_producto,listadoADD.cantidadUnidad,listadoADD.cantidadFraccion,AddFacturaSelect)">
									</div>
									
								</td>
								<td>
									<div class="input-tabla form-group form-group-sm">
										<input type="text" ng-if="listadoADD.fraccion!=0" name="cantidadF" class="form-control input-sm numero"  ng-model="listadoADD.cantidadFraccion" ng-if="listadoADD.fraccion!=0" ng-keypress="EditarProductoFacturaADD(e,listadoADD.id_producto,listadoADD.cantidadUnidad,listadoADD.cantidadFraccion,AddFacturaSelect)">
									</div>
									
								</td>
								<td>
								 %{{listadoADD.iva}}
								</td>
								
								<td>
									<div class="input-tabla form-group form-group-sm">
										<input type="text" name="cantidadF" class="form-control input-sm numero tamP"  ng-model="listadoADD.valor"  ng-keypress="EditarProductoFacturaADDValores(e,listadoADD.id_producto,listadoADD.valor,listadoADD.valor_venta,listadoADD.valor_unidad,AddFacturaSelect)">
									</div>
									
								</td>
								<td>
									<div class="input-tabla form-group form-group-sm" ng-if="listadoADD.fraccion!=0">
								 {{listadoADD.valor/listadoADD.fraccion | number:1}}
								</div>	<div class="input-tabla form-group form-group-sm" ng-if="listadoADD.fraccion==0">
								 {{listadoADD.valor}}
								</div>
								</td>
								
								<td>
									<div class="input-tabla form-group form-group-sm">
										<input type="text" name="cantidadF" class="form-control input-sm tamP"  ng-model="listadoADD.valor_venta"  ng-keypress="EditarProductoFacturaADDValores(e,listadoADD.id_producto,listadoADD.valor,listadoADD.valor_venta,listadoADD.valor_unidad,AddFacturaSelect)">
									</div>
									
									
								</td>
								
								<td>
									
									<div class="input-tabla form-group form-group-sm">
										<input type="number" ng-if="listadoADD.fraccion!=0" name="cantidadF" class="form-control input-sm"  value="{{listadoADD.valor_venta/listadoADD.fraccion}}"  ng-keypress="EditarProductoFacturaADDValores(e,listadoADD.id_producto,listadoADD.valor,listadoADD.valor_venta,listadoADD.valor_unidad,AddFacturaSelect)">
										<input type="text" ng-if="listadoADD.fraccion==0" name="cantidadF" class="form-control input-sm"  ng-model="listadoADD.valor_venta"  ng-keypress="EditarProductoFacturaADDValores(e,listadoADD.id_producto,listadoADD.valor,listadoADD.valor_venta,listadoADD.valor_unidad,AddFacturaSelect)">
									</div>
								</td>
								<td>
									%{{listadoADD.rentabilidad | number:1}}
								</td>
								<td>
									${{listadoADD.rentabilidad * listadoADD.valor_venta / 100 | number:0 }}
									
								</td>
								<td>
									
									<P><strong>${{listadoADD.valor_venta * listadoADD.cantidadUnidad + listadoADD.valor_unidad * listadoADD.cantidadFraccion | number:0}}</strong></P>
									
								</td>
								<td>
									
									<P><strong>${{((listadoADD.rentabilidad * listadoADD.valor_venta / 100 )*listadoADD.cantidadUnidad) + ((listadoADD.rentabilidad * listadoADD.valor_unidad / 100 )*listadoADD.cantidadFraccion)| number:0}}</strong></P>
									
								</td>
								
								<td>
									
									<button type="button" class="btn btn-danger  btn-sm btn-tabla" data-dismiss="modal" ng-click="EliminarProductoFacturaADD(listadoADD.id_producto,AddFacturaSelect)">
									
									<span class="material-icons">delete_forever</span> </button>
								</td>
							</tr>
						</tbody>
					</table>
					<h4>Total Inversion = $ {{valorInversion | number:0}} </h4>
					<h4>Total Ventas = $ {{valorVentas | number:0}} </h4>
					<h4>Total Ganancia = $ {{valorGanancia | number:0}} </h4>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ===================================================================================================== -->
<!-- ===================================================================================================== -->
<!-- ===================================================================================================== -->
<!-- ===================================================================================================== -->
<!-- ===================================================================================================== -->
</uib-tab>
<!-- ----------------------- SEGUNDO TAB  -->
<uib-tab index="2">
<uib-tab-heading>
<i class="material-icons">
format_list_bulleted
</i>
Lista de Ingresos
</uib-tab-heading>
<div class="espaciado">
	<div class="col-xs-12 col-ms-9 col-lg-4">
		<span><i>{{"Registros Encontrados"}}</i></span>
		<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
			{{listadodetodos_Ingreso.length}}
		</span>
	</div>
	<div class="col-md-12">
		<div class="container-3">
			<span class="icon"><i class="material-icons">search</i></span>
			<input type="search" placeholder="Buscar..." id="search" name="id_producto" id="id_producto" ng-model="filtroProductoIngreso" autofocus="autofocus">
		</div>
	</div>
	<div class="col-md-12">
		<uib-pagination class="pagination-mod" total-items="filterIngresos.length" ng-model="pagelistadodetodos_Ingreso" ng-change="paginalistadodetodos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=40></uib-pagination>
	</div>
	
	
	
	<div class="col-md-12">
		<div class="table-responsive">
			<table  datatable="ng" dt-options="vm.dtOptions" class="table table-hover table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nombre Producto</th>
						<th>Codigo</th>
						<th>Cantidad Unidad</th>
						<th>Cantidad Fraccion</th>
						<th>Fecha Ingreso</th>
						<th colspan="2">Operaciones</th>
					</tr>
				</thead>
				<tbody class="tbl-normal">
					<tr ng-repeat="listado in filterIngresos = (listadodetodos_Ingreso | filter : filtroProductoIngreso) | limitTo:40:40*(pagelistadodetodos_Ingreso-1)">
						  <td>{{$index + 1}}</td>
						<td>{{listado.descripcion}}</td>
						<td>{{listado.codigo_producto}}</td>
						<td>
							<div class="input-tabla form-group form-group-sm">
								{{listado.cantidad}}
							<!-- 	<input type="text" name="cantidadU" class="form-control input-sm"  ng-model="listado.cantidad" > -->
							</div>
						</td>
						<td >
							<div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">
								{{listado.cantidadFraccion}}
								<!-- <input type="text" name="cantidadU" class="form-control input-sm"  ng-model="listado.cantidadFraccion"> -->
							</div>
						</td>
						<td>{{listado.fecha}}</td>
					<!-- 	<td>
							<button type="button" class="btn btn-info btn-sm btn-tabla" data-toggle="modal" data-target="#modal-vereditarIngresoProducto" ng-click="verInfo_ingresoActualizar(listado.id_inventario,listado.id_ingresos,listado.id_producto,listado.nombre,listado.codigo_producto,listado.cantidad,updateIngresos)">Editar</button>
						</td> -->
						<td>
							<button type="button" class="btn btn-danger btn-sm btn-tabla" data-toggle="modal" data-target="#modal-eliminarIngreso" ng-click="confirmaEliminar_IngresosProducto(listado.id_producto,listado.id_ingresos,listado.cantidad,confirmaEminaIngreso)">
							<span class="icon-trash"></span>Eliminar</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- Inicio ventana de actualizacion de ingresos de producto -->
	<div id="modal-vereditarIngresoProducto" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="tt_modal">Productos</h2>
				</div>
				<div class="modal-body">
					<div class="row">
						<form  id="Form_editarIngresos">
							<div class="col-md-4">
								<input type="hidden" name="id_ingresos" id="id_ingresos" ng-model="updateIngresos.id_ingresos">
								
								
								<input type="hidden" name="id_producto" id="id_producto" ng-model="updateIngresos.id_producto">
								
								<input type="hidden" name="id_inventario" id="id_inventario" ng-model="updateIngresos.id_inventario">
								<input type="text" class="form-control input-sm" name="codigo_producto" disabled="disabled" id="codigo_producto" ng-model="updateIngresos.codigo_producto">
								
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control input-sm" name="nombre_producto" disabled="disabled" id="nombre_producto" ng-model="updateIngresos.nombre_producto">
								
							</div>
							<div class="col-md-4 col-espacio">
								<input type="hidden" name="cantidad" id="cantidad" ng-model="updateIngresos.cantidad">
								<input type="number" class="form-control input-sm" name="cantidad_nueva" id="cantidad_nueva" ng-model="updateIngresos.cantidad_nueva">
							</div>
							<div class="col-md-4 ">
								<button type="button" class="btn btn-info btn-sm" ng-click="actualizar_Ingresos(updateIngresos)">Actualizar</button>
							</div>
							
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- fin ventana de actualizacion de ingresos de producto -->
	<!-- Ininio ventana de confimacion de eliminacion del ingreso -->
	<div id="modal-eliminarIngreso" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<!-- <div class="modal-header"><h2>
				</div> -->
				<div class="modal-body">
					<div class="row">
						
						
						<div class="col-md-12">
							<h3 class="tt_modal">¿Desea Eliminar El Registro Del Ingreso?</h3>
						</div>
						<div class="col-md-4">
							<input type="hidden"  class="form-control input-sm" name="id_producto_ElimiIngre" id="id_producto_ElimiIngre" ng-model="confirmaEminaIngreso.id_producto_ElimiIngre" disabled>
						</div>
						<div class="col-md-4">
							<input type="hidden"  class="form-control input-sm"  name="id_ingreso_ElimiIngre" id="id_ingreso_ElimiIngre" ng-model="confirmaEminaIngreso.id_ingreso_ElimiIngre" disabled>
						</div>
						<div class="col-md-4 col-espacio">
							<input type="hidden" class="form-control input-sm"  name="cantidad_ElimiIngre" id="cantidad_ElimiIngre" ng-model="confirmaEminaIngreso.cantidad_ElimiIngre" disabled>
						</div>
						<!-- <div class="col-md-6 col-md-offset-4">
																																																		>
						</div>
						-->
						<div class="col-md-12 col-md-offset-3">
							<div class="col-md-2">
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-eliminarIngreso" ng-click="Eliminar_IngresosProducto(confirmaEminaIngreso)">Aceptar</button>
							</div>
							<div class="col-md-offset-1 col-md-2">
								<button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- fin ventana de confimacion de eliminacion del ingreso -->
</div>
</uib-tab>
<uib-tab index="3">
<uib-tab-heading>
<i class="material-icons">
insert_invitation
</i>
Ingresos Por Fecha
</uib-tab-heading>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Fecha Inicial</h4>
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="date" class="form-control" name="fechaInicial_ingresoGeneral" id="fechaInicial_ingresoGeneral" ng-model="busquedaingresosXfecharango.fechaInicial_ingresoGeneral">
				</div>
				
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Fecha Final</h4>
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="date" class="form-control" name="fechaFinal_ingresoGeneral" id="fechaFinal_ingresoGeneral" ng-model="busquedaingresosXfecharango.fechaFinal_ingresoGeneral">
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<button type="button" class="btn btn-primary" ng-click="generar_reportePDFingresosgenral(busquedaingresosXfecharango.fechaInicial_ingresoGeneral,busquedaingresosXfecharango.fechaFinal_ingresoGeneral)"><span class="icon-file-pdf"></span>Generar Reporte</button>
	</div>
</div>
</uib-tab>
<!-- Tab 3 -->
<!-- <uib-tab index="4"> -->
<!-- <uib-tab-heading>
<i class="material-icons">
assignment_returned
</i>
Ingresos Por Producto
</uib-tab-heading>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-text">
			<div class="card-icon">
				<i class="material-icons">inbox</i>
			</div>
			<h4 class="card-title">Productos</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6" >
					<input type="hidden" name="id_producto" id="id_producto" ng-model="busquedaingresosXproducto.id_producto">
					<div class="input-group">
						<input type="text" class="form-control input-sm" name="codigo_producto" id="codigo_producto" ng-model="busquedaingresosXproducto.codigo_producto" disabled>
						<span class="input-group-btn">
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-productorReporte"><i class="material-icons">search</i> Buscar</button>
						</span>
					</div>
				</div>
				
				<div class="col-md-6">
					<input type="text" class="form-control input-sm" name="nombre_producto" id="nombre_producto" ng-model="busquedaingresosXproducto.nombre_producto" disabled>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Fecha inicial</h4>
			</div>
			<div class="card-body">
				<input type="date" class="form-control" name="fechaInicial_ingresoXproduct" id="fechaInicial_ingresoXproduct" ng-model="busquedaingresosXproducto.fechaInicial_ingresoXproduct">
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Fecha Final</h4>
			</div>
			<div class="card-body">
				<input type="date" class="form-control" name="fechaFinal_ingresoXproduct" id="fechaFinal_ingresoXproduct" ng-model="busquedaingresosXproducto.fechaFinal_ingresoXproduct">
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<button type="button" class="btn btn-primary" ng-click="generar_reportePDFingresosXproducto(busquedaingresosXproducto.id_producto,busquedaingresosXproducto.fechaInicial_ingresoXproduct,busquedaingresosXproducto.fechaFinal_ingresoXproduct)">Generar Reporte</button>
</div>
<!-- Ininio ventana modal de productos 
<div id="modal-productorReporte" class="modal fade" role="dialog">
	<div class="modal-dialog ta_modal">
		<!-- Modal content-
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Productos</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<input type="text" class="form-control" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
					</div>
					<div class="col-md-12">
						<uib-pagination class="pagination-mod" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre Producto</th>
										<th>codigo</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
										<td>{{listado.descripcion}}</td>
										<td>{{listado.codigo_producto}}</td>
										<td>
											<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarProductXreproteInsert(listado.id_producto,listado.nombre,listado.codigo_producto,busquedaingresosXproducto)">Agregar</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>

</uib-tab> -->
</uib-tabset>
</div>
<div id="myModalAddBarra" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Productos</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<h2  align="center">{{barraView}}</h2>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<input type="text" class="form-control" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
				</div>
				
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nombre Producto</th>
									<th>Codigo</th>
									<th>Agregar</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
									<td>{{listado.descripcion}}</td>
									<td>{{listado.codigo_producto}}</td>
									<td>
										<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="addBarraProductoActualizar(listado.id_producto,barraView)">Agregar</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
// initialise Datetimepicker and Sliders
md.initFormExtendedDatetimepickers();
if($('.slider').length != 0){
md.initSliders();
}
});
</script>