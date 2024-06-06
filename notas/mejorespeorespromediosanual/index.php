<?php
include_once("../../login/check.php");
$titulo = "NMejoresPeoresPromediosAnual";
$folder = "../../";
?>
<?php include_once("../../cabecerahtml.php"); ?>
<script language="javascript" type="application/javascript" src="../../js/notas/mejorespeorespromedios.js"></script>
<?php
include_once("../../cabecera.php");
?>
<div class="span3 box">
    <div class="box-header">
        <h2><i class="icon-cog"></i><span class="break"></span>Configuración</h2>
    </div>
    <div class="box-content">
        <?php echo $idioma['TipoReporte'] ?>:
        <!--<input type="search" class="span12" placeholder="<?php echo $idioma['BuscarOrdenPor'] ?>" name="tOrden"/>-->
        <select name="Orden" class="span12">
            <option value="1"><?php echo $idioma['CuadroHonor'] ?></option>
            <option value="0"><?php echo $idioma['PromediosBajos'] ?></option>
        </select>
        <?php echo $idioma['CantidadAlumnoCurso'] ?>:
        <input type="text" value="3" name="Cantidad" size="2" class="span12" />
        <input type="submit" value="<?php echo $idioma['Reporte'] ?>" class="btn btn-success" id="revisar" />
    </div>
</div>
<div class="span9 box">
    <div class="box-header">
        <h2><i class="icon-file"></i><span class="break"></span><?php echo $idioma['Reporte'] ?></h2>
    </div>
    <div class="box-content" id="contenido">

    </div>
</div>
<?php include_once("../../pie.php"); ?>