<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	extract($_POST);
	include_once("../../class/anuncioslogin.php");
	$anuncioslogin = new anuncioslogin;
	$valores = array(
		"Mensaje" => "'$Mensaje'",
		"Resaltar" => "'$Resaltar'",
	);
	if (isset($_FILES['Imagen']) && $_FILES['Imagen']['name'] != "") {
		@copy($_FILES['Imagen']['tmp_name'], "../../imagenes/anuncioslogin/" . $_FILES['Imagen']['name']);
		$valores['Imagen'] = "'imagenes/anuncioslogin/" . $_FILES['Imagen']['name'] . "'";
	}
	if ($anuncioslogin->insertarRegistro($valores)) {
?><div class="alert alert-success"><?php echo $idioma['DatosGuardadosCorrectamente'] ?></div>
	<?php
	} else {
	?><div class="alert alert-error"><?php echo $idioma['DatosGuardadosError'] ?></div>
<?php
	}
}
?>

<script language="javascript">
	mostrar();
</script>