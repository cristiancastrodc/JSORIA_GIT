/*** Inicio de Buscar Deudas de Alumno o Deuda Extraordinaria ***/
$('#form-buscar-deudas #btn-buscar-deudas').click(function (e) {
  e.preventDefault();

  var $codigo = $('#form-buscar-deudas #codigo').val();

  var ruta = 'cajera/buscar/deudas/' + $codigo;

  $.get(ruta, function(response) {
    if (response['mensaje']) {
      swal({
        title: 'ERROR',
        text : response['mensaje'],
        type : 'warning',
      });
    } else {
      if (response['res']) {
        $('#card-deudas-alumno').slideUp('fast');
        $('#tabla-pagos-pendientes > tbody').empty();
        $('#tabla-categorias-compras > tbody').empty();
        var deuda = response['deuda'];
        var cliente = deuda['cliente_extr'];
        var descripcion = deuda['descripcion_extr'];
        var monto = deuda['saldo'];
        var id_deuda = deuda['id'];

        $("#cliente_extr").html(cliente);
        $("#descripcion_extr").html(descripcion);
        $("#monto_extr").html(monto.toFixed(2));
        $('#id_deuda_extr').val(id_deuda);
        $('#card-deuda-extraordinaria.js-toggle').slideDown('fast');
      } else{
        $('#card-deuda-extraordinaria.js-toggle').slideUp('fast');
        var nombre_alumno = response[0].nombres + ' ' + response[0].apellidos;
        var nro_documento = response[0].nro_documento;
        $('#nro_documento').val(nro_documento);
        $('#nombre-alumno').html(nombre_alumno);
        var nombre_institucion = response[1].nombre;
        var id_institucion = response[1].id;
        $('#id_institucion').val(id_institucion);
        $('#nombre-institucion').html(nombre_institucion);

        $('#tabla-pagos-pendientes tbody').empty();
        for (var i = 0; i < response[2].length; i++) {
          var fila = "<tr>";
          fila += "<td class='hidden id'>" + response[2][i].id + "</td>";
          fila += "<td class='hidden destino'>" + response[2][i].destino + "</td>";
          fila += "<td class='nombre'>" + response[2][i].nombre + "</td>";

          monto = parseFloat(response[2][i].saldo) - parseFloat(response[2][i].descuento);
          fila += "<td class='text-right monto'>" + monto.toFixed(2) + "</td>";

          fila += "<td><label class='checkbox checkbox-inline'><input type='checkbox' class='selected'><i class='input-helper'></i> Seleccionar</label></td>";
          fila += "</tr>";

          $('#tabla-pagos-pendientes tbody').append(fila);
        };

        $('#tabla-categorias-compras tbody').empty();
        for (var i = 0; i < response[3].length; i++) {
          var fila = "<tr class='" + response[3][i].id + "'>";
          fila += "<td class='hidden id'>" + response[3][i].id + "</td>";
          fila += "<td class='hidden destino'>" + response[3][i].destino + "</td>";
          fila += "<td><div class='fg-line'><input type='text' class='form-control text-right cantidad' value='0' onkeyup='calcularImporte(" + response[3][i].id + ", this.value)'></div></td>";
          fila += "<td class='nombre'>" + response[3][i].nombre + "</td>";
          fila += "<td><input type='text' class='form-control text-right monto disabled' disabled value='" + response[3][i].monto + "' /></td>";
          fila += "<td><input type='text' class='form-control text-right importe disabled' disabled /></td>";
          fila += "</tr>";

          $('#tabla-categorias-compras tbody').append(fila);
        };

        /***** DEBUG MESSAGE *****/
        debug(response, false);
        /*************************/
        $('#card-deudas-alumno.js-toggle').slideDown();
      };
    };
  });
});

/*** Fin de Buscar Deudas de Alumno o Deuda Extraordinaria ***/

/*** Inicio de Procesos en la tabla de compras ***/
$('#btn-toggle-compras').click(function (e) {
  $('#compras-toggle').slideToggle();
});

function calcularImporte (id, value) {
  var sel = '#tabla-categorias-compras tr.' + id;
  if (value != "") {
    value = parseFloat(value);
    var unitario = parseFloat($(sel).find('.monto').val());
    var importe = value * unitario;
    $(sel).find('.importe').val(importe);
  } else {
    $(sel).find('.importe').val('0');
  }
};
/*** Fin de Procesos en la tabla de compras ***/

/*** Inicio de Procesar Pago ***/
$('#btn-finalizar-pago').click(function (e) {
  e.preventDefault();

  var fila_resumen = "";
  var total = 0;
  var destino_externo = false;
  var id_pagos = [];
  var id_compras = [];

  var $filas_pagos = $("#tabla-pagos-pendientes tr");
  var nro_pagos_sel = 0;
  $filas_pagos.each(function(index, el) {
    var sel = $(this).find('.selected').is(':checked');
    if (sel) {
      destino_externo = $(this).find('.destino').html() == "0" ? false : true;
      var monto_pago = parseFloat($(this).find('.monto').html());
      fila_resumen += "<tr><td class='hidden id'>" + $(this).find('.id').html() + "</td><td class='nombre'>" + $(this).find('.nombre').html() + "</td><td class='monto text-right'>" + monto_pago + "</td></tr>"
      nro_pagos_sel++;
      total += monto_pago;
      id_pagos.push($(this).find('.id').html());
    };
  });
  $('#id_pagos').val(id_pagos);

  var $filas_compras = $("#tabla-categorias-compras tr");
  var nro_compras = 0;
  $filas_compras.each(function(index, el) {
    var qty = parseInt($(this).find('.cantidad').val());
    if (qty > 0) {
      destino_externo = $(this).find('.destino').html() == "0" ? false : true;
      var monto_compra = parseFloat($(this).find('.importe').val());
      fila_resumen += "<tr><td class='hidden id'>" + $(this).find('.id').html() + "</td><td class='nombre'>" + $(this).find('.nombre').html() + "</td><td class='monto text-right'>" + monto_compra + "</td></tr>"
      nro_compras++;
      total += monto_compra;
      id_compras.push([$(this).find('.id').html(), monto_compra]);
    };
  });
  $('#id_compras').val(id_compras);

  $modal = $('#modal-resumen-pago');
  $modal.find('#tabla-resumen tbody').empty();
  if (nro_pagos_sel == 0 && nro_compras == 0) {
    swal({
      title : 'Advertencia',
      text : 'Debe seleccionar una deuda a pagar o una compra como mínimo.',
      type : 'warning'
    });
  } else{
    $modal.find('#tabla-resumen tbody').append(fila_resumen);
    $modal.find('#tabla-resumen tbody').append("<tr><td class='text-right'><b>TOTAL:</b></td><td class='text-right'>"  + total + "</td></tr>");
    var botones = "<button type='button' class='btn btn-link' data-dismiss='modal'>CANCELAR</button><button id='btn-comprobante' class='btn btn-default bgm-indigo'>COMPROBANTE</button>";
    if (!destino_externo) {
      botones += "<button type='button' class='btn bgm-orange btn-md' id='btn-boleta'>BOLETA</button><button type='button' class='btn bgm-green btn-md' id='btn-factura'>FACTURA</button>";
    }
    $modal.find('.modal-footer').html(botones);
    $modal.modal('show');
  };
});

$('#modal-resumen-pago').on('click', '#btn-comprobante', function(e) {
  e.preventDefault();

  procesarComprobanteBoleta('comprobante');
});

$('#modal-resumen-pago').on('click', '#btn-boleta', function(e) {
  e.preventDefault();

  procesarComprobanteBoleta('boleta');
});

$('#modal-resumen-pago').on('click', '#btn-factura', function(e) {
  e.preventDefault();

  var $id_institucion = $('#id_institucion').val();
  var $nro_documento = $('#nro_documento').val();
  var $ruc_cliente = $('#ruc_cliente').val();
  var $razon_social = $('#razon_social').val();
  var $direccion = $('#direccion').val();
  var $token = $('#_token').val();
  var $id_pagos = $("#id_pagos").val();
  var $id_compras = $("#id_compras").val();

  $.ajax({
    url: '/cajera/cobro/guardar',
    headers: {'X-CSRF-TOKEN' : $token},
    type: 'POST',
    dataType: 'json',
    data: {
      tipo: 'factura',
      id_institucion: $id_institucion,
      nro_documento : $nro_documento,
      ruc_cliente : $ruc_cliente,
      razon_social : $razon_social,
      direccion : $direccion,
      id_pagos : $id_pagos,
      id_compras : $id_compras,
    },
    success : function (data) {
      swal({
        title : '¡Éxito!',
        text :  data.mensaje,
        type : 'success',
      }, function () {
        document.location.reload();
      });
    },
    error : function (data) {
      var error = '203';
      sweet_alert('Ocurrió algo inesperado', 'No se puede procesar la petición. Error: ' + error);
    },
    complete : function (data, textStatus) {
      debug(data, false);
      debug(textStatus);
    }
  });
});

function procesarComprobanteBoleta ($tipo) {
  debug('Procesar Comprobante / Boleta');
  var $id_institucion = $('#id_institucion').val();
  var $nro_documento = $('#nro_documento').val();
  var $token = $('#_token').val();
  var $id_pagos = $("#id_pagos").val();
  var $id_compras = $("#id_compras").val();

  $.ajax({
    url: '/cajera/cobro/guardar',
    headers: {'X-CSRF-TOKEN' : $token},
    type: 'POST',
    dataType: 'json',
    data: {
      tipo : $tipo,
      id_institucion: $id_institucion,
      nro_documento : $nro_documento,
      id_pagos : $id_pagos,
      id_compras : $id_compras,
    },
    success : function (data) {
      debug(data, false);
      swal({
        title : '¡Éxito!',
        text :  data.mensaje,
        type : 'success',
      }, function () {
        document.location.reload();
      });
    },
    error : function (data) {
      debug(data, false);
      var error = '202';
      sweet_alert('Ocurrió algo inesperado', 'No se puede procesar la petición. Error: ' + error, 'error');
    },
  });
}
/*** Fin de Procesar Pago ***/

/*** Inicio de Procesar pago Extra ***/
$('#btn-comprobante-extr').click(function(e) {
  e.preventDefault();
  debug('Presionado boton de Compr. Extr.');

  var id_deuda_extr = $('#id_deuda_extr').val();
  var ruta = '/cajera/cobro/extraordinario/guardar';
  var $token = $('#_token').val();

  $.ajax({
    url: ruta,
    headers: {'X-CSRF-TOKEN' : $token},
    type: 'POST',
    dataType: 'json',
    data: {
      id_deuda_extr: id_deuda_extr,
      tipo: 'comprobante',
    },
    success : function (data) {
      swal({
        title : '¡Éxito!',
        text :  data.mensaje,
        type : 'success',
      }, function () {
        document.location.reload();
      });
    },
    error : function (data) {
      var error = '203';
      sweet_alert('Ocurrió algo inesperado', 'No se puede procesar la petición. Error: ' + error);
    },
    complete : function (data, textStatus) {
      debug(data, false);
      debug(textStatus);
    }
  });
});

$('#btn-boleta-extr').click(function(e) {
  e.preventDefault();
  debug('Presionado boton de Boleta. Extr.');

  var id_deuda_extr = $('#id_deuda_extr').val();
});

$('#btn-factura-extr').click(function(e) {
  e.preventDefault();
  debug('Presionado boton de Factura. Extr.');

  var id_deuda_extr = $('#id_deuda_extr').val();
});
/*** Fin de Procesar pago Extra ***/

$('#btn-cobrar-multiple').click(function(e) {
  e.preventDefault();
  debug('Clicked');

  var $filas = $("#otros-conceptos > tbody > tr");
  var nro_pagos_sel = 0;
  var compras = [];
  var filas_resumen = "";
  var total = 0;
  var destino_externo = false;

  $filas.each(function(index, el) {
    var sel = $(this).find('.selected').is(':checked');
    if (sel) {
      if (!destino_externo) { destino_externo = $(this).find('.destino').html() == "0" ? false : true; };
      var monto_pago = parseFloat($(this).find('.monto').html());
      filas_resumen += "<tr><td class='hidden id'>" + $(this).find('.id').html() + "</td><td class='nombre'>" + $(this).find('.nombre').html() + "</td><td class='monto text-right'>" + monto_pago + "</td></tr>"
      nro_pagos_sel++;
      total += monto_pago;
      compras.push($(this).find('.id').html());
    };
  });

  debug(destino_externo, false);

  $('#card-cobro-multiple.js-toggle').slideDown('fast');
});

