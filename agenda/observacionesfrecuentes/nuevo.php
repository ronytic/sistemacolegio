<?php
include_once("../../login/check.php");
if (isset($_POST)) {
?>
    <h2><?php echo $idioma['NuevoMensaje'] ?></h2>
    <form action="guardar.php" method="post" class="formulario">
        <table class="table table-bordered table-striped">
            <tr>
                <td><?php echo $idioma['Nombre'] ?><br>
                    <input type="text" value="<?php echo isset($men['Nombre']) ? $men['Nombre'] : '' ?>" name="Nombre" class="span12" placeholder="">
                </td>
            </tr>
            <tr>
                <td><?php echo $idioma['ValorObservacion'] ?><br>
                    <input type="text" name="Valor" value="<?php echo isset($men['Valor']) ? $men['Valor'] : '' ?>" class="span12">
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