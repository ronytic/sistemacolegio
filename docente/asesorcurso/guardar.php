<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	include_once("../../class/asesor.php");
	$asesor = new asesor;

	extract($_POST);
	if (count($asesor->mostrarTodoRegistro("CodDocente=$CodDocente and CodCurso=$CodCurso"))) {
		echo $idioma["YaAsignadoCurso"];
	} else {
		$valores = array(
			"CodDocente" => "'$CodDocente'",
			"CodCurso" => "'$CodCurso'",
			"Observacion" => "'$Observacion'",
		);
		$asesor->insertarRegistro($valores);
	}
}
