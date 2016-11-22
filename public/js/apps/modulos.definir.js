// Definir la aplicación
var app = angular.module('definirModulosUsuario', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('modulosController', function ($scope, $http, $filter) {
  // Atributos
  $scope.usuarios = [];
  $scope.modulos = [];
  // Métodos que se ejecutan al iniciar el módulo
  // -- Recuperar las instituciones del usuario
  $http.get('/admin/usuario/lista')
  .success(function(response) {
    $scope.usuarios = response;
  });
  // Funciones
  $scope.cargarModulos = function () {
    var ruta = '/admin/usuario/'+ $scope.usuario.id + '/modulos';
    $http.get(ruta)
    .success(function(response) {
      $scope.modulos = response;
    });
  }
  $scope.guardarModulos = function () {
    var ruta = '/admin/usuario/modulos/grabar'
    var modulosSeleccionadas = $filter('filter')($scope.modulos, { seleccionado : true });
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_usuario : $scope.usuario.id,
       modulos : modulosSeleccionadas,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : "Éxito!",
          text : "Módulos de usuario actualizados correctamente.",
          type : "success",
          confirmButtonText: "Aceptar",
          closeOnConfirm: false,
        }, function () {
          document.location.reload();
        });
      } else {
        swal({
          title: response.data.mensaje.titulo,
          text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos. Excepción: " + response.data.mensaje.contenido,
          type: "warning"
        }, function () {
          document.location.reload();
        });
      }
    }, function errorCallback(response) {
      console.log('Internal Error');
    });
  }
});
