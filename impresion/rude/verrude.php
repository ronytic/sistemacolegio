<?php
include_once("../../login/check.php");
include_once("../fpdf/fpdf.php");
include_once("../../class/rude.php");
include_once("../../class/config.php");
include_once("../../class/alumno.php");
include_once("../../class/curso.php");
include_once("../../class/cursoarea.php");
$rude = new rude;
$alumno = new alumno;
$config = new config;
$curso = new curso;
$cursoarea = new cursoarea;
$al = $rude->mostrarTodoDatos($_GET['CodAlumno']);
$a = $alumno->mostrarTodoDatos($_GET['CodAlumno']);
$al = array_shift($al);
$a = array_shift($a);
$DistritoEducativo = $config->mostrarConfig("DistritoEducativo", 1);
$DistritoEscolar = $config->mostrarConfig("DistritoEscolar", 1);
$NombreUnidad = $config->mostrarConfig("NombreUnidad", 1);
$TipoUnidadEducativa = $config->mostrarConfig("TipoUnidadEducativa", 1);
$Sie = $config->mostrarConfig("Sie", 1);
$TurnoUnidad = $config->mostrarConfig("TurnoUnidad", 1);
$Localidad = $config->mostrarConfig("Localidad", 1);
function escribe($x, $y, $t, $tam = 12)
{
	global $pdf;
	$pdf->SetFont('Arial', '', $tam);
	$pdf->SetXY($x, $y);
	$pdf->Cell(5, 4, utf8_decode(mb_strtoupper($t, "utf8")), 0, 0, "C");
}

$pdf = new FPDF("P", "mm", array(216, 330));
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 0);

$pdf->SetFont('Arial', 'B', 12);
$pdf->AddPage();
$pdf->Image("../../imagenes/rude/rude2012.jpg", 0, 0, 216, 330);
//Codigo Sie

escribe(167.5, 29, $Sie[strlen($Sie) - 8]);
escribe(172, 29, $Sie[strlen($Sie) - 7]);
escribe(176.5, 29, $Sie[strlen($Sie) - 6]);
escribe(181, 29, $Sie[strlen($Sie) - 5]);
escribe(185.5, 29, $Sie[strlen($Sie) - 4]);
escribe(190, 29, $Sie[strlen($Sie) - 3]);
escribe(194.5, 29, $Sie[strlen($Sie) - 2]);
escribe(199, 29, $Sie[strlen($Sie) - 1]);

switch ($TipoUnidadEducativa) {
	case 'Privada': {
			escribe(75.2, 40.3, "x", 10);
		}
		break;
	case 'Convenio': {
			escribe(59.2, 40.3, "x", 10);
		}
		break;
	case 'Comunitaria': {
			escribe(38.2, 40.3, "x", 10);
		}
		break;
	case 'Publica': {
			escribe(18.2, 40.3, "x", 10);
		}
		break;
}

escribe(140, 40, mayuscula($NombreUnidad));
escribe(56, 46, $DistritoEducativo);
escribe(110, 46, mayuscula($DistritoEscolar));
escribe(70, 61.5, mayuscula($a['Paterno']));
escribe(70, 67, mayuscula($a['Materno']));
escribe(70, 73, mayuscula($a['Nombres']));

escribe(72, 82, mayuscula($al['PaisN'] ?? ''));
escribe(72, 88.5, mayuscula($a['LugarNac'] ?? ''));
escribe(72, 94.5, mayuscula($al['ProvinciaN'] ?? ''));
escribe(72, 100.5, mayuscula($al['LocalidadN'] ?? ''));

escribe(150, 61.5, $a['Rude']);
if (isset($al['Documento']) && $al['Documento'] != "") {
	escribe(178.4, 66.3, "x", 10);
} else {
	escribe(178.4, 66.3, "x", 10);
	// escribe(197.4, 66.3, "x", 10);
}
escribe(185, 71, $a['Ci'], 10);

escribe(129, 81.5, date('d', strtotime($a['FechaNac'] ?? '')));
escribe(140, 81.5, date('m', strtotime($a['FechaNac'] ?? '')));
escribe(157, 81.5, date('Y', strtotime($a['FechaNac'] ?? '')));

if (!$a['Sexo']) escribe(195.5, 80.5, "x", 10);
if ($a['Sexo']) escribe(195.5, 85, "x", 10);

escribe(130, 99, $al['CertOfi'] ?? '', 10);
escribe(153, 99, $al['CertLibro'] ?? '', 10);
escribe(177.5, 99, $al['CertPartida'] ?? '');
escribe(193, 99, $al['CertFolio'] ?? '');

escribe(50, 109, $al['CodigoSie'] ?? ''); //SIE
escribe(155, 109, $al['NombreUnidad'] ?? '', 10);
$cur = $curso->mostrarCurso($a['CodCurso']);
$cur = array_shift($cur);
$curarea = $cursoarea->mostrarArea($cur['CodCursoArea']);
$curarea = array_shift($curarea);
$cursoNombre = mayuscula($cur['Nombre'] ?? '');
//echo $curarea['Area'];
//echo ereg("^KINDER",mayuscula($cur['Nombre']));
if ((preg_match("/^PREKINDER/", $cursoNombre) || preg_match("/^I.*1/", $cursoNombre)) && $curarea['Area'] = 1) escribe(10, 125, "x", 10); //prekinder
if ((preg_match("/^KINDER/", $cursoNombre) || preg_match("/^I.*2/", $cursoNombre)) && $curarea['Area'] = 1) escribe(15, 125, "x", 10); //kinder

if (preg_match("/^1/", $cursoNombre) && $curarea['Area'] == 2) escribe(24.7, 125, "x", 10); //1
if (preg_match("/^2/", $cursoNombre) && $curarea['Area'] == 2) escribe(29.5, 125, "x", 10); //2
if (preg_match("/^3/", $cursoNombre) && $curarea['Area'] == 2) escribe(34, 125, "x", 10); //3
if (preg_match("/^4/", $cursoNombre) && $curarea['Area'] == 2) escribe(39, 125, "x", 10); //4
if (preg_match("/^5/", $cursoNombre) && $curarea['Area'] == 2) escribe(43.5, 125, "x", 10); //5
if (preg_match("/^6/", $cursoNombre) && $curarea['Area'] == 2) escribe(48.5, 125, "x", 10); //6
if (preg_match("/^1/", $cursoNombre) && $curarea['Area'] == 3) escribe(57, 125, "x", 10); //1
if (preg_match("/^2/", $cursoNombre) && $curarea['Area'] == 3) escribe(61.5, 125, "x", 10); //2
if (preg_match("/^3/", $cursoNombre) && $curarea['Area'] == 3) escribe(66.2, 125, "x", 10); //3
if (preg_match("/^4/", $cursoNombre) && $curarea['Area'] == 3) escribe(71, 125, "x", 10); //4
if (preg_match("/^5/", $cursoNombre) && $curarea['Area'] == 3) escribe(75.7, 125, "x", 10); //5
if (preg_match("/^6/", $cursoNombre) && $curarea['Area'] == 3) escribe(80.3, 125, "x", 10); //6

switch ($cur['Paralelo']) {
	case "A": {
			escribe(123.2, 127, "x", 10);
		}
		break;
	case "B": {
			escribe(128, 127, "x", 10);
		}
		break;
	case "C": {
			escribe(132.5, 127, "x", 10);
		}
		break;
	case "D": {
			escribe(137, 127, "x", 10);
		}
		break;
	case "E": {
			escribe(142, 127, "x", 10);
		}
		break;
	case "F": {
			escribe(146.2, 127, "x", 10);
		}
		break;
	case "G": {
			escribe(151, 127, "x", 10);
		}
		break;
	case "H": {
			escribe(155.8, 127, "x", 10);
		}
		break;
	case "I": {
			escribe(160.3, 127, "x", 10);
		}
		break;
	case "J": {
			escribe(164.5, 127, "x", 10);
		}
		break;
	case "K": {
			escribe(169, 127, "x", 10);
		}
		break;
	case "L": {
			escribe(173.5, 127, "x", 10);
		}
		break;
}

switch ($TurnoUnidad) {
	case 'Manana': {
			escribe(184.5, 125, "x", 10);
		}
		break;
	case 'Tarde': {
			escribe(191, 125, "x", 10);
		}
		break;
	case 'Noche': {
			escribe(197.5, 125, "x", 10);
		}
		break;
}

escribe(60, 140, $al['ProvinciaE'] ?? '');
escribe(60, 146, $al['MunicipioE'] ?? '');
escribe(60, 152, $al['ComunidadE'] ?? '');

escribe(160, 140, $a['Zona'] ?? '');
escribe(160, 146, $a['Calle'] ?? '');
escribe(192, 152, $a['Numero'] ?? '');
escribe(131, 152, $a['TelefonoCasa'] ?? '');


escribe(25, 176, $al['LenguaMater'] ?? '', 10);

if ($al['CastellanoI'] ?? false) escribe(25, 187.5, "CASTELLANO", 10);
if ($al['InglesI'] ?? false) escribe(25, 191.8, "INGLES", 10);
if ($al['AymaraI'] ?? false) escribe(25, 196.4, "AYMARA", 10);

switch ($al['PerteneceA'] ?? '') {
	case "QUECHUA": {
			escribe(107.3, 192, "x", 8); //Quechua
		}
		break;
	case "AYMARA": {
			escribe(61.5, 181, "x", 8); //Aymara
		}
		break;
	case "MESTIZO": {
			escribe(61.5, 173, "x", 8);
			escribe(119, 196.7, $al['PerteneceA'], 8);
		}
		break;
}




if ($al['CentroSalud'] ?? false) {
	escribe(189, 170, "x", 10); //centro salud Si
} else {
	escribe(198.5, 170, "x", 10); //centro salud No
}

if (isset($al['VecesCentro']) && $al['VecesCentro'] == "1a2") escribe(146, 177, "x", 10); //1a2
if (isset($al['VecesCentro']) && $al['VecesCentro'] == "3a5") escribe(163, 177, "x", 10); //3a5
if (isset($al['VecesCentro']) && $al['VecesCentro'] == "6a+") escribe(183, 177, "x", 10); //6a+
if (isset($al['VecesCentro']) && $al['VecesCentro'] == "ninguna") escribe(196, 177, "x", 10); //ninguna

if (isset($al['Discapacidad']) && $al['Discapacidad']) {
	escribe(154, 187, "x", 10); //no
	escribe(154, 189.8, "x", 10); //no
	escribe(154, 193, "x", 10); //no
} else {
	escribe(168, 187, "x", 10); //no
	escribe(168, 189.8, "x", 10); //no
	escribe(168, 193, "x", 10); //no
}
if (isset($al['AguaDomicilio']) && $al['AguaDomicilio']) {
	escribe(43.3, 208, "x", 10);
} else {
	escribe(43.3, 226, "x", 10);
}
if (isset($al['Electricidad']) && $al['Electricidad']) {
	escribe(36.5, 234.2, "x", 10);
} else {
	escribe(45, 234.2, "x", 10);
}
if (isset($al['Alcantarillado']) && $al['Alcantarillado']) {
	escribe(35.5, 243, "x", 10);
} else {
	escribe(35.5, 246, "x", 10);
}

switch ($al['Trabaja'] ?? '') {
	case 'NOTRABAJA': {
			escribe(112, 237, "x", 10);
		}
		break;
	case 'EMPLEADO': {
			escribe(112, 234, "x", 10);
		}
		break;
	case 'INDEPENDIENTE': {
			escribe(112, 234, "x", 10);
		}
		break;
	case 'DOMESTICOCASA': {
			escribe(112, 218, "x", 10);
		}
		break;
}

if (isset($al['Trabaja']) && $al['Trabaja'] == "NOTRABAJA") {
	escribe(86, 247, "NO TRABAJO", 10);
} else {
	escribe(86, 247, "MAS DE DOS DIAS", 10);
}
if (isset($al['Trabaja']) && $al['Trabaja'] == "NOTRABAJA") {
	escribe(89.3, 255.7, "x", 10);
} else {
	escribe(80.3, 255.7, "x", 10);
}

if (isset($al['InternetCasa']) && $al['InternetCasa']) {
	escribe(148, 212, "x", 10);
}
escribe(148, 215.5, "x", 10);
escribe(148, 219, "x", 10);

escribe(143.5, 243, "x", 10); //Frecuencia Internet

if (isset($al['Transporte']) && $al['Transporte'] == "APIE") escribe(194.2, 212, "x", 10);
if (isset($al['Transporte']) && $al['Transporte'] == "MINIBUS") escribe(194.2, 216, "x", 10);

switch ($al['TiempoLlegada'] ?? '') {
	case 'MenosMediaHora': {
			escribe(190.5, 243.5, "x", 10);
		}
		break; //
	case 'EntreMediaHoraYHora': {
			escribe(190.5, 247, "x", 10);
		}
		break; //
	case 'EntreDosHoras': {
			escribe(190.5, 250.5, "x", 10);
		}
		break; //
	case 'DosHorasOMas': {
			escribe(190.5, 254.2, "x", 10);
		}
		break; //
}

escribe(55, 270, $a['CiPadre'] ?? '', 10);
escribe(72, 274.2, $a['ApellidosPadre'] ?? '', 10);
escribe(72, 279, $a['NombrePadre'] ?? '', 10);
escribe(72, 283.5, $al['IdiomaP'] ?? '', 10);
escribe(72, 288, $a['OcupPadre'] ?? '', 10);
escribe(72, 292.2, $al['InstruccionP'] ?? '', 10);
escribe(72, 296, $al['ParentescoP'] ?? '', 10);

escribe(158, 270.8, $a['CiMadre'] ?? '', 10);
escribe(171, 275.3, $a['ApellidosMadre'] ?? '', 10);
escribe(171, 280, $a['NombreMadre'] ?? '', 10);
escribe(171, 284.5, $al['IdiomaM'] ?? '', 10);
escribe(171, 289, $a['OcupMadre'] ?? '', 10);
escribe(171, 293.5, $al['InstruccionM'] ?? '', 10);

escribe(27, 301.5, isset($Localidad[0]) ? $Localidad[0] : '', 10);
escribe(32, 301.5, isset($Localidad[1]) ? $Localidad[1] : '', 10);
escribe(36.5, 301.5, isset($Localidad[2]) ? $Localidad[2] : '', 10);
escribe(41, 301.5, isset($Localidad[3]) ? $Localidad[3] : '', 10);
escribe(45, 301.5, isset($Localidad[4]) ? $Localidad[4] : '', 10);
escribe(50, 301.5, isset($Localidad[5]) ? $Localidad[5] : '', 10);
escribe(54, 301.5, isset($Localidad[6]) ? $Localidad[6] : '', 10);
escribe(59, 301.5, isset($Localidad[7]) ? $Localidad[7] : '', 10);
escribe(63, 301.5, isset($Localidad[8]) ? $Localidad[8] : '', 10);
escribe(68, 301.5, isset($Localidad[9]) ? $Localidad[9] : '', 10);
escribe(72, 301.5, isset($Localidad[10]) ? $Localidad[10] : '', 10);
escribe(76, 301.5, isset($Localidad[11]) ? $Localidad[11] : '', 10);
escribe(81, 301.5, isset($Localidad[12]) ? $Localidad[12] : '', 10);


$dia = date("d", strtotime($a['FechaIns']));
$mes = date("m", strtotime($a['FechaIns']));
$anio = date("Y", strtotime($a['FechaIns']));
escribe(120.5, 302, $dia[0], 10); //E
escribe(125, 302, $dia[1], 10); //E

escribe(140, 302, $mes[0], 10); //E
escribe(144, 302, $mes[1], 10); //E

escribe(159, 302, $anio[0], 10); //E
escribe(164, 302, $anio[1], 10); //E
escribe(169, 302, $anio[2], 10); //E
escribe(173, 302, $anio[3], 10); //E

$pdf->Output("Registro del RUDE", "I");
