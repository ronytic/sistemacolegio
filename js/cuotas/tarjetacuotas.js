var file = "verDocumento.php";
function respuesta(data) {
	$("#respuesta").html(data);
	agregarCargandoIframe('#pdf', false);
}