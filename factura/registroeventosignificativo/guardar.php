<?php
require_once '../../login/check.php';
extract($_POST);

require_once '../../factura/sfe/core.php';
$core = new Core;
$starSignificantEvent = $core->startSignificantEvent('', '', $CodigoEventoSignificativo, $Descripcion);
if ($starSignificantEvent['status'] == true) {
?>
    <div class="alert alert-success">
        <?php echo $idioma['EventoSignificativoRegistradoCorrectamente'] ?>
    </div>
<?php

} else {
?>
    <div class="alert alert-error">
        <?php echo $idioma['ErrorAlRegistrarEventoSignificativo'] ?>
        <br>
        <?php echo $idioma['Detalle'] ?>: <b><?php echo $starSignificantEvent['message'] ?></b>
    </div>
<?php
}
