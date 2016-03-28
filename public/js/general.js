/*** Inicio de Cambiar contraseña ***/
$('#btn-guardar-contraseña').click(function(e) {
  e.preventDefault();
  debug('Boton Guardar Contraseña presionado.');

  var new_pass = $('#new_password').val();
  var old_pass = $('#old_password').val();
  var ruta = "/perfil/guardar";
  var $token = $('#_token').val();

  $.ajax({
    url : ruta,
    headers : {'X-CSRF-TOKEN': $token},
    type : 'POST',
    dataType : 'json',
    data : {
      new_pass : new_pass,
      old_pass : old_pass
    },
    success : function (data) {
      if (data.tipo == 'exito') {
        swal({
          title : '¡ÉXITO!',
          text : data.mensaje,
          type : 'success'
        }, function () {
          document.location = '/logout';
        });
      } else{
        sweet_alert('ERROR', data.mensaje, 'error');
      };
    },
    error : function (data) {
      sweet_alert('ERROR', data.mensaje, 'error');
    }
  });
});
/*** Fin de Cambiar contraseña ***/
