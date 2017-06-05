// Definir la aplicación
var app = angular.module('cobrosOrdinarios', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('crearCobroOrdinarioController', function ($scope, $http) {
  // Atributos
  $scope.cobroOrdinario = {
    'institucion' : null,
    'nombre' : '',
    'monto' : '',
    'con_factor' : false,
    'destino' : false,
    'estado' : false,
  }
  $scope.procesando = false
  $scope.form_busqueda = {
    id_institucion : '',
    procesando : false,
  }
  $scope.cobros = []
  $scope.modal = {
    id_categoria : '',
    nombre : '',
    monto : '',
    institucion : '',
    destino : '',
    estado : '',
    tipo : '',
    errores : null,
    procesando : false,
  }
  // Procesos iniciales
  $scope.listarInstituciones = function () {
    $http.get('/usuario/instituciones')
    .then(function (response) {
      $scope.instituciones = response.data;
    })
  }
  $scope.listarInstituciones()
  // Funciones
  $scope.guardarCobroOrdinario = function () {
    $scope.procesando = true
    var ruta = '/admin/cobros/ordinarios';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_institucion : $scope.cobroOrdinario.institucion.id_institucion,
       nombre : $scope.cobroOrdinario.nombre,
       monto : $scope.cobroOrdinario.monto,
       con_factor : $scope.cobroOrdinario.con_factor,
       destino : $scope.cobroOrdinario.destino,
       estado : $scope.cobroOrdinario.estado,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      debug(response, false)
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>Institución : </strong>" + $scope.cobroOrdinario.institucion.nombre + "<br>"
                  + "<strong>Descripción : </strong>" + $scope.cobroOrdinario.nombre + "<br>"
                  + "<strong>Monto : </strong>" + $scope.cobroOrdinario.monto + "<br>"
                  + "<strong>Habilitado : </strong>" + ($scope.cobroOrdinario.estado ? "Si" : "No") + "<br>"
                  + "<strong>Es Monto Unitario : </strong>" + ($scope.cobroOrdinario.con_factor ? "Si" : "No") + "<br>"
                  + ($scope.cobroOrdinario.destino ? "* Este concepto almacena los ingresos en la cuenta exterior privada." : "") + "</p>";
        swal({
          title : "Concepto creado correctamente.",
          text : texto,
          type : "success",
          confirmButtonText: "Aceptar",
          html: true,
        }, function () {
          $scope.procesando = false
          $scope.cobroOrdinario = {
            'id_institucion' : null,
            'nombre' : '',
            'monto' : '',
            'con_factor' : false,
            'destino' : false,
            'estado' : false,
          }
          $scope.$apply();
          $('.selectpicker').selectpicker('refresh');
        });
      } else {
        debug(response.data.mensaje)
        swal({
          title: 'Error.',
          text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
          type: "warning",
        });
      }
    }, function errorCallback(response) {
      debug('Error')
    });
  }
  $scope.inicializar = function () {
    $scope.cobroOrdinario = []
    $scope.cobroOrdinario.institucion = null
    $('.selectpicker').selectpicker('refresh')
  }
  $scope.inicializarFormBusqueda = function () {
    $scope.form_busqueda = {
      id_institucion : '',
    }
    $scope.cobros = []
  }
  $scope.listarCobrosOrdinarios = function () {
    $scope.form_busqueda.procesando = true
    var id_institucion = $scope.form_busqueda.id_institucion
    id_institucion = id_institucion == null ? '' : id_institucion
    var ruta = '/admin/cobro/ordinario/listar/' + id_institucion
    $http.get(ruta)
    .then(function(response) {
      $scope.form_busqueda.procesando = false
      $scope.cobros = response.data
    })
  }
  $scope.editarCobro = function (cobro) {
    $scope.modal = {
      id_categoria : cobro.id,
      institucion : cobro.institucion,
      nombre : cobro.nombre,
      monto : cobro.monto,
      con_factor : cobro.tipo == 'con_factor',
      estado : cobro.estado == 1,
      procesando : false,
      errores : null,
    }
    $('#modal-editar-cobro').modal('show')
  }
  $scope.esValidoFormEdicion = function () {
    return $scope.modal.nombre != ''
           && $scope.modal.monto != ''
  }
  $scope.actualizarCobro = function () {
    $scope.modal.procesando = true
    var ruta = '/admin/cobros/ordinarios/' + $scope.modal.id_categoria
    $http.put(ruta, {
      nombre: $scope.modal.nombre,
      monto : $scope.modal.monto,
      con_factor : $scope.modal.con_factor,
      estado : $scope.modal.estado,
    })
    .then(function successCallback(response) {
      $scope.modal.procesando = false
      $('#modal-editar-cobro').modal('hide')
      if (response.data.resultado == 'true') {
        swal({
          title : 'Cobro Ordinario actualizado correctamente.',
          type : 'success',
          confirmButtonText : 'Aceptar',
        })
        $scope.listarCobrosOrdinarios()
      } else {
        swal({
          title : 'Error.',
          text : 'No se pudo actualizar el Cobro Ordinario. Mensaje: ' + response.data.mensaje,
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
          text : 'No se pudo actualizar el Cobro Ordinario.',
          type : 'error',
        })
      }
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
      var ruta = '/admin/cobros/ordinarios/' + id
      $http.delete(ruta)
      .then(function successCallback(response) {
        var data = response.data
        if (data.resultado == 'true') {
          swal({
            title : 'Cobro eliminado correctamente.',
            type : 'success',
          })
          $scope.listarCobrosOrdinarios()
        } else {
          swal({
            title: 'Error.',
            text: 'No se pudo eliminar el cobro. Mensaje: ' + data.mensaje,
            type: 'error',
          })
        }
      }, function errorCallback(response) {
        debug(response, false)
        swal({
          title: 'Error.',
          text: 'No se pudo eliminar el cobro.',
          type: 'error',
        })
      })
    })
  }
  $scope.esValidoFormCreacion = function () {
    return $scope.cobroOrdinario.institucion != null
           && $scope.cobroOrdinario.nombre != ''
           && $scope.cobroOrdinario.monto != ''
           && $scope.cobroOrdinario.monto != null
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
