<?php

use Picqer\Barcode\BarcodeGenerator;
use Brewerwall\Barcode\Constants\BarcodeType;
use Brewerwall\Barcode\Constants\BarcodeRender;

// require_once "../../Brewerwall/Barcode/BarcodeGenerator.php";
// require_once "../../Brewerwall/Barcode/Constants/BarcodeType.php";
// require_once "../../Brewerwall/Barcode/Constants/BarcodeRender.php";
// require_once "../../Brewerwall/Barcode/Renders/BarcodeRenderFactory.php";
// require_once "../../Brewerwall/Barcode/Types/BarcodeTypeFactory.php";
// require_once "../../Brewerwall/Barcode/Types/C128.php";
// require_once "../../Brewerwall/Barcode/Types/BarcodeTypeAbstract.php";

// use Brewerwall\Barcode\BarcodeGenerator;
// use Brewerwall\Barcode\Constants\BarcodeType;
// use Brewerwall\Barcode\Constants\BarcodeRender;
// use Brewerwall\Barcode\Renders\BarcodeRenderFactory;
require_once "../../code/vendor/autoload.php";

include_once("../../login/check.php");
if (!empty($_GET)) {
    $CodAlumno = $_GET['CodAlumno'];
    include_once("../../class/alumno.php");
    $alumno = new alumno;
    $folder = "../../";
    //include_once("../../cabecerahtml.php");
    // $generator = new BarcodeGenerator(BarcodeType::TYPE_CODE_128, BarcodeRender::RENDER_JPG);

    // // Generate our code
    // $generated = $generator->generate('012345678');
    // This will output the barcode as HTML output to display in the browser
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <div style="text-align:center">
            <h1><?php echo $idioma['CodigoBarra'] ?></h1>
        </div>
        <input type="button" value="<?php echo $idioma['Imprimir'] ?>" onClick="javascript:window.print();" class="btn btn-info">
        <hr>
        <?php
        $al = $alumno->mostrarTodoDatos($CodAlumno);
        $al = array_shift($al);
        $code = $generator->getBarcode($al['CodBarra'], $generator::TYPE_CODE_128, 1, 60);
        $code = 'data:image/png;base64,' . base64_encode($code);
        //foreach($alumno->mostrarDatosAlumnosWhere("CodCurso=".$CodCurso) as $al){
        ?>
        <div style="display:inline-block;border:#CCC 1px solid;padding:10px; width:250px; text-align:center">
            <div class="centrar"><?php echo capitalizar($al['Paterno']); ?> <?php echo capitalizar($al['Materno']); ?> <?php echo capitalizar($al['Nombres']); ?></div>
            <!-- <img src="../../code/barcode.php?code=<?php echo $al['CodBarra'] ?>&encoding=ANY" class="span2" height="100"> -->
            <img src="<?php echo $code ?>" class="span2" height="100" alt="<?php echo $al['CodBarra'] ?>">
            <div style="text-align: center; margin-top: -25px;">
                <div style="display: inline-block;background-color: white; padding: 2px 20px">
                    <?php echo $al['CodBarra'] ?>
                </div>
            </div>
            <!-- <img src="../barcode/barcode.php?print=true&text=<?php echo $al['CodBarra'] ?>&encoding=ANY" class="span2" height="100"> -->

        </div>
    <?php
    //}
}
    ?>
    </body>

    </html>