// Definir la aplicación
var app = angular.module('programarPeriodos', ['ui.bootstrap'], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('periodosController', function ($scope, $http) {
  // Recuperar las instituciones del usuario
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Cargar las matrículas temporales y reiniciar las matrículas a programar
  $scope.matriculas_temp = [];
  $scope.matriculas_programar = [];
  $scope.cargarCategoriasTemp = function () {
    var ruta = '/secretaria/matriculas/recuperar/' + $scope.institucion.id_institucion;
    $http.get(ruta)
    .success(function(response) {
      $scope.matriculas_temp = response;
      $scope.matriculas_programar = [];
    });
  };
  // Agregar matrícula a la lista de programación
  $scope.cantidad_matriculas = 0;
  $scope.agregarMatricula = function (matricula, indice) {
    $scope.matriculas_programar.push(matricula);
    $scope.matriculas_temp.splice(indice, 1);
    $scope.cantidad_matriculas = $scope.matriculas_programar.length;
  };
  // Función para suprimir un producto de la orden
  $scope.quitar = function(matricula, indice) {
    matricula.fecha_inicial = '';
    matricula.fecha_final = '';
    matricula.mes_inicial_pension = '';
    matricula.mes_final_pension = '';
    $scope.matriculas_temp.push(matricula);
    $scope.matriculas_programar.splice(indice, 1);
    $scope.cantidad_matriculas = $scope.matriculas_programar.length;
  };
  // Abrir el calendario
  $scope.open = function($event, matricula, number) {
    $event.preventDefault();
    $event.stopPropagation();
    // Abrir calendario seleccionado y cerrar los restantes
    if (number == 1) {matricula.opened1 = true; matricula.opened2 = matricula.opened3 = matricula.opened4 = false;}
    if (number == 2) {matricula.opened2 = true; matricula.opened1 = matricula.opened3 = matricula.opened4 = false;}
    if (number == 3) {matricula.opened3 = true; matricula.opened1 = matricula.opened2 = matricula.opened4 = false;}
    if (number == 4) {matricula.opened4 = true; matricula.opened1 = matricula.opened2 = matricula.opened3 = false;}
  };
  // Opciones para los calendarios respectivos
  $scope.dateOptions1 = {
    formatYear : 'yyyy',
    startingDay : 1,
  };
  $scope.dateOptions2 = {
    minMode: 'month',
  };
  // Crear las categorías
  $scope.procesando = false;
  $scope.crearMatriculaPensiones = function () {
    $scope.procesando = true;
    // Procesar el guardado =)
    var url = '/secretaria/periodo/crear';
    $http({
      method: 'POST',
      url: url,
      data : $.param({
        matriculas : $scope.matriculas_programar,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data == 'true') {
        debug('Matrículas y pensiones creadas');
        swal({
          title: "Éxito!",
          text: "Matrícula y pensiones creadas correctamente.",
          type: "success"
        }, function () {
          document.location.reload();
        });
      } else {
        swal({
          title: "Error",
          text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos. Excepción: " + response.data,
          type: "warning"
        }, function () {
          document.location.reload();
        });
      }
    }, function errorCallback(response) {
      console.log('error');
    });
  };
  $scope.cancelar = function () {
    $scope.matriculas_temp = [];
    $scope.matriculas_programar = [];
  }
});

app.directive('myFullDate', function(dateFilter) {
  return {
    restrict: 'EAC',
    require: '?ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(viewValue) {
        return dateFilter(viewValue,'yyyy-MM-dd');
      });
    }
  };
});

app.directive('myMonthDate', function(dateFilter) {
  return {
    restrict: 'EAC',
    require: '?ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(viewValue) {
        return dateFilter(viewValue,'MM/yyyy');
      });
    }
  };
});
