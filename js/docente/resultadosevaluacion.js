function lanzadorC(CodDocente) {

}
function respuestaInicial(data) {
	$("#contenido1").html(data);
	$(document).on("click", "#Ver", function () {
		$.post("reporte.php", { 'CodDocente': CodDocente }, respuesta)
	});
	$(document).on("click", "#VerImprimir", function () {
		$.post("reporteimprimir.php", { 'CodDocente': CodDocente }, respuesta)
	});

}
function respuesta(data) {
	$("#contenido2").html(data);
	agregarCargandoIframe('#pdf', false);
}