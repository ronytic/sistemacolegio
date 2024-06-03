var file = "reporte.php";
function respuesta(data) {
	$("#respuesta").html(data);
	agregarCargandoIframe('#areaimpresion', false);
}