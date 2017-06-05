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
  $scope.listarUsuarios = function () {
    $http.get('/admin/usuario/lista')
    .success(function(response) {
      $scope.usuarios = response
    })
  }
  $scope.listarInstituciones()
  $scope.listarUsuarios()
  // Atributos
  $scope.tipos_usuario = [
    { value : 'Administrador', label : 'Administrador' },
    { value : 'Cajera', label : 'Cajera' },
    { value : 'Secretaria', label : 'Secretaria' },
    { value : 'Tesorera', label : 'Tesorera' },
  ]
  $scope.usuario = {
    dni : '',
    nombres : '',
    apellidos : '',
    login : '',
    password : '',
    tipo : null,
    permisos : null,
  }
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
    $scope.usuario = {
      dni : '',
      nombres : '',
      apellidos : '',
      login : '',
      password : '',
      tipo : null,
      permisos : '',
    }
    $scope.procesando = false
  }
  $scope.eliminarUsuario = function (id_usuario) {
    swal({
      title: '¿Realmente desea eliminar el usuario?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn-danger',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }, function () {
      var ruta = '/admin/usuario/eliminar/' + id_usuario
      $http.get(ruta)
      .success(function(response) {
        if (response.resultado == 'true') {
          swal({
            title : 'Usuario eliminado correctamente.',
            type : 'success',
          })
          $scope.listarUsuarios()
        } else {
          swal({
            title: 'Error.',
            text: 'No se pudo eliminar al usuario. Mensaje: ' + response.mensaje,
            type: 'error',
          })
        }
      })
    })
  }
  $scope.esValidoFormCreacion = function () {
    return $scope.usuario.dni != ''
           && $scope.usuario.nombres != ''
           && $scope.usuario.apellidos != ''
           && $scope.usuario.tipo != null
           && $scope.usuario.permisos != ''
           && $scope.usuario.permisos != null
           && $scope.usuario.login != ''
           && $scope.usuario.password != ''
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
.directive('tooltip', function() {
  var linker = function (scope, element, attr) {
    element.tooltip()
  }
  return {
    restrict: 'A',
    link: linker,
  }
})
.directive('chosenUpdater', function () {
  return {
    restrict: 'A',
    link : function (scope, element) {
      element.bind('click', function () {
        $('.chosen').trigger('chosen:updated')
      });
    },
  };
})
