<?php   session_start();
//$_SESSION['ejecutado'];
?>
<!-- <div class="card"> -->
<uib-tabset active="active" class="col-md-12 tab-normal active-color switch-trigger">
    <uib-tab index="0" ng-click="cerrarverificarCosas()">
        <uib-tab-heading>
            <i class="material-icons">add_box</i>Crear Factura
        </uib-tab-heading>
        <form id="Form_insertarIngresos">
            <div class="row">
                <div class="col-md-8">
                   <!--  <div class="col-md-12 p-m-v">
                        <div class="producto" ng-repeat="listadoTopProducto in filterTopProducto = (listadodetodos_ProductoTopVentaXdia)" ng-click="agregarProductoFacturaPressTopProductos(listadoTopProducto.id_producto,listadoTopProducto.descripcion,listadoTopProducto.codigo_producto,listadoTopProducto.valor,listadoTopProducto.valor_venta,listadoTopProducto.ivaValor,listadoTopProducto.iva,listadoTopProducto.presentacion,listadoTopProducto.fraccion,listadoTopProducto.valor_unidad,listadoTopProducto.editableValor)">
                            <span class="ntf pink">{{listadoTopProducto.Unidad}} - {{listadoTopProducto.stock}}</span>
                            <div class="uno"><span> {{listadoTopProducto.descripcion.charAt(0)}}</span></div>
                            <p> {{listadoTopProducto.descripcion}}</p>
                        </div>
                    </div> --> 
                    <div class="col-md-12">
                        <div class="container-3">
                            <span class="icon"><i class="material-icons">search</i></span>
                            <input type="search" placeholder="Busqueda General..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" ng-model="busquedaProducto" ng-keypress="listadotodos_ProductoKeypress(e,busquedaProducto)" ng-change="listadotodos_ProductoChange(busquedaProducto) " ng-click="FacturaListaDiaria()" ng-focus="noBarraNew()" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-12" ng-if="barraNew!=0">
                        <h4>¿Desea Agregar Codigo de Barra a un Producto? </h4>
                        <div class="col-md-1">
                            <input type="submit" ng-click="showBarra(busquedaProducto)" data-toggle="modal" data-target="#myModalAddBarra" class="btn btn-info btn-sm" value="Si!">
                        </div>
                        <div class="col-md-1 separar">
                            <input type="submit" ng-click="noBarraNew()" class="btn btn-danger btn-sm" value="No!">
                        </div>
                    </div>
                    <div class="col-md-12" >
                        <div class="col-md-12">
                            <uib-pagination 
                                class="pagination-mod" 
                                total-items="pagelistadodetodos_Producto.length" 
                                max-size="maxSize" 
                                class="pagination-sm" 
                                boundary-links="true" 
                                ng-model="pagelistadodetodos_Producto" 
                                ng-change="paginalistadodetodos_Producto()" 
                                previous-text="&lsaquo;" 
                                next-text="&rsaquo;" 
                                items-per-page=10>
                            </uib-pagination>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Stock1</th>
                                        <th>Sec</th>
                                        <th>Cod.</th>
                                        <th>Prod</th>
                                        <th>Pre</th>
                                        <!-- <th style="width:20px;">Caja</th>
                                        <th style="width:20px;">Und</th> -->
                                        <th>V.Prod</th>
                                        <th>V.Und</th>
                                        <th>Agreg</th>
                                    </tr>
                                </thead>
                                <tbody class="tbl-normal">
                                    <tr ng-repeat="listado in filterDatProducIngreso = (listadodetodos_Producto) " ng-class="{'ctr': listado.stockMinimo >= listado.Unidad}">
                                        <td>
                                            <div class="col-md-12 btn_sesion">
                                                <h3 class="cantidad badge badge-warning">
                                                    <span class="" ng-if="listado.fraccion==0">{{listado.Unidad}} </span>
                                                    <span class="" ng-if="listado.fraccion!=0">{{listado.Unidad}} / {{listado.stock}}</span>
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="seccion">{{listado.seccion}}</td>
                                        <td>
                                            <div align="center">{{listado.codigo_producto}}</div>
                                        </td>
                                        <td>{{listado.descripcion}}</td>
                                        <td>{{listado.presentacion}}</td>
                                        <!-- <td>{{listado.nombre_categoria}}</td>
								<td>{{listado.codigo_producto}}</td> -->
                                        <!-- <td style="width:15px;">
                                            <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">
                                                <input type="number" name="cantidadU" class="form-control input-sm" ng-model="cant.cantidadU" ng-keypress="agregarProductoFactura(e,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant,listado.editableValor)">
                                            </div>
                                        </td> -->
                                        <!-- <td style="width:15px;">
                                            <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion==0">
                                                <input type="number" name="cantidadU" class="form-control input-sm" ng-model="cant.cantidadU" ng-keypress="agregarProductoFactura(e,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant,listado.editableValor)">
                                            </div>
                                            <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">
                                                <input type="number" name="cantidadF" class="form-control input-sm" ng-model="cant.cantidadF" ng-keypress="agregarProductoFactura(e,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant,listado.editableValor)">
                                            </div>
                                        </td> -->
                                        <td>
                                            <h4><strong>${{listado.valor_venta | number:0}}</strong></h4>
                                        </td>
                                        <td>
                                            <div ng-if="listado.fraccion!=0">
                                                <h4> <strong>${{listado.valor_unidad | number:0 }}</strong></h4>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm btn-tabla" data-dismiss="modal" ng-click="agregarProductoFacturaPress(listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,cant,listado.editableValor)">
                                                <span class="icon-cart-plus"></span>+</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">shopping_basket</i>
                                </div>
                                <h3 class="card-title">Ventas</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table  table-striped table-no-bordered table-hover dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <!-- 	<th>Codigo</th> -->
                                                <th style="width:15px;">Item.</th>
                                                <th>Prod.</th>
                                                <th>Pres.</th>
                                                <th style="width:40px;">Caja.</th>
                                                <th style="width:50px;">Und</th>
                                                <th>Valor Un.</th>
                                                <th>Iva.</th>
                                                <th>Total</th>
                                                <th>Opcion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listado in filterproducDetalles = (listaProductosDetalleFactura | orderBy:'-')">
                                                <!-- <td data-toggle="modal" data-target="#myModalSerial" ng-click="AddSerialList(listado.id_producto,listado.codigo_,listado.nombre,listado.id_categoria,listado.descripcion,listado.valor,listado.valor_venta)" >{{listado.codigoProducto}}</td> -->
                                                <td style="width:15px;">{{$index + 1}}</td>
                                                <td>{{listado.descripcion}}</td>
                                                <td>{{listado.presentacion}}</td>
                                                <td style="width:40px;">
                                                    <div class="input-tabla form-group form-group-sm">
                                                        <input type="number" name="cantidadU" id="UnidadId" class="form-control input-sm numero" ng-model="listado.cantidadU" onclick="javascript: limpia(this);" ng-change="agregarProductoFacturaChange(listado.numeroPro,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,listado.cantidadU,listado.cantidadF,listado.editableValor)" ng-if="listado.fraccion!=0">
                                                    </div>
                                                </td>
                                                <td style="width:50px;">
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion==0">
                                                        <input type="number" name="cantidadU" id="UnidadId" class="form-control input-sm numero" ng-model="listado.cantidadU" onclick="javascript: limpia(this);" ng-change="agregarProductoFacturaChange(listado.numeroPro,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,listado.cantidadU,listado.cantidadF,listado.editableValor)">
                                                    </div>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">
                                                        <input type="number" name="cantidadU" class="form-control input-sm numero" ng-model="listado.cantidadF" id="fraccionID" onclick="javascript: limpia(this);" ng-change="agregarProductoFacturaChange(listado.numeroPro,listado.id_producto,listado.descripcion,listado.codigo_producto,listado.valor,listado.valor_venta,listado.ivaValor,listado.iva,listado.presentacion,listado.fraccion,listado.valor_unidad,listado.cantidadU,listado.cantidadF,listado.editableValor)">
                                                    </div>
                                                </td>
                                                <td>${{listado.valor_venta - listado.ivaV | number:0}}</td>
                                                <td>{{listado.ivaV}} - ({{listado.iva}} %)</td>
                                                <td class="table-info">
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.editableValor==1">
                                                        <input type="number" name="cantidadU" class="form-control input-sm numero" ng-model="listado.valorTotal" id="fraccionID" ng-keypress="agregarProductoFacturaEditable(e)"></div>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.editableValor!=1">
                                                        <h4>${{listado.valorTotal |number:0}} </h4>
                                                    </div>
                                                </td>
                                                <td class="table-warning">
                                                    <div align="center">
                                                        <button type="button" class="btn btn-danger  btn-sm btn-tabla" ng-click="eliminarProductoProFacturar(listado.numeroPro,listado.id_producto,listado.valorTotal,listado.ganacia)"><span class="material-icons">delete_forever</span> </button>
                                                        <button></button>
                                                        </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 p-m-v">
                        <label class="label" title="EFECTIVO">
                            <input class="label__checkbox" ng-model="cambioFacturaDinero.tipoPago" value="EFECTIVO" type="radio" name="jar" checked />
                            <span class="label__text">
                                EFECTIVO
                                <span class="label__check">
                                    <i class="material-icons icon">attach_money</i>
                                </span>
                            </span>
                        </label>
                        <label class="label" title="DAVIPLATA">
                            <input class="label__checkbox" ng-model="cambioFacturaDinero.tipoPago" value="DAVIPLATA" type="radio" name="jar" />
                            <span class="label__text">
                                DAVIPLATA
                                <span class="label__check">
                                    <i class="material-icons icon">
                                    vpn_lock
                                    </i>
                                </span>
                            </span>
                        </label>
                        <label class="label" title="ADDI">
                            <input class="label__checkbox" ng-model="cambioFacturaDinero.tipoPago" value="ADDII" type="radio" name="jar" />
                            <span class="label__text">
                                ADDI
                                <span class="label__check">
                                    <i class="material-icons icon">
                                    vpn_lock
                                    </i>
                                </span>
                            </span>
                        </label>
                        <label class="label" title="TRANSFERENCIA BANCARIA">
                            <input class="label__checkbox" ng-model="cambioFacturaDinero.tipoPago" value="TRANSFERENCIA BANCARIA" type="radio" name="jar" />
                            <span class="label__text">
                                TRANSFERENCIA
                                <span class="label__check">
                                    <i class="material-icons icon">
                                        swap_horiz
                                    </i>
                                </span>
                            </span>
                        </label>
                        <label class="label" title="NEQUI">
                            <input class="label__checkbox" ng-model="cambioFacturaDinero.tipoPago" value="NEQUI" type="radio" name="jar" />
                            <span class="label__text">
                                NEQUI
                                <span class="label__check">
                                    <i class="material-icons icon">
                                        vpn_lock
                                    </i>
                                </span>
                            </span>
                        </label>
                         <label class="label" title="OTROS">
                            <input class="label__checkbox" ng-model="cambioFacturaDinero.tipoPago" value="OTROS" type="radio" name="jar" />
                            <span class="label__text">
                                OTROS
                                <span class="label__check">
                                    <i class="material-icons icon">
                                        account_balance_wallet
                                    </i>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="material-icons" ng-click="verDescuento(cambioFacturaDinero)">payment</i>
                            </div>
                            <h4 class="card-title">Detalles Factura</h4>
                        </div>
                        <div class="card-body"> 
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th colspan="8"></th> -->
                                        <th class="dinero">
                                            <span class="icon"><i class="material-icons">attach_money</i></span>
                                            <input type="text" onclick="javascript: limpia(this);"   class="form-control cambio" onkeyup="format(this)" onchange="format(this)" ng-model="cambioFacturaDinero.Pagocambio" id="dinero" ng-change="cambioFactura(cambioFacturaDinero)" ng-keypress="guardarFactura(e,insertClientes,cambioFacturaDinero)">
                                        </th>
                                    </tr>
                                    <tr ng-show="viewDescuento">
                                        <th class="dinero cambio descuento"><span>Descuento</span><br>
                                            <span class="icon"><i class="material-icons">attach_money</i></span>
                                            <input type="text" onclick="javascript: limpia(this);" onfocus="javascript: limpia(this);"  class="form-control cambio" onkeyup="format(this)" onchange="format(this)" ng-model="cambioFacturaDinero.descuento" class="form-control" id="descuento" ng-keypress="validarDescuento(e,cambioFacturaDinero)">
                                        </th>
                                    </tr>
                                    <tr>
                                        <!-- <th colspan="8"></th> -->
                                        <th class="dinero cambio" id="cambio" ng-model="cambioFacturaDinero.cambio">
                                            Cambio<br>
                                            <span class="icon">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <span class="total">
                                                {{cambioFacturaDinero.cambio | number:0}}
                                            </span>
                                        </th>
                                    </tr>
                                    <tr class="table-success">
                                        <!-- <th colspan="8"></th> -->
                                        <th class=" dinero cambio ">Total <br>
                                            <span class="icon">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <span class="total"> {{totalapagar | number:0}}</span>
                                        </th>
                                    </tr>
                                    <?php 
								 if ($_SESSION['tipo']==0) {

							echo '<tr>
								
								<th class=" dinero cambio">Ganacia  <br>
								<span class="icon">
											<i class="material-icons">attach_money</i>
								</span> 
								<span class="total">{{totalganacia | number:0}}</span></th>
							</tr>';
						}
							 ?>
                                    <tr>
                                        <th>
                                            <div class="row">
                                                <div ng-if="ContraDescuentroBotonFacturar==1" align="center" class="col-md-12">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block " ng-click="guardarFacturaPress(insertClientes,cambioFacturaDinero)">
                                                        <i class="material-icons">play_for_work</i> Facturar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div ng-if="ContraDescuentroBotonFacturar==1" align="center" class="col-md-12">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block " ng-click="guardarFacturaElec(insertClientes,cambioFacturaDinero)">
                                                        <i class="material-icons">play_for_work</i> Factura Electrónica
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row" ng-if="vistaCredito==false">
                                                <div ng-if="ContraDescuentroBotonFacturar==1" align="center" class="col-md-12">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block " ng-click="creditoAddDatos()">
                                                        <i class="material-icons">play_for_work</i> Credito
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row" ng-if="vistaCredito==true">
                                                <div ng-if="ContraDescuentroBotonFacturar==1" align="center" class="col-md-12">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block " ng-click="guardar_credito(insertClientes,cambioFacturaDinero)">
                                                        <i class="material-icons">play_for_work</i> Credito
                                                    </button>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div ng-if="ContraDescuentro==1" class="col-md-10">
                                <h4>Para realizar el descuento debe ingresar la contraseña</h4>
                                <label for="">Contraseña </label><input type="password" name="passCurioso" ng-keypress="validarContraDescuento(e,clave)" placeholder="Ingrese su contraseña" class="form-control input-sm" ng-model="clave" id="conta">
                            </div>
                            <table class="table table-hover" ng-if="vistaCredito==true">
                                <thead>
                                    <tr>
                                        <!-- <th colspan="8"></th> -->
                                        <th class="dinero">
                                        <th class="dinero cambio"><span>Aumento</span>
                                            <input type="text" onclick="javascript: limpia(this);" onfocus="javascript: limpia(this);"  class="form-control cambio" onkeyup="format(this)" onchange="format(this)" ng-model="cambioFacturaDinero.ValorAumento" id="dinero">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="">
                                        <th class=" "><span>Inicio</span>
                                            <input type="date" class="form-control " ng-model="cambioFacturaDinero.fechaInicio">
                                        <th class=" "><span>Final</span>
                                            <input type="date" class="form-control " ng-model="cambioFacturaDinero.fechaFinal">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="">
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row tarjeta">
                            <div class="col-md-12">
                                <div class="cliented">
                                    <!-- <div class="card card-profile"> -->
                                    <!-- <div class="card-avatar"> -->
                                    <!-- <a href="#pablo"> -->
                                    <div ng-if="ultimaFacturaDatos==''" class="col-md-12 textos">
                                        <h2>No hay Datos</h2>
                                    </div>
                                    <div ng-repeat="listado in filterultimaFacturaDatos = (ultimaFacturaDatos)|  limitTo:25:25*(pageultimaFacturaDatos-1)" ng-if="ultimaFacturaDatos!=''" ng-if="ultimaFacturaDatos!=''" class="facturadt facturad">
                                        <img class="imgfacturad" src="img/factura.png" data-toggle="modal" data-target="#modal-vistafactudetalleUltimaFactura" ng-click="verdetalleFacturaSelect(listado.id_factura)">
                                        <p class="text_des"> {{listado.codigo_factura}} - {{listado.nombre_cliente}}</p>
                                        <img class="imgfacturad" src="img/factura2.png"  ng-click="generarfactura(listado.id_factura)">
                                    </div>
                                </div>
                                <!-- </div> -->
                                <!-- </div> -->
                                <!-- ================================================= -->
                            </div>
                        </div>
                        <div class="row tarjeta">
                            <div class="col-md-12">
                                <div class="cliented">
                                    <img class="imgCircule" src="img/user.png" data-toggle="modal" data-target="#myModalADDCLIENTE">
                                    <!--  <input type="text" class="cambioViewCliente" value="{{insertClientes.nombre_clientes}}" disabled=""> -->
                                    <div class=" btn_sesion">
                                        <li class="dropdown mega-dropdown btn_li">
                                            <a href="" class="btn_log btn btn-info btn-sm btn-tabla" class="dropdown-toggle" data-toggle="dropdown" ng-click="verificarStock(listado.id_producto)">
                                                <p class="text_des">{{insertClientes.nombre_clientes}}</p> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu  mega-dropdown-menu  row">
                                                <li>
                                                    <div class="col-md-12">
                                                        <form id="guardarcliente" name="guardarcliente">
                                                            <div class="col-md-12">
                                                                <div class="form-group bmd-form-group">
                                                                    <label class="bmd-label-floating">Cedula o Nit</label>
                                                                    <input type="text" placeholder="C.c" class="form-control" ng-model="insertarCliente.ccCliente" name="ccCliente">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group bmd-form-group">
                                                                    <label class="bmd-label-floating">Nombre</label>
                                                                    <input type="text" placeholder="Nombre" class="form-control input-sm" ng-model="insertarCliente.nombreCliente" name="nombreCliente">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group bmd-form-group">
                                                                    <label class="bmd-label-floating">Direccion</label>
                                                                    <input type="text" placeholder="Direccion" class="form-control input-sm" ng-model="insertarCliente.direccionCliente" name="direccionCliente">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group bmd-form-group">
                                                                    <label class="bmd-label-floating">Telefono</label>
                                                                    <input type="text" placeholder="Telefono" class="form-control input-sm" ng-model="insertarCliente.telefonoCliente" name="telefonoCliente">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-info btn-sm" ng-click="guardarCliente(insertarCliente)" data-dismiss="modal">Guardar</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </div>
                                    <img class="imgCircule" src="img/search2.png" data-toggle="modal" data-target="#modal_clientes_Factura">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="container-3">
                                    <span class="icon"><i class="material-icons">search</i></span>
                                    <input type="search" placeholder="Busqueda General..." id="search" placeholder="Buscar..." name="id_producto" ng-model="filtroClientesIngreso" ng-keypress="seleccionarCliente(e,cc,insertClientes)">
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ident</th>
                                            <th>Cliente</th>
                                            <th>Add</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="listado in filterDatProducclientFactura = (listadodetodos_clientesFactu | filter : filtroClientesIngreso) | limitTo:5:5*(pagelistadodetodos_clientesFactu-1)">
                                            <td>{{listado.cc_cliente}}</td>
                                            <td>{{listado.nombre_cliente}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarClienteFactura(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,insertClientes)">+</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- <div align="center"> -->
                        <!-- <div class="row tarjeta" > -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <!-- 		<div class="col-md-4">
		<button type="button" class="btn btn-info btn-md" ng-click="guardarCotizacion(insertClientes)">
		<span class="icon-doc"></span> Cotizacion
		</button>
	</div> -->
            <div class="row">
                <div id="myModalADDCLIENTE" class="modal " role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="tt_modal">Crear Cliente</h2>
                            </div>
                            <div class="modal-body">
                                <form id="guardarcliente" name="guardarcliente">
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Cedula o Nit</label>
                                            <input type="text" placeholder="C.c" class="form-control" ng-model="insertarCliente.ccCliente" name="ccCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Nombre</label>
                                            <input type="text" placeholder="Nombre" class="form-control input-sm" ng-model="insertarCliente.nombreCliente" name="nombreCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Direccion</label>
                                            <input type="text" placeholder="Direccion" class="form-control input-sm" ng-model="insertarCliente.direccionCliente" name="direccionCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Telefono</label>
                                            <input type="text" placeholder="Telefono" class="form-control input-sm" ng-model="insertarCliente.telefonoCliente" name="telefonoCliente">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-info btn-sm" ng-click="guardarCliente(insertarCliente)" data-dismiss="modal">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--modal agregar codigo de barras-->
        <div id="myModalAddBarra" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Productos</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h2 align="center">{{barraView}}</h2>
                        </div>
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
                                                    <button type="button" class="btn btn-info btn-sm" ng-click="addBarraProductoActualizar(listado.id_producto,barraView)">Agregar</button>
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
        <!--Fin modal de codigo de barras-->
        <div id="modal-vistafactudetalleUltimaFactura" class="modal " role="dialog">
            <div class="modal-dialog ta_modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal"><strong> Detalles Factura</strong> </h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Datos Usuario</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="t-border">
                                                <th>Cod. Factura</th>
                                                <th>Fecha Factura</th>
                                                <th>Cc Cliente</th>
                                                <th>Cliente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-dark">
                                                <td><strong> {{var_codigo_factura}}</strong> </td>
                                                <td><strong> {{var_fecha_factura}}</strong> </td>
                                                <td><strong> {{var_cc_cliente}}</strong> </td>
                                                <td><strong> {{var_nombre_cliente}}</strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4><strong> Datos Factura</strong> </h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead class="t-border">
                                            <tr>
                                                <th>Codigo Producto</th>
                                                <th>Producto</th>
                                                <th>Precentación</th>
                                                <th>Caja</th>
                                                <th>Und</th>
                                                <th>iva</th>
                                                <th>valor_venta</th>
                                                <th>Valor Pago</th>
                                                <th>Vendedor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturas)">
                                                <td>{{listado.codigo_producto}}</td>
                                                <td>{{listado.descripcion}}</td>
                                                <td>{{listado.presentacion}}</td>
                                                <td>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">{{listado.cantidad}}</div>
                                                </td>
                                                <td>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">{{listado.cantidadFraccion}}</div>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion==0">{{listado.cantidad}}</div>
                                                </td>
                                                <td class="table-warning">${{listado.ivaVal}}/({{listado.iva}}%)</td>
                                                <td class="table-info">${{listado.valor_venta | number:0}}</td>
                                                <td class="table-success">${{listado.total_pago | number:0}}</td>
                                                <td class="table-success">
                                                    <div class="card-avatar" align="center">
                                                        <!-- <a href="#pablo"> -->
                                                        <img class="imgCircule" src="{{listado.img}}">
                                                        <!-- </a> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <th colspan="8"><span class="total-d"><strong> ${{var_valor_pago | number:0}}</strong> </span></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
						<h3>Total a pagar: <span class="letra"><strong> ${{var_valor_pago | number:0}}</strong> </span></h3>
						
					</div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div id="modalbasediario" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Base Diaria</h2>
                    </div>
                    <div class="modal-body">
                    <?php 
								 if ($_SESSION['tipo']==0) {

							echo '
                         <div class="col-md-12 col-espacio">
                        
                                <label for="">valor </label>
                                <input type="text" class="form-control btn-sm" name="valor_venta" id="valor_venta" ng-model="insertBaseDIaria.valor_Diario" >
                            </div>
                             <div class="col-md-12">
                                    <button type="button" class="btn btn-info btn-sm" ng-click="guardarBaseDiaria(insertBaseDIaria)" data-dismiss="modal">Guardar</button>
                                </div>';
                            }else{
                                echo'<h1 class="mx-auto d-block"> ¡Por favor!, Solicita al Administrador ingresar la base del dia</h1> ';
                            }
                            ?>
                        
                    </div>
                </div>
            </div>
        </div>';
  
        <!-- ========================================================================================================================================= -->
        <!-- Ininio ventana modal de clientes -->
        <div id="modal_clientes_Factura" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Clientes</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="container-3">
                                    <span class="icon"><i class="material-icons">search</i></span>
                                    <input type="search" class="form-control input-sm" id="search" placeholder="Buscar..." name="id_producto" ng-model="filtroClientesIngreso">
                                </div>
                            </div>
                            <!-- 	<div class="container-3">
						<span class="icon"><i class="material-icons">search</i></span>
						<input type="search" class="form-control input-sm" id="search" placeholder="Buscar..." name="id_producto"  ng-model="filtroClientesIngreso">
					</div>
 -->
                            <div class="col-md-12">
                                <uib-pagination class="pagination-mod" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Identificación</th>
                                                <th>Nombre Cliente</th>
                                                <th>Agregar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listado in filterDatProducclientFactura = (listadodetodos_clientesFactu | filter : filtroClientesIngreso) | limitTo:20:20*(pagelistadodetodos_clientesFactu-1)">
                                                <td>{{listado.cc_cliente}}</td>
                                                <td>{{listado.nombre_cliente}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarClienteFactura(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,insertClientes)">Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin ventana modal de clientes -->
        <!-- Ininio ver agregar nuevos producto y cantidad -->
        <div id="modal-agregar_productoFactura" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Agregar Productos</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-espacio">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-productoFactura"><span class="icon-cart-arrow-down"></span>Agregar Producto</button>
                            </div>
                            <div class="col-md-4">
                                <label for="">Codigo</label>
                                <input type="hidden" name="id_productoFactura" id="id_productoFactura" ng-model="agregarInsertProduFactura.id_productoFactura">
                                <input type="text" class="form-control btn-sm" name="codigo_productoFactura" id="codigo_productoFactura" ng-model="agregarInsertProduFactura.codigo_productoFactura" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="">producto</label>
                                <input type="text" class="form-control btn-sm" name="nombre_productoFactura" id="nombre_productoFactura" ng-model="agregarInsertProduFactura.nombre_productoFactura" disabled>
                            </div>
                            <div class="col-md-4 col-espacio">
                                <label for="">valor Unidad</label>
                                <input type="text" class="form-control btn-sm" name="valor_venta" id="valor_venta" ng-model="agregarInsertProduFactura.valor_venta" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="">Cantidad de Productos</label>
                                <input type="number" class="form-control btn-sm" name="cantidad_productoFactura" id="cantidad_productoFactura" ng-model="agregarInsertProduFactura.cantidad_productoFactura" ng-keypress='agregarProductoFactura(e,agregarInsertProduFactura)'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin ver agregar nuevos producto y cantidad -->
        <!-- Ininio ver agregar nuevos producto y cantidad -->
        <div id="myModalSerial" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Agregar Serial</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="">
                                <input type="text" class="form-control input-sm" placeholder="Buscar Producto..." name="id_producto" id="id_producto" ng-model="filtroSerial">
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <label>Codigo Producto : </label><span>{{CodigoProductoSerial}}</span>
                                </div>
                                <div class="col-md-4">
                                    <label>Nombre : </label><span> {{nombreProductoSerial}}</span>
                                </div>
                                <div class="col-md-3">
                                    <label>Valor : </label><span> {{valorVentaProductoSerial}}</span>
                                </div>
                                <!-- <div class="col-md-4"> -->
                                <!-- <label>Periodo  : </label><span> {{year}} - {{periodo}} </span> -->
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Escoger</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listadoSerial in filterDat = (listadodetodos_ProductoSeriales | filter : filtroSerial) | limitTo:20:20*(pagelistadodetodos_ProductoSeriales-1)">
                                                <td>{{listadoSerial.serial}}</td>
                                                <<!-- td>{{listadoSerial.nombre_cliente}}</td> -->
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" ng-click="agregarSerialFactura(listadoSerial.id_productoserial,id_ProductoSerial,nombreProductoSerial,listadoSerial.serial)">Agregar</button>
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
        <!-- fin ver agregar nuevos producto y cantidad -->
        <!-- Ininio ventana modal de productos -->
        <div id="modal-productoFactura" class="modal " role="dialog">
            <div class="modal-dialog ta_modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Productos</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="text" class="form-control input-sm" placeholder="Buscar..." name="id_producto" id="id_producto" ng-model="filtroProductoIngreso">
                            </div>
                            <div class="col-md-12">
                                <uib-pagination class="pagination-mod" total-items="filterDatProducIngreso.length" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre Producto</th>
                                                <th>nombre_categoria</th>
                                                <th>codigo</th>
                                                <th>Agregar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
                                                <td>{{listado.nombre}}</td>
                                                <td>{{listado.nombre_categoria}}</td>
                                                <td>{{listado.codigo_producto}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarProductofacturaForm(listado.id_producto,listado.nombre,listado.codigo_producto,listado.valor_venta,agregarInsertProduFactura)">
                                                        <span class="icon-cart-plus"></span>Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin ventana modal de productos -->
    </uib-tab>
    <!-- --------------------- SEGUNDO TAP  -->
    <uib-tab index="1">
        <uib-tab-heading>
            <i class="material-icons">
                format_list_bulleted
            </i>
            Lista de Facturas
        </uib-tab-heading>
        <div class="row">
            <!-- 	<div class="col-md-6">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Codigo Factura</h4>
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="number" class="form-control" name="codigoFactura" id="codigoFactura" ng-model="busquedadFactura" ng-keypress="FacturaxCodigo(e,busquedadFactura)">
				</div>
			</div>
		</div>
	</div>
 -->
            <!-- <div class="col-md-4 animate-div">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Rango de Fechas</h4>
			</div>
			<div class="card-body">
				<div class="col-md-12">
					<label for="">Fecha Inical</label>
					<input type="date" class="form-control" name="fechaInicialFactura" id="fechaInicialFactura" ng-model="agregarbusquedaFacturaXf.fechaInicialFactura">
				</div>
				<div class="col-md-12">
					<label for="">Fecha Final</label>
					<input type="date" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="agregarbusquedaFacturaXf.fechaFinalFactura">
				</div>
				<button type="button" class="btn btn-info btn-sm" ng-click="buscarfacturaXfecha(agregarbusquedaFacturaXf)"><i class="material-icons"> search</i>Buscar</button>
			</div>
		</div>
	</div> -->
            <!-- <div class="col-md-2">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">today</i>
				</div>
				<h4 class="card-title">Fecha Final</h4>
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="date" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="agregarbusquedaFacturaXf.fechaFinalFactura">
				</div>
			</div>
			
		</div>
	</div> -->
            <!-- <div class="col-md-2">
	<button type="button" class="btn btn-info btn-sm" ng-click="buscarfacturaXfecha(agregarbusquedaFacturaXf)"><i class="material-icons"> search</i>Buscar</button>
</div> -->
        </div>
        <!-- <div class="col-md-12">
	<button type="button" class="btn btn-info" ng-click="generar_reportePDFfacturaXfecha(agregarbusquedaFacturaXf)">Generar Reporte</button>
</div> -->

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
        <div class="col-md-12" ng-show="fromVisibility">
            <div class="card ">
                <div class="card-header card-header-rose card-header-text">
                    <!-- jar -->
                    <!-- 		<div class="row fechas"> 
				<div class="col-md-3">
					<label class="fi">Fecha Inical</label>
					<input type="text" class="form-control" name="fechaInicialFactura" id="fechaInicialFactura" ng-model="agregarbusquedaFacturaXf.fechaInicialFactura" placeholder="Año-Mes-Dia">
				</div>
				<div class="col-md-6 btn-buscar">
					<button type="button" class="btn btn-info" ng-click="buscarfacturaXfecha(agregarbusquedaFacturaXf)"><i class="material-icons">search</i></button>
				</div>
				<div class="col-md-3">
					<label class="fi">Fecha Final</label>
					<input type="text" class="form-control" name="fechaFinalFactura" id="fechaFinalFactura" ng-model="agregarbusquedaFacturaXf.fechaFinalFactura" placeholder="Año-Mes-Dia">
				</div>
				

			</div> -->
                    <div class="row">
                        <div class="head-buscador col-md-6">
                            <div class="col-md-12">
                                <div class="container-3">
                                    <span class="icon"><i class="material-icons">search</i></span>
                                    <input type="search" placeholder="Facturas normales" id="search" name="id_producto" ng-model="filtroProductoIngresofac" ng-keypress="FacturaxCodigo(e,filtroProductoIngresofac)">
                                </div>
                            </div>
                            <div class="col-md-12 paginacion">
                                <uib-pagination class="pagination-mod" total-items="filterfacturXfechaRango.length" max-size="5" class="pagination-sm" boundary-links="true" ng-model="pagelistadofacturasXfechasDos" ng-change="paginalistadofacturasXfechasDos()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
                            </div>
                        </div>
                        <!-- buscador factura credito -->
                        <div class="head-buscador col-md-6">
                            <div class="col-md-12">
                                <div class="container-3">
                                    <span class="icon"><i class="material-icons">search</i></span>
                                    <input type="search" placeholder="Facturas Creditos" id="search" name="id_producto" ng-model="filtroLiistaPl" ng-keypress="buscarCreditoporcodigo(e,filtroLiistaPl)">
                                </div>
                            </div>
                            <div class="col-md-12 paginacion">
                                <uib-pagination class="pagination-mod" total-items="filterRangoFechasPl.length" max-size="5" class="pagination-sm" boundary-links="true" ng-model="pageListaPlanesDados" ng-change="paginaListaPlanesDados()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
                            </div>
                        </div>
                    </div>
                    <!-- buscador factura credito -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                    <tr class="t-completa">
                                        <th>Vend</th>
                                        <th>Cod Fac</th>
                                        <th>Ident</th>
                                        <th>Nombres</th>
                                        <th style="font-size: 10">Fecha</th>
                                        <th>Hora</th>
                                        <th class="text-cen-table">Ope</th>
                                    </tr>
                                </thead>
                                <tbody class="tbl-normal">
                                    <tr ng-repeat="listado in filterfacturXfechaRango = (listadofacturasXfechasDos | filter : filtroProductoIngresofac )|  limitTo:10:10*(pagelistadofacturasXfechasDos-1)">
                                        <td>
                                            <div class="card-avatar" align="center">
                                                <!-- <a href="#pablo"> -->
                                                <img class="imgCircule" src="{{listado.img}}">
                                                <!-- </a> -->
                                            </div>
                                        </td>
                                        <td>{{listado.codigo_factura}}</td>
                                        <td>{{listado.cc_cliente}}</td>
                                        <td>{{listado.nombre_cliente}}</td>
                                        <td>{{listado.fecha_factura}}</td>
                                        <td>{{listado.hora}}</td>
                                        <td class="text-cen-table">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalle" title="Detalle Factura" ng-click="verdetalleFacturaSelect(listado.id_factura)"><i class="material-icons">details</i></button>
                                            <button type="button" class="btn btn-success btn-sm" ng-click="generarfactura(listado.id_factura)"><i class="material-icons" title="Factura">receipt</i></button><button type="button" title="Ticket" class="btn btn-warning btn-sm" ng-click="generarfacturaWord(listado.id_factura)"><i class="material-icons">print</i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModaDevolucion" title="Eliminar" ng-click="DevolucionTotal(listado.id_factura,listado.codigo_factura,listado.cc_cliente,listado.nombre_cliente,listado.fecha_factura)"><i class="material-icons">delete_forever</i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="t-completa">
                                        <th>Vend</th>
                                        <th>Cod. Cred</th>
                                        <!-- <th>Ident</th> -->
                                        <th>Nombres</th>
                                        <th style="font-size: 10">Fecha</th>
                                        <th>Tot/Deu</th>
                                        <th>Estado</th>
                                        <th class="text-cen-table">Ope</th>
                                    </tr>
                                </thead>
                                <tbody class="tbl-normal">
                                    <!-- <tr ng-repeat="listado in filterfacturXfechaRango = (ListaPlanesDados | filter : filtroProductoIngreso)"> -->
                                    <tr ng-repeat="listado in filterRangoFechasPl = (ListaPlanesDados | filter : filtroLiistaPl | filter: filtroLiistaPl2 |  orderBy:'-') | limitTo:10:10*(pageListaPlanesDados-1)">
                                        <td>
                                            <div class="card-avatar" align="center">
                                                <!-- <a href="#pablo"> -->
                                                <img class="imgCircule" src="{{listado.img}}">
                                                <!-- </a> -->
                                            </div>
                                        </td>
                                        <td>{{listado.codigoCredito}}</td>
                                        <!-- <td>{{listado.cc_cliente}}</td> -->
                                        <td>{{listado.nombre_cliente}}</td>
                                        <td>
                                            <FONT SIZE=2>{{listado.fecha_inicio}}<br>{{listado.fecha_fin}}</FONT>
                                        </td>
                                        <td>${{listado.total_pagosepare | number:0}}/<br>${{listado.descuento_abonos | number:0}}</td>
                                        <td>{{listado.estado}}/<br>{{listado.estadocredito}}</td>
                                        <td class="text-cen-table">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-detallePagos_planSeare" title="Detalle Credito" ng-click="verdetalleCredito(listado.id_credito,listado.id_cliente)"><i class="material-icons">details</i></button>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_cuotas_listaPlansepare" title="Abonos" ng-click="cuotas_listacredito(listado.descuento_abonos,listado.id_credito,listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,cuotas_credito)"><i class="material-icons">receipt</i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" title="Ticket" ng-click="generarfacturaCreditoWord(listado.id_credito)"><i class="material-icons">print</i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-ConfirmEliminacionPlansepare" title="Eliminar" ng-click="Confirmaeliminar_ProductoCreditoreXfechas(listado.id_credito,listado.id_cliente,listado.fecha_inicio,listado.fecha_fin,listado.estadoproductos,confirmaeliminacionPlan)"><i class="material-icons">delete_forever</i></button>
                                        </td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-detallePagos_planSeare" class="modal" role="dialog">
            <div class="modal-dialog ta_modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Detalles de Cuotas de Pago </h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Identificacion:</th>
                                            <td>{{cc_cliente_sql}}</td>
                                            <th>Nombre Cliente:</th>
                                            <td>{{nombre_cliente_sql}}</td>
                                            <th>Tota Apagar:</th>
                                            <td>$ {{total_pagosepare_sql | number:0}}</td>
                                        </tr>
                                        <tr>
                                            <th>Valor Aumento</th>
                                            <td>$ {{valor_aumetoplansepare_sql | number:0}}</td>
                                            <th>Fecha de Inicio</th>
                                            <td>{{fecha_inicio_sql}}</td>
                                            <th>Fecha Fin</th>
                                            <td>{{fecha_fin_sql}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- listado de producto del plan separe -->
                            <div class="col-md-12">
                                <h2 align="center">Productos del Credito</h2>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Codigo Producto </th>
                                                <th>Nombre </th>
                                                <th>Nombre Categoria </th>
                                                <th>Valor Venta </th>
                                                <th>Cantidad </th>
                                                <th>Valor actual producto </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbl-normal">
                                            <tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaPagosPlanes)">
                                                <td>{{listado.codigo_producto}}</td>
                                                <td>{{listado.descripcion}}</td>
                                                <td>{{listado.nombre_categoria}}</td>
                                                <td>$ {{listado.valor_venta | number:0}}</td>
                                                <td>{{listado.cantidad}} / {{listado.cantidadFraccion}}</td>
                                                <td>$ {{listado.valor_actual_producto | number:0}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- listado de cuotas pagadas al plan separa  -->
                            <div class="col-md-12">
                                <h2 align="center">Datos Pago</h2>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Valor Pago</th>
                                                <th>Fecha Abono</th>
                                                <th>Detalle</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbl-normal">
                                            <tr ng-repeat="listado in filterlistacuotaPlansepare = (ListaProductosPlanSepare)">
                                                <td><span class="tbl-text badge badge-info"> ${{listado.valor_abono | number:0}}</span></td>
                                                <td>{{listado.fecha_abono}}</td>
                                                <td><label>Detalle de Credito:
                                                        <input type="checkbox" ng-model="checkboxModel.value1">
                                                    </label></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-actualizacionCuotaplansepare" ng-click="verinformacionCuotaActualizarCredito(listado.id_abonos_credito,listado.id_credito,listado.valor_abono,listado.id_cliente,listado.descuento_abonos,actualizacion_cuotas_credito)" data-dismiss="modal"><i class="material-icons">replay</i></button>
                                                    <button type="button" class="btn btn-success btn-sm" ng-click="imprimmirRecibocuptaCredito(listado.id_abonos_credito,listado.id_credito,id_cliente_sql,checkboxModel.value1)"><i class="material-icons">print</i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4 offset-md-8">
                                <div class="card card-stats">
                                    <div class="table-responsive">
                                        <table class="table table-no-bordered">
                                            <tbody class="tbl-normal">
                                                <tr>
                                                    <th>Total A Pagar </th>
                                                    <th>
                                                        <h4 class="tbl-text badge badge-pill badge-info">$ {{total_pagosepare_sql | number:0}}</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total Deuda</th>
                                                    <th>
                                                        <h4 class="tbl-text badge badge-pill badge-info"> $ {{descuento_abonos_sql | number:0}}</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total Abonos</th>
                                                    <th>
                                                        <h4 class="tbl-text badge badge-pill badge-info"> $ {{sumacuotas | number:0}}</h4>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
					<h6>Total Apagar: <span class="letra">{{total_pagosepare_sql}}</span></h6>
				</div>
				<div class="col-md-4">
					<h6>Total Deuda: <span class="letra">{{descuento_abonos_sql}}</span></h6>
				</div>
				<div class="col-md-3">
					<h6>Total Abonos: <span class="letra">{{sumacuotas}}</span></h6>
				</div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-actualizacionCuotaplansepare" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Actualizar Cuotas Credito</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Cuota Anterior</label>
                                <input type="text" class="form-control input-sm" name="cuotaanterior" id="cuotaanterior" ng-model="actualizacion_cuotas_credito.cuotaanterior" disabled>
                            </div>
                            <div class="col-md-6 col-espacio">
                                <label for="">Nueva Cuota</label>
                                <input type="hidden" name="id_abonos_credito" id="id_abonos_credito" ng-model="actualizacion_cuotas_credito.id_abonos_credito" disabled>
                                <input type="hidden" name="id_credito" id="id_credito" ng-model="actualizacion_cuotas_credito.id_credito" disabled>
                                <input type="hidden" name="descuento_abonos" id="descuento_abonos" ng-model="actualizacion_cuotas_credito.descuento_abonos" disabled>
                                <input type="number" class="form-control input-sm" name="nuevacuota" placeholder="identificación" id="nuevacuota" ng-model="actualizacion_cuotas_credito.nuevacuota">
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info btn-md" data-dismiss="modal" ng-click="actualizar_CuotaCredito(actualizacion_cuotas_credito,listar_credito)">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal_cuotas_listaPlansepare" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Pago Cuotas Credito</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Identificacion</th>
                                            <th>Nombre Cliente</th>
                                            <th>Deuda Actual</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="id_cliente" id="id_cliente" ng-model="cuotas_credito.id_cliente">
                                                <span>{{cuotas_credito.identificacion}}</span>
                                            </td>
                                            <td>
                                                <span>
                                                    {{cuotas_credito.nombre_clientes}}
                                                </span>
                                            </td>
                                            <td><span class="tbl-text badge badge-info">${{cuotas_credito.deuda_actual}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Pago</th>
                                            <td><input type="text" class="form-control" name="pagocuota_plansepare" id="pagocuota_plansepare" ng-model="cuotas_credito.pagocuota_plansepare"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col-md-6">
					<label for="">cc cliente</label>
					<input type="hidden" name="id_cliente" id="id_cliente" ng-model="cuotas_credito.id_cliente">
					<input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="cuotas_credito.identificacion" disabled>
					
				</div>
				<div class="col-md-6">
					<label for="">nombre cliente</label>
					<input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="cuotas_credito.nombre_clientes" disabled>
					
				</div>
				<div class="col-md-4">
					<label for="">Deuda Actual</label>
					<input type="text" class="form-control" name="deuda_actual" id="deuda_actual" ng-model="cuotas_credito.deuda_actual" disabled>
					<input type="hidden" class="form-control" name="id_credito" id="id_credito" ng-model="cuotas_credito.id_credito" >
				</div>
				<div class="col-md-4">
					<label for="">Pago</label>
					<input type="text" class="form-control" name="pagocuota_plansepare" id="pagocuota_plansepare" ng-model="cuotas_credito.pagocuota_plansepare">
					
				</div> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="footer-centrado">
                            <button type="button" class="btn btn-info btn-md aceptar" data-dismiss="modal" ng-click="guardar_CuotaPagoCredito(cuotas_credito,listar_credito)"> Guardar</button>
                            <button type="button" class="btn btn-warning cancelar" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-ConfirmEliminacionPlansepare" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Eliminar Credito</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id_credito" id="id_credito" ng-model="confirmaeliminacionPlan.id_credito" disabled>
                                <input type="hidden" name="id_cliente" id="id_cliente" ng-model="confirmaeliminacionPlan.id_cliente" disabled>
                                <input type="hidden" name="fechaInicialPansepare" id="fechaInicialPansepare" ng-model="confirmaeliminacionPlan.fechaInicialPansepare" disabled>
                                <input type="hidden" name="fechaFinalPansepare" id="fechaFinalPansepare" ng-model="confirmaeliminacionPlan.fechaFinalPansepare" disabled>
                                <input type="hidden" class="form-control input-sm" name="estadoproductos" placeholder="estadoproductos" id="estadoproductos" ng-model="confirmaeliminacionPlan.estadoproductos">
                            </div>
                            <div class="col-md-12">
                                <h3>
                                    Realmente desea eliminar el plan separe seleccionado,<b> toda la información se perderá</b>; por favor verifique que no tenga cuotas o que el producto ya se ha entregado
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-sm" ng-click="eliminar_ProductoCreditoXfechas(confirmaeliminacionPlan)" data-dismiss="modal">
                                    <span class="icon-doc"></span> Aceptar
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    <!--  <div class="modal-footer">
																							<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
		</div> -->
                </div>
            </div>
        </div>
        <!-- Ininio ventana de confimacion de eliminacion del ingreso -->
        <div id="modal-vistafactudetalle" class="modal " role="dialog">
            <div class="modal-dialog ta_modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <button type="button" ng-click="detalleFacturaAnt(var_id_factura)">&lsaquo;</button>
                        <button type="button" ng-click="detalleFacturaSig(var_id_factura)">&rsaquo;</button>
                        <h2 class="tt_modal">Detalles factura</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3> <strong>Datos Usuario</strong> </h3>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod. Factura</th>
                                                <th>Fecha Factura</th>
                                                <th>Hora</th>
                                                <th>Cc Cliente</th>
                                                <th>Nombre Cliente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{var_codigo_factura}}</td>
                                                <td>{{var_fecha_factura}}</td>
                                                <td>{{var_hora_factura}}</td>
                                                <td>{{var_cc_cliente}}</td>
                                                <td>{{var_nombre_cliente}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3><strong> Datos Factura</strong> </h3>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Vendedor</th>
                                                <th>Codigo Producto</th>
                                                <th>Nombres Producto</th>
                                                <th>Categoria</th>
                                                <th>Caja</th>
                                                <th>Und</th>
                                                <!-- <th>Fraccion</th> -->
                                                <th>Valor Pago</th>
                                                <th>Descuento</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbl-normal">
                                            <tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturas)">
                                                <td>
                                                    <div class="card-avatar" align="center">
                                                        <!-- <a href="#pablo"> -->
                                                        <img class="imgCircule" src="{{listado.img}}">
                                                        <!-- </a> -->
                                                    </div>
                                                </td>
                                                <td>{{listado.codigo_producto}}</td>
                                                <td>{{listado.descripcion}} {{listado.presentacion}} </td>
                                                <td>{{listado.nombre_categoria}}</td>
                                                <td><span ng-if="listado.fraccion!=0">{{listado.cantidad}}</span></td>
                                                <td>
                                                    <span ng-if="listado.fraccion!=0">{{listado.cantidadFraccion}}</span>
                                                    <span ng-if="listado.fraccion==0">{{listado.cantidad}}</span>
                                                </td>
                                                <!-- <td>{{listado.valor_venta}}</td> -->
                                                <td class="table-info">${{listado.total_pago | number:0}}</td>
                                                <td class="table-info">${{listado.descuento | number:0}}</td>
                                                <td><button type="button" class="btn btn-warning btn-sm" ng-click="SuccessDevolucionUnidad(listado.id_factura,listado.id_detalleFactura,var_codigo_factura)"><span class="icon-file-pdf"></span>Dev</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4 offset-md-8">
                                <div class="card card-stats">
                                    <table class="table table-no-bordered">
                                        <tbody class="tbl-normal">
                                            <tr>
                                                <th>Subtotal</th>
                                                <th>
                                                    <h4 class="tbl-text badge badge-pill badge-info ng-binding"> ${{var_valor_pagoSub | number:0}}</h4>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Descuento</th>
                                                <th>
                                                    <h4 class="tbl-text badge badge-pill badge-info ng-binding"> ${{var_valor_descuento | number:0}}</h4>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <th>
                                                    <h4 class="tbl-text badge badge-pill badge-info ng-binding"> ${{var_valor_pago | number:0}}</h4>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Ganancias</th>
                                                <th>
                                                    <?php 
					 if ($_SESSION['tipo']==0) {
            
            
            echo '
					
						<h4 class="tbl-text badge badge-pill badge-info ng-binding">${{var_ganancia | number:0}}</h4>';
				}
					 ?>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
						<h3>SubTotal: <span class="letra"> <strong> ${{var_valor_pagoSub | number:0}}</strong></span></h3>
					</div>	
					<div class="col-md-12">
						<h3>Descuento: <span class="letra "> <strong> ${{var_valor_descuento | number:0}}</strong></span></h3>
						
					</div>	
					<div class="col-md-12">
						<h3>Total: <span class="letra "> <strong> ${{var_valor_pago | number:0}}</strong></span></h3>
						
					</div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin ventana de confimacion de eliminacion del ingreso -->
        <div id="myModaDevolucion" class="modal " role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Devoluciones</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 align="center">Factura : {{codigo_facturaD}} </h2>
                                <h4 align="center">Realmente Desea Devolver Todos los Productos Adquiridos por esta Factura con fecha de <strong>{{fecha_facturaD}} </strong> por el cliente <strong>{{nombre_clienteD}} </strong> con cedular<strong> {{cc_clienteD}} </strong></h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="footer-centrado">
                            <button type="button" class="btn btn-info btn-sm" ng-click="SuccessDevolucionTotal(id_facturaD,codigo_facturaD)" data-dismiss="modal">Procesar</button>
                            <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </uib-tab>
    <!-- ---------------- TECER ITEMS -->
    <uib-tab index="2" heading="Facturas por Clientes">
        <uib-tab-heading>
            <i class="material-icons">
                contacts
            </i>
            Facturas Por Clientes
        </uib-tab-heading>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon card-header-rose">
                    <div class="card-icon">
                        <i class="material-icons">account_box</i>
                    </div>
                    <h4 class="card-title">Cliente</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-6">
                        <input type="hidden" name="id_cliente" id="id_cliente" ng-model="busquedaFactXcliente.id_cliente">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" name="identificacion" placeholder="identificación" id="identificacion" ng-model="busquedaFactXcliente.identificacion" disabled>
                            <span class="input-group-btn">
                                <button type="button" id="funciona" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_clientes_BudquedasFactDetalle"> <i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control input-sm" name="nombre_clientes" placeholder="nombre" id="nombre_clientes" ng-model="busquedaFactXcliente.nombre_clientes" disabled>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <uib-pagination class="pagination-mod" total-items="filterfacturXfechaRango.length" ng-model="pagelistadofacturasXclienteSelect" ng-change="paginalistadofacturasXclienteSelect()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=25></uib-pagination>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Vendedor</th>
                            <th>Codigo Factura</th>
                            <th>Identificacion</th>
                            <th>Nombres</th>
                            <th>Fecha</th>
                            <th colspan="3">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="listado in filterfacturXfechaRango = (listadofacturasXclienteSelect | filter : filtroProductoIngreso | orderBy:'-')|  limitTo:25:25*(pagelistadofacturasXclienteSelect-1)">
                            <td>
                                <div class="card-avatar" align="center">
                                    <!-- <a href="#pablo"> -->
                                    <img class="imgCircule" src="{{listado.img}}">
                                    <!-- </a> -->
                                </div>
                            </td>
                            <td>{{listado.codigo_factura}}</td>
                            <td>{{listado.cc_cliente}}</td>
                            <td>{{listado.nombre_cliente}}</td>
                            <td>{{listado.fecha_factura}}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-vistafactudetalleClientes" ng-click="verdetalleFacturaSelect(listado.id_factura)">Ver Detalle</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" ng-click="generarfactura(listado.id_factura)"><span class="icon-file-pdf"></span>Genera Factura</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModaDevolucionCliente" ng-click="DevolucionTotal(listado.id_factura,listado.codigo_factura,listado.cc_cliente,listado.nombre_cliente,listado.fecha_factura)"><span class="icon-file-pdf"></span>Devolución</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div ng-if="listadofacturasXclienteSelect =='' " align="center">
                    <h3> {{menssageFacturaNull}} </h3>
                </div>
            </div>
        </div>
        <!-- Ininio ventana de confimacion de eliminacion del ingreso -->
        <div id="modal-vistafactudetalleClientes" class="modal" role="dialog">
            <div class="modal-dialog ta_modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal"><strong>Detalles Factura</strong> </h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>Codigo Factura</th>
                                                <th>Fecha Factura</th>
                                                <th>Cc Cliente</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><strong>
                                                    <td>{{var_codigo_factura}}</td>
                                                    <td>{{var_fecha_factura}}</td>
                                                    <td>{{var_cc_cliente}}</td>
                                                    <td>{{var_nombre_cliente}}</td>
                                                </strong>
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
                                                <th>Vendedor</th>
                                                <th>codigo producto</th>
                                                <th>Nombres producto</th>
                                                <th>categoria</th>
                                                <th>Caja</th>
                                                <th>Und</th>
                                                <th>valor Unidad</th>
                                                <th>valor pago</th>
                                                <th>Descuento</th>
                                                <th>Dev</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listado in filterfacturXfechaRango = (listadoDetallefacturas | orderBy: '-')">
                                                <td>
                                                    <div class="card-avatar" align="center">
                                                        <!-- <a href="#pablo"> -->
                                                        <img class="imgCircule" src="{{listado.img}}">
                                                        <!-- </a> -->
                                                    </div>
                                                </td>
                                                <td>{{listado.codigo_producto}}</td>
                                                <td>{{listado.descripcion}} {{listado.presentacion}}</td>
                                                <td>{{listado.nombre_categoria}}</td>
                                                <td>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">{{listado.cantidad}}</div>
                                                </td>
                                                <td>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion!=0">{{listado.cantidadFraccion}}</div>
                                                    <div class="input-tabla form-group form-group-sm" ng-if="listado.fraccion==0">{{listado.cantidad}}</div>
                                                </td>
                                                <td class="table-info">${{listado.valor_venta | number:0}}</td>
                                                <td class="table-success">${{listado.total_pago | number:0}}</td>
                                                <td class="table-info">${{listado.descuento | number:0}}</td>
                                                <td><button type="button" class="btn btn-warning btn-sm" ng-click="SuccessDevolucionUnidad(listado.id_factura,listado.id_detalleFactura,var_codigo_factura)"><span class="icon-file-pdf"></span>Dev</button></td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal</th>
                                                <th colspan="8"><span class="total-d"> <strong> ${{var_valor_pagoSub | number:0}}</strong></span></th>
                                            </tr>
                                            <tr>
                                                <th>Descuento</th>
                                                <th colspan="8"><span class="total-d"> <strong> ${{var_valor_descuento | number:0}}</strong></span></th>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <th colspan="8"><span class="total-d"> <strong> ${{var_valor_pago | number:0}}</strong></span></th>
                                            </tr>
                                            <tr>
                                                <th>Ganancias</th>
                                                <th colspan="8">
                                                    <?php 
					 if ($_SESSION['tipo']==0) {
            
            
            echo '
					
						<span class="total-d"> <strong> ${{var_ganancia | number:0}}</strong></span>';
				}
					 ?>
                                                </th>
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
        <!-- fin ventana de confimacion de eliminacion del ingreso -->
        <!-- Inicio ventana modal de clientes -->
        <div id="modal_clientes_BudquedasFactDetalle" class="modal " role="dialog">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Clientes</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="container-3">
                                    <span class="icon"><i class="material-icons">search</i></span>
                                    <input type="text" class="form-control input-sm" placeholder="Buscar..." name="id_producto" id="search" ng-model="filtroProductoIngreso">
                                </div>
                            </div>
                            <uib-pagination class="pagination-mod" total-items="filterDatProducclientFactura.length" ng-model="pagelistadodetodos_clientesFactu" ng-change="paginalistadodetodos_clientesFactu()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
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
                                                <button type="button" class="btn btn-info btn-sm" ng-click="agregarclienteBusqueDetalleFactu(listado.id_cliente,listado.cc_cliente,listado.nombre_cliente,busquedaFactXcliente)" data-dismiss="modal">Agregar</button>
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
        <div id="myModaDevolucionCliente" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Devoluciones</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 align="center">Factura : {{codigo_facturaD}} </h2>
                                <h4 align="center">Realmente Desea Devolver Todos los Productos Adquiridos por esta Factura con fecha de <strong>{{fecha_facturaD}} </strong> por el cliente <strong>{{nombre_clienteD}} </strong> con cedular<strong> {{cc_clienteD}} </strong></h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-sm" ng-click="SuccessDevolucionTotal(id_facturaD,codigo_facturaD)">Procesar</button>
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin ventana modal de clientes -->
    </uib-tab>
    <uib-tab index="3">
        <uib-tab-heading>
            <i class="material-icons">format_list_bulleted</i>
            informe de venta
        </uib-tab-heading>
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon" data-toggle="modal" data-target="#myModaInformeFecha">
                            <i class="material-icons">send</i>
                        </div>
                        <h3 class="card-title">Ventas del Dia {{fechaActual}}</h3>
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
            <div class="col-md-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-rose card-header-icon">
                            <h4 class="card-title">Mas Vendido</h4>
                        </div>
                        <div class="card-body" ng-repeat="listadodelDia in filterdelDia = (delDia)" ng-if="listadodelDia.id_producto==CodfacMax">
                            {{listadodelDia.descripcion}} ({{listadodelDia.cantidad}}: {{listadodelDia.cantidadFraccion}}) - ${{listadodelDia.TotalPago | number:0}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-rose card-header-icon">
                            <h4 class="card-title">Menos Vendidos</h4>
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
                            <canvas class="chart chart-pie" chart-data="datos2Mx" chart-labels="etiquetas2Mx">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card datos-v-s">
                    <div class="card-header card-datos">
                        <h3 class="card-title titulo"> <span class="text">${{Vtotaltotal | number:0}} </span></h3>
                        <span class="icono"><i class="material-icons">dns</i></span>
                    </div>
                    <div class="card-body">
                        <h4>Total Ventas</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card datos-utilidad">
                    <div class="card-header card-datos">
                        <h3 class="card-title titulo"> <span class="text">${{TotalGanDescuento | number:0}} </span></h3>
                        <span class="icono"><i class="material-icons">dns</i></span>
                    </div>
                    <div class="card-body">
                        <h4>Total Descuentos</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card datos-venta-u">
                    <div class="card-header card-datos">
                        <h3 class="card-title titulo"> <span class="text">${{Vtotaltotal - TotalGanDescuento | number:0}} </span></h3>
                        <span class="icono"><i class="material-icons">dns</i></span>
                    </div>
                    <div class="card-body">
                        <h4>Total Neto</h4>
                    </div>
                </div>
            </div>
            <?php
            if ($_SESSION['tipo']==0)
            {
                echo '<div class="col-md-2">
                    <div class="card datos-utilidad">
                        <div class="card-header card-datos">
                            <h3 class="card-title titulo"> <span class="text">${{TotalGanancias | number:0}} </span></h3>
                            <span class="icono"><i class="material-icons">dns</i></span>
                        </div>
                        <div class="card-body">
                            <h4>Total Ganancias</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card datos-venta-u">
                        <div class="card-header card-datos">
                            <h3 class="card-title titulo"> <span class="text">$ {{Vtotaltotal - TotalGanancias | number:0}} </span></h3>
                            <span class="icono"><i class="material-icons">dns</i></span>
                        </div>
                        <div class="card-body">
                            <h4>Total Capital</h4>
                        </div>
                    </div>
                </div>';
            }
            ?>
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
                                    <input type="text" class="form-control" ng-model="insertInformeVenta.fecha_inicio" name="fecha_inicio" placeholder="Año-Mes-Dia">
                                    <div class="form-group">
                                        <input type="text" class="form-control" ng-model="insertInformeVenta.fecha_final" name="fecha_final" placeholder="Año-Mes-Dia">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="informeVenta(insertInformeVenta)">Procesar</button>
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
                          <label for="">Fecha inicial (AÑO-MES-DIA)</label>
                          <input 
                            type="date" 
                            class="form-control" 
                            name="fechaInicialFactura" 
                            id="fechaInicialFactura" 
                            ng-model="listadoGeneral.fechaInicialFactura" 
                            ng-change="listadoGeneral.fechaInicialFactura = listadoGeneral.fechaInicialFactura.toISOString().slice(0,10)">
                        </div>
                        
                        <div class="col-md-12 col-espacio">
                          <label for="">Fecha final (AÑO-MES-DIA)</label>
                          <input 
                            type="date" 
                            class="form-control" 
                            name="fechaFinalFactura" 
                            id="fechaFinalFactura" 
                            ng-model="listadoGeneral.fechaFinalFactura" 
                            ng-change="listadoGeneral.fechaFinalFactura = listadoGeneral.fechaFinalFactura.toISOString().slice(0,10)">
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
                    <div class="card-body">
                        <button type="button" class="btn btn-info btn-lg" ng-click="arqueoDeCaja(listadoGeneral.idSistemaU,listadoGeneral)"><span class="icon-search"></span>Arqueo de caja</button>
                    </div>
                </div>
            </div>
        </div>
    </uib-tab>
</uib-tabset>
<!-- </div> -->
<script>
$(document).ready(function() {
    // initialise Datetimepicker and Sliders
    md.initFormExtendedDatetimepickers();
    if ($('.slider').length != 0) {
        md.initSliders();
    }
});
</script>