<?php   session_start();
//$_SESSION['ejecutado'];
?>


<uib-tabset active="active" class="col-md-12 tab-normal" >
    <uib-tab index="0">
        <uib-tab-heading>
            <i class="material-icons">list_alt</i>Inventario General
        </uib-tab-heading>
        <div class="row">
            <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                    <!-- <div class="card-icon">
				<i class="material-icons">assignment</i>
			</div>
			<h3 class="card-title">Inventario</h3> -->
                    <div class="row head-buscador">
                        <div class="col-md-6">
                            <div class="container-3">
                                <span class="icon"><i class="material-icons">search</i></span>
                                <input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroInventarioList"  autofocus="autofocus" autocomplete="off">
                                
                            </div>
                             <span class="input-group-btn">
                                  <!--  <button type="button" class="btn btn-info btn-sm" ng-click="listadotodos_Inventario()"><i class="material-icons">search</i> Cargar Inventario</button> -->
                                </span>
                        </div>
                        <div class="col-md-6 paginacion">
                            <uib-pagination class="pagination-mod" total-items="filterInventario.length" max-size="5" class="pagination-sm" boundary-links="true" ng-model="pagelistadodetodos_inventariioList" ng-change="paginalistadodetodos_inventariioList()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
                        </div>
                    </div>
                </div>
                <div class="card-body card-b-l">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="t-completa">
                                    <th>Cod.Producto</th>
                                    <th>Nombre</th>
                                    <th style="width:20px;">Caja</th>
                                    <th style="width:20px;">Und</th>
                                    <th style="width:80px;">Dif U</th> 
                                    <th style="width:80px;">Dif F</th>
                                    <th>Valor </th>
                                    <th>Venta </th>
                                    <th>Valor U</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="tbl-normal tbl-fixed">
                                <tr ng-repeat="listadoInventario in filterInventario = (listadodetodos_inventariioList | filter : filtroInventarioList) | limitTo:100:100*(pagelistadodetodos_inventariioList-1)" ng-class="{'table-danger': listadoInventario.stockMinimo==listadoInventario.Unidad}">
                                    <td>
                                        <div align="center">{{listadoInventario.codigo_barras}}</div>
                                        <div align="center">{{listadoInventario.codigo_barrasUno}}</div>
                                        <div align="center">{{listadoInventario.codigo_barrasDos}}</div>
                                        <div align="center">{{listadoInventario.codigo_producto}}</div>
                                    </td>
                                    <td>{{listadoInventario.descripcion}} {{listadoInventario.presentacion}}</td>
                                    <td class="und" style="width:20px;">
                                        <div align="center">
                                            <input type="text" name="cantidadF" class="form-control input-sm" ng-keypress="ajusteInventario(e,listadoInventario.Unidad,listadoInventario.stock,listadoInventario.id_inventario,listadoInventario.fraccion)" ng-model="listadoInventario.Unidad" ng-if="listadoInventario.fraccion!=0"></div>
                                    </td>
                                    <td class="frac" style="width:20px;">
                                        <div align="center">
                                            <input type="text" name="cantidadF" class="form-control input-sm" ng-keypress="ajusteInventario(e,listadoInventario.Unidad,listadoInventario.stock,listadoInventario.id_inventario,listadoInventario.fraccion)" ng-model="listadoInventario.Unidad" ng-if="listadoInventario.fraccion==0">
                                        </div>
                                        <div align="center">
                                            <input type="text" name="cantidadF" ng-keypress="ajusteInventario(e,listadoInventario.Unidad,listadoInventario.stock,listadoInventario.id_inventario,listadoInventario.fraccion)" class="form-control input-sm" ng-if="listadoInventario.fraccion!=0" ng-model="listadoInventario.stock">
                                        </div>
                                    </td>
                                    <td style="width:80px;">
                                        <div align="center"> {{listadoInventario.diferenciaU}} </div>
                                    </td>
                                    <td style="width:80px;">
                                        <div ng-if="listadoInventario.fraccion!=0" align="center">{{listadoInventario.diferenciaF}} </div>
                                    </td>
                                    <td>$ {{listadoInventario.valor | number:0}}</td>
                                    <td>$ {{listadoInventario.valor_venta | number:0}}</td>
                                    <td>$ {{listadoInventario.valor_unidad | number:0}}</td>
                                    <td>
                                        <button class="btn btn-warning  btn-just-icon" tooltip-placement="bottom" uib-tooltip="Editar" data-toggle="modal" data-target="#ModalActualizarProducto" ng-click="verProducto(listadoInventario.id_producto,listadoInventario.codigo_producto,listadoInventario.codigo_barras,listadoInventario.codigo_barrasUno,listadoInventario.codigo_barrasDos,listadoInventario.descripcion,listadoInventario.presentacion,listadoInventario.marca,listadoInventario.id_proveedor,listadoInventario.id_categoria,listadoInventario.id_iva,listadoInventario.id_seccion,listadoInventario.unidadCerrada,listadoInventario.fraccion,listadoInventario.valor,listadoInventario.valor_venta,listadoInventario.valor_unidad,listadoInventario.stockMinimo,listadoInventario.rentabilidad,actualizarProducto)"><i class="material-icons">create</i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL PARA ACTUALIZAR CAtegoria -->
        <div class="modal" id="ModalActualizarProducto">
            <div class="modal-dialog ta_modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Actualizar Producto</h2>
                    </div>
                    <!-- cuerpo del <mod</mod>al -->
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <input type="hidden" ng-model="actualizarProducto.id_ProductoActualizar" name="id_ProductoActualizar" class="form-control" required disabled="disabled">
                                <input type="hidden" class="form-control input-sm" ng-model="actualizarProducto.CodigoProducto" name="CodigoProducto">
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Codigo de Barras #1</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.CodigBarras" name="CodigBarras">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Codigo de Barras #2</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.CodigBarrasU" name="CodigBarras">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Codigo de Barras #3</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.CodigBarrasD" name="CodigBarras">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Descripcion</label>
                                        <TEXTAREA COLS=5 ROWS=2 name="fechaPago" class="form-control input-sm" ng-model="actualizarProducto.DescripcionProducto" name="DescripcionProducto">
						</TEXTAREA>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Presentación</label>
                                        <input type="text" class="form-control input-sm" ng-model="actualizarProducto.presentacion" name="presentacion">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Marca</label>
                                        <input type="text" class="form-control input-sm" ng-model="actualizarProducto.marcaProducto" name="marcaProducto">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Seleccione Proveedor</label>
                                        <select name="idProveedor" class="form-control input-sm" ng-model="actualizarProducto.idProveedor">
                                            <option ng-repeat="listadoProveedor in listadodetodos_Proveedor" value="
							{{listadoProveedor.id_proveedor}}">{{listadoProveedor.nombre_proveedor}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Seleccione Categoria</label>
                                        <select name="idCategoria" class="form-control input-sm" ng-model="actualizarProducto.idCategoria">
                                            <option ng-repeat="listadoCateoria in listadodetodos_Categoria" value="
							{{listadoCateoria.id_categoria}}">{{listadoCateoria.nombre_categoria}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="">Iva</label>
                                        <select name="idIva" class="form-control input-sm" ng-model="actualizarProducto.idIva">
                                            <option ng-repeat="listadoIva in listadodetodos_iva" value="
							{{listadoIva.id_iva}}">{{listadoIva.iva}} - %</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="">Seccion</label>
                                        <select name="idIva" class="form-control input-sm" ng-model="actualizarProducto.idSeccion">
                                            <option ng-repeat="listadoSec in listadodetodos_seccion" value="
							{{listadoSec.id_seccion}}">{{listadoSec.seccion}}</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Unidad Cerrada</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.unidadCerrada" name="unidadCerrada">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Fracción </label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.fraccion" name="fraccion">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Precio Del Producto</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.valorProducto" name="valorProducto" ng-change="valorUnidadUp(actualizarProducto.fraccion,actualizarProducto.valorProducto,actualizarProducto.valorVentaProducto,actualizarProducto)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Precio De Venta</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.valorVentaProducto" name="valorVentaProducto" ng-change="valorUnidadUp(actualizarProducto.fraccion,actualizarProducto.valorProducto,actualizarProducto.valorVentaProducto,actualizarProducto)">
                                    </div>
                                </div>
                                <div class="row" ng-if="actualizarProducto.fraccion!=0">
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Precio por Unidad</label>
                                            <input type="number" class="form-control input-sm" ng-model="actualizarProducto.valorUnidadProducto" name="valorUnidadProducto">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Stock Minimo</label>
                                        <input type="number" class="form-control input-sm" ng-model="actualizarProducto.stockMin" name="stockMin">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <h3>Renta %{{actualizarProducto.rentabilidad | number:0}}</h3>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="Actualizar_Producto(actualizarProducto)" data-dismiss="modal">
                                Actualizar
                            </button>
                        </div>
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
                                    <th>Codigo</th>
                                    <th>Nombre Producto</th>
                                    <th>Caja</th>
                                    <th>Unidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="listado in filterinvenXprodut = (listainventarioXproducto  )" ng-class="{'table-danger': listado.stockMinimo>=listado.Unidad}">
                                    <td>{{listado.nombre_categoria}}</td>
                                    <td>{{listado.codigo_producto}}</td>
                                    <td>{{listado.descripcion}}</td>
                                    <td>
                                        <p ng-if="listado.fraccion!=0">{{listado.Unidad}}</p>
                                    </td>
                                    <td>
                                        <p ng-if="listado.fraccion==0">{{listado.Unidad}}</p>
                                        <p ng-if="listado.fraccion!=0">{{listado.stock}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ininio ventana modal de productos -->
        <div id="modal-productorReporte" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Productos</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-4">
                                <input type="text" name="id_producto" class="form-control" placeholder="Buscar..." id="id_producto" ng-model="filtroProductoIngreso">
                            </div>
                            <div class="col-md-12">
                                <uib-pagination class="pagination-mod" total-items="filterDatProducIngreso.length" max-size="5" class="pagination-sm" boundary-links="true" ng-model="pagelistadodeProductos_Ingreso" ng-change="paginalistadodeProductos_Ingreso()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=20></uib-pagination>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Descripcion</th>
                                                <th>V.venta</th>
                                                <th>V.Und</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="listado in filterDatProducIngreso = (listadodeProductos_Ingreso | filter : filtroProductoIngreso) | limitTo:20:20*(pagelistadodeProductos_Ingreso-1)">
                                                <td>{{listado.codigo_producto}}</td>
                                                <td>{{listado.descripcion}} {{listado.presentacion}} </td>
                                                <td>${{listado.valor_venta | number:0 }} </td>
                                                <td>${{listado.valor_unidad | number:0}} </td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" ng-click="agregarinvemtario_ProductXreprote(listado.id_producto,listado.descripcion,listado.codigo_producto,busquedainventarioXproducto)">+</button>
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
        </div>
        <!-- Ininio ventana modal de productos -->
        <div id="modal-categoriadelProduct" class="modal" role="dialog">
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
                                                    <button type="button" class="btn btn-info btn-sm" ng-click="agregarcartegoriaFormu(listado.id_categoria,listado.nombre_categoria,busquedainventarioXcategira)" data-dismiss="modal">Agregar</button>
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
                            <input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroDescuadreoListDos" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <uib-pagination class="pagination-mod" total-items="filterDescuadre.length" ng-model="pagelistadoDescuadreXunidadNomodificado" max-size="5" class="pagination-sm" boundary-links="true" ng-change="paginalistadoDescuadreXunidadNomodificado()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=40></uib-pagination>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-info">
                                        <th>Cod.Producto</th>
                                        <th>Nombre</th>
                                        <th>Pre</th>
                                        <th>Unidad</th>
                                        <th>Fraccion</th>
                                        <th>valor </th>
                                        <th>valor Unidad </th>
                                        <th>Ultima Fecha </th>
                                    </tr>
                                </thead>
                                <tbody class="tbl-normal">
                                    <tr ng-repeat="listadoInventario in filterDescuadre = (listadoDescuadreXunidadNomodificado | filter : filtroDescuadreoListDos) | limitTo:10:10*(pagelistadoDescuadreXunidadNomodificado-1)">
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
                                        <td>
                                            {{listadoInventario.fecha_movimiento}}
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
                        <input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroDescuadreoList" autofocus="autofocus">
                    </div>
                </div>
                <div class="col-md-12">
                    <uib-pagination class="pagination-mod" total-items="filterDescuadre.length" ng-model="pagelistadoDescuadreXunidad" max-size="5" class="pagination-sm" boundary-links="true" ng-change="paginalistadoDescuadreXunidad()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=40></uib-pagination>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-danger">
                                    <th>Cod.Producto</th>
                                    <th>Nombre</th>
                                    <th>Pre</th>
                                    <th>Cambio U</th>
                                    <th>Cambio F</th>
                                    <th>valor </th>
                                    <th>Descuadre U</th>
                                    <th>Descuadre F</th>
                                    <th>Valor Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="tbl-normal">
                                <tr ng-repeat="listadoInventario in filterDescuadre = (listadoDescuadreXunidad | filter : filtroDescuadreoList) | limitTo:10:10*(pagelistadoDescuadreXunidad-1)">
                                    <td>{{listadoInventario.codigo_producto}}</td>
                                    <td>{{listadoInventario.descripcion}}</td>
                                    <td>{{listadoInventario.presentacion}}</td>
                                    <td> {{listadoInventario.diferenciaU}} </td>
                                    <td>
                                        <div ng-if="listadoInventario.fraccion<0">
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
                                        {{(listadoInventario.valor_unidad * listadoInventario.diferenciaF * -1 | number:0) }}
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
                            <div class="card-header card-datos">
                                <h3 class="card-title titulo"> <span class="text">$ {{totaldescuadrePorUnidad * -1 | number:2}}</span></h3>
                                <span class="icono"><i class="material-icons">dns</i></span>
                            </div>
                            <div class="card-body">
                                <h4>Total Unidad ({{ totalUnidadDes * -1}})</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card datos-utilidad">
                            <div class="card-header card-datos">
                                <h3 class="card-title titulo"> <span class="text">$ {{totaldescuadrePorFraccion * -1 | number:2}}</span></h3>
                                <span class="icono"><i class="material-icons">dns</i></span>
                            </div>
                            <div class="card-body">
                                <h4>Total Fraccion ({{totalFraccionDes * -1}}))</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card datos-utilidad">
                            <div class="card-header card-datos">
                                <h3 class="card-title titulo"> <span class="text">$ {{totaldescuadre * -1 | number:2}}</span></h3>
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
    <uib-tab index="5">
        <uib-tab-heading>
            <i class="material-icons">list_alt</i>Producto Por Caducar
        </uib-tab-heading>
        <div class="row">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <!-- <div class="card-icon">
				<i class="material-icons">how_to_vote</i>
			</div>
			<h3 class="card-title">Producto</h3> -->
                    <div class="row head-buscador">
                        <div class="col-md-6">
                            <div class="container-3">
                                <span class="icon"><i class="material-icons">search</i></span>
                                <input type="search" placeholder="Busqueda general..." id="search" onclick="ClearSearch()" onfocus="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroInventarioListFCD" autofocus="autofocus">
                            </div>
                        </div>
                        <div class="col-md-6 paginacion">
                            <uib-pagination class="pagination-mod" total-items="filterInventarioFCD.length" max-size="5" class="pagination-sm" boundary-links="true" ng-model="pagelistaDetallefechaCaducidadLista" ng-change="paginalistaDetallefechaCaducidadLista()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
                        </div>
                    </div>
                </div>
                <div class="card-body card-b-l">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="t-completa">
                                    <th>Cod.Producto</th>
                                    <th>Nombre</th>
                                    <th>Pre</th>
                                    <th>Cantidad</th>
                                    <th>Lote</th>
                                    <th>Referencia U</th>
                                    <th>Fecha Caducidad</th>
                                </tr>
                            </thead>
                            <tbody class="tbl-normal">
                                <tr ng-repeat="listadoInventario in filterInventarioFCD = (listaDetallefechaCaducidadLista | filter : filtroInventarioListFCD) | limitTo:100:100*(pagelistaDetallefechaCaducidadLista-10)">
                                    <td class="cod">{{listadoInventario.codigo_producto}}</td>
                                    <td>{{listadoInventario.descripcion}}</td>
                                    <td>{{listadoInventario.presentacion}}</td>
                                    <td>{{listadoInventario.cantidad}}</td>
                                    <td>{{listadoInventario.lote}}</td>
                                    <td>{{listadoInventario.referencia}}</td>
                                    <td>{{listadoInventario.fechaCaducidad}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </uib-tab>
</uib-tabset>