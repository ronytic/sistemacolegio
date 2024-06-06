<?php
require_once '../login/check.php';
require_once '../class/alumno.php';
require_once '../class/cuota.php';
require_once '../class/curso.php';

$alumno = new alumno();
$curso = new curso;
$cursos = $curso->mostrarTodoRegistro("CodCurso=1");
$cuota = new cuota();
foreach ($cursos as $cur) {
    $alumnos = $alumno->mostrarDatosAlumnos($cur['CodCurso'], 0);
    foreach ($alumnos as $al) {
        $cuotas = $cuota->mostrarCuotas($al['CodAlumno']);
        for ($numeroCuota = 1; $numeroCuota <= 10; $numeroCuota++) {
            $flagExiste = false;
            foreach ($cuotas as $cuo) {
                if ($cuo['Numero'] == $numeroCuota) {
                    $flagExiste = true;
                    break;
                }
            }
            if (!$flagExiste) {
                $cuota->guardar(array(
                    "CodAlumno" => $al['CodAlumno'],
                    "Numero" => $numeroCuota,
                    "MontoPagar" => 300,
                    "Fecha" => date("Y-m-d")
                ));
            }
        }
        // $al['cuotas'] = $cuotas;
    }
}
// var_dump($alumnos);
