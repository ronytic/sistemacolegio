<?php
require_once '../../login/check.php';
$CodigoEventoSignificativo = $_GET['CodigoEventoSignificativo'];

require_once '../../factura/sfe/core.php';
$core = new Core;
$finalizarEvento = $core->endSignificantEvent('', '', $CodigoEventoSignificativo);

$respuesta = [];
if ($finalizarEvento['status'] == true) {
    $respuesta['estado'] = 'correcto';
    $respuesta['mensaje'] = $idioma['EventoFinalizadoCorrectamente'];
} else {
    $respuesta['estado'] = 'error';
    $respuesta['mensaje'] = $idioma['ErrorFinalizarEvento'] . '. <br>' . $finalizarEvento['message'];
}

echo json_encode($respuesta);
