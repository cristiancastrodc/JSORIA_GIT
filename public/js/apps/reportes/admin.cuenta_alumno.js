// Definir la aplicación
var app = angular.module('reporteCuentaAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('reporteCuentaAlumnoController', function ($scope, $http) {
  // Atributos
  $scope.buscando = false;
  $scope.hayAlumno = false;
  $scope.alumno = [];
  $scope.categorias = [];
  $scope.periodo = {
    id : '',
    periodo : '',
  }
  // Funciones
  $scope.buscar = function () {
    $scope.buscando = true;
    // Recuperar el detalle del alumno
    var ruta = '/admin/reportes/cuenta_alumno/' + $scope.alumno.nro_documento + '/periodos';
    $http.get(ruta)
    .then(function(response) {
      if (response.data.resultado == 'true') {
        $scope.categorias = response.data.periodos;
        $scope.alumno = response.data.alumno;
        $scope.hayAlumno = true;
      } else {
        swal({
          title : 'Error.',
          text  : response.data.mensaje,
          type  : 'error',
          confirmButtonText : 'Aceptar',
        })
      }
      $scope.buscando = false;
    });
  };
  $scope.cancelar = function () {
    $scope.buscando = false;
    $scope.hayAlumno = false;
    $scope.categorias = [];
  }
});
