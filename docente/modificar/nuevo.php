<?php
include_once '../../login/check.php';
include_once '../../class/docente.php';
if (isset($_POST)) {
    $folder = "../../";
    $docente = new docente;
    $doc = $docente->estadoTabla();
    $CodDocente = isset($doc['Auto_increment']) ? $doc['Auto_increment'] : '';
    //$doc=array_shift($docente->mostrarRegistro($CodDocente));
?>
    <form action="guardar.php" method="post" class="formulario" enctype="multipart/form-data">
        <input type="hidden" name="CodDocente" value="<?php echo $CodDocente ?>">
        <div id="respuestaformulario"></div>
        <div class="box-header">
            <h2><?php echo $idioma['DatosPersonales'] ?></h2>
        </div>
        <div class="box-content">

            <table class="table table-bordered table-hover">
                <tr>
                    <td colspan="2">
                        <?php echo $idioma['Foto'] ?>:<br />
                        <br /><small><?php echo $idioma['ImagenRecomendada'] ?> <br /><?php echo $idioma['TipoArchivo'] ?> "jpg" <br /><?php echo $idioma['TamanoArchivo'] ?> 200x200</small>
                        <input type="file" name="Foto" accept="image/*" class="span12">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Paterno'] ?></td>
                    <td><?php campo("Paterno", "text", isset($doc['Paterno']) ? $doc['Paterno'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Apellido'], 1) ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Materno'] ?></td>
                    <td><?php campo("Materno", "text", isset($doc['Materno']) ? $doc['Materno'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Apellido']) ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Nombre'] ?></td>
                    <td><?php campo("Nombres", "text", isset($doc['Nombres']) ? $doc['Nombres'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Nombre']) ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Sexo'] ?></td>
                    <td><?php campo("Sexo", "select", array("1" => $idioma['Masculino'], "0" => $idioma['Femenino']), "span12", 1) ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Ci'] ?></td>
                    <td><?php campo("Ci", "text", isset($doc['Ci']) ? $doc['Ci'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Ci'], 0, "") ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['FechaNacimiento'] ?></td>
                    <td><?php campo("FechaNac", "text", isset($doc['FechaNac']) ? $doc['FechaNac'] : '', "span12 fecha", 1); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Departamento'] ?></td>
                    <td><?php campo("Departamento", "text", isset($doc['Departamento']) ? $doc['Departamento'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['Departamento']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Provincia'] ?></td>
                    <td><?php campo("Provincia", "text", isset($doc['Provincia']) ? $doc['Provincia'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['Provincia']); ?></td>
                </tr>

                <tr>
                    <td><?php echo $idioma['Direccion'] ?></td>
                    <td><?php campo("Direccion", "text", isset($doc['Direccion']) ? $doc['Direccion'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Direccion']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Telefono'] ?></td>
                    <td><?php campo("Telefono", "text", isset($doc['Telefono']) ? $doc['Telefono'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Telefono']);  ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Celular'] ?></td>
                    <td><?php campo("Celular", "text", isset($doc['Celular']) ? $doc['Celular'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Celular']);  ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['EstadoCivil'] ?></td>
                    <td><?php campo("EstadoCivil", "text", isset($doc['EstadoCivil']) ? $doc['EstadoCivil'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['EstadoCivil']);  ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Email'] ?></td>
                    <td><?php campo("Email", "email", isset($doc['Email']) ? $doc['Email'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['Email']);  ?></td>
                </tr>

            </table>
        </div>
        <div class="box box-header">
            <h2><?php echo $idioma['DatosFormacionProfesional'] ?></h2>
        </div>
        <div class="box-content">
            <table class="table table-bordered table-hover">
                <tr>
                    <td><?php echo $idioma['RDA'] ?></td>
                    <td><?php campo("RDA", "text", isset($doc['RDA']) ? $doc['RDA'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['RDA']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Departamento'] ?></td>
                    <td><?php campo("DPDepartamento", "text", isset($doc['DPDepartamento']) ? $doc['DPDepartamento'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['Departamento']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Universidad'] ?></td>
                    <td><?php campo("DPUniversidad", "text", isset($doc['DPUniversidad']) ? $doc['DPUniversidad'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['Universidad']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['AñoIngreso'] ?></td>
                    <td><?php campo("DPAnoIngreso", "text", isset($doc['DPAnoIngreso']) ? $doc['DPAnoIngreso'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['AñoIngreso']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['AñoEgreso'] ?></td>
                    <td><?php campo("DPAnoEgreso", "text", isset($doc['DPAnoEgreso']) ? $doc['DPAnoEgreso'] : '', "span12", 0, $idioma['IngreseSu'] . $idioma['AñoEgreso']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['AñoTitulacion'] ?></td>
                    <td><?php campo("DPAnoTitulacion", "text", isset($doc['DPAnoTitulacion']) ? $doc['DPAnoTitulacion'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['AñoTitulacion']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Titulo'] ?></td>
                    <td><?php campo("DPTitulo", "text", isset($doc['DPTitulo']) ? $doc['DPTitulo'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Titulo']); ?></td>
                </tr>
            </table>
        </div>
        <div class="box box-header">
            <h2><?php echo $idioma['DatosTrabajo'] ?></h2>
        </div>
        <div class="box-content">
            <table class="table table-bordered table-hover">
                <tr>
                    <td><?php echo $idioma['Cargo'] ?></td>
                    <td><?php campo("DTCargo", "text", isset($doc['DTCargo']) ? $doc['DTCargo'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Cargo']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['CargaHoraria'] ?></td>
                    <td><?php campo("DTCargaHoraria", "text", isset($doc['DTCargaHoraria']) ? $doc['DTCargaHoraria'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['CargaHoraria']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Antiguedad'] ?></td>
                    <td><?php campo("DTAntiguedad", "text", isset($doc['DTAntiguedad']) ? $doc['DTAntiguedad'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Antiguedad']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Categoria'] ?></td>
                    <td><?php campo("DTCategoria", "text", isset($doc['DTCategoria']) ? $doc['DTCategoria'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Categoria']); ?></td>
                </tr>
                <tr>
                    <td><?php echo $idioma['Observacion'] ?></td>
                    <td><?php campo("Observacion", "text", isset($doc['Observacion']) ? $doc['Observacion'] : '', "span12", 1, $idioma['IngreseSu'] . $idioma['Observacion']); ?></td>
                </tr>
            </table>
            <input type="submit" value="<?php echo $idioma['Guardar'] ?>" class="btn">
        </div>
    </form>

<?php } ?>