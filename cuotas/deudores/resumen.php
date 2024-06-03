<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	$CodCurso = $_POST['CodCurso'];
	$Cuota = $_POST['Cuota'];
	$Orden = $_POST['Orden'];
	$url = "../../impresion/cuotas/deudores.php?CodCurso=" . $CodCurso . "&Cuota=" . $Cuota . "&Orden=" . $Orden . "&lock=" . md5("lock");
?>
	<iframe src="<?php echo $url ?>" width="100%" height="750" id="pdf" title=""></iframe>
<?php
}
?>