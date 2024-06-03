<?php
include_once("../../login/check.php");
include_once("../../basededatos.php");
include_once("../../class/config.php");
set_time_limit(5 * 60);
//ini_set('max_execution_time',3000);
$config = new config;
$IpInternet = $config->mostrarConfig("IpInternet", 1);
$PuertoInternet = $config->mostrarConfig("PuertoInternet", 1);
$UsuarioInternet = $config->mostrarConfig("UsuarioInternet", 1);
$ContrasenaInternet = $config->mostrarConfig("ContrasenaInternet", 1);
$BaseDatosInternet = $config->mostrarConfig("BaseDatosInternet", 1);

$local = mysqli_connect($host, $user, $pass, $database);
mysqli_query($local, "SET NAMES utf8");
$inter = mysqli_connect($IpInternet . ":" . $PuertoInternet, $UsuarioInternet, $ContrasenaInternet, $BaseDatosInternet);
mysqli_query($inter, "SET NAMES utf8");
foreach ($tables_export as $tabla) {
	$consulta = "SELECT * FROM $tabla;";
	mysqli_query($inter, "TRUNCATE TABLE $tabla");
	$respuesta = mysqli_query($local, $consulta)
		or die("No se pudo ejecutar la consulta: " . mysqli_error($local));
	$i = 0;
	while ($fila = mysqli_fetch_array($respuesta)) {
		$i++;
		$columnas = array_keys($fila);
		foreach ($columnas as $columna) {
			if (gettype($fila[$columna]) == "NULL") {
				$values[] = "NULL";
			} else {
				$values[] = "'" . mysqli_real_escape_string($local, $fila[$columna]) . "'";
			}
		}

		if ($i == 1) {
			$insert_into_query .= "INSERT INTO `$tabla` VALUES (" . implode(", ", $values) . ")";
		} else {
			$insert_into_query .= ",(" . implode(", ", $values) . ")";
		}
		unset($values);
		if ($i == 400) {
			$i = 0;
			$insert_into_query .= ";";
			mysqli_query($inter, $insert_into_query);
			//echo $insert_into_query."<br><br><br>";
			$insert_into_query = "";
		}
	}
	$insert_into_query .= ";";
	mysqli_query($inter, $insert_into_query);
	$insert_into_query = "";
}
