<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	$Cod = $_POST['Cod'];
	$Valor = $_POST['Valor'];
	include_once("../../class/factura.php");
	$factura = new factura;
	$val = array("Estado" => "'$Valor'");
	$fac = $factura->mostrarFactura($Cod);
	$fac = array_shift($fac);
	if ($fac['TipoFactura'] == 'SistemaFacturacionElectronica') {
		require_once '../../factura/sfe/core.php';
		$core = new Core;
		$respuestaAnulacion = $core->annulmentInvoice('', $fac['CodigoControl']);
		if ($respuestaAnulacion['status'] === true) {
			$factura->actualizarRegistro($val, "CodFactura=$Cod");
		}
	} else {
		$factura->actualizarRegistro($val, "CodFactura=$Cod");
	}
}
