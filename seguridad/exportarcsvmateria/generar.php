<?php
include_once("../../login/check.php");
if (!empty($_GET)) {
	extract($_GET);
	include_once("../../csv/csv.php");
	include_once("../../class/alumno.php");
	include_once("../../class/cursomateriaexportar.php");
	include_once("../../class/registronotas.php");
	include_once("../../class/casilleros.php");

	include_once("../../class/config.php");
	include_once("../../class/agenda.php");
	include_once("../../class/curso.php");
	$config = new config;
	$agenda = new agenda;
	$curso = new curso;

	$cur = $curso->mostrarCurso($CodCurso);
	$cur = array_shift($cur);

	if ($cur['Bimestre']) {
		$InicioBimestre1 = $config->mostrarConfig("InicioBimestre1", 1);
		$FinBimestre1 = $config->mostrarConfig("FinBimestre1", 1);
		$InicioBimestre2 = $config->mostrarConfig("InicioBimestre2", 1);
		$FinBimestre2 = $config->mostrarConfig("FinBimestre2", 1);
		$InicioBimestre3 = $config->mostrarConfig("InicioBimestre3", 1);
		$FinBimestre3 = $config->mostrarConfig("FinBimestre3", 1);
		$InicioBimestre4 = $config->mostrarConfig("InicioBimestre4", 1);
		$FinBimestre4 = $config->mostrarConfig("FinBimestre4", 1);
	} else {
		$InicioTrimestre1 = ($config->mostrarConfig("InicioTrimestre1", 1));
		$FinTrimestre1 = ($config->mostrarConfig("FinTrimestre1", 1));
		$InicioTrimestre2 = ($config->mostrarConfig("InicioTrimestre2", 1));
		$FinTrimestre2 = ($config->mostrarConfig("FinTrimestre2", 1));
		$InicioTrimestre3 = ($config->mostrarConfig("InicioTrimestre3", 1));
		$FinTrimestre3 = ($config->mostrarConfig("FinTrimestre3", 1));
	}
	$alumno = new alumno;
	$casilleros = new casilleros;
	$registronotas = new registronotas;
	$cursomateriaexportar = new cursomateriaexportar;

	$fila = array();
	if ($Numeracion == "si") {
		if ($Cabecera == "si")
			$fila[] = "N";
	}
	if ($Cabecera == "si")
		$fila[] = $idioma["Apellidos"] . " " . $idioma["Nombres"];

	if ($Trimestre == "todo") {
		$cas1 = $casilleros->mostrarMateriaCursoTrimestre($Materias, $CodCurso, 1);
		$cas1 = array_shift($cas1);
		$cas2 = $casilleros->mostrarMateriaCursoTrimestre($Materias, $CodCurso, 2);
		$cas2 = array_shift($cas2);
		$cas3 = $casilleros->mostrarMateriaCursoTrimestre($Materias, $CodCurso, 3);
		$cas3 = array_shift($cas3);
		$cas4 = $casilleros->mostrarMateriaCursoTrimestre($Materias, $CodCurso, 4);
		$cas4 = array_shift($cas4);
		if ($Cabecera == "si") {
			if ($cur['Bimestre']) {
				$fila[] = "N1";
				$fila[] = "N2";
				$fila[] = "N3";
				$fila[] = "N4";
				$fila[] = "Dias Trab-1";
				$fila[] = "Falta C/Lic-1";
				$fila[] = "Falta S/Lic-1";
				$fila[] = "Atrasos-1";
				$fila[] = "Dias Trab-2";
				$fila[] = "Falta C/Lic-2";
				$fila[] = "Falta S/Lic-2";
				$fila[] = "Atrasos-2";
				$fila[] = "Dias Trab-3";
				$fila[] = "Falta C/Lic-3";
				$fila[] = "Falta S/Lic-3";
				$fila[] = "Atrasos-3";
				$fila[] = "Dias Trab-4";
				$fila[] = "Falta C/Lic-4";
				$fila[] = "Falta S/Lic-4";
				$fila[] = "Atrasos-4";
			} else {
				$fila[] = "N1";
				if ($cur['Dps']) {
					$fila[] = "Dps1";
				}
				$fila[] = "N2";
				if ($cur['Dps']) {
					$fila[] = "Dps2";
				}
				$fila[] = "N3";
				if ($cur['Dps']) {
					$fila[] = "Dps3";
				}
				$fila[] = "Ref";
				$fila[] = "Dias Trab-1";
				$fila[] = "Falta C/Lic-1";
				$fila[] = "Falta S/Lic-1";
				$fila[] = "Atrasos-1";
				$fila[] = "Dias Trab-2";
				$fila[] = "Falta C/Lic-2";
				$fila[] = "Falta S/Lic-2";
				$fila[] = "Atrasos-2";
				$fila[] = "Dias Trab-3";
				$fila[] = "Falta C/Lic-3";
				$fila[] = "Falta S/Lic-3";
				$fila[] = "Atrasos-3";
			}
		}
	} else {
		$cas = $casilleros->mostrarMateriaCursoTrimestre($Materias, $CodCurso, $Trimestre);
		$cas = array_shift($cas);
		if ($Cabecera == "si") {
			$fila[] = "N" . $Trimestre;
			if ($cur['Dps']) {
				$fila[] = "Dps" . $Trimestre;
			}
			/*$fila[]="Dias Trabajados";
			$fila[]="Falta C/Lic";
			$fila[]="Falta S/Lic";
			$fila[]="Atrasos";*/
		}
	}
	$datos = array();
	if ($Cabecera == "si") {
		array_push($datos, $fila);
	}
	$i = 0;
	foreach ($alumno->mostrarDatosAlumnos($CodCurso) as $al) {
		$i++;
		$fila = array();
		if ($Numeracion == "si") {
			$fila[] = $i;
		}

		$fila[] = ucwords($al['Paterno']) . " " . ucwords($al['Materno']) . " " . ucwords($al['Nombres']);
		if ($Trimestre == "todo") {
			/**/
			if ($cur['Bimestre']) {
				$faltasConLic1 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioBimestre1, $FinBimestre1));
				$faltasSinLic1 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioBimestre1, $FinBimestre1));
				$Atrasos1 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioBimestre1, $FinBimestre1));

				$faltasConLic2 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioBimestre2, $FinBimestre2));
				$faltasSinLic2 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioBimestre2, $FinBimestre2));
				$Atrasos2 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioBimestre2, $FinBimestre2));

				$faltasConLic3 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioBimestre3, $FinBimestre3));
				$faltasSinLic3 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioBimestre3, $FinBimestre3));
				$Atrasos3 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioBimestre3, $FinBimestre3));

				$faltasConLic4 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioBimestre4, $FinBimestre4));
				$faltasSinLic4 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioBimestre4, $FinBimestre4));
				$Atrasos4 = array_shift($agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioBimestre4, $FinBimestre4));
				/**/
				$r1 = array_shift($registronotas->mostrarRegistroNotas($cas1['CodCasilleros'], $al['CodAlumno'], 1));
				$r2 = array_shift($registronotas->mostrarRegistroNotas($cas2['CodCasilleros'], $al['CodAlumno'], 2));
				$r3 = array_shift($registronotas->mostrarRegistroNotas($cas3['CodCasilleros'], $al['CodAlumno'], 3));
				$r4 = array_shift($registronotas->mostrarRegistroNotas($cas4['CodCasilleros'], $al['CodAlumno'], 4));
				//$promedioAnual=number_format(($r1['NotaFinal']+$r2['NotaFinal']+$r3['NotaFinal'])/3,0);
				/*$fila[]="N1";
				$fila[]="N2";
				$fila[]="N3";
				$fila[]="N4";
				$fila[]="Dias Trab-1";
				$fila[]="Falta C/Lic-1";
				$fila[]="Falta S/Lic-1";
				$fila[]="Atrasos-1";
				$fila[]="Dias Trab-2";
				$fila[]="Falta C/Lic-2";
				$fila[]="Falta S/Lic-2";
				$fila[]="Atrasos-2";
				$fila[]="Dias Trab-3";
				$fila[]="Falta C/Lic-3";
				$fila[]="Falta S/Lic-3";
				$fila[]="Atrasos-3";
				$fila[]="Dias Trab-4";
				$fila[]="Falta C/Lic-4";
				$fila[]="Falta S/Lic-4";
				$fila[]="Atrasos-4";*/

				$fila[] = $r1['Resultado'];
				$fila[] = $r2['Resultado'];
				$fila[] = $r3['Resultado'];
				$fila[] = $r4['Resultado'];
				$fila[] = "68";
				$fila[] = $faltasConLic1['Cantidad'];
				$fila[] = $faltasSinLic1['Cantidad'];
				$fila[] = $Atrasos1['Cantidad'];
				$fila[] = "64";
				$fila[] = $faltasConLic2['Cantidad'];
				$fila[] = $faltasSinLic2['Cantidad'];
				$fila[] = $Atrasos2['Cantidad'];
				$fila[] = "68";
				$fila[] = $faltasConLic3['Cantidad'];
				$fila[] = $faltasSinLic3['Cantidad'];
				$fila[] = $Atrasos3['Cantidad'];
				$fila[] = "68";
				$fila[] = $faltasConLic4['Cantidad'];
				$fila[] = $faltasSinLic4['Cantidad'];
				$fila[] = $Atrasos4['Cantidad'];
			} else {
				$faltasConLic1 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioTrimestre1, $FinTrimestre1);
				$faltasConLic1 = array_shift($faltasConLic1);
				$faltasSinLic1 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioTrimestre1, $FinTrimestre1);
				$faltasSinLic1 = array_shift($faltasSinLic1);
				$Atrasos1 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioTrimestre1, $FinTrimestre1);
				$Atrasos1 = array_shift($Atrasos1);

				$faltasConLic2 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioTrimestre2, $FinTrimestre2);
				$faltasConLic2 = array_shift($faltasConLic2);
				$faltasSinLic2 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioTrimestre2, $FinTrimestre2);
				$faltasSinLic2 = array_shift($faltasSinLic2);
				$Atrasos2 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioTrimestre2, $FinTrimestre2);
				$Atrasos2 = array_shift($Atrasos2);
				$faltasConLic3 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 14, $al['CodAlumno'], $InicioTrimestre3, $FinTrimestre3);
				$faltasConLic3 = array_shift($faltasConLic3);
				$faltasSinLic3 = $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 12, $al['CodAlumno'], $InicioTrimestre3, $FinTrimestre3);
				$faltasSinLic3 = array_shift($faltasSinLic3);
				$Atrasos3 =  $agenda->mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, 11, $al['CodAlumno'], $InicioTrimestre3, $FinTrimestre3);
				$Atrasos3 = array_shift($Atrasos3);

				/**/
				if (is_null($cas1)) {
					$cas1['CodCasilleros'] = 0;
				}
				$r1 = $registronotas->mostrarRegistroNotas($cas1['CodCasilleros'], $al['CodAlumno'], 1);
				$r1 = array_shift($r1);
				if (is_null($cas2)) {
					$cas2['CodCasilleros'] = 0;
				}

				if (is_null($cas3)) {
					$cas3['CodCasilleros'] = 0;
				}

				if (is_null($cas4)) {
					$cas4['CodCasilleros'] = 0;
				}
				$r2 = $registronotas->mostrarRegistroNotas($cas2['CodCasilleros'], $al['CodAlumno'], 2);
				$r2 = array_shift($r2);
				$r3 = $registronotas->mostrarRegistroNotas($cas3['CodCasilleros'], $al['CodAlumno'], 3);
				$r3 = array_shift($r3);
				$r4 = $registronotas->mostrarRegistroNotas($cas4['CodCasilleros'], $al['CodAlumno'], 4);
				$r4 = array_shift($r4);
				//$promedioAnual=number_format(($r1['NotaFinal']+$r2['NotaFinal']+$r3['NotaFinal'])/3,0);
				$fila[] = $r1['Resultado'] ?? 0;
				if ($cur['Dps']) {
					$fila[] = $r1['Dps'] ?? 0;
				}
				$fila[] = $r2['Resultado'] ?? 0;
				if ($cur['Dps']) {
					$fila[] = $r2['Dps'] ?? 0;
				}
				$fila[] = $r3['Resultado'] ?? 0;
				if ($cur['Dps']) {
					$fila[] = $r3['Dps'] ?? 0;
				}
				$fila[] = $r4['Nota2'] ?? 0;
				$fila[] = "68";
				$fila[] = $faltasConLic1['Cantidad'] ?? 0;
				$fila[] = $faltasSinLic1['Cantidad'] ?? 0;
				$fila[] = $Atrasos1['Cantidad'] ?? 0;
				$fila[] = "64";
				$fila[] = $faltasConLic2['Cantidad'] ?? 0;
				$fila[] = $faltasSinLic2['Cantidad'] ?? 0;
				$fila[] = $Atrasos2['Cantidad'] ?? 0;
				$fila[] = "68";
				$fila[] = $faltasConLic3['Cantidad'] ?? 0;
				$fila[] = $faltasSinLic3['Cantidad'] ?? 0;
				$fila[] = $Atrasos3['Cantidad'] ?? 0;
			}
		} else {
			$r = $registronotas->mostrarRegistroNotas($cas['CodCasilleros'], $al['CodAlumno'], $Trimestre);
			$r = array_shift($r);
			$fila[] = $r['NotaFinal'];
			if ($cur['Dps']) {
				$fila[] = $r['Dps'];
			}
		}

		array_push($datos, $fila);
	}


	archivocsv("reporte.csv", $datos, $Separador, stripslashes($SeparadorFila));
}
