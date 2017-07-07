// Definir la aplicación
var app = angular.module('registrarCobros', [], function($interpolateProvider) {
                          $interpolateProvider.startSymbol('{@');
                          $interpolateProvider.endSymbol('@}');
                       })
                 .constant('API_URL', '/deuda_ingreso')
// Definir el controlador para Cobros y Cobros Extraordinarios
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
  $scope.busqueda = {
    concepto : '',
    categoria : '',
  }
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
  $scope.cargarNumero = function () {
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
    $scope.busqueda = {
      concepto : '',
      categoria : '',
    }
  }
  $scope.esValidoCobro = function () {
    var nro_deudas = $filter('filter')($scope.deudas, { seleccionada : true }).length
    var deudas_validas = true
    if (nro_deudas > 0) {
      deudas_validas = $filter('filter')($scope.deudas, $scope.filtroDeudaNoValida).length <= 0
    }
    var nro_cobros = $filter('filter')($scope.categorias, { seleccionada : true }).length
    var cobros_validos = true
    if (nro_cobros > 0) {
      cobros_validos = $filter('filter')($scope.categorias, $scope.filtroCobroNoValido).length <= 0
    }
    return (nro_deudas > 0 || nro_cobros > 0)
            && deudas_validas && cobros_validos
  }
  $scope.filtroDeudaNoValida = function (value, index, array) {
    return typeof value.seleccionada !== 'undefined'
            && value.seleccionada
            && (typeof value.monto_pagado === 'undefined'
                || value.monto_pagado <= 0)
  }
  $scope.filtroCobroNoValido = function (value, index, array) {
    return typeof value.seleccionada !== 'undefined'
            && value.seleccionada
            && (typeof value.cantidad === 'undefined'
                || value.cantidad <= 0)
  }
  $scope.esValidoDatosComprobante = function () {
    return ($scope.comprobante.tipo == 'factura' ?
              ($scope.comprobante.ruc != '' && $scope.comprobante.razon_social != '' && $scope.comprobante.direccion != '') :
              $scope.comprobante.tipo != '')
           && $scope.comprobante.serie != ''
           && $scope.comprobante.numero != ''
  }
  $scope.regresarAConceptos = function () {
    $scope.finalizando = false
  }  
  $scope.filtroConcepto = function (concepto, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(concepto)
  }
  $scope.filtroCategoria = function (categoria, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(categoria)
  }
})
// Definir el controlador para Otros Cobros
app.controller('ingresosMultiplesController', function($scope, $http, $filter, API_URL) {
  // Atributos
  $scope.busqueda = {
    nombre : '',
    institucion : '',
  }
  $scope.categorias = []
  $scope.categoria = null
  $scope.cliente = null
  $scope.comprobante = null
  $scope.comprobantes = null
  $scope.procesando = false
  $scope.efectivo = null
  $scope.vuelto = null
  // Procesos Iniciales
  $scope.listarCategorias = function () {
    $http.get('/categoria/multiple/listar')
    .then(function (response) {
      $scope.categorias = response.data
    })
  }
  $scope.listarCategorias()
  // Funciones
  $scope.filtroNombre = function (nombre, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(nombre)
  }
  $scope.filtroInstitucion = function (institucion, texto) {
    if (texto === '' || texto === null) return true
    var regex = new RegExp("\\b" + texto, "i")
    return regex.test(institucion)
  }
  $scope.cargarSeries = function () {
    if ($scope.comprobante != null) {
      var ruta = '/cajera/comprobante/' + $scope.categoria.id_institucion + '/' + $scope.comprobante.tipo
      $http.get(ruta)
      .then(function(response) {
        $scope.comprobantes = response.data
        $scope.comprobante.serie = ''
        $scope.comprobante.numero = ''
        $scope.comprobante.ruc = ''
        $scope.comprobante.razon_social = ''
        $scope.comprobante.direccion = ''
      })
    }
  }
  $scope.cargarNumero = function () {
    $scope.comprobante.numero = $filter('filter')($scope.comprobantes, { serie : $scope.comprobante.serie })[0].numero_comprobante
  }
  $scope.calcularVuelto = function () {
    var vuelto = parseFloat($scope.efectivo, 10) - parseFloat($scope.categoria.monto, 10)
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
  $scope.inicializar = function () {
    $scope.busqueda = {
      nombre : '',
      institucion : '',
    }
    $scope.categoria = null
    $scope.cliente = null
    $scope.comprobante = null
  }
  $scope.esValidoFormCreacion = function () {
    return $scope.categoria != null
            && $scope.cliente != null
            && $scope.cliente.dni != null
            && $scope.cliente.dni != ''
            && $scope.cliente.nombre != null
            && $scope.cliente.nombre != ''
            && $scope.comprobante != null
            && $scope.comprobante.tipo != ''
            && $scope.comprobante.tipo != null
            && $scope.comprobante.serie != ''
            && $scope.comprobante.serie != null
            && $scope.comprobante.numero != ''
            && $scope.comprobante.numero != null
            && ($scope.comprobante.tipo != 'factura' ? true :
                $scope.cliente.ruc != ''
                && $scope.cliente.ruc != null
                && $scope.cliente.razon_social != null
                && $scope.cliente.razon_social != ''
                && $scope.cliente.direccion != null
                && $scope.cliente.direccion != '')
  }
  $scope.grabarIngreso = function () {
    $scope.procesando = true
    $http.post(API_URL, {
      tipo_ingreso : 'multiple',
      categoria : $scope.categoria,
      cliente : $scope.cliente,
      comprobante : $scope.comprobante,
    })
    .then(function successCallback(response) {
      if (response.data.resultado == 'true') {
        swal({
          title : 'Éxito.',
          text : 'Cobro creado correctamente.',
          type : 'success',
          confirmButtonText: 'Aceptar',
          confirmButtonClass : 'main-color',
          closeOnConfirm : false,
        }, function () {
          post('/cajera/generar/ingreso/imprimir_multiple', {
            nombre_categoria : $scope.categoria.nombre,
            monto : $scope.categoria.monto,
            dni : $scope.cliente.dni,
            nombre : $scope.cliente.nombre,
            ruc: $scope.cliente.ruc,
            razon_social: $scope.cliente.razon_social,
            direccion: $scope.cliente.direccion,
            tipo: $scope.comprobante.tipo,
          });
        });
      } else {
        swal({
          title: 'Error.',
          text: 'No se pudo guardar el Cobro. Mensaje: ' + response.data.mensaje,
          type: 'error',
        }, function () {
          $scope.procesando = false
        })
      }
    }, function errorCallback(response) {
      debug(response, false)
      swal({
        title: 'Error.',
        text: 'No se pudo guardar el Cobro.',
        type: 'error',
      }, function () {
        $scope.procesando = false
      })
    })
  }
})
