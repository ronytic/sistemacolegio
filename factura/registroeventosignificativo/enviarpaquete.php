<?php
require_once '../../login/check.php';
$CodigoEventoSignificativo = $_GET['CodigoEventoSignificativo'];

require_once '../../factura/sfe/core.php';
$core = new Core;
$enviarPaquete = $core->sendPackages('', '', $CodigoEventoSignificativo);

$respuesta = [];
if ($enviarPaquete['status'] == true) {
    $respuesta['estado'] = 'correcto';
    $respuesta['mensaje'] = $idioma['PaqueteEnviadoCorrectamente'];
} else {
    $respuesta['estado'] = 'error';
    $respuesta['mensaje'] = $idioma['ErrorEnviarPaquete'] . '. <br>' . $enviarPaquete['message'];
}

echo json_encode($respuesta);
