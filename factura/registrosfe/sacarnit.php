<?php
include_once("../../login/check.php");
if (!empty($_POST['CodAlumno'])) {
	include_once("../../class/alumno.php");
	$alumno = new alumno;
	$CodAlumno = $_POST['CodAlumno'];
	$al = $alumno->mostrarTodoDatos($CodAlumno);
	$al = array_shift($al);
	$nombres = capitalizar($al['Paterno']) . " " . capitalizar($al['Materno']) . " " . capitalizar($al['Nombres']);
	$valores = array(
		"Alumno" => $nombres,
		"NumeroDocumento" => $al['Nit'],
		"FacturaA" => $al['FacturaA'],
		"Email" => $al['Email'],
	);

	echo json_encode($valores);
}
