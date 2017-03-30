// Definir la aplicación
var app = angular.module('retirarIngresos', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@')
                          $interpolateProvider.endSymbol('@}')
                       })
// Definir el controlador
app.controller('retirosController', function ($scope, $http) {
  // Procesos iniciales
  $scope.listarRetiros = function () {
    $http.get('/admin/retiros/listar')
    .success(function(response) {
      $scope.retiros = response
    })
  }
  $scope.listarRetiros()
  // Atributos
  $scope.retiros_pendientes = 1
  $scope.retiros = []
  $scope.modal = []
  // Funciones
  $scope.filtrarRetiros = function (retiro) {
    return retiro.estado == 0 || retiro.estado == !$scope.retiros_pendientes;
  }
  $scope.mostrarDetalle = function (retiro) {
    $scope.modal = {
      id_retiro  : retiro.id,
      cajera  : retiro.nombres + ' ' + retiro.apellidos,
      estado  : retiro.estado == 0 ? 'Pendiente' : 'Retirado',
      fecha_hora_creacion  : retiro.fecha_hora_creacion,
      fecha_hora_retiro  : retiro.fecha_hora_retiro,
      monto  : retiro.monto,
      puede_eliminar  : retiro.estado == 0,
    }
    $('#modal-detalle-retiro').modal('show')
  }
  $scope.eliminarRetiro = function (id_retiro) {
    swal({
      title : '¿Realmente desea eliminar el retiro?',
      text : 'Esta acción no se puede deshacer.',
      type : 'warning',
      showCancelButton : true,
      cancelButtonText : 'Cancelar',
      confirmButtonText : 'Aceptar',
      confirmButtonClass : 'btn-danger',
    },
    function () {
      var ruta = '/admin/retiro/eliminar/' + id_retiro
      $http.get(ruta)
      .success(function(response) {
        if (response.resultado == 'true') {
          swal({
            title : 'Retiro eliminado correctamente.',
            type : 'success',
          })
          $('#modal-detalle-retiro').modal('hide')
          $scope.listarRetiros()
        } else {
          debug(response.mensaje)
          swal({
            title: 'Error.',
            text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos. Mensaje: ' + response.mensaje,
            type: 'error',
          })
        }
      })
    })
  }
})
