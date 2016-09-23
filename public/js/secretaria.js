$('#form-buscar-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = $('#form-buscar-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $('#ajax-loader').fadeIn('fast', function () {
    $.get(ruta, function (response, state) {

      if (response['mensaje']) {
        swal({
              title: "Error",
              text: response['mensaje'],
              type: "warning"
          }, function () {
            document.location.reload();
          });
      }else{
        documento_alumno = response.nro_documento;
        nombres_alumno = response.nombres;
        apellidos_alumno = response.apellidos;

        $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
        $('#form-matricular #nro_documento').val(documento_alumno);

        $('.js-toggle').slideDown('fast');
      }
    })
    .always(function () {
      $('#ajax-loader').fadeOut('slow');
    });
  });


});

$('#form-matricular #id_institucion').change(function (event) {

  var $detalle_institucion = $('#form-matricular #id_detalle_institucion');
  $detalle_institucion.empty();

  var route = 'divisiones/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      if (response[i].nombre_division != 'Todo') {
        var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre_division + "</option>"
        $detalle_institucion.append(opcion);
      }
    };
    $detalle_institucion.selectpicker('refresh');
  });
});

$('#form-matricular #btn-matricular').click(function (e) {
  e.preventDefault();
  $(this).html('Cargando...');

  var ruta = '../alumnos/' + $('#form-matricular #nro_documento').val();
  var $token = $('#form-matricular #token').val();
  var $detalle_institucion = $('#form-matricular #id_detalle_institucion').val();
  var $grado = $('#form-matricular #id_grado').val();
  var $matricula = $('#form-matricular #id_tipo_matricula').val();

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      id_detalle_institucion : $detalle_institucion,
      id_grado : $grado,
      id_matricula : $matricula,
    },
    beforeSend : function () {
          debug('Antes de enviar');
          $('#ajax-loader').fadeIn('slow');
        },
    success : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        swal({
            title: "Éxito",
            text: "Alumno matriculado. Además fueron agregados sus pagos.",
            type: "success",
            closeOnConfirm: false
        }, function(){
            document.location.reload();
          });
      });
    },
    fail : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        swal({
          title: "ERROR",
          text: "Ocurrió un error inesperado. Por favor, intente nuevamente en unos minutos.",
          type: "error",
          closeOnConfirm: false
        }, function(){
            document.location.reload();
          });
      });

    }
  })
});

$('#form-matricular #id_detalle_institucion').change(function (event) {
  var $detalle_grado = $('#form-matricular #id_grado');
  $detalle_grado.empty();

  var route = 'grados/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
        var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre_grado + "</option>"
        $detalle_grado.append(opcion);
    };
    $detalle_grado.selectpicker('refresh');
  });

  var $matricula = $('#form-matricular #id_tipo_matricula');
  $matricula.empty();

  var route = 'matriculas/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
        var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre + "</option>"
        $matricula.append(opcion);
    };
    $matricula.selectpicker('refresh');
  });
});

/*** Agregar deudas de alumno ***/
$('#form-categorias-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = '/secretaria/alumno/categorias/' + $('#form-categorias-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";
  $('#tabla-categorias-alumno tbody').empty();
  $('#ajax-loader').fadeIn('fast', function () {
    $.get(ruta, function (response, state) {
      if (response['mensajeno']) {
        swal({
              title: "Error",
              text: "El Alumno NO EXISTE. Primero debe crear y matricular al alumno.",
              type: "warning"
          });
      } else {
        if (response['mensaje']) {
          swal({
                title: "Error",
                text: "El Alumno NO esta matriculado.",
                type: "warning"
            });
        } else {
            documento_alumno = response[0].nro_documento;
            nombres_alumno = response[0].nombres;
            apellidos_alumno = response[0].apellidos;

            $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
            $('#form-agregar-deuda-alumno #nro_documento').val(documento_alumno);

            for (var i = 0; i < response[1].length; i++) {
              var $id = response[1][i].id;
              var $monto = response[1][i].monto;
              var $nombre = response[1][i].nombre;

              var fila = "<tr class=" + $id + ">";
              fila += "<td class='hidden id-categoria'>" + $id + "</td>";
              fila += "<td>" + $nombre + "</td>";
              fila += "<td class='text-right monto'>" + $monto + "</td>";
              fila += "<td><div class='fg-line'><input type='text' class='form-control input-sm text-right deuda-factor' value='0' onkeyup='calcularImporte(" + $id + ", this.value)'></div></td>";
              fila += "<td><p class='text-right total'></p></td>";
              fila += "</tr>";

              $('#tabla-categorias-alumno tbody').append(fila);
            }

            $('.js-toggle').slideDown('fast');
        }
      }
    })
    .always(function () {
      $('#ajax-loader').fadeOut('slow');
    });
  });
});

function calcularImporte (id, value) {
  var sel = '#tabla-categorias-alumno tr.' + id;
  if (value != "") {
    value = parseFloat(value);
    var unitario = parseFloat($(sel).find('.monto').html());
    var importe = value * unitario;
    $(sel).find('.total').html(importe);
  } else {
    $(sel).find('.total').html('0');
  }
  debug(importe);
};


/*** Listar deudas de alumno ***/
$('#form-buscar-deudas-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = '../lista_deudas/' + $('#form-buscar-deudas-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $('#tabla-deudas-alumno tbody').empty();

  $('#ajax-loader').fadeIn('fast', function () {
    $.get(ruta, function (response, state) {
      if (response['mensaje']) {
        swal({
              title: "Error",
              text: "El Alumno NO EXISTE. Crear y matricular al alumno.",
              type: "warning"
          }, function () {
            document.location.reload();
          });
      } else {

        documento_alumno = response[0].nro_documento;
        nombres_alumno = response[0].nombres;
        apellidos_alumno = response[0].apellidos;

        $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
        $('#form-lista-deudas-alumno #nro_documento').val(documento_alumno);

        for (var i = 0; i < response[1].length; i++) {

          var $id = response[1][i].id;
          var $monto = response[1][i].saldo;
          var $deuda = response[1][i].nombre;


          var id_cb = "ts" + i;
          var fila = "<tr>";

          fila += "<td class='hidden id-deuda'>" + $id + "</td>";
          fila += "<td>" + $deuda + "</td>";
          fila += "<td class='text-right'>" + $monto + "</td>";
          fila += "<td><div class='fg-line'><input type='text' class='form-control input-sm text-right descuento' placeholder='Descuento'></div></td>";
          fila += "<td><div class='toggle-switch'><input id='" + id_cb + "' type='checkbox' hidden='hidden'><label for='" + id_cb + "' class='ts-helper'></label></div></td>";

          $('#tabla-deudas-alumno tbody').append(fila);
        }

        $('.js-toggle').slideDown('fast');
      }

    })
    .always(function () {
      $('#ajax-loader').fadeOut('slow');
    });
  });


});

/*** Listar deudas de actividades de alumno ***/
$('#form-buscar-actividades-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = '../lista_actividades/' + $('#form-buscar-actividades-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $('#tabla-actividades-listar-alumno tbody').empty();
  $('#ajax-loader').fadeIn('fast', function () {
    $.get(ruta, function (response, state) {
      if (response['mensaje']) {
        swal({
              title: "Error",
              text: response['mensaje'],
              type: "warning"
          }, function () {
            document.location.reload();
          });
      } else {

        documento_alumno = response[0].nro_documento;
        nombres_alumno = response[0].nombres;
        apellidos_alumno = response[0].apellidos;

        $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
        $('#tabla-actividades-listar-alumno #nro_documento').val(documento_alumno);

        for (var i = 0; i < response[1].length; i++) {

          var $id = response[1][i].id;
          var $monto = response[1][i].saldo - response[1][i].descuento ;
          var $deuda = response[1][i].nombre;

          var fila = "<tr>";
          var id_cb = "ts" + i;
          fila += "<td class='hidden id-categoria'>" + $id + "</td>";
          fila += "<td>" + $deuda + "</td>";
          fila += "<td class='text-right'>" + $monto + "</td>";
          fila += "<td><div class='toggle-switch'><input id='" + id_cb + "' type='checkbox' hidden='hidden' class='check'><label for='" + id_cb + "' class='ts-helper'></label></div></td>";

          $('#tabla-actividades-listar-alumno tbody').append(fila);
        }

        $('.js-toggle').slideDown('fast');
      }
    })
    .always(function () {
      $('#ajax-loader').fadeOut('slow');
    });
  });
});

/*** Amortizar deudas de un alumno ***/
$('#form-amortizar-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = '../amortizar_deudas/' + $('#form-amortizar-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $('#tabla-deudasAmortizacion-alumno tbody').empty();
  $('#ajax-loader').fadeIn('fast', function () {
    $.get(ruta, function (response, state) {
      if (response['mensaje']) {
        swal({
              title: "Error",
              text: response['mensaje'],
              type: "warning"
          }, function () {
            document.location.reload();
          });
      } else {

        documento_alumno = response[0].nro_documento;
        nombres_alumno = response[0].nombres;
        apellidos_alumno = response[0].apellidos;

        $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
        $('#tabla-deudasAmortizacion-alumno #nro_documento').val(documento_alumno);

        for (var i = 0; i < response[1].length; i++) {

          var $id = response[1][i].id;
          var $monto = response[1][i].saldo - response[1][i].descuento;
          var $deuda = response[1][i].nombre;

          var fila = "<tr>";
          fila += "<td class='hidden'>" + $id + "</td>";
          fila += "<td>" + $deuda + "</td>";
          fila += "<td class='text-right'>" + $monto + "</td>";
          fila += "<td><a href='#modal-crear-amortizacion' data-toggle='modal' class='btn third-color m-r-20' data-id='" + $id + "' data-deuda='" + $deuda + "' data-saldo='" + $monto + "'><i class='zmdi zmdi-dns'></i> </a></td>";
          //fila += "<td><button class='btn bgm-lightgreen waves-effect'>Amortizar</button></td>";

          $('#tabla-deudasAmortizacion-alumno tbody').append(fila);
        }

        $('.js-toggle').slideDown('fast');
      }
    })
    .always(function () {
      $('#ajax-loader').fadeOut('slow');
    });
  });
});

/*** Inicio de Agregar Deuda a Alumno ***/
$('#btn-agregar-deuda').click(function(e) {
  e.preventDefault();
  debug('Presionado boton agregar deuda a alumno.');

  var $nro_documento = $('#form-agregar-deuda-alumno #nro_documento').val();

  var $filas = $('#tabla-categorias-alumno > tbody > tr');

  var deudas = [];
  $filas.each(function(index, el) {
    var $factor = $(this).find('.deuda-factor').val();

    if ($factor != "" && $factor != "0") {
      var $id_categoria = $(this).find('.id-categoria').html();
      var deuda = {
        "id_categoria" : $id_categoria,
        "factor" : $factor,
      };
      deudas.push(deuda);
    };
  });

  if (deudas.length > 0) {
    var ruta = '/secretaria/alumno/deudas/crear';
    var $token = $('#token').val();
    $.ajax({
      headers : { 'X-CSRF-TOKEN' : $token },
      url: ruta,
      type: 'POST',
      dataType: 'json',
      data : {
        nro_documento : $nro_documento,
        deudas : deudas,
      },
      beforeSend: function () {
        debug('Antes de enviar');
        $('#ajax-loader').fadeIn('slow');
      },
      success : function (data) {
        $('#ajax-loader').fadeOut('slow', function() {
          debug(data.mensaje);
          sweet_alert('¡Éxito!', data.mensaje, 'success', 'reload');
        });
      },
      fail : function (data) {
        $('#ajax-loader').fadeOut('slow', function() {
          debug('Error al agregar deuda.');
          debug(data, false);
          sweet_alert('Ocurrió algo inesperado', 'Hubo un error al momento de agregar la deuda, inténtelo de nuevo más tarde.', 'warning', 'reload');
        });
      }
    });
  } else{
    sweet_alert('¡Atención!', 'Debe ingresar por lo menos un factor', 'warning');
  };
});
/*** Fin de Agregar Deuda a Alumno ***/

/*** Inicio de Cancelar Deuda de Actividad a un Alumno ***/
$('#btn-cancelar-deuda-actividad').click(function(e) {
  e.preventDefault();
  debug('Presionado boton cancelar deuda actividad a alumno.');

  var $nro_documento = $('#form-lista-deudas-alumno #nro_documento').val();

  var $filas = $('#tabla-actividades-listar-alumno > tbody > tr');

  var deudasCanceladas = [];

  $filas.each(function(index, el) {
    var $seleccionado = $(this).find('[type=checkbox]').is(':checked');

    if ($seleccionado) {
      var $id_deuda = $(this).find('.id-categoria').html();
      var deuda = {
        "id_deuda" : $id_deuda,
      };
      deudasCanceladas.push(deuda);
    };

  });
  debug(deudasCanceladas, false);

  if (deudasCanceladas.length > 0) {
    var ruta = '/secretaria/alumno/deudas/eliminar_actividad';
    var $token = $('#token').val();
    $.ajax({
      headers : { 'X-CSRF-TOKEN' : $token },
      url: ruta,
      type: 'POST',
      dataType: 'json',
      data : {
        deudasCanceladas : deudasCanceladas,
      },
      beforeSend : function () {
          debug('Antes de enviar');
          $('#ajax-loader').fadeIn('slow');
        },
      success : function (data) {
        $('#ajax-loader').fadeOut('slow', function () {
          debug(data.mensaje);
          sweet_alert('¡Éxito!', data.mensaje, 'success', 'reload');
        });

      },
      fail : function (data) {
        $('#ajax-loader').fadeOut('slow', function () {
          debug('Error en la eliminacion de la actividad.');
          debug(data, false);
          sweet_alert('Ocurrió algo inesperado', 'Hubo un error en la eliminacion de la actividad, inténtelo de nuevo más tarde.', 'warning', 'reload');
        });
      }
    });
  } else{
    sweet_alert('¡Atención!', 'Debe seleccionar por lo menos una actividad', 'warning');
  };

});
/*** Fin de Cancelar Deuda de Actividad a un Alumno ***/

/*** Inicio descuento deudas alumno ***/
$('#btn-autorizar-descuento').click(function(e) {
  e.preventDefault();
  debug('Presionado boton decontar deuda a alumno.');

  var $nro_documento = $('#form-lista-deudas-alumno #nro_documento').val();
  var $resolucion = $('#form-autorizacion-descuento #rd').val();
  debug($resolucion);
  var $filas = $('#tabla-deudas-alumno > tbody > tr');

  var deudas = [];

  $filas.each(function(index, el) {
    var $seleccionado = $(this).find('[type=checkbox]').is(':checked');
    var $monto = $(this).find('.descuento').val();
    if ($seleccionado) {
      var $id_deuda = $(this).find('.id-deuda').html();
      var deuda = {
        "id_deuda" : $id_deuda,
        "monto" : 0,
        "operacion" : 'eliminar',
      };
    deudas.push(deuda);
    }else if($monto != "" && $monto != "0") {
      var $id_deuda = $(this).find('.id-deuda').html();
      var deuda = {
        "id_deuda" : $id_deuda,
        "monto" : $monto,
        "operacion" : 'descontar',
      };
    deudas.push(deuda);
    };
    });

  if (deudas.length > 0) {
    var ruta = '/secretaria/alumno/deudas/eliminar_descontar_deuda';
    var $token = $('#token').val();
    $.ajax({
      headers : { 'X-CSRF-TOKEN' : $token },
      url: ruta,
      type: 'POST',
      dataType: 'json',
      data : {
        deudas : deudas,
        resolucion: $resolucion,
        nro_documento: $nro_documento,
      },
      beforeSend : function () {
          debug('Antes de enviar');
          $('#ajax-loader').fadeIn('slow');
        },
      success : function (data) {
        $('#ajax-loader').fadeOut('slow', function () {
          debug(data, false);
          if (data.tipo == 'error') {
             sweet_alert('¡Error!', data.mensaje, 'error', 'reload');
          } else {
          sweet_alert('¡Éxito!', data.mensaje, 'success', 'reload');
          }
        });

      },
      fail : function (data) {
        $('#ajax-loader').fadeOut('slow', function () {
          debug('Error en el proceso de elimar y/o descontar de la deuda.');
          debug(data, false);
          sweet_alert('Ocurrió algo inesperado', 'Hubo un error en el proceso de elimar y/o descontar de la deuda, inténtelo de nuevo más tarde.', 'warning', 'reload');
        });
      }
    });
  };
});
/*** fin descuento deudas alumno ***/
/*** Modal Amortizacion***/
$('#modal-crear-amortizacion').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var deuda = $boton.data('deuda');
  var saldo = $boton.data('saldo');
  var monto = $boton.data('monto');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
  $modal.find('#modal-deuda').html(deuda);
  $modal.find('#modal-saldo').html(saldo);
});

$('#modal-crear-amortizacion #modal-guardar').click(function () {
  var $modal = $('#modal-crear-amortizacion');
  var $id = $('#modal-id').val();
  var $monto = $('#modal-monto').val();
  var $token = $('#modal-token').val();

  var ruta = '/secretaria/alumno/amortizarDeuda';

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'POST',
    dataType : 'json',
    data : {
      id_deuda : $id,
      monto : $monto,
    },
    beforeSend : function () {
      debug('Antes de enviar');
      $('#ajax-loader').fadeIn('slow');
    },
    success : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        swal({
          title: "Éxito",
          text: data.mensaje,
          type: "success",
          closeOnConfirm : true
        }, function(){
            document.location.reload();
            //reloadTablaActividades($modal);
        });
      });

    },
    error : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        debug(data, false);swal({
          title: "ERROR",
          text: "Ocurrió un error inesperado. Por favor, intente nuevamente en unos minutos.",
          type: "error",
          closeOnConfirm: true
        }, function(){
          console.log('fail');
        });
      });

    },
  });

  /*$.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'POST',
    dataType : 'json',
    data : {
      id: $id,
      nombre : $nombre,
      saldo : $saldo,
      monto : $monto,
    },
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Se creó la amortizacion.",
          type: "success",
          closeOnConfirm : true
      },
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
  });*/
});



