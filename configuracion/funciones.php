<?php
function dato($Campo, $codificado = false)
{
	global $folder;
	include_once($folder . "class/config.php");
	$config = new config;
	$cnf = $config->mostrarConfig($Campo, 1);
	return htmlspecialchars($cnf);
}
