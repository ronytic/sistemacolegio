<?php
include_once("../../login/check.php");
if (isset($_POST)) {
    extract($_POST);
    $Borde = isset($Borde) ? $Borde : "0";
    $Blanco = isset($Blanco) ? $Blanco : "0";
    $url = "../../impresion/reporte/reportepersonalizado.php?CodCurso=" . $CodCurso . "&Sexo=" . $Sexo . "&Campo1=" . $Campo1 . "&Campo2=" . $Campo2 . "&Campo3=" . $Campo3 . "&Campo4=" . $Campo4 . "&Borde=" . $Borde . "&Blanco=" . $Blanco . "&Cantidad=" . $Cantidad . "&Sombreado=" . $Sombreado;
?>
    <a class="btn btn-danger" target="_blank" href="<?php echo $url; ?>"><?php echo $idioma['AbrirOtraVentana'] ?></a>
    <hr />
    <div id="parentIframe">
        <iframe src="<?php echo $url; ?>" width="100%" height="750" id="pdf" title=""></iframe>
    </div>
<?php
}
?>