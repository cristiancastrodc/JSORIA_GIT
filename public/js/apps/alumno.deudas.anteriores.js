// Definir la aplicación
var app = angular.module('agregarDeudasAlumno', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('deudasController', function ($scope, $http, $filter) {
  // Atributos
  $scope.buscando = false;
  $scope.matriculando = false;
  $scope.alumno = [];
  $scope.datosinstitucion = [];
  $scope.label_detalle = '';
  $scope.pensiones = [];
  $scope.cantidad_categorias = 0;
  $scope.busqueda = {
    concepto : '',
  }
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
        $scope.datosinstitucion = response.datosinstitucion;
        $scope.matriculando = true;
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
    $scope.matriculas = [];
    $scope.pensiones = [];
    $scope.busqueda = {
      concepto : '',
    }
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
  $scope.cargarMatriculas = function () {
    if ($scope.detalle_institucion != null) {
      var id_detalle = $scope.detalle_institucion.id;
      // Recuperar detalle de la institución
      var ruta = '/secretaria/alumno/deudas/anteriores/detalle_institucion/' + id_detalle + '/matriculas';
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
  $scope.filtroConcepto = function (concepto, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(concepto)
  }
});
