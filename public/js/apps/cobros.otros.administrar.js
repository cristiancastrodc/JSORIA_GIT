// Definir la aplicación
var app = angular.module('otrosCobros', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('crearOtroCobroController', function ($scope, $http) {
  // Atributos
  $scope.institucion = ''
  $scope.nombre = ''
  $scope.monto = ''
  $scope.destino = false
  $scope.estado = false
  $scope.procesando = false
  // Procesos iniciales
   $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
    });
  // Funciones
  $scope.guardarOtroCobro = function () {
    $scope.procesando = true
    var ruta = '/admin/cobros/otros';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_institucion : $scope.institucion.id_institucion,
       nombre : $scope.nombre,
       monto : $scope.monto,
       destino : $scope.destino,
       estado : $scope.estado,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      debug(response, false)
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>Institución : </strong>" + $scope.institucion.nombre + "<br>"
                  + "<strong>Descripción : </strong>" + $scope.nombre + "<br>"
                  + "<strong>Monto : </strong>" + $scope.monto + "<br>"
                  + "<strong>Habilitado : </strong>" + ($scope.estado ? "Si" : "No") + "<br>"
                  + ($scope.destino ? "* Este concepto almacena los ingresos en la cuenta exterior privada." : "") + "</p>";
        swal({
          title : "Concepto creado correctamente.",
          text : texto,
          type : "success",
          confirmButtonText: "Aceptar",
          html: true,
        }, function () {
          $scope.procesando = false
          $scope.institucion = ''
          $scope.nombre = ''
          $scope.monto = ''
          $scope.destino = false
          $scope.estado = false
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
    $scope.institucion = ''
    $scope.nombre = ''
    $scope.monto = ''
    $scope.destino = false
    $scope.estado = false
    $scope.procesando = false
  }
});
