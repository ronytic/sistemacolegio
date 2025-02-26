<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	include_once("../../class/agenda.php");
	include_once("../../class/curso.php");
	include_once("../../class/alumno.php");
	include_once("../../class/materias.php");
	include_once("../../class/observaciones.php");
	$agenda = new agenda;
	$observaciones = new observaciones;
	$alumno = new alumno;
	$cursos = new curso;
	$materias = new materias;

	$FechaInicio = $_POST['FechaInicio'];
	$FechaFinal = $_POST['FechaFinal'];
	$Curso = $_POST['Curso'];
	$Materia = $_POST['Materia'];
	$Alumnos = $_POST['Alumnos'];
	$Observacion = $_POST['Observacion'];

	$FechaInicio = fecha2Str($FechaInicio, 0);
	$FechaFinal = fecha2Str($FechaFinal, 0);
	$Cod = array_shift($Observacion);

	$TodoObservaciones = [];
	$CodTodosObservaciones = [];
	foreach ($observaciones->mostrarTodoRegistro('', '1', 'Nombre') as $TO) {
		$TodoObservaciones[$TO['CodObservacion']] = $TO['Nombre'];
		$CodTodosObservaciones[] = $TO['CodObservacion'];
	}

	if ($Cod == "") {
		$CodObservaciones = $CodTodosObservaciones;
	} else {
		$CodObservaciones = (array)$Observacion;
	}


	$ValoresObser = [];

	foreach ($CodObservaciones as $i => $obs) {
		$ValoresObser['Observacion' . ($i + 1)]['Nombre'] = "" . $TodoObservaciones[$obs] . "";
	}

	$CantidadDias = (strtotime($FechaFinal) - strtotime($FechaInicio)) / 86400;
	$ValoresFechas = [];

	$Valor = [];
	for ($i = 1; $i <= $CantidadDias + 1; $i++) {

		$Fecha = date("Y-m-d", strtotime($FechaInicio . "+" . ($i - 1) . "days"));
		$ag = $agenda->CantidadObservacionesTotal($Curso, $Alumnos, implode(",", $CodObservaciones), $Materia, $Fecha);

		foreach ($CodObservaciones as $j => $obs) {
			$Cantidad = 0;
			foreach ($ag as $a) {
				if ($a['CodObservacion'] == $obs) {
					$Cantidad = $a['Cantidad'];
				}
			}
			$ValoresObser['Observacion' . ($j + 1)]['Cantidades'][] = $Cantidad;
		}
		$ValoresFechas['Fecha' . $i] = "'" . (textoDia($Fecha, 1, 0, 0)) . "'";
	}
	$ValoresFechas = implode(",", $ValoresFechas);

	$subtitulo = "";

	if ($Curso == "") {
		$subtitulo .= " " . $idioma['Curso'] . ": " . $idioma['TodaUnidadEducativa'] . " - ";
	} else {
		$cur = $cursos->mostrarCurso($Curso);
		$cur = array_shift($cur);
		$subtitulo .= " " . $idioma['Curso'] . ": " . $cur['Nombre'] . " - ";
	}
	if ($Materia == "") {
		$subtitulo .= " " . $idioma['Materia'] . ": " . $idioma['Todas'] . " - ";
	} else {
		$mat = $materias->mostrarMateria($Materia);
		$mat = array_shift($mat);
		$subtitulo .= " " . $idioma['Materia'] . ": " . $mat['Nombre'] . " - ";
	}
	if ($Alumnos == "") {
		$subtitulo .= " " . $idioma['Alumnos'] . ": " . $idioma['Todos'] . " - ";
	} else {
		$al = $alumno->mostrarTodoDatos($Alumnos);
		$al = array_shift($al);
		$subtitulo .= " " . $idioma['Alumnos'] . ": " . $al['Paterno'] . " " . $al['Materno'] . " " . $al['Nombres'] . " - ";
	}
}
?>
<div id="reporte" style="height: 600px !important;"></div>
<a href="#" class="imprimir btn btn-info"><?php echo $idioma['Imprimir'] ?></a>
<script type="text/javascript">
	$(function() {
		var chart;
		$(document).ready(function() {
			$(".imprimir").click(function(e) {
				e.preventDefault();
				chart.print();
			});
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'reporte',
					type: 'line'
				},
				title: {
					text: '<?php echo $idioma['ReporteEstadisticoAgenda'] ?>'
				},
				subtitle: {
					text: '<?php echo $subtitulo ?>'
				},
				xAxis: {
					categories: [<?php echo $ValoresFechas ?>],
					labels: {
						rotation: -90,
						align: 'right',
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '<?php echo $idioma['CantidadObservaciones'] ?>'
					}
				},
				tooltip: {
					enabled: true,
					formatter: function() {
						return '<b>' + this.series.name + '</b><br/>' +
							this.x + ': ' + this.y + ' <?php echo $idioma['Registros'] ?>';
					}
				},
				plotOptions: {
					line: {
						dataLabels: {
							enabled: true
						},
						enableMouseTracking: true
					}
				},
				series: [
					<?php $i = 0;
					foreach ($ValoresObser as $Vo) {
						$i++;
						$ValoresCantidad = implode(",", $Vo['Cantidades']);
						echo $i != 1 ? "," : "";
					?> {
							name: '<?php echo $Vo['Nombre'] ?>',
							data: [<?php echo $ValoresCantidad ?>]
						}
					<?php
					}
					?>
				],
				navigation: {
					buttonOptions: {
						enabled: false
					}
				}
			});
		});

	});
</script>