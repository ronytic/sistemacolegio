<?php
define("Config", 1);
include_once("bd.php");
class config extends bd
{
	var $tabla = "config";

	function mostrarConfig($Nombre, $Valor = 0)
	{
		$this->campos = array('*');
		$v = $this->getRecords("Nombre='$Nombre'");
		$v = array_shift($v);
		if (is_null($v)) {
			return null;
		}
		if ($Valor) {
			$Valor = $v['Valor'];
		} else {
			$Valor = $v;
		}

		if (in_array($Nombre, ['CodigoSeguimientoNotasDocente', 'CodigoSeguimientoSistema', 'CodigoAdicionalSistemaLogin'])) {
			return base64_decode($Valor);
		} else {
			return $Valor;
		}
	}

	function revisar($key, $valor)
	{
		$v = $this->mostrarConfig($key, 1);
		// if ($key == 'SFEToken') {
		// 	var_dump($v);
		// }
		if (is_null($v)) {
			$this->insertarConfig($key, $valor);
		} else {
			$this->actualizarConfig($valor, $key);
		}
	}

	function insertarConfig($Nombre, $Valor)
	{
		$datos = array();
		$datos['Nombre'] = "'" . $Nombre . "'";
		if (in_array($Nombre, ['CodigoSeguimientoNotasDocente', 'CodigoSeguimientoSistema', 'CodigoAdicionalSistemaLogin'])) {
			$datos['Valor'] = "'" . base64_encode($Valor) . "'";
		} else {
			$datos['Valor'] = "'" . $Valor . "'";
		}
		$this->insertRow($datos, 1);
	}

	function actualizarConfig($dato, $Nombre = "")
	{
		$datos = array();
		if (in_array($Nombre, ['CodigoSeguimientoNotasDocente', 'CodigoSeguimientoSistema', 'CodigoAdicionalSistemaLogin'])) {
			$datos['Valor'] = "'" . base64_encode($dato) . "'";
		} else {
			$datos['Valor'] = "'" . $dato . "'";
		}
		$this->updateRow($datos, "Nombre='$Nombre'");
	}
}
