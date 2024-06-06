<?php
include_once("../../login/check.php");
if (!empty($_POST['CodObservacionesFrecuentes'])) {
	$CodObservacionesFrecuentes = $_POST['CodObservacionesFrecuentes'];
	include_once("../../class/observacionesfrecuentes.php");
	include_once("../../class/cursoarea.php");
	$observacionesfrecuentes = new observacionesfrecuentes;

	$men = $observacionesfrecuentes->mostrarObservacion($CodObservacionesFrecuentes);
	$men = array_shift($men);

	//$curarea=array_shift($curarea);
?>
	<h2><?php echo $idioma['Modificar'] ?></h2>
	<form action="actualizar.php" method="post" class="formulario">
		<input type="hidden" name="CodObservacionesFrecuentes" value="<?php echo $CodObservacionesFrecuentes ?>">
		<table class="table table-bordered table-striped">
			<tr>
				<td><?php echo $idioma['Nombre'] ?><br>
					<input type="text" value="<?php echo $men['Nombre'] ?>" name="Nombre" class="span12" placeholder="">
				</td>
			</tr>
			<tr>
				<td><?php echo $idioma['ValorObservacion'] ?><br>
					<input type="text" name="Valor" value="<?php echo $men['Valor'] ?>" class="span12">
				</td>
			</tr>

			<tr>
				<td><input type="submit" class="btn btn-success" value="<?php echo $idioma['Guardar'] ?>"></td>
			</tr>
		</table>
	</form>
<?php
}
?>