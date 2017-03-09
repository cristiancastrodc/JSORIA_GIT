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
  $scope.existe_alumno = true
  $scope.nro_documento = ''
  $scope.fecha_limite = ''
  // Funciones
  $scope.buscarAlumno = function () {
    if ($scope.nro_documento != '') {
      var ruta = '/admin/alumno/' + $scope.nro_documento + '/datos'
      $http.get(ruta)
      .success(function(response) {
        if (response.resultado == 'true') {
          $scope.datos_alumno = response.alumno['apellidos'] + ' ' + response.alumno['nombres'] + ' - ' + response.alumno['institucion'] + ' - ' + response.alumno['division']
          $scope.existe_alumno = true
          $scope.clase_documento = 'form-group'
        } else {
          $scope.datos_alumno = ''
          $scope.existe_alumno = false
          $scope.clase_documento = 'form-group has-error'
        }
      });
    } else {
      $scope.datos_alumno = ''
    }
  }
  $scope.guardarAutorizacion = function () {
    $scope.procesando = true
    var ruta = '/admin/autorizacion/guardar';
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
                  + "<strong>Fecha límite : </strong>" + $scope.fecha_limite + "</p>";
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
  // Eventos
  $("#fecha_limite").on("dp.change", function() {
    $scope.fecha_limite = $("#fecha_limite").val();
  });
});
