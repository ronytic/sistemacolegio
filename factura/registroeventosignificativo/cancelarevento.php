<?php
require_once '../../login/check.php';
$CodigoEventoSignificativo = $_GET['CodigoEventoSignificativo'];

require_once '../../factura/sfe/core.php';
$core = new Core;
$cancelarEvento = $core->cancelSignificantEvent('', '', $CodigoEventoSignificativo);

$respuesta = [];
if ($cancelarEvento['status'] == true) {
    $respuesta['estado'] = 'correcto';
    $respuesta['mensaje'] = $idioma['EventoCanceladoCorrectamente'];
} else {
    $respuesta['estado'] = 'error';
    $respuesta['mensaje'] = $idioma['ErrorCancelarEvento'] . '. <br>' . $cancelarEvento['message'];
}

echo json_encode($respuesta);
