<?php
require_once 'login/check.php';

include_once 'class/alumno.php';
$alumno = new alumno;
include_once 'class/config.php';
$conf = new config;
include_once 'class/curso.php';
$curso = new curso;
include_once 'class/cuota.php';
$cuota = new cuota;

$cursos = $curso->mostrarTodoRegistro('', 1, 'Nombre');
foreach ($cursos as $c) {
    $cursosGeneralMontoCuota[$c['CodCurso']] = $c['MontoCuota'];
}

$alumnos = $alumno->mostrarTodoRegistro('', 0);
foreach ($alumnos as $al) {
    $CodAlumno = $al['CodAlumno'];
    $Paterno = $al['Paterno'];
    $Materno = $al['Materno'];
    $FechaNac = $al['FechaNac'];
    $Ci = $al['Ci'];
    //fecha de nacimiento debe ser su password
    $Password = date("jnY", strtotime($FechaNac));
    $PasswordP = date("jnY", strtotime($FechaNac));

    $UsuarioPadre = $Ci;
    if ($Paterno != '') {
        $CodUsuarioAlumno = trim(minuscula(quitarSimbolos($Paterno))) . $CodAlumno;
    } else {
        $CodUsuarioAlumno = trim(minuscula(quitarSimbolos($Materno))) . $CodAlumno;
    }

    $AccesoSistema = 1;
    $CodigoBarra = ($conf->mostrarConfig("CodBarra", 1));
    $CodBarra = trim($CodigoBarra) . $CodAlumno;
    $valores = [
        'UsuarioAlumno' => "'$CodUsuarioAlumno'",
        'CodBarra' => "'$CodBarra'",
        'Password' => "'$Password'",
        'PasswordP' => "'$PasswordP'",
        'UsuarioPadre' => "'$UsuarioPadre'",
        'Activo' => 0,
        'AccesoSistema' => "'$AccesoSistema'",
    ];

    $alumno->actualizarDatosAlumno($valores, $CodAlumno);

    // Cuotas
    $CodCurso = $al['CodCurso'];

    for ($ncuota = 1; $ncuota <= 10; $ncuota++) {
        $cuotas = $cuota->mostrarTodoRegistro("CodAlumno = $CodAlumno AND Numero = $ncuota", '');

        $valorCuota = [
            'CodAlumno' => $CodAlumno,
            'Numero' => $ncuota,
            'MontoPagar' => $cursosGeneralMontoCuota[$CodCurso],
            'Cancelado' => 0,
        ];


        if (count($cuotas) == 0) {
            $cuota->insertarRegistro($valorCuota);
        } else {
            $cuota->actualizarCuota($valorCuota, "CodAlumno = $CodAlumno and Numero = $ncuota");
        }
    }
}
