$(document).on("ready", function () {
	mostrar();

	$(document).on("click", ".eliminar", function (e) {
		e.preventDefault();
		if (confirm(MensajeEliminar)) {
			var CodUsuario = $(this).attr("rel");
			$.post("eliminar.php", { 'CodUsuario': CodUsuario }, function (data) { mostrar(); });
		}
	});
	$(document).on("click", ".modificar", function (e) {
		e.preventDefault();
		if (confirm(MensajeModificar)) {
			cargandoG("#configuracion");
			var CodUsuario = $(this).attr("rel");
			$.post("modificar.php", { 'CodUsuario': CodUsuario }, function (data) { $(".configuracion").html(data); $("input[name=Usuario]").alpha({ 'allow': '' }); });
		}
	});
	$(document).on("click", "#nuevo", function (e) {
		e.preventDefault();
		cargandoG("#configuracion");
		var CodUsuario = $(this).attr("rel");
		$.post("nuevo.php", { 'CodUsuario': CodUsuario }, function (data) { $(".configuracion").html(data); $("input[name=Usuario]").alpha({ 'allow': '' }); });

	});
	$(document).on("keyup", "#Pass", function (event) {
		var password = $('#Pass').val();
		fortaleza = checkPasswordStrength(password);
		if (password != "") {

			if (fortaleza >= 4) {
				$("#guardar").attr("disabled", false);
			} else {
				$("#guardar").attr("disabled", true);
			}
		} else {
			$("#guardar").attr("disabled", false);
		}
	});
});
function mostrar() {
	cargandoG("#listadocursos");
	$.post("mostrar.php", "", function (data) { $("#listadocursos").html(data) });
}