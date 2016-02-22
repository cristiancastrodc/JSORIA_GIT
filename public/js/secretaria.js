$('#form-buscar-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = $('#form-buscar-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $.get(ruta, function (response, state) {

    if (response['mensaje']) {
      swal({
            title: "Error",
            text: "Sucedió algo inesperado. El Alumno ya esta matricula en otra institucion.",
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

/*** Agregar deudas de alumno ***/
$('#form-categorias-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = '../categorias/' + $('#form-categorias-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";
  $('#tabla-categorias-alumno tbody').empty();
  $.get(ruta, function (response, state) {
    console.log(response);

    if (response['mensajeno']) {
      swal({
            title: "Error",
            text: "El Alumno NO EXISTE. Crear y matricular al alumno.",
            type: "warning"
        }, function () {
          document.location.reload();
        });
    } else {
      if (response['mensaje']) {
        swal({
              title: "Error",
              text: "El Alumno NO esta matricula.",
              type: "warning"
          }, function () {
            document.location.reload();
          });
      } else {
          documento_alumno = response[0].nro_documento;
          nombres_alumno = response[0].nombres;
          apellidos_alumno = response[0].apellidos;

          $('#nombre-alumno').text(nombres_alumno + ' ' + apellidos_alumno);
          $('#form-categorias-alumno #nro_documento').val(documento_alumno);

          for (var i = 0; i < response[1].length; i++) {
            var $id = response[1][i].id;
            var $monto = response[1][i].monto;
            var $nombre = response[1][i].nombre;

            var fila = "<tr>";
            fila += "<td class='hidden'>" + $id + "</td>";
            fila += "<td>" + $nombre + "</td>";
            fila += "<td class='text-right'>" + $monto + "</td>";
            fila += "<td><div class='fg-line'><input type='text' class='form-control input-sm text-right' placeholder='Factor'></div></td>";
            fila += "<td><p class='text-right total'></p></td>"
            fila += "</tr>";

            $('#tabla-categorias-alumno tbody').append(fila);
          }

          $('.js-toggle').slideDown('fast');
        }
    }
    });    
});

/*** Listar deudas de alumno ***/
$('#form-buscar-deudas-alumno #btn-buscar-alumno').click(function (e) {
  e.preventDefault();

  var ruta = '../lista_deudas/' + $('#form-buscar-deudas-alumno #nro_documento').val();
  var documento_alumno = "";
  var nombres_alumno = "";
  var apellidos_alumno = "";

  $('#tabla-deudas-alumno tbody').empty();
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
      $('#form-deudas-alumno #nro_documento').val(documento_alumno);

      for (var i = 0; i < response[1].length; i++) {
      
        var $id = response[1][i].id;
        var $monto = response[1][i].saldo;
        var $deuda = response[1][i].nombre;

        var fila = "<tr>";
        fila += "<td class='hidden'>" + $id + "</td>";
        fila += "<td>" + $deuda + "</td>";
        fila += "<td class='text-right'>" + $monto + "</td>";
        fila += "<td><div class='fg-line'><input type='text' class='form-control input-sm text-right' placeholder='Descuento'></div></td>";
        fila += "<td><div class='toggle-switch'><input id='ts1' type='checkbox' hidden='hidden'><label for='ts1' class='ts-helper'></label></div></td>";
        
        $('#tabla-deudas-alumno tbody').append(fila);
      }

      $('.js-toggle').slideDown('fast');
    }
  
  });
});