<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	include_once("../../class/curso.php");
	$curso = new curso;

	?>
	<div class="alert alert-info guardarE"><strong><?php echo $idioma['SeleccionarCurso'] ?></strong></div>
	<table class="table table-bordered table-hover">
		<tr>
			<td>
				<?php echo $idioma['Curso'] ?>:
				<select name="Curso" class="span12">
					<?php foreach ($curso->mostrar() as $cur) { ?>
						<option value="<?php echo $cur['CodCurso'] ?>"><?php echo $cur['Nombre'] ?></option>
					<?php } ?>
				</select>
				<?php echo $idioma['Observacion'] ?>:

				<textarea name="Observacion" id="" cols="30" rows="10" class="span12"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" value="<?php echo $idioma['Asignar'] ?>" class="btn btn-success guardarE" id="asignar">
				<input type="button" value="<?php echo $idioma['Modificar'] ?>" class="btn btn-warning ocultar actualizarE" id="actualizar">
				<input type="button" value="<?php echo $idioma['Cancelar'] ?>" class="btn ocultar actualizarE" id="cancelar">
			</td>
		</tr>
	</table>
<?php
}
?>
<script language="javascript" type="text/javascript">
	var MensajeEliminar = "<?php echo $idioma['EliminarAsignacionAsesor'] ?>";
	var SeleccioneMateria = "<?php echo $idioma['SeleccioneMateria'] ?>"
	var Porfavor = "<?php echo $idioma['PorFavor'] ?>";
	var SeguroAsignar = "<?php echo $idioma['SeguroAsignar'] ?>";
	var SeguroAsignarModificar = "<?php echo $idioma['SeguroAsignarModificar'] ?>";
</script>