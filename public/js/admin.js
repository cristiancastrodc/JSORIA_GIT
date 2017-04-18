/*** Retiros ***/
$('#form-ingresos-cajera #btn-ingresos-cajera').click(function(e) {
  e.preventDefault();
  var $id_cajera = $('#id_cajera').val();
  if ($id_cajera != '') {
    $('#tabla-ingresos-cajera tbody').empty();
    $('#id_cajera_retirar').val($id_cajera);
    var ruta = '/admin/retirar/' + $('#id_cajera').val() + "";

    $('#ajax-loader').fadeIn('fast', function () {
      $.get(ruta, function (response, state) {
        if (response.length > 0) {
          var monto_no_retirado = 0;
          var monto_por_retirar = 0;
          for (var i = 0; i < response.length; i++) {
            var monto = response[i].saldo - response[i].descuento;
            // Sumar los montos al agregado
            if (response[i].estado_retiro == 0) {
              monto_no_retirado += monto;
            } else if (response[i].estado_retiro == 1) {
              monto_por_retirar += monto;
            }
            var fila = "<tr>";
            fila += "<td class='hidden id_cobro'>" + response[i].id + "</td>";
            fila += "<td>" + response[i].fecha_hora_ingreso + "</td>";
            fila += "<td>" + response[i].documento + "</td>";
            fila += "<td>" + response[i].nombre + "</td>";
            if (response[i].estado_retiro == 0) {
              fila += "<td><span class='p-5'>Sin retirar</span></td>";
            } else if (response[i].estado_retiro == 1) {
              fila += "<td><span class='bgm-orange c-white p-5'>Por retirar</span></td>";
            }
            fila += "<td class='text-right'>" + monto.toFixed(2) + "</td>";
            fila += "</tr>";
            $('#tabla-ingresos-cajera tbody').append(fila);
          }
          // Desactivar botón de Retirar si no hay montos "Sin retirar"
          if (monto_no_retirado == 0) {
            $('#btn-retirar-ingresos').prop('disabled', true)
          }
          else {
            $('#btn-retirar-ingresos').prop('disabled', false)
          }
          $('#cobros-no-retirados').html(monto_no_retirado.toFixed(2));
          $('#cobros-por-retirar').html(monto_por_retirar.toFixed(2));
          $('#form-detalle-retiro').removeClass('hidden')
        } else {
          swal({
            title : 'No existen cobros pendientes de retiro.',
            type : 'info',
            confirmButtonText : 'Aceptar',
          })
          $('#form-detalle-retiro').addClass('hidden')
        }
      })
      .always(function () {
        $('#ajax-loader').fadeOut('slow');
      });
    });
  } else {
    sweet_alert('¡Atención!', 'Debe de seleccionar una cajera.', 'warning');
  }
});

$('#btn-retirar-ingresos').click(function (e) {
  e.preventDefault();
  var ids_cobros = [];
  $('#tabla-ingresos-cajera tbody > tr').each(function(index, el) {
    ids_cobros.push($(this).find('.id_cobro').html());
  });
  var ruta = '/admin/retirar/actualizar';
  var $token = $('#_token').val();
  var $id_cajera_retirar = $('#id_cajera_retirar').val();
  $.ajax({
    url: ruta,
    type: 'POST',
    dataType: 'json',
    headers : { 'X-CSRF-TOKEN' : $token },
    data : {
      ids_cobros : ids_cobros,
      id_cajera : $id_cajera_retirar
    },
    beforeSend : function () {
      $('#ajax-loader').fadeIn('slow');
    },
    success : function (data) {
      if (data.resultado == 'true') {
        var ruta = '/admin/retiro/resumen/' + data.id_retiro
        window.location = ruta;
      } else {
        swal({
          title: 'Error.',
          text: 'No se pudo crear el Retiro. Mensaje: ' + data.mensaje,
          type: 'error'
        }, function () {
          window.location.reload();
        })
      }
    },
    fail : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        debug(data, false);
        swal({
          title: 'Error.',
          text: 'No se pudo crear el Retiro.',
          type: 'error',
        })
      })
    }
  })
});
/***************/

/*** Funciones adicionales ***/
function notify(message, from, align, type, animIn, animOut){
  $.growl({
      title : 'ERROR: ',
      message: message,
  },{
    element: 'body',
    type: type,
    allow_dismiss: true,
    placement: {
      from: from,
      align: align
    },
    offset: {
      x: 20,
      y: 85
    },
    spacing: 10,
    z_index: 1031,
    delay: 2500,
    timer: 1000,
    url_target: '_blank',
    mouse_over: false,
    animate: {
      enter: animIn,
      exit: animOut
    },
    icon_type: 'class',
    template: '<div data-growl="container" class="alert" role="alert">' + '<button type="button" class="close" data-growl="dismiss">' + '<span aria-hidden="true">&times;</span>' + '<span class="sr-only">Close</span>' + '</button>' + '<span data-growl="icon"></span>' + '<span data-growl="title"></span>' + '<span data-growl="message"></span>' + '<a href="#" data-growl="url"></a>' + '</div>'
  });
};

/*** Listar Cobros Extraordinarios  ***/
$('#btn-listar-extraordinarios').click(function (e) {
  e.preventDefault();
  listar_extraordinarios();
});

function listar_extraordinarios() {
  $id_institucion = $('#id_institucion_listar').val()
  $id_institucion = $id_institucion == null ? '' : $id_institucion
  var ruta = '/admin/cobro/extraordinario/listar/' + $id_institucion
  $('#tabla-listar-extraordinarios tbody').empty()
  $('#ajax-loader').fadeIn('fast', function () {
    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td>" + data[i].id + "</td>";
            fila += "<td>" + data[i].descripcion_extr + "</td>";
            fila += "<td class='text-right'>" + data[i].saldo.toFixed(2) + "</td>";
            if (data[i].estado_pago == 1) {
              fila += "<td>Cancelado</td>";
              fila += '<td></td>'
            } else {
              fila += "<td>Pendiente</td>";
              fila += "<td><button type='button' class='btn fourth-color btn-eliminar-extraordinario' data-id='" + data[i].id + "'><i class='zmdi zmdi-delete'></i></button></td>";
            }
            fila += "</tr>";
            $('#tabla-listar-extraordinarios tbody').append(fila);
        };
      } else {
        $('#tabla-listar-extraordinarios tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    })
    .always(function () {
      $('#ajax-loader').fadeOut('slow');
    });
  });
}

$('#tabla-listar-extraordinarios').on('click', '.btn-eliminar-extraordinario', function(event) {
  event.preventDefault();
  var $id = $(this).data('id')
  swal({
    title: "¿Realmente desea eliminar el cobro?",
    type: "warning",
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Aceptar',
    confirmButtonClass: 'btn-danger',
  }, function () {
    $.get('/admin/cobros/extraordinarios/eliminar/' + $id, function(data) {
      listar_extraordinarios();
    })
  })
})