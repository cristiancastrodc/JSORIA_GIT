// Definir la aplicación
var app = angular.module('nuevoAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('alumnoNuevoController', function ($scope, $http) {
	// Atributos
	$scope.tipo_documento = ''
	$scope.nro_documento = ''
	$scope.nombres = ''
	$scope.apellidos = ''
	$scope.nro_documento = ''
	// Funciones
	$scope.inicializar = function () {
		$scope.tipo_documento = ''
		$scope.nro_documento = ''
		$scope.nombres = ''
		$scope.apellidos = ''
		$scope.nro_documento = ''
	}
	$scope.esValidoFormCreacion = function () {
    	return $scope.tipo_documento != ''
    	&& $scope.nro_documento != ''
		&& $scope.nombres != ''
		&& $scope.apellidos != ''
		&& $scope.nro_documento != ''
  	}
})
