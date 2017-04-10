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
    institucion : '',
    tipo : '',
    serie : '',
    numero : '',
  }
  // Métodos que se ejecutan al iniciar el módulo
  // -- Recuperar instituciones del usuario
  $scope.listarInstituciones = function () {
    $http.get('/usuario/instituciones')
    .success(function(response) {
      $scope.instituciones = response
    })
  }
  $scope.listarInstituciones()
  // -- Recuperar la lista de comprobantes
  $scope.listarComprobantes = function () {
    // -- Recuperar la lista de comprobantes
    $http.get('/admin/comprobante/listar')
    .success(function(response) {
      $scope.comprobantes = response;
    })
  }
  $scope.listarComprobantes()
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
  $scope.editarComprobante = function (comprobante) {
    $scope.modal = {
      id : comprobante.id,
      institucion : comprobante.institucion,
      tipo : comprobante.tipo,
      serie : comprobante.serie,
      numero : comprobante.numero_comprobante,
    }
    $('#modal-detalle-comprobante').modal('show')
  }
  $scope.actualizarComprobante = function () {
    $scope.modal.procesando = true
    var ruta = '/admin/comprobante/actualizar/' + $scope.modal.id;
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        serie_comprobante : $scope.modal.serie,
        numero_comprobante : $scope.modal.numero,
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
        swal({
          title: 'Error.',
          text: 'No se pudo actualizar el Comprobante. Mensaje: ' + response.data.mensaje,
          type: 'warning',
        })
      }
      $scope.modal.procesando = false
    }, function errorCallback(response) {
      $('#modal-detalle-comprobante').modal('hide')
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'No se pudo actualizar el Comprobante.',
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
