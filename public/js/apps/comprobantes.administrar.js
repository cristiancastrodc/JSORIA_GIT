// Definir la aplicación
var app = angular.module('administrarComprobantes', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('comprobantesController', function ($scope, $http) {
  // Atributos
  $scope.instituciones = []
  $scope.comprobantes = []
  $scope.tipos_comprobante = [
    { value : 'comprobante', label : 'Comprobante' },
    { value : 'boleta', label : 'Boleta' },
    { value : 'factura', label : 'Factura' },
  ]
  $scope.comprobante = {
    tipo : '',
    serie : '',
    numero : '',
    institucion : [],
  }
  $scope.procesando = false
  $scope.modal = {
    procesando : false,
    comprobante : [],
  }
  // Métodos que se ejecutan al iniciar el módulo
  // -- Recuperar instituciones del usuario
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response
  });
  // -- Recuperar la lista de comprobantes
  $http.get('/admin/comprobante/listar')
  .success(function(response) {
    $scope.comprobantes = response;
  });
  // Funciones
  $scope.guardarComprobante = function () {
    $scope.procesando = true
    var ruta = '/admin/comprobante/guardar';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        tipo_comprobante : $scope.comprobante.tipo.value,
        serie_comprobante : $scope.comprobante.serie,
        numero_comprobante : $scope.comprobante.numero,
        id_institucion : $scope.comprobante.institucion.id_institucion,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>Tipo : </strong>" + $scope.comprobante.tipo.label + "<br>"
                  + "<strong>Serie : </strong>" + $scope.comprobante.serie + "<br>"
                  + "<strong>Número : </strong>" + $scope.comprobante.numero + "<br>"
                  + "<strong>Institución : </strong>" + $scope.comprobante.institucion.nombre + "</p>"
        swal({
          title : 'Comprobante creado correctamente.',
          text : texto,
          type : "success",
          confirmButtonText: "Aceptar",
          html: true,
        });
      } else {
        debug(response.data.mensaje)
        swal({
          title: 'Error.',
          text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
          type: "warning",
        });
      }
      // Inicializar
      $scope.inicializar()
      $scope.listarComprobantes()
    }, function errorCallback(response) {
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
        type: "warning",
      });
      // Inicializar
      $scope.inicializar()
    });
  }
  $scope.inicializar = function () {
    $scope.comprobante = {
      tipo : '',
      serie : '',
      numero : '',
      institucion : [],
    }
    $scope.procesando = false
  }
  $scope.listarComprobantes = function () {
    // -- Recuperar la lista de comprobantes
    $http.get('/admin/comprobante/listar')
    .success(function(response) {
      $scope.comprobantes = response;
    });
  }
  $scope.editarComprobante = function (comprobante) {
    $scope.modal.comprobante = comprobante
    $('#modal-detalle-comprobante').modal('show')
  }
  $scope.actualizarComprobante = function () {
    $scope.modal.procesando = true
    var ruta = '/admin/comprobante/actualizar/' + $scope.modal.comprobante.id;
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        serie_comprobante : $scope.modal.comprobante.serie,
        numero_comprobante : $scope.modal.comprobante.numero_comprobante,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      $('#modal-detalle-comprobante').modal('hide')
      if (response.data.resultado == 'true') {
        swal({
          title : 'Comprobante actualizado correctamente.',
          type : 'success',
        })
        $scope.listarComprobantes()
      } else {
        debug(response.data.mensaje)
        swal({
          title: 'Error.',
          text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
          type: 'warning',
        })
      }
      $scope.modal.procesando = false
    }, function errorCallback(response) {
      $('#modal-detalle-comprobante').modal('hide')
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
        type: 'error',
      })
      $scope.modal.procesando = false
    });
  }
  $scope.confirmarEliminacion = function (id) {
    swal({
      title: '¿Realmente desea eliminar el comprobante?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn-danger',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }, function () {
      var ruta = '/admin/comprobante/eliminar/' + id
      $http.get(ruta)
      .success(function(response) {
        if (response.resultado == 'true') {
          swal({
            title : 'Comprobante eliminado correctamente.',
            type : 'success',
          })
          $scope.listarComprobantes()
        } else {
          debug(response.mensaje)
          swal({
            title: 'Error.',
            text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
            type: 'error',
          })
        }
      })
    })
  }
})
/*
.directive('selectpicker', function($timeout){
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function($scope, element, iAttrs, controller) {
      $timeout(function() {
        element.selectpicker()
      }, 1000);
    }
  };
});
*/
