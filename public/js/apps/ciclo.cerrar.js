// Definir la aplicación
var app = angular.module('cerrarCiclo', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('cicloController', function ($scope, $http, $filter) {
  // Variables
  $scope.label_detalle = '';
  $scope.detalle = [];
  $scope.cantidad_matriculas = 0;
  $scope.busqueda = {
    concepto : '',
  }
  // Recuperar las instituciones del usuario
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Funciones
  $scope.cargarDetalleInstitucion = function () {
    if ($scope.institucion != null) {
      var id = $scope.institucion.id_institucion;
      // Actualizar las etiquetas
      switch (id) {
        case 1:
        case 2:
          $scope.label_detalle = 'Nivel';
          break;
        case 3:
        case 4:
          $scope.label_detalle = 'Carrera'
          break;
        default:
          $scope.label_detalle = ''
          break;
      }
      // Recuperar detalle de la institución
      var ruta = '/secretaria/ciclo/cerrar/institucion/' + id + '/detalle';
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
      var ruta = '/secretaria/ciclo/cerrar/detalle_institucion/' + id_detalle + '/matriculas';
      $http.get(ruta)
      .success(function(response) {
        $scope.matriculas = response.matriculas;
      });
    } else {
      $scope.matriculas = [];
    }
  }
  $scope.actualizarMatriculas = function () {
    $scope.cantidad_matriculas = $filter('filter')($scope.matriculas, { seleccionada : true }).length;
  }
  $scope.cerrarCiclo = function () {
    var ruta = '/secretaria/ciclo/cerrar/guardar';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       matriculas : $filter('filter')($scope.matriculas, { seleccionada : true })
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title: "Éxito!",
          text: "Ciclos correctamente cerrados.",
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
  $scope.cancelar = function () {
    $scope.institucion = [];
    $scope.detalle = [];
    $scope.matriculas = [];
    $scope.label_detalle = ''
    $scope.busqueda = {
      matricula : '',
    }
  }
  $scope.filtroMatricula = function (matricula, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(matricula)
  }
});
