// Definir la aplicación
var app = angular.module('administrarUsuarios', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('usuariosController', function ($scope, $http) {
  // Procesos iniciales
  $scope.listarInstituciones = function () {
    $http.get('/usuario/instituciones')
    .success(function(response) {
      $scope.instituciones = response
    })
  }
  $scope.listarInstituciones()
  // Atributos
  $scope.tipos_usuario = [
    { value : 'Administrador', label : 'Administrador' },
    { value : 'Cajera', label : 'Cajera' },
    { value : 'Secretaria', label : 'Secretaria' },
    { value : 'Tesorera', label : 'Tesorera' },
  ]
  $scope.usuario = []
  $scope.procesando = false
  // Funciones
  $scope.guardarUsuario = function () {
    $scope.procesando = true
    var ruta = '/admin/usuarios';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        dni : $scope.usuario.dni,
        nombres : $scope.usuario.nombres,
        apellidos : $scope.usuario.apellidos,
        tipo : $scope.usuario.tipo,
        permisos : $scope.usuario.permisos,
        usuario_login : $scope.usuario.login,
        password : $scope.usuario.password,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>DNI : </strong>" + $scope.usuario.dni + "<br>"
                  + "<strong>Nombres : </strong>" + $scope.usuario.nombres + "<br>"
                  + "<strong>Apellidos : </strong>" + $scope.usuario.apellidos + "<br>"
                  + "<strong>Tipo : </strong>" + $scope.usuario.tipo + "<br>"
                  + "<strong>Usuario : </strong>" + $scope.usuario.login + "</p>"
        swal({
          title : 'Usuario creado correctamente.',
          text : texto,
          type : 'success',
          confirmButtonText: 'Aceptar',
          html: true,
          closeOnConfirm: false,
        },
        function () {
          window.location.reload()
        })
      } else {
        swal({
          title: 'Error.',
          text: 'Ocurrió un error durante el guardado. Mensaje: ' + response.data.mensaje,
          type: 'error',
        })
        $scope.procesando = false
      }
    }, function errorCallback(response) {
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
        type: 'warning',
      })
      $scope.procesando = false
    })
  }
  $scope.inicializar = function () {
    $scope.usuario = []
    $scope.procesando = false
  }
})
.directive('chosen', function() {
  var linker = function (scope, element, attr) {
    scope.$watch('instituciones', function () {
      element.trigger("chosen:updated")
    })
    element.chosen()
  }
  return {
    restrict: 'A',
    link: linker,
  }
})