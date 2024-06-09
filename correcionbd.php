<?php
date_default_timezone_set("America/La_Paz");
set_time_limit(0);
ini_set('memory_limit', '-1');

require_once "basededatos.php";
$ln = mysqli_connect($host, $user, $pass, $database);
$tablas = false;
/* Se busca las tablas en la base de datos */
$tablas = array();
if (empty($tablas)) {
    $consulta = "SHOW TABLES FROM $database;";
    $respuesta = mysqli_query($ln, $consulta)
        or die("No se pudo ejecutar la consulta: " . mysqli_error($ln));
    while ($fila = mysqli_fetch_array($respuesta)) {
        // var_dump($fila);
        $tablas[] = $fila[0];
    }
}

foreach ($tablas as $tabla) {
    //     //Crear una consulta sq para cambiar el motor de la tabla a INNODB and cotejamiento es utf8mb4_spanish_ci
    $sql = "ALTER TABLE $tabla ENGINE = INNODB, COLLATE utf8mb4_spanish_ci;";
    echo $sql . "<br>";
    //     //Ejecutar la consulta
    // $respuesta = mysqli_query($ln, $sql)
    // or die("No se pudo ejecutar la consulta: " . mysqli_error($ln));
}

// Crear una consulta sql para relacionar la tabla cursoarea su id CodCursoArea con la tabla curso