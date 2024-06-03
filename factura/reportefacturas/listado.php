<?php
include_once("../../login/check.php");
extract($_POST);
$da = array();
foreach ($_POST as $k => $v) {
	array_push($da, $k . "=" . $v);
};
$url = "../../impresion/factura/listado.php?" . implode("&", $da);
?>
<a href="<?php echo $url ?>" target="_blank" class="btn btn-danger"><?php echo $idioma['AbrirOtraVentana'] ?></a>
<hr>
<div id="parentIframe">
	<iframe src="<?php echo $url ?>" width="100%" height="550" id="pdf"></iframe>
</div>