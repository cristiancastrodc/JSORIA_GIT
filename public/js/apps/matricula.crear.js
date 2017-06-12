// Definir la aplicación
var app = angular.module('crearMatricula', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('matriculaController', function ($scope, $http, $filter) {
  // Procesos iniciales
  $http.get('/usuario/instituciones')
  .success(function(response) {
    $scope.instituciones = response;
  });
  // Enlazar
  $scope.institucion = [];
  $scope.matricula = {
    concepto : '',
    fecha_inicio : null,
    fecha_fin : null,
    periodo : ''
  };
  $scope.pensiones = {
    concepto : 'Pensión',
    mes_inicio : null,
    mes_fin : null
  };
  $scope.divisiones = [];
  $scope.periodo = '';
  $scope.definir_fechas = false;
  // Funciones
  $scope.recuperarDetalle = function () {
    // Recuperar el detalle de la Institucion
    $http.get('/admin/divisiones_select/' + $scope.institucion.id_institucion)
    .success(function(response) {
      $scope.divisiones = response;
    });
  };
  $scope.procesando = false;


  $scope.crearMatriculaPensiones = function (argument) {
    if ($scope.esValidoFormEdicion() ){     
      $scope.procesando = true;
      var url = '/admin/matricula/guardar';
      $http({
        method: 'POST',
        url: url,
        data : $.param({
         id_institucion : $scope.institucion.id_institucion,
         matricula : $scope.matricula,
         pensiones : $scope.pensiones,
         divisiones : $scope.divisiones,
         periodo : $scope.periodo,
         definir_fechas : $scope.definir_fechas,
        }),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      })
      .then(function successCallback(response) {
        if (response.data.resultado == 'true') {
          debug('Las pensiones fueron creadas');
          var ruta = '/admin/matricula/resumen/' + response.data.batch
          if (!$scope.definir_fechas) {
            ruta = '/admin/matricula/temp/resumen/' + response.data.batch
          }
          window.location = ruta;
        } else {
          swal({
            title: "Error",
            text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos. Excepción: " + response.data.mensaje,
            type: "warning"
          }, function () {
            document.location.reload();
          });
        }
      }, function errorCallback(response) {
        console.log('error');
      });
    } else {
      swal({
        title : 'Error.',
        text : 'Debe completar todos los campos requeridos.',
        type : 'error',
      })
    }
  };
  $scope.esValidoFormEdicion = function () {
    var fechas_validas = true
    if ($scope.definir_fechas) {
      fechas_validas = $scope.matricula.fecha_inicio != null
                       && $scope.matricula.fecha_inicio != ''
                       && $scope.matricula.fecha_fin != null
                       && $scope.matricula.fecha_fin != ''
                       && $scope.pensiones.mes_inicio != ''
                       && $scope.pensiones.mes_inicio != null 
                       && $scope.pensiones.mes_fin != ''
                       && $scope.pensiones.mes_fin != null   
    }
    return $scope.periodo != null
           && $scope.periodo != ''
           && $scope.matricula.concepto != null
           && $scope.matricula.concepto != ''
           && $scope.pensiones.concepto != null
           && $scope.pensiones.concepto != ''
           && $scope.divisiones.length > 0
           && $filter('filter')($scope.divisiones, { seleccionar : true }).length > 0
           && $filter('filter')($scope.divisiones, $scope.filtroDivisionesNoValidas).length <= 0
           && fechas_validas
  }
  $scope.filtroDivisionesNoValidas = function (value, index, array) {
    return typeof value.seleccionar !== 'undefined'
           && value.seleccionar
           && ((typeof value.monto_pensiones === 'undefined' || value.monto_pensiones <= 0)
                      || (typeof value.monto_matricula === 'undefined' || value.monto_matricula <= 0))
  }
  $scope.cancelar = function () {
    $scope.institucion = [];
    $scope.periodo = '';
    $scope.definir_fechas = false;
    $scope.matricula.concepto = '';
    $scope.matricula.fecha_inicio = '';
    $scope.matricula.fecha_fin = '';
    $scope.pensiones.concepto = '';
    $scope.pensiones.mes_inicio = '';
    $scope.pensiones.mes_fin = '';
    $scope.divisiones = [];
  }

  $("#fecha_inicio_matricula").on("dp.change", function() {
    $scope.matricula.fecha_inicio = $("#fecha_inicio_matricula").val();
  });
  $("#fecha_fin_matricula").on("dp.change", function() {
    $scope.matricula.fecha_fin = $("#fecha_fin_matricula").val();
  });
  $("#mes_inicio_pension").on("dp.change", function() {
    $scope.pensiones.mes_inicio = $("#mes_inicio_pension").val();
  });
  $("#mes_fin_pension").on("dp.change", function() {
    $scope.pensiones.mes_fin = $("#mes_fin_pension").val();
  });

});
