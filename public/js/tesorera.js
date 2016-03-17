$('#form-registrar-egreso-tesorera #tipo_comprobante').change(function (event){
	var seleccionado = $('#form-registrar-egreso-tesorera #tipo_comprobante').val();

	if (seleccionado == 3) {
		$('#numero_comprobante').prop('disabled', true);
		$('#form-group-nro-comprobante').slideUp();
	} else {
		$('#numero_comprobante').prop('disabled', false);
		$('#form-group-nro-comprobante').slideDown();
	}
});


$('#form-registrar-egreso-tesorera #btn_nuevo_rubro').click(function (e) {
  e.preventDefault();

  var ruta ='../egresos/rubroNuevo/';
  var dato = $('#nombre').val();
  var token =$('#token').val();

  $.ajax({
  	url: ruta,
  	headers: {'X-CSRF-TOKEN': token},
  	type: 'POST',
  	dataType: 'json',
  	data:{nombre: dato},
  	success : function (response) {
  		swal({
          title: "Éxito",
          text: "Rubro creado.",
          type: "success",
      });
  		$('#nombre').val("");

  	}
  });
});

/****** Retirar Ingresos *******/
$('#form-ingresos-cajera #btn-ingresos-cajera').click(function(e) {
  e.preventDefault();
  debug('Boton Buscar Cobros presionado.');

  var $id_cajera = $('#id_cajera').val();

  if ($id_cajera != '') {
    $('#tabla-ingresos-cajera tbody').empty();
    var ruta = 'retirar/' + $('#id_cajera').val() + "";

    $.get(ruta, function (response, state) {
      var monto_no_retirado = 0;
      var monto_por_retirar = 0;
      for (var i = 0; i < response.length; i++) {
        var monto = response[i].saldo - response[i].descuento;
        if (response[i].estado_retiro == 0) {
          monto_no_retirado += monto;
        } else if (response[i].estado_retiro == 1) {
          monto_por_retirar += monto;
        }
        var fila = "<tr>";
        fila += "<td class='hidden id_cobro'>" + response[i].id + "</td>";
        fila += "<td>" + response[i].fecha_hora_ingreso + "</td>";
        fila += "<td>" + response[i].nombre + "</td>";
        if (response[i].estado_retiro == 0) {
          fila += "<td><span class='p-5'>No retirado</span></td>";
        } else if (response[i].estado_retiro == 1) {
          fila += "<td><span class='bgm-orange c-white p-5'>Por retirar</span></td>";
        }
        fila += "<td class='text-right'>" + monto.toFixed(2) + "</td>";
        fila += "</tr>";
        $('#tabla-ingresos-cajera tbody').append(fila);
      };
      $('#cobros-no-retirados').html(monto_no_retirado.toFixed(2));
      $('#cobros-por-retirar').html(monto_por_retirar.toFixed(2));
    });
    $('#card-ingresos-admin.js-toggle').slideDown();
  } else {
    sweet_alert('¡Atención!', 'Debe de seleccionar una cajera.', 'warning');
  }
});

$('#btn-retirar-ingresos').click(function (e) {
  e.preventDefault();
  debug('Boton Retirar Ingresos presionado.');

  var ids_cobros = [];
  $('#tabla-ingresos-cajera tbody > tr').each(function(index, el) {
    ids_cobros.push($(this).find('.id_cobro').html());
  });

  var ruta = 'retirar/actualizar';
  var $token = $('#_token').val();
  $.ajax({
    url: ruta,
    type: 'POST',
    dataType: 'json',
    headers : { 'X-CSRF-TOKEN' : $token },
    data : { ids_cobros : ids_cobros }
  })
  .done(function(data) {
    if (data.tipo == 'creado') {
      debug("Retiro creado con éxito.");
      sweet_alert('¡Éxito!', data.mensaje, 'success', 'reload');
    } else if (data.tipo == 'sin_cambios') {
      debug("No se realizó cambios.");
      swal({
        title: data.mensaje
      }, function () {
        document.location.reload();
      });
    };
  })
  .fail(function(data) {
    debug("Error del servidor.");
    debug(data, false);
    sweet_alert('Ocurrió algo inesperado', 'No se pudo procesar la petición.', 'warning', 'reload');
  });
});
/*** Fin de Retirar Ingresos ***/