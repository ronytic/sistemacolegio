<?php
include_once("../../login/check.php");
include_once("../../basededatos.php");
include_once("../../class/config.php");
set_time_limit(5 * 60);
//ini_set('max_execution_time',3000);
$config = new config;
$cnf = ($config->mostrarConfig("IpInternet"));
$IpInternet = $cnf['Valor'];
$cnf = ($config->mostrarConfig("PuertoInternet"));
$PuertoInternet = $cnf['Valor'];
$cnf = ($config->mostrarConfig("UsuarioInternet"));
$UsuarioInternet = $cnf['Valor'];
$cnf = ($config->mostrarConfig("ContrasenaInternet"));
$ContrasenaInternet = $cnf['Valor'];
$cnf = ($config->mostrarConfig("BaseDatosInternet"));
$BaseDatosInternet = $cnf['Valor'];

$local = mysqli_connect($host, $user, $pass, $database);
mysqli_query($local, "SET NAMES utf8");
$inter = mysqli_connect($IpInternet . ":" . $PuertoInternet, $UsuarioInternet, $ContrasenaInternet, $BaseDatosInternet);
mysqli_query($inter, "SET NAMES utf8");

$tablas = array("casilleros", "docentemateriacurso", "registronotas", "notascualitativa", "notascualitativabimestre", "tarea");
//$tablas=array("registronotas");
//$tablas=array("docentemateriacurso","casilleros");
foreach ($tablas as $tabla) {

	mysqli_query($local, "TRUNCATE TABLE $tabla");
	$consulta = "SELECT * FROM $tabla;";
	//echo $consulta;
	unset($respuesta);
	$respuesta = "";
	//echo "<h1>$consulta</h1>";
	$respuesta = mysqli_query($inter, $consulta)
		or die("No se pudo ejecutar la consulta: " . mysqli_error($inter));
	//echo "<h1>$consulta".mysql_num_rows($respuesta)."</h1>";
	$i = 0;
	/*while($reg=mysql_fetch_array($respuesta)){
		print_r($reg);
	}*/
	while ($fila = mysqli_fetch_array($respuesta)) {
		$i++;
		$columnas = array_keys($fila);
		foreach ($columnas as $columna) {
			if (gettype($fila[$columna]) == "NULL") {
				$values[] = "NULL";
			} else {
				$values[] = "'" . mysqli_real_escape_string($inter, $fila[$columna]) . "'";
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
			mysqli_query($local, $insert_into_query);
			//echo $insert_into_query."<br><br><br>";
			$insert_into_query = "";
		}
	}
	$insert_into_query .= ";";
	//echo $insert_into_query."<br>SEPARO!!!!<hr><br>";
	mysqli_query($local, $insert_into_query);
	$insert_into_query = "";
}
