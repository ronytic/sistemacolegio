<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	extract($_POST);
	include_once("../../class/usuario.php");
	$usuario = new usuario;
	$valores = array(
		"Paterno" => "'$Paterno'",
		"Materno" => "'$Materno'",
		"Nombres" => "'$Nombres'",
		"Nivel" => "'$Nivel'",
		"Usuario" => "'$Usuario'",
		"Nick" => "'$Nick'",
		"Ci" => "'$Ci'",
		"Direccion" => "'$Direccion'",
		"Telefono" => "'$Telefono'",
		"Celular" => "'$Celular'",
		"Observacion" => "'$Observacion'",
		"Idioma" => "'$Idioma'",
		"Activo" => "'$Activo'",
	);
	if ($Pass != "") {
		$valores = array_merge(array("Pass2" => "SHA1('$Pass')"), $valores);
	}
	if ($usuario->actualizarRegistro($valores, "CodUsuario=$CodUsuario")) {
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