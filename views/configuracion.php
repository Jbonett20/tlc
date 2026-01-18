<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">settings</i>Configuracion
</uib-tab-heading>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">add_box</i>
			</div>
			<h3 class="card-title">Empresas</h3>
		</div>
		<div class="card-body">
			<div class="row">
			<div class="col-md-7">
			<form id="guardarempresa" name="guardarempresa">
				<div class="row">
					<label for="" class="col-md-1 col-form-label"> <i class="material-icons">polymer</i></label>
					<div class="col-md-11">
						<div class="form-group col-md-8">
							<input type="text"  placeholder="Nit de la empresa" class="form-control input-sm" size="10" ng-model="insertarEmpresa.nitEmpresa" name="nitEmpresa">
						</div>
					</div>

				</div>
				<div class="row">
					<label for="" class="col-md-1 col-form-label"> <i class="material-icons">store</i></label>
					<div class="col-md-11">
						<div class="form-group col-md-8">
						<input type="text" placeholder="Nombre de la empresa" class="form-control input-sm" size="20" ng-model="insertarEmpresa.nombreEmpresa" name="nombreEmpresa">
					</div>
				</div>
				</div><div class="row">
					<label for="" class="col-md-1 col-form-label"> <i class="material-icons">subdirectory_arrow_right</i></label>
					<div class="col-md-11">
						<div class="form-group col-md-8">
						<input type="text" placeholder="Direccion de la empresa" class="form-control input-sm" size="20" ng-model="insertarEmpresa.direccionEmpresa" name="nombreEmpresa">
					</div>
					</div>
				</div>
				<div class="row">
					<label for="" class="col-md-1 col-form-label"> <i class="material-icons">phone</i></label>
					<div class="col-md-11">
						<div class="form-group col-md-8">
						<input type="text" placeholder="Telefono de la empresa" class="form-control input-sm" size="20" ng-model="insertarEmpresa.telefonoEmpresa" name="nombreEmpresa">
					</div>
					</div>
				</div>
			</form>
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm btn-todo" ng-click="guardarEmpresa(insertarEmpresa)">Guardar</button>
			</div>
		</div>
			
	<div class="col-md-5" ng-repeat="listado in filterDat = (listadodetodos_Empresa )">
		<div class="row">
			<div class="col-md-6">
		<div class="imgn">
			<img src="img/empresa1.png" alt="empresa" class="empresa">

		</div>
		</div>
		<div class="col-md-6">
		<div class="texto-e">
			<i class="material-icons">location_city</i>
			<p>{{listado.nombre_empresa}}</p>
			<i class="material-icons">settings_phone</i><p>{{listado.telefono}}</p>
			<i class="material-icons">place</i>
			<p>{{listado.direccion}}</p>
			<i class="material-icons">assignment_ind</i>
			<p>{{listado.nit_empresa}}</p>
		</div>	
		</div>
		</div>
		</div>	
		</div>
		</div>
		<div class="card-footer">
			
		</div>
	</div>
</div>

<!-- MODAL PARA ACTUALIZAR CAtegoria -->
<div class="modal" id="ModalActualizarEmpresa">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h2 class="tt_modal">Actualizar Empresa</h2>
		</div>
		<!-- cuerpo del modal -->
		<div class="modal-body">
			<div class="row">
				<form>
					<div class="row">
						
						<input type="hidden" ng-model="actualizarEmpresa.id_empresaActualizar" name="id_empresaActualizar" placeholder="id" class="form-control" required>

						<div class="col-md-11">	
							<input type="text" name="nitEmpresactualizar" id="nitEmpresactualizar" ng-model="actualizarEmpresa.nitEmpresactualizar" placeholder="nit de la empresa" class="form-control" required="">
						</div>
						<div class="col-md-11">
							<input type="text" name="nombreEmpresaActualizar" id="nombreEmpresaActualizar" ng-model="actualizarEmpresa.nombreEmpresaActualizar" placeholder="Nombre de la Empresa" class="form-control" required="">
						</div>
						<div class="col-md-12">
							<button type="button" class="btn btn-info btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="Actualizar_Empresa(actualizarEmpresa)" data-dismiss="modal">
							Actualizar
							</button>
						</div>
						
						
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
</div>
<!-- fin ventana modal de clientes -->
<!-- MODAL PARA CONFIRMAR ELIMINAR  -->
<div class="modal" id="modal-eliminarEmpresa">
<div class="modal-dialog">
	<div class="modal-content">
		
		<div class="modal-body">
			<div class="row">
				
				<div class="col-md-12">
					<h3 class="tt_modal">
					<input type="hidden" name="idEliminarEmpresa" ng-model="idEliminarEmpresa">
					¿Realmente desea eliminar la Empresa <b>{{nombre_empresa}} {{nit_empresa}}</b>?
					</h3>
					
				</div>
				<div class="col-md-12 col-md-offset-3">
					<div class="col-md-2">
						<button class="btn btn-danger btn-sm" ng-click="EliminarEmpresa(idEliminarEmpresa)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
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


<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">add_box</i>
			</div>
			<h3 class="card-title">Rango de Factura</h3>
		</div>
		<div class="card-body">
		

<!-- Example -->
<label for="ex3">Inicial</label>
<input type="text" id="ex3" class="form-control" ng-model="rangoFacturaInicial" ng-keypress="OperacionRangoFactura(e,rangoFacturaInicial,rangoFacturaFinal)">
<label for="ex4">Final</label>
<input type="text" id="ex4" class="form-control" ng-model="rangoFacturaFinal" ng-keypress="OperacionRangoFactura(e,rangoFacturaInicial,rangoFacturaFinal)">
			</div>
		</div>
	</div>
</uib-tab>

<uib-tab index="1">
<uib-tab-heading>
<i class="material-icons">settings</i>Usuarios & Contraseñas 
</uib-tab-heading>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">add_box</i>
			</div>
			<h3 class="card-title">Lista de Usuarios</h3>
		</div>
		<div class="card-body">
			<div class="row">
			<div class="col-md-12">
                                    <div class="table">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="t-completa">
                                                    <th>Ico</th>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Fecha Caducidad</th>
													<th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="listado in filterDatProducIngreso = (listaUser )">
                                                    <td><div class="card-avatar" align="center">
                                                <!-- <a href="#pablo"> -->
                                                <img class="imgCircule" src="{{listado.img}}">
                                                <!-- </a> -->
                                            </div> </td>
                                                    <td>{{listado.nombre_usuario}}</td>
                                                    <td ng-if="viewPassUser==true">********* <button class="btn btn-info btn-just-icon" ng-click="viewPasswordUser()"><i class="material-icons">visibility</i></button></td>
													<td ng-if="viewPassUser==false"><input type="text" placeholder="Nombre de la empresa" class="form-control input-sm" size="20" ng-model="listado.password" name="nombreEmpresa"><button class="btn btn-info btn-just-icon" ng-click="viewPasswordUser()"><i class="material-icons">visibility_off</i></button></td>
                                                    <td>{{listado.fecha_final}}</td>
                                                    <td><button class="btn btn-success btn-just-icon" tooltip-placement="bottom" uib-tooltip="Save"  ng-click="actualizarPassUser(listado.id_usuariosistema,listado.password)"><i class="material-icons">save</i></button></td>
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
