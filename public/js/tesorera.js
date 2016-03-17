/****** Agregar Egreso *******/
$('#form-registrar-egreso-tesorera #tipo_comprobante').change(function (event){
	var seleccionado = $('#form-registrar-egreso-tesorera #tipo_comprobante').val();

	if (seleccionado == 3) {
		$('#numero_comprobante').prop('disabled', true);
    $('#numero_comprobante').val('cp');
		$('#form-group-nro-comprobante').slideUp();
	} else {
		$('#numero_comprobante').prop('disabled', false);
    $('#numero_comprobante').val('');
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
      }, function () {
        $('#nombre').val("");
        reloadRubros();
      });
  	}
  });
});

function reloadRubros () {
  debug('Recargar rubros.');
  var ruta = '../rubro/listar/';
  var $sel_rubros = $('#rubro_egreso');
  $sel_rubros.empty();

  $.get(ruta, function (data) {
    debug('AJAX request completed.');
    debug(data, false);
    for (var i = 0; i < data.length; i++) {
        var opcion = "<option value='" + data[i].id + "'>" + data[i].nombre + "</option>";
        $sel_rubros.append(opcion);
    };
    $sel_rubros.selectpicker('refresh');
  });
};

$('#btn-detalle-egreso-agregar').click(function(e) {
  e.preventDefault();
  debug('Boton Agregar Egreso presionado');

  var $descripcion = $('#egreso #descripcion_egreso').val();
  var $rubro = $('#egreso #rubro_egreso').val();
  var $textoRubro = $('#rubro_egreso option:selected').text();
  var $monto = $('#egreso #monto_egreso').val();

  if ($descripcion != "" && $rubro != "" && $monto != "") {
    debug('Agregar Egreso a la tabla');
    var fila = "<tr>";
    fila += "<td class='egreso-descripcion'>" + $descripcion + "</td>";
    fila += "<td class='hidden egreso-rubro-id'>" + $rubro + "</td>";
    fila += "<td>" + $textoRubro + "</td>";
    fila += "<td class='text-right egreso-monto'>" + parseFloat($monto).toFixed(2) + "</td>";
    fila += "<td><a class='delete-row c-red'><i class='zmdi zmdi-close-circle'></i> Quitar</a></td>";
    fila += "</tr>";

    $('#tabla-resumen-egresos tbody').append(fila);

    $('#egreso #descripcion_egreso').val('');
    $('#rubro_egreso').selectpicker('deselectAll');
    $('#egreso #monto_egreso').val('');
  } else{
    debug('Datos de egreso incompletos.');
    sweet_alert('¡Atención!', 'Debe llenar todos los campos de egreso.', 'warning');
  };
});

$('#tabla-resumen-egresos').on('click', '.delete-row', function() {
  $(this).parents('tr').remove();
});

$('#btn-guardar-egreso').click(function(e) {
  e.preventDefault();
  debug('Boton Guardar Egreso presionado.');

  var $id_institucion = $('#id_institucion').val();
  var $tipo_comprobante = $('#tipo_comprobante').val();
  var $numero_comprobante = $('#numero_comprobante').val();
  var $fecha_egreso = $('#fecha_egreso').val();

  if ($id_institucion != "" && $tipo_comprobante != "" && $fecha_egreso != "" && $numero_comprobante != "") {
    debug('Maestro OK. Comprobar detalle.');
    var $filas_detalle = $('#tabla-resumen-egresos > tbody > tr');

    if ($filas_detalle.length > 0) {
      debug('El egreso maestro y detalle están correctos.');

      var ruta = '../egresos/crear_egreso';
      var $token = $('#_token').val();
      var detalle_egreso = [];

      $('#tabla-resumen-egresos > tbody > tr').each(function(index, el) {
        var $descripcion = $(this).find('.egreso-descripcion').html();
        var $egreso_rubro = $(this).find('.egreso-rubro-id').html();
        var $monto = $(this).find('.egreso-monto').html();
        var detalle = {
          "descripcion" : $descripcion,
          "id_rubro" : $egreso_rubro,
          "monto" : $monto,
        };
        detalle_egreso.push(detalle);
      });
      debug(detalle_egreso, false);

      $.ajax({
        headers : { 'X-CSRF-TOKEN' : $token },
        url: ruta,
        type: 'POST',
        dataType: 'json',
        data : {
          id_institucion : $id_institucion,
          tipo_comprobante : $tipo_comprobante,
          numero_comprobante : $numero_comprobante,
          fecha_egreso : $fecha_egreso,
          detalle_egreso : detalle_egreso,
        }
      })
      .done(function(data) {
        debug(data.mensaje);
        sweet_alert('¡Éxito!', data.mensaje, 'success', 'reload');
      })
      .fail(function(data) {
        debug('Error en la creación del egreso.');
        debug(data, false);
        sweet_alert('Ocurrió algo inesperado', 'Hubo un error en la creación del egreso, inténtelo de nuevo más tarde.', 'warning', 'reload');
      });
    } else{
      debug('Falta ingresar el detalle.');
      sweet_alert('¡Atención!', 'Debe ingresar por lo menos un egreso', 'warning');
    };
  } else{
    debug('Faltan campos en el maestro.');
    sweet_alert('¡Atención!', 'Debe llenar todos los campos generales.', 'warning');
  };
});
/*** Fin de Agregar Egreso ***/

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

/*** Inicio de Mantenimiento de Rubro ***/
$('#modal-editar-rubro').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var nombre = $boton.data('nombre');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
  $modal.find('#modal-nombre').val(nombre);
});

$('#modal-editar-rubro #modal-guardar').click(function () {
  var $modal = $('#modal-editar-rubro');
  var $id = $('#modal-id').val();
  var $nombre = $('#modal-nombre').val();
  var $token = $('#modal-token').val();

  var ruta = '/tesorera/rubros/' + $id;

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      nombre : $nombre,
      operacion : 'actualizar'
    },
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Se actualizó el Rubro.",
          type: "success",
          closeOnConfirm : true
      }, function(){
          reloadTablaRubros($modal);
      });
    },
    fail : function (data) {
      swal({
          title: "ERROR",
          text: "Ocurrió un error inesperado. Por favor, intente nuevamente en unos minutos.",
          type: "error",
          closeOnConfirm: true
      }, function(){
        console.log('fail');
      });
    },
    error : function (msg) {
      var err_list = '<ul>';
      $.each( msg.responseJSON, function( i, val ) {
        err_list += '<li>' + val[0] + '</li>';
      });
      err_list += '</ul>';

      $('#modal-error #message').html(err_list);
      $('#modal-error').fadeIn();
    }
  });
});

function reloadTablaRubros (modal_rubro) {
    var ruta = 'rubro/listar/';
    $('#tabla-listar-rubro tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td><a href='#modal-editar-rubro' data-toggle='modal' class='btn bgm-amber m-r-20' data-id=" + data[i].id + " data-nombre="+ data[i].nombre +"><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-listar-rubro tbody').append(fila);
        };
      } else {
        $('#tabla-listar-rubro tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });

    modal_rubro.modal('hide');
}
/*** Fin de Mantenimiento de Rubro ***/
