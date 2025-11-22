<?php   session_start();
//$_SESSION['ejecutado'];
?>
<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">list_alt</i>Inventario General
</uib-tab-heading>
<div class="row">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">assignment</i>
			</div>
			<h3 class="card-title">Inventario</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroInventarioList" ng-keypress="listadoPorOrdenInventario(e,filtroInventarioList)" autofocus="autofocus" >
				</div>
			</div>
			<div class="col-md-12">
				<uib-pagination class="pagination-mod" total-items="filterInventario.length"  max-size="5" class="pagination-sm" boundary-links="true"  ng-model="pagelistadodetodos_inventariioList" ng-change="paginalistadodetodos_inventariioList()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="t-completa">
								<th>Cod.Producto</th>
								<th>Nombre</th>
								<th>Pre</th>
								<th>Und</th>
								<th>Frac</th>
								<th>Cambio U</th>
								<th>Cambio F</th>
								<th>valor </th>
								<th>Valor U</th>

							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoInventario in filterInventario = (listadodetodos_inventariioList | filter : filtroInventarioList) | limitTo:100:100*(pagelistadodetodos_inventariioList-1)">
								<td>{{listadoInventario.codigo_producto}}</td>
								<td>{{listadoInventario.descripcion}}</td>
								<td>{{listadoInventario.presentacion}}</td>
								<td><input type="text" name="cantidadF" class="form-control input-sm"  ng-keypress="ajusteInventario(e,listadoInventario.Unidad,listadoInventario.stock,listadoInventario.id_inventario,listadoInventario.fraccion)" ng-model="listadoInventario.Unidad" ></td>
								<td ><input type="text" name="cantidadF"  ng-keypress="ajusteInventario(e,listadoInventario.Unidad,listadoInventario.stock,listadoInventario.id_inventario,listadoInventario.fraccion)" class="form-control input-sm" ng-if="listadoInventario.fraccion!=0"  ng-model="listadoInventario.stock" ></td>
								<td> {{listadoInventario.diferenciaU}} </td>
								<td  ><div ng-if="listadoInventario.fraccion!=0">{{listadoInventario.diferenciaF}} </div> </td>
								<td>
								{{listadoInventario.valor_venta}}
								</td>
								<td>
								{{listadoInventario.valor_unidad}}
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
<!-- tab 2 -->
<uib-tab index="3">
<uib-tab-heading>
<i class="material-icons">list_alt</i>Inventario Por Producto
</uib-tab-heading>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">how_to_vote</i>
			</div>
			<h3 class="card-title">Inventatio</h3>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<input type="hidden" name="id_producto" id="id_producto" ng-model="busquedainventarioXproducto.id_producto">
					<div class="input-group">
						<input type="text" class="form-control input-sm" name="codigo_producto" id="codigo_producto" ng-model="busquedainventarioXproducto.codigo_producto" disabled>
						<span class="input-group-btn">
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-productorReporte"><i class="material-icons">search</i> Buscar</button>
						</span>
					</div>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="nombre_producto" id="nombre_producto" ng-model="busquedainventarioXproducto.nombre_producto" disabled>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary" ng-click="busquedainventarioXproducto(busquedainventarioXproducto.id_producto)"><span class="icon-search"></span>Buscar</button>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="card">
		<div class="card-header card-header-rose card-header-text">
			<div class="card-icon">
				<i class="material-icons">assignment</i>
			</div>
			<h4 class="card-title">Resultado Busqueda</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Categoria</th>
							<th>Nombre Producto</th>
							<th>Codigo</th>
							<th>Cantidad U</th>
							<th>Cantidad F</th>
							
							
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="listado in filterinvenXprodut = (listainventarioXproducto )">
							<td>{{listado.nombre_categoria}}</td>
							<td>{{listado.descripcion}}</td>
							<td>{{listado.codigo_producto}}</td>
							<td>{{listado.Unidad}}</td>
							<td>{{listado.stock}}</td>
							
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Ininio ventana modal de productos -->
<div id="modal-productorReporte" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Productos</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<input type="text" name="id_producto" class="form-control" placeholder="Buscar..." id="id_producto" ng-model="filtroProductoIngreso">
					</div>
					<div class="col-md-12">
						<uib-pagination class="pagination-mod" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
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
											<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarinvemtario_ProductXreprote(listado.id_producto,listado.descripcion,listado.codigo_producto,busquedainventarioXproducto)">Agregar</button>
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
<!-- fin ventana modal de productos -->
</uib-tab>
<!-- ---------------------- -->
<uib-tab index="2">
<uib-tab-heading>
<i class="material-icons">list_alt</i>Inventario Por Categoria
</uib-tab-heading>
<div class="card">
	<div class="card-header card-header-rose card-header-text">
		<div class="card-icon">
			<i class="material-icons">ballot</i>
		</div>
		<h4 class="card-title">Categoria</h4>
	</div>
	<div class="card-body">
		<input type="hidden" name="id_categoria" id="id_categoria" ng-model="busquedainventarioXcategira.id_categoria">
		<div class="input-group">
			<input type="text" class="form-control" name="nombre_categoria" id="nombre_categoria" ng-model="busquedainventarioXcategira.nombre_categoria" disabled>
			<span class="input-group-btn">
				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-categoriadelProduct"><span class="icon-search"></span>Buscar</button>
			</span>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary" ng-click="busquedainventarioXcategorias(busquedainventarioXcategira.id_categoria)"><i class="material-icons">search</i>Buscar</button>
		</div>
	</div>
</div>
<!-- Ininio ventana modal de productos -->
<div id="modal-categoriadelProduct" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Categorias</h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<span><i>{{"Registros Encontrados"}}</i></span>
						<span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
							{{listCategoriasProdcuto.length}}
						</span>
					</div>
					<div class="col-md-12">
						<uib-pagination class="pagination-mod" total-items="filterCateg_Productos.length" ng-model="pagelistCategoriasProdcuto" ng-change="paginalistCategoriasProdcuto()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=4></uib-pagination>
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre categoria</th>
										
										<th colspan="2">Operaciones</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="listado in filterCateg_Productos = (listCategoriasProdcuto | filter : filtroProductoIngreso) | limitTo:4:4*(pagelistCategoriasProdcuto-1)">
										<td>{{listado.nombre_categoria}}</td>
										
										<td>
											<button type="button" class="btn btn-info btn-sm"  ng-click="agregarcartegoriaFormu(listado.id_categoria,listado.nombre_categoria,busquedainventarioXcategira)">Agregar</button>
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
<!-- fin ventana modal de productos -->
</uib-tab>
<uib-tab index="4">
<uib-tab-heading>
<i class="material-icons">list_alt</i>Descuadre de Inventario
</uib-tab-heading>

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
					<input type="date" class="form-control" name="fechaInicialFactura" id="fechaInicialFactura" ng-model="agregarFechaDescuadre.fechaInicialFactura">
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
					<input type="date" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="agregarFechaDescuadre.fechaFinalFactura">
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="col-md-6">
	<button type="button" class="btn btn-info btn-sm" ng-click="buscarDescuadreInventario(agregarFechaDescuadre)"><i class="material-icons"> search</i>Buscar Descuadre</button>
</div>
<div class="col-md-6">
	<button type="button" class="btn btn-info btn-sm" ng-click="buscarDescuadreInventarioNomodificados(agregarFechaDescuadre)"><i class="material-icons"> search</i>Buscar no modificados</button>
</div>

<div class="col-md-6">
	<button type="button" class="btn btn-info btn-sm" ng-click="ordenarGanancia()"><i class="material-icons"> search</i>Calcular</button>
</div>

<div class="row">
	<div class="card" ng-if="visibleDateDos==true">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">assignment</i>
			</div>
			<h3 class="card-title">Inventario</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroDescuadreoListDos" autofocus="autofocus" >
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Cod.Producto</th>
								<th>Nombre</th>
								<th>Pre</th>
								
								<th>Unidad</th>
								<th>Fraccion</th>
								
								<th>valor </th>
								<th>valor Unidad </th>
								
								
								
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoInventario in filterDescuadre = (listadoDescuadreXunidadNomodificado | filter : filtroDescuadreoListDos) | limitTo:1000:1000*(pagelistadoDescuadreXunidadNomodificado-1)">
								<td>{{listadoInventario.codigo_producto}}</td>
								<td>{{listadoInventario.descripcion}}</td>
								<td>{{listadoInventario.presentacion}}</td>
								<td> {{listadoInventario.Unidad}} </td>
								<td> 
									<div ng-if="listadoInventario.fraccion!=0">
								{{listadoInventario.stock}} 
								</div>
							</td>

							
								
								<td>
								{{listadoInventario.valor_venta | number:0}}
								</td>
								
								<td>
								{{listadoInventario.valor_unidad | number:0}}
								</td>
								
							</tr>
								

						</tbody>
					</table>
					<h2>{{totalUUUU}}</h2>
					<h2>{{totalUUUUD}}</h2>
				</div>
			</div>
		</div>
	</div>
</div>	
<div class="card" ng-if="visibleDate==true">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">assignment</i>
			</div>
			<h3 class="card-title">Inventario</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroDescuadreoList" autofocus="autofocus" >
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Cod.Producto</th>
								<th>Nombre</th>
								<th>Pre</th>
								
								<th>Cambio U</th>
								<th>Cambio F</th>
								
								<th>valor </th>
								<th>Descuadre U</th>
								
								
								<th>Valor Fecha</th>

							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoInventario in filterDescuadre = (listadoDescuadreXunidad | filter : filtroDescuadreoList) | limitTo:1000:1000*(pagelistadoDescuadreXunidad-1)">
								<td>{{listadoInventario.codigo_producto}}</td>
								<td>{{listadoInventario.descripcion}}</td>
								<td>{{listadoInventario.presentacion}}</td>
								<!-- <td> {{listadoInventario.diferenciaU}} </td> -->
								<td> 
									<div ng-if="listadoInventario.fraccion!=0">
								{{listadoInventario.diferenciaF}} 
								</div>
							</td>

							
								
								<td>
								{{listadoInventario.valor_venta | number:0}}
								</td>
								<td>
								{{(listadoInventario.valor_venta * listadoInventario.diferenciaU * -1 | number:0) }}
								</td>
								
								<td>
								
								
								{{listadoInventario.fecha_movimiento}}
								</td>
							</tr>
							</tbody>
					</table>
					</div>	
								
							
						
				
			</div>
				<div class="row">
						
						<div class="col-md-4">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo">  <span class="text">$ {{totaldescuadrePorUnidad * -1 | number:2}}</span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Unidad ({{ totalUnidadDes * -1}})</h4>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo">  <span class="text">$ {{totaldescuadrePorFraccion * -1 | number:2}}</span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Fraccion ({{totalFraccionDes * -1}}))</h4>
			</div>
		</div>
	</div>
		<div class="col-md-4">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo">  <span class="text">$ {{totaldescuadre * -1 | number:2}}</span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total</h4>
			</div>
		</div>
	</div>


					</div>
		</div>
	</div>
</div>
</uib-tab>
</uib-tabset>