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

$('#form-reporte-ingresos #id_detalle_institucion').change(function (e) {

  var $categoria_institucion = $('#form-reporte-ingresos #categoria');
  $categoria_institucion.empty();

  var route = '../categorias/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre + "</option>"
      $categoria_institucion.append(opcion);
    };
    $categoria_institucion.selectpicker('refresh');
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