<div class="panel panel-body">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="icon-home"></em>
			</a></li>
			<li class="active">Proyecto</li>
		</ol>
	</div>
	<h2>Proyecto</h2>
	<uib-tabset active="active">
	<uib-tab index="0" heading="Creacion de Productos">
	<form id="guardarProyecto" name="guardarProyecto">

		<div class="row  col-md-3">
		<div class="row ">
			
		
		
</div>
<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="">Nombre Del Proyecto</label>
				<input type="text" class="form-control input-sm" placeholder="Nombre  Proyecto"   ng-model="insertarProyecto.nombreProyecto" name="nombreProyecto">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="">Seleccione</label>
				<select name="idCliente" class="form-control input-sm" ng-model="insertarProyecto.idCliente">
					<option ng-repeat="listadoC in listadodetodos_clientesFactu" value="
					{{listadoC.id_cliente}}">{{listadoC.nombre_cliente}}</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="">Mano de Obra</label>
				<input type="number" class="form-control input-sm" placeholder="Valor de la Mano de Obra"   ng-model="insertarProyecto.manoObra" name="manoObra">
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-info  btn-sm" ng-click="guardarProyectoDos(insertarProyecto)">Guardar</button>
		</div>
	</div>
	</div>

</form>
	<div class="col-md-9">
		<div class="">
			      		<input type="text" class="form-control input-sm" placeholder="Buscar Cliente..." name="id_producto" id="id_producto" ng-model="filtroProyecto">
			      	</div>
	<div class="col-md-12">
				<uib-pagination class="pagination-sm pagination" total-items="filterProducto.length" ng-model="pagelistadodetodos_Proyecto" ng-change="paginalistadodetodos_Proyecto()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
			</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Nombre Proyecto</th>
						<th>Nombre Cliente</th>
						<th>Valor Mano de Obra</th>
						<th>Fecha Creacion</th>
						<th>Estado</th>
						<!-- <th>descripcion</th> -->
						
						
						
						<th colspan="3">Operaciones</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="listadoProyecto in filterProyecto = (listadodetodos_Proyecto | filter : filtroProyecto) | limitTo:10:10*(pagelistadodetodos_Proyecto-1)">
						<td>{{listadoProyecto.nombre}}</td>
						<td>{{listadoProyecto.nombre_cliente}}</td>
						<td>{{listadoProyecto.manoObra | currency}}</td>
						<td>{{listadoProyecto.fecha}}</td>
						<td>{{listadoProyecto.estado}}</td>
						
						
						<td>
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalActualizarProducto" ng-click="CambiarEstadoProyecto(listadoProyecto.id_proyecto,listadoProyecto.id_cliente,listadoProyecto.nombre,listadoProyecto.nombre_cliente,listadoProyecto.manoObra,listadoProyecto.fecha,listadoProyecto.estado,actualizarEstado)"><span class="icon-pencil"></span>Cambiar</button>
						</td>

						<td>
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ModalVerProyecto" ng-click="verProyecto(listadoProyecto.id_proyecto,listadoProyecto.id_cliente,listadoProyecto.nombre,listadoProyecto.nombre_cliente,listadoProyecto.manoObra,listadoProyecto.fecha,listadoProyecto.estado)"><span class="icon-pencil"></span>Productos</button>
						</td><td>
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalleProyectoDOs"  ng-click="verdetalleFacturaProyectoSelec(listadoProyecto.id_proyecto)" ><span class="icon-trash"></span>Ver</button>
					</td>
					<td>
						<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEgresosProductos"  ng-click="verdetalleegresoProyecto(listadoProyecto.id_proyecto)" ><span class="icon-trash"></span>Egreso</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
	</div>
	<hr>
	
<!-- MODAL PARA ACTUALIZAR CAtegoria -->
<div class="modal" id="ModalVerProyecto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Proyecto</h2>
			</div>
			<!-- cuerpo del <mod</mod>al -->
			<div class="modal-body">
				<div class="row">
					 <div class="col-md-12">
 	
 		
 	
			      	<div class="">
			      		<input type="text" class="form-control input-sm" placeholder="Buscar Producto..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
			      	</div>
			      	<div class="">
						<uib-pagination class="pagination-sm pagination" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=5></uib-pagination>
					</div>
			      	<div >
			      		
				      	<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre Producto</th>
										<th>nombre_categoria</th>
										<th>codigo</th>
										<th>Cantidad</th>
										<th>Agregar</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:5:5*(pagelistadodeProductos_Ingreso-1)">
										<td>{{listado.nombre}}</td>
										<td>{{listado.nombre_categoria}}</td>
										<td>{{listado.codigo_producto}}</td>
										<td>
											<div class="col-sm-8">
												
											
											<input type="number" name="cantidad" class=" form-control input-sm" value="1" ng-model="cant.cantidad">
											</div>
										</td>
										<td>
											<button type="button" class="btn btn-info btn-sm"  ng-click="agregarProductoFactura(listado.id_producto,listado.nombre,listado.codigo_producto,listado.valor_venta,cant)">
											<span class="icon-cart-plus"></span>Agregar</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-12">
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
								<tr ng-repeat="listado in filterproducDetalles = (listaProductosDetalleFactura)">
									<td>{{listado.nombre}}</td>
									<td>{{listado.codigoProducto}}</td>
									<td>{{listado.cantidad}}</td>
									<td>{{listado.valor_venta}}</td>
									<td>{{listado.valorTotal}}</td>
									<td>
										<button type="button" class="btn btn-danger" ng-click="eliminarProductoProFacturar(listado.id_producto,listado.valorTotal)"><span class="icon-trash"></span> Eliminar</button>
									</td>
									
									
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<th>Total a Pagar</th>
									<th>{{totalapagar}}</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

						


				<div class="col-md-4 espacio">
					<button type="button" class="btn btn-info btn-md"  data-dismiss="modal" ng-click="guardarFacturaProyecto(id_Proyecto,id_cliente)">
						<span class="icon-doc"></span> Guardar
					</button>
					
				</div>
				
			</form>
				</div>
			</div>
		</div>
	</div>
</div>	
<!-- MODAL PARA ACTUALIZAR CAtegoria -->
<div class="modal" id="ModalActualizarProducto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Estado del Proyecto</h2>
			</div>
			<!-- cuerpo del <mod</mod>al -->
			<div class="modal-body">
				<div class="row">
					<form>
						
						<input type="hidden"  value={{id_proyectoE}} name="id_proyectoE" placeholder="id" class="form-control" required disabled="disabled">
						
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Nombre del Proyecto</label>
								<input type="text" class="form-control input-sm" value={{nombreE}} disabled >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Nombre Del Cliente</label>
								<input type="text" class="form-control input-sm" value={{nombre_clienteE}} disabled>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Valor Mano de Obra</label>
								<input type="text" class="form-control input-sm" value={{manoObraE}} disabled >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Fecha Creacion</label>
								<input type="number" class="form-control input-sm" value={{fechaE}} disabled>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Estado</label>
								<input type="number" class="form-control input-sm" value={{estadoE}} disabled >
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Seleccione Estado</label>
								<select name="estadoNuevo" class="form-control input-sm" ng-model="actualizarEstado.estadoNuevo">
									<option ></option>
									<option value="TERMINADO">TERMINADO</option>
									<option value="EN PROCESO" >EN PROCESO</option>
								</select>
							</div>
						</div>
					</form>
					
					<div class="col-md-12">
						<button type="button" class="btn btn-info btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="Actualizar_Estado(id_proyectoE,actualizarEstado)" data-dismiss="modal">
						Actualizar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- fin ventana modal de clientes -->
<!-- MODAL PARA CONFIRMAR ELIMINAR  -->
<div class="modal" id="modal-eliminarProducto">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			<div class="row">
				
				<div class="col-md-12">
					<h3 class="tt_modal">
					<input type="hidden"  name="idEliminarProducto" ng-model="idEliminarProducto">
					¿Realmente desea eliminar Producto <b>{{nombre}} {{codigo}}</b>?
					</h3>
					
				</div>
				<div class="col-md-12 col-md-offset-3">
					<div class="col-md-2">
						<button class="btn btn-danger btn-sm" ng-click="EliminarProducto(idEliminarProducto)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
					</div>
					<div class="col-md-offset-1 col-md-2">
						<button class="btn btn-info btn-sm" aria-hidden="true" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!-- FINAL DEL MODAL PARA CONFIRMAR PAR ELIMINAR CATEGORIA -->
</uib-tab>
</uib-tabset>
</div>
		<!-- Ininio ventana de confimacion de eliminacion del ingreso -->
			<div id="modal-vistafactudetalleProyectoDOs" class="modal" role="dialog">
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
			      						<td>{{var_codigo_facturaP}}</td>
			      						<td>{{var_fecha_facturaP}}</td>
			      						<td>{{var_cc_clienteP}}</td>
			      						<td>{{var_nombre_clienteP}}</td>
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
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturasProyecto)">
										
										<td>{{listado.codigo_producto}}</td>
										<td>{{listado.nombre}}</td>
										<td>{{listado.nombre_categoria}}</td>
										<td>{{listado.cantidad}}</td>
										<td>{{listado.valor_venta}}</td>
										<td>{{listado.total_pago}}</td>
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
			      	<h4>Total a pagar :<span class="letra">{{var_valor_pagoP}}</span></h4>
			      				
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
			<div id="modal_clientes_BudquedasFactDetalle" class="modal" role="dialog">
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
						<uib-pagination class="pagination-sm pagination" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
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
			<!-- fin ventana modal de clientes -->

			<!-- Inicio ventana modal de clientes -->
			<div id="modalEgresosProductos" class="modal " role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h2 class="tt_modal">Egresos</h2>
			      </div>
			      <div class="modal-body">
			      	<div class="row">
			      <form id="guardarEgresoProyecto" name="guardarEgresoProyecto">
		
		<div class="col-md-offset-2">
			
		
		<div class="col-md-6 ">
			<div class="form-group">
				<label for="">Pagado a: </label>
				<input type="text" placeholder="Nombre de quien recive" class="form-control input-sm"  ng-model="insertarEgresoProyecto.pagadoProyecto" name="pagadoProyecto">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="">Valor</label>
				<input type="number" placeholder="Ingrese Valor Egreso" class="form-control input-sm"  ng-model="insertarEgresoProyecto.valorEgresoProyecto" name="valorEgresoProyecto">
			</div>
		</div>

		
		
		
		
		</div>
		<div class="col-md-offset-4">
		
		
		<div class="col-md-12">
			<button type="button" class="btn btn-info btn-sm" ng-click="guardarEgresoProyectoDos(insertarEgresoProyecto,id_Pro)">Guardar</button>
		</div>
		</div>
	</form>
	
<div class="col-md-12">
				<span><i>{{"Registros Encontrados"}}</i></span>
				<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
					{{listadodetodos_EProducto.length}}
				</span>
			</div>

			<div class="col-md-4 col-espacio">
				<label for="">Buscar</label>
				<input type="text" class="form-control" ng-model="filtroEgresosPRO">
			</div>
	
	<div class="col-md-12">
				<uib-pagination class="pagination-sm pagination" total-items="filtroEgresosPRO.length" ng-model="pagelistadodetodos_EProducto" ng-change="paginalistadodetodos_EProducto()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
			</div>
	<div class="col-md-10">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						
						<th>Nombre </th>
						<th>Valor</th>
						<th>Fecha</th>
						
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="listadoEgresosPRO in filterEPRO = (listadodetodos_EProducto | filter : filtroEgresosPRO) | limitTo:10:10*(pagelistadodetodos_EProducto-1)">
						<td>{{listadoEgresosPRO.pagado}}</td>
						
						<td>{{listadoEgresosPRO.valor}}</td>
						<td>{{listadoEgresosLista.fecha}}</td>
						
						
						<!-- <td>
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalActualizarCategoria" ng-click="verTipoEgreso(listadoEgresos.id_tipoEgreso,listadoEgresos.nombreTipo,listadoEgresos.codigo_egreso,actualizarEgreso)"><span class="icon-pencil"></span>Editar</button>
						</td> -->
						<!-- <td>
						<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminarEgreso" ng-click="confirmaEliminar_Egreso(listadoEgresos.id_tipoEgreso,listadoEgresos.nombreTipo,idEliminarEgreso)"><span class="icon-trash"></span>Eliminar</button>
					</td> --><!-- <td>
						<button type="button" class="btn btn-success btn-sm" ng-click="imprimir_Egreso(listadoEgresosLista.id_egreso)"><span class="icon-trash"></span>Imprimir recivo</button>
					</td>
				</tr> -->
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