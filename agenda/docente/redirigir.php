<?php
include_once("../../login/check.php");
include_once("../../class/config.php");
$config = new config;
$cnf = array_shift($config->mostrarConfig("UrlInternet"));
$urlInternet = $cnf['Valor'];
$cnf = array_shift($config->mostrarConfig("DirectorioInternet"));
$directorioInternet = $cnf['Valor'];
header("Location:" . $urlInternet . $directorioInternet . "agenda/docente/");
