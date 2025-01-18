<?php
include_once("../../login/check.php");
$CodAlumno = $_GET['CodAlumno'];
$Ruta = $_GET['Ruta'];
$Personalizado = $_GET['Personalizado'];
include_once("../../class/tmpcola.php");
$tmpcola = new tmpcola;
$tmpcola->actualizarRegistro(array("Estado" => "'Proceso'"), "CodAlumno=" . $CodAlumno);
if ($Personalizado == "1") {
    header("Location:" . $Ruta . "?CodAlumno=" . $CodAlumno);
} else {
    header("Location:" . $Ruta . "/index.php?CodAlumno=" . $CodAlumno);
}
