function lanzadorC(CodCurso) {
	$.post("materias.php", { "CodCurso": CodCurso }, function (data) {
		$("select[name=CodMateria]").html(data);
		buscadorLista("", $("[name=CodMateria]"));
	});
};
function respuesta1(data) {
	$("#configuracion").html(data);
	buscadorLista("", $("[name=Periodo]"));
	$("#ver").click(function (e) {
		var CodMateria = $("select[name=CodMateria]").val();
		var Periodo = $("select[name=Periodo]").val();
		$.post("listaalumnos.php", { 'CodCurso': CodCurso, 'CodMateria': CodMateria, 'Periodo': Periodo }, respuesta2);
	});
}
function respuesta2(data) {
	$("#respuesta").html(data);
	$(".ver").toggle(function (e) {
		e.preventDefault();
		$(this).find('i').removeClass('icon-chevron-down').addClass('icon-chevron-up');
		$(this).parent().parent().next().show();
	}, function (e) {
		e.preventDefault();
		$(this).find('i').removeClass('icon-chevron-up').addClass('icon-chevron-down');
		$(this).parent().parent().next().hide();
	});
}