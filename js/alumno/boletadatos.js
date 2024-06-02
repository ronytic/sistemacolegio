file = "verdocumento.php";
function respuesta(data) {
	$("#respuesta").html(data);
	agregarCargandoIframe('#pdf', true);
}