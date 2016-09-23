/*** Inicio de Mantenimiento de Rubro ***/
$('#modal-editar-rubro').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var nombre = $boton.data('nombre');

  var $modal = $(this);
  $modal.find('#id_rubro').val(id);
  $modal.find('#nombre').val(nombre);
});


$('#btn-guardar-rubro').click(function () {
  debug('Boton editar rubro presionado.');
  var $id = $('#id_rubro').val();
  var ruta = '/tesorera/administrar/rubros/actualizar/' + $id;
  var $token = $('#modal-token').val();
  var $nombre = $('#nombre').val();
  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type: 'GET',
    dataType : 'json',
    data : {
      nombre : $nombre,
    },
    beforeSend : function () {
      debug('Antes de enviar');
      $('#ajax-loader').fadeIn('slow');
    },
  })
  .done(function(data) {
    $('#ajax-loader').fadeOut('slow', function () {
      swal({
          title: "Éxito",
          text: data.mensaje,
          type: "success",
          closeOnConfirm : true
      }, function(){
          document.location.reload();
      });
    });
  })
  .fail(function(data) {
    $('#ajax-loader').fadeOut('slow', function () {
      swal({
        title: "ERROR",
        text: "Ocurrió un error inesperado. Por favor, intente nuevamente en unos minutos.",
        type: "error",
        closeOnConfirm: true
      }, function(){
        debug('Hubo un error en la petición AJAX.');
      });
    });
  });
});
/*** Fin de Mantenimiento de Rubro ***/
