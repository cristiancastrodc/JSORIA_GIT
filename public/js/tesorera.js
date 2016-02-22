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

