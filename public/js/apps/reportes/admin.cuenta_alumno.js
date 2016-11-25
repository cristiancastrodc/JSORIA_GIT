// Definir la aplicación
var app = angular.module('reporteCuentaAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('reporteCuentaAlumnoController', function ($scope, $http, $filter) {
  // Atributos
  $scope.buscando = false;
  $scope.hayAlumno = false;
  // Funciones
  $scope.buscar = function () {
    $scope.buscando = true;
    // Recuperar el detalle del alumno
    var ruta = '/admin/reportes/cuenta_alumno/' + $scope.alumno.nro_documento + '/periodos';
    $http.get(ruta)
    .success(function(response) {
        $scope.periodos = response;
        $scope.hayAlumno = true;
    });
    $scope.buscando = false;
  };
  $scope.cancelar = function () {
    $scope.matriculando = false;
    $scope.alumno = [];
    $scope.institucion = [];
    $scope.detalle_institucion = [];
    $scope.matriculas = [];
    $scope.pensiones = [];
  }
  $scope.cargarMatriculas = function () {
    if ($scope.detalle_institucion != null) {
      var id_detalle = $scope.detalle_institucion.id;
      // Recuperar detalle de la institución
      var ruta = '/secretaria/matricular/detalle_institucion/' + id_detalle + '/grados_matriculas';
      $http.get(ruta)
      .success(function(response) {
        $scope.matriculas = response.matriculas;
      });
    } else {
      $scope.matriculas = [];
    }
  }
  $scope.cargarPensiones = function (indice) {
    if ($scope.matricula != null) {
      var id_matricula = $scope.matricula.id;
      // Recuperar detalle de la institución
      var ruta = '/secretaria/alumno/deudas/' + id_matricula + '/categorias';
      $http.get(ruta)
      .success(function(response) {
        $scope.pensiones = $scope.pensiones.concat(response);
        $scope.matriculas.splice(indice, 1);
        $scope.matricula = [];
        $scope.cantidad_categorias = $filter('filter')($scope.pensiones, { seleccionada : true }).length;
      });
    }
  }
  $scope.crearMatricula = function () {
    $scope.procesando = true;
    var ruta = '/secretaria/alumno/deudas/anteriores/crear';
    var pensionesSeleccionadas = $filter('filter')($scope.pensiones, { seleccionada : true });
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       nro_documento : $scope.alumno.nro_documento,
       pensiones : pensionesSeleccionadas,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : "Éxito!",
          text : "Deudas agregadas correctamente.",
          type : "success",
          confirmButtonText: "Aceptar",
          closeOnConfirm: false,
        }, function (isConfirm) {
          document.location.reload();
        });
      } else {
        swal({
          title: response.data.mensaje.titulo,
          text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos. Excepción: " + response.data.mensaje.contenido,
          type: "warning"
        }, function () {
          document.location.reload();
        });
      }
    }, function errorCallback(response) {
      console.log('Internal Error');
    });
  }
  $scope.contarCategorias = function () {
    $scope.cantidad_categorias = $filter('filter')($scope.pensiones, { seleccionada : true }).length;
  }
});
