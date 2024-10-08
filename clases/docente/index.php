<?php
include_once("../../login/check.php");
$folder = "../../";
$titulo = "NMisClases";
include_once("../../class/docentemateriacurso.php");
include_once("../../class/curso.php");
include_once("../../class/materias.php");
$docentemateriacurso = new docentemateriacurso;
$curso = new curso;
$materias = new materias;
$CodDocente = $_SESSION['CodUsuarioLog'];
$docmateriacurso = $docentemateriacurso->mostrarDocenteGrupo($CodDocente, "CodCurso");

include_once("../../cabecerahtml.php");
?>
<link href="../../css/clases/estio.css" type="text/css" rel="stylesheet">
<script language="javascript" type="application/javascript" src="../../js/clases/docente.js"></script>
<script language="javascript">
    var PesoArchivo = "<?php echo $idioma['PesoArchivo'] ?>";
    var FechaModificacion = "<?php echo $idioma['FechaModificacion'] ?>";
</script>
<?php include_once("../../cabecera.php"); ?>
<div class="span5 box">
    <form action="subir.php" enctype="multipart/form-data" method="post" id="formulario">
        <div class="row-fluid">
            <div class="span5">
                <div class="box-header"><?php echo $idioma['Curso'] ?></div>
                <div class="box-content">
                    <select class="span12" name="CodCurso">
                        <?php foreach ($docmateriacurso as $dmc) {

                            $cur = $curso->mostrarCurso($dmc['CodCurso']);
                            $cur = array_shift($cur);
                        ?>
                            <option value="<?php echo $dmc['CodCurso'] ?>"><?php echo $cur['Nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="box-header"><?php echo $idioma['Materia'] ?></div>
                <div class="box-content">
                    <select class="span12" name="CodMateria">
                        <?php foreach ($docentemateriacurso->mostrarDocenteMateria($CodDocente) as $dmc) {
                            $mat = $materias->mostrarMateria($dmc['CodMateria']);
                            $mat = array_shift($mat);
                        ?>
                            <option value="<?php echo $dmc['CodMateria'] ?>"><?php echo $mat['Nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="span7">
                <div class="box-header">
                    <h2><?php echo $idioma['DatosClase'] ?></h2>
                </div>
                <div class="box-content">
                    <?php echo $idioma["NombreClase"] ?>:<br>
                    <?php campo("NombreTarea", "text", "", "span12", 1, $idioma['Ej:ClaseLunes25/06/2024']) ?>

                    <?php echo $idioma["FechaPresentacion"] ?>:<br>
                    <?php campo("FechaPresentacion", "text", date("d-m-Y"), "span12", 1, "", 0, array("maxlength" => 10)) ?>

                    <?php echo $idioma["DetalleClase"] ?>:<br>
                    <?php campo("DetalleClase", "textarea", "", "span12", 1, "", 0, array("rows" => 5)) ?>

                    <?php echo $idioma['Archivos'] ?>
                    <label for="files"><?php echo $idioma['SuelteArchivos'] ?></label>
                    <div style="position:relative">
                        <input type="file" id="files" name="files[]" multiple />
                        <div id="drop_zone"><?php echo $idioma['SuelteArchivos'] ?></div>
                        <div id="list"></div>
                    </div>
                    <br>
                    <input type="submit" value="<?php echo $idioma['Publicar'] ?>" class="btn btn-success">
                    <a class="btn" href="./"><?php echo $idioma['Cancelar'] ?></a>

                    <div class="row-fluid">
                        <div class="span12" id="respuesta">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="span7 box">
    <div class="box-header">
        <h2><?php echo $idioma['MisArchivosClases'] ?></h2>
        <div class="box-icon"><a href="#" id="actualizar"><i class="icon-refresh"></i></a></div>
    </div>
    <div class="box-content">
        <div></div>
        <div id="mostrar"></div>
    </div>

</div>


<?php include_once("../../pie.php"); ?>