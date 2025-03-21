<?php
session_start();
$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . "../";
define("RAIZ", $dir);
include_once RAIZ . "configuracion.php";
include_once RAIZ . "rastreo/revisar.php";
if (!(isset($_SESSION["LoginSistemaColegio"]) && $_SESSION['LoginSistemaColegio'] == 1 && isset($_SESSION["Nivel"]) && $_SESSION["Nivel"] != "")) {
    include_once RAIZ . "funciones/url.php";
    $self =  $_SERVER['PHP_SELF'] == '/index.php' ? '/' : $_SERVER['PHP_SELF'];
    header("Location:" . url_base() . $directory . "login/?u=" . $self);
} else {
    $idiomaarchivo = $_SESSION['Idioma'] != "" ? $_SESSION['Idioma'] : "es";
    if (!file_exists(RAIZ . "idioma/" . $idiomaarchivo . ".php")) {
        $idiomaarchivo = "es";
    }

    include_once RAIZ . "idioma/" . $idiomaarchivo . ".php";

    include_once RAIZ . "funciones/funciones.php";
}
