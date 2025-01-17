<?php
include_once("bd.php");
class gestionanterior extends bd
{
    var $tabla = "gestionesanteriores";
    function mostrarGestionAnterior()
    {
        $tablaExistente = $this->verificarExistenciaTabla();
        if ($tablaExistente == null) {
            return array();
        }
        $this->campos = array("*");
        return $this->getRecords("Activo=1");
    }
}
