<?php   session_start();
//$_SESSION['ejecutado'];
?>
<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">add_box</i>Devolucioes
</uib-tab-heading>
<div class="row">
<div class="card">
	<div class="card-header card-header-rose card-header-text">
		<!-- <div class="card-icon">
			<i class="material-icons">reply</i>
		</div> -->
		<div class="row head-buscador">
			<div class="col-md-6">
		
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtrolistaDevolucion" autofocus="autofocus">
		
			</div>
		</div>
		<div class="col-md-6 paginacion">
	<uib-pagination class="pagination-mod" total-items="filterdevolucioesL.length" ng-model="pagelistadodevoluciones" ng-change="paginalistadodevoluciones()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=25></uib-pagination>
</div>

	</div>
		<!-- <h4 class="card-title">Lista de Devoluciones</h4> -->
	</div>
	<div class="card-body card-b-l">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Codigo Factura</th>
								<th>Identificacion</th>
								<th>Nombres</th>
								<th>Fecha</th>
								<th>Hora</th>
								<th class="text-cen-table">Operaciones</th>
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listado in filterdevolucioesL = (listadodevoluciones | filter : filtrolistaDevolucion)|  limitTo:100:100*(pagelistadodevoluciones-1) | orderBy:'-'">
								
								<td>{{listado.codigo_factura}}</td>
								<td>{{listado.cc_cliente}}</td>
								<td>{{listado.nombre_cliente}}</td>
								
								<td>{{listado.fecha_factura}}</td>
								<td>{{listado.hora}}</td>
								<td class="text-cen-table">
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalle" ng-click="verdetalleDevolucionSelect(listado.id_devolucion)"><span class="icon-file-pdf"></span>Ver Detalle</button>
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
</uib-tab>
</uib-tabset>
<!-- Ininio ventana de confimacion de eliminacion del ingreso -->
<div id="modal-vistafactudetalle" class="modal " role="dialog">
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
								<tbody class="tbl-normal">
									<tr>
										<td>{{var_codigo_devolucion}}</td>
										<td>{{var_fecha_devolucion}}</td>
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
										
										<th>Caja Devoclucion</th>
										<th>Codigo</th>
										<th>Producto</th>
										<th>Categoria</th>
										<th>Cant/Frac</th>
										
										<!-- <th>Fraccion</th> -->
										<th>Valor Pago</th>
										<th>Hora</th>
										
										
									</tr>
								</thead>
								<tbody class="tbl-normal">
									<tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetalledevoluciones)">
										
										<td>{{listado.nombre_usuario}}</td>
										<td>{{listado.codigo_producto}}</td>
										<td>{{listado.descripcion}}</td>
										<td>{{listado.nombre_categoria}}</td>
										<td>{{listado.cantidad}} : {{listado.cantidadFraccion}}</td>
										
										<!-- <td>{{listado.valor_venta}}</td> -->
										<td>${{listado.total_pago | number:0}}</td>
										<td>{{listado.hora}}</td>
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<h4>Total a pagar: <span class="letra"><h3>${{var_valor_pago | number:0}}</span></h3></h4>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>