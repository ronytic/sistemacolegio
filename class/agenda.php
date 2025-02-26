<?php
include_once "bd.php";
class agenda extends bd
{
    public $tabla = "agenda";
    public function insertarRegistro($Values, $Todo = 1)
    {
        $this->tabla = "agenda";
        return $this->insertRow($Values, 1);
    }
    public function mostrarRegistroCurso($CodDocente, $CodCurso)
    {
        $this->tabla = "agenda";
        $this->campos = array("*");
        return $this->getRecords("CodUsuario=$CodDocente and CodCurso=$CodCurso and Activo=1", " FechaRegistro,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarRegistroFecha($Fecha)
    {
        $this->tabla = "agenda";
        $this->campos = array("*"); //CodUsuario=$CodDocente and
        return $this->getRecords("Fecha='$Fecha' and Activo=1", " Fecha DESC,HoraRegistro", 0, 0, 0, 1);
    }

    public function mostrarRegistroSinRetiradosFecha($Fecha)
    {
        $this->campos = array("a.*", "al.Nombres Nombres, al.Paterno Paterno, al.Materno Materno", "c.Nombre NombreCurso, c.Abreviado AbreviadoCurso, c.Bimestre", "o.*", "m.Nombre NombreMateria,m.Abreviado AbreviadoMateria");
        $this->tabla = "agenda a, alumno al, curso c, observaciones o, materias m";
        $registros = $this->getRecords("a.Fecha='$Fecha' and a.Activo=1 and al.CodAlumno=a.CodAlumno and al.Retirado=0 and c.CodCurso=al.CodCurso and o.CodObservacion=a.CodObservacion and a.CodMateria=m.Codmateria", "a.Fecha DESC,a.HoraRegistro", 0, 0, 0, 1);
        $this->tabla = "agenda";
        return $registros;
    }

    public function mostrarRegistroMateria($CodDocente, $CodCurso, $Materia)
    {
        $this->tabla = "agenda";
        $this->campos = array("*"); //CodUsuario=$CodDocente and
        return $this->getRecords("CodCurso=$CodCurso and CodMateria=$Materia and Activo=1", " Fecha DESC,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarRegistroMateriaAlumno($CodDocente, $CodCurso, $Materia, $CodAlumno)
    {
        $this->tabla = "agenda";
        $this->campos = array("*"); //CodUsuario=$CodDocente and
        return $this->getRecords("CodCurso=$CodCurso and CodMateria=$Materia and CodAlumno=$CodAlumno and Activo=1", " FechaRegistro DESC,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarRegistroAlumno($CodDocente, $CodCurso, $Materia, $CodAlumno)
    {
        $this->tabla = "agenda";
        $this->campos = array("*");
        return $this->getRecords("CodUsuario=$CodDocente and CodCurso=$CodCurso and CodMateria=$Materia and CodAlumno=$CodAlumno and Activo=1", " FechaRegistro DESC,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarCodMateriaCodAlumno($CodMateria, $CodAlumno)
    {
        $this->tabla = "agenda";
        $this->campos = array("*");
        return $this->getRecords("CodMateria=$CodMateria and CodAlumno=$CodAlumno and Activo=1", " FechaRegistro DESC,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarCodMateriaCodAlumnoRango($CodMateria, $CodAlumno, $Inicio, $Fin)
    {
        $this->tabla = "agenda";
        $this->campos = array("*");
        return $this->getRecords("CodMateria=$CodMateria and CodAlumno=$CodAlumno and Activo=1 and Fecha BETWEEN '$Inicio' and  '$Fin'", " FechaRegistro DESC,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarCodCursoCodObservacionCodAlumnoRango($CodCurso, $CodObservacion, $CodAlumno, $Inicio, $Fin)
    {
        $this->tabla = "agenda";
        $this->campos = array("count(*) as Cantidad");
        return $this->getRecords("CodCurso=$CodCurso and CodObservacion=$CodObservacion and CodAlumno=$CodAlumno and Activo=1 and Fecha BETWEEN '$Inicio' and  '$Fin'", " FechaRegistro DESC,HoraRegistro", 0, 0, 0, 1);
    }
    public function mostrarRegistros($CodAlumno)
    {
        $this->tabla = "agenda";
        $this->campos = array("*");
        return $this->getRecords("CodAlumno=$CodAlumno and Activo=1", "Fecha DESC,CodAgenda", 0, 0, 0, 1);
    }
    public function CantidadObservaciones($CodAlumno = "", $CodObservaciones, $CodMateria = "", $Fecha = "")
    {
        $this->campos = array("count(*) as Cantidad");
        if ($CodMateria == "") {
            $Materia = "";
        } else {
            $Materia = "and a.CodMateria=$CodMateria";
        }
        if ($CodAlumno == "") {
            $CodAl = "";
        } else {
            $CodAl = "and a.CodAlumno=$CodAlumno";
        }
        if ($Fecha == "") {
            $fech = "";
        } else {
            $fech = "and a.Fecha='$Fecha'";
        }
        $this->tabla = "agenda a, alumno al";
        return $this->getRecords("a.CodAlumno = al.CodAlumno and al.Retirado = 0 and a.CodObservacion IN($CodObservaciones) and a.Activo=1 $CodAl $Materia $fech");
    }
    public function MostrarAgenda($CodAgenda)
    {
        $this->tabla = "agenda";
        $this->campos = array("*");
        return $this->getRecords("CodAgenda=$CodAgenda and Activo=1");
    }
    public function CantidadObservacionesTotal($CodCurso = "", $CodAlumno = "", $CodObservaciones = "", $CodMateria = "", $Fecha = "")
    {
        $this->campos = array("count(*) as Cantidad", "CodObservacion");

        if ($CodMateria == "") {
            $Materia = "";
        } else {
            $Materia = "and a.CodMateria=$CodMateria";
        }
        if ($CodCurso == "") {
            $Curso = "";
        } else {
            $Curso = "and a.CodCurso=$CodCurso";
        }
        if ($CodAlumno == "") {
            $CodAl = "";
        } else {
            $CodAl = "and a.CodAlumno=$CodAlumno";
        }
        if ($Fecha == "") {
            $fech = "";
        } else {
            $fech = "and a.Fecha='$Fecha'";
        }
        $this->tabla = "agenda a, alumno al";
        return $this->getRecords("a.CodAlumno = al.CodAlumno and al.Retirado = 0 and a.CodObservacion IN($CodObservaciones) and a.Activo=1 $Curso $CodAl $Materia $fech", '', 'a.CodObservacion');
    }

    public function CantidadTotalAgrupado($CodAlumno = '', $Fecha = '')
    {
        if ($CodAlumno != "") {
            $whereCodAlumno = "a.CodAlumno=$CodAlumno";
        } else {
            $whereCodAlumno = "";
        }
        if ($Fecha != "") {
            $whereFecha = " a.Fecha='$Fecha'";
            if ($whereCodAlumno != "") {
                $whereFecha = " and " . $whereFecha;
            }
        } else {
            $whereFecha = "";
        }
        /*SELECT count(*) CantidadObservaciones,
                    CodObservacion
                FROM `agenda`
                WHERE CodAlumno = 681 and Activo = 1
                GROUP BY CodObservacion;*/
        $this->campos = array("count(*) as Cantidad", "a.CodObservacion");
        $this->tabla = "agenda a, alumno al";
        return $this->getRecords("$whereCodAlumno $whereFecha and a.Activo = 1 and a.CodAlumno = al.CodAlumno and al.Retirado=0", "a.CodObservacion", "a.CodObservacion");
    }
    public function actualizarAgendaE($values, $where)
    {
        $this->updateRow($values, $where);
    }
}
