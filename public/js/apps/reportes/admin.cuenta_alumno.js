// Definir la aplicación
var app = angular.module('reporteCuentaAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('reporteCuentaAlumnoController', function ($scope, $http, $filter) {
  // Atributos
  $scope.buscando = false;
  $scope.hayAlumno = false;
  $scope.alumno = [];
  $scope.periodos = [];
  // Funciones
  $scope.buscar = function () {
    $scope.buscando = true;
    // Recuperar el detalle del alumno
    var ruta = '/admin/reportes/cuenta_alumno/' + $scope.alumno.nro_documento + '/periodos';
    $http.get(ruta)
    .success(function(response) {
        $scope.periodos = response.periodos;
        $scope.alumno = response.alumno;
        $scope.hayAlumno = true;
    });
    $scope.buscando = false;
  };
  $scope.cancelar = function () {
    $scope.buscando = false;
    $scope.hayAlumno = false;
    $scope.periodos = [];
  }
});
