// Definir la aplicación
var app = angular.module('cobrosOrdinarios', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('crearCobroOrdinarioController', function ($scope, $http) {
  // Atributos
  $scope.cobroOrdinario = {
    'institucion' : null,
    'nombre' : '',
    'monto' : '',
    'con_factor' : false,
    'destino' : false,
    'estado' : false,
  }
  $scope.procesando = false
   // Procesos iniciales
   $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Funciones
  $scope.guardarCobroOrdinario = function () {
    $scope.procesando = true
    var ruta = '/admin/cobros/ordinarios';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_institucion : $scope.cobroOrdinario.institucion.id_institucion,
       nombre : $scope.cobroOrdinario.nombre,
       monto : $scope.cobroOrdinario.monto,
       con_factor : $scope.cobroOrdinario.con_factor,
       destino : $scope.cobroOrdinario.destino,
       estado : $scope.cobroOrdinario.estado,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      debug(response, false)
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>Institución : </strong>" + $scope.cobroOrdinario.institucion.nombre + "<br>"
                  + "<strong>Descripción : </strong>" + $scope.cobroOrdinario.nombre + "<br>"
                  + "<strong>Monto : </strong>" + $scope.cobroOrdinario.monto + "<br>"
                  + "<strong>Habilitado : </strong>" + ($scope.cobroOrdinario.estado ? "Si" : "No") + "<br>"
                  + "<strong>Es Monto Unitario : </strong>" + ($scope.cobroOrdinario.con_factor ? "Si" : "No") + "<br>"
                  + ($scope.cobroOrdinario.destino ? "* Este concepto almacena los ingresos en la cuenta exterior privada." : "") + "</p>";
        swal({
          title : "Concepto creado correctamente.",
          text : texto,
          type : "success",
          confirmButtonText: "Aceptar",
          html: true,
        }, function () {
          $scope.procesando = false
          $scope.cobroOrdinario = {
            'id_institucion' : null,
            'nombre' : '',
            'monto' : '',
            'con_factor' : false,
            'destino' : false,
            'estado' : false,
          }
          $scope.$apply();
          $('.selectpicker').selectpicker('refresh');
        });
      } else {
        debug(response.data.mensaje)
        swal({
          title: 'Error.',
          text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
          type: "warning",
        });
      }
    }, function errorCallback(response) {
      debug('Error')
    });
  }
  $scope.inicializar = function () {
    $scope.cobroOrdinario = []
    $scope.cobroOrdinario.institucion = null
    $scope.$apply()
    $('.selectpicker').selectpicker('refresh')
  }
});
