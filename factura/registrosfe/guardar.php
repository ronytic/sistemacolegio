<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	extract($_POST);
	include_once("../../class/config.php");
	include_once("../../class/factura.php");
	include_once("../../class/cuota.php");
	include_once("../../class/alumno.php");
	include_once("../../class/facturadetalle.php");
	$config = new config;
	$factura = new factura;
	$facturadetalle = new facturadetalle;
	$cuota = new cuota;
	// $estado = $factura->statusTable();
	// $CodFactura = $estado['Auto_increment'];
	// $NumeroAutorizacion = $config->mostrarConfig("NumeroAutorizacion", 1);
	// $LlaveDosificacion = $config->mostrarConfig("LlaveDosificacion", 1);
	// $FechaLimiteEmision = $config->mostrarConfig("FechaLimiteEmision", 1);
	$alumno = new alumno;
	$al = $alumno->mostrarTodoDatos($CodAlumno);
	$al = array_shift($al);
	$SistemaFacturacion = $config->mostrarConfig("SistemaFacturacion", 1);
	if ($SistemaFacturacion == "SistemaFacturacionElectronica") {
		$SFECodPos = $config->mostrarConfig("SFECodPos", 1);
		$SFECodSucursal = $config->mostrarConfig("SFECodSucursal", 1);
		$SFETipoDeMoneda = $config->mostrarConfig("SFETipoDeMoneda", 1);
		$SFEActividades = $config->mostrarConfig("SFEActividades", 1);
		$SFEUnidadMedidaMensualidad = $config->mostrarConfig("SFEUnidadMedidaMensualidad", 1);
		$SFECodigoProductoSIN = $config->mostrarConfig("SFECodigoProductoSIN", 1);
		$SFECodigoProductoInterno = $config->mostrarConfig("SFECodigoProductoInterno", 1);
		$datosFactura = [
			'siat_number_branch' => $SFECodSucursal,
			'siat_code_pos' => $SFECodPos,
			'type_invoice' => 1, // Factura con Credito Fiscal

			'client_reason_social' => mb_strtoupper($NombreFactura),
			'client_document_type' => $TipoDocumento, // CI
			'client_nro_document' => $NumeroDocumento,
			'client_complement' => isset($NumeroDocumentoComplemento) ? $NumeroDocumentoComplemento : '',
			'client_code' => $CodAlumno,
			'client_email' => $Email,
			'client_cellphone' => (isset($al['CelularSMS']) && !empty($al['CelularSMS'])) ? $al['CelularSMS'] : '',
			'client_city' => 'La Paz',

			'siat_exception_code' => 0, // Código de Exception, colocar "1" en caso de que el NIT sea erroneo
			'siat_code_payment_method' => $MetodoPago,
			'number_card' => $NumeroTarjeta,
			'user_pos' =>  isset($_SESSION['CodUsuarioLog']) ? $_SESSION['CodUsuarioLog'] : 'SYSTEM',
			'siat_code_currency_type' => $SFETipoDeMoneda, // 'BOB' o 'USD'

			'name_student' => mb_strtoupper($al['Paterno'] . ' ' . $al['Materno'] . ' ' . $al['Nombres']),
			'billed_period' => convertirCuotaEnMes(isset($a['1']['Cuota']) ? $a['1']['Cuota'] : 1),
			'additional_discount' => 0,
			'gift_card' => (float)$MontoGiftCard > 0 ? $MontoGiftCard : 0,
		];
		$detalleFactura = [];
		foreach ($a as $fd) {
			$detalleFactura[] = [
				'code_product' => $SFECodigoProductoInterno,
				'siat_code_caeb' => $SFEActividades,
				'siat_code_product' => $SFECodigoProductoSIN,
				'siat_code_measurement_unit' => $SFEUnidadMedidaMensualidad,
				'description' => 'Cuota ' . $fd['Cuota'] . ", " . $fd['Nombre'],
				'quantity' => 1,
				'price_unit' => (float)$fd['ImporteCobrado'] > 0 ? $fd['ImporteCobrado'] : 0,
				'discount' => (float)$fd['Descuento'] > 0 ? $fd['Descuento'] : 0,
			];
		}
		$datosFactura['detail_invoice'] = $detalleFactura;
		// var_dump($_POST, $datosFactura);
	}
	// echo json_encode($datosFactura);
	//require sfeconexion.php
	require_once '../../factura/sfe/core.php';
	$coreSFE = new Core;
	$respuestaFactura = $coreSFE->sendInvoice('', $datosFactura);
	// var_dump($respuestaFactura);
	if ($respuestaFactura['status'] == true) {
		if ($respuestaFactura['data']['siat_code_description'] == "VALIDADA") {
			$CUF = $respuestaFactura['data']['cuf'];
			$UIDInvoice = $respuestaFactura['data']['uid_invoice'];
			$NumeroFactura = $respuestaFactura['data']['invoice_number'];
			$QrLink = $respuestaFactura['data']['qr_code'];
			$xml = $respuestaFactura['data']['xml'];
			$FechaEmision = $respuestaFactura['data']['date_emission'];
			$NumeroAutorizacion = $respuestaFactura['data']['siat_code_reception'];

			$respuestaFactura['data']['xml'] = base64_encode($xml);
			$ValoresFactura = array(
				// "CodFactura" => "'$CodFactura'",
				"FechaFactura" => "'" . fecha2Str($FechaEmision, 0) . "'",
				"NFactura" => "'" . trim($NumeroFactura) . "'",
				"NReferencia" => "''",
				"FacturaAlumno" => "'" . trim($FacturaAlumno) . "'",
				"CodAlumno" => "'$CodAlumno'",
				"Nit" => "'" . trim($NumeroDocumento) . "'",
				"Factura" => "'" . trim($NombreFactura) . "'",
				"TotalDescuento" => "'$TotalDescuento'",
				"TotalInteres" => "'$TotalInteres'",
				"TotalBs" => "'$TotalBs'",
				"Cancelado" => "'$Cancelado'",
				"MontoDevuelto" => "'$MontoDevuelto'",
				"Observacion" => "'$Observacion'",
				"Estado" => "'Valido'",
				"MontoCodigo" => "'0'",
				"NumeroAutorizacion" => "'$NumeroAutorizacion'",
				"LlaveDosificacion" => "'$CUF'",
				"CodigoControl" => "'$UIDInvoice'",
				"FechaLimiteEmision" => "''",
				"Tipo" => "'General'",

				"NitEmisor" => "''",
				"RazonSocialEmisor" => "''",
				"ActividadEconomica" => "''",
				"LeyendaPiePagina" => "''",
				"TipoFactura" => "'$SistemaFacturacion'",
				"ImagenFondo" => "'0'",
				'RequestSIN' => "'" . json_encode($datosFactura) . "'",
				'ResponseSIN' => "'" . json_encode($respuestaFactura) . "'",
				'QrLink' => "'" . $QrLink . "'",
			);
			$factura->insertarRegistro($ValoresFactura);
			$CodFactura = $factura->ultimo();
			foreach ($a as $fd) {
				if ($fd['CodCuota'] != "") {
					$ValoresFacturaDetalle = array(
						"CodFactura" => "'$CodFactura'",
						"CodAlumno" => "'" . $fd['CodAlumno'] . "'",
						"Nombre" => "'" . $fd['Nombre'] . "'",
						"CodCuota" => "'" . $fd['CodCuota'] . "'",
						"MontoCuota" => "'" . $fd['MontoCuota'] . "'",
						"ImporteCobrado" => "'" . $fd['ImporteCobrado'] . "'",
						"Interes" => "'" . $fd['Interes'] . "'",
						"Descuento" => "'" . $fd['Descuento'] . "'",
						"Total" => "'" . $fd['Total'] . "'",
						"Tipo" => "'General'"
					);
					/*echo "<pre>";
					print_r($ValoresFacturaDetalle);
					echo "</pre>";*/
					$facturadetalle->insertarRegistro($ValoresFacturaDetalle);
					switch ($fd['CodCuota']) {
						case "Todo": {
								for ($numcuo = 1; $numcuo <= 10; $numcuo++) {
									$cuo = $cuota->mostrarCuota($fd['CodAlumno'], $numcuo);
									$cuo = array_shift($cuo);
									$CodCuota = $cuo['CodCuota'];
									$Valor = 1;
									$Factura = trim($NumeroFactura);
									$Observaciones = "Facturado";
									$Fecha = fecha2Str($FechaEmision, 0);
									$Hora = date("H:i:s");
									$Fecha = $Fecha . " " . $Hora;
									$cuota->actualizar($CodCuota, $Valor, $Factura, $Observaciones, $Fecha);
								}
							}
							break;
						case "2a10": {
								for ($numcuo = 2; $numcuo <= 10; $numcuo++) {
									$cuo = $cuota->mostrarCuota($fd['CodAlumno'], $numcuo);
									$cuo = array_shift($cuo);
									$CodCuota = $cuo['CodCuota'];
									$Valor = 1;
									$Factura = trim($NumeroFactura);
									$Observaciones = "Facturado";
									$Fecha = fecha2Str($FechaEmision, 0);
									$Hora = date("H:i:s");
									$Fecha = $Fecha . " " . $Hora;
									$cuota->actualizar($CodCuota, $Valor, $Factura, $Observaciones, $Fecha);
								}
							}
							break;
						default: {
								/*Modificacion Cuota*/
								$CodCuota = $fd['CodCuota'];
								$Valor = 1;
								$Factura = trim($NumeroFactura);
								$Observaciones = "Facturado";
								$Fecha = fecha2Str($FechaEmision, 0);
								$Hora = date("H:i:s");
								$Fecha = $Fecha . " " . $Hora;
								$cuota->actualizar($CodCuota, $Valor, $Factura, $Observaciones, $Fecha);
							}
							break;
					}
					/*Fin de Modificacion Pago Cuota*/
				}
			}
			header("Location:ver.php?f=" . $CodFactura);
		} else {
			$mensaje = $respuestaFactura['message'];
			$tipo = "error";
			header("Location:ver.php?m=" . base64_encode($mensaje));
		}
	} else {
		$mensaje = $respuestaFactura['message'];
		$tipo = "error";
		// header("Location:ver.php?m=" . base64_encode($mensaje));
	}
	exit();


	foreach ($a as $fd) {
		if ($fd['CodCuota'] != "") {
			$ValoresFacturaDetalle = array(
				"CodFactura" => "'$CodFactura'",
				"CodAlumno" => "'" . $fd['CodAlumno'] . "'",
				"Nombre" => "'" . $fd['Nombre'] . "'",
				"CodCuota" => "'" . $fd['CodCuota'] . "'",
				"MontoCuota" => "'" . $fd['MontoCuota'] . "'",
				"ImporteCobrado" => "'" . $fd['ImporteCobrado'] . "'",
				"Interes" => "'" . $fd['Interes'] . "'",
				"Descuento" => "'" . $fd['Descuento'] . "'",
				"Total" => "'" . $fd['Total'] . "'",
				"Tipo" => "'General'"
			);
			/*echo "<pre>";
			print_r($ValoresFacturaDetalle);
			echo "</pre>";*/
			$facturadetalle->insertarRegistro($ValoresFacturaDetalle);
			switch ($fd['CodCuota']) {
				case "Todo": {
						for ($numcuo = 1; $numcuo <= 10; $numcuo++) {
							$cuo = $cuota->mostrarCuota($fd['CodAlumno'], $numcuo);
							$cuo = array_shift($cuo);
							$CodCuota = $cuo['CodCuota'];
							$Valor = 1;
							$Factura = trim($NFactura);
							$Observaciones = "Facturado";
							$Fecha = fecha2Str($FechaFactura, 0);
							$Hora = date("H:i:s");
							$Fecha = $Fecha . " " . $Hora;
							$cuota->actualizar($CodCuota, $Valor, $Factura, $Observaciones, $Fecha);
						}
					}
					break;
				case "2a10": {
						for ($numcuo = 2; $numcuo <= 10; $numcuo++) {
							$cuo = $cuota->mostrarCuota($fd['CodAlumno'], $numcuo);
							$cuo = array_shift($cuo);
							$CodCuota = $cuo['CodCuota'];
							$Valor = 1;
							$Factura = trim($NFactura);
							$Observaciones = "Facturado";
							$Fecha = fecha2Str($FechaFactura, 0);
							$Hora = date("H:i:s");
							$Fecha = $Fecha . " " . $Hora;
							$cuota->actualizar($CodCuota, $Valor, $Factura, $Observaciones, $Fecha);
						}
					}
					break;
				default: {
						/*Modificacion Cuota*/
						$CodCuota = $fd['CodCuota'];
						$Valor = 1;
						$Factura = trim($NFactura);
						$Observaciones = "Facturado";
						$Fecha = fecha2Str($FechaFactura, 0);
						$Hora = date("H:i:s");
						$Fecha = $Fecha . " " . $Hora;
						$cuota->actualizar($CodCuota, $Valor, $Factura, $Observaciones, $Fecha);
					}
					break;
			}
			/*Fin de Modificacion Pago Cuota*/
		}
	}
	$factura->insertarRegistro($ValoresFactura);
	//echo $TxtCodigoDeControl;
	header("Location:ver.php?f=" . $CodFactura);
}
//echo "HOla";
