<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
    $CodCurso = $_POST['CodCurso'];
    $Periodo = isset($_POST['Periodo']) ? $_POST['Periodo'] : '1';
    $url = "../../impresion/notas/centralizadorpromediofinal.php?CodCurso=" . $CodCurso . "&Periodo=" . $Periodo . "&mf=" . md5("lock");
?>
    <a href="<?php echo $url; ?>" class="btn btn-danger" target="_blank"><?php echo $idioma['AbrirOtraVentana'] ?></a>
    <hr />
    <iframe width="100%" height="600" src="<?php echo $url; ?>" id="pdf"></iframe>
<?php
}
?>