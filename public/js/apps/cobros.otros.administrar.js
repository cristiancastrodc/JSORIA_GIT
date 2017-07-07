// Definir la aplicación
var app = angular.module('otrosCobros', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('crearOtroCobroController', function ($scope, $http) {
  // Atributos
  $scope.institucion = ''
  $scope.nombre = ''
  $scope.monto = ''
  $scope.destino = false
  $scope.estado = false
  $scope.procesando = false
  $scope.form_busqueda = {
    id_institucion : '',
    procesando : false,
  }
  $scope.modal = {
    id_categoria : '',
    nombre : '',
    monto : '',
    institucion : '',
    estado : '',
    errores : null,
    procesando : false,
  }
  $scope.busqueda = {
    concepto : '',
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
  $scope.guardarOtroCobro = function () {
    $scope.procesando = true
    var ruta = '/admin/cobros/otros';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_institucion : $scope.institucion.id_institucion,
       nombre : $scope.nombre,
       monto : $scope.monto,
       destino : $scope.destino,
       estado : $scope.estado,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      debug(response, false)
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>Institución : </strong>" + $scope.institucion.nombre + "<br>"
                  + "<strong>Descripción : </strong>" + $scope.nombre + "<br>"
                  + "<strong>Monto : </strong>" + $scope.monto + "<br>"
                  + "<strong>Habilitado : </strong>" + ($scope.estado ? "Si" : "No") + "<br>"
                  + ($scope.destino ? "* Este concepto almacena los ingresos en la cuenta exterior privada." : "") + "</p>";
        swal({
          title : "Concepto creado correctamente.",
          text : texto,
          type : "success",
          confirmButtonText: "Aceptar",
          html: true,
        }, function () {
          $scope.procesando = false
          $scope.institucion = ''
          $scope.nombre = ''
          $scope.monto = ''
          $scope.destino = false
          $scope.estado = false
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
    $scope.institucion = ''
    $scope.nombre = ''
    $scope.monto = ''
    $scope.destino = false
    $scope.estado = false
    $scope.procesando = false
  }
  $scope.inicializarFormBusqueda = function () {
    $scope.form_busqueda = {
      id_institucion : '',
    }
    $scope.cobros = []
    $scope.busqueda = {
      concepto : '',
    }
  }
  $scope.listarOtrosCobros = function () {
    $scope.form_busqueda.procesando = true
    var id_institucion = $scope.form_busqueda.id_institucion
    id_institucion = id_institucion == null ? '' : id_institucion
    var ruta = '/admin/cobro/otro/listar/' + id_institucion
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
    var ruta = '/admin/cobros/otros/' + $scope.modal.id_categoria
    $http.put(ruta, {
      nombre: $scope.modal.nombre,
      monto : $scope.modal.monto,
      estado : $scope.modal.estado,
    })
    .then(function successCallback(response) {
      $scope.modal.procesando = false
      $('#modal-editar-cobro').modal('hide')
      if (response.data.resultado == 'true') {
        swal({
          title : 'Cobro actualizado correctamente.',
          type : 'success',
          confirmButtonText : 'Aceptar',
        })
        $scope.listarOtrosCobros()
      } else {
        swal({
          title : 'Error.',
          text : 'No se pudo actualizar el Cobro. Mensaje: ' + response.data.mensaje,
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
          text : 'No se pudo actualizar el Cobro.',
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
      var ruta = '/admin/cobros/otros/' + id
      $http.delete(ruta)
      .then(function successCallback(response) {
        var data = response.data
        if (data.resultado == 'true') {
          swal({
            title : 'Cobro eliminado correctamente.',
            type : 'success',
          })
          $scope.listarOtrosCobros()
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
    return $scope.institucion != ''
           && $scope.nombre != ''
           && $scope.monto != ''
           && $scope.monto != null
  }
  $scope.filtroConcepto = function (concepto, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(concepto)
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
