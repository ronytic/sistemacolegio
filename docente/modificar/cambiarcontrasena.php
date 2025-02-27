<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	include_once("../../class/docente.php");
	$docente = new docente;
	extract($_POST);
	$doc = $docente->mostrarTodoDatosDocente($CodDocente);
	$doc = array_shift($doc);
	$contra = date("Y", strtotime($doc['FechaNac']));
	//$contra = mb_strtolower(generarPalabra(), "utf8");
	$valores = array("Password" => "'$contra'");

	if ($docente->actualizarRegistro($valores, "CodDocente=$CodDocente")) {
		echo $contra;
	} else {
		echo $idioma['NoseGuardo'];
	}
}
