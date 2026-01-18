// 'use strict'

var app = angular.module('software',['ngRoute','ngAnimate','ui.bootstrap','chart.js']);
app.config(function($routeProvider){
    $routeProvider
        
        .when('/home',
        {
            templateUrl: 'views/home.php',
            controller: 'ventas'
        })
        .when('/ingresos',
        {
            templateUrl: 'views/ingresos.php',
            controller: 'ventas'
        })
        .when('/facturar',
        {
            templateUrl: 'views/facturar.php',
            controller: 'ventas'
        })
        .when('/inventario',
        {
            templateUrl: 'views/inventario.php',
            controller: 'ventas'
        }).when('/categoria',
        {
            templateUrl: 'views/categoria.php',
            controller:'ventas'

        }).when('/configuracion',
        {
            templateUrl: 'views/configuracion.php',
            controller:'ventas'

        }).when('/devolucion',
        {
            templateUrl: 'views/devoluciones.php',
            controller:'ventas'

        }).when('/clientes',
        {
            templateUrl: 'views/clientes.php',
            controller:'ventas'

        }).when('/productos',
        {
            templateUrl: 'views/producto.php',
            controller:'ventas'

        })

        .when('/login',
        {
            templateUrl : 'views/login.php',
            controller : 'loginCtrl'
        }) .when('/tipoEgreso',
        {
            templateUrl: 'views/TipoEgresos.php',
            controller: 'ventas'

        })

        .when('/plansepare',
        {
            templateUrl : 'views/plansepare.php',
            controller : 'ventas'
        })
        .when('/credito',
        {
            templateUrl : 'views/credito.php',
            controller : 'ventas'
        })  .when('/movimiento',
        {
            templateUrl : 'views/movimiento.php',
            controller : 'ventas'
        }) .when('/stockBajo',
        {
            templateUrl : 'views/productosBajo.php',
            controller : 'ventas'
        }) .when('/proveedores',
        {
            templateUrl : 'views/proveedores.php',
            controller : 'ventas'
        }) .when('/proyecto',
        {
            templateUrl : 'views/proyecto.php',
            controller : 'ventas'
        }).when('/admin',
        {
            templateUrl : 'views/DatosAdministrativos.php',
            controller : 'ventas'
        });
    
    $routeProvider.otherwise({redirectTo: '/home'});
});

app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/plansepare'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});

app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/home'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});

app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/ingresos'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/facturar'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/inventario'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/categoria'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});

app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/empresa'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/clientes'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/productos'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/login'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/proveedores'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/credito'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});

app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/tipoEgreso'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});
app.run(function($rootScope, $location, loginService){
    var routesPermissions = ['/admin'];
    $rootScope.$on('$routeChangeStart', function(){
         if (routesPermissions.indexOf($location.path())!=-1){
             var connected = loginService.isLogged();
             connected.then(function(msg){
                if (!msg.data) {
                    $location.path('/login'); // this redirect and delete data entered manually
                    //$location.path(/login);
                }
             });
        }
    });
});

