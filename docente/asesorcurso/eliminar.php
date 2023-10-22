<?php
include_once("../../login/check.php");
if (isset($_POST)) {
	$Cod = $_POST['Cod'];
	include_once("../../class/asesor.php");
	$asesor = new asesor;
	$asesor->eliminarRegistro("CodAsesor=" . $Cod);
}
