// Definir la aplicación
var app = angular.module('cobrosOrdinarios', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('crearCobroOrdinarioController', function ($scope, $http) {
  // Atributos
  $scope.cobroOrdinario = {
    'institucion' : null,
    'nombre' : '',
    'monto' : '',
    'con_factor' : false,
    'destino' : false,
    'estado' : false,
  }
  $scope.procesando = false
  $scope.instituciones = [
    { value: '1', label:'I.E. J. Soria' },
    { value: '2', label:'CEBA Konrad Adenahuer' },
    { value: '3', label:'I.S.T. Urusayhua' },
    { value: '4', label:'Universidad Privada Líder Peruana' },
  ];
  // Funciones
  $scope.guardarCobroOrdinario = function () {
    $scope.procesando = true
    var ruta = '/admin/cobros/ordinarios';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
       id_institucion : $scope.cobroOrdinario.institucion.value,
       nombre : $scope.cobroOrdinario.nombre,
       monto : $scope.cobroOrdinario.monto,
       con_factor : $scope.cobroOrdinario.con_factor,
       destino : $scope.cobroOrdinario.destino,
       estado : $scope.cobroOrdinario.estado,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      debug(response, false)
      if (response.data.resultado == 'true') {
        var texto = "Institución : " + $scope.cobroOrdinario.institucion.label + "\n"
                  + "Descripción : " + $scope.cobroOrdinario.nombre + "\n"
                  + "Monto : " + $scope.cobroOrdinario.monto + "\n"
                  + "Habilitado : " + ($scope.cobroOrdinario.estado ? "Si" : "No") + "\n"
                  + "Es Monto Unitario : " + ($scope.cobroOrdinario.con_factor ? "Si" : "No") + "\n"
                  + ($scope.cobroOrdinario.destino ? "* Este concepto almacena los ingresos en la cuenta exterior privada" : "")
        swal({
          title : "Concepto creado correctamente.",
          text : texto,
          type : "success",
          confirmButtonText: "Aceptar",
        }, function () {
          $scope.procesando = false
          $scope.cobroOrdinario = {
            'id_institucion' : null,
            'nombre' : '',
            'monto' : '',
            'con_factor' : false,
            'destino' : false,
            'estado' : false,
          }
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
});
