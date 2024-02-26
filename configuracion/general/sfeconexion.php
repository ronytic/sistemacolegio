<?php
require_once '../../login/check.php';
require_once '../../factura/sfe/core.php';
$core = new Core;
$accion = $_POST['accion'];
if ($accion == 'testconexion') {
    $SFEUrl = $_POST['SFEUrl'];
    $SFEUsuario = $_POST['SFEUsuario'];
    $SFEContrasena = $_POST['SFEContrasena'];
    $resultado = $core->getToken($SFEUrl, $SFEUsuario, $SFEContrasena);
    echo json_encode($resultado);
}

if ($accion == 'obtenersistemas') {
    $SFEToken = $_POST['SFEToken'];
    $resultado = $core->getSystems($SFEToken);
    echo json_encode($resultado);
}

if ($accion == 'obtenersucursales') {
    $SFEToken = $_POST['SFEToken'];
    $resultado = $core->getBranches($SFEToken);
    echo json_encode($resultado);
}

if ($accion == 'obtenerposes') {
    $SFEToken = $_POST['SFEToken'];
    $SFECodSucursal = $_POST['SFECodSucursal'];
    $resultado = $core->getPoses($SFEToken, $SFECodSucursal);
    echo json_encode($resultado);
}
if ($accion == 'obtenermetodosdepagos') {
    $SFEToken = isset($_POST['SFEToken']) ? $_POST['SFEToken'] : '';
    $SFECodSucursal = isset($_POST['SFECodSucursal']) ? $_POST['SFECodSucursal'] : '';
    $resultado = $core->getPaymentMethods($SFEToken, $SFECodSucursal);
    echo json_encode($resultado);
}
if ($accion == 'obtenertipomonedas') {
    $SFEToken = $_POST['SFEToken'];
    $SFECodSucursal = $_POST['SFECodSucursal'];
    $resultado = $core->getCurrencyTypes($SFEToken, $SFECodSucursal);
    echo json_encode($resultado);
}

if ($accion == 'obtenerunidadmedidas') {
    $SFEToken = $_POST['SFEToken'];
    $SFECodSucursal = $_POST['SFECodSucursal'];
    $resultado = $core->getMeasurementUnits($SFEToken, $SFECodSucursal);
    echo json_encode($resultado);
}

if ($accion == 'obteneractividades') {
    $SFEToken = $_POST['SFEToken'];
    $SFECodSucursal = $_POST['SFECodSucursal'];
    $resultado = $core->getActivities($SFEToken, $SFECodSucursal);
    echo json_encode($resultado);
}
if ($accion == 'obtenerProductosSin') {
    $SFEToken = $_POST['SFEToken'];
    $SFECodSucursal = $_POST['SFECodSucursal'];
    $SFECodActividad = $_POST['SFECodActividad'];
    $resultado = $core->getProductService($SFEToken, $SFECodSucursal, $SFECodActividad);
    echo json_encode($resultado);
}

if ($accion == 'obtenerTipoDocumentosIdentidad') {
    $SFEToken = isset($_POST['SFEToken']) ? $_POST['SFEToken'] : '';
    $SFECodSucursal = isset($_POST['SFECodSucursal']) ? $_POST['SFECodSucursal'] : '';
    $resultado = $core->getIdentityDocumentTypes($SFEToken, $SFECodSucursal);
    echo json_encode($resultado);
}

if ($accion == 'verificarNit') {
    $SFEToken = isset($_POST['SFEToken']) ? $_POST['SFEToken'] : '';
    $Nit = isset($_POST['Nit']) ? $_POST['Nit'] : '';
    $resultado = $core->verifyNit($SFEToken, $Nit);
    echo json_encode($resultado);
}

if ($accion == 'anularFactura') {
    $SFEToken = isset($_POST['SFEToken']) ? $_POST['SFEToken'] : '';
    $UIDInvoice = isset($_POST['UIDInvoice']) ? $_POST['UIDInvoice'] : '';
    $resultado = $core->annulmentInvoice($SFEToken, $UIDInvoice);
    echo json_encode($resultado);
}
