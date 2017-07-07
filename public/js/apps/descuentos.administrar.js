// Definir la aplicación
var app = angular.module('autorizarDescuentos', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('descuentosController', function ($scope, $http) {
  // Atributos
  $scope.datos_alumno = ''
  $scope.clase_documento = 'form-group'
  $scope.error_documento = ''
  $scope.existe_alumno = true
  $scope.nro_documento = ''
  $scope.fecha_limite = ''
  $scope.form_busqueda = {
    nro_documento  : '',
    fecha_creacion : '',
    procesando     : false,
  }
  $scope.autorizaciones = []
  $scope.modal = {
    resolucion  : '',
    id_alumno  : '',
    nombre  : '',
    fecha_limite  : '',
    fecha_creacion  : '',
    estado  : '',
    puede_eliminar  : false,
  }
  $scope.busqueda = {
    rd : '',
    nombres : '',
  }
  // Funciones
  $scope.buscarAlumno = function () {
    if ($scope.nro_documento != '') {
      var ruta = '/admin/alumno/' + $scope.nro_documento + '/datos'
      $http.get(ruta)
      .then(function successCallback(response) {
        if (response.data.resultado == 'true') {
          var alumno = response.data.alumno
          $scope.datos_alumno = alumno['apellidos'] + ' ' + alumno['nombres'] + ' - ' + alumno['institucion'] + ' - ' + alumno['division']
          $scope.existe_alumno = true
          $scope.clase_documento = 'form-group'
        } else {
          $scope.datos_alumno = ''
          $scope.existe_alumno = false
          $scope.clase_documento = 'form-group has-error'
          $scope.error_documento = response.data.mensaje
        }
      })
    } else {
      $scope.datos_alumno = ''
    }
  }
  $scope.guardarAutorizacion = function () {
    $scope.procesando = true
    var ruta = '/admin/autorizacion/guardar'
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       nro_documento : $scope.nro_documento,
       resolucion : $scope.resolucion,
       fecha_limite : $scope.fecha_limite,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        var texto = "<p style='text-align:left'><strong>Alumno : </strong>" + $scope.datos_alumno + "<br>"
                  + "<strong>Resolución : </strong>" + $scope.resolucion + "<br>"
                  + "<strong>Fecha límite : </strong>" + $scope.fecha_limite + "</p>"
        swal({
          title : "Autorización creada correctamente.",
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
      $scope.procesando = false
      $scope.nro_documento = ''
      $scope.datos_alumno = ''
      $scope.resolucion = ''
      $scope.fecha_limite = ''
    }, function errorCallback(response) {
      debug(response, false);
      swal({
        title: 'Error.',
        text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
        type: "warning",
      });
      // Inicializar
      $scope.procesando = false
      $scope.nro_documento = ''
      $scope.datos_alumno = ''
      $scope.resolucion = ''
      $scope.fecha_limite = ''
    });
  }
  $scope.buscarAutorizacion = function () {
    $scope.form_busqueda.procesando = true
    var fecha = $scope.form_busqueda.fecha_creacion.split('/').join('-')
    var nro_documento = $scope.form_busqueda.nro_documento != '' ? $scope.form_busqueda.nro_documento : 'nro_documento_is_null'
    var ruta = '/admin/autorizacion/listar/autorizaciones/' + nro_documento + '/' + fecha
    $http.get(ruta)
    .success(function(response) {
      $scope.autorizaciones = response
      $scope.form_busqueda.procesando = false
    });
  }
  $scope.mostrarDetalle = function (autorizacion) {
    $scope.modal = {
      id_autorizacion  : autorizacion.id,
      resolucion  : autorizacion.rd,
      id_alumno  : autorizacion.id_alumno,
      nombre_alumno  : autorizacion.apellidos + ' ' + autorizacion.nombres,
      fecha_limite  : autorizacion.fecha_limite,
      fecha_creacion  : autorizacion.fecha_creacion,
      estado  : autorizacion.estado == 0 ? 'Sin procesar' : 'Procesada',
      puede_eliminar  : autorizacion.estado == 0,
    }
    $('#modal-detalle-autorizacion').modal('show')
  }
  $scope.eliminarAutorizacion = function (id_autorizacion) {
    var ruta = '/admin/autorizacion/eliminar/' + id_autorizacion
    $http.get(ruta)
    .success(function(response) {
      swal({
        title : "Autorización eliminada correctamente.",
        type : "success",
      }, function () {
        $scope.buscarAutorizacion()
        $('#modal-detalle-autorizacion').modal('hide')
      })
    });
  }
  $scope.inicializar = function () {
    $scope.datos_alumno = ''
    $scope.clase_documento = 'form-group'
    $scope.existe_alumno = true
    $scope.nro_documento = ''
    $scope.fecha_limite = ''
    $scope.resolucion = ''
    $scope.busqueda = {
      rd : '',
      nombres : '',
    }
  }
  $scope.cancelar = function () {
    $scope.form_busqueda.nro_documento = ''
    $scope.form_busqueda.fecha_creacion = ''
    $scope.autorizaciones = []
    $scope.busqueda = {
      rd : '',
      nombres : '',
    }
  }
  $scope.filtroRd = function (rd, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(rd)
  }
  $scope.filtroNombre = function (nombres, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(nombres)
  }
  // Eventos
  $("#fecha_limite").on("dp.change", function() {
    $scope.fecha_limite = $("#fecha_limite").val();
  });
  $("#busqueda_fecha_creacion").on("dp.change", function() {
    $scope.form_busqueda.fecha_creacion = $("#busqueda_fecha_creacion").val();
  });
});
