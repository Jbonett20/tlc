  <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-1.jpg">
             
                
                <div class="logo">
                    <a href="" class="simple-text">
                        Farma System <br>Donde Alex
                    </a>
                </div> <div class="logo">
                  <h4 align="center"><?php echo $_SESSION['nombre_usuario']; ?></h4>
                </div>

<div class="sidebar-wrapper">
    <ul class="nav">
        <li class="" id="lista">
            <a href="#/facturar" accesskey="q">
                <i class="material-icons">dashboard</i>
                <p>Factura</p>
            </a>
        </li>
         <?php
                if ($_SESSION['tipo']==0) {
                  
                
        echo '<li class="" id="lista">
            <a href="#/ingresos"  accesskey="i">
                <i class="material-icons">add_shopping_cart</i>
                <p>Ingresos</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="inventario.php" accesskey="v">
                <i class="material-icons">assignment</i>
                <p>Inventario</p>
            </a>
        </li>
         <li class="" id="lista">
            <a href="#/devolucion" accesskey="u">
                <i class="material-icons">Devoluciones</i>
                <p>Devoluciones</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="#/categoria" accesskey="c">
                <i class="material-icons">chrome_reader_mode</i>
                <p>Categoria</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="#/empresa" accesskey="l">
                <i class="material-icons">location_city</i>
                <p>Empresa</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="#/clientes" accesskey="t">
                <i class="material-icons">group</i>
                <p>Clientes</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="#/credito" accesskey="r">
                <i class="material-icons">credit_card</i>
                <p>Creditos</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="#/productos" accesskey="p">
                <i class="material-icons">beach_access</i>
                <p>Productos</p>
            </a>
        </li>
        <li class="" id="lista">
            <a href="#/proveedores" accesskey="d">
                <i class="material-icons">beach_access</i>
                <p>Proveedores</p>
            </a>
        </li>
       
        <li class="" id="lista">
            <a href="#/admin" accesskey="m">
                <i class="material-icons">library_books</i>
                <p>Datos Administrativos</p>
            </a>
        </li>
        
       
        ';
        }else{
                    echo "";
                }
                
                ?>
                 <li  class="" id="lista">
            <a href="#/tipoEgreso" accesskey="g">
                <i class="material-icons">unarchive</i>
                <p>Egresos</p>
            </a>
        </li>
                 <li class="">
            <a href="data/cerrar_session.php" accesskey="s">
                <i class="material-icons">exit_to_app</i>
                <p>Salir</p>
            </a>
        </li>
    </ul>

</div>
  </div>