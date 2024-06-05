<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	$sino = array(1 => $idioma['Si'], 0 => $idioma['No']);
	$valoridioma = array("es" => "Castellano", "ay" => 'Aymara', "qu" => "Quechua", "gu" => 'Guarani', "en" => 'Ingles');

	$valoridioma = array("es" => "Castellano", "ay" => 'Aymara', "qu" => "Quechua", "gu" => 'Guarani', "en" => 'Ingles');
	if ($_SESSION['Nivel'] == "1") {
		$tipo['1'] = $idioma['Administrador'];
	}
	$tipo["2"] = $idioma['Director'];
	$tipo["4"] = $idioma['Secretaria'];
	$tipo["5"] = $idioma['Regente'];

	$sino = array(0 => $idioma['No'], 1 => $idioma['Si']);
?>
	<h2><?php echo $idioma['NuevoUsuario'] ?></h2>
	<form action="guardar.php" method="post" class="formulario">
		<table class="table table-bordered table-striped">
			<tr>
				<td><?php echo $idioma['Paterno'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Paterno'] : '' ?>" name="Paterno" class="span12" placeholder="" required>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Materno'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Materno'] : '' ?>" name="Materno" class="span12" placeholder="" required>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Nombres'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Nombres'] : '' ?>" name="Nombres" class="span12" placeholder="" required>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['NivelUsuario'] ?><br>
					<?php campo("Nivel", "select", $tipo, "span12", 1, "", 0, "", isset($usua) ? $usua['Nivel'] : '') ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Usuario'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Usuario'] : '' ?>" name="Usuario" class="span12" placeholder="" required>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Contrasena'] ?><br>
					<input type="text" value="" name="Pass" class="span12" placeholder="" id="Pass" required>
					<small><?php echo $idioma['NotaContrasenaNueva'] ?></small>
					<?php htmlListadoCriteriosContrasena(); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Apodo'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Nick'] : '' ?>" name="Nick" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Ci'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Ci'] : '' ?>" name="Ci" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Direccion'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Direccion'] : '' ?>" name="Direccion" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Telefono'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Telefono'] : '' ?>" name="Telefono" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Celular'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Celular'] : '' ?>" name="Celular" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Observacion'] ?><br>
					<input type="text" value="<?php echo isset($usua) ? $usua['Observacion'] : '' ?>" name="Observacion" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Idioma'] ?><br>
					<?php campo("Idioma", "select", $valoridioma, "span12", 1, "", 0, "", isset($usua) ? $usua['Idioma'] : '') ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['Habilitado'] ?><br>
					<?php campo("Activo", "select", $sino, "span12", 1, "", 0, "", isset($usua) ? $usua['Activo'] : '') ?>
				</td>
			</tr>
			<tr>
				<td><input type="submit" class="btn btn-success" value="<?php echo $idioma['Guardar'] ?>" id="guardar"></td>
			</tr>
		</table>
	</form>
<?php
}
?>