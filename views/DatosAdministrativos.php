<div class="col-lg-4 col-md-6 col-sm-6 ml-auto mr-auto">
	<div class="card" ng-hide="fromVisibility">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">contacts</i>
			</div>
			<h4 class="card-title">Login</h4>
		</div>
		<div class="card-body">
			
			<div class="col-md-12">
				<label class="">Contraseña </label>
				<div class="form-group">
					<input type="password" name="passCurioso" placeholder="Ingrese su contraseña" class="form-control"  ng-model="cosas.passCurioso">
					
				</div>
			</div>
			<button type="button" class="btn btn-primary btn-sm" ng-click="verificarCosas(cosas.passCurioso)" data-dismiss="modal"><span class="icon-floppy"></span> Aceptar</button>
		</div>
	</div>
</div>

<uib-tabset active="active" class="col-md-12 tab-normal active-color switch-trigger" ng-show="fromVisibility" >
<uib-tab index="0">
<uib-tab-heading>
<i class="material-icons">add_box</i>Datos Generales
</uib-tab-heading>




	
<div class="row" >
	<div id="modal_clientes_Factura" class="modal " role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h1 class="tt_modal">	<span class="icono"><i class="material-icons">assessment</i></span></h1>
			</div>
			<div class="modal-body">
				<div class="row">
					
					<div class="col-md-12">
						<div class="table-responsive">
						<h3 align="center">¿Esta Seguro(a) que desea cerrar el inventario Actual?</h3>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm" ng-click="cierreInventario(VTotal,vVenta,unidadN,stockN)" data-dismiss="modal"><span class="icon-floppy"></span> Aceptar</button>
					<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
	<div class="col-md-3" ng-show="fromVisibility"  data-toggle="modal" data-target="#modal_clientes_Factura">
		<div class="card datos-ia">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text"> {{fechaToday}} </span></h3>
				<span class="icono"><i class="material-icons">date_range</i></span>
			</div>
			
			<div class="card-body">
				<h4><strong>Cerrar Inventario Actual</strong></h4>
			</div>
		</div>
	</div>
		<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos-ia">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">$ {{VTotal  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">credit_card</i></span>
			</div>
			
			<div class="card-body">
				<h4><strong>Su capital Invertido Actual</strong></h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos_actuales">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">$ {{vVenta | number:0}}</span> </h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Su capital Total Actual</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo">  <span class="text">${{ vVenta -VTotal  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">account_balance_wallet
</i></span>
			</div>
			
			<div class="card-body">
				<h4>Utilidad</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos-unidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text"> {{unidadN   | number:0 }} </span></h3>
				<span class="icono"><i class="material-icons">view_carousel</i></span>
			</div>
			
			<div class="card-body">
				<h4>Unidades  Actuales</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos-unidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text"> {{stockN   | number:0 }} </span></h3>
				<span class="icono"><i class="material-icons">donut_small</i></span>
			</div>
			
			<div class="card-body">
				<h4> Fraccion Actual</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos-venta-u">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{Vtotaltotal - TotalGanDescuento  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">tab</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total en Ventas del Ultimo Dia</h4>
			</div>
		</div>
	</div>
	
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos-v-s">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{ValorSemana - ValorSemanaDescuento | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">timeline</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total en Ventas de Semana</h4>
			</div>
		</div>
	</div>
	
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos_actuales">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text"> ${{ValorMes - ValorMesDescuento | number:0}}</span></h3>
				<span class="icono"><i class="material-icons">trending_up</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Ventas Del ultimo mes</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos_actuales">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{ ValorAnno - TotalAnnoDescuento  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">euro_symbol</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total en ventas del ultimo año</h4>
			</div>
		</div>
	</div>
	<div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos_actuales">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{ ValorAbono  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">shopping_cart</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Valor Creditos</h4>
			</div>
		</div>
	</div><div class="col-md-3" ng-show="fromVisibility">
		<div class="card datos_actuales">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{ AbotosTotal  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">shopping_cart</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total en Abonos</h4>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-6" ng-show="fromVisibility">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Ventas del Dia  {{fechaActual}}</h3>
				</div>
				<div class="card-body card-table">
					<div class="table-responsive card-tabla">
						<table class="table table-hover ">
							<thead>
								<tr>
									<th></th>
									<!-- <th>Codigo</th> -->
									<th>Nombre</th>
									<th>Caja</th>
									<th>Und</th>
									<th>Valor </th>
									
									
									
								</tr>
							</thead>
							<tbody class="tbl-normal">
								<tr ng-repeat="listadodelDia in filterdelDia = (delDia)">
									<td></td>
									<!-- <td>{{listadodelDia.codigo_factura}}</td> -->
									<td>{{listadodelDia.descripcion}}</td>
									<td><div class="input-tabla form-group form-group-sm" ng-if="listadodelDia.fraccion!=0">{{listadodelDia.cantidad}}</div></td>
									<td><div class="input-tabla form-group form-group-sm" ng-if="listadodelDia.fraccion!=0">{{listadodelDia.cantidadFraccion}}</div>
										<div class="input-tabla form-group form-group-sm" ng-if="listadodelDia.fraccion==0">{{listadodelDia.cantidad}}</div></td>
									<td>${{listadodelDia.TotalPago | number:0}}</td>
									
									
									
								</tr>
								
							</tbody>
						</table>

					</div>
					<div class="table-responsive">
					<table class="table">
							<tr>
								<th><h4>SubTotal </h4></th>
								<th><h4 class="tbl-text">${{Vtotaltotal - VtotalDescuento | number:0}}</h4></th>
							</tr>
							<tr>
								<th><h4>Descuento</h4></th>
								<th><h4 class="tbl-text">${{TotalGanDescuento | number:0}}</h4></th>
							</tr>

							<tr class="table-success">
								<th><h4>Total</h4></th>
								<th><h4 class="tbl-text">${{Vtotaltotal - TotalGanDescuento | number:0}}</h4></th>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6" ng-show="fromVisibility">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Ventas del Dia de ayer  {{fechaActualAyer}}</h3>
				</div>
				<div class="card-body card-table">
					<div class="table-responsive card-tabla">
						<table class="table table-hover">
							<thead>
								<tr>
									<th></th>
									<!-- <th>Codigo</th> -->
									<th>Nombre</th>
									<th>Cantidad</th>
									<th>Fraccion</th>
									<th>Valor </th>
									
									
									
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="listadodelDiadeAyer in filterdelDiadeAyer = (delDiadeAyer)">
									<td></td>
									<!-- <td>{{listadodelDiadeAyer.codigo_factura}}</td> -->
									<td>{{listadodelDiadeAyer.descripcion}}</td>
									<td>{{listadodelDiadeAyer.cantidad}}</td>
									<td>{{listadodelDiadeAyer.cantidadFraccion}}</td>
									<td align="rigth">${{listadodelDiadeAyer.TotalPago | number:0}}</td>
									
									
									
								</tr>
								
							</tbody>
						</table>

					</div>

					<div class="table-responsive">
						<table class="table">
							<tr>
									
									
									<th><h4> SubTotal</h4></th>
									<th> <h4 class="tbl-text"> ${{VtotaltotalAyer | number:0}}</h4></th>
								</tr>
								<tr>
									
									
									<th><h4>Descuento</h4></th>
									<th> <h4 class="tbl-text"> ${{VtotalDescuentoAyer | number:0}}</h4></th>
								</tr><tr class="table-success">
								
									<th><h4>Total</h4></th>
									<th><h4 class="tbl-text"> ${{VtotaltotalAyer - VtotalDescuentoAyer | number:0}}</h4></th>
								</tr>
						</table>

							<!-- <h4>Total</h4>
							<h2>${{VtotaltotalAyer - VtotalDescuentoAyer | number:0}}</h2>		 -->
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
</uib-tab>
<uib-tab index="1">
<uib-tab-heading ng-click="listadoCierreInventario()">
<i class="material-icons">add_box</i>Datos de inventarios
</uib-tab-heading>

<div class="row">
	
	<div class="col-md-12">
		<div class="col-md-12">
				<uib-pagination class="pagination-mod" total-items="filterCierre.length" ng-model="pagelistadodecierre_inventario" ng-change="paginalistadodecierre_inventario()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=50></uib-pagination>
			</div>
		<div class="card">
			<div class="col-md-12">
				<div class="container-3">
					<span class="icon"><i class="material-icons">search</i></span>
					<input type="search" id="search" placeholder="Buscar Cierre Inventario..." onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroCierre">
				</div>
			</div>
			
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Tabla de inventarios</h3>
				</div>

				<div class="card-body">
				<div class="table-responsive">
					<table  class="table table-hover" >
						<thead>
							<tr>
								
								<th>fecha Cierre</th>
								<th>Inventario</th>
								<th>Capital</th>
								<th>Utilidad</th>
								<th>Unidad</th>
								<th>Fraccion</th>
							</tr>
						</thead>
						<tbody class="tbl-normal">
							<tr ng-repeat="listadoCierre in filterCierre = (listadodecierre_inventario | filter : filtroCierre) | limitTo:50:50*(pagelistadodecierre_inventario-1)" ng-click="SelectInventario(listadoCierre.id_cierreInventario, listadoCierre.fecha_Cierre,listadoCierre.total_Invertido,listadoCierre.tota_capital,listadoCierre.total_Utilidad,listadoCierre.total_Unidad,listadoCierre.total_Fraccion)" >
							
							
								<td>{{listadoCierre.fecha_Cierre }}</td>
								<td>{{listadoCierre.total_Invertido | number:0}}</td>
								<td>{{listadoCierre.tota_capital | number:0}}</td>
								
								<td>{{listadoCierre.total_Utilidad | number:0}}</td>
								<td>{{listadoCierre.total_Unidad | number:0}}</td>
								<td>{{listadoCierre.total_Fraccion | number:0}}</td>
								
								
								
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6" ng-if="id_cierreI!=0">
		
		<div class="card">
		
			
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon" ng-click="ClearinventarioI()">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Inventario Inicio</h3>
				</div>

				<div class="card-body">

					<h2>{{fecha_CierreI}}</h2>
					<ul>
						<li>Inventario: {{total_InvertidoI | number:0}}  </li>
						<li>Capital: {{tota_capitalI | number:0}} </li>
						<li>Utilidad: {{total_UtilidadI | number:0}} </li>
						<li>Unidad: {{total_UnidadI | number:0}} </li>
						<li>Fraccion: {{total_FraccionI | number:0}} </li>

					</ul>
				</div>
			</div>
		</div>
<div class="col-md-6" ng-if="id_cierreF!=0">
		
		<div class="card">
		
			
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon" ng-click="ClearinventarioF()">
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title">Inventario Final</h3>

				</div>

				<div class="card-body">
					<h2>{{fecha_CierreF}}</h2>

					<ul>
						<li>Inventario: {{total_InvertidoF | number:0}}  </li>
						<li>Capital: {{tota_capitalF | number:0}} </li>
						<li>Utilidad: {{total_UtilidadF | number:0}} </li>
						<li>Unidad: {{total_UnidadF | number:0}} </li>
						<li>Fraccion: {{total_FraccionF | number:0}} </li>

					</ul>
				</div>
			</div>
		</div>

		<div class="card-footer" ng-if="id_cierreI!=0 && id_cierreF!=0">
					<button type="button" class="btn btn-primary" ng-click="ProcesarInventario(id_cierreI,id_cierreF)" >
					<i class="material-icons">play_for_work</i> Procesar
					</button>
					
				</div>
</div>
				<div class="row">

					<div class="col-md-12" >
		
		<div class="card">
		
			
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon" >
						<i class="material-icons">send</i>
					</div>
					<h3 class="card-title"></h3>
				</div>

				<div class="card-body">
						
						<h3>total de facturas : {{inventarioCierreData.length}}</h3>
					</div>
				</div>
				</div>

</div>

</uib-tab>
<uib-tab index="3">
	<uib-tab-heading>
	<i class="material-icons">format_list_bulleted</i>
	informe de venta
	</uib-tab-heading>
	<div class="row">

		<div class="col-md-7" >
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
									<th>Cod</th>
									<th>Nombre</th>
									<th>Und/Frac</th>
									
									<th>Valor </th>
									<th>Desc </th>
									<th>Neto </th>
									
									
									
								</tr>
							</thead>
							<tbody class="tbl-normal">
								<tr ng-repeat="listadodelDia in filterdelDia = (delDia)">
									<td></td>
									<td align="center">{{listadodelDia.codigo_factura}}</td>
									<td>{{listadodelDia.descripcion}}</td>
									<td align="center">{{listadodelDia.cantidad}}: {{listadodelDia.cantidadFraccion}} </td>
									
									
									<td>${{listadodelDia.TotalPago | number:0}}</td>
									<td align="center">${{listadodelDia.descuento | number:0}}</td>
									<td>${{listadodelDia.TotalPago - listadodelDia.descuento | number:0}}</td>
									
									
									
								</tr>
								
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-md-5" >
		<div class="col-md-12" >
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					
					<h4 class="card-title" >Mas Vendido</h4>
				</div>
				<div class="card-body" ng-repeat="listadodelDia in filterdelDia = (delDia)" ng-if="listadodelDia.id_producto==CodfacMax">
					{{listadodelDia.descripcion}} ({{listadodelDia.cantidad}}: {{listadodelDia.cantidadFraccion}}) -  ${{listadodelDia.TotalPago | number:0}}
				</div>
			</div>
		</div>
		<div class="col-md-12" >
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					
					<h4 class="card-title" >Menos Vendidos</h4>
				</div>
				<div class="card-body" ng-repeat="listadodelDia in filterdelDia = (delDia)" ng-if="listadodelDia.id_producto==CodfacMin">
					{{listadodelDia.descripcion}} ({{listadodelDia.cantidad}} :{{listadodelDia.cantidadFraccion}}) - ${{listadodelDia.TotalPago | number:0}}
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

<div class="col-md-2">
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
	<div class="col-md-2">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{TotalGanDescuento  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Descuentos</h4>
			</div>
		</div>
	</div>
<div class="col-md-2">
		<div class="card datos-venta-u">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{Vtotaltotal - TotalGanDescuento  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Neto</h4>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="card datos-utilidad">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">${{TotalGanancias  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Ganancias</h4>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="card datos-venta-u">
			<div  class="card-header card-datos">
				<h3 class="card-title titulo"> <span class="text">$ {{Vtotaltotal - TotalGanancias  | number:0}} </span></h3>
				<span class="icono"><i class="material-icons">dns</i></span>
			</div>
			
			<div class="card-body">
				<h4>Total Capital</h4>
			</div>
		</div>
	</div>

	<div id="myModaInformeFecha" class="modal " role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="tt_modal">Ingrese Fechas</h2>
			</div>
			<div class="modal-body">
				<div class="container">
  
</div>
				<div class="row">
					<div class="form-group">
						
					<input type="text" class="form-control"  ng-model="insertInformeVenta.fecha_inicio" name="fecha_inicio" placeholder="Año-Mes-Dia">
					<div class="form-group">

					<input type="text"  class="form-control"  ng-model="insertInformeVenta.fecha_final" name="fecha_final" placeholder="Año-Mes-Dia">
				</div>
				</div>
					
					
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-sm"  data-dismiss="modal" ng-click="informeVenta(insertInformeVenta)">Procesar</button>
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
						<input type="text" class="form-control" name="fechaInicialFactura" id="fechaInicialFactura" ng-model="listadoGeneral.fechaInicialFactura" placeholder="Año-Mes-Dia">
					</div>
					<div class="col-md-12 col-espacio">
						<label for="">Fecha final</label>
						<input type="text" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="listadoGeneral.fechaFinalFactura" placeholder="Año-Mes-Dia">
					</div>
					<div class="col-md-12 col-espacio">
						<label>Detalle de venta (Producto y valor):
							<input type="checkbox" ng-model="checkboxModel.value1">
						</label>
					</div>
					<div class="col-md-6">
						
						<button type="button" class="btn btn-info btn-sm" ng-click="buscarfacturaXfechaGeneral(listadoGeneral.idSistemaU,listadoGeneral,checkboxModel.value1)"><span class="icon-search"></span>Buscar</button>
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
	</uib-tab>
	
</uib-tabset>

