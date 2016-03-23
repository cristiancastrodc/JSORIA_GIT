$('#form-reporte-ingresos #id_institucion').change(function (e) {

  var $detalle_institucion = $('#form-reporte-ingresos #id_detalle_institucion');
  $detalle_institucion.empty();

  var route = '../divisiones/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre_division + "</option>"
      $detalle_institucion.append(opcion);
    };
    $detalle_institucion.selectpicker('refresh');
  });
});

$('#form-reporte-egresos #id_institucion').change(function (e) {

  var $rubro_institucion = $('#form-reporte-egresos #rubro');
  $rubro_institucion.empty();

  var route = '../rubros';

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre + "</option>"
      $rubro_institucion.append(opcion);
    };
    $rubro_institucion.selectpicker('refresh');
  });
});

$('#form-listar_deudores #id_institucion').change(function (e) {

  var $detalle_institucion = $('#form-listar_deudores #id_detalle_institucion');
  $detalle_institucion.empty();

  var route = '../divisiones/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre_division + "</option>"
      $detalle_institucion.append(opcion);
    };
    $detalle_institucion.selectpicker('refresh');
  });
});
$('#form-listar_deudores #id_detalle_institucion').change(function (e) {

  var $grado_institucion = $('#form-listar_deudores #grado');
  $grado_institucion.empty();

  var route = '../grados/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre_grado + "</option>"
      $grado_institucion.append(opcion);
    };
    $grado_institucion.selectpicker('refresh');
  });
});

$(document).ready(function() {
    $('#form-reporte-ingresos').on('submit', function(evt) {
          evt.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
    });
});

$(document).ready(function() {
    $('#form-reporte-egresos').on('submit', function(evt) {
          evt.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
    });
});

$(document).ready(function() {
    $('#form-otros-reportes').on('submit', function(evt) {
          evt.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
    });
});

$(document).ready(function() {
    $('#form-listar_deudores').on('submit', function(evt) {
          evt.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
    });
});

$(document).ready(function () {
   $("#checkbox_todas_instituciones").click(function () {
      $('#id_institucion').attr("disabled", $(this).is(":checked"));
   });
});

$(document).ready(function () {
   $("#checkbox_todos_rubros").click(function () {
      $('#rubro').attr("disabled", $(this).is(":checked"));
   });
});

$(document).ready(function () {
   $("#todas_instituciones").click(function () {
      $('#id_institucion').attr("disabled", $(this).is(":checked"));
      $('#id_detalle_institucion').attr("disabled", $(this).is(":checked"));
   });
});

$(document).ready(function () {
   $("#todas_categorias").click(function () {
      $('#id_categoria').attr("disabled", $(this).is(":checked"));
   });
});

