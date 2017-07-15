// Definir la aplicación
var app = angular.module('administrarActividades', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('actividadesController', function ($scope, $http) {
  // Procesos iniciales
  $scope.listarInstituciones = function () {
    $http.get('/usuario/instituciones')
    .success(function(response) {
      $scope.instituciones = response;
    })
  }
  $scope.listarInstituciones()
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
    form_busqueda_division : '',
  }
  $scope.procesando = false
  $scope.form_busqueda = {
    divisiones : [],
    institucion : '',
    division : '',
    procesando : false,
  }
  $scope.modal = {
    id_actividad : '',
    nombre : '',
    monto : '',
    procesando : true,
    errores : null,
  }
  $scope.busqueda = {
    actividad : '',
  }
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
        $scope.labels.todas_divisiones = 'Todo'
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
    $scope.busqueda = {
      actividad : '',
    }
    $scope.divisiones = []
    $scope.labels = {
      division : '',
      todas_divisiones : 'Todo',
    }
    $scope.procesando = false
  }
  $scope.esValidoFormCreacion = function () {
    return ($scope.actividad.division != '' || $scope.actividad.todas_divisiones)
           && $scope.actividad.nombre != ''
           && ($scope.actividad.monto != null && $scope.actividad.monto != '' && $scope.actividad.monto != 0)
  }
  $scope.cargarDetalleFormBusqueda = function () {
    var id = $scope.form_busqueda.institucion
    // Actualizar las etiquetas
    switch (id) {
      case 1:
      case 2:
        $scope.labels.form_busqueda_division = 'Nivel';
        break;
      case 3:
      case 4:
        $scope.labels.form_busqueda_division = 'Carrera'
        break;
      default:
        $scope.labels.form_busqueda_division = ''
        break;
    }
    var ruta = '/admin/divisiones_select/' + id
    $http.get(ruta)
    .success(function(response) {
      $scope.form_busqueda.divisiones = response
    })
  }
  $scope.inicializarFormBusqueda = function () {
    $scope.form_busqueda = {
      divisiones : [],
      institucion : '',
      division : '',
    }
  }
  $scope.listarActividades = function () {
    $scope.form_busqueda.procesando = true
    var id_institucion = $scope.form_busqueda.institucion
    var id_division = $scope.form_busqueda.division
    var ruta = '/admin/actividad/listar'
    $http.post(ruta, { id_institucion: id_institucion, id_division : id_division})
    .then(function(response) {
      $scope.form_busqueda.procesando = false
      $scope.actividades = response.data
    })
  }
  $scope.editarActividad = function (actividad) {
    $scope.modal = {
      id_actividad : actividad.id,
      nombre : actividad.nombre,
      monto : actividad.monto,
      institucion : actividad.institucion,
      errores : null,
    }
    $('#modal-editar-actividad').modal('show')
  }
  $scope.actualizarActividad = function () {
    $scope.modal.procesando = true
    var ruta = '/admin/actividades/' + $scope.modal.id_actividad
    var nombre = $scope.modal.nombre
    var monto = $scope.modal.monto
    $http.put(ruta, { nombre: nombre, monto : monto })
    .then(function successCallback(response) {
      $scope.modal.procesando = false
      $('#modal-editar-actividad').modal('hide')
      if (response.data.resultado == 'true') {
        swal({
          title : 'Actividad actualizada correctamente.',
          type : 'success',
          confirmButtonText : 'Aceptar',
        })
        $scope.listarActividades()
      } else {
        swal({
          title : 'Error.',
          text : 'No se pudo actualizar la Actividad. Mensaje: ' + response.data.mensaje,
          type : 'error',
        })
      }
    }, function errorCallback(response) {
      $scope.modal.procesando = false
      if (response.status == 422) {
        $scope.modal.errores = response.data
      } else {
        debug(response, false)
        $('#modal-editar-actividad').modal('hide')
        swal({
          title : 'Error.',
          text : 'No se pudo actualizar la Actividad.',
          type : 'error',
        })
      }
    })
  }
  $scope.esValidoFormEdicion = function () {
    return $scope.modal.nombre != ''
           && $scope.modal.monto != ''
  }
  $scope.filtroActividad = function (actividad, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(actividad)
  }
})
