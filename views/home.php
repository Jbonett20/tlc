<?php   session_start();
//$_SESSION['ejecutado'];
?>
<div class="content">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card ">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons"></i>
                    </div>
                    <h4 class="card-title">Reporte Global Top Ventas</h4>
                  </div>
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="table-responsive table-sales">
                          <table class="table">
                            <tbody>
                              <tr  ng-repeat="listadoTopProductoGlobal in filterTopProductoGlobal = (listadodetodos_ProductoTopVentaXdiaGlobal)">

                                <td>

                                  <div class="flag">
                                    <img src="assets/img/flags/CO.png" </div>
                                </td>
                                <td>{{listadoTopProductoGlobal.descripcion}}</td>
                                <td class="text-right">
                                 {{listadoTopProductoGlobal.cantidad}}
                                </td>
                                <td class="text-right">
                                  {{listadoTopProductoGlobal.cantidad *100 /TotalGlobal | number:1}} %
                                </td>
                              </tr>
                              
                            </tbody>
                          </table>
                          </div>
                          </div>
                          <div class="col-md-6 ml-auto mr-auto">

                            <div id="worldMap" style="height: 300px;">
                              <!-- <img src="assets/img/flags/carte.png" alt=""> -->
                            </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                        </div>
                        <!-- <button type="button" class="btn btn-round btn-default dropdown-toggle btn-link" data-toggle="dropdown">
7 days
</button> -->
                         <?php
                if ($_SESSION['tipo']==0) {
                       echo' <div class="row">
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category">Unidad</p>
                                <h3 class="card-title">{{unidadN}}</h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                  <i class="material-icons ">update</i>
                                  <a href="#pablo">Actualizado</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">equalizer</i>
                                </div>
                                <p class="card-category">Fraccion</p>
                                <h3 class="card-title">{{stockN}}</h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                  <i class="material-icons">local_offer</i> Actualizado
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">store</i>
                                </div>
                                <p class="card-category">Valor Venta</p>
                                <h3 class="card-title">${{vVenta | number:0}}</h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                  <i class="material-icons">date_range</i> En tiempo real
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">favorite_border</i>
                                </div>
                                <p class="card-category">Clientes</p>
                                <h3 class="card-title">{{listadodetodos_Cliente.length}}</h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                  <i class="material-icons">update</i> Actual
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>';
                }else{
                    echo "";
                }
                
                ?>
                        <h3>Proyección</h3>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="card card-product">
                              <div class="card-header card-header-image" data-header-animation="true">
                                <a href="#pablo">
                                  <img class="img" src="assets/img/card-2.jpg">
                                </a>
                              </div>
                              <div class="card-body">
                                <div class="card-actions text-center">
                                  <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                  </button>
                                  <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                  </button>
                                  <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                  </button>
                                  <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                  </button>
                                </div>
                                <h4 class="card-title">
                                  <a >Misión</a>
                                </h4>
                                <div class="card-description">
                                 
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="price">
                                  <h4></h4>
                                </div>
                                <div class="stats">
                                  <p class="card-category"><i class="material-icons">place</i> Corozal,Sucre</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="card card-product">
                              <div class="card-header card-header-image" data-header-animation="true">
                                <a href="#pablo">
                                  <img class="img" src="assets/img/card-3.jpg">
                                </a>
                              </div>
                              <div class="card-body">
                                <div class="card-actions text-center">
                                  <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                  </button>
                                  <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                  </button>
                                  <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                  </button>
                                  <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                  </button>
                                </div>
                                <h4 class="card-title">
                                  <a href="#pablo">Visión</a>
                                </h4>
                                <div class="card-description">
                                  
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="price">
                                  <h4></h4>
                                </div>
                                <div class="stats">
                                  <p class="card-category"><i class="material-icons">place</i> Corozal,Sucre</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="card card-product">
                              <div class="card-header card-header-image" data-header-animation="true">
                                <a href="#pablo">
                                  <img class="img" src="assets/img/card-1.jpg">
                                </a>
                              </div>
                              <div class="card-body">
                                <div class="card-actions text-center">
                                  <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                  </button>
                                  <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                  </button>
                                  <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                  </button>
                                  <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                  </button>
                                </div>
                                <h4 class="card-title">
                                  <a href="#pablo">Proyecto</a>
                                </h4>
                                <div class="card-description">
                                  
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="price">
                                  <h4></h4>
                                </div>
                                <div class="stats">
                                  <p class="card-category"><i class="material-icons">place</i> Corozal,Sucre</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>