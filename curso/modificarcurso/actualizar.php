<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	extract($_POST);
	include_once("../../class/curso.php");
	$curso = new curso;
	$cursoDatos = $curso->mostrarCurso($CodCurso);
	$cursoDatos = array_shift($cursoDatos);
	$valores = array(
		"Nombre" => "'$Nombre'",
		"Abreviado" => "'$Abreviado'",
		"CodCursoArea" => "'$CodCursoArea'",
		"Paralelo" => "'$Paralelo'",
		"Dps" => "'$Dps'",
		"Orden" => "'$Orden'",
		"Bimestre" => "'$Bimestre'",
		"NotaTope" => "'$NotaTope'",
		"NotaAprobacion" => "'$NotaAprobacion'",
		"MontoCuota" => "'$MontoCuota'",
		"CantidadEtapas" => "'$CantidadEtapas'"
	);
	if ($curso->actualizarRegistro($valores, "CodCurso=$CodCurso")) { ?>
		<div class="alert alert-success"><?php echo $idioma['DatosGuardadosCorrectamente'] ?></div>
		<?php
		if ($cursoDatos['MontoCuota'] != $MontoCuota) {
			include_once '../../class/alumno.php';
			$alumno = new alumno;
			include_once '../../class/cuota.php';
			$cuota = new cuota;
			$alumnos = $alumno->getRecords("CodCurso=$CodCurso");
			foreach ($alumnos as $al) {
				$CodAlumno = $al['CodAlumno'];
				for ($ncuota = 1; $ncuota <= 10; $ncuota++) {
					$cuotas = $cuota->mostrarTodoRegistro("CodAlumno = $CodAlumno AND Numero = $ncuota", '');

					$valorCuota = [
						'MontoPagar' => $MontoCuota
					];
					if (count($cuotas) == 0) {
						$cuota->insertarRegistro($valorCuota);
					} else {
						$cuota->actualizarCuota($valorCuota, "CodAlumno = $CodAlumno and Numero = $ncuota");
					}
				}
			}
		}
	} else { ?>
		<div class="alert alert-error"><?php echo $idioma['DatosGuardadosError'] ?></div>
<?php
	}
}
?>

<script language="javascript">
	// mostrar();
</script>