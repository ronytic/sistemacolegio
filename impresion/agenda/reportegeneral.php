<?php
include_once("../../login/check.php");
if (isset($_GET)) {
	$CodCurso = $_GET['CodCurso'];
	include_once("../pdf.php");
	include_once("../../class/alumno.php");
	include_once("../../class/curso.php");
	include_once("../../class/observaciones.php");
	include_once("../../class/agenda.php");
	$curso = new curso;
	$alumno = new alumno;
	$observaciones = new observaciones;
	$agenda = new agenda;
	$cur = $curso->mostrarCurso($CodCurso);
	$cur = array_shift($cur);

	$CodigosObservacionesG = $observaciones->agruparObservaciones();
	$CodigosObservaciones = [];
	foreach ($CodigosObservacionesG as $CodOb) {
		$CodigosObservaciones[$CodOb['NivelObservacion']] = explode(",", $CodOb['CodObservaciones']);
	}


	$titulo = $idioma["AgendaReporteGeneral"];
	class PDF extends PPDF
	{
		function Cabecera()
		{
			global $idioma, $cur;
			$this->CuadroCabecera(15, $idioma['Curso'] . ":", 35, $cur['Nombre']);
			$this->Pagina();
			$this->CuadroCabecera(10, sacarIniciales($idioma['Observaciones']) . "=", 30, $idioma['Observaciones']);
			$this->CuadroCabecera(10, sacarIniciales($idioma['Faltas']) . "=", 30, $idioma['Faltas']);
			$this->CuadroCabecera(10, sacarIniciales($idioma['Atrasos']) . "=", 30, $idioma['Atrasos']);
			$this->CuadroCabecera(10, sacarIniciales($idioma['Licencias']) . "=", 30, $idioma['Licencias']);
			$this->Ln();
			$this->CuadroCabecera(35, "", 50, "");
			$this->CuadroCabecera(10, sacarIniciales($idioma['NotificacionPadres']) . "=", 40, $idioma['NotificacionPadres']);


			$this->CuadroCabecera(10, sacarIniciales($idioma['NoRespondeTelf']) . "=", 40, $idioma['NoRespondeTelf']);
			$this->CuadroCabecera(10, sacarIniciales($idioma['Felicitaciones']) . "=", 40, $idioma['Felicitaciones']);
			$this->Ln();
			$this->TituloCabecera(10, "Nº");
			$this->TituloCabecera(30, $idioma["Paterno"]);
			$this->TituloCabecera(30, $idioma["Materno"]);
			$this->TituloCabecera(45, $idioma["Nombres"]);
			$this->TituloCabecera(15, sacarIniciales($idioma['Observaciones']));
			$this->TituloCabecera(15, sacarIniciales($idioma['Faltas']));
			$this->TituloCabecera(15, sacarIniciales($idioma['Atrasos']));
			$this->TituloCabecera(15, sacarIniciales($idioma['Licencias']));
			$this->TituloCabecera(15, sacarIniciales($idioma['NotificacionPadres']));
			$this->TituloCabecera(15, sacarIniciales($idioma['NoRespondeTelf']));
			$this->TituloCabecera(15, sacarIniciales($idioma['Felicitaciones']));
			$this->TituloCabecera(15, $idioma['Total']);
		}
	}

	$pdf = new PDF("L", "mm", "letter");
	$pdf->AddPage();
	$i = 0;
	$tObservaciones = 0;
	$tfaltas = 0;
	$tAtrasos = 0;
	$tLicencias = 0;
	$tNotificacionPadres = 0;
	$tNoRespondeTelf = 0;
	$tFelicitaciones = 0;
	$tTotal = 0;

	foreach ($alumno->mostrarAlumnosCurso($CodCurso) as $al) {
		$i++;
		/*Inicio Agenda*/
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
		/*Fin Agenda*/
		$tObservaciones += $CantObservaciones;
		$tfaltas += $CantFaltas;
		$tAtrasos += $CantAtrasos;
		$tLicencias += $CantLicencias;
		$tNotificacionPadres += $CantNotificacion;
		$tNoRespondeTelf += $CantNoContestan;
		$tFelicitaciones += $CantFelicitacion;
		$tTotal += $Total;


		if ($i % 2 == 0) {
			$relleno = 1;
		} else {
			$relleno = 0;
		}
		$pdf->CuadroCuerpo(10, $i, $relleno, "R");
		$pdf->CuadroNombreSeparado(30, $al['Paterno'], 30, $al['Materno'], 45, $al['Nombres'], 1, $relleno);
		$pdf->CuadroCuerpo(15, $CantObservaciones, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantFaltas, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantAtrasos, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantLicencias, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantNotificacion, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantNoContestan, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantFelicitacion, $relleno, "R", 1);
		$pdf->CuadroCuerpoResaltar(15, $Total, 1, "R", 1, 1);
		$pdf->Ln();
	}
	$pdf->Linea();
	$pdf->CuadroCuerpo(115, $idioma["Total"] . " " . $idioma["Curso"], 0, "R", 0);
	$pdf->CuadroCuerpo(15, $tObservaciones, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tfaltas, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tAtrasos, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tLicencias, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tNotificacionPadres, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tNoRespondeTelf, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tFelicitaciones, $relleno, "R", 1);
	$pdf->CuadroCuerpoResaltar(15, $tTotal, 1, "R", 1, 1);
	$pdf->Output($titulo . " " . $cur['Nombre'] . ".pdf", "I");
}
