$(document).ready(function (e) {
	$(document).on('click', '.enlacecorreo', function (e) {
		e.preventDefault();
		var dest = $(this).attr("href") != "" ? $(this).attr("href") : $(this).attr("data-destino");
		var mensaje = $(this).attr("data-mensaje");
		var resp = $(this).attr("data-respuesta");
		var campos = $(this).attr("data-campos");
		if (mensaje != "") {
			if (confirm(mensaje)) {
				$.post(dest, campos, function (data) {
					html = '';
					if (data.estado == 'correcto') {
						html = '<div class="alert alert-success" style="margin:0px;padding-top:5px;padding-bottom:5px">' + data.mensaje + '</div>';
					} else {
						html = '<div class="alert alert-danger" style="margin:0px;padding-top:5px;padding-bottom:5px">' + data.mensaje + '</div>';
					}
					$(resp).html(html);


				}, "json");
			}
		} else {
			$.post(dest, campos, function (data) { $(resp).html(data) }, "json");
		}
	});
});