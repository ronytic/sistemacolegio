<?php
include_once("../../login/check.php");
$CodAlumno = $_POST['CodAlumno'];
//echo "-".$CodAlumno."-";
if ($CodAlumno == "null") {
	exit();
}
include_once("../../class/config.php");
$config = new config;
$SistemaFacturacion = $config->mostrarConfig("SistemaFacturacion", 1);
$EstadoSms = $config->mostrarConfig("EstadoSms", 1);
$ManejarCuotas = $config->mostrarConfig("ManejarCuotas", 1);
$ManejarRude = $config->mostrarConfig("ManejarRude", 1);
?>
<div class="row-fluid">
	<?php
	if (in_Array($_SESSION['Nivel'], [1, 2])) {

		$men1 = [];
		if ($SistemaFacturacion != '0') {
			$men1[] = array("Nombre" => "RegistrarFactura", "Url" => "factura/registro/?CodAlumno=$CodAlumno", "Imagen" => "facturaregistro.png");
		}
		$men1[] = array("Nombre" => "Agenda", "Url" => "agenda/total/agenda.php?CodAl=$CodAlumno", "Imagen" => "agendaregistro.png");
		if ($EstadoSms != 'NoEnviar') {
			$men1[] = array("Nombre" => "EnviarMensajePrivado", "Url" => "sms/enviarmensaje/?CodAlumno=$CodAlumno", "Imagen" => "sms2.png");
		}
		$men1[] = array("Nombre" => "VerBoletin", "Url" => "notas/boletines/?CodAlumno=$CodAlumno", "Imagen" => "boletin.png");
		if ($ManejarCuotas == 1) {
			$men1[] = array("Nombre" => "PagarCuotas", "Url" => "cuotas/pagar/?CodAlumno=$CodAlumno", "Imagen" => "pagar.png");
			$men1[] = array("Nombre" => "ImprimirTarjetaCuotas", "Url" => "cuotas/tarjetacuotas/?CodAlumno=$CodAlumno", "Imagen" => "impresion.png");
		}
		$men1[] = array("Nombre" => "DatosAlumno", "Url" => "alumno/datosalumno/?CodAlumno=$CodAlumno", "Imagen" => "alumnoeditar.png");
		$men1[] = array("Nombre" => "VerBoletaDatos", "Url" => "alumno/boletadatos/?CodAlumno=$CodAlumno", "Imagen" => "verdatos.png");
		if ($ManejarRude == 1) {
			$men1[] = array("Nombre" => "ModificarRude", "Url" => "rude/editarrude/?CodAlumno=$CodAlumno", "Imagen" => "editarrude.png");
			$men1[] = array("Nombre" => "VerRudeImpresion", "Url" => "rude/verrude/?CodAlumno=$CodAlumno", "Imagen" => "verrude.png");
		}
		$men1[] = array("Nombre" => "CodigosAlumnos", "Url" => "codigos/alumnos/?CodAlumno=$CodAlumno", "Imagen" => "codigosalumnos.png");
		if ($EstadoSms != 'NoEnviar') {
			$men1[] = array("Nombre" => "ConfigurarNumeroCelulares", "Url" => "sms/revisardatos/?CodAlumno=$CodAlumno", "Imagen" => "sms.png");
		}
	} elseif (in_Array($_SESSION['Nivel'], [4, 5])) {
		$men1 = array(
			array("Nombre" => "Agenda", "Url" => "agenda/total/agenda.php?CodAl=$CodAlumno", "Imagen" => "agendaregistro.png"),

			array("Nombre" => "VerBoletaDatos", "Url" => "alumno/boletadatos/?CodAlumno=$CodAlumno", "Imagen" => "verdatos.png"),
		);
	}
	$i = 0;
	foreach ($men1 as $m) {
		$i++;
	?>

		<div class="span6 box">
			<div class="box-header centrar"><?php echo $idioma[$m['Nombre']]; ?></div>
			<div class="box-content centrar">
				<a class="box-small-link" href="../../<?php echo $m['Url'] ?>" title="<?php echo $idioma['IrA'] ?> <?php echo $idioma[$m['Nombre']]; ?>">
					<img src="../../imagenes/submenu/<?php echo $m['Imagen'] ?>">
				</a>
			</div>
		</div>
		<?php
		if ($i == 2) {
			$i = 0;
		?>
</div>
<div class="row-fluid">
<?php
		}
	} ?>