<?php
include_once("fpdf_protection.php");
if (!defined("Config")) {
	include_once("../../class/config.php");
}
if (!isset($config)) {
	$config = new config;
}
$cnf = $config->mostrarConfig("Titulo");
$title = $cnf['Valor'];
$cnf = $config->mostrarConfig("Gestion");
$gestion = $cnf['Valor'];
$cnf = $config->mostrarConfig("Lema");
$lema = $cnf['Valor'];
$cnf = $config->mostrarConfig("Logo");
$logo = $cnf['Valor'];
include_once("../../funciones/usuarios.php");
$Nivel = $_SESSION['Nivel'];
$CodigoUsuario = $_SESSION['CodUsuarioLog'];
$DatosGenerador = DatosUsuario($Nivel, $CodigoUsuario);
// $tam = isset($tam) ? $tam : '';
class PPDF extends FPDF_Protection
{
	var $ancho = 176;
	var $altocelda = 5;
	var $OrientacionObligada  = "";
	function Header()
	{
		global $idioma, $FechaReporte, $tam;
		$this->SetTitle(("Sistema Académico y Administrativo para Colegios"), true);
		$this->SetAuthor(("Sistema Académico y Administrativo para Colegios Desarrollado por Ronald Nina Layme. Cel: 73230568 - www.facebook.com/ronaldnina"), true);
		$this->SetSubject(("Sistema Académico y Administrativo para Colegios Desarrollado por Ronald Nina Layme. Cel: 73230568 - www.facebook.com/ronaldnina"), true);
		$this->SetCreator(("Sistema Académico y Administrativo para Colegios Desarrollado por Ronald Nina Layme. Cel: 73230568 - www.facebook.com/ronaldnina"), true);
		//$this->SetProtection(array('print'));
		if ($this->CurOrientation == "P") {
			$this->ancho = $this->w - 40;
		} else {
			$this->ancho = $this->w - 33.4;
		}
		$this->SetLeftMargin(18);
		$this->SetAutoPageBreak(true, 15);
		global $title, $gestion, $titulo, $logo, $idioma;
		$fecha = ucfirst(mb_strtolower(textoDia(date("Y-m-d")), "utf8"));

		$this->Image("../../imagenes/logos/" . $logo, 10, 10, 20, 20);
		$this->Fuente("", $tam);
		$this->SetXY(34, 12);
		$this->Cell(70, 4, utf8Decode($title), 0, 0, "L");
		$this->Fuente("B", 8);
		$this->SetXY(34, 16);
		$this->Cell(70, 4, utf8Decode($gestion), 0, 0, "L");
		$this->ln(10);
		$this->Fuente("B", 18);
		$this->Cell($this->ancho, 4, utf8Decode($titulo), 0, 5, "C");
		$this->ln(5);
		if (!isset($FechaReporte)) {
			$this->CuadroCabecera(32, $idioma['FechaReporte'] . ": ", 50, ($fecha));
			$this->ln(5);
		}

		if (in_array("Cabecera", get_class_methods($this))) {
			$this->Cabecera();
		}
		$this->ln();

		$this->Cell($this->ancho, 0, "", 1, 1);
		$this->Ln(0.1);
	}
	function Pagina()
	{
		global $idioma;
		$this->AliasNbPages();
		$this->CuadroCabecera(15, $idioma['Pagina'] . ":", 20, $this->PageNo() . " " . $idioma['De'] . " {nb}");
	}
	function AltoCelda($a)
	{
		$this->altocelda = $a;
	}
	function Fuente($tipo = "B", $tam = 10)
	{
		$this->SetFillColor(234, 234, 234);
		$this->SetFont("Arial", $tipo, $tam);
	}
	function CuadroCabecera($txt1Ancho, $txt1, $txt2Ancho, $txt2)
	{
		$this->Fuente("B");
		$this->Cell($txt1Ancho, 4, utf8Decode($txt1), 0, 0, "L");
		$this->Fuente("");
		$this->Cell($txt2Ancho, 4, utf8Decode($txt2), 0, 0, "L");
	}
	function TituloCabecera($txtAncho, $txt, $tam = 10, $borde = 1, $align = "C")
	{
		$this->Fuente("B", $tam);
		$this->Cell($txtAncho, 4, utf8Decode($txt), $borde, 0, $align);
	}
	function CuadroCuerpo($txtAncho, $txt, $relleno = 0, $align = "L", $borde = 0, $tam = 9, $tipo = "")
	{

		$this->Fuente($tipo, $tam);
		$this->Cell($txtAncho, $this->altocelda, utf8Decode($txt), $borde, 0, $align, $relleno);
	}
	function CuadroCuerpoMulti($txtAncho, $txt, $relleno = 0, $align = "L", $borde = 0, $tam = 9, $tipo = "")
	{
		$this->Fuente($tipo, $tam);
		$this->MultiCell($txtAncho, 5, utf8Decode($txt), $borde, $align, $relleno);
	}
	function CuadroCuerpoPersonalizado($txtAncho, $txt, $relleno = 0, $align = "L", $borde = 0, $tipo = "", $tam = 10)
	{
		$this->Fuente($tipo, $tam);
		$this->Cell($txtAncho, 5, utf8Decode($txt), $borde, 0, $align, $relleno);
	}
	function CuadroCuerpoResaltar($txtAncho, $txt, $relleno = 0, $align = "L", $borde = 0, $resaltar = 2, $tipo = "", $tam = 10)
	{
		$this->Fuente($tipo, $tam);
		switch ($resaltar) {
				//case 1:{$this->SetFillColor(179,179,179);}break;
				//case 2:{$this->SetFillColor(135,135,135);}break;
			case 2: {
					$this->SetFillColor(190, 190, 190);
				}
				break;
			case 1: {
					$this->SetFillColor(210, 210, 210);
				}
				break;
		}
		$this->Cell($txtAncho, 5, utf8Decode($txt), $borde, 0, $align, $relleno);
	}
	function CuadroNombre($txtAncho, $Paterno, $Materno, $Nombres, $Full = 0, $relleno)
	{
		if ($Full) {
			$this->CuadroCuerpo($txtAncho, ucwords($Paterno . " " . $Materno . " " . $Nombres), $relleno);
		} else {
			$Nombre = explode(" ", $Nombres);
			$Nombre = array_shift($Nombre);
			$this->CuadroCuerpo($txtAncho, ucwords($Paterno . " " . $Materno . " " . $Nombre), $relleno);
		}
	}
	function CuadroNombreSeparado($txtAnchoP, $Paterno, $txtAnchoM, $Materno, $txtAnchoN, $Nombres, $Full, $relleno)
	{
		if ($Full) {
			$this->CuadroCuerpo($txtAnchoP, ucwords($Paterno), $relleno);
			$this->CuadroCuerpo($txtAnchoM, ucwords($Materno), $relleno);
			$this->CuadroCuerpo($txtAnchoN, ucwords($Nombres), $relleno);
		} else {
			$Nombre = array_shift(explode(" ", $Nombres));
			$this->CuadroCuerpo($txtAnchoP, ucwords($Paterno), $relleno);
			$this->CuadroCuerpo($txtAnchoM, ucwords($Materno), $relleno);
			$this->CuadroCuerpo($txtAnchoN, ucwords($Nombre), $relleno);
		}
	}
	function Linea()
	{
		$this->Cell($this->ancho, 0, "", 1, 1);
		$this->Ln();
	}
	function Footer()
	{
		global $lema, $idioma, $DatosGenerador;

		$DatosUsuario = capitalizar($DatosGenerador['TipoUsuario'] . ", " . $DatosGenerador['Paterno'] . " " . $DatosGenerador['Materno'] . " " . $DatosGenerador['Nombres']);

		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$BordePie = 0;
		$this->Fuente("I", 7.5);
		$this->Cell($this->ancho + 5, 0, "", 1, 1);
		if ($this->ancho <= 200) {

			$Resto = 35;
			// $DatosReporteGenerado = utf8_decode($idioma['ReporteGenerado']) . ": " . date('d-m-Y H:i:s') . " " . $DatosUsuario;
			$DatosReporteGenerado = utf8Decode($idioma['ReporteGenerado']) . ": " . date('d-m-Y H:i:s') . " ";
			$this->Cell(60, 3, $DatosReporteGenerado, $BordePie, 0, "L");

			$this->Cell((round(($this->ancho - 50) / 2) + 55 - 0), 3, utf8Decode($idioma['TituloSistema'] . ""), $BordePie, 0, "R");
			$this->ln();
			$this->Cell((round(($this->ancho - 50) / 2) + 0), 3, $idioma['Por'] . ": " . $DatosUsuario, $BordePie, 0, "L");

			$this->Fuente("I", 8);
			$this->Cell((round(($this->ancho - 50) / 2) + 30 - $Resto), 3, utf8Decode($lema), $BordePie, 0, "C");
			$this->Fuente("I", 7);

			$this->Cell((round(($this->ancho - 50) / 2) + 00), 3, "Desarrollado por Ronald Nina", $BordePie, 0, "R");
		} else {

			if ($this->CurOrientation == "P" || $this->OrientacionObligada == "L") {
				$Resto = 0;
				$DatosReporteGenerado = utf8Decode($idioma['ReporteGenerado']) . ": " . date('d-m-Y H:i:s') . " ";
				$this->Cell(50, 3, $DatosReporteGenerado, $BordePie, 0, "L");
			} else {
				$Resto = 35;
				$DatosReporteGenerado = utf8Decode($idioma['ReporteGenerado']) . ": " . date('d-m-Y H:i:s') . " " . $DatosUsuario;
				$this->Cell(90, 3, $DatosReporteGenerado, $BordePie, 0, "L");
			}

			$this->Fuente("I", 8);
			$this->Cell((round(($this->ancho - 50) / 2) - $Resto), 3, utf8Decode($lema), $BordePie, 0, "C");
			$this->Fuente("I", 7);


			if ($this->CurOrientation == "P" || $this->OrientacionObligada == "L") {
				$this->Cell((round(($this->ancho - 50) / 2) + 0), 3, utf8Decode($idioma['TituloSistema'] . ""), $BordePie, 0, "R");
				$this->ln();

				$this->Cell((round(($this->ancho - 50) / 2) + 50), 3, $idioma['Por'] . ": " . $DatosUsuario, $BordePie, 0, "L");
				$this->Cell((round(($this->ancho - 50) / 2) + 00), 3, "Desarrollado por Ronald Nina", $BordePie, 0, "R");
			} else {
				$this->Cell((round(($this->ancho - 50) / 2) + 1), 3, utf8Decode($idioma['TituloSistema'] . " - Desarrollado por Ronald Nina"), $BordePie, 0, "R");
			}

			//$this->Cell(60,4,utf8_decode($idioma['ReporteGenerado']).": ".date('d-m-Y H:i:s'),0,0,"R");
		}

		if (in_array("Pie", get_class_methods($this))) {
			$this->Pie();
		}
	}

	function Pie() {}
	function Cabecera() {}
}
