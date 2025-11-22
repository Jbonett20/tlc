<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">store</i>Ingreso de Proveedores
</uib-tab-heading>
<div class="row">
	<div class="col-md-3">
		<form id="guardarProducto" name="guardarProducto">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">shopping_cart</i>
					</div>
					<h3 class="card-title">Proveedores</h3>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="bmd-label-floating">Codigo del Proveedor</label>
							<input type="number" class="form-control input-sm" placeholder="Codigo"   ng-model="insertarProveedor.CodigoProveedor" name="CodigoProveedor">
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Nombre Del Proveedor</label>
							<input type="text" class="form-control input-sm" placeholder="Nombre Del Proveedor"   ng-model="insertarProveedor.NombreProveedor" name="NombreProveedor">
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating"> Responsable </label>
							<input type="text" class="form-control input-sm" placeholder="Responsable"   ng-model="insertarProveedor.responsable" name="responsable">
						</div>
					</div>
					
					
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Direccion</label>
							<input type="text" class="form-control input-sm" placeholder="Direccion"   ng-model="insertarProveedor.direccionProveedor" name="direccionProveedor">
						</div>
					</div>
					
					
					
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Telefono</label>
							<input type="text" class="form-control input-sm" placeholder="Telefono"   ng-model="insertarProveedor.telefonoProveedor" name="telefonoProveedor">
						</div>
					</div>
					
					
					
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Departamento </label>
							<input type="text" class="form-control input-sm" placeholder="Departamento"   ng-model="insertarProveedor.departamento" name="departamento">
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Rentabilidad</label>
							<input type="number" class="form-control input-sm" placeholder="Rentabilidad"   ng-model="insertarProveedor.rentabilidad" name="rentabilidad">
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group">
							<label class="bmd-label-floating">Dias De Pago</label>
							<input type="number" class="form-control input-sm" placeholder="Dias De Pago"   ng-model="insertarProveedor.diasPago" name="diasPago">
						</div>
					</div>
					
					
					
					<div class="col-md-12">
						<button type="button" class="btn btn-info  btn-sm" ng-click="guardarProveedor(insertarProveedor)">Guardar</button>
					</div>
					
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-header card-header-rose card-header-icon">
				<div class="card-icon">
					<i class="material-icons">shopping_cart</i>
				</div>
				<h3 class="card-title">Proveedores</h3>
			</div>
			<div class="card-body">
				<div class="col-md-12">
					<div class="container-3">
						<span class="icon"><i class="material-icons">search</i></span>
						<input type="text" class="form-control input-sm" placeholder="Buscar Cliente..." name="proveedor" id="id_proveedor" ng-model="filtroProveedor">
					</div>
				</div>
				<!-- <div class="col-md-12">
					<uib-pagination class="pagination-mod" total-items="filterProveedor.length" ng-model="pagelistadodetodos_Producto" ng-change="paginalistadodetodos_Cateoria()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
				</div> -->
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Codigo Proveedor</th>
									<th>Nombre Proveedor</th>
									<th>Responsable</th>
									<!-- <th>Serial Producto</th> -->
									<th>Departamento</th>
									<!-- <th>descripcion</th> -->
									<th>Estado</th>
									<th>Rentabilidad</th>
									
									
									<th colspan="2">Operaciones</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listadoProveedor in filterProveedor = (listadodetodos_Proveedores | filter : filtroProveedor) | limitTo:20:20*(pagelistadodetodos_Producto-1)">
									<td>{{listadoProveedor.codigo_proveedor}}</td>
									<td>{{listadoProveedor.nombre_proveedor}}</td>
									<td>{{listadoProveedor.responsable}}</td>
									<!-- <td>{{listadoProveedor.serial}}</td> -->
									<td>{{listadoProveedor.Departamento}}</td>
									<!-- <td>{{listadoProveedor.descripcion}}</td> -->
									<td ng-if="listadoProveedor.estado==1">Activo</td>
									<td>{{listadoProveedor.rentabilidad}}</td>
									
									
									<td>
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalactualizarProveedor" ng-click="verProveedor(listadoProveedor.id_proveedor,listadoProveedor.codigo_proveedor,listadoProveedor.nombre_proveedor,listadoProveedor.responsable,listadoProveedor.direccion,listadoProveedor.telefono,listadoProveedor.Departamento,listadoProveedor.estado,listadoProveedor.rentabilidadpro,listadoProveedor.diasPago,actualizarProveedor)"><span class="icon-pencil"></span>Editar</button>
									</td><td>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminarProducto" ng-click="confirmaEliminar_Proveedor(listadoProveedor.id_proveedor,listadoProveedor.codigo_Proveedor,listadoProveedor.nombre_proveedor)"><span class="icon-trash"></span>Eliminar</button>
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
<!-- MODAL PARA ACTUALIZAR CAtegoria -->
<div class="modal" id="ModalactualizarProveedor">
<div class="modal-dialog ta_modal">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h2 class="tt_modal">Actualizar Proveedor</h2>
	</div>
	<!-- cuerpo del <mod</mod>al -->
	<div class="modal-body">
		<div class="row">
			<form class="form-jar">
				
				<input type="hidden" ng-model="actualizarProveedor.id_proveedor" name="id_proveedor" placeholder="id" class="form-control" required disabled="disabled">
				<div class="row">
					<label class="col-md-3 col-form-label">Codigo del Proveedor</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="number" class="form-control" placeholder="Codigo"   ng-model="actualizarProveedor.CodigoProveedor" name="CodigoProveedor">
						</div>
					</div>
				</div>

				<div class="row">

					<label class="col-md-3 col-form-label">Nombre Del Proveedor</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="Nombre del Proveedor"   ng-model="actualizarProveedor.NombreProveedor" name="NombreProveedor">
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-md-3 col-form-label">Responsable </label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="Ingrese Responsable"   ng-model="actualizarProveedor.responsable" name="responsable">
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-md-3 col-form-label">Direccion</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="Direccion del Proveedor"   ng-model="actualizarProveedor.direccionProveedor" name="direccionProveedor">
						</div>
					</div>
				</div>
				
				
				
				
				
				<div class="row">
					<label class="col-md-3 col-form-label">Telefono</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="ingrese Telefono"   ng-model="actualizarProveedor.telefonoProveedor" name="telefonoProveedor">
						</div>
					</div>
				</div>
				
				<div class="row">
					<label class="col-md-3 col-form-label">Departamento </label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="ingrese departamento"   ng-model="actualizarProveedor.departamento" name="departamento">
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-md-3 col-form-label">Rentabilidad</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="number" class="form-control input-sm" placeholder="ingrese rentabilidad"   ng-model="actualizarProveedor.rentabilidad" name="rentabilidad">
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-md-3 col-form-label">Estado</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="number" class="form-control input-sm" placeholder="ingrese rentabilidad"   ng-model="actualizarProveedor.estado" name="rentabilidad">
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-md-3 col-form-label">Dias de pago</label>
					<div class="col-md-9">
						<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="ingrese dias del mes de pago"   ng-model="actualizarProveedor.diasPago" name="diasPago">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-info  btn-sm" ng-click="UpdateProveedor(actualizarProveedor)" data-dismiss="modal">Actualizar</button>
					</div>
				</div>
			</form>
			
		</div>
	</div>
</div>
</div>
</div>
<!-- M
ODAL PARA ACTUALIZAR CAtegoria -->
<div class="modal" id="ModalAgregarProducto">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h2 class="tt_modal">Agregar Cantidad de Producto</h2>
	</div>
	<!-- cuerpo del <mod</mod>al -->
	<div class="modal-body">
		<div class="row">
			<form>
				
				<form id="guardarInscripcion" name="guardarInscripcion">
					<div class="col-md-12">
						<div class="col-md-5">
							<label>Codigo Producto : </label><span>{{CodigoProductoAgregar}}</span>
							
						</div>
						<div class="col-md-4">
							<label>Nombre : </label><span> {{nombreProductoAgregar}}</span>
							
						</div>
						<div class="col-md-3">
							<label>Valor   : </label><span> {{valorVentaProductoAgregar}}</span>
							
						</div>
						<!-- <div class="col-md-4"> -->
						<!-- <label>Periodo  : </label><span> {{year}} - {{periodo}} </span> -->
						
					</div>
					<fieldset>
						<legend> <hr></legend>
					</fieldset>
					<div  ng-show="fromIngresosCantidad.show"  class="col-md-offset-3">
						
						
						<div class="col-md-8">
							<div class="form-group">
								<label for="">Cantidad Por Unidad</label>
								<input type="number" class="form-control input-sm" placeholder="ingrese Cantidad"   ng-model="AgregarCantidadProducto.AddCantidadUnidad" name="AddCantidadUnidad">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="">Cantidad Por Fraccion</label>
								<input type="number" class="form-control input-sm" placeholder="ingrese Cantidad"   ng-model="AgregarCantidadProducto.AddCantidadFraccion" name="AddCantidadFraccion">
							</div>
						</div>
					</div>
					
					
				</form>
				<div  ng-show="fromIngresosCantidadBotton.show" class="col-md-offset-4">
					<div class="col-md-12">
						<button type="button" class="btn btn-info btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="guardarIngresosProducto(id_ProductoAgregar,AgregarCantidadProducto)" >
						Guardar Cantidad
						</button>
					</div>
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
				<input type="hidden"  name="idEliminarProveedor" ng-model="idEliminarProveedor">
				¿Realmente desea eliminar Proveedor <b>{{nombre_proveedorEl}} {{codigo_provvedorEl}}</b>?
				</h3>
				
			</div>
			<div class="col-md-12 col-md-offset-3">
				<div class="col-md-2">
					<button class="btn btn-danger btn-sm" ng-click="EliminarProveedor(idEliminarProveedor)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
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