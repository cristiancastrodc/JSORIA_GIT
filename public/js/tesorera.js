$('#form-registrar-egreso-tesorera #tipo_comprobante').change(function (event){
	var seleccionado = $('#form-registrar-egreso-tesorera #tipo_comprobante').val();

	if (seleccionado == 3) {
		$('#numero_comprobante').prop('disabled', true);
		$('#form-group-nro-comprobante').slideUp();
	} else {
		$('#numero_comprobante').prop('disabled', false);
		$('#form-group-nro-comprobante').slideDown();
	}
});


$('#form-registrar-egreso-tesorera #btn_nuevo_rubro').click(function (e) {
  e.preventDefault();

  var ruta ='../egresos/rubroNuevo/';
  var dato = $('#nombre').val();
  var token =$('#token').val();

  $.ajax({
  	url: ruta,
  	headers: {'X-CSRF-TOKEN': token},
  	type: 'POST',
  	dataType: 'json',
  	data:{nombre: dato},
  	success : function (response) {
  		swal({
          title: "Éxito",
          text: "Rubro creado.",
          type: "success",
      });
  		$('#nombre').val("");

  	}
  });
});

/*** Inicio Rubro ***/
$('#modal-editar-rubro').on('shown.bs.modal', function (e) {
  var $boton = $(e.relatedTarget);
  var id = $boton.data('id');
  var nombre = $boton.data('nombre');

  var $modal = $(this);
  $modal.find('#modal-id').val(id);
  $modal.find('#modal-nombre').val(nombre);
});

$('#modal-editar-rubro #modal-guardar').click(function () {
  var $modal = $('#modal-editar-rubro');
  var $id = $('#modal-id').val();
  var $nombre = $('#modal-nombre').val();
  var $token = $('#modal-token').val();

  var ruta = '/tesorera/rubros/' + $id;

  $.ajax({
    url: ruta,
    headers : { 'X-CSRF-TOKEN' : $token },
    type : 'PUT',
    dataType : 'json',
    data : {
      nombre : $nombre,
      operacion : 'actualizar'
    },
    success : function (data) {
      swal({
          title: "Éxito",
          text: "Se actualizó el Rubro.",
          type: "success",
          closeOnConfirm : true
      }, function(){
          reloadTablaRubros($modal);
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
    },
    error : function (msg) {
      var err_list = '<ul>';
      $.each( msg.responseJSON, function( i, val ) {
        err_list += '<li>' + val[0] + '</li>';
      });
      err_list += '</ul>';

      $('#modal-error #message').html(err_list);
      $('#modal-error').fadeIn();
    }
  });
});
function reloadTablaRubros (modal_rubro) {
    var ruta = 'rubro/listar/';
    $('#tabla-listar-rubro tbody').empty();

    $.get(ruta, function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var fila = "<tr>";
            fila += "<td>" + data[i].id + "</td>";
            fila += "<td>" + data[i].nombre + "</td>";
            fila += "<td><a href='#modal-editar-rubro' data-toggle='modal' class='btn bgm-amber m-r-20' data-id=" + data[i].id + " data-nombre="+ data[i].nombre +"><i class='zmdi zmdi-edit'></i></a></td>";
            fila += "</tr>";
            $('#tabla-listar-rubro tbody').append(fila);
        };
      } else {
        $('#tabla-listar-rubro tbody').append('<tr><td colspan="4">No existen resultados.</td></tr>');
      }
    });

    modal_rubro.modal('hide');
  }
/*** Fin Rubro ***/
