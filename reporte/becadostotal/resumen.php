<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	$url = "../../impresion/reporte/becadostotal.php";
?>
	<a class="btn btn-danger" target="_blank" href="<?php echo $url; ?>"><?php echo $idioma['AbrirOtraVentana'] ?></a>
	<hr />
	<div id="parentIframe">
		<iframe src="<?php echo $url; ?>" width="100%" height="700" id="pdf" title=""></iframe>
	</div>
<?php
}
?>