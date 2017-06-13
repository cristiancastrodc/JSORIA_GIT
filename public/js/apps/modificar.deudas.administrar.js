// Definir la aplicación
var app = angular.module('modificarDeuda', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('modificarDeudaController', function ($scope, $http) {
	// Atributos
	$scope.nro_documento = ''
	// Funciones
	$scope.inicializar = function () {
		$scope.nro_documento = ''
		$scope.resolucion = ''
		$('#tabla-deudas-alumno tbody').empty()
	}
})
