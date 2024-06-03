<?php
include_once("../login/check.php");
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);
include_once("../class/alumno.php");
include_once("../class/tmp_alumno.php");
include_once("../class/cuota.php");
include_once("../class/documento.php");
include_once("../class/config.php");
include_once("../class/curso.php");

if (!empty($_POST)) {
	$folder = "../";
	$al = new alumno;
	$cuota = new cuota;
	$doc = new documento;
	$tmpalumno = new tmp_alumno;
	$conf = new config;
	$curso = new curso;
	if (isset($_POST['CodAlumno'])) {
		$CodAl = $_POST['CodAlumno'];
	}
	$Matricula = $_POST['Matricula'];
	$CodCurso = $_POST['Curso'];
	$Paterno = $_POST['Paterno'];
	$Materno = $_POST['Materno'];
	$Nombres = $_POST['Nombres'];
	$Sexo = $_POST['Sexo'];
	$LugarNac = $_POST['LugarNac'];
	$FechaNac = date("Y-m-d", strtotime($_POST['FechaNac']));
	$Ci = $_POST['Ci'];
	//	$CiExt=$_POST['CiExt'];
	$Zona = $_POST['Zona'];
	$Calle = $_POST['Calle'];
	$Numero = $_POST['Numero'];
	$TelefonoCasa = $_POST['TelefonoCasa'];
	$Celular = $_POST['Celular'];
	$CelularSMS = $_POST['CelularSMS'];
	$ActivarSMS = $_POST['ActivarSMS'];
	//
	$Procedencia = $_POST['Procedencia'];
	$Repitente = $_POST['Repitente'];
	$Traspaso = $_POST['Traspaso'];
	$Becado = $_POST['Becado'];
	$MontoBeca = $_POST['MontoBeca'];
	$PorcentajeBeca = $_POST['PorcentajeBeca'];
	$MontoPagar = $_POST['MontoPagar'];
	$Retirado = $_POST['Retirado'];
	$FechaRetiro = $_POST['FechaRetiro'];
	$Rude = $_POST['Rude'];
	$Observaciones = $_POST['Observaciones'];
	$ApellidosPadre = $_POST['ApellidosPadre'];
	$NombrePadre = $_POST['NombrePadre'];
	$CiPadre = $_POST['CiPadre'];
	$CiExtP = isset($_POST['CiExtP']) ? $_POST['CiExtP'] : '';
	$OcupPadre = $_POST['OcupPadre'];
	$CelularP = $_POST['CelularP'];
	$ApellidosMadre = $_POST['ApellidosMadre'];
	$NombreMadre = $_POST['NombreMadre'];
	$CiMadre = $_POST['CiMadre'];
	$CiExtM = isset($_POST['CiExtM']) ? $_POST['CiExtM'] : '';
	$OcupMadre = $_POST['OcupMadre'];
	$CelularM = $_POST['CelularM'];
	$Email = $_POST['Email'];
	$AccesoSistema = $_POST['AccesoSistema'];

	//
	$Nit = $_POST['Nit'];
	$FacturaA = $_POST['FacturaA'];
	//
	$CertificadoNac = (isset($_POST['CertificadoNac']) && $_POST['CertificadoNac'] != "") ? $_POST['CertificadoNac'] : "0";
	$LibretaEsc = (isset($_POST['LibretaEsc']) && $_POST['LibretaEsc'] != "") ? $_POST['LibretaEsc'] : "0";
	$LibretaVac = (isset($_POST['LibretaVac']) && $_POST['LibretaVac']) != "" ? $_POST['LibretaVac'] : "0";
	$CedulaId = (isset($_POST['CedulaId']) && $_POST['CedulaId'] != "") ? $_POST['CedulaId'] : "0";
	$CedulaIdP = (isset($_POST['CedulaIdP']) && $_POST['CedulaIdP'] != "") ? $_POST['CedulaIdP'] : "0";
	$CedulaIdM = (isset($_POST['CedulaIdM']) && $_POST['CedulaIdM'] != "") ? $_POST['CedulaIdM'] : "0";
	$ObservacionesDoc = $_POST['ObservacionesDoc'];
	$autoIncrement = $al->estadoTabla();
	$CodAlumno = $autoIncrement['Auto_increment'];
	$FechaInsc = date("Y-m-d");
	$HoraIns = date("H:i:s");
	//Obtenemos el Codigo de Barra
	$cnf = ($conf->mostrarConfig("CodBarra"));
	$CodBarra = trim($cnf['Valor']) . $CodAlumno;
	$CodUsuarioAlumno = trim(minuscula(quitarSimbolos($Paterno))) . $CodAlumno;

	//fecha de nacimiento debe ser su password
	$Password = date("jnY", strtotime($FechaNac));
	$PasswordP = date("jnY", strtotime($FechaNac));

	// $Password = rand(1000, 9999);
	// $PasswordP = rand(1000, 9999);
	// if ($CiPadre != "" && $CiMadre != "") {
	// 	// $UsuarioPadre = usuarioPadre($CiPadre, $CiMadre);
	// } else {
	// 	$UsuarioPadre = "";
	// }
	$UsuarioPadre = $Ci;

	$cur = $curso->mostrarCurso($CodCurso);
	$cur = array_shift($cur);
	$MontoGeneral = $cur['MontoCuota'];

	$valuesDoc = array(
		'CodDocumento' => 'Null',
		'CodAlumno' => $CodAlumno,
		'CertificadoNac' => $CertificadoNac,
		'LibretaEsc' => $LibretaEsc,
		'LibretaVac' => $LibretaVac,
		'CedulaId' => $CedulaId,
		'CedulaIdP' => $CedulaIdP,
		'CedulaIdM' => $CedulaIdM,
		'Observaciones' => "LOWER('$ObservacionesDoc')"
	);

	$valuesAl = array(
		'CodAlumno' => "$CodAlumno",
		'Paterno' => "LOWER('$Paterno')",
		'Materno' => "LOWER('$Materno')",
		'Nombres' => "LOWER('$Nombres')",
		'Sexo' => $Sexo,
		'LugarNac' => "LOWER('$LugarNac')",
		'FechaNac' => "'$FechaNac'",
		'Ci' => "'$Ci'",
		//				'CiExt'=>"'$CiExt'",
		'Zona' => "LOWER('$Zona')",
		'Calle' => "LOWER('$Calle')",
		'Numero' => "LOWER('$Numero')",
		'TelefonoCasa' => "'$TelefonoCasa'",
		'Celular' => "'$Celular'",
		'CelularSMS' => "'$CelularSMS'",
		'ActivarSMS' => "'$ActivarSMS'",
		'Procedencia' => "LOWER('$Procedencia')",
		'Repitente' => $Repitente,
		'Traspaso' => $Traspaso,
		'Becado' => $Becado,
		'MontoBeca' => $MontoBeca,
		'PorcentajeBeca' => $PorcentajeBeca,
		'Retirado' => $Retirado,
		'FechaRetiro' => "'$FechaRetiro'",
		'Rude' => "'$Rude'",
		'Observaciones' => "LOWER('$Observaciones')",
		'ApellidosPadre' => "LOWER('$ApellidosPadre')",
		'NombrePadre' => "LOWER('$NombrePadre')",
		'CiPadre' => "'$CiPadre'",
		'CiExtP' => "'$CiExtP'",
		'OcupPadre' => "LOWER('$OcupPadre')",
		'CelularP' => "'$CelularP'",
		'ApellidosMadre' => "LOWER('$ApellidosMadre')",
		'NombreMadre' => "LOWER('$NombreMadre')",
		'CiMadre' => "'$CiMadre'",
		'CiExtM' => "'$CiExtM'",
		'OcupMadre' => "LOWER('$OcupMadre')",
		'CelularM' => "'$CelularM'",
		'Email' => "LOWER('$Email')",
		'Nit' => "'$Nit'",
		'FacturaA' => "LOWER('$FacturaA')",
		'CodCurso' => $CodCurso,
		'FechaIns' => "'$FechaInsc'",
		'HoraIns' => "'$HoraIns'",
		'UsuarioAlumno' => "'$CodUsuarioAlumno'",
		'CodBarra' => "'$CodBarra'",
		'Password' => "'$Password'",
		'PasswordP' => "'$PasswordP'",
		'UsuarioPadre' => "'$UsuarioPadre'",
		'Activo' => 0,
		'AccesoSistema' => "'$AccesoSistema'",
	);

	$fechaCuota = date("Y-m-d H:i:s");
	for ($i = 1; $i <= 10; $i++) {
		if ($i == 1) {
			$valuesCuota = array(
				'CodCuota' => 'NULL',
				'CodAlumno' => $CodAlumno,
				'Numero' => $i,
				'MontoPagar' => $MontoGeneral,
				'Factura' => "''",
				'Cancelado' => 0,
				'Fecha' => "'$fechaCuota'",
				'Observaciones' => "''"
			);
		} else {
			$valuesCuota = array(
				'CodCuota' => 'NULL',
				'CodAlumno' => $CodAlumno,
				'Numero' => $i,
				'MontoPagar' => $MontoPagar,
				'Factura' => "''",
				'Cancelado' => 0,
				'Fecha' => "'$fechaCuota'",
				'Observaciones' => "''"
			);
		}
		//echo "<br>";
		//print_r($valuesCuota);
		$cuota->guardar($valuesCuota);
	}
	if ($NombreFoto = subirArchivo($_FILES['Foto'], "imagenes/alumnos/")) {
		$valuesAl = array_merge(array("Foto" => "'$NombreFoto'"), $valuesAl);
	}

	$al->insertarAlumno($valuesAl);
	$doc->guardarDocumento($valuesDoc);

	if (isset($CodAl)) {
		$tmpalumno->actualizarVisor($CodAl);
	}
	include_once("../class/tmpcola.php");
	$tmpcola = new tmpcola;
	$tmpcola->insertarRegistro(array("CodAlumno" => $CodAlumno, "Estado" => "'Espera'"));
	header("Location:../rude/esperarude/?CodAlumno=" . $CodAlumno);
}
