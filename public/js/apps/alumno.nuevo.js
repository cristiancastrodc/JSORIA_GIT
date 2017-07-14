// Definir la aplicación
var app = angular.module('nuevoAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('alumnoNuevoController', function ($scope, $http) {
  // Atributos
  $scope.tipo_documento = null
  $scope.nro_documento_dni = null
  $scope.nro_documento_otro = null
  $scope.nombres = null
  $scope.apellidos = null
  // Funciones
  $scope.inicializar = function () {
    $scope.tipo_documento = null
    $scope.nro_documento_dni = null
    $scope.nro_documento_otro = null
    $scope.nombres = null
    $scope.apellidos = null
  }
  $scope.esValidoFormCreacion = function () {
    return $scope.tipo_documento != null
            && ($scope.tipo_documento == 'dni' ?
                  ($scope.nro_documento_dni != null && !isNaN($scope.nro_documento_dni)) :
                  $scope.nro_documento_otro != null)
            && $scope.nombres != null
            && $scope.apellidos != null
  }
})
