<?php
include_once("../../login/check.php");
$titulo = "NAgendaAlumnos";
include_once("../../class/config.php");
include_once("../../class/alumno.php");
include_once("../../class/cursomateria.php");
include_once("../../class/materias.php");
include_once("../../class/cuota.php");
include_once("../../class/observaciones.php");
include_once("../../class/curso.php");
include_once("../../class/tarea.php");
include_once("../../class/agenda.php");
include_once("../../class/tarea.php");
include_once("../../class/registronotas.php");
include_once("../../class/casilleros.php");
$alumno = new alumno;
$config = new config;
$curso = new curso;
$tarea = new tarea;
$materia = new materias;
$cuota = new cuota;
$agenda = new agenda;
$tarea = new tarea;
$cursomateria = new cursomateria;
$observaciones = new observaciones;
$registronotas = new registronotas;
$casilleros = new casilleros;
$CodAlumno = $_SESSION['CodUsuarioLog'];
$al = $alumno->mostrarTodoDatos($CodAlumno);
$al = array_shift($al);
$cur = $curso->mostrarCurso($al['CodCurso']);
$cur = array_shift($cur);
$ManejarCuotas = ($config->mostrarConfig("ManejarCuotas", 1));
$ManejarTareas = ($config->mostrarConfig("ManejarTareas", 1));
$VisibleNotasPPFFAlumno = ($config->mostrarConfig("VisibleNotasPPFFAlumno", 1));
if ($ManejarCuotas == '1') {
    $Moneda = ($config->mostrarConfig("Moneda", 1));
    $FechaCuota1 = ($config->mostrarConfig("FechaCuota1", 1));
    $FechaCuota2 = ($config->mostrarConfig("FechaCuota2", 1));
    $FechaCuota3 = ($config->mostrarConfig("FechaCuota3", 1));
    $FechaCuota4 = ($config->mostrarConfig("FechaCuota4", 1));
    $FechaCuota5 = ($config->mostrarConfig("FechaCuota5", 1));
    $FechaCuota6 = ($config->mostrarConfig("FechaCuota6", 1));
    $FechaCuota7 = ($config->mostrarConfig("FechaCuota7", 1));
    $FechaCuota8 = ($config->mostrarConfig("FechaCuota8", 1));
    $FechaCuota9 = ($config->mostrarConfig("FechaCuota9", 1));
    $FechaCuota10 = ($config->mostrarConfig("FechaCuota10", 1));
} else {
    $cantidadCuotas = 10;
}
$mes = date("m");

//echo
$Foto = $al['Foto'] != "" ? $al['Foto'] : $al['Sexo'] . ".png";
$v = $config->mostrarConfig("LogoIcono");
$LogoIcono = $v['Valor'];
$folder = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $idioma['TituloSistema'] ?></title>
    <link href="<?php echo $folder ?>css/bootstrap.css" type="text/css" rel="stylesheet" />
    <link href="../../css/internet.css?1" type="text/css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo $folder ?>imagenes/logos/<?php echo $LogoIcono ?>" />
    <!-- Favicon para tabley ios -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $folder ?>imagenes/logos/<?php echo $LogoIcono ?>">
</head>

<body>
    <div class="contenedoracciones">
        <div class="contenedorbotones">
            <!-- <a href="../../" class="inicio"><?php echo $idioma["Inicio"] ?></a> -->
            <a href="../../login/logout.php" class="salir"><?php echo $idioma["Salir"] ?></a>
        </div>
    </div>

    <div class="row-fluid wrapper">
        <div class="span12">
            <div class="cabecera">

                <div class="contenedorfoto">
                    <img src="../../imagenes/alumnos/<?php echo $Foto ?>" class="img-circle fotoalumno" title="" />
                </div>
                <div class="contenedordatospersonales">
                    <h1 class="nombre"><?php echo ucwords($al['Paterno'] . " " . $al['Materno'] . " " . $al['Nombres']) ?></h1>
                    <p class="datospersonalessecundarios"><?php echo $cur['Nombre'] ?></p>
                    <p class="datospersonalessecundarios"><?php echo $al['Ci'] ?></p>
                    <p class="datospersonalessecundarios"><?php echo ucwords($al['Zona'] . " " . $al['Calle'] . " " . $al['Numero']) ?></p>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>

    <!--Estadísticas-->

    <?php
    $CodigosObservaciones = [];
    foreach ($observaciones->agruparObservaciones() as $CodOb) {
        $CodigosObservaciones[$CodOb['NivelObservacion']] = explode(",", $CodOb['CodObservaciones']);
    }

    $TotalesAgenda = $agenda->CantidadTotalAgrupado($CodAlumno);

    $CantObservaciones = 0;
    $CantFaltas = 0;
    $CantAtrasos = 0;
    $CantLicencias = 0;
    $CantNotificacion = 0;
    $CantNoContestan = 0;
    $CantFelicitacion = 0;

    foreach ($TotalesAgenda as $TotAgenda) {
        //Observaciones
        foreach ($CodigosObservaciones[1] as $CodOb) {
            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantObservaciones += $TotAgenda['Cantidad'] ?? 0;
            }
        }
        //Faltas
        foreach ($CodigosObservaciones[2] as $CodOb) {
            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantFaltas += $TotAgenda['Cantidad'] ?? 0;
            }
        }
        //Atrasos
        foreach ($CodigosObservaciones[3] as $CodOb) {

            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantAtrasos += $TotAgenda['Cantidad'] ?? 0;
            }
        }
        //Licencias
        foreach ($CodigosObservaciones[4] as $CodOb) {
            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantLicencias += $TotAgenda['Cantidad'] ?? 0;
            }
        }
        //Notificacion
        foreach ($CodigosObservaciones[5] as $CodOb) {
            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantNotificacion += $TotAgenda['Cantidad'] ?? 0;
            }
        }
        //NoContestan
        foreach ($CodigosObservaciones[6] as $CodOb) {
            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantNoContestan += $TotAgenda['Cantidad'] ?? 0;
            }
        }
        //Felicitacion
        foreach ($CodigosObservaciones[7] as $CodOb) {
            if ($TotAgenda['CodObservacion'] == $CodOb) {
                $CantFelicitacion += $TotAgenda['Cantidad'] ?? 0;
            }
        }
    }

    $Total = $CantObservaciones + $CantFaltas + $CantAtrasos + $CantLicencias + $CantNotificacion + $CantNoContestan + $CantFelicitacion;
    ?>

    <!--Agenda-->
    <div class="row-fluid wrapper">
        <?php if ($ManejarCuotas == '1') { ?>
            <div class="span3">
                <div class="cuerpo">
                    <h2><a name="cuotas"></a><?php echo $idioma["Cuotas"] ?></h2>
                    <table class="tabla">
                        <?php
                        $total = 0;
                        $totalDeuda = 0;
                        $cantidadCuotas = 0;
                        foreach ($cuota->mostrarCuotas($al['CodAlumno']) as $cuo) {
                            if ($cuo['Cancelado']) {
                                $cantidadCuotas++;
                            }
                        ?>
                            <tr>
                                <td class="div"><?php echo $cuo['Numero']; ?></td>
                                <td class="div"><?php echo $cuo['MontoPagar']; ?> <?php echo $Moneda ?></td>
                                <td><?php echo $cuo['Cancelado'] ? $idioma['Cancelado'] : $idioma['Pendiente']; ?></td>
                                <td><i class="icon-ok"></i></td>
                            </tr>
                        <?php
                            $total += $cuo['MontoPagar'];
                            if ($cuo['Cancelado']) {
                                $totalDeuda += $cuo['MontoPagar'];
                            }
                        }
                        ?>
                    </table>
                    <div class="msgA"><?php echo $idioma['MontoAdeudado'] ?>: <?php echo $total - $totalDeuda; ?> Bs.</div>
                </div>
            </div>
        <?php } ?>
        <div class="<?php echo ($ManejarCuotas == '1') ? 'span9' : 'span12'; ?>">
            <div class="cuerpo">
                <h2><a name="agenda"></a><?php echo $idioma['Agenda'] ?></h2>

                <table class="tablaresumen" style="margin-bottom: 20px;">
                    <tr class="cabeceratabla">
                        <th width="100"><?php echo $idioma['Observaciones'] ?></th>
                        <th width="100"><?php echo $idioma['Felicitaciones'] ?></th>
                        <th width="100"><?php echo $idioma['Faltas'] ?></th>
                        <th width="100"><?php echo $idioma['Atrasos'] ?></th>
                        <th width="100" class="columnaocultarmobile"><?php echo $idioma['Licencias'] ?></th>
                        <th width="100" class="columnaocultarmobile"><?php echo $idioma['NoRespondeTelf'] ?></th>
                        <th width="100" class="columnaocultarmobile"><?php echo $idioma['NotificacionPadres'] ?></th>
                        <th width="100" class="columnaocultarmobile"><?php echo $idioma['Total'] ?></th>
                    </tr>
                    <tr>
                        <td style="background: #B3D9FF;"><?php echo $CantObservaciones; ?></td>
                        <td style="background: #B9F2C3;"><?php echo $CantFelicitacion; ?></td>
                        <td style="background: #FFB6B9;"><?php echo $CantFaltas; ?></td>
                        <td style="background: #FFE5A9;"><?php echo $CantAtrasos; ?></td>
                        <td style="background: #AEEEEE;" class="columnaocultarmobile"><?php echo $CantLicencias; ?></td>
                        <td style="background: #FFD8A8;" class="columnaocultarmobile"><?php echo $CantNoContestan; ?></td>
                        <td style="background: #C3E6CB;" class="columnaocultarmobile"><?php echo $CantNotificacion; ?></td>
                        <td style="background: #f1f1f1;" class="columnaocultarmobile"><?php echo $Total; ?></td>
                    </tr>
                    <tr class="filamobile cabeceratabla">
                        <th><?php echo $idioma['Licencias'] ?></th>
                        <th><?php echo $idioma['NoRespondeTelf'] ?></th>
                        <th><?php echo $idioma['NotificacionPadres'] ?></th>
                        <th><?php echo $idioma['Total'] ?></th>
                    </tr>
                    <tr class="filamobile">
                        <td style="background: #AEEEEE;"><?php echo $CantLicencias; ?></td>
                        <td style="background: #FFD8A8;"><?php echo $CantNoContestan; ?></td>
                        <td style="background: #C3E6CB;"><?php echo $CantNotificacion; ?></td>
                        <td style="background: #f1f1f1; "><?php echo $Total; ?></td>
                    </tr>

                </table>
                <!--Lista de observaciones-->

                <table class="tabla">
                    <tr class="cabeceratabla">
                        <th width="25">Nº</th>
                        <th width="100"><?php echo $idioma['Fecha'] ?></th>
                        <th width="233"><?php echo $idioma['Materia'] ?></th>
                        <th width="150"><?php echo $idioma['Observacion'] ?></th>
                        <th width="350" class="columnaocultarmobile"><?php echo $idioma['Detalle'] ?></th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($agenda->mostrarRegistros($al['CodAlumno']) as $ag) {
                        $i++;
                        $ma = $materia->mostrarMateria($ag['CodMateria']);
                        $ma = array_shift($ma);
                        $obs = $observaciones->mostrarObser($ag['CodObservacion']);
                        $obs = array_shift($obs);
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date("d", strtotime($ag['Fecha'])) . "-" . mesNumeroToLiteralCorto(date("n", strtotime($ag['Fecha']))); ?></td>
                            <td><?php echo $ma['Nombre']; ?></td>
                            <td><?php echo $obs['Nombre']; ?></td>
                            <td class="columnaocultarmobile"><?php echo $ag['Detalle'] ?></td>
                        </tr>
                        <tr class="filamobile bordemobilevisible intercalado">
                            <td class="div"></td>
                            <td class="detalle" colspan="4"><?php echo $ag['Detalle'] ?></td>
                        </tr>
                    <?php
                    }
                    if ($i == 0) {
                    ?>
                        <tr>
                            <td colspan="5" class="centrar"><?php echo $idioma['NoCuentaConAnotacionesALaFecha'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

                <div style="margin-top:8px; ">
                    <strong style="color:red;">*</strong>
                    <span style="color:rgb(181, 181, 181)">
                        <?php echo $idioma['OrdenObservaciones'] ?>
                    </span>
                </div>

            </div>
        </div>
    </div>
    <?php if ($ManejarTareas == '1') { ?>
        <div class="row-fluid">
            <div class="span6">
                <div class="cuerpo">
                    <h2><a name="tareaspendientes"></a><?php echo $idioma['TareasPendientes'] ?></h2>
                    <div class="table-responsive">
                        <table class="tabla">
                            <tr class="cabecera">
                                <td width="15">Nº</td>
                                <td width="80"><?php echo $idioma['Materia'] ?></td>
                                <td width="160"><?php echo $idioma['Nombre'] ?></td>
                                <td width="130"><?php echo $idioma['Detalle'] ?></td>
                                <td width="80"><span title="<?php echo $idioma['FechaPresentacion'] ?>"><?php echo $idioma['Fecha'] ?></span></td>
                            </tr>
                            <?php
                            $i = 0;
                            $Fecha = date("Y-m-d");
                            foreach ($tarea->mostrarTareaCursoPendiente($al['CodCurso'], $Fecha) as $ta) {
                                $i++;
                                $ma = $materia->mostrarMateria($ta['CodMateria']);
                                $ma = array_shift($ma);
                            ?>
                                <tr>
                                    <td class="div"><?php echo $i; ?></td>
                                    <td class="div"><?php echo $ma['Nombre']; ?></td>
                                    <td class="div"><?php echo ucfirst(mb_strtolower($ta['Nombre'], "UTF-8")); ?></td>
                                    <td class="div"><?php echo ucfirst(mb_strtolower($ta['Descripcion'], "UTF-8")); ?></td>
                                    <td><?php echo utf8_encode(strftime("%A, %d-%b", strtotime($ta['FechaPresentacion']))) ?></td>
                                </tr>
                            <?php
                            }
                            if ($i == 0) {
                            ?>
                                <tr>
                                    <td colspan="5" class="centrar"><?php echo $idioma['NoTieneTareasPendientes'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="cuerpo">
                    <h2><a name="tareasrevisadas"></a><?php echo $idioma['TareasRevisadas'] ?></h2>
                    <div class="table-responsive">
                        <table class="tabla">
                            <tr class="cabecera">
                                <td width="15">Nº</td>
                                <td width="80"><?php echo $idioma['Materia'] ?></td>
                                <td width="160"><?php echo $idioma['Nombre'] ?></td>
                                <td width="130"><?php echo $idioma['Detalle'] ?></td>
                                <td width="80"><span title="<?php echo $idioma['FechaPresentacion'] ?>"><?php echo $idioma['Fecha'] ?></span></td>
                            </tr>
                            <?php
                            $i = 0;
                            $Fecha = date("Y-m-d");
                            foreach ($tarea->mostrarTareaCursoRevisadas($al['CodCurso'], $Fecha) as $ta) {
                                $i++;
                                $ma = $materia->mostrarMateria($ta['CodMateria']);
                                $ma = array_shift($ma);
                            ?>
                                <tr>
                                    <td class="div"><?php echo $i; ?></td>
                                    <td class="div"><?php echo $ma['Nombre']; ?></td>
                                    <td class="div"><?php echo ucfirst(mb_strtolower($ta['Nombre'], "UTF-8")); ?></td>
                                    <td class="div"><?php echo ucfirst(mb_strtolower($ta['Descripcion'], "UTF-8")); ?></td>
                                    <td><?php echo utf8_encode(strftime("%A, %d-%b", strtotime($ta['FechaPresentacion']))) ?></td>
                                </tr>
                            <?php
                            }
                            if ($i == 0) {
                            ?>
                                <tr>
                                    <td colspan="5" class="centrar"><?php echo $idioma['NoTieneTareasRevisadas'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="cuerpo">
                <h2><a name="notas"></a><?php echo $idioma['Notas'] ?></h2>
                <div class="table-responsive">
                    <?php if (!$VisibleNotasPPFFAlumno) :
                    ?>
                        <div class="alert alert-error"><?php echo $idioma['VisibleNotasPPFFAlumnoRestringido'] ?></div>
                    <?php else : ?>
                        <table class="tabla">
                            <tr class="cabecera">
                                <td width="150"><?php echo $idioma['Materias'] ?></td>
                                <?php for ($i = 1; $i <= $cur['CantidadEtapas']; $i++) { ?>
                                    <td colspan="<?php echo ($cur['Dps']) ? 3 : 1 ?>"><?php echo $i ?> <?php echo $cur['Bimestre'] ? $idioma['Bimestre'] : $idioma['Trimestre']; ?></td>
                                <?php } ?>
                                <td width="90"><?php echo $idioma['PromedioAnual'] ?></td>
                                <!-- <?php if ($cur['Bimestre'] == 0) { ?>
                                <td><?php echo $idioma['Reforzamiento'] ?></td>
                                <td><?php echo $idioma['PromedioFinal'] ?></td>
                            <?php } ?> -->
                            </tr>
                            <?php if ($cur['Bimestre']) { ?>
                                <tr></tr>
                            <?php } else { ?><tr>
                                    <td></td>
                                    <?php for ($i = 1; $i <= $cur['CantidadEtapas']; $i++) {
                                        if ($cur['Dps']) { ?>
                                            <td class="text-right">PC</td>
                                            <td class="text-right">DPS</td>
                                        <?php } ?>
                                        <td class="text-right">PT</td>
                                    <?php } ?>

                                    <td></td>
                                    <!-- <td></td>
                                    <td></td> -->
                                </tr>
                            <?php } ?>
                            <?php

                            foreach ($cursomateria->mostrarMaterias($al['CodCurso']) as $cm) {
                                $ma = $materia->mostrarMateria($cm['CodMateria']);
                                $ma = array_shift($ma);
                                for ($p = 1; $p <= $cur['CantidadEtapas']; $p++) {
                                    $casillas = $casilleros->mostrarMateriaCursoSexoTrimestre($cm['CodMateria'], $al['CodCurso'], $al['Sexo'], $p);
                                    $casillas = array_shift($casillas);
                                    if (!is_null($casillas)) {
                                        ${("rn" . $p)} = $registronotas->mostrarRegistroNotas($casillas['CodCasilleros'], $al['CodAlumno'], $p);
                                        ${("rn" . $p)} = array_shift(${("rn" . $p)});
                                    }
                                }
                                /*$casillas = $casilleros->mostrarMateriaCursoSexoTrimestre($cm['CodMateria'], $al['CodCurso'], $al['Sexo'], 1);
                            $casillas = array_shift($casillas);
                            $rn1 = $registronotas->mostrarRegistroNotas($casillas['CodCasilleros'], $al['CodAlumno'], 1);
                            $rn1 = array_shift($rn1);
                            $casillas = $casilleros->mostrarMateriaCursoSexoTrimestre($cm['CodMateria'], $al['CodCurso'], $al['Sexo'], 2);
                            $casillas = array_shift($casillas);
                            $rn2 = $registronotas->mostrarRegistroNotas($casillas['CodCasilleros'], $al['CodAlumno'], 2);
                            $rn2 = array_shift($rn2);
                            $casillas = $casilleros->mostrarMateriaCursoSexoTrimestre($cm['CodMateria'], $al['CodCurso'], $al['Sexo'], 3);
                            $casillas = array_shift($casillas);
                            $rn3 = $registronotas->mostrarRegistroNotas($casillas['CodCasilleros'], $al['CodAlumno'], 3);
                            $rn3 = array_shift($rn3);
                            $casillas = $casilleros->mostrarMateriaCursoSexoTrimestre($cm['CodMateria'], $al['CodCurso'], $al['Sexo'], 4);
                            $casillas = array_shift($casillas);
                            $rn4 = $registronotas->mostrarRegistroNotas($casillas['CodCasilleros'], $al['CodAlumno'], 4);
                            $rn4 = array_shift($rn4);*/


                                if ($cur['Bimestre']) {
                                    $promedio = $registronotas->promedioBimestre($rn1['NotaFinal'], $rn2['NotaFinal'], $rn3['NotaFinal'], $rn4['NotaFinal']);
                                } else {
                                    if (isset($rn1) && isset($rn2) && isset($rn3)) {
                                        $promedio = $registronotas->promedio($rn1['NotaFinal'], $rn2['NotaFinal'], $rn3['NotaFinal']);
                                    } else {
                                        $promedio = 0;
                                    }
                                }
                            ?>
                                <?php //echo $cantidadCuotas;
                                $mes = ($mes == "12") ? $mes - 1 : $mes;
                                ?>
                                <?php if ($cantidadCuotas >= ($mes - 1)) { ?>
                                    <tr>
                                        <td class="div"><?php echo $ma['Nombre']; ?></td>
                                        <?php if ($cur['Bimestre']) {
                                        ?>
                                            <td colspan="" class="div der <?php echo $cur['NotaAprobacion'] > $rn1['NotaFinal'] && $rn1['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn1['NotaFinal']; ?></td>
                                            <td colspan="" class="div der <?php echo $cur['NotaAprobacion'] > $rn2['NotaFinal'] && $rn2['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn2['NotaFinal']; ?></td>
                                            <td colspan="" class="div der <?php echo $cur['NotaAprobacion'] > $rn3['NotaFinal'] && $rn3['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn3['NotaFinal']; ?></td>
                                            <td colspan="" class="div der <?php echo $cur['NotaAprobacion'] > $rn4['NotaFinal'] && $rn4['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn4['NotaFinal']; ?></td>
                                            <?php
                                        } else {
                                            for ($i = 1; $i <= $cur['CantidadEtapas']; $i++) {
                                                $Resultado = ${("rn" . $i)}['Resultado'] ?? 0;
                                                $Dps = ${("rn" . $i)}['Dps'] ?? 0;
                                                $NotaFinal = ${("rn" . $i)}['NotaFinal'] ?? 0;
                                                if ($cur['Dps']) { ?>
                                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $NotaFinal && $NotaFinal != 0 ? 'rojo' : ''; ?>"><?php echo $Resultado; ?></td>
                                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $NotaFinal && $NotaFinal != 0 ? 'rojo' : ''; ?>"><?php echo $Dps; ?></td>
                                                <?php } ?>
                                                <td class="div der <?php echo $cur['NotaAprobacion'] > $NotaFinal && $NotaFinal != 0 ? 'rojo' : ''; ?>"><?php echo $NotaFinal; ?></td>
                                        <?php }

                                            /*?>
                                            <!-- <td class="div der <?php echo $cur['NotaAprobacion'] > $rn2['NotaFinal'] && $rn2['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn2['Resultado']; ?></td>
                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $rn2['NotaFinal'] && $rn2['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn2['Dps']; ?></td>
                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $rn2['NotaFinal'] && $rn2['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn2['NotaFinal']; ?></td>
                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $rn3['NotaFinal'] && $rn3['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn3['Resultado']; ?></td>
                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $rn3['NotaFinal'] && $rn3['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn3['Dps']; ?></td>
                                    <td class="div der <?php echo $cur['NotaAprobacion'] > $rn3['NotaFinal'] && $rn3['NotaFinal'] != 0 ? 'rojo' : ''; ?>"><?php echo $rn3['NotaFinal']; ?></td> -->
                                        <?php
                                        */
                                        } ?>
                                        <td class="div der <?php echo $cur['NotaAprobacion'] > $promedio && $promedio != 0 ? 'rojo' : ''; ?>"><?php echo $promedio ?></td>
                                        <?php if ($cur['Bimestre'] == 0) {
                                            if (isset($rn4) && $rn4['Nota2'] != "0") {
                                                $promedioanual = round(($promedio + $rn4['Nota2']) / 2);
                                            } else {
                                                $promedioanual = $promedio;
                                            }
                                            /*
                                        ?>
                                            <!-- <td class="div der"><?php echo isset($rn4) ? $rn4['Nota2'] : '' ?></td>
                                        <td class="der <?php echo $cur['NotaAprobacion'] > $promedioanual && $promedioanual != 0 ? 'rojo' : ''; ?>"><?php echo $promedioanual ?></td> -->
                                        <?php */
                                        } ?>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="13"><?php echo $idioma['DebeCancelarMensualidades'] ?></td>
                                    </tr>
                                <?php break;
                                } ?>
                            <?php
                            }
                            ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="cuerpo pie">
                <?php echo $idioma['TituloSistema'] ?> &copy; <?php echo $idioma['DerechosReservados'] ?> 2011 - <?php echo date("Y") ?>
                <p class="pull-right"><?php echo $idioma['DesarrolladoPor']; ?>: <a href="https://ninatic.net" title="https://ninatic.net - 73230568" target="_blank" class="link">Ronald Nina Layme</a></p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-30922203-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
</body>

</html>