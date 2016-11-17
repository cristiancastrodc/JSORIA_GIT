// Definir la aplicación
var app = angular.module('matricularAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('matriculaController', function ($scope, $http, $filter) {
  // Atributos
  $scope.buscando = false;
  $scope.matriculando = false;
  $scope.alumno = [];
  $scope.label_detalle = '';
  $scope.label_grado = '';
  // Métodos que se ejecutan al iniciar el módulo
  // -- Recuperar las instituciones del usuario
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Funciones
  $scope.buscar = function () {
    $scope.buscando = true;
    // Recuperar el detalle del alumno
    var ruta = '/secretaria/matricular/alumno/' + $scope.alumno.nro_documento + '/datos';
    $http.get(ruta)
    .success(function(response) {
      if (response.resultado == 'true') {
        $scope.alumno = response.alumno;
        $scope.matriculando = true;
        if (response.alertar == 'true') {
          swal({
            title : response.mensaje.titulo,
            text  : response.mensaje.contenido,
            type  : "warning",
          });
        }
      } else if (response.resultado == 'false') {
        swal({
          title : response.mensaje.titulo,
          text  : response.mensaje.contenido,
          type  : "warning",
        });
      }
    });
    $scope.buscando = false;
  };
  $scope.cancelar = function () {
    $scope.matriculando = false;
    $scope.alumno = [];
    $scope.institucion = [];
    $scope.detalle_institucion = [];
    $scope.grados = [];
    $scope.matriculas = [];
    $scope.pensiones = [];
  }
  $scope.cargarDetalle = function () {
    if ($scope.institucion != null) {
      var id = $scope.institucion.id_institucion;
      // Actualizar las etiquetas
      switch (id) {
        case 1:
        case 2:
          $scope.label_detalle = 'Nivel';
          $scope.label_grado = 'Grado';
          break;
        case 3:
        case 4:
          $scope.label_detalle = 'Carrera'
          $scope.label_grado = 'Semestre'
          break;
        default:
          $scope.label_detalle = ''
          break;
      }
      // Recuperar detalle de la institución
      var ruta = '/secretaria/matricular/institucion/' + id + '/detalle';
      $http.get(ruta)
      .success(function(response) {
        $scope.detalle = response;
      });
    } else {
      $scope.detalle = [];
    }
  }
  $scope.cargarGradosYMatriculas = function () {
    if ($scope.detalle_institucion != null) {
      var id_detalle = $scope.detalle_institucion.id;
      // Recuperar detalle de la institución
      var ruta = '/secretaria/matricular/detalle_institucion/' + id_detalle + '/grados_matriculas';
      $http.get(ruta)
      .success(function(response) {
        $scope.grados = response.grados;
        $scope.matriculas = response.matriculas;
      });
    } else {
      $scope.grados = [];
      $scope.matriculas = [];
    }
  }
  $scope.cargarPensiones = function () {
    if ($scope.matricula != null) {
      var id_matricula = $scope.matricula.id;
      // Recuperar detalle de la institución
      var ruta = '/secretaria/matricular/matricula/' + id_matricula + '/pensiones';
      $http.get(ruta)
      .success(function(response) {
        $scope.pensiones = response;
      });
    } else {
      $scope.pensiones = [];
    }
  }
  $scope.crearMatricula = function () {
    $scope.procesando = true;
    var ruta = '/secretaria/matricular/crear';
    var pensionesSeleccionadas = $filter('filter')($scope.pensiones, { seleccionada : true });
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       nro_documento : $scope.alumno.nro_documento,
       id_grado : $scope.grado.id,
       matricula : $scope.matricula,
       pensiones : pensionesSeleccionadas,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title: "Éxito!",
          text: "Matrícula y pensiones creadas correctamente.",
          type: "success"
        }, function () {
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
});
