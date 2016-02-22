/*** Actividades ***/
$('#form-crear-actividad #id_institucion').change(function (e) {

  var $detalle_institucion = $('#form-crear-actividad #id_detalle_institucion');
  $detalle_institucion.empty();

  var route = 'divisiones/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      var opcion = "<option value='" + response[i].id + "'>" + response[i].nombre_division + "</option>"
      $detalle_institucion.append(opcion);
    };
    $detalle_institucion.selectpicker('refresh');
  });
});

$('#form-crear-actividad #btn-crear-actividad').click(function (e) {
  e.preventDefault();
  $(this).html('Cargando...');

  var $form = $('#form-crear-actividad');
  var $id_detalle_institucion = $form.find('#id_detalle_institucion').val();
  var $nombre = $form.find('#nombre').val();
  var $monto = $form.find('#monto').val();
  var $token = $('#form-crear-actividad #token').val();

  var XHRs = [];
  var resultado = true;
  var ruta = '/admin/actividades';

  XHRs.push($.ajax({
    url : ruta,
    headers : {'X-CSRF-TOKEN': $token},
    type : 'POST',
    dataType : 'json',
    data : {
      nombre : $nombre,
      monto : $monto,
      id_detalle_institucion : $id_detalle_institucion,
    },
    success : function (data) {
      console.log(data);
    },
    fail : function () {
      resultado = false;
      console.log(resultado);
    }
  }));

  $.when.apply(null, XHRs).then(function () {
    if (resultado) {
      swal({
          title: "Éxito!",
          text: "Se creó la actividad y se agregó la deuda a los alumnos respectivos.",
          type: "success"
      }, function () {
        document.location.reload();
      });
    } else {
      swal({
          title: "Error",
          text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.",
          type: "warning"
      }, function () {
        document.location.reload();
      });
    }
  });
});

$('#form-listar-actividades #id_institucion').change(function (e) {

  var $detalle_institucion = $('#form-listar-actividades #id_detalle_institucion');
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

$('#form-listar-actividades #btn-listar-actividades').click(function (e) {

  e.preventDefault();

  $id_detalle_institucion = $('#form-listar-actividades #id_detalle_institucion').val();

  if ($id_detalle_institucion != "") {
    var ruta = 'actividades/listar/' + $id_detalle_institucion;
    $('#tabla-listar-actividades tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            fila += "<td><a href='#modal-editar-actividad' data-toggle='modal' class='btn bgm-amber m-r-20' data-id='" + data[i].id + "' data-nombre='" + data[i].nombre + "' data-monto='" + data[i].monto + "'><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-listar-actividades tbody').append(fila);
        };
      } else {
        $('#tabla-listar-actividades tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });
  } else {
    swal({
      title : '¡Atención!',
      text : 'Debe seleccionar la institución.',
      type : 'warning'
    });
  }
});

$('#modal-editar-actividad').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var nombre = $boton.data('nombre');
  var monto = $boton.data('monto');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
  $modal.find('#modal-nombre').val(nombre);
  $modal.find('#modal-monto').val(monto);
});

$('#modal-editar-actividad #modal-guardar').click(function () {
  var $modal = $('#modal-editar-actividad');
  var $id = $('#modal-id').val();
  var $nombre = $('#modal-nombre').val();
  var $monto = $('#modal-monto').val();
  var $token = $('#modal-token').val();

  var ruta = '/admin/actividades/' + $id;

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      nombre : $nombre,
      monto : $monto,
      operacion : 'actualizar'
    },
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Se actualizó la actividad.",
          type: "success",
          closeOnConfirm : true
      }, function(){
          reloadTablaActividades($modal);
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
    }
  });
});

function reloadTablaActividades (modal_actividad) {
  $id_detalle_institucion = $('#form-listar-actividades #id_detalle_institucion').val();

  if ($id_detalle_institucion != "") {
    var ruta = 'actividades/listar/' + $id_detalle_institucion;
    $('#tabla-listar-actividades tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            fila += "<td><a href='#modal-editar-actividad' data-toggle='modal' class='btn bgm-amber m-r-20' data-id='" + data[i].id + "' data-nombre='" + data[i].nombre + "' data-monto='" + data[i].monto + "'><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-listar-actividades tbody').append(fila);
        };
      } else {
        $('#tabla-listar-actividades tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });

    modal_actividad.modal('hide');
  } else {
    document.location.reload;
  }
};
/*** Fin Actividades ***/

/*** Matriculas ***/
$('#form-crear-matricula #id_institucion').change(function (e) {

  $('#tabla-crear-matricula tbody').empty();

  var route = 'divisiones/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      if (response[i].nombre_division != 'Todo') {
        var fila = "<tr>";
        fila += "<td class='hidden id-division'>" + response[i].id + "</td>";
        fila += "<td>" + response[i].nombre_division + "</td>";
        fila += "<td><div class='col-sm-12'><div class='fg-line'><input type='text' class='form-control input-sm monto-matricula' placeholder='Monto...'></div></div></td>";
        fila += "</tr>";
        $('#tabla-crear-matricula tbody').append(fila);
      }
    };
  });
});

$('#btn-crear-matricula').click(function (e) {

  e.preventDefault();

  var nroFilas = $('#tabla-crear-matricula tr').length;

  if (nroFilas > 1) {

    $(this).html('Cargando...');

    var $nombre = $('#nombre').val();
    var $fecha_inicio = $('#fecha_inicio').val();
    var $fecha_fin = $('#fecha_fin').val();
    var $token = $('#form-crear-matricula #token').val();

    var ruta = '/admin/matriculas';

    var XHRs = [];
    var resultado = true;

    $('#tabla-crear-matricula tr').each(function (index, el) {
      var $id_detalle_institucion = $(this).find('.id-division').html();
      var $monto = $(this).find('.monto-matricula').val();

      if (index != 0) {
        XHRs.push($.ajax({
          url : ruta,
          headers : {'X-CSRF-TOKEN': $token},
          type : 'POST',
          dataType : 'json',
          data : {
            nombre : $nombre,
            monto : $monto,
            tipo : 'matricula',
            estado : '1',
            fecha_inicio : $fecha_inicio,
            fecha_fin : $fecha_fin,
            destino : '0',
            id_detalle_institucion : $id_detalle_institucion
          },
          fail : function () {
            resultado = false;
          }
        }));
      };
    });

    $.when.apply(null, XHRs).then(function () {
      if (resultado) {
        swal({
            title: "Éxito!",
            text: "Se crearon los conceptos de matrícula correctamente.",
            type: "success"
        }, function () {
          document.location.reload();
        });
      } else {
        swal({
            title: "Error",
            text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.",
            type: "warning"
        }, function () {
          document.location.reload();
        });
      }
    });

  } else {
    swal({
        title: "¡Atención!",
        text: "Debe seleccionar una institución primero.",
        type: "warning"
    });
  }
});

$('#form-listar-matriculas #btn-listar-matriculas').click(function (e) {

  e.preventDefault();

  $id_institucion = $('#form-listar-matriculas #id_institucion').val();
  $anio = $('#form-listar-matriculas #year').val();

  if ($id_institucion != "" && $anio != "" ) {
    var ruta = 'matriculas/' + $id_institucion + '/' + $anio;
    $('#tabla-lista-matriculas tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden matricula-id'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].nombre_division + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            fila += "<td><a href='#modal-editar-matricula' data-toggle='modal' class='btn bgm-amber m-r-20' data-id='" + data[i].id + "' data-nombre='" + data[i].nombre + "' data-monto='" + data[i].monto + "'><i class='zmdi zmdi-edit'></i></a><label class='checkbox checkbox-inline'><input type='checkbox'><i class='input-helper'></i>Seleccionar</label></td>";
            fila += "</tr>";
            $('#tabla-lista-matriculas tbody').append(fila);
        };
      } else {
        $('#tabla-lista-matriculas tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });
  } else {
    swal({
      title : '¡Atención!',
      text : 'Debe seleccionar la institución y el año.',
      type : 'warning'
    });
  }
});

$('#modal-editar-matricula').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var nombre = $boton.data('nombre');
  var monto = $boton.data('monto');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
  $modal.find('#modal-nombre').val(nombre);
  $modal.find('#modal-monto').val(monto);
});

$('#modal-editar-matricula #modal-guardar').click(function () {
  var $modal = $('#modal-editar-matricula');
  var $id = $('#modal-id').val();
  var $nombre = $('#modal-nombre').val();
  var $monto = $('#modal-monto').val();
  var $token = $('#modal-token').val();

  var ruta = '/admin/matriculas/' + $id;

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      nombre : $nombre,
      monto : $monto,
      operacion : 'actualizar'
    },
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Se actualizó la matrícula.",
          type: "success",
          closeOnConfirm: true
      }, function(){
          reloadTablaMatriculas($modal);
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
    }
  });
});

function reloadTablaMatriculas (modal_matricula) {
  $id_institucion = $('#form-listar-matriculas #id_institucion').val();
  $anio = $('#form-listar-matriculas #year').val();

  if ($id_institucion != "" && $anio != "" ) {
    var ruta = 'matriculas/' + $id_institucion + '/' + $anio;
    $('#tabla-lista-matriculas tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden matricula-id'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].nombre_division + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            fila += "<td><a href='#modal-editar-matricula' data-toggle='modal' class='btn bgm-amber m-r-20' data-id='" + data[i].id + "' data-nombre='" + data[i].nombre + "' data-monto='" + data[i].monto + "'><i class='zmdi zmdi-edit'></i></a><label class='checkbox checkbox-inline'><input type='checkbox'><i class='input-helper'></i>Seleccionar</label></td>";
            fila += "</tr>";
            $('#tabla-lista-matriculas tbody').append(fila);
        };
      } else {
        $('#tabla-lista-matriculas tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });

    modal_matricula.modal('hide');
  } else {
    document.location.reload;
  }
};

$('#btn-deshabilitar-matriculas').click(function (e) {
  e.preventDefault();
  var resultado = true;
  var XHRs = [];

  var $filasTabla = $('#tabla-lista-matriculas tr');

  $(this).html('Cargando...');

  $filasTabla.each(function (index, el) {
    var $seleccionado = $(this).find('[type=checkbox]').is(':checked');

    if (index != 0 && $seleccionado) {
      var $id = $(this).find('.matricula-id').html();
      var $token = $('#token-deshabilitar').val();

      var ruta = '/admin/matriculas/' + $id;

      XHRs.push($.ajax({
        url: ruta,
        headers : { 'X-CSRF-TOKEN' : $token },
        type : 'PUT',
        dataType : 'json',
        data : {
          estado : '0',
          operacion : 'estado'
        },
        fail : function () {
          resultado = false;
        }
      }));
    };
  });

  $.when.apply(null, XHRs).then(function () {
    if (resultado) {
      swal({
        title: "Éxito!",
        text: "Los cambios fueron realizados.",
        type: "success",
        closeOnConfirm: false
      }, function () {
        document.location.reload();
      });
    } else {
      swal({
          title: "Error",
          text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.",
          type: "warning"
      }, function () {
        document.location.reload();
      });
    }
  });
});
/*** Fin Matriculas ***/

/*** Pensiones ***/
$('#form-crear-pensiones #id_institucion').change(function (e) {

  $('#tabla-crear-pensiones tbody').empty();

  var route = 'divisiones/' + $(this).val() + "";

  $.get(route, function (response, state) {
    for (var i = 0; i < response.length; i++) {
      if (response[i].nombre_division != 'Todo') {
        var fila = "<tr>";
        fila += "<td class='hidden id-division'>" + response[i].id + "</td>";
        fila += "<td>" + response[i].nombre_division + "</td>";
        fila += "<td><div class='col-sm-12'><div class='fg-line'><input type='text' class='form-control input-sm monto-matricula' placeholder='Monto...'></div></div></td>";
        fila += "</tr>";
        $('#tabla-crear-pensiones tbody').append(fila);
      }
    };
  });
});

$('#btn-crear-pensiones').click(function (e) {

  e.preventDefault();

  var nroFilas = $('#tabla-crear-pensiones tr').length;

  if (nroFilas > 1) {

    $(this).html('Cargando...');

    var $mes_inicio = $('#mes_inicio').val();
    var $mes_fin = $('#mes_fin').val();
    var nro_mes_inicio = parseInt($mes_inicio.split('/')[0], 10);
    var anio_inicio = parseInt($mes_inicio.split('/')[1], 10);
    var nro_mes_fin = parseInt($mes_fin.split('/')[0], 10);
    var anio_fin = parseInt($mes_fin.split('/')[1], 10);
    var $token = $('#form-crear-pensiones #token').val();
    var XHRs = [];
    var ruta = '/admin/pensiones';
    var resultado = true;
    var meses = [0,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    if (anio_inicio == anio_fin) {
      for (var nro_mes = nro_mes_inicio; nro_mes <= nro_mes_fin; nro_mes++) {
        var nombre = 'Pension ' + meses[nro_mes] + ' ' + anio_inicio;
        var fecha_inicio = anio_inicio + '/' + nro_mes + '/01';
        /*var fecha_fin = anio_inicio + '/' + nro_mes + '/28';*/
        var fecha_fin = new Date(anio_inicio, nro_mes + 1, 0);

        $('#tabla-crear-pensiones tr').each(function (index, el) {
          var $id_detalle_institucion = $(this).find('.id-division').html();
          var $monto = $(this).find('.monto-matricula').val();

          if (index != 0) {
            XHRs.push($.ajax({
              url : ruta,
              headers : {'X-CSRF-TOKEN': $token},
              type : 'POST',
              dataType : 'json',
              data : {
                nombre : nombre,
                monto : $monto,
                tipo : 'pension',
                estado : '1',
                fecha_inicio : fecha_inicio,
                fecha_fin : fecha_fin,
                destino : '0',
                id_detalle_institucion : $id_detalle_institucion
              },
              fail : function () {
                resultado = false;
              }
            }));
          };
        });
      };
    } else if (anio_inicio < anio_fin) {

      var kfecha_inicio = anio_inicio + "/" + nro_mes_inicio + "/01";
      var kfecha_fin = anio_fin + "/" + nro_mes_fin + "/01";

      var dfi = new Date(kfecha_inicio);
      var dff = new Date(kfecha_fin);

      while (dfi <= dff) {

        var nombre = 'Pension ' + meses[dfi.getMonth() + 1] + ' ' + dfi.getFullYear();
        var fecha_mes = dfi.getMonth() + 1;
        var fecha_ini = dfi.getFullYear() + '/' + fecha_mes + '/01';
        //var fecha_fin = dfi.getFullYear() + '/' + fecha_mes + '/28';
        var fecha_fin = dfi.getFullYear() + '/' + fecha_mes + '/28';

        $('#tabla-crear-pensiones tr').each(function (index, el) {
          var $id_detalle_institucion = $(this).find('.id-division').html();
          var $monto = $(this).find('.monto-matricula').val();


          if (index != 0) {
            XHRs.push($.ajax({
              url : ruta,
              headers : {'X-CSRF-TOKEN': $token},
              type : 'POST',
              dataType : 'json',
              data : {
                nombre : nombre,
                monto : $monto,
                tipo : 'pension',
                estado : '1',
                fecha_inicio : fecha_ini,
                fecha_fin : fecha_fin,
                destino : '0',
                id_detalle_institucion : $id_detalle_institucion
              },
              fail : function () {
                resultado = false;
              }
            }));
          };
        });

        dfi.setMonth(dfi.getMonth() + 1);
      }
    }

    $.when.apply(null, XHRs).then(function () {
      if (resultado) {
        swal({
            title: "Éxito!",
            text: "Se crearon las pensiones correctamente.",
            type: "success"
        }, function () {
          document.location.reload();
        });
      } else {
        swal({
            title: "Error",
            text: "Sucedió algo inesperado. Por favor, intente nuevamente en unos minutos.",
            type: "warning"
        }, function () {
          document.location.reload();
        });
      }
    });
  } else {
    swal({
        title: "¡Atención!",
        text: "Debe seleccionar una institución primero.",
        type: "warning"
    });
  }
});

$('#form-listar-pensiones #id_institucion').change(function (e) {

  var $detalle_institucion = $('#form-listar-pensiones #id_detalle_institucion');
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

$('#form-listar-pensiones #btn-listar-pensiones').click(function (e) {

  e.preventDefault();

  $id_detalle_institucion = $('#form-listar-pensiones #id_detalle_institucion').val();
  $anio = $('#form-listar-pensiones #year').val();

  if ($id_detalle_institucion != "" && $anio != "" ) {
    var ruta = 'pensiones/' + $id_detalle_institucion + '/' + $anio;
    $('#tabla-listar-pensiones tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden pension-id'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            fila += "<td><a href='#modal-editar-pension' data-toggle='modal' class='btn bgm-amber m-r-20' data-id='" + data[i].id + "' data-monto='" + data[i].monto + "'><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-listar-pensiones tbody').append(fila);
        };
      } else {
        $('#tabla-listar-pensiones tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });
  } else {
    swal({
      title : '¡Atención!',
      text : 'Debe seleccionar la institución y el año.',
      type : 'warning'
    });
  }
});

$('#modal-editar-pension').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var monto = $boton.data('monto');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
  $modal.find('#modal-monto').val(monto);
});

$('#modal-editar-pension #modal-guardar').click(function () {
  var $modal = $('#modal-editar-pension');
  var $id = $('#modal-id').val();
  var $monto = $('#modal-monto').val();
  var $token = $('#modal-token').val();

  var ruta = '/admin/pensiones/' + $id;

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      monto : $monto,
      operacion : 'actualizar'
    },
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Se actualizó la pensión.",
          type: "success",
          closeOnConfirm: true
      }, function(){
          reloadTablaPension($modal);
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
    }
  });
});

function reloadTablaPension (modal_pension) {
  $id_detalle_institucion = $('#form-listar-pensiones #id_detalle_institucion').val();
  $anio = $('#form-listar-pensiones #year').val();

  if ($id_detalle_institucion != "" && $anio != "" ) {
    var ruta = 'pensiones/' + $id_detalle_institucion + '/' + $anio;
    $('#tabla-listar-pensiones tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden pension-id'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            fila += "<td><a href='#modal-editar-pension' data-toggle='modal' class='btn bgm-amber m-r-20' data-id='" + data[i].id + "' data-monto='" + data[i].monto + "'><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-listar-pensiones tbody').append(fila);
        };
      } else {
        $('#tabla-listar-pensiones tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });

    modal_pension.modal('hide');
  } else {
    document.location.reload;
  }
};

/*** Fin Pensiones ***/

/*** Cobros Ordinarios ***/
$('#form-lista-c-ordinarios #btn-lista-c-ordinarios').click(function (e) {

  e.preventDefault();

  $id_institucion = $('#form-lista-c-ordinarios #id_institucion').val();

  if ($id_institucion != "") {
    var ruta = 'ordinarios/listar/' + $id_institucion;
    $('#tabla-lista-c-ordinarios tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td class='hidden'>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td>" + data[i].monto + "</td>";
            if (data[i].estado == 1) {
              fila += "<td>Habilitado</td>";
            } else {
              fila += "<td>Deshabilitado</td>";
            }
            fila += "<td><a href='#modal-editar-c-ordinario' data-toggle='modal' class='btn bgm-amber m-r-20' ";
            fila += "data-id='" + data[i].id + "' data-nombre='" + data[i].nombre + "' data-monto='" + data[i].monto + "' data-estado='" + data[i].estado + "' data-tipo='" + data[i].tipo + "' data-destino='" + data[i].destino + "'><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-lista-c-ordinarios tbody').append(fila);
        };
      } else {
        $('#tabla-lista-c-ordinarios tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });
  } else {
    swal({
      title : '¡Atención!',
      text : 'Debe seleccionar la institución.',
      type : 'warning'
    });
  }
});
/*** Fin Cobros Ordinarios ***/