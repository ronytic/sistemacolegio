<?php
include_once("../../login/check.php");
if (!empty($_POST) && $_POST['lock'] == md5("lock")) {
	$CodCurso = $_POST['CodCurso'];
	$Orden = $_POST['Orden'];
	$Periodo = $_POST['Periodo'];
	$url = "../../impresion/notas/promediocurso.php?CodCurso=$CodCurso&Periodo=$Periodo&Orden=$Orden&lock=dce7c4174ce9323904a934a486c41288";
?>
	<a href="<?php echo $url ?>" class="btn btn-danger" target="_blank"><?php echo $idioma['AbrirOtraVentana'] ?></a>
	<hr />
	<iframe src="<?php echo $url ?>" width="100%" height="750" id="pdf"></iframe>
<?php
}
?>