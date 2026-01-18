<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons"> person_add</i> Clientes
</uib-tab-heading>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">perm_identity</i>
			</div>
			<h3 class="card-title">Crear Cliente</h3>
		</div>
		<div class="card-body">
			
			<div class="form-group">
				<form id="guardarcliente" name="guardarcliente">
					<div class="row">
						<label class="col-md-1 col-form-label">Cedula</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="number"  class="form-control input-sm"  ng-model="insertarCliente.ccCliente" name="ccCliente">
							</div>
						</div>
					</div>
					<div class="row">
						<label  class="col-md-1 col-form-label">Nombre</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" class="form-control input-sm"  ng-model="insertarCliente.nombreCliente" name="nombreCliente">
							</div>
						</div>
					</div>
					<div class="row">
						<label  class="col-md-1 col-form-label">Direccion</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" class="form-control input-sm"  ng-model="insertarCliente.direccionCliente" name="direccionCliente">
							</div>
						</div>
					</div>
					<div class="row">
						<label  class="col-md-1 col-form-label">Telefono</label>
						<div class="col-md-9">
							<div class="form-group">
								<input type="text"  class="form-control input-sm"  ng-model="insertarCliente.telefonoCliente" name="telefonoCliente">
							</div>
						</div>
					</div>
				</form>
				
			</div>
		</div>
		<div class="card-footer">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm" ng-click="guardarCliente(insertarCliente)">Guardar</button>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="card">
		
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">perm_identity</i>
			</div>
			<h3 class="card-title">Lista De Clientes</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" id="search" placeholder="Buscar..." ng-model="filtroCliente">
				</div>
				
				
			</div>
			<div class="col-md-8">
				<uib-pagination class="pagination-mod" total-items="filterCliente.length" ng-model="pagelistadodetodos_Cliente" ng-change="paginalistadodetodos_Cliente()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
			</div>
			<div class="col-md-12">
				<span><i>{{"Registros Encontrados"}}</i></span>
				<p>{{listadodetodos_Cliente.length}}</p>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Cedula Cliente</th>
								<th>Nombre Cliente</th>
								<th>Direccion Cliente</th>
								<th>Telefono Cliente</th>
								
								<th colspan="2">Operaciones</th>
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoCliente in filterCliente = (listadodetodos_Cliente | filter : filtroCliente) | limitTo:10:10*(pagelistadodetodos_Cliente-1)">
								<td>{{listadoCliente.cc_cliente}}</td>
								<td>{{listadoCliente.nombre_cliente}}</td>
								<td>{{listadoCliente.direccion}}</td>
								<td>{{listadoCliente.telefono}}</td>
								
								<td>
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalActualizarCliente" ng-click="verCliente(listadoCliente.id_cliente,listadoCliente.cc_cliente,listadoCliente.nombre_cliente,listadoCliente.direccion,listadoCliente.telefono,actualizarCliente)"><span class="icon-pencil"></span>Editar</button>
								</td>
								<td>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminarCliente" ng-click="confirmaEliminar_Cliente(listadoCliente.id_cliente,listadoCliente.cc_cliente,listadoCliente.nombre_cliente)"><span class="icon-trash"></span>Eliminar</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- MODAL PARA ACTUALIZAR CAtegoria -->
<div class="modal" id="ModalActualizarCliente">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Actualizar Cliente</h2>
			</div>
			<!-- cuerpo del <mod</mod>al -->
			<div class="modal-body">
				
				<form>
					<div class="row">
						
						<input type="hidden" ng-model="actualizarCliente.id_clienteActualizar" name="id_clienteActualizar" placeholder="id" class="form-control input-sm" required disabled="disabled">
						
						<div class="col-md-12">
							<div class="form-group">
								<label class="bmd-label-floating">Cedula</label>
								<input type="text" name="ccClienteActualizar" id="ccClienteActualizar" ng-model="actualizarCliente.ccClienteActualizar" placeholder="Cedula" class="form-control input-sm" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="bmd-label-floating">Nombre</label>
								<input type="text" name="nombreClienteActualizar" id="nombreClienteActualizar" ng-model="actualizarCliente.nombreClienteActualizar" placeholder="Nombre del cliente" class="form-control input-sm" required="">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="bmd-label-floating">Direccion</label>
								<input type="text" name="direccionClienteActualizar" id="direccionClienteActualizar" ng-model="actualizarCliente.direccionClienteActualizar" placeholder="direccion del CLiente" class="form-control input-sm" required="">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="bmd-label-floating">Telefono</label>
								<input type="text" name="telefonoClienteActualizar" id="telefonoClienteActualizar" ng-model="actualizarCliente.telefonoClienteActualizar" placeholder="Telefono del cliente" class="form-control input-sm" required="">
							</div>
						</div>
						
						
						
						
						
					</div>
				</form>
				
				<div class="col-md-12">
					<div class="container-fluid">
						<button type="button" class="btn btn-info btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="Actualizar_Cliente(actualizarCliente)" data-dismiss="modal">
						Actualizar
						</button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- fin ventana modal de clientes -->
<!-- MODAL PARA CONFIRMAR ELIMINAR  -->
<div class="modal" id="modal-eliminarCliente">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-body">
				<div class="row">
					
					<div class="col-md-12">
						<h3 class="tt_modal">
						<input type="hidden" name="idEliminarCliente" ng-model="idEliminarCliente">
						¿Realmente desea eliminar cliente <b>{{cc_cliente}} {{nombre_cliente}}</b>?
						</h3>
						
					</div>


				</div>
				
				<div class="row">
							<button class="btn btn-danger btn-sm" ng-click="EliminarCliente(idEliminarCliente)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
							<button class="btn btn-info btn-sm" aria-hidden="true" data-dismiss="modal">Cancelar</button>
					
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
<