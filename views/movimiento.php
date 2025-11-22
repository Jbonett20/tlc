<?php   session_start();
//$_SESSION['ejecutado'];
?>
<!-- <div class="card"> -->
<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">add_box</i>Movimiento del Producto
</uib-tab-heading>
<!-- <form  id="Form_insertarIngresos">
				<input type="submit" data-toggle="modal" data-target="#myModalAddBarra" class="btn btn-info btn-sm"  value="Si!">
</form> -->
<div class="col-md-12">
	<div class="container-3">
		<span class="icon"><i class="material-icons">search</i></span>
		<input type="search" placeholder="Busqueda Barra..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" ng-model="filtroProductoIngreso"   ng-change="listadotodos_ProductoChange(filtroProductoIngreso)">
	</div>
</div>
<div class="col-md-4" ng-show="showVistaF.show">
	
	
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					
					<th>Nombre Producto</th>
					<th>Venta</th>
					<th>Unidad</th>
					
					<th ng-show="false">Barra</th>
					
					
					<th>Agregar</th>
				</tr>
			</thead>
			<tbody class="tbl-normal" >
				
				<tr ng-repeat="listado in filterDatProducIngreso = (listadodetodos_Producto | filter : filtroProductoIngreso) | limitTo:10:10*(pagelistadodeProductos_Ingreso-10)"  ng-class="{'ctr': listado.stockMinimo>=listado.Unidad}" >
					
					<td>{{listado.descripcion}} {{listado.presentacion}}</td>
					<td>{{listado.valor_venta}}</td>
					<td> {{listado.valor_unidad}}</td>
					<td ng-show="false">{{listadoProducto.codigo_barras}}</td>
					<!-- <td>{{listado.nombre_categoria}}</td>
					<td>{{listado.codigo_producto}}</td> -->
					
					
					<td>
						<button type="button" class="btn btn-info btn-sm btn-tabla"  ng-click="listaMovimiento(listado.id_producto,listado.descripcion,listado.presentacion)">
						<span class="icon-cart-plus"></span>Agregar</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">shopping_basket</i>
				</div>
				<h3 class="card-title">{{nombreProducto}} {{presentacionProducto}} </h3>
			</div>
			<div class="card-body">
				<div class="col-md-12">
					<div class="form-group">
						<label for="">Seleccione Operacion </label>
						<select name="idSistemaU" class="form-control input-sm" ng-model="filtroMov">
							<option value=""></option>
							<option ng-repeat="listadoE in etiquetas" value="
							{{listadoE}}">{{listadoE}}</option>
						</select>
					</div>
				</div>
				<div class="table-responsive tabla-scroll ">
					<table class="table  table-striped table-no-bordered table-hover dataTable dtr-inline">
						<thead >
							<tr>
								<!-- 	<th>Codigo</th> -->
								<th>Operacion.</th>
								<th>Cantidad U.</th>
								<th>Cantidad F.</th>
								<th>Referencia.</th>
								<th>Fecha.</th>
								
								
							</tr>
						</thead>
						<tbody>
							
							<tr ng-repeat="listadoM in filterMovimiento = (listadodetodos_movimiento |  filter :filtroMov)">
								<!-- <td data-toggle="modal" data-target="#myModalSerial" ng-click="AddSerialList(listado.id_producto,listado.codigo_,listado.nombre,listado.id_categoria,listado.descripcion,listado.valor,listado.valor_venta)" >{{listado.codigoProducto}}</td> -->
								<td>{{listadoM.operacion}}</td>
								<td>{{listadoM.cantidad}}</td>
								<td>{{listadoM.cantidadFraccion}}</td>
								<td>{{listadoM.codigoD}}</td>
								<td>{{listadoM.fecha}}</td>
								
							</tr>
							
							
						</tbody>
						
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div ng-controller="ventas" ng-if="nombreProducto!=''">
			<div class="row">
				<div class="col-md-12">
						<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">timeline</i>
				</div>
				<h3 class="card-title">{{nombreProducto}} {{presentacionProducto}} </h3>
			</div>
			<div class="card-body">
					<canvas
					class="chart chart-bar"
					chart-data="datos"
					chart-labels="etiquetas"
					chart-series="series">
						
					</canvas>
					</div>
				</div>

				</div>
				<div class="col-md-12">
						<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">timeline</i>
				</div>
				<h3 class="card-title">{{nombreProducto}} {{presentacionProducto}} </h3>
			</div>
			<div class="card-body">
					<canvas
					class="chart chart-pie"
					chart-data="datos2"
					chart-labels="etiquetas2">
						
					</canvas>
				</div>
			</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myModalAddBarra" class="modal" role="dialog">
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
												<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="listaMovimiento(listado.id_producto,listado.descripcion,listado.presentacion)">Agregar</button>
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
</div>
</uib-tab>
</uib-tabset>