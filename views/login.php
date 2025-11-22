<?php   
  //$_SESSION['ejecutado'];


?>
<link rel="stylesheet" href="css/login.css">
<script>
	document.getElementById("user").focus();
</script>
<div class="signupform">
  <div class="container">
    <!-- main content -->
    <div class="agile_info">
      <div class="w3l_form">
        <div class="left_grid_info">
          <h1>Bienvenidos a TuingApp..!! </h1>
          <p>Manten en control todos tus negocios</p>
          <img src="img/image.jpg" alt="" />
        </div>
      </div>
      <div class="w3_info">
        <h2>Accede con tu cuenta</h2>
        <p>Detalles de la cuenta</p>
        <form>
          <label>Usuarios</label>
          <div class="input-group">
            <span class="fa fa-envelope" aria-hidden="true"></span>
            <input type="text" placeholder="Usuario" required="" ng-model="user.usuario" type="text" autofocus="" id="user"> 
          </div>
          <label>Contraseña</label>
          <div class="input-group">
            <span class="fa fa-lock" aria-hidden="true"></span>
            <input type="Password" placeholder="Contraseña" required="" ng-model="user.clave"  value="" ng-keypress="loginkey(e,user)">
          </div> 
            <button class="btn btn-danger btn-block" ng-click="login(user)">Ingresar</button >                
        </form>
      
      </div>
    </div>
    <!-- //main content -->
  </div>
 
</div>

	<!-- <div class="container">
    <div class="col-lg-4 col-md-6 col-sm-6 ml-auto mr-auto">
      <form class="form" role="form">
        <div class="card card-login card-hidden">
          <div class="card-header card-header-rose text-center">
            <h4 class="card-title">Login</h4>
            <div class="social-line">
              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                <i class="material-icons">perm_contact_calendar</i>
              </a>
            </div>
          </div>
          <div class="card-body ">
            <p class="card-description text-center">Datos</p>
            <span class="bmd-form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">face</i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="Usuario" ng-model="user.usuario" type="text" autofocus="" id="user">
              </div>
            </span>
       
            <span class="bmd-form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" class="form-control" placeholder="Contraseña" ng-model="user.clave" name="password" type="password" value="" ng-keypress="loginkey(e,user)">
              </div>
            </span>
          </div>
          <div class="card-footer justify-content-center">
            <button  class="btn btn-primary" ng-click="login(user)">Ingresar</button>
          </div>
        </div>
      </form>
    </div>
  </div>


 -->