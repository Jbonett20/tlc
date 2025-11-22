app.factory("sessionService", function ($http) {
  //var API_URI = 'api/';
  return {
    set: function (key, value) {
      /**
       * Ajoute des variable de session clé, valeur
       */
      return sessionStorage.setItem(key, value);
    },
    get: function (key) {
      /**
       * Permet de recupperer la valeur d'une variable de session par sa clé
       */
      return sessionStorage.getItem(key);
    },
    destroy: function (key) {
      /**
       * Ici je détruis toutes les variables de  session coté client
       */
      $http.post("data/destroy_session.php");
      return sessionStorage.removeItem(key);
    },
  };
});

app.factory(
  "loginService",
  function ($window, $http, $location, sessionService) {
    return {
      login: function (user, $scope) {
        console.log("logueando");
        var $promise = $http.post("data/user.php", user); //  vous pouvez passer par le success et error de $http
        $promise.then(function (msg) {
          var uid = msg.data;
          if (uid) {
            if (uid == "Datos Ingresados Incorrectos") {
              // console.log("esta mal logiado");

              new PNotify({
                title: "Error!",
                text: "Por favor Verifique Su Usuario o Password",

                styling: "bootstrap3",
              });
            }
            // else if (uid == "Pin Ingresado Incorrecto")
            // {
            //    $('#pin_login_error').modal({
            //         keyboard: false
            //       });
            // }
            else if (uid == "Negado") {
              new PNotify({
                title: "Error!",
                text: "Los Permisos para este usuario esta negados",

                styling: "bootstrap3",
              });
            } else if (uid == "Desactivado") {
              new PNotify({
                title: "Error!",
                text: "Los permisos para este usuario ha sido desactivados",

                styling: "bootstrap3",
              });
            } else if (uid == "no cumple") {
              new PNotify({
                title: "Error!",
                text: "Los permisos para este usuario han sido caducados",

                styling: "bootstrap3",
              });
            } else if (uid == "error estado") {
              new PNotify({
                title: "Error!",
                text: "Error en el esatdo del usuario por favor comuniquese con el administrador",

                styling: "bootstrap3",
              });
            } else {
              var data = uid.split("-");
              sessionService.set("user", data[0]);

              if (data[1] == 2) {
                $location.path("/inventario");
              } else {
                $location.path("/facturar");
              }

              setTimeout(()=>{location.reload(true);},50)
              
              // sessionService.set('user', uid);
              // $location.path('/home');
              //  location.reload(true);
            }
          } else {
            location.reload(true);
            $location.path("/login");
            //$scope.msgtext = 'error infromacion';
          }
        });
      },
      logout: function () {
        sessionService.destroy("uid"); //destruction de la session coté client
        //$http.post('API/DESTROY/');//destruction de la session coté serveur
        location.reload(true);
        $location.path("/login"); // redirection vers la page du login
      },
      isLogged: function () {
        /**
         * Pour plus de sécurité j'envoie  la variable de session user à mon serveur qui devrait avoir la même
         * Si ce n'est pas le cas le serveur ne renvoie rien et la redirection est faite sur authentificationApp
         * (app.js line 18) via le logout qui détruit la session client et de même du côté du serveur
         */
        /* if(sessionService.get('user'))
          {
            return true;
          }*/
        //var  $checkSessionServer = $http.get('API/CHECK_SESSION/?user='+user);
        var user = sessionService.get("user");
        var $checkSessionServer = $http.get("data/check_session.php");
        return $checkSessionServer;
      },
    };
  }
);
