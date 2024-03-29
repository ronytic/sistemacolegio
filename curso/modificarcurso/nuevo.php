<?php
include_once("../../login/check.php");
if (isset($_POST)) {
    include_once("../../class/curso.php");
    include_once("../../class/cursoarea.php");
    include_once("../../class/config.php");
    $curso = new curso;
    $cursoarea = new cursoarea;
    $config = new config;
    $Moneda = $config->mostrarConfig("Moneda", 1);
    $CodCurso = isset($_POST['CodCurso']) ? $_POST['CodCurso'] : '';
    // $cur = $curso->mostrarCurso($CodCurso);
    // $cur = array_shift($cur);
    $curarea = todoLista($cursoarea->mostrarTodoRegistro(), "CodCursoArea", "Nombre");
    for ($i = 1; $i <= 4; $i++) {
        $datos[$i] = $i;
    }
    $paralelos = array("A" => "A", "B" => "B", "C" => "C", "D" => "D", "E" => "E", "F" => "F", "G" => "G", "H" => "H", "I" => "I", "J" => "J", "K" => "K", "L" => "L");
?>
    <h2><?php echo $idioma['NuevoCurso'] ?></h2>
    <form action="guardar.php" method="post" class="formulario">
        <input type="hidden" name="CodCurso" value="<?php echo $CodCurso ?>">
        <table class="table table-bordered table-striped">
            <tr>
                <td><?php echo $idioma['Nombre'] ?><br>
                    <input type="text" value="" name="Nombre" class="span12" placeholder="1 Primaria"><br>
                    <small><?php echo $idioma['NotaNombreCurso'] ?></small>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['Abreviado'] ?><br>
                    <input type="text" value="" name="Abreviado" class="span12" placeholder="1 Prim">
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['AreaCurso'] ?><br>
                    <?php campo("CodCursoArea", "select", $curarea, "span12", 1, "", 0, "") ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['Paralelo'] ?><br>
                    <?php campo("Paralelo", "select", $paralelos, "span12", 1, "", 0, "") ?><br>
                    <small><?php echo $idioma['NotaParalelo'] ?></small>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['Dps'] ?><br>
                    <?php campo("Dps", "select", array("1" => $idioma["Si"], "0" => $idioma["No"]), "span12", 1, "", 0, "") ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['Bimestre'] ?><br>
                    <?php campo("Bimestre", "select", array("1" => $idioma["Si"], "0" => $idioma["No"]), "span12", 1, "", 0, "") ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['NotaTope'] ?><br>
                    <input type="text" value="" name="NotaTope" class="span12" placeholder="60">
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['NotaAprobacion'] ?><br>
                    <input type="text" value="" name="NotaAprobacion" class="span12" placeholder="36">
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['MontoCuotaPagar'] ?><br>
                    <div class="input-append">
                        <input type="text" value="" name="MontoCuota" class="span12">
                        <div class="add-on"><?php echo $Moneda ?></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['CantidadEtapas'] ?><br>
                    <?php campo("CantidadEtapas", "select", $datos, "span12", 1, "", 0, "") ?><br>
                    <small><?php echo $idioma['DescripcionEtapa'] ?></small>
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['Orden'] ?><br>
                    <input type="text" value="" name="Orden" class="span12" placeholder="14"><br>
                    <small><?php echo $idioma['DescripcionOrden'] ?></small>
                </td>
            </tr>
            <tr>
                <td><input type="submit" class="btn btn-success" value="<?php echo $idioma['Guardar'] ?>"></td>
            </tr>
        </table>
    </form>
<?php
}
?>