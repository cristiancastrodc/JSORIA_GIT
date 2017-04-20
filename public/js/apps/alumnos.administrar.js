// Definir la aplicación
var app = angular.module('administrarAlumnos', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador para Agregar Deudas
app.controller('agregarDeudasController', function ($scope, $http, $filter) {
  // Procesos iniciales
  $scope.listarConceptos = function () {
    var ruta = '/categoria/con_factor/listar'
    $http.get(ruta)
    .then(function successCallback(response) {
      $scope.conceptos = response.data
    }, function errorCallback(response) {
      $scope.conceptos = []
    })
  }
  $scope.listarConceptos()
  // Atributos
  $scope.conceptos = []
  $scope.alumno = {
    nro_documento : '',
  }
  $scope.existeAlumno = false
  $scope.procesando = false
  $scope.busqueda = {
    institucion : '',
    concepto : '',
  }
  // Funciones
  $scope.buscarAlumno = function () {
    var ruta = '/alumno/' + $scope.alumno.nro_documento + '/datos'
    $http.get(ruta)
    .then(function successCallback(response) {
      var data = response.data
      if (data.resultado == 'true') {
        $scope.alumno = data.alumno
        $scope.existeAlumno = true
      } else {
        swal({
          title : 'Error.',
          text : data.mensaje,
          type : 'error',
        })
      }
    }, function errorCallback(response) {
      debug(response.data)
      swal({
        title : 'Error.',
        text : 'Se produjo un error al buscar al alumno.',
        type : 'error',
      })
    })
  }
  $scope.inicializar = function () {
    $scope.alumno = {
      nro_documento : '',
    }
    $scope.existeAlumno = false
    $scope.procesando = false
    $scope.busqueda = {
      institucion : '',
      concepto : '',
    }
  }
  $scope.calcularTotal = function (concepto) {
    concepto.total = concepto.monto * concepto.factor
  }
  $scope.filtroInstitucion = function (institucion, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(institucion)
  }
  $scope.filtroConcepto = function (concepto, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(concepto)
  }
  $scope.esValidoConceptos = function () {
    return $filter('filter')($scope.conceptos, { seleccionado : true }).length > 0
  }
  $scope.agregarDeuda = function () {
    $scope.procesando = true
    var ruta = '/alumno/deudas/agregar/procesar'
    $http.post(ruta, {
      nro_documento : $scope.alumno.nro_documento,
      deudas : $filter('filter')($scope.conceptos, { seleccionado : true }),
    })
    .then(function successCallback(response) {
      $scope.procesando = false
      var respuesta = response.data
      if (respuesta.resultado == 'true') {
        swal({
          title : 'Éxito',
          text : 'Deudas de Alumno agregadas correctamente.',
          type : 'success',
          confirmButtonText : 'Aceptar',
          confirmButtonClass : 'main-color',
        })
        $scope.inicializar()
      } else {
        swal({
          title : 'Error',
          text : 'No se pudo agregar las Deudas del Alumno. Mensaje: ' + respuesta.mensaje,
          type : 'error',
          confirmButtonText : 'Aceptar',
          confirmButtonClass : 'main-color',
        })
        $scope.inicializar()
      }
    }, function errorCallback(response) {
      $scope.procesando = false
      debug(response.data, false)
      swal({
        title : 'Error',
        text : 'No se pudo agregar las Deudas del Alumno.',
        type : 'error',
        confirmButtonText : 'Aceptar',
        confirmButtonClass : 'main-color',
      })
    })
  }
})
