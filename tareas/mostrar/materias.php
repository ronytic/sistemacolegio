<?php
include_once("../../login/check.php");
if (!empty($_POST)) {
	include_once("../../class/cursomateria.php");
	include_once("../../class/materias.php");
	$cursomateria = new cursomateria;
	$materias = new materias;
	$CodCurso = $_POST['CodCurso'];
	foreach ($cursomateria->mostrarMateriasOrden($CodCurso) as $curm) {
		$ma = $materias->mostrarMateria($curm['CodMateria']);
		$ma = array_shift($ma);
?>
		<option value="<?php echo $curm['CodMateria'] ?>"><?php echo $ma['Nombre'] ?></option>
<?php
	}
}
?>