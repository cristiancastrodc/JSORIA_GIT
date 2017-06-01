// Definir la aplicación
var app = angular.module('cobrosExtraordinarios', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('crearCobroExtraordinarioController', function ($scope, $http) {
  // Atributos
  $scope.institucion = null
  $scope.descripcion_extr = ''
  $scope.monto = ''
  $scope.cliente_extr = ''
  $scope.destino = false
  $scope.procesando = false
  $scope.cobros = []
  $scope.form_busqueda = {
    id_institucion : '',
    procesando : false,
  }
  $scope.modal = {
    id_deuda : '',
    descripcion_extr : '',
    cliente_extr : '',
    monto : '',
    institucion : '',
    errores : null,
    procesando : false,
  }
  // Procesos iniciales
  $scope.listarInstituciones = function () {
    $http.get('/usuario/instituciones')
    .success(function(response) {
      $scope.instituciones = response;
    })
  }
  $scope.listarInstituciones()
  // Funciones
  $scope.guardarCobroExtraordinario = function () {
    $scope.procesando = true
    var ruta = '/admin/cobros/extraordinarios';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_institucion : $scope.institucion.id_institucion,
       descripcion_extr : $scope.descripcion_extr,
       monto : $scope.monto,
       cliente_extr : $scope.cliente_extr,
       destino : $scope.destino,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        var texto = "<h1>Código de pago: " + response.data.id_deuda + "</h1>"
                  + "<p style='text-align:left'><strong>Institución : </strong>" + $scope.institucion.nombre + "<br>"
                  + "<strong>Descripción : </strong>" + $scope.descripcion_extr + "<br>"
                  + "<strong>Monto : </strong>" + $scope.monto + "<br>"
                  + "<strong>Cliente : </strong>" + $scope.cliente_extr + "<br>"
                  + ($scope.destino ? "* Este ingreso se almacenará en la cuenta exterior privada." : "") + "</p>";
        swal({
          title : "Cobro creado correctamente.",
          text : texto,
          type : 'success',
          confirmButtonText: 'Aceptar',
          confirmButtonClass : 'accent-color',
          html: true,
        }, function () {
          $scope.procesando = false
          $scope.institucion = null
          $scope.descripcion_extr = ''
          $scope.monto = ''
          $scope.cliente_extr = ''
          $scope.destino = false
          $scope.$apply();
          $('.selectpicker').selectpicker('refresh');
        });
      } else {
        swal({
          title: 'Error.',
          text: 'No se pudo crear el cobro. Mensaje: ' + response.data.mensaje,
          type: 'error',
        })
      }
    }, function errorCallback(response) {
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'No se pudo crear el cobro.',
        type: 'error',
      })
    });
  }
  $scope.inicializar = function () {
   $scope.institucion = null
    $scope.descripcion_extr = ''
    $scope.monto = ''
    $scope.cliente_extr = ''
    $scope.destino = false
    $scope.procesando = false
  }
  $scope.inicializarFormBusqueda = function () {
    $scope.form_busqueda.id_institucion = ''
    $scope.cobros = []
  }
  $scope.listarCobrosExtraordinarios = function () {
    $scope.form_busqueda.procesando = true
    var id_institucion = $scope.form_busqueda.id_institucion
    id_institucion = id_institucion == null ? '' : id_institucion
    var ruta = '/admin/cobro/extraordinario/listar/' + id_institucion
    $http.get(ruta)
    .then(function(response) {
      $scope.form_busqueda.procesando = false
      $scope.cobros = response.data
    })
  }
  $scope.eliminarCobro = function (id) {
    swal({
      title: '¿Realmente desea eliminar el cobro?',
      type: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Aceptar',
      confirmButtonClass: 'btn-danger',
    }, function () {
      var ruta = '/admin/cobros/extraordinarios/eliminar/' + id
      $http.get(ruta)
      .then(function successCallback(response) {
        var data = response.data
        if (data.resultado == 'true') {
          swal({
            title : 'Cobro anulado correctamente.',
            type : 'success',
          })
          $scope.listarCobrosExtraordinarios()
        } else {
          swal({
            title: 'Error.',
            text: 'No se pudo anular el cobro. Mensaje: ' + data.mensaje,
            type: 'error',
          })
        }
      }, function errorCallback(response) {
        debug(response, false)
        swal({
          title: 'Error.',
          text: 'No se pudo anular el cobro.',
          type: 'error',
        })
      })
    })
  }
  $scope.editarCobro = function (cobro) {
    $scope.modal = {
      id_deuda : cobro.id,
      institucion : cobro.institucion,
      descripcion_extr : cobro.descripcion_extr,
      cliente_extr : cobro.cliente_extr,
      monto : cobro.saldo,
      procesando : false,
      errores : null,
    }
    $('#modal-editar-cobro').modal('show')
  }
  $scope.esValidoFormEdicion = function () {
    return $scope.modal.descripcion_extr != ''
           && $scope.modal.cliente_extr != ''
           && $scope.modal.monto != ''
  }
  $scope.actualizarCobro = function () {
    $scope.modal.procesando = true
    var ruta = '/admin/cobros/extraordinarios/' + $scope.modal.id_deuda
    $http.put(ruta, {
      descripcion_extr: $scope.modal.descripcion_extr,
      cliente_extr: $scope.modal.cliente_extr,
      monto : $scope.modal.monto,
    })
    .then(function successCallback(response) {
      $scope.modal.procesando = false
      $('#modal-editar-cobro').modal('hide')
      if (response.data.resultado == 'true') {
        swal({
          title : 'Cobro Extraordinario actualizado correctamente.',
          type : 'success',
          confirmButtonText : 'Aceptar',
        })
        $scope.listarCobrosExtraordinarios()
      } else {
        swal({
          title : 'Error.',
          text : 'No se pudo actualizar el Cobro Extraordinario. Mensaje: ' + response.data.mensaje,
          type : 'error',
        })
      }
    }, function errorCallback(response) {
      $scope.modal.procesando = false
      if (response.status == 422) {
        $scope.modal.errores = response.data
      } else {
        debug(response, false)
        $('#modal-editar-cobro').modal('hide')
        swal({
          title : 'Error.',
          text : 'No se pudo actualizar el Cobro Extraordinario.',
          type : 'error',
        })
      }
    })
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
