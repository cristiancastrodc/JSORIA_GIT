// Definir la aplicación
var app = angular.module('administrarRubro', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('rubroController', function ($scope, $http) {
	// Funciones
	$scope.inicializar = function () {
		$scope.rubro = ''
	}
})