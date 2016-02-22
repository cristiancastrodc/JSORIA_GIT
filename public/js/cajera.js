/*** Buscar Deudas de Alumno o Deuda Extraordinaria ***/
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
    } else{
      var nombre_alumno = response[0].nombres + ' ' + response[0].apellidos;
      $('#nombre-alumno').html(nombre_alumno);
      var nombre_institucion = response[1].nombre;
      var id_institucion = response[1].id;
      $('#nombre-institucion').html(nombre_institucion);

      $('#tabla-pagos-pendientes tbody').empty();
      for (var i = 0; i < response[2].length; i++) {
        var fila = "<tr>";
        fila += "<td class='hidden'>" + response[2][i].id + "</td>";
        fila += "<td>" + response[2][i].nombre + "</td>";

        monto = parseFloat(response[2][i].saldo) - parseFloat(response[2][i].descuento);
        fila += "<td class='text-right'>" + monto.toFixed(2) + "</td>";

        fila += "<td><label class='checkbox checkbox-inline'><input type='checkbox'><i class='input-helper'></i> Seleccionar</label></td>";
        fila += "</tr>";

        $('#tabla-pagos-pendientes tbody').append(fila);
      };

      $('#tabla-categorias-compras tbody').empty();
      for (var i = 0; i < response[3].length; i++) {
        var fila = "<tr class='" + response[3][i].id + "'>";
        fila += "<td class='hidden'>" + response[3][i].id + "</td>";
        fila += "<td><div class='fg-line'><input type='text' class='form-control text-right' value='0' onkeyup='calcularImporte(" + response[3][i].id + ", this.value)'></div></td>";
        fila += "<td>" + response[3][i].nombre + "</td>";
        fila += "<td><input type='text' class='form-control text-right monto disabled' disabled value='" + response[3][i].monto + "' /></td>";
        fila += "<td><input type='text' class='form-control text-right importe disabled' disabled /></td>";
        fila += "</tr>";

        $('#tabla-categorias-compras tbody').append(fila);
      };

      console.log(response);
      $('#card-deudas-alumno.js-toggle').slideDown();
    };
  });
});

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

$('#btn-finalizar-pago').click(function (e) {
  $modal = $('#modal-resumen-pago');

  $modal.modal('show');
});