<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	$Desde = $_POST['Desde'];
	$Hasta = $_POST['Hasta'];
	$Tipo = $_POST['Tipo'];
	$url = "../../impresion/cuotas/arqueo.php?wsd=new&Desde=" . $Desde . "&Hasta=" . $Hasta . "&Tipo=" . $Tipo . "&lock=" . md5("lock");
?>
	<iframe src="<?php echo $url ?>" width="100%" height="800" id="pdf"></iframe>
<?php
}
?>