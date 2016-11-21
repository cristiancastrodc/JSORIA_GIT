// Definir la aplicación
var app = angular.module('registrarCobros', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       });
// Definir el controlador
app.controller('cobrosController', function ($scope, $http, $filter) {
  // Atributos
  $scope.buscando = false;
  $scope.cobranzaAlumno = false;
  $scope.cobranzaExtraordinaria = false;
  $scope.cobro = [];
  $scope.deudas = [];
  $scope.alumno = [];
  $scope.matricula_alumno = '';
  $scope.categorias = [];
  $scope.deudas_seleccionadas = [];
  $scope.conceptos_adicionales = [];
  $scope.finalizando = false;
  $scope.comprobante = [];
  $scope.id_institucion = '';
  $scope.tipo_comprobante = '';
  $scope.comprobantes = [];
  $scope.vuelto = '';
  $scope.efectivo = '';
  $scope.destino_externo = false;
  $scope.deuda_extraordinaria = [];
  // Funciones
  $scope.buscar = function (argument) {
    $scope.buscando = true;
    // Recuperar deudas de alumno o detalle de cobro extraordinario
    $http.get('/cajera/generar/ingreso/buscar/' + $scope.cobro.codigo)
    .success(function(response) {
      if (response.resultado == 'alumno') {
        $scope.deudas = response.deudas;
        $scope.alumno = response.alumno;
        $scope.matricula_alumno = response.matricula_alumno;
        $scope.categorias = response.categorias;
        $scope.cobranzaAlumno = true;
        $scope.id_institucion = response.id_institucion;
      } else if (response.resultado == 'extraordinario') {
        $scope.cobranzaExtraordinaria = true;
        $scope.deuda_extraordinaria = response.deuda_extraordinaria;
        $scope.id_institucion = response.id_institucion;
        $scope.destino_externo = $scope.deuda_extraordinaria.destino == 1;
      };
      // Alertar en caso sea necesario
      if (response.alertar == 'true') {
        swal({
          title : response.mensaje.titulo,
          text  : response.mensaje.contenido,
          type  : "warning",
        });
      }
      $scope.buscando = false;
    });
  };
  $scope.actualizarConcepto = function (concepto) {
    if (!concepto.seleccionada) {
      concepto.cantidad = 0;
      concepto.total = '0.00';
    }
  }
  $scope.calcularTotal = function (concepto) {
    var total = concepto.monto * concepto.cantidad;
    if (!isNaN(total)) {
      concepto.total = total.toFixed(2);
    } else {
      concepto.total = '0.00';
    }
  }
  $scope.finalizarCobro = function () {
    // Recuperar pedido
    $scope.deudas_seleccionadas = $filter('filter')($scope.deudas, { seleccionada : true });
    $scope.conceptos_adicionales = $filter('filter')($scope.categorias, { seleccionada : true });
    // Recuperar el valor de la variable destino externo
    $scope.destino_externo = $filter('filter')($scope.deudas, { seleccionada : true, destino : '1' }).length > 0 ||
                             $filter('filter')($scope.categorias, { seleccionada : true, destino : '1' }).length > 0;
    $scope.finalizando = true;
  }
  $scope.totalPago = function () {
    var i = 0;
    var suma = 0;
    // Sumar pagos
    for(; i < $scope.deudas_seleccionadas.length; i++) {
      monto = parseFloat($scope.deudas_seleccionadas[i].monto_pagado, 10);
      suma += monto;
    }
    // Sumar conceptos adicionales
    i = 0;
    for(; i < $scope.conceptos_adicionales.length; i++) {
      monto = parseFloat($scope.conceptos_adicionales[i].total, 10);
      suma += monto;
    }
    return suma;
  }
  $scope.datosComprobante = function () {
    $('#modal-resumen-pago').modal('show');
  }
  $scope.cargarSeries = function () {
    var ruta = '/cajera/comprobante/' + $scope.id_institucion + '/' + $scope.tipo_comprobante;
    $http.get(ruta)
    .success(function(response) {
      $scope.comprobantes = response;
    })
  }
  $scope.calcularVuelto = function () {
    var total = $scope.totalPago();
    var vuelto = parseFloat($scope.efectivo, 10) - parseFloat(total, 10);
    if (isNaN(vuelto)) {
      $scope.vuelto = '';
    } else {
      if (vuelto < 0) {
        $scope.vuelto = '';
      } else {
        $scope.vuelto = vuelto.toFixed(2);
      }
    };
  }
  $scope.grabarPago = function () {
    var ruta = '/cajera/generar/ingreso/grabar';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        nro_documento : $scope.alumno.nro_documento,
        deudas_seleccionadas : $scope.deudas_seleccionadas,
        conceptos_adicionales : $scope.conceptos_adicionales,
        tipo_comprobante : $scope.tipo_comprobante,
        comprobante : $scope.comprobante,
        id_institucion : $scope.id_institucion,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : "Éxito!",
          text : "Pagos de alumno correctamente actualizados.",
          type : "success",
          confirmButtonText: "Aceptar",
        }, function () {
          var data = {
            nro_documento : $scope.alumno.nro_documento,
            deudas_seleccionadas : angular.toJson($scope.deudas_seleccionadas),
            conceptos_adicionales : angular.toJson($scope.conceptos_adicionales),
            tipo_comprobante : $scope.tipo_comprobante,
            comprobante : angular.toJson($scope.comprobante),
          };
          post('/cajera/generar/ingreso/imprimir', data);
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
  $scope.calcularVueltoExtraordinario = function () {
    var total = $scope.deuda_extraordinaria.saldo;
    var vuelto = parseFloat($scope.efectivo, 10) - parseFloat(total, 10);
    if (isNaN(vuelto)) {
      $scope.vuelto = '';
    } else {
      if (vuelto < 0) {
        $scope.vuelto = '';
      } else {
        $scope.vuelto = vuelto.toFixed(2);
      }
    };
  }
  $scope.finalizarCobroExtraordinario = function () {
    var ruta = '/cajera/generar/ingreso/grabar_extraordinario';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        deuda_extraordinaria : $scope.deuda_extraordinaria,
        tipo_comprobante : $scope.tipo_comprobante,
        comprobante : $scope.comprobante,
        id_institucion : $scope.id_institucion,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : "Éxito!",
          text : "Cobro realizado.",
          type : "success",
          confirmButtonText: "Aceptar",
        }, function () {
          var data = {
            deuda_extraordinaria : angular.toJson($scope.deuda_extraordinaria),
            tipo_comprobante : $scope.tipo_comprobante,
            comprobante : angular.toJson($scope.comprobante),
          };
          post('/cajera/generar/ingreso/imprimir_extraordinario', data);
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
  $scope.cancelar = function (argument) {
    $scope.buscando = false;
    $scope.cobranzaAlumno = false;
    $scope.finalizando = false;
    $scope.cobro.codigo = '';
  };
});

// Post to the provided URL with the specified parameters.
function post(path, parameters) {
  var form = $('<form></form>');

  form.attr("method", "post");
  form.attr("action", path);

  $.each(parameters, function(key, value) {
      var field = $('<input></input>');
      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);
      form.append(field);
  });

  var _token = $('#_token').val();
  var field = $('<input></input>');
  field.attr("type", "hidden");
  field.attr("name", "_token");
  field.attr("value", _token);
  form.append(field);
  // The form needs to be a part of the document in
  // order for us to be able to submit it.
  $(document.body).append(form);
  form.submit();
}
