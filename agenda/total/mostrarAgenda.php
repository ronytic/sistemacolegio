<?php
include_once("../../login/check.php");
include_once("../../class/agenda.php");
include_once("../../class/alumno.php");
include_once("../../class/curso.php");
include_once("../../class/materias.php");
include_once("../../class/config.php");
include_once("../../class/observaciones.php");
if (isset($_POST)) {
	$CodAl = $_SESSION['CodAl'];
	$CodMateria = isset($_POST['CodMateria']) ? $_POST['CodMateria'] : '';
	$alumno = new alumno;
	$curso = new curso;
	$agenda = new agenda;
	$materia = new materias;
	$observaciones = new observaciones;
	$config = new config;
	$al = $alumno->mostrarTodoDatos($CodAl);
	$al = array_shift($al);
	$cur = $curso->mostrarCurso($al['CodCurso']);
	$cur = array_shift($cur);

	$TodoObservaciones = [];
	foreach ($observaciones->mostrarTodoRegistro('', '1') as $TO) {
		$TodoObservaciones[$TO['CodObservacion']] = $TO['Nombre'];
	}
	$TodoMaterias = [];
	foreach ($materia->mostrarMaterias() as $TM) {
		$TodoMaterias[$TM['CodMateria']] = $TM['Nombre'];
	}

	$CodigosObservaciones = [];
	foreach ($observaciones->agruparObservaciones() as $CodOb) {
		$CodigosObservaciones[$CodOb['NivelObservacion']] = explode(",", $CodOb['CodObservaciones']);
	}

	$TotalesAgenda = $agenda->CantidadTotalAgrupado($CodAl);

	$CantObservaciones = 0;
	$CantFaltas = 0;
	$CantAtrasos = 0;
	$CantLicencias = 0;
	$CantNotificacion = 0;
	$CantNoContestan = 0;
	$CantFelicitacion = 0;

	foreach ($TotalesAgenda as $TotAgenda) {
		//Observaciones
		foreach ($CodigosObservaciones[1] as $CodOb) {
			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantObservaciones += $TotAgenda['Cantidad'] ?? 0;
			}
		}
		//Faltas
		foreach ($CodigosObservaciones[2] as $CodOb) {
			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantFaltas += $TotAgenda['Cantidad'] ?? 0;
			}
		}
		//Atrasos
		foreach ($CodigosObservaciones[3] as $CodOb) {

			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantAtrasos += $TotAgenda['Cantidad'] ?? 0;
			}
		}
		//Licencias
		foreach ($CodigosObservaciones[4] as $CodOb) {
			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantLicencias += $TotAgenda['Cantidad'] ?? 0;
			}
		}
		//Notificacion
		foreach ($CodigosObservaciones[5] as $CodOb) {
			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantNotificacion += $TotAgenda['Cantidad'] ?? 0;
			}
		}
		//NoContestan
		foreach ($CodigosObservaciones[6] as $CodOb) {
			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantNoContestan += $TotAgenda['Cantidad'] ?? 0;
			}
		}
		//Felicitacion
		foreach ($CodigosObservaciones[7] as $CodOb) {
			if ($TotAgenda['CodObservacion'] == $CodOb) {
				$CantFelicitacion += $TotAgenda['Cantidad'] ?? 0;
			}
		}
	}

	$Total = $CantObservaciones + $CantFaltas + $CantAtrasos + $CantLicencias + $CantNotificacion + $CantNoContestan + $CantFelicitacion;

	/*Sacando Fecha de Trimestre*/
	if ($cur['Bimestre']) {
		$fechaInicioBimestre1 = $config->mostrarConfig("InicioBimestre1", 1);
		$fechaFinBimestre1 = $config->mostrarConfig("FinBimestre1", 1);
		$fechaInicioBimestre2 = $config->mostrarConfig("InicioBimestre2", 1);
		$fechaFinBimestre2 = $config->mostrarConfig("FinBimestre2", 1);
		$fechaInicioBimestre3 = $config->mostrarConfig("InicioBimestre3", 1);
		$fechaFinBimestre3 = $config->mostrarConfig("FinBimestre3", 1);
		$fechaInicioBimestre4 = $config->mostrarConfig("InicioBimestre4", 1);
		$fechaFinBimestre4 = $config->mostrarConfig("FinBimestre4", 1);
	} else {
		$fechaInicioTrimestre1 = $config->mostrarConfig("InicioTrimestre1", 1);
		$fechaFinTrimestre1 = $config->mostrarConfig("FinTrimestre1", 1);
		$fechaInicioTrimestre2 = $config->mostrarConfig("InicioTrimestre2", 1);
		$fechaFinTrimestre2 = $config->mostrarConfig("FinTrimestre2", 1);
		$fechaInicioTrimestre3 = $config->mostrarConfig("InicioTrimestre3", 1);
		$fechaFinTrimestre3 = $config->mostrarConfig("FinTrimestre3", 1);
	}
	/*Fin de Sacando Información de Trimestre*/
	if (isset($_POST['CodMateria'])) {
		$CodMateria = $_POST['CodMateria'];
		$ag = $agenda->mostrarRegistroMateriaAlumno(0, $al['CodCurso'], $CodMateria, $CodAl);
	} else {
		$ag = $agenda->mostrarRegistros($CodAl);
	}
?>
	<a href="#" id="exportarexcel" class="btn btn-success btn-mini"><?php echo $idioma['ExportarExcel'] ?></a>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th><?php echo $idioma['Observaciones'] ?></th>
				<th colspan="2"><?php echo $idioma['Felicitaciones'] ?></th>
				<th><?php echo $idioma['Total'] ?></th>
			</tr>
		</thead>
		<tr>
			<td class="centrar"><?php echo $CantObservaciones; ?></td>

			<td class="centrar" colspan="2"><?php echo $CantFelicitacion; ?></td>
			<td class="centrar resaltar alineadovertical x2" rowspan="5"><?php echo $Total; ?></td>
		</tr>
		<tr>
			<td class="resaltar"><?php echo $idioma['Faltas'] ?></td>
			<td class="resaltar"><?php echo $idioma['Atrasos'] ?></td>
			<td class="resaltar"><?php echo $idioma['Licencias'] ?></td>
		</tr>
		<tr>
			<td class="centrar"><?php echo $CantFaltas; ?></td>
			<td class="centrar"><?php echo $CantAtrasos; ?></td>
			<td class="centrar"><?php echo $CantLicencias; ?></td>
		</tr>
		<tr>
			<td class="resaltar" colspan="1"><?php echo $idioma['NoRespondeTelf'] ?></td>
			<td class="resaltar" colspan="2"><?php echo $idioma['NotificacionPadres'] ?></td>
		</tr>
		<tr>
			<td class="centrar" colspan="1"><?php echo $CantNoContestan; ?></td>
			<td class="centrar" colspan="2"><?php echo $CantNotificacion; ?></td>
		</tr>
	</table>
	<?php
	?>
	<div class="responsive-table">
		<a href="#" id="exportarexcel" class="btn btn-success btn-mini"><?php echo $idioma['ExportarExcel'] ?></a>
		<table class="table table-hover table-bordered table-striped table-condensed">
			<thead>
				<tr class="cabecera">
					<th width="20" style="min-width:20px;"></th>
					<th><?php echo $idioma['Materia'] ?></th>
					<th width="100"><?php echo $idioma['Observacion'] ?></th>
					<th><?php echo $idioma['Detalle'] ?></th>
					<th width="85"><?php echo $idioma['Fecha'] ?></th>
					<th></th>
				</tr>
			</thead>
			<?php


			foreach ($ag as $a) {
				$tipo = 0;
				$mensaje = "";
				if ($cur['Bimestre']) {
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioBimestre1) and strtotime($a['Fecha']) <= strtotime($fechaFinBimestre1)) {
						$tipo = 1;
					}
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioBimestre2) and strtotime($a['Fecha']) <= strtotime($fechaFinBimestre2)) {
						$tipo = 2;
					}
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioBimestre3) and strtotime($a['Fecha']) <= strtotime($fechaFinBimestre3)) {
						$tipo = 3;
					}
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioBimestre4) and strtotime($a['Fecha']) <= strtotime($fechaFinBimestre4)) {
						$tipo = 4;
					}
					$mensaje = $tipo . " " . $idioma['Bimestre'];
				} else {
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioTrimestre1) and strtotime($a['Fecha']) <= strtotime($fechaFinTrimestre1)) {
						$tipo = 1;
					}
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioTrimestre2) and strtotime($a['Fecha']) <= strtotime($fechaFinTrimestre2)) {
						$tipo = 2;
					}
					if (strtotime($a['Fecha']) >= strtotime($fechaInicioTrimestre3) and strtotime($a['Fecha']) <= strtotime($fechaFinTrimestre3)) {
						$tipo = 3;
					}
					$mensaje = $tipo . " " . $idioma['Trimestre'];
				}
				if ($a['Resaltar']) {
					$resaltar = "resaltar";
				} else {
					$resaltar = "";
				}
			?>
				<tr class=" <?php if ($a['Resaltar2']) echo "warning"; ?>">
					<td>
						<?php
						switch ($tipo) {
							case 1: { ?><div class="cverde" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
								<?php }
								break;
							case 2: { ?><div class="cazul" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
								<?php }
								break;
							case 3: { ?><div class="cnaranja" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
								<?php }
								break;
							case 4: { ?><div class="cnegro" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
						<?php }
								break;
						}
						?>
						<?php if ($a['Resaltar']) { ?><div class="crojo" title="<?php echo $idioma['Importante'] ?>" style="width:5px;height:18px"></div><?php } ?></td>
					<td class="<?php echo $resaltar ?>"><?php echo $TodoMaterias[$a['CodMateria']] ?? '' ?></td>
					<td class="<?php echo $resaltar ?>"><?php echo $TodoObservaciones[$a['CodObservacion']] ?? '' ?></td>
					<td class="<?php echo $resaltar ?>"><?php echo $a['Detalle']; ?></td>
					<td class="<?php echo $resaltar ?> der">
						<div title="<?php echo ($idioma['FechaRegistro']) ?>: <?php echo date("d-m-Y", strtotime($a['FechaRegistro'])); ?>
							<?php echo date("H:i:s", strtotime($a['HoraRegistro'])); ?>"><?php echo date("d-m-Y", strtotime($a['Fecha'])); ?><div>

					</td>

					<td class="centrar">
						<?php if (trim($al['CelularSMS']) != "" && $al['ActivarSMS']) { ?>
							<a href="#" class="btn btn-mini enviarmsg <?php echo $a['EnviadoSMS'] ? 'disabled btn-danger' : '' ?>" rel="<?php echo $a['CodAgenda']; ?>" title="<?php echo $idioma['EnviarSMS'] ?>"><i class="icon-envelope"></i></a>
						<?php } ?>
						<input type="checkbox" class="resaltar checkbox" rel="<?php echo $a['CodAgenda']; ?>" title="<?php echo $idioma['Revisado'] ?>" <?php if ($a['Resaltar2']) echo 'checked="checked"'; ?> /><br />
						<a href="#" class="btn btn-mini eliminar" title="<?php echo $idioma['Eliminar'] ?>" rel="<?php echo $a['CodAgenda']; ?>">x</a>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}

?>