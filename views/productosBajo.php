<?php   session_start();
//$_SESSION['ejecutado'];
?>
<!-- <div class="card"> -->
<uib-tabset active="active" class="col-md-12 tab-normal">
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">add_box</i>Movimiento del Producto
</uib-tab-heading>



	<div class="col-md-12">
	<div class="card">
		
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">add_box</i>
			</div>
			<h3 class="card-title">Lista De Productos Stock Bajo</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" id="search" placeholder="Buscar Producto..." onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroProducto">
				</div>
			</div>
			<div class="col-md-12">
				<uib-pagination class="pagination-mod" total-items="filterProducto.length"  max-size="5"  ng-model="pagelistadodetodos_Producto" boundary-links="true"  ng-change="paginalistadodetodos_Cateoria()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=100></uib-pagination>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table  class="table table-hover" >
						<thead>
							<tr>
								<th>Cantidad</th>
								<th>Codigo Producto</th>
								<th ng-show="false">Barra</th>
								<th>Descripccion</th>
								<!-- <th>Proveedor</th> -->
								<!-- <th>Serial Producto</th> -->
								<!-- <th>Categoria</th> -->
								<!-- <th>descripcion</th> -->
								<th>Valor</th>
								<th>Valor Venta</th>
								<th>Valor Unidad</th>
								
								
							
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoProducto in filterProducto = (listadodetodos_Producto | filter : filtroProducto) | limitTo:100:100*(pagelistadodetodos_Producto-1)" ng-if=" listadoProducto.stockMinimo>=listadoProducto.Unidad">
								<td>
									<div  class="col-md-12 btn_sesion">
										<li class="dropdown mega-dropdown btn_li">
											<a href="" class="btn_log btn btn-info btn-sm" class="dropdown-toggle" data-toggle="dropdown"  ng-click="verificarStock(listadoProducto.id_producto)">cantidad  <span class="caret"></span></a>
											<ul class="dropdown-menu  mega-dropdown-menu  row">
												<li>
													<div class="col-md-12">
														<div class="table-table-responsive">
															<table class="table table-bordered">
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
								<td>{{listadoProducto.codigo_producto}}</td>
								<td ng-show="false">{{listadoProducto.codigo_barras}}</td>
								<td>{{listadoProducto.descripcion}}</td>
								<!-- <td>{{listadoProducto.nombre_proveedor}}</td> -->
								<!-- <td>{{listadoProducto.serial}}</td> -->
								<!-- <td>{{listadoProducto.nombre_categoria}}</td> -->
								<!-- <td>{{listadoProducto.descripcion}}</td> -->
								<td>$ {{listadoProducto.valor | number:0}}</td>
								<td>$ {{listadoProducto.valor_venta | number:0}}</td>
								<td>$ {{listadoProducto.valor_unidad | number:0}}</td>
								
								
								
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

	
	
</uib-tab>
</uib-tabset>
