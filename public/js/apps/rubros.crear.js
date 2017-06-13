// Definir la aplicación
var app = angular.module('administrarRubro', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('rubroController', function ($scope, $http) {
	// Atributos
	$scope.rubro = ''
	// Funciones
	$scope.inicializar = function () {
		$scope.rubro = ''
	}
	$scope.esValidoFormCreacion = function () {
    	return $scope.rubro != ''
  	}
})
