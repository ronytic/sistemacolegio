<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	$CodDocente = $_POST['CodDocente'];
	include_once("../../class/asesor.php");
	include_once("../../class/curso.php");
	include_once("../../class/docente.php");
	$asesor = new asesor;
	$curso = new curso;

	$docente = new docente;
	$asesores = $asesor->mostrarTodoRegistro("CodDocente=" . $CodDocente);
	// echo "<pre>";
	// print_r($asesores);
	// echo "</pre>";
	$doc = $docente->mostrarDocente($CodDocente);
	$doc = array_shift($doc);
	?>
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr>
				<th colspan="2"> <?php echo $idioma['Docente'] ?>:<?php echo capitalizar($doc['Paterno']) ?> <?php echo capitalizar($doc['Materno']) ?> <?php echo capitalizar($doc['Nombres']) ?></th>
			</tr>
			<tr>
				<th witdh="5">N</th>
				<th><?php echo $idioma['Curso'] ?></th>
				<th><?php echo $idioma['Observacion'] ?></th>
				<th></th>
			</tr>
		</thead>
		<?php
			foreach ($asesores as $asesor) {
				$i++;
				$cur = $curso->mostrarCurso($asesor['CodCurso']);
				$cur = array_shift($cur);

				?>
			<tr>
				<td><?php echo $i ?></td>

				<td><?php echo $cur['Nombre'] ?></td>
				<td><?php echo $asesor['Observacion'] ?></td>
				<td>
					<a href="#" class="btn btn-mini eliminar" title="<?php echo $idioma['Eliminar'] ?>" rel="<?php echo $asesor['CodAsesor'] ?>"><i class="icon-remove"></i>
				</td>
			</tr>
		<?php
			}
			?>
	</table>
<?php
}
?>