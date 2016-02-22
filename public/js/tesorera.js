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

