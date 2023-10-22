function lanzadorC(CodDocente) {
	mostrar();
}
function respuestaInicial(data) {
	$("#contenido1").html(data);
	var CodModificar = 0;
	var CodCurso = $("select[name=Curso]").val();

	$('#asignar').click(function (e) {
		CodCurso = $("select[name=Curso]").val();
		Observacion = $("textarea[name=Observacion]").val();

		if (!CodCurso) { alert(CodCurso + ", " + Porfavor); return false; }
		if (confirm(SeguroAsignar)) {
			$.post("guardar.php", { 'CodDocente': CodDocente, 'CodCurso': CodCurso, 'Observacion': Observacion }, function (data) {
				if (data != "") {
					alert(data);
				}
				$("select[name=Curso]").val('');
				$("textarea[name=Observacion]").val('');
				mostrar();
			});

		}
	});

	$(document).on("click", '.eliminar', function (e) {
		e.preventDefault();
		if (confirm(MensajeEliminar)) {
			var Cod = $(this).attr("rel");
			$.post("eliminar.php", { 'Cod': Cod }, mostrar());
		}
	});
}

function mostrar() {
	$.post('mostrar.php', { 'CodDocente': CodDocente }, repuestamostrar);
}
function repuestamostrar(data) {
	$("#contenido2").html(data)
}