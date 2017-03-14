// Definir la aplicación
var app = angular.module('administrarActividades', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('actividadesController', function ($scope, $http) {
  // Procesos iniciales
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Atributos
  $scope.actividad = {
    institucion  : '',
    division  : '',
    todas_instituciones  : false,
    todas_divisiones  : false,
    nombre  : '',
    monto  : '',
  }
  $scope.divisiones = []
  $scope.labels = {
    division : '',
    todas_divisiones : 'Todo',
  }
  $scope.procesando = false
  // Funciones
  $scope.cargarDetalle = function () {
    var id = $scope.actividad.institucion.id_institucion
    // Actualizar las etiquetas
    switch (id) {
      case 1:
      case 2:
        $scope.labels.division = 'Nivel';
        $scope.labels.todas_divisiones = 'Todos los niveles';
        break;
      case 3:
      case 4:
        $scope.labels.division = 'Carrera'
        $scope.labels.todas_divisiones = 'Todas las carreras'
        break;
      default:
        $scope.labels.division = ''
        $scope.labels.division = 'Todo'
        break;
    }
    var ruta = '/admin/divisiones_select/' + id
    $http.get(ruta)
    .success(function(response) {
      $scope.divisiones = response
    });
  }
  $scope.grabarActividad = function () {
    $scope.procesando = true
    var ruta = '/admin/actividades/grabar'
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        id_institucion : $scope.actividad.institucion.id_institucion,
        id_division : $scope.actividad.division.id,
        todas_instituciones : $scope.actividad.todas_instituciones,
        todas_divisiones : $scope.actividad.todas_divisiones,
        nombre : $scope.actividad.nombre,
        monto : $scope.actividad.monto,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        var ruta = '/admin/actividades/resumen/' + response.data.batch
        window.location = ruta;
      } else {
        debug(response.data.mensaje)
        swal({
          title: 'Error.',
          text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
          type: "warning",
        })
        // Inicializar
        $scope.inicializar()
      }
    }, function errorCallback(response) {
      debug(response, false);
      swal({
        title: 'Error.',
        text: 'Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.',
        type: "warning",
      });
      // Inicializar
      $scope.inicializar()
    })
  }
  $scope.inicializar = function () {
    $scope.actividad = {
      institucion  : '',
      division  : '',
      todas_instituciones  : false,
      todas_divisiones  : false,
      nombre  : '',
      monto  : '',
    }
    $scope.divisiones = []
    $scope.labels = {
      division : '',
      todas_divisiones : 'Todo',
    }
    $scope.procesando = false
  }
  /*
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
  // Eventos
  $("#fecha_limite").on("dp.change", function() {
    $scope.fecha_limite = $("#fecha_limite").val();
  });
  $("#busqueda_fecha_creacion").on("dp.change", function() {
    $scope.form_busqueda.fecha_creacion = $("#busqueda_fecha_creacion").val();
  });
  */
});
