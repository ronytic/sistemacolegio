<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	include_once("../../class/agenda.php");
	include_once("../../class/alumno.php");
	include_once("../../class/curso.php");
	include_once("../../class/observaciones.php");
	$alumno = new alumno;
	$observaciones = new observaciones;
	$agenda = new agenda;
	$curso = new curso;
	$CodCurso = $_POST['CodCurso'];
	$cur = $curso->mostrarCurso($CodCurso);
	$cur = array_shift($cur);

	$CodigosObservaciones = [];
	foreach ($observaciones->agruparObservaciones() as $CodOb) {
		$CodigosObservaciones[$CodOb['NivelObservacion']] = explode(",", $CodOb['CodObservaciones']);
	}

?>
	<a href="#" class="btn" id="reportegeneral"><?php echo $idioma['ReporteGeneral'] ?></a>
	<a href="#" class="btn btn-info" id="reporteimprimir"><?php echo $idioma['ReporteImprimir'] ?></a>
	<hr />
	<div id="respuesta1">
		<div class="responsive-table">
			<a href="#" class="btn btn-success btn-mini" id="exportarexcel"><?php echo $idioma['ExportarExcel'] ?></a>
			<table class="table table-hover table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="2"><?php echo $idioma['Curso'] ?>:</th>
						<td colspan="10"><?php echo $cur['Nombre'] ?></td>
					</tr>

					<tr>
						<th>N</th>
						<th><?php echo $idioma['Paterno'] ?></th>
						<th><?php echo $idioma['Materno'] ?></th>
						<th><?php echo $idioma['Nombres'] ?></th>
						<th><span title="<?php echo $idioma['Observaciones']; ?>"><?php echo sacarIniciales($idioma['Observaciones']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['Observaciones']; ?></span></th>
						<th><span title="<?php echo $idioma['Faltas']; ?>"><?php echo sacarIniciales($idioma['Faltas']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['Faltas']; ?></span></th>
						<th><span title="<?php echo $idioma['Atrasos']; ?>"><?php echo sacarIniciales($idioma['Atrasos']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['Atrasos']; ?></span></th>
						<th><span title="<?php echo $idioma['Licencias']; ?>"><?php echo sacarIniciales($idioma['Licencias']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['Licencias']; ?></span></th>
						<th><span title="<?php echo $idioma['NotificacionPadres']; ?>"><?php echo sacarIniciales($idioma['NotificacionPadres']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['NotificacionPadres']; ?></span></th>
						<th><span title="<?php echo $idioma['NoRespondeTelf']; ?>"><?php echo sacarIniciales($idioma['NoRespondeTelf']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['NoRespondeTelf']; ?></span></th>
						<th><span title="<?php echo $idioma['Felicitaciones']; ?>"><?php echo sacarIniciales($idioma['Felicitaciones']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['Felicitaciones']; ?></span></th>
						<th><span title="<?php echo $idioma['Total']; ?>"><?php echo sacarIniciales($idioma['Total']) ?></span><span class="hidden-phone hidden-tablet hidden-desktop"> - <?php echo $idioma['Total']; ?></span></th>
					</tr>
				</thead>
				<?php
				$i = 0;
				$tObser = 0;
				$tFaltas = 0;
				$tAtrasos = 0;
				$tLicencias = 0;
				$tNotificacion = 0;
				$tNoContestan = 0;
				$tFelicitacion = 0;
				$tTotal = 0;
				foreach ($alumno->mostrarAlumnosCurso($CodCurso) as $al) {
					$i++;
					$CodAl = $al['CodAlumno'];

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
					//Estadisticas Totales
					$tObser += $CantObservaciones;
					$tFaltas += $CantFaltas;
					$tAtrasos += $CantAtrasos;
					$tLicencias += $CantLicencias;
					$tNotificacion += $CantNotificacion;
					$tNoContestan += $CantNoContestan;
					$tFelicitacion += $CantFelicitacion;
					$tTotal += $Total;
				?>
					<tr>
						<td class="der"><?php echo $i; ?></td>
						<td><?php echo capitalizar($al['Paterno']) ?></td>
						<td><?php echo capitalizar($al['Materno']) ?></td>
						<td><?php echo capitalizar($al['Nombres']) ?></td>
						<td class="centrar"><?php echo $CantObservaciones; ?></td>
						<td class="centrar"><?php echo $CantFaltas; ?></td>
						<td class="centrar"><?php echo $CantAtrasos; ?></td>
						<td class="centrar"><?php echo $CantLicencias; ?></td>
						<td class="centrar"><?php echo $CantNotificacion; ?></td>
						<td class="centrar"><?php echo $CantNoContestan; ?></td>
						<td class="centrar"><?php echo $CantFelicitacion; ?></td>
						<td class="centrar der"><?php echo $Total; ?></td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td class="resaltar der" colspan="4"><?php echo $idioma['Total'] ?>:</td>
					<td class="centrar"><?php echo $tObser; ?></td>
					<td class="centrar"><?php echo $tFaltas; ?></td>
					<td class="centrar"><?php echo $tAtrasos; ?></td>
					<td class="centrar"><?php echo $tLicencias; ?></td>
					<td class="centrar"><?php echo $tNotificacion; ?></td>
					<td class="centrar"><?php echo $tNoContestan; ?></td>
					<td class="centrar"><?php echo $tFelicitacion; ?></td>
					<td class="centrar der"><?php echo $tTotal; ?></td>
				</tr>
			</table>
		</div>
	</div>
<?php
}
?>