<?php
include_once("../../login/check.php");
include_once("../../class/alumno.php");
include_once("../../class/curso.php");
if (!empty($_POST)) {
    $al = new alumno;
    $rude = new alumno;
    $curso = new curso;
    @$CodAlumno = $_POST['CodAlumno'];

    $CantidadTotal = 0;
    $CantidadTotalV = 0;
    $CantidadTotalM = 0;
    $CantidadNuevos = 0;


    $titulos = array();
    $cantidad = array();
    $inscritosXDias = $al->contarInscritoFechas();
    foreach ($inscritosXDias as $k => $CantidadFechas) {
        $textoDia = ucfirst(mb_strtolower(textoDia($CantidadFechas['FechaIns'])));
        $inscritosXDias[$k]['TextoDia'] = $textoDia;
        array_push($titulos, "'" . $textoDia . "'");
        array_push($cantidad, $CantidadFechas['CantidadFecha']);
        $CantidadTotal += $CantidadFechas['CantidadFecha'];
    }
    $titulos = implode(",", $titulos);
    $cantidad = implode(",", $cantidad);
?>
    <table class="table">
        <thead>
            <tr>
                <th width="50%" class="der"><?php echo $idioma['CantidadTotalInscritos'] ?></th>
                <th width="50%" class="alert alert-info"><?php echo $CantidadTotal; ?> <?php echo $idioma['Alumnos'] ?></th>
            </tr>
        </thead>
    </table>
    <div id="reporte"></div>
    <a href="#" class="imprimir btn btn-info btn-mini"><?php echo $idioma['Imprimir'] ?></a><br>
    <a href="#" class="btn btn-success btn-mini" id="exportarexcel"><?php echo $idioma['ExportarExcel'] ?></a>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <thead>
            <tr class="cabecera">
                <th><?php echo $idioma['Fechas'] ?></th>
                <th><?php echo $idioma['CantidadTotal'] ?></th>
            </tr>
        </thead>
        <?php

        foreach ($inscritosXDias as $CantidadFechas) {
        ?>
            <tr class="contenido">
                <td><?php echo $CantidadFechas['TextoDia']; ?></td>
                <td><?php echo $CantidadFechas['CantidadFecha']; ?> <?php echo $idioma['Alumnos'] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <a href="#" class="btn btn-success btn-mini" id="exportarexcel"><?php echo $idioma['ExportarExcel'] ?></a>
    <table class="table table-hover table-bordered table-striped" id="cantidades">
        <thead>
            <tr class="cabecera">
                <th><?php echo $idioma['Cursos'] ?></th>
                <th><?php echo $idioma['CantidadTotal'] ?></th>
                <th><?php echo $idioma['Hombres'] ?></th>
                <th><?php echo $idioma['Mujeres'] ?></th>
                <th colspan="2"><?php echo $idioma['Nuevos'] ?></th>
            </tr>
        </thead>
        <?php
        $cursos = $al->cantidadAlumnosGeneral();
        $CantidadTotal = 0;
        foreach ($cursos as $row) {

            $cantidadMasculino = $row['TotalMasculino'] ?? 0;
            $cantidadFemenino = $row['TotalFemenino'] ?? 0;
            $cantidadNuevos = $row['TotalNuevo'] ?? 0;

            $CantidadTotalM += $cantidadFemenino;
            $CantidadTotalV += $cantidadMasculino;
            $CantidadNuevos += $cantidadNuevos;
            $CantidadTotal += $row['CantidadTotal'];

        ?>
            <tr class="contenido">
                <td><?php echo $row['NombreCurso']; ?></td>
                <td><?php echo $row['CantidadTotal']; ?> <?php echo $idioma['Alumnos'] ?></td>
                <td><?php echo $cantidadMasculino; ?> <?php echo $idioma['Alumnos'] ?></td>
                <td><?php echo $cantidadFemenino; ?> <?php echo $idioma['Alumnas'] ?></td>
                <td class="text-right"><?php echo $cantidadNuevos ?> </td>
                <td><a class="btn btn-mini vermasnuevo" title="<?php echo $idioma["VerAlumnosNuevos"] ?>" rel="<?php echo $row['CCurso'] ?>"><i class="icon-chevron-down"></i></a></td>

            </tr>
        <?php
        }
        ?>
        <tfoot>
            <tr class="contenido resaltar">
                <th><?php echo $idioma['TodoColegio'] ?></th>
                <th><?php echo $CantidadTotal; ?> <?php echo $idioma['Alumnos'] ?></th>
                <th><?php echo $CantidadTotalV; ?> <?php echo $idioma['Alumnos'] ?></th>
                <th><?php echo $CantidadTotalM ?> <?php echo $idioma['Alumnas'] ?></th>
                <th><?php echo $CantidadNuevos; ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <div class="alumnosnuevos oculto">
        <div class="box-header">
            <h2><?php echo $idioma['AlumnosNuevos'] ?></h2>
        </div>
        <div class="box-content" id="alumnosnuevos">
        </div>
    </div>



    <div class="clear"></div>
<?php

}

?>
<script language="javascript" type="text/javascript" src="../../js/core/plugins/highcharts.js"></script>
<script language="javascript" type="text/javascript" src="../../js/core/plugins/exporting.js"></script>
<script type="text/javascript">
    $(function() {
        var chart;
        $(document).ready(function() {
            $(".imprimir").click(function(e) {
                e.preventDefault();
                chart.print();
            });
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'reporte',
                    type: 'line'
                },
                title: {
                    text: '<?php echo $idioma['EstadisticasInscritos'] ?>'
                },
                subtitle: {
                    text: '<?php echo $idioma['Fecha'] ?>: <?php echo  textoDia(date("Y-m-d")) ?>'
                },
                xAxis: {
                    categories: [<?php echo $titulos ?>],
                    labels: {
                        rotation: -90,
                        align: 'right',
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '<?php echo $idioma['CantidadInscritos'] ?>'
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y + ' <?php echo $idioma['Inscritos'] ?>';
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                },
                legend: false,
                series: [{
                    name: '<?php echo $idioma['CantidadInscritos']; ?>',
                    data: [<?php echo $cantidad ?>]
                }],
                navigation: {
                    buttonOptions: {
                        enabled: false
                    }
                }
            });
        });

    });
</script>