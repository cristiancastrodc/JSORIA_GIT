/*** Inicio de Registro e Impresión de cobro múltiple ***/
$('#comprobante.btn-cobro-multiple').click(function(e) {
  e.preventDefault();
  debug('Presionado Boton Comprobante de Otros Conceptos.');

  var $tabla_body = $('#tabla-cobros-multiples > tbody');
  var monto_total = 0;

  var $radio = $tabla_body.find('input[type=radio]:checked');

  if ($radio.length == 1) {
    var $dni = $('#dni_cliente').val();
    var $nombre = $('#nombre_cliente').val();

    if ($dni != '' && $nombre != '') {
      var $fila = $radio.closest('tr');
      var $id = $fila.find('.id').html();

      var texto = 'El monto a cancelar es S/ ' + $fila.find('.monto').html() + '. ¿Desea continuar?';
      swal({
        title : 'Confirmar Compra',
        text : texto,
        type : 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: "Cancelar",
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
            tipo: 'comprobante'
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
                document.location.reload();
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
      sweet_alert('¡ATENCIÓN!', 'El DNI y el Nombre no pueden estar vacíos.', 'warning');
    }
  } else{
    sweet_alert('¡ATENCIÓN!', 'Debe seleccionar un concepto.', 'warning');
  };
});

$('#boleta.btn-cobro-multiple').click(function(e) {
  e.preventDefault();
  debug('Presionado Boton Boleta de Otros Conceptos.');

  var $tabla_body = $('#tabla-cobros-multiples > tbody');
  var monto_total = 0;

  var $radio = $tabla_body.find('input[type=radio]:checked');

  if ($radio.length == 1) {
    var $dni = $('#dni_cliente').val();
    var $nombre = $('#nombre_cliente').val();
    var $fila = $radio.closest('tr');
    var $destino = $fila.find('.destino').html();

    if ($destino != '1') {
      if ($dni != '' && $nombre != '') {
        var $id = $fila.find('.id').html();

        var texto = 'El monto a cancelar es S/ ' + $fila.find('.monto').html() + '. ¿Desea continuar?';
        swal({
          title : 'Confirmar Compra',
          text : texto,
          type : 'warning',
          showCancelButton: true,
          confirmButtonText: 'Continuar',
          cancelButtonText: "Cancelar",
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
              tipo: 'boleta'
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
                  document.location.reload();
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
        sweet_alert('¡ATENCIÓN!', 'El DNI y el Nombre no pueden estar vacíos.', 'warning');
      }
    } else{
      sweet_alert('¡ATENCIÓN!', 'Esta operación no admite la emisión de boleta. Intente con otro tipo de comprobante.', 'warning');
    };
  } else{
    sweet_alert('¡ATENCIÓN!', 'Debe seleccionar un concepto.', 'warning');
  };
});

$('#factura.btn-cobro-multiple').click(function(e) {
  e.preventDefault();
  debug('Presionado Boton Factura de Otros Conceptos.');

  var $tabla_body = $('#tabla-cobros-multiples > tbody');
  var monto_total = 0;

  var $radio = $tabla_body.find('input[type=radio]:checked');

  if ($radio.length == 1) {
    var $ruc = $('#ruc_cliente').val();
    var $razon_social = $('#razon_social').val();
    var $direccion = $('#direccion').val();

    var $fila = $radio.closest('tr');
    var $destino = $fila.find('.destino').html();

    if ($destino != '1') {
      if ($ruc != '' && $razon_social != '') {
        var $id = $fila.find('.id').html();

        var texto = 'El monto a cancelar es S/ ' + $fila.find('.monto').html() + '. ¿Desea continuar?';
        swal({
          title : 'Confirmar Compra',
          text : texto,
          type : 'warning',
          showCancelButton: true,
          confirmButtonText: 'Continuar',
          cancelButtonText: "Cancelar",
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
              ruc_cliente : $ruc,
              razon_social : $razon_social,
              direccion : $direccion,
              tipo: 'factura'
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
                  document.location.reload();
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
        sweet_alert('¡ATENCIÓN!', 'El RUC y la Razón Social no pueden estar vacíos.', 'warning');
      }
    } else{
      sweet_alert('¡ATENCIÓN!', 'Esta operación no admite la emisión de factura. Intente con otro tipo de comprobante.', 'warning');
    };
  } else{
    sweet_alert('¡ATENCIÓN!', 'Debe seleccionar un concepto.', 'warning');
  };
});
/*** Fin de Registro e Impresión de cobro múltiple ***/

/*** Inicio de autorización de retiro ***/
$('#modal-confirmar-autorizacion').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
});

$('#modal-confirmar-autorizacion #modal-guardar').click(function () {
  var $modal = $('#modal-confirmar-autorizacion');
  var $id = $('#modal-id').val();
  var $pass = $('#contrasenia').val();
  var $token = $('#modal-token').val();
  debug($id);
  debug($pass);

  var ruta = '/cajera/retiro/confirmacion';

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'POST',
    dataType : 'json',
    data : {
      pass : $pass,
      retiro : $id,
    },
    beforeSend : function () {
      debug('Antes de enviar');
      $('#ajax-loader').fadeIn('slow');
    },
    success : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        debug(data, false);
        if (data.tipo == 'error') {
           sweet_alert('¡Error!', data.mensaje, 'error');
        } else {
          sweet_alert('¡Éxito!', data.mensaje, 'success', 'reload');
        }
      });
    },
    fail : function (data) {
      $('#ajax-loader').fadeOut('slow', function () {
        debug('Error en el proceso de realizar retiro.');
        debug(data, false);
        sweet_alert('Ocurrió algo inesperado', 'inténtelo de nuevo más tarde.', 'warning', 'reload');
      });
    }
  });
});
/*** Fin de autorización de retiro ***/
