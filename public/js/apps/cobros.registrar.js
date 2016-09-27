// Definir la aplicación
var app = angular.module('registrarCobros', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('cobrosController', function ($scope, $http) {
  // Atributos
  $scope.buscando = false;
  $scope.hayResultados = false;
  $scope.codigo_cobro = '';
  // Funciones
  $scope.buscar = function (argument) {
    $scope.buscando = true;
    // Recuperar el detalle de la Institucion
    /*
    $http.get('/admin/divisiones_select/' + $scope.id_institucion)
    .success(function(response) {
      $scope.divisiones = response;
    });
    */
  };
  $scope.cancelar = function (argument) {
    $scope.buscando = false;
    $scope.hayResultados = false;
    $scope.codigo_cobro = '';
  };
});
