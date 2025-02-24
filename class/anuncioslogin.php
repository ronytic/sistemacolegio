<?php
include_once("bd.php");
class anuncioslogin extends bd
{
	var $tabla = "anuncioslogin";
	function mostrarAnuncios($Visible = null)
	{
		if ($Visible !== null) {
			$Visible = 'and Visible=' . $Visible;
		}
		$this->campos = array('*');
		return $this->getRecords("Activo=1 $Visible", 'FechaRegistro DESC');
	}
	function mostrarAnuncio($CodAnunciosLogin)
	{
		$this->campos = array('*');
		return $this->getRecords("CodAnunciosLogin=$CodAnunciosLogin and Activo=1");
	}
}
