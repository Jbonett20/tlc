<?php
session_start();
?>
<!DOCTYPE html>
<html ng-app="software">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
    <link rel="icon" type="image/png" href="img/icono.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
    AppTuring
    </title>
    
    
    <!-- CSS Files -->
    <!-- <link rel="stylesheet" href="css/login.css"> -->
    <link href="css/material-dashboard.min.css?v=2.0.2" rel="stylesheet" />
    <link href="dist/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="dist/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="dist/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <link rel="stylesheet" href="material/css.css"> 
    <script src="js/accessKey.js"></script>
    <link rel="stylesheet" href="css/estilo.css?v=2">
    <link rel="stylesheet" href="css/iconos.css">
   

  <body class="sidebar-mini">
  <div class="loader"></div>

     <?php
          if (isset($_SESSION['nombre_usuario'])) {
          ?>
    <div class="wrapper ">
      
      <div class="sidebar" data-color="rose" data-background-color="black" data-image="img/sidebar-1.jpg">
        
        <div class="logo"><a href="#" class="simple-text logo-mini">
          JC
        </a>
        <a href="#" class="simple-text logo-normal">
          AppTuring
        </a></div>
        <div class="sidebar-wrapper">
          
          <div class="user">
            <div class="photo">
              <img src= <?php echo $_SESSION['img']; ?>  />
            </div>
            <div class="user-info">
              <a data-toggle="collapse" class="username">
                <span>
                 <?php 
                 echo strtoupper ($_SESSION['nombre_usuario']);
                  ?>
                  <b class="caret"></b>
                </span>
              </a>
              <!-- <div class="collapse" id="collapseExample">
                <ul class="nav">
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span class="sidebar-mini"> MP </span>
                      <span class="sidebar-normal"> My Profile </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span class="sidebar-mini"> EP </span>
                      <span class="sidebar-normal"> Edit Profile </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span class="sidebar-mini"> S </span>
                      <span class="sidebar-normal"> Settings </span>
                    </a>
                  </li>
                </ul>
              </div> -->
            </div>
          </div>
         

         
         
          <ul class="nav">
            <li class="nav-item" id="lista">
              <a class="nav-link" href="#/facturar" accesskey="q">
                <i class="material-icons">dashboard</i>
                <p>Factura</p>
              </a>
            </li>
            <?php
            if ($_SESSION['tipo']==0) {
            
            
            echo '<li class="nav-item" id="lista">
              <a  class="nav-link" href="#/ingresos"  accesskey="i">
                <i class="material-icons">add_shopping_cart</i>
                <p>Ingresos</p>
              </a>
            </li>
            <li class="nav-item" id="lista" >
              <a class="nav-link" href="#/inventario" accesskey="v" >
                <i class="material-icons">assignment</i>
                <p>Inventario</p>
              </a>
            </li>
            <li class="nav-item" id="lista" ng-click="buscaDevoluciones()">
              <a  class="nav-link" href="#/devolucion" accesskey="u">
                <i class="material-icons">compare_arrows</i>
                <p>Devoluciones</p>
              </a>
            </li>
            <li class="nav-item" id="lista" ng-click="buscaDevoluciones()">
              <a  class="nav-link" href="#/movimiento" accesskey="k">
                <i class="material-icons">flight_takeoff</i>
                <p>Movimiento</p>
              </a>
            </li>  
             <li class="nav-item" id="lista" ng-click="buscaDevoluciones()">
              <a  class="nav-link" href="#/stockBajo" accesskey="z">
                <i class="material-icons">move_to_inbox</i>
                <p>Stock Bajo</p>
              </a>
            </li> 
            
            
            </li>
            <li class="nav-item" id="lista">
              <a  class="nav-link" href="#/clientes" accesskey="t">
                <i class="material-icons">group</i>
                <p>Clientes</p>
              </a>
            </li>
            <li class="nav-item" id="lista">
              <a  class="nav-link" href="#/credito" accesskey="r">
                <i class="material-icons">credit_card</i>
                <p>Creditos</p>
              </a>
            </li>
            <li class="nav-item" id="lista">
              <a  class="nav-link" href="#/productos" accesskey="p">
                <i class="material-icons">shopping_basket</i>
                <p>Productos</p>
              </a>
            </li>
            <li class="nav-item" id="lista">
              <a  class="nav-link" href="#/proveedores" accesskey="d">
                <i class="material-icons">account_box</i>
                <p>Proveedores</p>
              </a>
            </li>
          
            <li class="nav-item" id="lista">
              <a  class="nav-link" href="#/admin" accesskey="m">
                <i class="material-icons">library_books</i>
                <p>Datos Administrativos</p>
              </a>
            </li>
            
            
            ';
            }else{
            echo "";
            }
            
            ?>
              <li  class="nav-item" id="lista">
              <a class="nav-link"  href="#/tipoEgreso" accesskey="g">
                <i class="material-icons">unarchive</i>
                <p>Egresos</p>
              </a>
            </li>
             <li class="nav-item" id="lista">
              <a  class="nav-link" href="#/configuracion" accesskey="c">
                <i class="material-icons">settings</i>
                <p>Configuración</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="data/cerrar_session.php" accesskey="s">
                <i class="material-icons">exit_to_app</i>
                <p>Salir</p>
              </a>
            </li>
          </ul>
       
          
        </div>
      </div>
      <div class="main-panel">

        <!-- boton  collapso-->
         <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  " id="navigation-example">
          <div class="container-fluid">
            <div class="navbar-wrapper">
              <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                </button>
              </div>
              
              
            </div>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end">
              
              
            
            </div>
          </div>
        </nav>
       
        <?php 
      }
         ?>
        <div class="content">
          
          
            <div class="container-fluid">
              
              <div class="row" ng-view>
                <?php
                include('views/login.php');
                ?>
              </div>
              
            </div>
            
          
          
        </div>
         <?php
          if (isset($_SESSION['nombre_usuario'])) {
          ?>
        <!-- <div class="fixed-plugin">
          <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
              <i class="material-icons">settings</i>
            </a>
            <ul class="dropdown-menu">
              <li class="header-title"> Sidebar Filters</li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color ">
                  <div class="badge-colors ml-auto mr-auto">
                    <span class="badge filter badge-purple" data-color="purple"></span>
                    <span class="badge filter badge-azure" data-color="azure"></span>
                    <span class="badge filter badge-green" data-color="green"></span>
                    <span class="badge filter badge-warning" data-color="orange"></span>
                    <span class="badge filter badge-danger" data-color="danger"></span>
                    <span class="badge filter badge-rose active" data-color="rose"></span>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </li>
              
              <li class="header-title">Sidebar Background</li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger background-color">
                  <div class="ml-auto mr-auto">
                    <span class="badge filter badge-black active" data-background-color="black"></span>
                    <span class="badge filter badge-white" data-background-color="white"></span>
                    <span class="badge filter badge-red" data-background-color="red"></span>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                  <p>Sidebar Mini</p>
                  <label class="ml-auto">
                    <div class="togglebutton switch-sidebar-mini">
                      <label>
                        <input type="checkbox">
                        <span class="toggle"></span>
                      </label>
                    </div>
                  </label>
                  <div class="clearfix"></div>
                </a>
              </li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                  <p>Sidebar Images</p>
                  <label class="switch-mini ml-auto">
                    <div class="togglebutton switch-sidebar-image">
                      <label>
                        <input type="checkbox" checked="">
                        <span class="toggle"></span>
                      </label>
                    </div>
                  </label>
                  <div class="clearfix"></div>
                </a>
              </li>
              <li class="header-title">Images</li>
              <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="img/sidebar-1.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="img/sidebar-2.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="img/sidebar-3.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="img/sidebar-4.jpg" alt="">
                </a>
              </li>
            </ul>
          </div>
        </div> -->
        <?php 
}
         ?>
         
        <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <!-- todo lo nuevo de angular -->
        <!-- menu estilos -->
        <script src="js/menu.js"></script>
        <script src="js/tabla.js"></script>
        <script src="js/angular.min.js" ></script>
        <script src="js/Chart.js"></script>
        <script src="js/angular-chart.js"></script>
        <!-- app donde esta el modulo de angular -->
        <script src="js/app.js"></script>
        <!-- controlador -->
        <script src="js/controlador.js" ></script>
        <!-- <script src="js/angular-pagination.js" ></script> -->
        <!--   Core JS Files   -->
        <script src="js/services.js"></script>
        
        <script src="js/ui-bootstrap-tpls-1.3.2.js"></script>

        <!-- <script src="js/ui-bootstrap-tpls-2.4.0.min.js"></script> -->

        <script src="js/angular-animate.min.js"></script>
        <script src="js/angular-pagination.js"></script>
        <script src="js/Chart.js"></script>
        <script src="js/angular-chart.min.js"></script>
        <script src="js/angular-route.js"></script>
        <script src="js/Chart.js"></script>
        
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- <script src="js/material.min.js" type="text/javascript"></script> -->
        <script src="js/scriptCECM.js" type="text/javascript"></script>
        <script src="js/percenj-filter.js" type="text/javascript"></script>
        <script src="dist/pnotify/dist/pnotify.js"></script>
        <script src="dist/pnotify/dist/pnotify.buttons.js"></script>
        <script src="dist/pnotify/dist/pnotify.nonblock.js"></script>
        <!-- <script src="assets/js/menu.js"></script> -->
        
        <!--   Core JS Files   -->
        <script src="js/core/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery-preloader.min.js" type="text/javascript"></script>
        <script src="js/preloader-jar.js" type="text/javascript"></script>
        <!-- modales -->
        <script src="js/modales.js" type="text/javascript"></script>

        <script src="js/core/popper.min.js" type="text/javascript"></script>
        <script src="js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
        <script src="js/plugins/perfect-scrollbar.jquery.min.js" ></script>
        <!-- Plugin for the momentJs  -->
        <script src="js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="js/plugins/sweetalert2.js"></script>
        <script src="js/plugins/jquery.bootstrap-wizard.js"></script>
        
        <script src="js/plugins/bootstrap-selectpicker.js" ></script>
        
        <script src="js/plugins/bootstrap-datetimepicker.min.js"></script>
        
        <script src="js/plugins/jquery.dataTables.min.js"></script>
        
        <script src="js/plugins/bootstrap-tagsinput.js"></script>
        
        <script src="js/plugins/jasny-bootstrap.min.js"></script>
        
        
        <script src="js/plugins/jquery-jvectormap.js"></script>
        
        <script src="js/plugins/nouislider.min.js" ></script>
        
        <script src="js/plugins/arrive.min.js"></script>
        
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="js/buttons.js"></script>
        <!-- Chartist JS -->
        <script src="js/plugins/chartist.min.js"></script>
        
        <script src="js/plugins/bootstrap-notify.js"></script>
        <script src="js/material-dashboard.min.js?v=2.0.2" type="text/javascript"></script>
        <script src="js/plugins/menu.js"></script>
        <!-- <script src="js/plugins/datatime.js"></script> -->
        
 
      </body>
    </html>