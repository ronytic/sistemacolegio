<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	$Orden = $_POST['Orden'];
	$Periodo = isset($_POST['Periodo']) ? $_POST['Periodo'] : '1';
	$Cantidad = $_POST['Cantidad'];
	$url = "../../impresion/notas/mejorespeorespromediosanual.php?Cantidad=$Cantidad&Periodo=$Periodo&Orden=$Orden&lock=dce7c4174ce9323904a934a486c41288";
?>
	<a href="<?php echo $url ?>" class="btn btn-danger" target="_blank"><?php echo $idioma['AbrirOtraVentana'] ?></a>
	<hr />
	<iframe src="<?php echo $url ?>" width="100%" height="750"></iframe>
<?php
}
?>