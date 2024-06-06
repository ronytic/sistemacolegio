<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	extract($_POST);

	$valores = [];

	if ((!empty($Pass)) || $Pass != "") {
		if ($_SESSION['Nivel'] == 3) {
			$valores = array_merge(array("Password" => "'$Pass'"), $valores);
			include_once("../../class/docente.php");
			$docente = new docente;
			$docente->actualizarDocente($valores, "CodDocente=" . $_SESSION['CodUsuarioLog']);
		}
		if ($_SESSION['Nivel'] == 6) {
			$valores = array_merge(array("PasswordP" => "'$Pass'"), $valores);
			include_once("../../class/alumno.php");
			$alumno = new alumno;
			$alumno->actualizarDatosAlumno($valores, $_SESSION['CodUsuarioLog']);
		}
		if ($_SESSION['Nivel'] == 7) {
			$valores = array_merge(array("Password" => "'$Pass'"), $valores);
			include_once("../../class/alumno.php");
			$alumno = new alumno;
			$alumno->actualizarDatosAlumno($valores, $_SESSION['CodUsuarioLog']);
		}
	}
	header("Location:index.php?s=1");
}
