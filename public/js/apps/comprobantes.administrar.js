// Definir la aplicación
var app = angular.module('administrarComprobantes', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('comprobantesController', function ($scope, $http, $filter) {
  // Atributos
  $scope.comprobantes = [];
  // Métodos que se ejecutan al iniciar el módulo
  // -- Recuperar la lista de comprobantes
  $http.get('/admin/comprobante/listar')
  .success(function(response) {
    $scope.comprobantes = response;
  });
});
