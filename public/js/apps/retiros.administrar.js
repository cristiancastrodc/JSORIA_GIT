// Definir la aplicación
var app = angular.module('retirarIngresos', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@')
                          $interpolateProvider.endSymbol('@}')
                       })
// Definir el controlador (Tesorera)
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
      cajera  : retiro.nombres + ' ' + retiro.apellidos,
      estado  : retiro.estado == 0 ? 'Pendiente' : 'Retirado',
      fecha_hora_creacion  : retiro.fecha_hora_creacion,
      fecha_hora_retiro  : retiro.fecha_hora_retiro,
      monto  : retiro.monto,
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
    }, function () {
      var ruta = '/admin/retiro/eliminar/' + id_retiro
      $http.get(ruta)
      .then(function successCallback(response) {
        if (response.data.resultado == 'true') {
          swal({
            title : 'Retiro eliminado correctamente.',
            type : 'success',
          }, function () {
            window.location.reload()
          })
        } else {
          swal({
            title: 'Error.',
            text: 'No se pudo eliminar el retiro. Mensaje: ' + response.mensaje,
            type: 'error',
          })
        }
      }, function errorCallback(response) {
        debug(response, false)
        swal({
          title: 'Error.',
          text: 'No se pudo eliminar el retiro.',
          type: 'error',
        })
      })
    })
  }
  $scope.inicializar = function () {
    // Tabla de ingresos por cajera
    $('#form-detalle-retiro').addClass('hidden')
    $('#tabla-ingresos-cajera > tbody').empty()
    $('#cobros-no-retirados').html('0.00')
    $('#cobros-por-retirar').html('0.00')
    // Form búsqueda de cajera
    $('#id_cajera').val('').selectpicker('refresh')
  }
})
// Definir el controlador (Cajera)
app.controller('retirosCajeraController', function($scope, $http){
  $scope.retiro = {
    id : '',
    detalle : [],
  }
  $scope.mostrarDetalleRetiro = function (item) {
    $scope.retiro.id = angular.element(item.target).data('id')
    var ruta = '/cajera/retiro/detalle/' + $scope.retiro.id
    $http.get(ruta)
    .then(function (response) {
      $scope.retiro.detalle = response.data
    })
    $('#modal-detalle-retiro').modal('show')
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
