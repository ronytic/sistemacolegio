<?php
require_once '../../login/check.php';
$uidFactura = $_GET['uidFactura'];

require_once '../../factura/sfe/core.php';
$core = new Core;

$reenviarCorreo = $core->sendEmail('', '', $uidFactura);
$respuesta = [];
//$reenviarCorreo['status'] = true;
if ($reenviarCorreo['status'] == true) {
    $respuesta['estado'] = 'correcto';
    $respuesta['mensaje'] = $idioma['CorreoEnviadoCorrectamente'];
} else {
    $respuesta['estado'] = 'error';
    $respuesta['mensaje'] = $idioma['ErrorEnviarCorreo'] . '. <br>' . $reenviarCorreo['message'];
}

echo json_encode($respuesta);
