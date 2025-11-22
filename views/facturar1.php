<?php   session_start();
//$_SESSION['ejecutado'];
?>
<!-- <div class="card"> -->
<uib-tabset active="active" class="col-md-12 tab-normal active-color switch-trigger">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">add_box</i>Crear Factura
</uib-tab-heading>
<form  id="Form_insertarIngresos">
	<div class="row">
		<div class="col-md-8">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda Barra..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" ng-model="filtroProductoIngreso" ng-keypress="listadotodos_ProductoKeypress(e,filtroProductoIngreso)" ng-change="listadotodos_ProductoChange(filtroProductoIngreso)" ng-focus="noBarraNew()">
				</div>
			</div>
			<div class="col-md-12" ng-if="barraNew!=0">
				<h4>¿Desea Agregar Codigo de Barra a un Producto? </h4>
				<div class="col-md-1">
					<input type="submit" ng-click="showBarra(filtroProductoIngreso)"  data-toggle="modal" data-target="#myModalAddBarra" class="btn btn-info btn-sm"  value="Si!">
				</div>
				<div class="col-md-1 separar">
					<input type="submit" ng-click="noBarraNew()"  class="btn btn-danger btn-sm"  value="No!">
				</div>
			</div>
			<div class="col-md-12" ng-show="showVistaF.show">
				<div class="col-md-12">
				<uib-pagination class="pagination-mod" total-items="filterDatProducIngreso.length"  max-size="maxSize" class="pagination-sm" boundary-links="true"  ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodetodos_Producto()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
			</div>
				
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Stock</th>
								<th>Nombre Producto</th>
								<th ng-show="false">Barra</th>
								<th>Cantidad</th>
								<th>Fraccion</th>
								<th>V.Prod</th>
								<th>V. Unidad</th>
								<th>Agregar</th>
							</tr>
						</thead>
						<tbody class="tbl-normal" >
							<tr ng-repeat="listado in filterDatProducIngreso = (listadodetodos_Producto | filter : filtroProductoIngreso) | limitTo:10:10*(pagelistadodeProductos_Ingreso-10)"  ng-class="{'ctr': listado.stockMinimo>=listado.Unidad}" >
								<td  >
									<div  class="col-md-12 btn_sesion">
										<li class="dropdown mega-dropdown btn_li">
											<a href="" class="btn_log btn btn-info btn-sm btn-tabla" class="dropdown-toggle" data-toggle="dropdown"  ng-click="verificarStock(listado.id_producto)">Opciones <span class="caret"></span></a>
											<ul class="dropdown-menu  mega-dropdown-menu  row">
												<li>
													<div class="col-md-12">
														<div class="table-table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th>Cantidad</th>
																		<th>Fraccion</th>
																	</tr>
																</thead>
																<tbody >
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
										<input type="number" name="cantidadU" class="form-control input-sm"  ng-model="cant.cantidadU" ng-keypress="agregarProductoFactura(e,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant)">
									</div>
								</td>
								<td>
									<div class="input-tabla form-group form-group-sm">
										<input type="number" name="cantidadF" class="form-control input-sm"  ng-model="cant.cantidadF" ng-if="listado.fraccion!=0"  ng-keypress="agregarProductoFactura(e,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant)">
									</div>
								</td>
								<td>
									
									<h4><strong>${{listado.valor_venta | number:0}}</strong></h4>
									
									
								</td>
								<td>
									<div ng-if="listado.fraccion!=0">
										
										<h4> <strong>${{listado.valor_unidad | number:0 }}</strong></h4>
										
									</div>
									
								</td>
								<td>
									<button type="button" class="btn btn-info btn-sm btn-tabla" data-dismiss="modal" ng-click="agregarProductoFacturaPress(listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant)">
									<span class="icon-cart-plus"></span>Agregar</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">shopping_basket</i>
						</div>
						<h3 class="card-title">Ventas</h3>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table  table-striped table-no-bordered table-hover dataTable dtr-inline">
								<thead >
									<tr>
										<!-- 	<th>Codigo</th> -->
										<th>Item.</th>
										<th>Prod.</th>
										<th>Pres.</th>
										<th>Uds.</th>
										<th>Fra</th>
										<th>Valor Un.</th>
										<th>Iva.</th>
										<th>Total</th>
										<th>Opcion</th>
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterproducDetalles = (listaProductosDetalleFactura | orderBy:'-')">
										<!-- <td data-toggle="modal" data-target="#myModalSerial" ng-click="AddSerialList(listado.id_producto,listado.codigo_,listado.nombre,listado.id_categoria,listado.descripcion,listado.valor,listado.valor_venta)" >{{listado.codigoProducto}}</td> -->
										<td>{{listado.numeroPro}}</td>
										<td>{{listado.descripcion}}</td>
										<td>{{listado.presentacion}}</td>
										<td>
											<div class="input-tabla form-group form-group-sm">
												<input type="number" name="cantidadU"  id="UnidadId" class="form-control input-sm numero" ng-model="listado.cantidadU" onclick="javascript: limpia(this);" ng-change="agregarProductoFacturaChange(listado.numeroPro,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,listado.cantidadU,listado.cantidadF)" >
											</div>
										</td>
										<td>
											<div class="input-tabla form-group form-group-sm">
												<input type="number" name="cantidadU" class="form-control input-sm numero" ng-model="listado.cantidadF" id="fraccionID" onclick="javascript: limpia(this);" ng-change="agregarProductoFacturaChange(listado.numeroPro,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,listado.cantidadU,listado.cantidadF)" ng-if="listado.fraccion!=0">
											</div>
										</td>
										<td>${{listado.valor_venta - listado.ivaV | number:0}}</td>
										<td>{{listado.ivaV}} - ({{listado.iva}} %) </td>
										<td>${{listado.valorTotal | number:0}}  </td>
										<td>
											<button type="button" class="btn btn-danger  btn-sm btn-tabla" ng-click="eliminarProductoProFacturar(listado.numeroPro,listado.id_producto,listado.valorTotal,listado.ganacia)"><span class="material-icons">delete_forever</span> </button>
										</td>
									</tr>
									
									
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header card-header-icon card-header-rose" >
					<div class="card-icon">
						<i class="material-icons" ng-click="verDescuento(cambioFacturaDinero)">payment</i>
					</div>
					<h4 class="card-title">Detalles Factura</h4>
				</div>
				<div class="card-body">
					<table class="table table-hover">
						<thead>
							
							<tr>
								<!-- <th colspan="8"></th> -->
								<th class="dinero">
									<input type="number"  onclick="javascript: limpia(this);"  onfocus="javascript: limpia(this);" onBlur="ValueFocus()" class="form-control cambio" onkeyup="format(this)" onchange="format(this)" ng-model="cambioFacturaDinero.Pagocambio" class="form-control" id="dinero" ng-change="cambioFactura(cambioFacturaDinero)" ng-keypress="guardarFactura(e,insertClientes,cambioFacturaDinero)" >
								</th>
							</tr>
							<tr ng-show="viewDescuento">
								<th class="dinero cambio"><span>Descuento</span>
									<input type="number"  onclick="javascript: limpia(this);"  onfocus="javascript: limpia(this);" onBlur="ValueFocus()" class="form-control cambio" onkeyup="format(this)" onchange="format(this)" ng-model="cambioFacturaDinero.descuento" class="form-control" id="descuento"   ng-keypress="validarDescuento(e,cambioFacturaDinero)" >
								</th>
							</tr>
							
							<tr>
								
								<!-- <th colspan="8"></th> -->
								<th class="dinero cambio" id="cambio" ng-model="cambioFacturaDinero.cambio">Cambio<br><span class="total"> $ {{cambioFacturaDinero.cambio | number:0}}</span></th>
							</tr>
							<tr >
								<!-- <th colspan="8"></th> -->
								<th class=" dinero cambio">Total  <br><span class="total">$ {{totalapagar | number:0}}</span></th>
							</tr>
							<tr ng-show="false" >
								
								<th class=" dinero cambio">ganacia  <br><span class="total">$ {{totalganacia | number:0}}</span></th>
							</tr>

						</thead>
					</table>
				</div>

				<div  ng-if="ContraDescuentro==1" class="col-md-10">
						<h4>Para realizar el descuento debe ingresar la contraseña</h4>
							<label for="">Contraseña </label><input type="password" name="passCurioso" ng-keypress="validarContraDescuento(e,clave)" placeholder="Ingrese su contraseña" class="form-control input-sm"  ng-model="clave" id="conta">
							
		
				</div>
				<div class="card-footer" ng-if="ContraDescuentroBotonFacturar==1">
					<button type="button" class="btn btn-primary" ng-click="guardarFacturaPress(insertClientes,cambioFacturaDinero)">
					<i class="material-icons">play_for_work</i> Facturar
					</button>
					
				</div>
			</div>
		</div>
	</div>
	

	
	
	
	<!-- 		<div class="col-md-4">
		<button type="button" class="btn btn-info btn-md" ng-click="guardarCotizacion(insertClientes)">
		<span class="icon-doc"></span> Cotizacion
		</button>
	</div> -->
	<div class="col-md-12"><button type="button" class="btn btn-success btn-sm" ng-click="showFrom()"><span class="icon-floppy"></span> Agregar Clientes</button></div>
	<div class="row">
		<div ng-show="fromVisibility" class="col-md-4">
			<div class="card">
				<div class="card-header card-header-icon card-header-info">
					<div class="card-icon">
						<i class="material-icons">perm_contact_calendar</i>
					</div>
					<h4 class="card-title">Agregar Cliente</h4>
				</div>
				<div class="card-body">
					<form id="guardarcliente" name="guardarcliente">
						<div class="col-md-12">
							<div class="form-group bmd-form-group">
								<label class="bmd-label-floating">Cedula</label>
								<input type="number" placeholder="C.c" class="form-control"  ng-model="insertarCliente.ccCliente" name="ccCliente">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group bmd-form-group">
								<label class="bmd-label-floating">Nombre</label>
								<input type="text" placeholder="Nombre" class="form-control input-sm"  ng-model="insertarCliente.nombreCliente" name="nombreCliente">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group bmd-form-group">
								<label class="bmd-label-floating">Direccion</label>
								<input type="text" placeholder="Direccion" class="form-control input-sm"  ng-model="insertarCliente.direccionCliente" name="direccionCliente">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group bmd-form-group">
								<label class="bmd-label-floating">Telefono</label>
								<input type="text" placeholder="Telefono" class="form-control input-sm"  ng-model="insertarCliente.telefonoCliente" name="telefonoCliente">
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer">
					<div class="col-md-12">
						<button type="button" class="btn btn-info btn-sm" ng-click="guardarCliente(insertarCliente)">Guardar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">account_box</i>
					</div>
					<h3 class="card-title">Cliente</h3>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<input type="hidden" name="id_cliente" id="id_cliente" ng-model="insertClientes.id_cliente">
						<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="insertClientes.identificacion" disabled>
						
					</div>
					<div class="col-md-12">
						<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="insertClientes.nombre_clientes" disabled>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_clientes_Factura"><span class="icon-file-pdf"></span>Add Cliente</button>
				</div>
			</div>
			
		</div>
		
		<div class="col-md-8">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon"><i class="material-icons">receipt</i></div>
					<h4 class="card-title">Ultima Factura</h4>
				</div>
				
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Codigo Factura</th>
								<th>Nombres</th>
								<th>Fecha</th>
								<th colspan="2">Operaciones</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="listado in filterultimaFacturaDatos = (ultimaFacturaDatos)|  limitTo:25:25*(pageultimaFacturaDatos-1)">
								
								<td>{{listado.codigo_factura}}</td>
								<!-- <td>{{listado.cc_cliente}}</td> -->
								<td>{{listado.nombre_cliente}}</td>
								<td>{{listado.fecha_factura}}</td>
								<td>
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalleUltimaFactura" ng-click="verdetalleFacturaSelect(listado.id_factura)"><span class="icon-file-pdf"></span>Detalle</button>
								</td>
								<td>
									<button type="button" class="btn btn-success btn-sm"  ng-click="generarfactura(listado.id_factura)"><span class="icon-file-pdf"></span>Factura</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</form>


<!--modal agregar codigo de barras-->
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
							<input type="text" class="form-control" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProduct0">
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
										<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProduct0) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
											<td>{{listado.descripcion}}</td>
											<td>{{listado.codigo_producto}}</td>
											<td>
												<button type="button" class="btn btn-info btn-sm"  ng-click="addBarraProductoActualizar(listado.id_producto,barraView)">Agregar</button>
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


<!--Fin modal de codigo de barras-->



<div id="modal-vistafactudetalleUltimaFactura" class="modal fade" role="dialog">
	<div class="modal-dialog ta_modal">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Detalles factura</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h4>Datos Usuario</h4>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Codigo Factura</th>
										<th>Fecha Factura</th>
										<th>Cc Cliente</th>
										<th>Nombre Cliente</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{var_codigo_factura}}</td>
										<td>{{var_fecha_factura}}</td>
										<td>{{var_cc_cliente}}</td>
										<td>{{var_nombre_cliente}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						
					</div>
					
					<div class="col-md-12">
						<h4>Datos Factura</h4>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										
										<th>Codigo Producto</th>
										<th>Producto</th>
										<th>Precentación</th>
										<th>Cantidad</th>
										<th>Fraccion</th>
										<th>iva</th>
										<th>valor_venta</th>
										<th>Valor Pago</th>
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturas)">
										<td>{{listado.codigo_producto}}</td>
										<td>{{listado.descripcion}}</td>
										<td>{{listado.presentacion}}</td>
										<td>{{listado.cantidad}}</td>
										<td>{{listado.cantidadFraccion}}</td>
										<td>${{listado.ivaVal}}/({{listado.iva}}%)</td>
										<td>${{listado.valor_venta | number:0}}</td>
										<td>${{listado.total_pago | number:0}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<h4>Total a pagar: <span class="letra">${{var_valor_pago | number:0}}</span></h4>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ========================================================================================================================================= -->
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
					<div class="container-3">
						<span class="icon"><i class="material-icons">search</i></span>
						<input type="search" class="form-control input-sm" id="search" placeholder="Buscar..." name="id_producto"  ng-model="filtroClientesIngreso">
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
									<tr ng-repeat="listado in filterDatProducclientFactura = (listadodetodos_clientesFactu | filter : filtroClientesIngreso) | limitTo:20:20*(pagelistadodetodos_clientesFactu-1)">
										<td>{{listado.cc_cliente}}</td>
										<td>{{listado.nombre_cliente}}</td>
										<td>
											<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarClienteFactura(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,insertClientes)">Agregar</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
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
						<input type="number" class="form-control btn-sm"  name="cantidad_productoFactura" id="cantidad_productoFactura" ng-model="agregarInsertProduFactura.cantidad_productoFactura" ng-keypress='agregarProductoFactura(e,agregarInsertProduFactura)'>
						
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
<!-- Ininio ver agregar nuevos producto y cantidad -->
<div id="myModalSerial" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Agregar Serial</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="">
						<input type="text" class="form-control input-sm" placeholder="Buscar Producto..." name="id_producto" id="id_producto" ng-model="filtroSerial">
					</div>
					<div class="col-md-12">
						<div class="col-md-5">
							<label>Codigo Producto : </label><span>{{CodigoProductoSerial}}</span>
							
						</div>
						<div class="col-md-4">
							<label>Nombre : </label><span> {{nombreProductoSerial}}</span>
							
						</div>
						<div class="col-md-3">
							<label>Valor   : </label><span> {{valorVentaProductoSerial}}</span>
							
						</div>
						<!-- <div class="col-md-4"> -->
						<!-- <label>Periodo  : </label><span> {{year}} - {{periodo}} </span> -->
						
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Serial</th>
										
										<th>Escoger</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listadoSerial in filterDat = (listadodetodos_ProductoSeriales | filter : filtroSerial) | limitTo:20:20*(pagelistadodetodos_ProductoSeriales-1)">
										<td>{{listadoSerial.serial}}</td>
										<<!-- td>{{listadoSerial.nombre_cliente}}</td> -->
										<td>
											<button type="button" class="btn btn-info btn-sm"  ng-click="agregarSerialFactura(listadoSerial.id_productoserial,id_ProductoSerial,nombreProductoSerial,listadoSerial.serial)">Agregar</button>
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
<!-- fin ver agregar nuevos producto y cantidad -->
<!-- Ininio ventana modal de productos -->
<div id="modal-productoFactura" class="modal fade" role="dialog">
	<div class="modal-dialog ta_modal">
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
						<uib-pagination class="pagination-mod" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
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
<uib-tab index="1">
<uib-tab-heading>
<i class="material-icons">
format_list_bulleted
</i>
Lista de Facturas
</uib-tab-heading>

<div class="row">
	
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Codigo Factura</h4>
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="number" class="form-control" name="codigoFactura" id="codigoFactura" ng-model="busquedadFactura" ng-keypress="FacturaxCodigo(e,busquedadFactura)">
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
				<div class="form-group">
					<input type="date" class="form-control" name="fechaInicialFactura" id="fechaInicialFactura" ng-model="agregarbusquedaFacturaXf.fechaInicialFactura">
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
					<input type="date" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="agregarbusquedaFacturaXf.fechaFinalFactura">
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="col-md-6">
	<button type="button" class="btn btn-info btn-sm" ng-click="buscarfacturaXfecha(agregarbusquedaFacturaXf)"><i class="material-icons"> search</i>Buscar</button>
</div>
<div class="col-md-12">
	<uib-pagination class="pagination-mod" total-items="filterfacturXfechaRango.length" ng-model="pagelistadofacturasXfechasDos" ng-change="paginalistadofacturasXfechasDos()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=100></uib-pagination>
</div>
<!-- <div class="col-md-12">
	<button type="button" class="btn btn-info" ng-click="generar_reportePDFfacturaXfecha(agregarbusquedaFacturaXf)">Generar Reporte</button>
</div> -->
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					
					<th>Codigo Factura</th>
					<th>Identificacion</th>
					<th>Nombres</th>
					<th>Fecha</th>
					<th colspan="3" ><div align="center">Operaciones</div></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="listado in filterfacturXfechaRango = (listadofacturasXfechasDos | filter : filtroProductoIngreso)|  limitTo:100:100*(pagelistadofacturasXfechasDos-1)">
					
					<td>{{listado.codigo_factura}}</td>
					<td>{{listado.cc_cliente}}</td>
					<td>{{listado.nombre_cliente}}</td>
					<td>{{listado.fecha_factura}}</td>
					<td>
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalle" ng-click="verdetalleFacturaSelect(listado.id_factura)"><span class="icon-file-pdf"></span>Ver Detalle</button>
					</td>
					<td>
						<button type="button" class="btn btn-success btn-sm"  ng-click="generarfactura(listado.id_factura)"><span class="icon-file-pdf"></span>Genera Factura</button>
					</td>
					<td>
						<button type="button" class="btn btn-warning btn-sm"   data-toggle="modal" data-target="#myModaDevolucion" ng-click="DevolucionTotal(listado.id_factura,listado.codigo_factura,listado.cc_cliente,listado.nombre_cliente,listado.fecha_factura)"><span class="icon-file-pdf"></span>Devolución</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!-- Ininio ventana de confimacion de eliminacion del ingreso -->
<div id="modal-vistafactudetalle" class="modal fade" role="dialog">
	<div class="modal-dialog ta_modal">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Detalles factura</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h4>Datos Usuario</h4>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Codigo Factura</th>
										<th>Fecha Factura</th>
										<th>Cc Cliente</th>
										<th>Nombre Cliente</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{var_codigo_factura}}</td>
										<td>{{var_fecha_factura}}</td>
										<td>{{var_cc_cliente}}</td>
										<td>{{var_nombre_cliente}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						
					</div>
					
					<div class="col-md-12">
						<h4>Datos Factura</h4>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										
										<th>Codigo Producto</th>
										<th>Nombres Producto</th>
										<th>Categoria</th>
										<th>Cantidad</th>
										<th>Fraccion</th>
										<!-- <th>Fraccion</th> -->
										<th>Valor Pago</th>
										<th>Opciones</th>
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturas)">
										
										<td>{{listado.codigo_producto}}</td>
										<td>{{listado.descripcion}}</td>
										<td>{{listado.nombre_categoria}}</td>
										<td>{{listado.cantidad}}</td>
										<td>{{listado.cantidadFraccion}}</td>
										<!-- <td>{{listado.valor_venta}}</td> -->
										<td>{{listado.total_pago}}</td>
										<td><button type="button" class="btn btn-warning btn-sm"  ng-click="SuccessDevolucionUnidad(listado.id_factura,listado.id_detalleFactura,var_codigo_factura)"><span class="icon-file-pdf"></span>Dev</button></td>
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<h4>Total a pagar: <span class="letra">{{var_valor_pago}}</span></h4>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- fin ventana de confimacion de eliminacion del ingreso -->
<div id="myModaDevolucion" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Devoluciones</h2>
			</div>
			<div class="modal-body">
				
				<div class="row">
					
					
					<div class="col-md-12">
						<h2 align="center">Factura : {{codigo_facturaD}} </h2>
						<h4  align="center">Realmente Desea Devolver Todos los Productos Adquiridos por esta Factura con fecha de  <strong>{{fecha_facturaD}} </strong> por el cliente <strong>{{nombre_clienteD}} </strong> con cedular<strong> {{cc_clienteD}} </strong></h4>
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-sm"  ng-click="SuccessDevolucionTotal(id_facturaD,codigo_facturaD)">Procesar</button>
				<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</uib-tab>
<!-- ---------------- TECER ITEMS -->
<uib-tab index="2" heading="Facturas por Clientes">
<uib-tab-heading>
<i class="material-icons">
contacts
</i>
Facturas Por Clientes
</uib-tab-heading>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-icon card-header-rose">
			<div class="card-icon">
				<i class="material-icons">account_box</i>
			</div>
			<h4 class="card-title">Cliente</h4>
		</div>
		<div class="card-body">
			<div class="col-md-6">
				<input type="hidden" name="id_cliente" id="id_cliente" ng-model="busquedaFactXcliente.id_cliente">
				<div class="input-group">
					<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="busquedaFactXcliente.identificacion" disabled>
					<span class="input-group-btn">
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_clientes_BudquedasFactDetalle"> <i class="material-icons">search</i> Buscar</button>
						</i>
					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="busquedaFactXcliente.nombre_clientes" disabled>
				</div>
			</div>
			<div class="card-footer">
				<div class="col-md-4">
					<button type="button" class="btn btn-primary btn-sm" ng-click="buscarfacturaXclienteseleccionado(busquedaFactXcliente.id_cliente)"><i class="material-icons">search</i>Buscar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<uib-pagination class="pagination-mod" total-items="filterfacturXfechaRango.length" ng-model="pagelistadofacturasXclienteSelect" ng-change="paginalistadofacturasXclienteSelect()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=25></uib-pagination>
	</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						
						<th>Codigo Factura</th>
						<th>Identificacion</th>
						<th>Nombres</th>
						<th>Fecha</th>
						<th colspan="3">Operaciones</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="listado in filterfacturXfechaRango = (listadofacturasXclienteSelect | filter : filtroProductoIngreso)|  limitTo:25:25*(pagelistadofacturasXclienteSelect-1)">
						
						<td>{{listado.codigo_factura}}</td>
						<td>{{listado.cc_cliente}}</td>
						<td>{{listado.nombre_cliente}}</td>
						<td>{{listado.fecha_factura}}</td>
						<td>
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalleClientes" ng-click="verdetalleFacturaSelect(listado.id_factura)">Ver Detalle</button>
						</td>
						<td>
							<button type="button" class="btn btn-success btn-sm"  ng-click="generarfactura(listado.id_factura)"><span class="icon-file-pdf"></span>Genera Factura</button>
						</td>
						<td>
							<button type="button" class="btn btn-warning btn-sm"   data-toggle="modal" data-target="#myModaDevolucionCliente" ng-click="DevolucionTotal(listado.id_factura,listado.codigo_factura,listado.cc_cliente,listado.nombre_cliente,listado.fecha_factura)"><span class="icon-file-pdf"></span>Devolución</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- Ininio ventana de confimacion de eliminacion del ingreso -->
	<div id="modal-vistafactudetalleClientes" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="tt_modal">Detalles Factura</h2>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Codigo Factura</th>
											<th>Fecha Factura</th>
											<th>Cc Cliente</th>
											<th>Nombre</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{var_codigo_factura}}</td>
											<td>{{var_fecha_factura}}</td>
											<td>{{var_cc_cliente}}</td>
											<td>{{var_nombre_cliente}}</td>
										</tr>
									</tbody>
								</table>
							</div>
							
							
						</div>
						
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											
											<th>codigo producto</th>
											<th>Nombres producto</th>
											<th>categoria</th>
											<th>cantidad</th>
											<th>cantidad</th>
											<th>valor pago</th>
											<th>Dev</th>
											
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturas)">
											
											<td>{{listado.codigo_producto}}</td>
											<td>{{listado.nombre}}</td>
											<td>{{listado.nombre_categoria}}</td>
											<td>{{listado.cantidad}}</td>
											<td>{{listado.valor_venta}}</td>
											<td>{{listado.total_pago}}</td>
											<td><button type="button" class="btn btn-warning btn-sm"  ng-click="SuccessDevolucionUnidad(listado.id_factura,listado.id_detalleFactura,var_codigo_factura)"><span class="icon-file-pdf"></span>Dev</button></td>
											
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-12">
							<h4>Total a pagar :<span class="letra">{{var_valor_pago}}</span></h4>
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- fin ventana de confimacion de eliminacion del ingreso -->
	<!-- Inicio ventana modal de clientes -->
	<div id="modal_clientes_BudquedasFactDetalle" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="tt_modal">Clientes</h2>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<input type="text" class="form-control input-sm" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
						</div>
						<div class="col-md-12">
							<uib-pagination class="pagination-mod" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
						</div>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
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
												<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarclienteBusqueDetalleFactu(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,busquedaFactXcliente)">Agregar</button>
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
	<div id="myModaDevolucionCliente" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Devoluciones</h2>
			</div>
			<div class="modal-body">
				
				<div class="row">
					
					
					<div class="col-md-12">
						<h2 align="center">Factura : {{codigo_facturaD}} </h2>
						<h4  align="center">Realmente Desea Devolver Todos los Productos Adquiridos por esta Factura con fecha de  <strong>{{fecha_facturaD}} </strong> por el cliente <strong>{{nombre_clienteD}} </strong> con cedular<strong> {{cc_clienteD}} </strong></h4>
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-sm"  ng-click="SuccessDevolucionTotal(id_facturaD,codigo_facturaD)">Procesar</button>
				<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
	<!-- fin ventana modal de clientes -->
	</uib-tab>
	<!-- <uib-tab index="3">
	<uib-tab-heading>
	<i class="material-icons">format_list_bulleted</i>
	informe de venta
	</uib-tab-heading>
	<div class="row">

		<div class="col-md-6" >
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon" data-toggle="modal" data-target="#myModaInformeFecha">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Ventas del Dia  {{fechaActual}}</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" style="height: 300px">
							<thead>
								<tr>
									<th></th>
									<!-- <th>Codigo</th> 
									<th>Nombre</th>
									<th>Unidad</th>
									<th>Fracción</th>
									<th>Valor </th>
									
									
									
								</tr>
							</thead>
							<tbody class="tbl-normal">
								<tr ng-repeat="listadodelDia in filterdelDia = (delDia)">
									<td></td>
									<!-- <td>{{listadodelDia.codigo_factura}}</td> 
									<td>{{listadodelDia.descripcion}}</td>
									<td>{{listadodelDia.cantidad}}</td>
									<td>{{listadodelDia.cantidadFraccion}}</td>
									<td>${{listadodelDia.TotalPago | number:0}}</td>
									
									
									
								</tr>
								
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-md-6" >
		<div class="col-md-12" >
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					
					<h4 class="card-title" ng-repeat="listadodelDia in filterdelDia = (delDia)" ng-if="listadodelDia.codigo_factura==CodfacMax">{{listadodelDia.descripcion}} {{listadodelDia.cantidad}} {{listadodelDia.cantidadFraccion}} ${{listadodelDia.TotalPago | number:0}}</h4>
				</div>
				<div class="card-body">
				</div>
			</div>
		</div>
		<div class="col-md-12" >
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					
					<h4 class="card-title" ng-repeat="listadodelDia in filterdelDia = (delDia)" ng-if="listadodelDia.codigo_factura==CodfacMin">{{listadodelDia.descripcion}} {{listadodelDia.cantidad}} {{listadodelDia.cantidadFraccion}} ${{listadodelDia.TotalPago | number:0}}</h4>
				</div>
				<div class="card-body">
				</div>
			</div>
		</div>
		<div class="col-md-12">
						<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">timeline</i>
				</div>
				<h3 class="card-title"> </h3>
			</div>
			<div class="card-body">
					<canvas
					class="chart chart-pie"
					chart-data="datos2Mx"
					chart-labels="etiquetas2Mx">
						
					</canvas>
				</div>
			</div>
				</div>
</div>

<div class="col-md-3">
		<div class="card datos-v-s">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{Vtotaltotal  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Ventas</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{Vganancia  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Ganancias</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card datos-venta-u">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">$ {{Vtotaltotal - Vganancia  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Capital</h4>
			</div>
		</div>
	</div>

	<div id="myModaInformeFecha" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Ingrese Fechas</h2>
			</div>
			<div class="modal-body">
				
				<div class="row">
					<div class="form-group">
					<input type="date" placeholder="Fecha Inicio" class="form-control"  ng-model="insertInformeVenta.fecha_inicio" name="fecha_inicio">
					<div class="form-group">
					<input type="date" placeholder="Fecha Inicio" class="form-control"  ng-model="insertInformeVenta.fecha_final" name="fecha_final">
				</div>
				</div>
					
					
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-sm"  ng-click="informeVenta(insertInformeVenta)">Procesar</button>
				<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
	</div>
</uib-tab>
	<uib-tab index="4">
	<uib-tab-heading>
	<i class="material-icons">format_list_bulleted</i>
	Listado Por Periodo
	</uib-tab-heading>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">receipt</i>
					</div>
					<h3 class="card-title">Reportes Por Cajas</h3>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Seleccione Caja </label>
							<select name="idSistemaU" class="form-control input-sm" ng-model="listadoGeneral.idSistemaU">
								<option value=""></option>
								<option ng-repeat="listadoCateoria in listadodetodos_Caja" value="
								{{listadoCateoria.id_usuariosistema}}">{{listadoCateoria.nombre_usuario}}</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<label for="">Fecha inicial</label>
						<input type="text" class="form-control" name="fechaInicialFactura" id="fechaInicialFactura" ng-model="listadoGeneral.fechaInicialFactura">
					</div>
					<div class="col-md-12 col-espacio">
						<label for="">Fecha final</label>
						<input type="text" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="listadoGeneral.fechaFinalFactura">
					</div>
					<div class="col-md-12 col-espacio">
						<label>Detalle de venta (Producto y valor):
							<input type="checkbox" ng-model="checkboxModel.value1">
						</label>
					</div>
					<div class="col-md-6">
						
						<button type="button" class="btn btn-info btn-sm" ng-click="buscarfacturaXfechaGeneral(listadoGeneral.idSistemaU,listadoGeneral)"><span class="icon-search"></span>Buscar</button>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">add_box</i>
					</div>
					<h3 class="card-title">Ventas del Día</h3>
				</div>
				<div class="card-body">
					<button type="button" class="btn btn-info btn-lg" ng-click="buscarfacturaXfechaHoy(listadoGeneral.idSistemaU,checkboxModel.value1)"><span class="icon-search"></span>Hoy</button>
				</div>
			</div>
		</div>
	</div>
	</uib-tab> -->
	</uib-tabset>
	<!-- </div> -->
	<script>
	$(document).ready(function(){
	// initialise Datetimepicker and Sliders
	md.initFormExtendedDatetimepickers();
	if($('.slider').length != 0){
	md.initSliders();
	}
	});
	</script>