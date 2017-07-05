// Definir la aplicación
var app = angular.module('modificarDeuda', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('modificarDeudaController', function ($scope, $http, $filter) {
  // Atributos
  $scope.agregando = false
  $scope.nro_documento = ''
  $scope.buscando = false
  $scope.alumno = null
  $scope.deudas = null
  $scope.busqueda = null
  $scope.resolucion = ''
  $scope.procesando = false
  $scope.finalizando = false
  $scope.deudas_seleccionadas = null
  // Funciones
  $scope.buscar = function () {
    $scope.buscando = true
    // Recuperar las deudas del alumno
    var ruta = '/secretaria/alumno/lista_deudas/' + $scope.nro_documento
    $http.get(ruta)
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        $scope.alumno = response.data.alumno;
        $scope.deudas = response.data.deudas;
        $scope.agregando = true
      } else if (response.data.resultado == 'false') {
        swal({
          title : 'Error.',
          text  : response.data.mensaje,
          type  : 'error',
        });
      }
    });
    $scope.buscando = false;
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
  $scope.inicializar = function () {
    $scope.nro_documento = ''
    $scope.resolucion = ''
    $scope.agregando = false
    $scope.alumno = null
    $scope.deudas = null
    $scope.busqueda = null
  }
  $scope.esValidoFormEdicion = function () {
    return $scope.resolucion != ''
            && $filter('filter')($scope.deudas, $scope.filtroDeudasValidas).length > 0
  }
  $scope.filtroDeudasValidas = function (value, index, array) {
    return (typeof value.descuento !== 'undefined'
            && value.descuento != null
            && value.descuento != 0
            && value.descuento < value.monto)
            || (typeof value.anulada !== 'undefined'
                && value.anulada)
  }
  $scope.mostrarResumen = function () {
    $scope.agregando = false
    $scope.finalizando = true
    $scope.deudas_seleccionadas = $filter('filter')($scope.deudas, $scope.filtroDeudasValidas)
  }
  $scope.volver = function () {
    $scope.agregando = true
    $scope.finalizando = false
  }
  $scope.guardar = function () {
    $scope.procesando = true
    var ruta = '/alumno/deudas/modificar/procesar';
    $http.post(ruta, {
      nro_documento : $scope.nro_documento,
      resolucion : $scope.resolucion,
      deudas : $scope.deudas_seleccionadas,
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : 'Éxito.',
          text : 'Deudas modificadas correctamente.',
          type : 'success',
          confirmButtonText: 'Aceptar',
          confirmButtonClass : 'main-color',
          closeOnConfirm : false,
        }, function () {
          document.location.reload()
        });
      } else {
        swal({
          title: 'Error.',
          text: 'No se pudo modificar las Deudas. Mensaje: ' + response.data.mensaje,
          type: 'error',
        })
        $scope.procesando = false
      }
    }, function errorCallback(response) {
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'No se pudo modificar las Deudas.',
        type: 'error',
      })
      $scope.procesando = false
    })
  }
})
