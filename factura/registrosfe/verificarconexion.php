<?php
require_once '../../login/check.php';
require_once '../../factura/sfe/core.php';
$core = new Core;
$verifyStatusServer = $core->verifyStatusServer();
echo json_encode($verifyStatusServer);
