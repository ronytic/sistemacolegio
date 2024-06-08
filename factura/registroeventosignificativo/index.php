<?php
include_once("../../login/check.php");
$titulo = "RegistrarEventoSignificativo";
$folder = "../../";
include_once("../../class/config.php");
$config = new config;


require_once '../../factura/sfe/core.php';
$core = new Core;
$significantEvents = $core->getSignificantEvents();
$eventosSignificativos = [];
if (isset($significantEvents['status']) && $significantEvents['status'] == 'success') {
    $eventosSignificativos = $significantEvents['data'] ?? [];
}


include_once($folder . "cabecerahtml.php");
?>
<script language="javascript" type="text/javascript" src="../../js/factura/registroeventosignificativo.js"></script>
<script language="javascript" type="text/javascript" src="../../js/core/plugins/jquery.alphanumeric.pack.js"></script>
<style type="text/css">
    th {
        vertical-align: top !important;
    }

    .derecha {
        text-align: right;
    }
</style>
<?php include_once($folder . "cabecera.php"); ?>
<div class="span3 box">
    <div class="box-header">
        <h2><i class="icon-cog"></i><span class="break"></span><?php echo $idioma['Configuracion'] ?></h2>
    </div>
    <div class="box-content">
        <form action="guardar.php" method="POST" class="formulario">
            <b><?php echo $idioma['EventoSignificativo'] ?>:</b><br>
            <select class="span12" name="CodigoEventoSignificativo" id="CodigoEventoSignificativo" required>
                <?php foreach ($eventosSignificativos as $evento) : ?>
                    <option value="<?php echo $evento['siat_code_classifier_significant_event'] ?>"><?php echo ucfirst(mb_strtolower($evento['siat_description_significant_event'])) ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <?php echo $idioma['Descripcion'] ?>:<br>
            <textarea name="Descripcion" id="Descripcion" rows="3" class="span12" required></textarea>

            <input type="submit" value="<?php echo $idioma['Guardar'] ?>" class="btn btn-success">
        </form>
        <div id="respuestaformulario"></div>
    </div>
</div>
<div class="span9 box">
    <div class="box-header">
        <h2><i class="icon-list"></i><span class="break"></span><?php echo $idioma['EventosSignificativos'] ?></h2>
    </div>
    <div class="box-content">
        <?php echo $idioma['Fecha'] ?>: <input type="text" name="fecha" id="fecha" style="margin-top:10px" value="<?php echo date("d-m-Y") ?>">
        <input type="button" value="<?php echo $idioma['Buscar'] ?>" class="btn btn-info" id="buscar">
        <div id="listadoEventosSignificativos">

        </div>
    </div>
</div>
<?php include_once($folder . "pie.php"); ?>