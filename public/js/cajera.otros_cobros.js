$('#tipo_comprobante').change(function(event) {
  if ($(this).val() == 'factura') {
    $('#datos-factura').slideDown();
  } else {
    $('#datos-factura').slideUp();
  }
  var $tabla_body = $('#tabla-cobros-multiples > tbody');
  var $radio = $tabla_body.find('input[type=radio]:checked');
  var $fila = $radio.closest('tr');
  var $id_institucion = $fila.find('.id_institucion').html();
  var ruta = '/cajera/comprobante/' + $id_institucion + '/' + $(this).val() + '/true';
  var $series = $('#serie_comprobante');
  $series.empty();
  $.get(ruta, function(data) {
    for (var i = 0; i < data.length; i++) {
      var opcion = "<option>" + data[i].serie + "</option>";
      $series.append(opcion);
    };
    $series.selectpicker('refresh');
  });
});
$('#serie_comprobante').change(function (e) {
  var $tabla_body = $('#tabla-cobros-multiples > tbody');
  var $radio = $tabla_body.find('input[type=radio]:checked');
  var $fila = $radio.closest('tr');
  var $id_institucion = $fila.find('.id_institucion').html();
  var $tipo_comprobante = $('#tipo_comprobante').val();
  var $serie = $('#serie_comprobante').val();
  var ruta = '/cajera/comprobante/numero/' + $id_institucion + '/' + $tipo_comprobante + '/' + $serie;
  $.get(ruta, function (response, state) {
    $('#numero_comprobante').val(response.numero_comprobante);
  });
});
$('#btn-cobro-multiple').click(function(e) {
  e.preventDefault();
  var $tabla_body = $('#tabla-cobros-multiples > tbody');
  var monto_total = 0;
  var $radio = $tabla_body.find('input[type=radio]:checked');
  if ($radio.length == 1) {
    var $fila = $radio.closest('tr');
    var $id_institucion = $fila.find('.id_institucion').html();
    var $tipo_comprobante = $('#tipo_comprobante').val();
    var $dni = $('#dni_cliente').val();
    var $nombre = $('#nombre_cliente').val();
    var $ruc = $('#ruc_cliente').val();
    var $razon_social = $('#razon_social').val();
    if (($tipo_comprobante != 'factura' && $dni != '' && $nombre != '') || ($tipo_comprobante == 'factura' && $ruc != '' && $razon_social != '')) {
      var $fila = $radio.closest('tr');
      var $id = $fila.find('.id').html();
      var texto = 'El monto a cancelar es S/ ' + $fila.find('.monto').html() + '. ¿Desea continuar?';
      swal({
        title : 'Confirmar Compra',
        text : texto,
        type : 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        confirmButtonClass: 'main-color',
        cancelButtonText: 'Cancelar',
      }, function () {
        var ruta = '/cajera/cobro/multiple/guardar';
        var $token = $('#_token').val();
        $.ajax({
          url: ruta,
          headers: {'X-CSRF-TOKEN' : $token},
          type: 'POST',
          dataType: 'json',
          data: {
            id_categoria : $id,
            dni : $dni,
            nombre : $nombre,
            tipo: $tipo_comprobante,
            serie: $('#serie_comprobante').val(),
            numero: $('#numero_comprobante').val(),
            ruc: $('#ruc_cliente').val(),
            razon_social: $('#razon_social').val(),
            direccion: $('#direccion').val(),
            id_institucion: $id_institucion,
          },
          beforeSend : function () {
            debug('Antes de enviar');
            $('#ajax-loader').fadeIn('slow');
          },
          success : function (data) {
            $('#ajax-loader').fadeOut('slow', function () {
              swal({
                title : '¡Éxito!',
                text :  data.mensaje,
                type : 'success',
              }, function () {
                var data = {
                  id_categoria : $id,
                  dni : $dni,
                  nombre : $nombre,
                  ruc: $('#ruc_cliente').val(),
                  razon_social: $('#razon_social').val(),
                  direccion: $('#direccion').val(),
                  tipo: $tipo_comprobante,
                };
                post('/cajera/generar/ingreso/imprimir_multiple', data);
              });
            });
          },
          error : function (data) {
            $('#ajax-loader').fadeOut('slow', function () {
              var error = '203';
              sweet_alert('Ocurrió algo inesperado', 'No se puede procesar la petición. Error: ' + error);
            });
          }
        });
      });
    } else {
      if ($tipo_comprobante == 'factura') {
        sweet_alert('¡ATENCIÓN!', 'RUC y Razón social no pueden estar vacíos.', 'warning');
      } else {
        sweet_alert('¡ATENCIÓN!', 'El DNI y el Nombre no pueden estar vacíos.', 'warning');
      }
    }
  } else{
    sweet_alert('¡ATENCIÓN!', 'Debe seleccionar un concepto.', 'warning');
  };
})
$('#btn-inicializar').click(function(e) {
  $("input[name='rb-cobro-multiple']").prop('checked', false)
  $('#dni_cliente').val('')
  $('#nombre_cliente').val('')
  $('#tipo_comprobante').val('')
  $('#serie_comprobante').val('')
  $('#numero_comprobante').val('')
  $('#ruc_cliente').val('')
  $('#razon_social').val('')
  $('#direccion').val('')
  $('.selectpicker').selectpicker('refresh')
})
