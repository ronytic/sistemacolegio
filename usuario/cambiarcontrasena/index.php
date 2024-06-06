<?php
include_once("../../login/check.php");
$folder = "../../";
$titulo = "NConfiguracionUsuario";

if ($_SESSION['Nivel'] == 3) {
    include_once("../../class/docente.php");
    $docente = new docente;
    $usuconf = $docente->mostrarTodoDatosDocente($_SESSION['CodUsuarioLog']);
    $usuconf = array_shift($usuconf);
    $usuarioAcceso = $usuconf['Usuario'];
}
if ($_SESSION['Nivel'] == 6 || $_SESSION['Nivel'] == 7) {
    include_once("../../class/alumno.php");
    $alumno = new alumno;
    $usuconf = $alumno->mostrarTodoDatos($_SESSION['CodUsuarioLog']);
    $usuconf = array_shift($usuconf);
    if ($_SESSION['Nivel'] == 6) {
        $usuarioAcceso = $usuconf['UsuarioPadre'];
    } else {
        $usuarioAcceso = $usuconf['UsuarioAlumno'];
    }
}
$valoridioma = array("es" => "Castellano", "ay" => 'Aymara', "qu" => "Quechua", "gu" => 'Guarani', "en" => 'Ingles');
if (isset($usuconf['Foto'])) {
    $ima = $folder . "imagenes/usuario/" . $usuconf['Foto'];
} else {
    $ima = $folder . "imagenes/usuario/0.jpg";
}
if (!file_exists($ima) || empty($usuconf['Foto'])) {
    $ima = $folder . "imagenes/usuario/0.jpg";
}
$NoRevisar = 1;
include_once($folder . "cabecerahtml.php");
?>
<script language="javascript" type="text/javascript" src="../../js/core/plugins/jquery.alphanumeric.pack.js"></script>
<!-- <script language="javascript" type="text/javascript" src="../../js/core/plugins/BootstrapStrength/bootstrap-strength.min.js"></script> -->
<script language="javascript" type="text/javascript" src="../../js/core/plugins/check-strength-password/asset/password-strength.js"></script>
<script language="javascript" type="text/javascript" src="../../js/usuario/configuracion.js"></script>
<link rel="stylesheet" href="../../js/core/plugins/check-strength-password/asset/password-strength.css">

<script language="javascript">
    var ContrasenaNoIgual = "<?php echo $idioma['ContrasenaNoIgual'] ?>";
</script>
<?php include_once($folder . "cabecera.php"); ?>
<span class="span12 box">
    <div class="box-header">
        <h2><i class="icon-cog"></i><span class="break"></span><?php echo $idioma['DatosUsuario'] ?></h2>
    </div>
    <div class="box-content">
        <?php if (isset($_GET['s'])) : ?>
            <div class="alert alert-success"><?php echo $idioma['DatosGuardadosCorrectamente'] ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>
        <form action="guardar.php" method="post" enctype="multipart/form-data" id="datos" autocomplete="off">
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <td><?php echo $idioma['Nombres'] ?>:</td>
                    <td><?php echo $usuconf['Nombres'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Paterno'] ?>:</td>
                    <td><?php echo $usuconf['Paterno'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Materno'] ?>:</td>
                    <td><?php echo $usuconf['Materno'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Usuario'] ?>:</td>
                    <td><?php echo $usuarioAcceso; ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Contrasena'] ?>:</td>
                    <td><?php campo("Pass", "password", "", "span6", 0, $idioma['Contrasena'], 0, ['autocomplete' => 'off']) ?>
                        <div id="password-strength-status"></div>
                        <?php htmlListadoCriteriosContrasena(); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $idioma['RepetirContrasena'] ?>:</td>
                    <td>
                        <?php campo("PassRepetir", "password", "", "span6", 0, $idioma['RepetirContrasena'], 0, ['autocomplete' => 'off']) ?>
                        <div id="contrasenaigual" class="alert alert-success" style="display:none"><?php echo $idioma['ContrasenaIgual'] ?></div>
                        <div id="contrasenanoigual" class="alert alert-error" style="display:none"><?php echo $idioma['ContrasenaNoIgual'] ?></div>
                    </td>
                </tr>
            </table>
            <input type="submit" class="btn btn-success" value="<?php echo $idioma['GuardarConfiguracion'] ?>" id="botonSubmit" />
        </form>
    </div>
</span>
<?php include_once($folder . "pie.php"); ?>