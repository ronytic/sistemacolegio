<?php
include_once("../../login/check.php");
include_once("../../class/agenda.php");
include_once("../../class/alumno.php");
include_once("../../class/curso.php");
include_once("../../class/materias.php");
include_once("../../class/config.php");
include_once("../../class/observaciones.php");
if (isset($_POST)) {
	$Fecha = fecha2Str($_POST['Fecha'], 0);
	$CodAl = isset($_SESSION['CodAl']) ?  $_SESSION['CodAl'] : "";
	$CodMateria = isset($_POST['CodMateria']) ? $_POST['CodMateria'] : "";
	$alumno = new alumno;
	$curso = new curso;
	$agenda = new agenda;
	$materia = new materias;
	$observaciones = new observaciones;
	$config = new config;

	//Cantidad de Observaciones
	$CodObser = $observaciones->CodObservaciones(1);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantObser = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantObser = array_shift($CantObser);
	//Cantidad de Faltas
	$Obser = array();
	$CodObser = $observaciones->CodObservaciones(2);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantFaltas = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantFaltas = array_shift($CantFaltas);
	//Cantidad de Atrasos
	$Obser = array();
	$CodObser = $observaciones->CodObservaciones(3);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantAtrasos = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantAtrasos = array_shift($CantAtrasos);
	//Cantidad de Licencias
	$Obser = array();
	$CodObser = $observaciones->CodObservaciones(4);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantLicencias = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantLicencias = array_shift($CantLicencias);
	//Cantidad de Felicitaciones
	$Obser = array();
	$CodObser = $observaciones->CodObservaciones(5);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantNotificacion = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantNotificacion = array_shift($CantNotificacion);
	//Cantidad de No contestan
	$Obser = array();
	$CodObser = $observaciones->CodObservaciones(6);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantNoContestan = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantNoContestan = array_shift($CantNoContestan);
	//Cantidad de Felicitaciones
	$Obser = array();
	$CodObser = $observaciones->CodObservaciones(7);
	foreach ($CodObser as $CodO) {
		$Obser[] = $CodO['CodObservacion'];
	}
	$CodigosObservaciones = implode(",", $Obser);
	$CantFelicitacion = $agenda->CantidadObservaciones($CodAl, $CodigosObservaciones, $CodMateria, $Fecha);
	$CantFelicitacion = array_shift($CantFelicitacion);
	$Total = $CantObser['Cantidad'] + $CantFaltas['Cantidad'] + $CantAtrasos['Cantidad'] + $CantLicencias['Cantidad'] + $CantNotificacion['Cantidad'] + $CantNoContestan['Cantidad'] + $CantFelicitacion['Cantidad'];


	$ag = $agenda->mostrarRegistroFecha($Fecha);
?>
	<table class="table table-condensed table-bordered inicio">
		<tr>
			<td width="75" colspan="1" class=""><?php echo $idioma['TotalObservaciones'] ?>: <span class="resaltar"><?php echo $Total; ?></span> <a href="#" class="imprimir btn btn-info btn-mini"><?php echo $idioma['Imprimir'] ?></a></td>
		</tr>
		<tr>
			<td class="centrar" id="grafica" width="100%" height="270"><?php echo $CantObser['Cantidad']; ?></td>


		</tr>
	</table>
	<?php
	?>
	<a href="#" id="exportarexcel" class="btn btn-success btn-mini"><?php echo $idioma['ExportarExcel'] ?></a>
	<table class="table table-hover table-bordered table-striped table-condensed inicio">
		<thead>
			<tr class="resaltar">
				<th colspan="3"><?php echo $idioma['Fecha'] ?></th>
				<th colspan="4"><?php echo fecha2Str($Fecha) ?></th>
			</tr>
			<tr class="cabecera">
				<th width="10" style="min-width:10px;"></th>
				<th><small><?php echo $idioma['Nombre'] ?></small></th>
				<th><small><?php echo sacarToolTip($idioma['Curso'], "", "0") ?></small></th>
				<th><small><?php echo sacarToolTip($idioma['Materia'], "", "R", 3) ?></small></th>
				<th width="100"><small><?php echo sacarToolTip($idioma['Observacion'], "", "R", 3) ?></small></th>
				<th><small><?php echo $idioma['Detalle'] ?></small></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!count($ag)) {
			?>
				<tr>
					<td colspan="6"><?php echo $idioma['NoExisteRegistro']; ?></td>
				</tr>
				<?php
			} else {
				/*Sacando Fecha de Trimestre*/
				$fechaInicioBimestre1 = $config->mostrarConfig("InicioBimestre1", 1);
				$fechaFinBimestre1 = $config->mostrarConfig("FinBimestre1", 1);
				$fechaInicioBimestre2 = $config->mostrarConfig("InicioBimestre2", 1);
				$fechaFinBimestre2 = $config->mostrarConfig("FinBimestre2", 1);
				$fechaInicioBimestre3 = $config->mostrarConfig("InicioBimestre3", 1);
				$fechaFinBimestre3 = $config->mostrarConfig("FinBimestre3", 1);
				$fechaInicioBimestre4 = $config->mostrarConfig("InicioBimestre4", 1);
				$fechaFinBimestre4 = $config->mostrarConfig("FinBimestre4", 1);

				$fechaInicioTrimestre1 = $config->mostrarConfig("InicioTrimestre1", 1);
				$fechaFinTrimestre1 = $config->mostrarConfig("FinTrimestre1", 1);
				$fechaInicioTrimestre2 = $config->mostrarConfig("InicioTrimestre2", 1);
				$fechaFinTrimestre2 = $config->mostrarConfig("FinTrimestre2", 1);
				$fechaInicioTrimestre3 = $config->mostrarConfig("InicioTrimestre3", 1);
				$fechaFinTrimestre3 = $config->mostrarConfig("FinTrimestre3", 1);
				/*Fin de Sacando Información de Trimestre*/
				foreach ($ag as $a) {
					$al = $alumno->mostrarTodoDatos($a['CodAlumno']);
					$al = array_shift($al);

					$cur = $curso->mostrarCurso($al['CodCurso']);
					$cur = array_shift($cur);

					$tipo = 0;
					$mensaje = "";
					$m = $materia->mostrarMateria($a['CodMateria']);
					$m = array_shift($m);
					$o = $observaciones->mostrarObser($a['CodObservacion']);
					$o = array_shift($o);
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
								case 1: { ?>
										<div class="cverde lateral" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
									<?php }
									break;
								case 2: { ?>
										<div class="cazul lateral" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
									<?php }
									break;
								case 3: { ?>
										<div class="cnaranja lateral" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
									<?php }
									break;
								case 4: { ?>
										<div class="cnegro lateral" title="<?php echo $mensaje ?>" style="width:5px;height:18px"></div>
							<?php }
									break;
							}
							?>
							<?php if ($a['Resaltar']) { ?><div class="crojo" title="<?php echo $idioma['Importante'] ?>" style="width:5px;height:18px"></div><?php } ?>
						</td>
						<td class="<?php echo $resaltar ?>"><?php echo capitalizar($al['Paterno']) ?> <?php echo capitalizar(acortarPalabra($al['Nombres'])) ?></td>
						<td class="<?php echo $resaltar ?>"><small><?php echo $cur['Abreviado'] ?></small></td>
						<td class="<?php echo $resaltar ?> pequeno">
							<div title="<?php echo $m['Nombre'] ?>"><?php echo $m['Abreviado'] ?></div>
						</td>
						<td class="<?php echo $resaltar ?>"><?php echo $o['Nombre'] ?></td>
						<td class="<?php echo $resaltar ?>"><?php echo $a['Detalle']; ?></td>
						<td class="centrar">
							<a href="agenda/total/agenda.php?CodAl=<?php echo $a['CodAlumno'] ?>" class="btn btn-mini" title="<?php echo $idioma['VerAgenda'] ?>"><i class="icon-book"></i></a>
						</td>
					</tr>
			<?php
				}
			} //Fin If
			?>
		<tbody>
	</table>
<?php
}

?>
<script language="javascript" type="application/javascript" src="js/core/plugins/exporting.js"></script>
<script language="javascript" type="text/javascript">
	var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'grafica',
			type: 'bar'
		},
		title: {
			text: '<?php echo $idioma['Estadisticas'] ?> <?php echo $idioma['Agenda'] ?>'
		},
		subtitle: {
			text: '<?php echo $idioma['Fecha'] ?>: <?php echo fecha2Str($Fecha) ?>'
		},
		xAxis: {
			categories: ['<?php echo $idioma['Observaciones'] ?>', '<?php echo $idioma['Faltas'] ?>', '<?php echo $idioma['Atrasos'] ?>', '<?php echo $idioma['Licencias'] ?>', '<?php echo $idioma['NoRespondeTelf'] ?>', '<?php echo $idioma['NotificacionPadres'] ?>', '<?php echo $idioma['Felicitaciones'] ?>'],
		},
		yAxis: {
			min: 0,
			title: {
				text: '<?php echo $idioma['CantidadObservaciones'] ?>'
			},
			labels: {
				overflow: 'justify'
			}
		},
		plotOptions: {
			bar: {
				dataLabels: {
					enabled: true
				}
			}
		},
		legend: false,
		series: [{
			name: '<?php echo $idioma['Observaciones'] ?>',
			data: [<?php echo $CantObser['Cantidad']; ?>, <?php echo $CantFaltas['Cantidad']; ?>, <?php echo $CantAtrasos['Cantidad']; ?>, <?php echo $CantLicencias['Cantidad']; ?>, <?php echo $CantNoContestan['Cantidad']; ?>, <?php echo $CantNotificacion['Cantidad']; ?>, <?php echo $CantFelicitacion['Cantidad']; ?>],
		}],
		exporting: {
			enabled: false
		}
	});
	$(document).ready(function() {
		$(".imprimir").click(function(e) {
			e.preventDefault();
			chart.print();
		});
	});
</script>