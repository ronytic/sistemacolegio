<?php
include_once("../../login/check.php");
if (!empty($_GET) && $_GET['lock'] == md5('lock')) {
	$titulo = $idioma['ReporteIndependienteAgenda'];

	$CodAlumno = $_SESSION['CodAl'];
	$CodMateria = isset($_GET['CodMateria']) ? $_GET['CodMateria'] : '';
	include_once("../../class/alumno.php");
	include_once("../../class/curso.php");
	include_once("../../class/agenda.php");
	include_once("../../class/observaciones.php");
	include_once("../../class/materias.php");
	include_once("../../class/config.php");

	$agenda = new agenda;
	$materia = new materias;
	$observaciones = new observaciones;
	$alumno = new alumno;
	$curso = new curso;
	$config = new config;
	$al = $alumno->mostrarTodoDatos($CodAlumno);
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

	$CodigosObservacionesG = $observaciones->agruparObservaciones();
	$CodigosObservaciones = [];
	foreach ($CodigosObservacionesG as $CodOb) {
		$CodigosObservaciones[$CodOb['NivelObservacion']] = explode(",", $CodOb['CodObservaciones']);
	}

	$TotalesAgenda = $agenda->CantidadTotalAgrupado($CodAlumno);

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
		$cnf = $config->mostrarConfig("InicioBimestre1");
		$fechaInicioBimestre1 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinBimestre1");
		$fechaFinBimestre1 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("InicioBimestre2");
		$fechaInicioBimestre2 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinBimestre2");
		$fechaFinBimestre2 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("InicioBimestre3");
		$fechaInicioBimestre3 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinBimestre3");
		$fechaFinBimestre3 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("InicioBimestre4");
		$fechaInicioBimestre4 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinBimestre4");
		$fechaFinBimestre4 = $cnf['Valor'];
	} else {
		$cnf = $config->mostrarConfig("InicioTrimestre1");
		$fechaInicioTrimestre1 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinTrimestre1");
		$fechaFinTrimestre1 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("InicioTrimestre2");
		$fechaInicioTrimestre2 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinTrimestre2");
		$fechaFinTrimestre2 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("InicioTrimestre3");
		$fechaInicioTrimestre3 = $cnf['Valor'];
		$cnf = $config->mostrarConfig("FinTrimestre3");
		$fechaFinTrimestre3 = $cnf['Valor'];
	}
	/*Fin de Sacando Información de Trimestre*/

	if (isset($_GET['CodMateria'])) {
		$CodMateria = $_GET['CodMateria'];
		$mat = $materia->mostrarMateria($CodMateria);
		$mat = array_shift($mat);
		$ag = $agenda->mostrarRegistroMateriaAlumno(0, $al['CodCurso'], $CodMateria, $CodAlumno);
	} else {
		$ag = $agenda->mostrarRegistros($CodAlumno);
	}

	$ima = "../../imagenes/alumnos/" . $al['Foto'];
	if (!file_exists($ima) || empty($al['Foto'])) {
		$ima = "../../imagenes/alumnos/0.jpg";
	}
	include_once("../pdf.php");
	class PDF extends PPDF
	{
		function Cabecera()
		{
			$this->Pagina();
			$this->ln();
		}
	}
	$relleno = 0;
	$pdf = new PDF("P", "mm", "letter"); //612,792
	$pdf->AddPage();
	$borde = 0;
	$pdf->Image($ima, 164, 60, 30, 30);
	$pdf->CuadroCuerpoPersonalizado(176, $idioma["DatosPersonales"], 1, "", 0, "B");
	$pdf->Ln();
	$pdf->Ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Nombre"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroNombre(100, $al['Paterno'], $al['Materno'], $al['Nombres'], 1, $relleno);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Sexo"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, $al['Sexo'] ? $idioma['Masculino'] : $idioma['Femenino'], 0, "", $borde);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Curso"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, $cur['Nombre'], 0, "", $borde);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Direccion"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, capitalizar($al['Zona'] . " " . $al['Calle'] . " " . $al['Numero']), 0, "", $borde);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["TelefonoCasa"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, $al['TelefonoCasa'], 0, "", $borde);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Celular"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, $al['Celular'], 0, "", $borde);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["CelularPadre"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, $al['CelularP'], 0, "", $borde);
	$pdf->ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["CelularMadre"] . ": ", 0, "L", $borde, "B");
	$pdf->CuadroCuerpo(100, $al['CelularM'], 0, "", $borde);
	if (isset($mat)) {
		$pdf->ln();
		$pdf->CuadroCuerpoPersonalizado(40, $idioma["SoloMateria"] . ": ", 0, "L", $borde, "B");
		$pdf->CuadroCuerpo(100, $mat['Nombre'], 0, "", $borde);
	}

	$pdf->Ln();
	$pdf->Ln();
	$pdf->CuadroCuerpoPersonalizado(176, $idioma["Estadistica"], 1, "", 0, "B");
	$pdf->ln();
	$pdf->Ln();
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Observaciones"] . " ", 0, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Felicitaciones"] . " ", 0, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Faltas"] . " ", 0, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Atrasos"] . " ", 0, "C", 1, "B");
	$pdf->ln();
	$pdf->CuadroCuerpo(40, $CantObservaciones, 0, "C", $borde);
	$pdf->CuadroCuerpo(40, $CantFelicitacion, 0, "C", $borde);
	$pdf->CuadroCuerpo(40, $CantFaltas, 0, "C", $borde);
	$pdf->CuadroCuerpo(40, $CantAtrasos, 0, "C", $borde);

	$pdf->ln();

	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Licencias"] . " ", 0, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(50, $idioma["NotificacionPadres"] . " ", 0, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(50, $idioma["NoRespondeTelf"] . " ", 0, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(35, $idioma["Total"] . " ", 0, "C", 1, "B");
	$pdf->ln();

	$pdf->CuadroCuerpo(40, $CantLicencias, 0, "C", $borde);
	$pdf->CuadroCuerpo(50, $CantNotificacion, 0, "C", $borde);
	$pdf->CuadroCuerpo(50, $CantNoContestan, 0, "C", $borde);
	$pdf->CuadroCuerpo(35, $Total, 0, "C", $borde);

	$pdf->Ln();
	$pdf->Ln();
	$pdf->CuadroCuerpoPersonalizado(176, $idioma["RegistroAgenda"], 1, "", 0, "B");
	$pdf->ln();
	$pdf->Ln();
	$pdf->CuadroCuerpoPersonalizado(8, "N", 1, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(50, $idioma["Materia"], 1, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(40, $idioma["Observacion"], 1, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(50, $idioma["Detalle"], 1, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(20, $idioma["Fecha"], 1, "C", 1, "B");
	$pdf->CuadroCuerpoPersonalizado(10, recortartexto($idioma["Periodo"], 5, ""), 1, "C", 1, "B");
	$pdf->Ln();
	$i = 0;
	foreach ($ag as $a) {
		$i++;
		$tipo = "";
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
		$importante = "";
		if ($a['Resaltar']) {
			$importante = " - I";
		}
		// $m = $materia->mostrarMateria($a['CodMateria']);
		// $m = array_shift($m);
		// $o = $observaciones->mostrarObser($a['CodObservacion']);
		// $o = array_shift($o);
		$pdf->CuadroCuerpo(8, $i, 0, "R", 1, 9, "");
		$pdf->CuadroCuerpo(50, $TodoMaterias[$a['CodMateria']] ?? '', 0, "L", 1, 8, "");
		$pdf->CuadroCuerpo(40, recortartexto($TodoObservaciones[$a['CodObservacion']] ?? '', 23), 0, "L", 1, 9, "");
		$pdf->CuadroCuerpo(50, recortartexto(minuscula($a["Detalle"]), 33), 0, "L", 1, 8, "");
		$pdf->CuadroCuerpo(20, fecha2Str($a["Fecha"]), 0, "C", 1, 9, "");
		$pdf->CuadroCuerpo(10, sacariniciales($mensaje) . $importante, 0, "L", 1, 9, "");
		$pdf->Ln();
	}
	$pdf->Output($titulo . " " . capitalizar($al['Paterno'] . " " . $al['Materno'] . " " . $al['Nombres']), "I");
}
