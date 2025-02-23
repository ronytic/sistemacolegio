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
	$titulo = $idioma["ReporteFaltaAtrasos"];
	class PDF extends PPDF
	{
		function Cabecera()
		{
			global $idioma, $cur;
			$this->CuadroCabecera(15, $idioma['Curso'] . ":", 35, $cur['Nombre']);
			$this->Pagina();

			$this->CuadroCabecera(10, sacarIniciales($idioma['Faltas']) . "=", 20, $idioma['Faltas']);
			$this->CuadroCabecera(10, sacarIniciales($idioma['Atrasos']) . "=", 25, $idioma['Atrasos']);
			$this->CuadroCabecera(10, sacarIniciales($idioma['Licencias']) . "=", 25, $idioma['Licencias']);


			$this->Ln();
			$this->TituloCabecera(10, "Nº");
			$this->TituloCabecera(30, $idioma["Paterno"]);
			$this->TituloCabecera(30, $idioma["Materno"]);
			$this->TituloCabecera(45, $idioma["Nombres"]);

			$this->TituloCabecera(15, sacarIniciales($idioma['Faltas']));
			$this->TituloCabecera(15, sacarIniciales($idioma['Atrasos']));
			$this->TituloCabecera(15, sacarIniciales($idioma['Licencias']));

			$this->TituloCabecera(15, $idioma['Total']);
		}
	}

	$pdf = new PDF("P", "mm", "letter");
	$pdf->AddPage();
	$i = 0;

	$CodigosObservaciones = [];
	foreach ($observaciones->agruparObservaciones() as $CodOb) {
		$CodigosObservaciones[$CodOb['NivelObservacion']] = explode(",", $CodOb['CodObservaciones']);
	}

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

		$CantFaltas = 0;
		$CantAtrasos = 0;
		$CantLicencias = 0;
		$TotalesAgenda = $agenda->CantidadTotalAgrupado($CodAl);
		foreach ($TotalesAgenda as $TotAgenda) {
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
		}


		$Total = $CantFaltas + $CantAtrasos + $CantLicencias;
		/*Fin Agenda*/

		$tfaltas += $CantFaltas;
		$tAtrasos += $CantAtrasos;
		$tLicencias += $CantLicencias;

		$tTotal += $Total;


		if ($i % 2 == 0) {
			$relleno = 1;
		} else {
			$relleno = 0;
		}
		$pdf->CuadroCuerpo(10, $i, $relleno, "R");
		$pdf->CuadroNombreSeparado(30, $al['Paterno'], 30, $al['Materno'], 45, $al['Nombres'], 1, $relleno);

		$pdf->CuadroCuerpo(15, $CantFaltas, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantAtrasos, $relleno, "R", 1);
		$pdf->CuadroCuerpo(15, $CantLicencias, $relleno, "R", 1);

		$pdf->CuadroCuerpoResaltar(15, $Total, 1, "R", 1, 1);
		$pdf->Ln();
	}
	$pdf->Linea();
	$pdf->CuadroCuerpo(115, $idioma["Total"] . " " . $idioma['Del'] . " " . $idioma["Curso"], 0, "R", 0);

	$pdf->CuadroCuerpo(15, $tfaltas, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tAtrasos, $relleno, "R", 1);
	$pdf->CuadroCuerpo(15, $tLicencias, $relleno, "R", 1);
	$pdf->CuadroCuerpoResaltar(15, $tTotal, 1, "R", 1, 1);
	$pdf->Output($titulo . " " . $cur['Nombre'] . ".pdf", "I");
}
