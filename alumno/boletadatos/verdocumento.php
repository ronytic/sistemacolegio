<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
    $CodAlumno = $_POST['CodAlumno'];
    if ($CodAlumno == 'null') {
        return;
    }
    $url = "../../impresion/alumno/boletadatos.php?CodAlumno=" . $CodAlumno;
?>
    <div id="parentIframe">
        <a href="<?php echo $url; ?>" class="btn btn-danger" target="_blank"><?php echo $idioma['AbrirOtraVentana'] ?></a>
        <a href="#" class="btn btn-success" id="registrarimpresion" data-archivo="Hoja de Datos" data-alumno="<?php echo $CodAlumno; ?>"><?php echo $idioma['RegistrarImpresion'] ?></a>
        <hr />
        <strong><?php echo $idioma['ReporteImpresion']; ?></strong>
        <iframe src="<?php echo $url ?>" height="450" width="100%" name="pdf" id="pdf" title=""></iframe>
        <a href="#" class="btn" id="mostrarimpresion"><?php echo $idioma['MostrarImpresion'] ?></a>
        <div id="respuestaimpresion"></div>
    </div>
<?php
}
?>