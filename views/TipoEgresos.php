<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">store</i>Egresos
</uib-tab-heading>
<form id="guardarEgreso" name="guardarEgreso">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Factura</h4>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Seleccione</label>
								<select name="idTipoEgreso" class="form-control input-sm" ng-model="insertarEgreso.idTipoEgreso">
									<option ng-repeat="listadoTipoEgreso in listadodetodos_Egresos" value="
									{{listadoTipoEgreso.id_tipoEgreso}}"> {{listadoTipoEgreso.codigo_egreso}} - {{listadoTipoEgreso.nombreTipo}}</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 col-form-label">Pagado a: </label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" placeholder="Nombre de quien recibe" class="form-control input-sm"  ng-model="insertarEgreso.pagado" name="pagado">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 col-form-label">Valor</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="number" placeholder="Ingrese Valor Egreso" class="form-control input-sm"  ng-model="insertarEgreso.valorEgreso" name="valorEgreso">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Mes</label>
								<select name="mes" ng-model="insertarEgreso.mes" class="form-control input-sm" >
									<option value=""></option>
									<option value="Enero">Enero</option>
									<option value="Febrero">Febrero</option>
									<option value="Marzo">Marzo</option>
									<option value="Abril">Abril</option>
									<option value="Mayo">Mayo</option>
									<option value="Junio">Junio</option>
									<option value="Julio">Julio</option>
									<option value="Agosto">Agosto</option>
									<option value="Septiembre">Septiembre</option>
									<option value="Octubre">Octubre</option>
									<option value="Noviembre">Noviembre</option>
									<option value="Diciembre">Diciembre</option>
									
								</select>
								
							</div>
						</div>
					</div>
					
					
				</div>
				<div class="card-footer">
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm" ng-click="guardarEgresoDos(insertarEgreso)">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">assignment</i>
			</div>
			<h4 class="card-title">Egresos</h4>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">{{"Registros Encontrados"}}</span>
				<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
					{{listadodetodos_Elista.length}}
				</span>
			</div>
			<div class="col-md-12">
				
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroEgresosLista" autofocus="autofocus">
				</div>
			</div>
			<div class="col-md-12">
				<uib-pagination class="pagination-mod" total-items="filterEgresosLista.length" ng-model="pagelistadodetodos_Elista" ng-change="paginalistadodetodos_Elista()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Codigo Egreso</th>
								<th>Nombre Egreso</th>
								<th>Valor</th>
								<th>Mes del Egreso</th>
								<th>Fecha Registrada</th>
								
								<th colspan="2">Operaciones</th>
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoEgresosLista in filterEgresosLista = (listadodetodos_Elista | filter : filtroEgresosLista) | limitTo:10:10*(pagelistadodetodos_Elista-1)">
								<td>{{listadoEgresosLista.codigo_egreso}}</td>
								<td>{{listadoEgresosLista.nombreTipo}}</td>
								<td>${{listadoEgresosLista.valor |  number:0}}</td>
								<td>{{listadoEgresosLista.mes}}</td>
								<td>{{listadoEgresosLista.fecha}}</td>
								
								<!-- <td>
																							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalActualizarCategoria" ng-click="verTipoEgreso(listadoEgresos.id_tipoEgreso,listadoEgresos.nombreTipo,listadoEgresos.codigo_egreso,actualizarEgreso)"><span class="icon-pencil"></span>Editar</button>
								</td> -->
								<!-- <td>
																						<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminarEgreso" ng-click="confirmaEliminar_Egreso(listadoEgresos.id_tipoEgreso,listadoEgresos.nombreTipo,idEliminarEgreso)"><span class="icon-trash"></span>Eliminar</button>
								</td> --><td>
								<button type="button" class="btn btn-success btn-sm" ng-click="imprimir_Egreso(listadoEgresosLista.id_egreso)"><span class="icon-trash"></span>Imprimir recibo</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</uib-tab>
<uib-tab index="1" heading="Lista Egresos">
<div class="card">
<div class="card-header card-header-rose card-header-icon">
	<div class="card-icon">
		<i class="material-icons">shopping_basket</i>
	</div>
	<h3 class="card-title">Crear Egresos</h3>
</div>
<div class="card-body">
	<form id="guardarTipoEgreso" name="guardarTipoEgreso">
		<div class="row">
			<label class="col-md-3 col-form-label">Codigo Egreso</label>
			<div class="col-md-9">
				<div class="form-group">
					<input type="text" class="form-control " placeholder="ingrese Codigo de Egreso" class="from-control input_linea" size="40" ng-model="insertarTipoEgreso.codigoEgreso" name="codigoEgreso">
				</div>
			</div>
		</div>
		<div class="row">
			<label class="col-md-3 col-form-label">Nombre Egreso</label>
			<div class="col-md-9">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="ingrese nombre del Egreso" class="from-control input_linea" size="40" ng-model="insertarTipoEgreso.nombreEgreso" name="nombreEgreso">
				</div>
			</div>
		</div>
		<div class="row">
			<label class="col-md-3 col-form-label">Concepto</label>
			<div class="col-md-9">
				<div class="form-group">
					<input type="text" placeholder="Ingrese Concepto" class="form-control"  ng-model="insertarTipoEgreso.concepto" name="concepto">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<button type="button" class="btn btn-primary btn-sm" ng-click="guardarTipoEgresoDos(insertarTipoEgreso)">Guardar</button>
			</div>
		</div>
	</form>
</div>
</div>
<div class="card">
<div class="card-header card-header-rose card-header-icon">
	<div class="card-icon">
		<i class="material-icons">send</i>
	</div>
	<h3 class="card-title">Lista De Egresos</h3>
</div>
<div class="card-body">
	<div class="col-md-12">
		<span><i>{{"Registros Encontrados"}}</i></span>
		<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
			{{listadodetodos_Egresos.length}}
		</span>
	</div>
	<div class="col-md-12">
		<div class="container-3">
			<span class="icon"><i class="material-icons">search</i></span>
			<input type="text" class="form-control" placeholder="Buscar..." id="search" name="id_producto" id="id_producto" ng-model="filtroEgresos">
		</div>
	</div>
	<div class="col-md-12">
		<uib-pagination class="pagination-mod" total-items="filterEgresos.length" ng-model="pagelistadodetodos_Egresos" ng-change="paginalistadodetodos_Egresos()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
	</div>
	<div class="col-md-10">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Codigo Egreso</th>
						<th>Nombre Egreso</th>
						
						<th colspan="2">Operaciones</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="listadoEgresos in filterEgresos = (listadodetodos_Egresos | filter : filtroEgresos) | limitTo:10:10*(pagelistadodetodos_Egresos-1)">
						<td>{{listadoEgresos.codigo_egreso}}</td>
						<td>{{listadoEgresos.nombreTipo}}</td>
						
						<!-- <td>
																					<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalActualizarCategoria" ng-click="verTipoEgreso(listadoEgresos.id_tipoEgreso,listadoEgresos.nombreTipo,listadoEgresos.codigo_egreso,actualizarEgreso)"><span class="icon-pencil"></span>Editar</button>
						</td> -->
						<td>
							<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminarEgreso" ng-click="confirmaEliminar_Egreso(listadoEgresos.id_tipoEgreso,listadoEgresos.nombreTipo,idEliminarEgreso)"><span class="icon-trash"></span>Eliminar</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
<!-- MODAL PARA CONFIRMAR ELIMINAR  -->
<div class="modal" id="modal-eliminarEgreso">
<div class="modal-dialog">
	<div class="modal-content">
		
		<div class="modal-body">
			<div class="row">
				
				<div class="col-md-12">
					<h3 class="tt_modal">
					<input type="hidden" name="idEliminarEgreso" ng-model="idEliminarEgreso">
					¿Realmente desea eliminar la categoria <b>{{nombre_Egreso}}</b>?
					</h3>
					
				</div>
				<div class="col-md-12 col-md-offset-3">
					<div class="col-md-2">
						<button type="button" class="btn btn-danger" ng-click="EliminarEgreso(idEliminarEgreso)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
					</div>
					<div class="col-md-offset-1 col-md-2">
						<button  type="button" class="btn btn-info" aria-hidden="true" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</uib-tab>
</uib-tabset>