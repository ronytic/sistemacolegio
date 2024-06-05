<?php
//show errors php
error_reporting(E_ALL);
require_once "login/check.php";
require_once "class/config.php";
if (isset($_SESSION['Nivel']) && in_array($_SESSION['Nivel'], [6, 7])) {
    $configAux = new config;
    $redirigirAlumno = $configAux->mostrarConfig('RedirigirAlumnoVersionResumida', 1);
    if ($redirigirAlumno == 1) {
        header("Location:internet/alumno/");
    }
}
$folder = '';
$titulo = "NPaginaPrincipal";
?>
<?php include_once "cabecerahtml.php"; ?>
<script language="javascript" type="text/javascript" src="js/core/plugins/highcharts.js"></script>
<script language="javascript" type="text/javascript" src="js/inicio.js"></script>
<?php include_once "cabecera.php"; ?>
<?php if ($_SESSION['Nivel'] == 1 || $_SESSION['Nivel'] == 2 || $_SESSION['Nivel'] == 4 || $_SESSION['Nivel'] == 5) : ?>
    <div id="asistenciarapida"></div>

    <div class="span2">

        <?php echo $idioma['Fecha']; ?>: <input type="text" class="span10" id="FechaAsistencia" value="<?php echo date("d-m-Y") ?>">
        <br>
        <a href="#" title="<?php echo $idioma['Actualizar'] ?> <?php echo $idioma['Asistencia'] ?>" id="actualizarasistencia" class="btn"><i class="icon-refresh"></i></a>
    </div>
<?php endif; ?>
</div>
<div class="row-fluid">
    <?php if ($_SESSION['Nivel'] == 1 || $_SESSION['Nivel'] == 2) : ?>
        <div class="span6 box">
            <div class="box-header">
                <h2><?php echo $idioma['EstadisticasInstantaneaPagoCuotas'] ?></h2>
                <div class="box-icon"><a href="#" title="<?php echo $idioma['Actualizar'] ?>" id="actualizarcuotas"><i class="icon-refresh"></i></a></div>
            </div>
            <div class="box-content">
                <table>
                    <tr>
                        <td><?php echo $idioma['FechaCuotas'] ?><br><?php campo("FechaCuotas", "text", date("d-m-Y"), "input-medium") ?></td>
                        <td>
                            <?php
                            $urlRegistroFactura = 'factura/registro/';
                            if (isset($SistemaFacturacion) && $SistemaFacturacion == 'SistemaFacturacionElectronica') {
                                $urlRegistroFactura = 'factura/registrosfe/';
                            }
                            ?>
                            <a href="<?php echo $urlRegistroFactura ?>" class="btn btn-mini"><i class="icon-plus"></i><?php echo $idioma['RegistrarFactura'] ?></a>
                            <a href="cuotas/pagar/" class="btn btn-mini"><i class="icon-plus"></i><?php echo $idioma['RegistrarNuevosPagos'] ?></a>
                        </td>
                    </tr>
                </table>



                <hr class="separador">
                <div id="listadocuotas" style="max-height:400px;overflow-y:auto"></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($_SESSION['Nivel'] == 1 || $_SESSION['Nivel'] == 2 || $_SESSION['Nivel'] == 4 || $_SESSION['Nivel'] == 5) : ?>
        <div class="span6 box">
            <div class="box-header"><?php echo $idioma['ObservacionesAgenda'] ?> - <?php echo $idioma['DiaHoy'] ?><div class="box-icon"><a href="#" title="<?php echo $idioma['Actualizar'] ?>" id="actualizaragenda"><i class="icon-refresh"></i></a></div>
            </div>
            <div class="box-content">
                <?php echo $idioma['FechaAgenda'] ?>
                <?php campo("FechaAgenda", "text", date("d-m-Y"), "input-medium") ?>
                <a href="agenda/total/" class="btn btn-mini"><i class="icon-plus"></i><?php echo $idioma['RegistrarNuevaObservacion'] ?></a>
                <div id="listadoagenda" style="max-height:400px;overflow-y:auto;position:relative"></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($_SESSION['Nivel'] == 6 || $_SESSION['Nivel'] == 7) : ?><a href="internet/alumno/" class="btn btn-large btn-danger"><?php echo $idioma['VersionResumida'] ?></a><?php endif; ?>
</div>
<div class="row-fluid">
    <div class="span8 box">
        <div class="box-header">
            <h2><i class="icon-calendar"></i><span class="break"></span><?php echo $idioma['AgendaActividades'] ?></h2>
            <div class="box-icon"><a href="#" title="<?php echo $idioma['Actualizar'] ?>" id="actualizaractividades"><i class="icon-refresh"></i></a></div>
        </div>
        <div class="box-content">
            <?php echo $idioma['FechaActividad'] ?>
            <?php campo("FechaActividad", "text", date("d-m-Y"), "input-medium") ?>
            <a href="agendaactividades/" class="btn btn-mini"><i class="icon-plus"></i><?php echo $idioma['RegistrarNuevaActividad'] ?></a>
            <hr class="separador">
            <div id="listadoactividades"></div>
        </div>
    </div>
    <?php if ($_SESSION['Nivel'] == 1 || $_SESSION['Nivel'] == 2) : ?>
        <div class="span4 box">
            <div class="box-header"><?php echo $idioma['AccesosUsuarioSistema'] ?><div class="box-icon"><a href="seguridad/veraccesos/" title="<?php echo $idioma["VerTodosLosAccesos"] ?>"><i class="icon-plus"></i></a><a href="#" title="<?php echo $idioma['Actualizar'] ?>" id="actualizarusuarios"><i class="icon-refresh"></i></a></div>
            </div>
            <div class="box-content" id="listausuario">
            </div>
        </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
</script><?php include_once "pie.php"; ?>