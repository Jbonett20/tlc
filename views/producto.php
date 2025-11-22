<uib-tabset active="active" class="col-md-12 tab-normal">
    <uib-tab index="0">
        <uib-tab-heading>
            <i class="material-icons">add_box</i> Productos
            <button class="btn btn-info cambiob" id="EnableVista" onclick="CambiarT()" value="[-]" ng-click="showVistaJS()"><i class="material-icons">
                    compare_arrows
                </i></button>
        </uib-tab-heading>
        <div class="row">
            <div class="col-md-3">
                <form id="guardarProducto" name="guardarProducto" ng-show="showVista.show" class="form-jar" ng-submit="guardarProductoDos(insertarProducto)" novalidate>
    <div class="card">
        <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon" ng-click="limpiarProducto()">
                <i class="material-icons">shopping_cart</i>
            </div>
            <h3 class="card-title">Productos</h3>
        </div>
        <div class="card-body">
            <!-- Codigo del Producto -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Codigo del Producto</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.CodigoProducto" ng-keypress="listadoPorducto_Keypress(e,insertarProducto.CodigoProducto)" name="CodigoProducto" required>
                    <div ng-show="guardarProducto.CodigoProducto.$touched && guardarProducto.CodigoProducto.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- Codigo de Barras -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Codigo de Barras</label>
                    <input type="text" class="form-control input-sm" ng-model="insertarProducto.CodigBarras" name="CodigBarras">
                </div>
            </div>

            <!-- Descripcion -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Descripcion</label>
                    <TEXTAREA COLS=5 ROWS=5 name="fechaPago" class="form-control" ng-model="insertarProducto.DescripcionProducto" required>
                    </TEXTAREA>
                    <div ng-show="guardarProducto.DescripcionProducto.$touched && guardarProducto.DescripcionProducto.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- Presentación -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Presentación</label>
                    <input type="text" class="form-control input-sm" ng-model="insertarProducto.presentacion" name="presentacion" required>
                    <div ng-show="guardarProducto.presentacion.$touched && guardarProducto.presentacion.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- Marca -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Marca</label>
                    <input type="text" class="form-control input-sm" ng-model="insertarProducto.marcaProducto" name="marcaProducto" required>
                    <div ng-show="guardarProducto.marcaProducto.$touched && guardarProducto.marcaProducto.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- Proveedor -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Seleccione Proveedor</label>
                    <select name="idProveedor" class="form-control input-sm" ng-model="insertarProducto.idProveedor" required>
                        <option ng-repeat="listadoProveedor in listadodetodos_Proveedor" value="{{listadoProveedor.id_proveedor}}">{{listadoProveedor.nombre_proveedor}}</option>
                    </select>
                    <div ng-show="guardarProducto.idProveedor.$touched && guardarProducto.idProveedor.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- Categoria -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Seleccione Categoria</label>
                    <select name="idCategoria" class="form-control input-sm" ng-model="insertarProducto.idCategoria" required>
                        <option ng-repeat="listadoCateoria in listadodetodos_Categoria" value="{{listadoCateoria.id_categoria}}">{{listadoCateoria.nombre_categoria}}</option>
                    </select>
                    <div ng-show="guardarProducto.idCategoria.$touched && guardarProducto.idCategoria.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- IVA -->
            <div class="col-md-12">
                <div class="col-md-12 p-m-v">
                    <div class="form-group">
                        <label>Seleccione Iva</label> <br>
                        <label class="label" ng-repeat="listadoIva in listadodetodos_iva">
                            <input class="label__checkbox" ng-model="insertarProducto.idIva" value="{{listadoIva.id_iva}}" type="radio" name="jar" checked />
                            <span class="label__text">
                                <span class="label__check span-espacio">
                                    <span class="icon">{{listadoIva.iva}}%</span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Fracción -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Fracción</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.fraccion" name="fraccion" required>
                    <div ng-show="guardarProducto.fraccion.$touched && guardarProducto.fraccion.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>
            
            <!-- Costo Del Producto -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Costo Del Producto</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.valorProducto" name="valorProducto" ng-change="valorUnidad(insertarProducto.fraccion,insertarProducto.valorProducto,insertarProducto.valorVentaProducto,insertarProducto)" required>
                    <div ng-show="guardarProducto.valorProducto.$touched && guardarProducto.valorProducto.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>
            
            <!-- Costo Del Producto por unidad -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Costo por Unidad</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.valorProductoUnidad" name="valorProducto" disabled="">
                </div>
            </div>

            <!-- Precio De Venta -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Precio De Venta</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.valorVentaProducto" name="valorVentaProducto" ng-change="valorUnidad(insertarProducto.fraccion,insertarProducto.valorProducto,insertarProducto.valorVentaProducto,insertarProducto)" required>
                    <div ng-show="guardarProducto.valorVentaProducto.$touched && guardarProducto.valorVentaProducto.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- valorUnidadProducto -->
            <div class="col-md-12" ng-if="insertarProducto.fraccion!=0">
                <div class="form-group">
                    <label class="bmd-label-floating">Precio venta por unidad</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.valorVentaProductoUnidad" name="valorVentaProductoUnidad" required>
                </div>
            </div>
            
            <!-- Stock Minimo -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Stock Minimo</label>
                    <input type="number" class="form-control input-sm" ng-model="insertarProducto.stockMin" name="stockMin" required>
                    <div ng-show="guardarProducto.stockMin.$touched && guardarProducto.stockMin.$invalid" class="text-danger">
                        Este campo es obligatorio.
                    </div>
                </div>
            </div>

            <!-- Rentabilidad -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="">Rentabilidad (%)</label>
                    <br>
                    <input type="number" class="form-control input-sm" placeholder="" ng-model="insertarProducto.renta" name="renta" disabled="">
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="col-md-12">
                <button type="submit" class="btn btn-info btn-sm" ng-disabled="guardarProducto.$invalid">Guardar</button>
            </div>
        </div>
    </div>
</form>

            </div>
            <!-- fin formulario -->
            <div class="col-md-9" id="vistaProducto">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon" id="EnableVista" onclick="CambiarT()" value="[-]" ng-click="showVistaJS()">
                            <i class="material-icons">add_box</i>
                        </div>
                        <h3 class="card-title">Lista De Productos</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="container-3">
                                <span class="icon"><i class="material-icons" ng-click="listadoPorOrdenProducto()">search</i></span>
                                <input type="search" id="search" placeholder="Buscar Producto..." onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="busquedaProducto" ng-change="listadotodos_ProductoChangeModPro(busquedaProducto) " ng-keypress="listadoPorOrdenProducto(e,busquedaProducto)" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <uib-pagination class="pagination-mod" total-items="filterProducto.length" max-size="maxSize" class="pagination-sm" boundary-links="true" ng-model="pagelistadodetodos_ProductoModProd" ng-change="paginalistadodetodos_ProductoModProd()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=50></uib-pagination>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Stock</th>
                                            <th>Codigo</th>
                                            <th ng-show="false">Barra</th>
                                            <th>Desc</th>
                                            <th>Pre</th>
                                            <th>Seccion</th>
                                            <!-- <th>Serial Producto</th> -->
                                            <!-- <th>Categoria</th> -->
                                            <!-- <th>descripcion</th> -->
                                            <th>Valor</th>
                                            <th>Venta</th>
                                            <th>Editable</th>
                                            <th colspan="2">Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbl-normal">
                                        <tr ng-repeat="listadoProducto in filterProducto = (listadodetodos_ProductoModProd | filter : filtroProducto) | limitTo:50:50*(pagelistadodetodos_Producto-1)" ng-class="{'ctr': listadoProducto.stockMinimo>=listadoProducto.Unidad}">
                                            <td>
                                                <div class="col-md-12">
                                                    <h3 class="cantidad badge badge-warning">
                                                        <span class="" ng-if="listadoProducto.fraccion==0">{{listadoProducto.Unidad}} </span>
                                                        <span class="" ng-if="listadoProducto.fraccion!=0">{{listadoProducto.Unidad}} / {{listadoProducto.stock}}</span>
                                                    </h3>
                                                </div>
                                            </td>
                                            <td>{{listadoProducto.codigo_producto}}</td>
                                            <td ng-show="false">{{listadoProducto.codigo_barras}}</td>
                                            <td>{{listadoProducto.descripcion}}</td>
                                            <td>{{listadoProducto.presentacion}}</td>
                                            <td class="seccion"><strong>{{listadoProducto.seccion}}</strong></td>
                                            <!-- <td>{{listadoProducto.serial}}</td> -->
                                            <!-- <td>{{listadoProducto.nombre_categoria}}</td> -->
                                            <!-- <td>{{listadoProducto.descripcion}}</td> -->
                                            <td class="_valor"> $ {{listadoProducto.valor | number:0}}</td>
                                            <td class="_valor_venta">$ {{listadoProducto.valor_venta | number:0}}</td>
                                            <td class="" ng-if="listadoProducto.editableValor==1">
                                                <h4>SI</h4>
                                            </td>
                                            <td class="" ng-if="listadoProducto.editableValor!=1">
                                                <h4>NO</h4>
                                            </td>
                                            <td><div>
                                                <button class="btn btn-primary btn-just-icon" tooltip-placement="bottom" uib-tooltip="Agregar Producto" data-toggle="modal" data-target="#ModalAgregarProducto" ng-click="verAgregarProducto(listadoProducto.id_producto,listadoProducto.codigo_producto,listadoProducto.descripcion,listadoProducto.id_categoria,listadoProducto.descripcion,listadoProducto.valor,listadoProducto.valor_venta,listadoProducto.fraccion)">
                                                    <i class="material-icons">input</i>
                                                </button>
                                                <button class="btn btn-success  btn-just-icon" tooltip-placement="bottom" uib-tooltip="Editar" data-toggle="modal" data-target="#ModalActualizarProducto" ng-click="verProducto(listadoProducto.id_producto,listadoProducto.codigo_producto,listadoProducto.codigo_barras,listadoProducto.codigo_barrasUno,listadoProducto.codigo_barrasDos,listadoProducto.descripcion,listadoProducto.presentacion,listadoProducto.marca,listadoProducto.id_proveedor,listadoProducto.id_categoria,listadoProducto.id_iva,listadoProducto.id_seccion,listadoProducto.unidadCerrada,listadoProducto.fraccion,listadoProducto.valor,listadoProducto.valor_venta,listadoProducto.valor_unidad,listadoProducto.stockMinimo,listadoProducto.rentabilidad,actualizarProducto)"><i class="material-icons">create</i></button>
                                                </div>
                                                <div>
                                                <button class="btn btn-danger btn-just-icon" tooltip-placement="bottom" uib-tooltip="Eliminar" data-toggle="modal" data-target="#modal-eliminarProducto" ng-click="confirmaEliminar_Producto(listadoProducto.id_producto,listadoProducto.codigo_producto,listadoProducto.nombre)"><i class="material-icons">delete</i></button>
                                                <button class="btn btn-warning btn-just-icon" tooltip-placement="bottom" data-toggle="modal" data-target="#myModalFechaCaducidad" ng-click="AddProductoFechaCaducidad(listadoProducto.id_producto,listadoProducto.presentacion,listadoProducto.descripcion,listadoProducto.cantidadUnidad,listadoProducto.cantidadFraccion)">
                                                <i class="material-icons">schedule</i></button>
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
        </div>
        <div id="myModalFechaCaducidad" class="modal" role="dialog">
            <div class="modal-dialog ta_modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Fecha Caducidad</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3> {{descripcionFecha}} - {{presentacionFecha}}</h3>
                                <br>
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Lote (Opcional)</label>
                                            <input type="text" placeholder="Lote" class="form-control" ng-model="insertarFechaCaducidad.lote" name="ccCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Referencia (Opcional)</label>
                                            <input type="text" placeholder="Referencia" class="form-control input-sm" ng-model="insertarFechaCaducidad.referencia" name="nombreCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Cantidad</label>
                                            <input type="number" placeholder="Cantidad" class="form-control input-sm" ng-model="insertarFechaCaducidad.cantidad" name="direccionCliente">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Fecha Caducidad</label>
                                            <input type="date" placeholder="Fecha" class="form-control input-sm" ng-model="insertarFechaCaducidad.fechaCaducidad" name="telefonoCliente">
                                        </div>
                                    </div>
                                </form>
                                <div class="card-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-info btn-sm" ng-click="guardarDetalleFechaCaducidad(insertarFechaCaducidad,id_fechacaducidad,id_productoFecha)">Guardar</button>
                                    </div>
                                </div>
                                </div>
                                <div>
                                <div class="col-md-12">
                                <div class="col-md-12">
                            <div class="container-3">
                                <span class="icon"><i class="material-icons" >search</i></span>
                                <input type="search" id="search" placeholder="Buscar por lote..." onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtro"  autocomplete="off">
                            </div>
                        </div>
                                    <div class="table table-caducidad">
                                        <table class="table table-bordered table-hover ">
                                            <thead>
                                                <tr class="t-completa">
                                                    <th>lote</th>
                                                    <th>referencia</th>
                                                    <th>Cantidad</th>
                                                    <th>Fecha Caducidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="listado in filterDatProducIngreso = (listaDetallefechaCaducidadLista ) | filter:filtro">
                                                    <td>{{listado.lote}}</td>
                                                    <td>{{listado.referencia}}</td>
                                                    <td>{{listado.cantidad}}</td>
                                                    <td>{{listado.fechaCaducidad}}</td>
                                                    <td><button class="btn btn-danger btn-just-icon" tooltip-placement="bottom" uib-tooltip="Eliminar"  ng-click="EliminarFechaCaducidad(listado.id_fechaCaducidadDetalle,listado.id_producto,1)"><i class="material-icons">delete</i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
        <div id="myModalFacturaSelect" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Factura </h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Nombre Factura</label>
                                            <input type="text" placeholder="Lote" class="form-control" ng-model="nombreFacturaSelecT" name="ccCliente">
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="footer-centrado">
                            <button type="button" class="btn btn-info btn-sm" ng-click="UpdateNombreFactura(nombreFacturaSelecT,idFacturaSelecT)" data-dismiss="modal">Guardar</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                        </div>
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
                            <button type="button" class="btn btn-primary btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="Actualizar_Producto(actualizarProducto,busquedaProducto)" data-dismiss="modal">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- MODAL PARA ACTUALIZAR CAtegoria -->
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
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Codigo Producto</th>
                                                    <th>Nombre</th>
                                                    <th>Valor</th>
                                                    <th>Fraccion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{CodigoProductoAgregar}}</td>
                                                    <td>{{nombreProductoAgregar}}</td>
                                                    <td>{{valorVentaProductoAgregar}}</td>
                                                    <td>{{fraccionAdd}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div ng-show="fromIngresosCantidad.show">
                                        <div class="row">
                                            <label class="col-md-3 col-form-label">Cantidad Por Unidad</label>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input type="number" class="form-control input-sm" placeholder="ingrese Cantidad" ng-model="AgregarCantidadProducto.AddCantidadUnidad" name="AddCantidadUnidad">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8" ng-if="fraccionAdd!=0">
                                            <div class="row">
                                                <label class="col-md-3 col-form-label">Cantidad Por Fraccion</label>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control input-sm" placeholder="ingrese Cantidad" ng-model="AgregarCantidadProducto.AddCantidadFraccion" name="AddCantidadFraccion">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                               <div ng-show="fromIngresosCantidadBotton.show" class="col-md-offset-4">
    <div class="col-md-12">
        <button type="button" class="btn btn-info btn-sm" 
                ng-disabled="actualizar_des.$invalid" 
                ng-click="guardarIngresosProducto(id_ProductoAgregar, AgregarCantidadProducto)" 
                data-dismiss="modal">
            Guardar Cantidad
        </button>
    </div>
</div>
<div ng-show="fromIngresosCantidadBotton.show" class="col-md-offset-4">
    <div class="col-md-12">
        <button type="button" class="btn btn-info btn-sm" 
                ng-click="restarIngresosProducto(idProducto, cantidad)" 
                data-dismiss="modal">
            Restar Cantidad
        </button>
    </div>
</div>

<script>
    $scope.restarIngresosProducto = function (idProducto, cantidad) {
        // Validar que la cantidad y el idProducto sean válidos
        if (!idProducto || cantidad <= 0) {
            alert("Por favor, ingresa un ID de producto válido y una cantidad mayor a 0.");
            return;
        }

        // Crear el objeto de datos
        const data = {
            idProducto: idProducto,
            cantidad: cantidad
        };

        // Enviar datos al archivo PHP usando $http
        $http.post('restar.php', data)
            .then(function (response) {
                // Manejar respuesta del servidor
                if (response.data.success) {
                    alert("Cantidad restada exitosamente.");
                } else {
                    alert("Error al restar la cantidad: " + response.data.message);
                }
            })
            .catch(function (error) {
                // Manejar errores en la solicitud
                console.error("Error en la solicitud:", error);
                alert("Ocurrió un error al restar la cantidad.");
            });
    };
</script>


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
                                    <input type="hidden" name="idEliminarProducto" ng-model="idEliminarProducto">
                                    ¿Realmente desea eliminar Producto <b>{{nombre}} {{codigo}}</b>?
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="footer-centrado">
                            <button class="btn btn-danger btn-sm" ng-click="EliminarProducto(idEliminarProducto)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
                            <button class="btn btn-info btn-sm" aria-hidden="true" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- FINAL DEL MODAL PARA CONFIRMAR PAR ELIMINAR CATEGORIA -->
    </uib-tab>
    <uib-tab index="1">
        <uib-tab-heading>
            <i class="material-icons">donut_small</i>Seccion
        </uib-tab-heading>
        <!-- <div class="row">
	<div class="col-md-4">
		<form id="guardarProducto" name="guardarProducto"  class="form-jar">
			<div class="card">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon" ng-click="limpiarProducto()">
						<i class="material-icons">shopping_cart</i>
					</div>
					<h3 class="card-title">Seccion</h3>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<div class="form-group">
							<label class="bmd-label-floating">Seccion</label>
							<input type="text" class="form-control input-sm"   ng-model="insertarSeccion.seccion" name="presentacion">
						</div>
					</div>
					<div class="col-md-12">
					<button type="button" class="btn btn-primary btn-sm" ng-click="guardarSeccion(insertarSeccion)">Guardar</button>
				</div>
					</div>
				</div>
			</form>
		</div>
	</div> -->
	

        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon" id="EnableVista">
                        <i class="material-icons">add_box</i>
                    </div>
                    <h3 class="card-title">Lista De Secciones</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 tarjeta-fija">
                            <div class="card">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon" ng-click="limpiarProducto()">
                                        <i class="material-icons">label_important</i>
                                    </div>
                                    <!-- <h3 class="card-title">Seccion</h3> -->
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Seccion</label>
                                            <input type="text" class="form-control input-sm" ng-model="insertarSeccion.seccion" name="presentacion">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-sm" ng-click="guardarSeccion(insertarSeccion)">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-4">
                            <div class="col-md-12">
                                <div class="container-3">
                                    <span class="icon"><i class="material-icons">search</i></span>
                                    <input type="search" id="search" placeholder="Buscar Producto..." onclick="ClearSearch()" name="id_producto" id="id_producto" ng-model="filtroSeccion" ng-change="listadotodos_Seccion()">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <uib-pagination class="pagination-mod" total-items="filterSeccion.length" max-size="maxSize" class="pagination-sm" boundary-links="true" ng-model="pagelistadodetodos_Seccion" ng-change="paginalistadodeProductos_Seccion()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=50></uib-pagination>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Seccion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbl-normal">
                                            <tr ng-repeat="listadoSeccion in filterSeccion = ( listadodetodos_Seccion | filter : filtroSeccion) | limitTo:50:50*(pagelistadodetodos_Seccion-1)">
                                                <td>
                                                    <div class="col-md-12 btn_sesion">
                                                        <li class="dropdown mega-dropdown btn_li">
                                                            <a href="" class="btn_log btn btn-info btn-sm" class="dropdown-toggle" data-toggle="dropdown" ng-click="verificarCanPro(listadoSeccion.id_seccion)">cantidad <span class="caret"></span></a>
                                                            <ul class="dropdown-menu  mega-dropdown-menu  row">
                                                                <li>
                                                                    <div class="col-md-12">
                                                                        <div class="table-table-responsive">
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Total</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>{{TotalPro}}</td>
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
                                                <td>{{listadoSeccion.seccion}}</td>
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
    </uib-tab>
    <uib-tab index="2">
        <uib-tab-heading>
            <i class="material-icons">donut_small</i>Categoria
        </uib-tab-heading>
        <!-- FINAL DEL MODAL PARA CONFIRMAR PAR ELIMINAR CATEGORIA -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">add_box</i>
                    </div>
                    <h3 class="card-title">Categorias</h3>
                </div>
                <div class="card-body">
                    <form id="guardarcategoria" name="guardarcategoria">
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" placeholder="ingrese nombre de la categoria" class="from-control input_linea" size="40" ng-model="insertarCategoria.nombreCategoria" name="nombreCategoria" required>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-sm" ng-click="guardarCategoria(insertarCategoria)">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <span><i>{{"Registros Encontrados"}}</i></span>
            <span style="font-size: font-size: 15px;font-weight: bold;color: red;margin-left: 3%;">
                {{listadodetodos_Categoria.length}}
            </span>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">shopping_cart</i>
                    </div>
                    <h3 class="card-title">Categorias</h3>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="container-3">
                            <span class="icon"><i class="material-icons">search</i></span>
                            <input type="search" placeholder="Buscar Categorias..." id="search" ng-model="filtroCategoria" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <uib-pagination class="pagination-mod" total-items="filterCateoria.length" ng-model="pagelistadodetodos_Categoria" ng-change="paginalistadodetodos_Producto()" previous-text="&lsaquo;" next-text="&rsaquo;" items-per-page=10></uib-pagination>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hove">
                                <thead>
                                    <tr>
                                        <th>Nombre Categoria</th>
                                        <th colspan="2">Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody class="tbl-normal">
                                    <tr ng-repeat="listadoCateoria in filterCateoria = (listadodetodos_Categoria | filter : filtroCategoria) | limitTo:10:10*(pagelistadodetodos_Categoria-1)">
                                        <td>{{listadoCateoria.nombre_categoria}}</td>
                                        <td ng-if="listadoCateoria.id_categoria!=1">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalActualizarCategoria" ng-click="verCategoria(listadoCateoria.id_categoria,listadoCateoria.nombre_categoria,actualizarCategoria)"><span class="icon-pencil"></span>Editar</button>
                                        </td>
                                        <td ng-if="listadoCateoria.id_categoria!=1">
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminarCategoria" ng-click="confirmaEliminar_Categoria(listadoCateoria.id_categoria,listadoCateoria.nombre_categoria,confirmaEminarCateoria)"><span class="icon-trash"></span>Eliminar</button>
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
        <div class="modal" id="ModalActualizarCategoria">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="tt_modal">Actualizar Categoria</h2>
                    </div>
                    <!-- cuerpo del modal -->
                    <div class="modal-body">
                        <div class="row">
                            <form>
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control input-sm" ng-model="actualizarCategoria.id_categoriaActualizar" name="id_categoriaActualizar" placeholder="id" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control input-sm" name="nombreCategoriaActualizar" id="nombreCategoriaActualizar" ng-model="actualizarCategoria.nombreCategoriaActualizar" placeholder="Nombre de la Categoria" class="form-control" required="">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary btn-sm" ng-disabled="actualizar_des.$invalid" ng-click="Actualizar_Categoria(actualizarCategoria)" data-dismiss="modal">
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- fin ventana modal de clientes -->
        <!-- MODAL PARA CONFIRMAR ELIMINAR  -->
        <div class="modal" id="modal-eliminarCategoria">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="tt_modal">
                                    <input type="hidden" name="idEliminarCategoria" ng-model="idEliminarCategoria">
                                    ¿Realmente desea eliminar la categoria <b>{{nombre_categoria}}</b>?
                                </h3>
                            </div>
                            <div class="col-md-12 col-md-offset-3">
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="EliminarCategoria(idEliminarCategoria)" aria-hidden="true" data-dismiss="modal">Aceptar</button>
                                </div>
                                <div class="col-md-offset-1 col-md-2">
                                    <button type="button" class="btn btn-info btn-sm" aria-hidden="true" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </uib-tab>
    <uib-tab index="3">
    <uib-tab-heading>
            <i class="material-icons">add_box</i> Productos por Caducar
            <button class="btn btn-info cambiob" id="EnableVista" onclick="CambiarT()" value="[-]" ng-click="showVistaJS()"><i class="material-icons">
                    compare_arrows
                </i></button>
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
                                    <th style="width:20px;">Cant.</th>
                                  
                                    <th>Fecha Caducidad </th>
                                   
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="tbl-normal tbl-fixed">
                                <tr ng-repeat="listadoInventario in filterInventario = (listaDetallefechaCaducidadLista | filter : filtroInventarioList) | limitTo:100:100*(pagelistadodetodos_inventariioList-1)" ng-class="{'table-danger': listadoInventario.fechaCaducidad==fechaHoy}">
                                    <td>
                                        <div align="center">{{listadoInventario.codigo_barras}}</div>
                                        <div align="center">{{listadoInventario.codigo_barrasUno}}</div>
                                        <div align="center">{{listadoInventario.codigo_barrasDos}}</div>
                                        <div align="center">{{listadoInventario.codigo_producto}}</div>
                                    </td>
                                    <td>{{listadoInventario.descripcion}} {{listadoInventario.presentacion}}</td>
                                    <td class="und" style="width:20px;">
                                        <div align="center">
                                           {{listadoInventario.cantidad}}
                                    </td>
                                    <td class="frac" style="width:20px;">
                                       {{listadoInventario.fechaCaducidad}}
                                    </td>
                                    
                                    <td><button class="btn btn-danger btn-just-icon" tooltip-placement="bottom" uib-tooltip="Eliminar"  ng-click="EliminarFechaCaducidad(listadoInventario.id_fechaCaducidadDetalle,listadoInventario.id_producto,2)"><i class="material-icons">delete</i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </uib-tab>
</uib-tabset>