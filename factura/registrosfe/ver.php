<?php
include_once("../../login/check.php");
$titulo = "VerFactura";
$folder = "../../";
if (isset($_GET['f'])) {
    require_once '../../class/factura.php';
    $factura = new factura;
    $fac = $factura->mostrarFactura($_GET['f']);
    $fac = array_shift($fac);
    // var_dump($fac);
    $RequestSIN = json_decode($fac['RequestSIN'], true);
    $ResponseSIN = json_decode($fac['ResponseSIN'], true);
    // var_dump($ResponseSIN);
}

$mensaje = isset($_GET['m']) ? $_GET['m'] : "";
$mensaje = base64_decode($mensaje);

include_once($folder . "cabecerahtml.php");
?>
<?php include_once($folder . "cabecera.php"); ?>
<div class="span12 box">
    <div class="box-content">
        <!-- <a href="<?php echo $url ?>" target="_blank" class="btn btn-danger"><?php echo $idioma['AbrirOtraVentana'] ?></a><hr> -->
        <!-- <iframe src="<?php echo $url ?>" width="100%" height="550"></iframe> -->
        <?php if ($mensaje != '') { ?>
            <div class="alert alert-danger">
                <h4><strong>Error al registrar la factura, por favor vuelva a intentarlo</strong></h4>
                <br>
                Descripción del Error: <?php echo $mensaje; ?>

                <!-- Crear boton html para dar attras -->
                <br><br>
                <a href="#" class="btn btn-danger" onclick="window.history.back();">Volver</a>
            </div>

        <?php } ?>

        <?php if (isset($_GET['f'])) { ?>
            <div class="alert alert-success">
                <h4 class="centrar"><?php echo $idioma['FacturaRegistradaCorrectamente'] ?></h4>
                <br>
                <table class="table">
                    <tr>
                        <td class="der">CUF:</td>
                        <td><b><?php echo $fac['CodigoControl'] ?></b></td>
                    </tr>
                    <tr>
                        <td class="der">UID <?php echo $idioma['Factura'] ?>:</td>
                        <td><b><?php echo $ResponseSIN['data']['uid_invoice'] ?></b></td>
                    </tr>
                    <tr>
                        <td class="der"><?php echo $idioma['NFactura'] ?>:</td>
                        <td><b><?php echo $fac['NFactura'] ?></b></td>
                    </tr>
                    <tr>
                        <td class="der"><?php echo $idioma['CorreoElectronico'] ?>:</td>
                        <td><b><?php echo $RequestSIN['client_email'] ?></b></td>
                    </tr>
                    <tr>
                        <td class="der"><?php echo $idioma['Estado'] ?>:</td>
                        <td><b><?php echo $fac['Estado'] ?></b></td>
                    </tr>
                    <tr>
                        <td class="der"><?php echo $idioma['EnlaceSIN'] ?>:</td>
                        <td><b><a href="<?php echo $fac['QrLink'] ?>" target="_blank"><?php echo $fac['QrLink'] ?></a></b></td>
                    </tr>
                </table>

                <br>

            </div>
        <?php } ?>
    </div>
</div>
<?php include_once($folder . "pie.php"); ?>