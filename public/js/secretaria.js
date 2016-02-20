$('#form-buscar-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = $('#form-buscar-alumno #dni').val();
  var dni_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $.get(ruta, function (response, state) {
    dni_alumno = response[0].dni;
    nombres_alumno = response[0].nombres;
    apellidos_alumno = response[0].apellidos;

    $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
    $('#form-matricular #dni').val(dni_alumno);

    $('.js-toggle').slideDown('fast');
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
  $(this).append(' <img src="img/ajax-loader.gif" alt="Cargando..." />')

  var ruta = '../alumnos/' + $('#form-matricular #dni').val();
  var $token = $('#form-matricular #token').val();
  var $id_detalle_institucion = $('#form-matricular #id_detalle_institucion').val();

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      estado : '1',
      id_detalle_institucion : $id_detalle_institucion
    }
  })
  .done(function (data) {
    swal({
        title: "Éxito",
        text: "Alumno matriculado. Además fueron agregados sus pagos.",
        type: "success",
        closeOnConfirm: false
    }, function(){
        document.location.reload();
    });
  })
  .fail(function (data) {
    swal({
        title: "ERROR",
        text: "Ocurrió un error inesperado. Por favor, intente nuevamente en unos minutos.",
        type: "error",
        closeOnConfirm: false
    }, function(){
        document.location.reload();
    });
  });
});