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
  $scope.comprobante = {
    tipo : '',
    serie : '',
    numero : '',
    ruc : '',
    razon_social : '',
    direccion : '',
  };
  $scope.id_institucion = '';
  $scope.comprobantes = [];
  $scope.vuelto = '';
  $scope.efectivo = '';
  $scope.destino_externo = false;
  $scope.deuda_extraordinaria = [];
  // Funciones
  $scope.buscar = function () {
    $scope.buscando = true;
    // Recuperar deudas de alumno o detalle de cobro extraordinario
    var ruta = '/cajera/generar/ingreso/buscar/' + $scope.cobro.codigo
    $http.get(ruta)
    .then(function(response) {
      if (response.data.resultado == 'alumno') {
        $scope.deudas = response.data.deudas;
        $scope.alumno = response.data.alumno;
        $scope.matricula_alumno = response.data.matricula_alumno;
        $scope.categorias = response.data.categorias;
        $scope.cobranzaAlumno = true;
        $scope.id_institucion = response.data.id_institucion;
      } else if (response.data.resultado == 'extraordinario') {
        $scope.cobranzaExtraordinaria = true;
        $scope.deuda_extraordinaria = response.data.deuda_extraordinaria;
        $scope.id_institucion = response.data.id_institucion;
        $scope.destino_externo = $scope.deuda_extraordinaria.destino == 1;
      };
      // Alertar en caso sea necesario
      if (response.data.alertar == 'true') {
        swal({
          title : response.data.mensaje.titulo,
          text  : response.data.mensaje.contenido,
          type  : 'warning',
        });
      }
      $scope.buscando = false;
    });
  };
  $scope.actualizarConcepto = function (concepto) {
    if (!concepto.seleccionada) {
      concepto.cantidad = ''
      concepto.total = 0
    }
  }
  $scope.calcularTotal = function (concepto) {
    var total = concepto.monto * concepto.cantidad;
    if (!isNaN(total)) {
      concepto.total = total.toFixed(2);
    } else {
      concepto.total = 0;
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
    var ruta = '/cajera/comprobante/' + $scope.id_institucion + '/' + $scope.comprobante.tipo;
    $http.get(ruta)
    .then(function(response) {
      $scope.comprobantes = response.data;
      $scope.comprobante.serie = ''
      $scope.comprobante.numero = ''
      $scope.comprobante.ruc = ''
      $scope.comprobante.razon_social = ''
      $scope.comprobante.direccion = ''
    })
  }
  $scope.cargarNumero = function (numero) {
    $scope.comprobante.numero = $filter('filter')($scope.comprobantes, { serie : $scope.comprobante.serie })[0].numero_comprobante
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
    }
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
        comprobante : $scope.comprobante,
        id_institucion : $scope.id_institucion,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      $('#modal-resumen-pago').modal('hide')
      if (response.data.resultado == 'true') {
        swal({
          title : 'Éxito.',
          text : 'Pagos de alumno correctamente actualizados.',
          type : 'success',
          confirmButtonText: 'Aceptar',
          confirmButtonClass : 'main-color',
        }, function () {
          var data = {
            nro_documento : $scope.alumno.nro_documento,
            deudas_seleccionadas : angular.toJson($scope.deudas_seleccionadas),
            conceptos_adicionales : angular.toJson($scope.conceptos_adicionales),
            comprobante : angular.toJson($scope.comprobante),
          };
          post('/cajera/generar/ingreso/imprimir', data);
        });
      } else {
        swal({
          title: response.data.mensaje.titulo,
          text: 'No se pudo guardar el Cobro. Mensaje: ' + response.data.mensaje.contenido,
          type: 'warning',
        }, function () {
          document.location.reload()
        })
      }
    }, function errorCallback(response) {
      $('#modal-resumen-pago').modal('hide')
      debug(response.data, false)
      swal({
        title: 'Error.',
        text: 'No se pudo guardar el Cobro.',
        type: 'warning',
      })
    })
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
    }
  }
  $scope.finalizarCobroExtraordinario = function () {
    var ruta = '/cajera/generar/ingreso/grabar_extraordinario';
    $http({
      method: 'POST',
      url: ruta,
      data : $.param({
        deuda_extraordinaria : $scope.deuda_extraordinaria,
        comprobante : $scope.comprobante,
        id_institucion : $scope.id_institucion,
      }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : 'Éxito.',
          text : 'Cobro guardado correctamente.',
          type : 'success',
          confirmButtonText: 'Aceptar',
          confirmButtonClass: 'main-color',
        }, function () {
          var data = {
            deuda_extraordinaria : angular.toJson($scope.deuda_extraordinaria),
            comprobante : angular.toJson($scope.comprobante),
          };
          post('/cajera/generar/ingreso/imprimir_extraordinario', data);
        });
      } else {
        swal({
          title: response.data.mensaje.titulo,
          text: 'No se pudo guardar el Cobro. Mensaje: ' + response.data.mensaje.contenido,
          type: 'warning',
        }, function () {
          document.location.reload();
        });
      }
    }, function errorCallback(response) {
      debug(response.data, false)
      swal({
        title: 'Error.',
        text: 'No se pudo guardar el Cobro.',
        type: 'warning',
      })
    });
  }
  $scope.cancelar = function (argument) {
    $scope.buscando = false;
    $scope.cobranzaAlumno = false;
    $scope.finalizando = false;
    $scope.cobro.codigo = '';
  };
  $scope.esValidoCobro = function () {
    return $filter('filter')($scope.deudas, { seleccionada : true }).length > 0
           || $filter('filter')($scope.categorias, { seleccionada : true }).length > 0;
  }
  $scope.esValidoDatosComprobante = function () {
    return ($scope.comprobante.tipo == 'factura' ?
              ($scope.comprobante.ruc != '' && $scope.comprobante.razon_social != '' && $scope.comprobante.direccion != '') :
              $scope.comprobante.tipo != '')
           && $scope.comprobante.serie != ''
           && $scope.comprobante.numero != ''
  }
});
