<?php
include_once("../../login/check.php");
if (!empty($_GET)) {
    $CodCurso = $_GET['CodCurso'];
    include_once("../../class/alumno.php");
    include_once("../../class/curso.php");
    require_once "../../code/vendor/autoload.php";
    $alumno = new alumno;
    $curso = new curso;
    $cur = $curso->mostrarCurso($CodCurso);
    $cur = array_shift($cur);
    $folder = "../../";
    //include_once("../../cabecerahtml.php");
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <div style="text-align:center">
            <h1><?php echo $idioma['CodigosBarra'] ?></h1>
        </div>
        <input type="button" value="<?php echo $idioma['Imprimir'] ?>" onClick="javascript:window.print();" class="btn btn-info"> <?php echo $idioma['Curso'] ?>: <?php echo $cur['Nombre'] ?>
        <hr>
        <?php
        foreach ($alumno->mostrarDatosAlumnosWhere("CodCurso=" . $CodCurso) as $al) {
            $code = $generator->getBarcode($al['CodBarra'], $generator::TYPE_CODE_128, 1, 60);
            $code = 'data:image/png;base64,' . base64_encode($code);
        ?>
            <div style="display:inline-block;border:#CCC 1px solid;padding:10px; width:200px; text-align:center">
                <div class="centrar"><?php echo capitalizar($al['Paterno']); ?> <?php echo capitalizar($al['Materno']); ?> <?php echo capitalizar($al['Nombres']); ?></div>
                <!-- <img src="../../code/barcode.php?code=<?php echo $al['CodBarra'] ?>&encoding=ANY" class="span2"  height="100"> -->
                <img src="<?php echo $code ?>" class="span2" height="100" alt="<?php echo $al['CodBarra'] ?>">
                <div style="text-align: center; margin-top: -25px;">
                    <div style="display: inline-block;background-color: white; padding: 2px 20px">
                        <?php echo $al['CodBarra'] ?>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
    </body>

    </html>