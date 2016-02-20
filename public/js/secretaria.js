/*****/
$('#form-buscar-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = $('#form-buscar-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $.get(ruta, function (response, state) {
    documento_alumno = response[0].nro_documento;
    nombres_alumno = response[0].nombres;
    apellidos_alumno = response[0].apellidos;

    $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
    $('#form-matricular #nro_documento').val(documento_alumno);

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
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Alumno matriculado. Además fueron agregados sus pagos.",
          type: "success",
          closeOnConfirm: false
      }, function(){
          document.location.reload();
      });
    },
    fail : function (data) {
      swal({
          title: "ERROR",
          text: "Ocurrió un error inesperado. Por favor, intente nuevamente en unos minutos.",
          type: "error",
          closeOnConfirm: false
      }, function(){
          document.location.reload();
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
