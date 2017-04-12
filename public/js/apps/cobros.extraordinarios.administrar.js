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
      debug(response, false)
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
   $scope.institucion = null
    $scope.descripcion_extr = ''
    $scope.monto = ''
    $scope.cliente_extr = ''
    $scope.destino = false
    $scope.procesando = false
  }
  $scope.inicializarFormBusqueda = function () {
    $scope.form_busqueda.institucion = ''
    $('#tabla-listar-extraordinarios tbody').empty()
  }
});
