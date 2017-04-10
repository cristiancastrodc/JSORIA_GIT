// Definir la aplicación
var app = angular.module('registrarIngresoAdicional', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('registrarIngresoController', function ($scope, $http) {
  // Procesos iniciales
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
$scope.inicializar = function () {
	$scope.institucion = null
	$scope.monto = ''	
}
})