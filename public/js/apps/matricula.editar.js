// Definir la aplicación
var app = angular.module('editarMatricula', [], function($interpolateProvider) {
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
  $scope.pensiones = [];
  $scope.cantidad_categorias = 0;
  $scope.matricula = []
  // Métodos que se ejecutan al iniciar el módulo
  // -- Recuperar las instituciones del usuario
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Funciones
  $scope.cancelar = function () {
    $scope.matriculando = false;
    $scope.alumno = [];
    $scope.institucion = [];
    $scope.detalle_institucion = [];
    $scope.matriculas = [];
    $scope.pensiones = [];
  }
  $scope.cargarDetalleInstitucion = function () {
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
      var ruta = '/admin/matricula/institucion/' + id + '/detalle';
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
      var ruta = '/admin/matricula/detalle_institucion/' + id_detalle + '/matriculas';
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
      var ruta = '/admin/matricula/' + id_matricula + '/categorias';
      $http.get(ruta)
      .success(function(response) {
        $scope.pensiones = response;
        $scope.cantidad_categorias = $filter('filter')($scope.pensiones, { seleccionada : true }).length;
      });
    }
  }
  $scope.guardarCambios = function () {
    $scope.procesando = true;
    var ruta = '/admin/matricula/editar/guardar';
    var pensionesSeleccionadas = $filter('filter')($scope.pensiones, { seleccionada : true });
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        matricula : $scope.matricula,
        pensiones : pensionesSeleccionadas,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : "Éxito!",
          text : "Datos actualizados correctamente.",
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
    })
  }
  $scope.contarCategorias = function () {
    $scope.cantidad_categorias = $filter('filter')($scope.pensiones, { seleccionada : true }).length;
  }
  // Eventos
  $("#fecha_inicio_matricula").on("dp.change", function() {
    $scope.matricula.fecha_inicio = $("#fecha_inicio_matricula").val()
  })
  $("#fecha_fin_matricula").on("dp.change", function() {
    $scope.matricula.fecha_fin = $("#fecha_fin_matricula").val()
  })
})
.directive('datepicker', function() {
  var linker = function (scope, element, attr) {
    scope.$watch('matricula', function () {
      if (element[0].id == 'fecha_inicio_matricula' && scope.matricula.fecha_inicio != null) {
        element.data('DateTimePicker').date(scope.matricula.fecha_inicio)
      }
      if (element[0].id == 'fecha_fin_matricula' && scope.matricula.fecha_fin != null) {
        element.data('DateTimePicker').date(scope.matricula.fecha_fin)
      }
    })
  }
  return {
    restrict: 'A',
    link: linker,
  }
})