// Definir la aplicación
var app = angular.module('crearMatricula', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('matriculaController', function ($scope, $http) {
  // Enlazar
  $scope.id_institucion = null;
  $scope.matricula = {
    concepto : '',
    fecha_inicio : null,
    fecha_fin : null
  };
  $scope.pensiones = {
    mes_inicio : null,
    mes_fin : null
  };
  $scope.divisiones = [];
  // Funciones
  $scope.recuperarDetalle = function () {
    // Recuperar el detalle de la Institucion
    $http.get('/admin/divisiones_select/' + $scope.id_institucion)
    .success(function(response) {
      $scope.divisiones = response;
    });
  };
  $scope.crearMatriculaPensiones = function () {
    var url = '/admin/matricula/guardar';
    $http({
      method: 'POST',
      url: url,
      data : $.param({
       id_institucion : $scope.id_institucion,
       matricula : $scope.matricula,
       pensiones : $scope.pensiones,
       divisiones : $scope.divisiones,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      console.log(response);
    }, function errorCallback(response) {
      console.log('error');
    });
  };

  $("#fecha_inicio_matricula").on("dp.change", function() {
    $scope.matricula.fecha_inicio = $("#fecha_inicio_matricula").val();
  });
  $("#fecha_fin_matricula").on("dp.change", function() {
    $scope.matricula.fecha_fin = $("#fecha_fin_matricula").val();
  });
  $("#mes_inicio_pension").on("dp.change", function() {
    $scope.pensiones.mes_inicio = $("#mes_inicio_pension").val();
  });
  $("#mes_fin_pension").on("dp.change", function() {
    $scope.pensiones.mes_fin = $("#mes_fin_pension").val();
  });

});
