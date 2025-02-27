<?php
if (!defined("RAIZ")) {
	$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . "../";
	define("RAIZ", $dir);
}
include_once(RAIZ . "basededatos.php");
class bd
{
	public $l;
	public $tabla;
	public $resultado;
	public $campos = array();
	function __construct()
	{
		global $host, $user, $pass, $database, $puerto;
		@$con = mysqli_connect($host, $user, $pass, $database, $puerto);
		if (!$con) {

			echo "No se Puede Conectar a la Base de Datos: " . mysqli_connect_error();
			exit();
		} else {
			mysqli_query($con, "SET NAMES utf8");
			mysqli_query($con, "SET SQL_MODE='ALLOW_INVALID_DATES'");
			$this->l = $con;
		}
		if ($this->tabla == "") {
			$this->tabla = get_class($this);
			$nombretabla = mb_strtolower($this->tabla, "utf8");
		}
	}
	function verificarExistenciaTabla()
	{
		$nombretabla = mb_strtolower($this->tabla, "utf8");
		$query = "SHOW TABLES LIKE '$nombretabla'";
		$res = mysqli_query($this->l, $query);
		$res = mysqli_fetch_array($res);
		return $res;
	}
	function __destruct()
	{
		@mysqli_close($this->l);
	}
	function ultimo()
	{
		return mysqli_insert_id($this->l);
	}
	function getTables()
	{
		global $database;
		return $this->sql("SHOW TABLES FROM " . $database);
	}
	function get_db()
	{
		global $database;
		return $database;
	}
	private function sql($consulta)
	{
		//echo mysql_real_escape_string ($consulta);
		$consQ = mysqli_query($this->l, ($consulta));
		//print_r(mysql_fetch_array($consQ));
		$resultado = array();
		if ($consQ) {
			while ($consF = mysqli_fetch_assoc($consQ))
				array_push($resultado, $consF);
		}
		//echo print_r($resultado);
		return $resultado;
	}
	function queryE($data, $f)
	{
		//echo $data;
		if ($f == "lock" && md5("lock") == md5($f)) {
			mysqli_query($this->l, $data); //or die(mysql_error($this->l));
		}
	}
	function statusTable()
	{
		$nombretabla = mb_strtolower($this->tabla, "utf8");
		$query1 = "SELECT COLUMN_NAME
		FROM information_schema.KEY_COLUMN_USAGE
		WHERE TABLE_NAME = '$nombretabla'
			and CONSTRAINT_SCHEMA = '" . $this->get_db() . "'
		  AND CONSTRAINT_NAME = 'PRIMARY'";
		$res = mysqli_query($this->l, $query1);
		$res = mysqli_fetch_array($res);
		$COLUMN_NAME = $res['COLUMN_NAME'];
		// $query = "SHOW TABLE STATUS LIKE '$nombretabla'";
		$query = "SELECT COALESCE(max($COLUMN_NAME),0) + 1  as Auto_increment FROM " . $nombretabla . "";
		$res = mysqli_query($this->l, $query);
		$res = mysqli_fetch_array($res);
		$res['Auto_increment'] = (int)$res['Auto_increment'];
		return $res;
	}
	function getRecords($where_str = false, $order_str = false, $group_str = false, $count = false, $start = 0, $order_strDesc = false, $joinTables = false)
	{
		if (empty($this->campos) || !isset($this->campos)) {
			$this->campos = array('*');
		}
		$where = $where_str ? "WHERE $where_str" : "";
		if (strpos($order_str, 'ASC') !== false || strpos($order_str, 'DESC') !== false) {
			$order = $order_str ? "ORDER BY $order_str" : "";
		} else {
			$order = $order_str ? "ORDER BY $order_str ASC" : "";
		}
		$order = $order_strDesc ? "ORDER BY $order_str DESC" : $order;
		$group = $group_str ? "GROUP BY $group_str" : "";
		$count = $count ? "LIMIT $start, $count" : "";
		$camposs = implode(', ', $this->campos);
		if (get_class($this) == $this->tabla) {
			$nombretabla = mb_strtolower(get_class($this), "utf8");
		} else {
			$nombretabla = mb_strtolower($this->tabla, "utf8");
		}
		if ($joinTables) {
			$nombretabla = $nombretabla . " " . $joinTables;
		}
		$query = "SELECT $camposs FROM {$nombretabla} $where $group $order $count";
		return $this->sql($query);
	}
	public function getRecord($id)
	{
		return $this->getRecords("id=$id", false, 1);
	}
	public function insertRecord($data)
	{
		$campos = $this->getTableFields();
		$sysData = $this->getDefaultValues();
		$data = implode("', '", $data);
		$query = "INSERT INTO {$this->tabla} ($campos) VALUES ($sysData, '$data')";
		echo $query;
		/*
		$log =fopen ('c:\leo\logworb.txt', 'w');
		fwrite ($log, $query);
		fclose ($log);
*/
		//		mysql_query ($query);
		//	return $this->validateOperation ();
	}
	public function insertRow($data, $sw = 0)
	{
		////
		$key = array();
		$val = array();
		foreach ($data as $k => $v) {
			$key[] = $k;
			$val[] = $v;
		}
		$campos = implode(",", $key);
		$datos = implode(",", $val);
		////
		$nombretabla = mb_strtolower(get_class($this), "utf8");
		if ($sw == 0)
			$query = "INSERT INTO {$nombretabla} VALUES ($datos)";
		else
			$query = "INSERT INTO {$nombretabla} ($campos) VALUES ($datos)";

		// echo $query . "<br>";
		//echo "NO ESTA HABILITADO EL REGISTRO";
		return mysqli_query($this->l, $query);
	}
	public function deleteRecord($where_str)
	{
		$where = $where_str ? "WHERE $where_str" : "";
		return mysqli_query($this->l, "DELETE FROM {$this->tabla} $where");
		//return $this->validateOperation ();
	}

	public function showError()
	{
		return mysqli_error($this->l);
	}
	public function updateRecord($where_str, $data)
	{
		$where = $where_str ? "WHERE $where_str" : "";
		$campos = $this->campos;
		$datos = array();
		foreach ($campos as $ind => $campo) {
			$current_data = $data[$ind];
			array_push($datos, "$campo='$current_data'");
		}
		$datos = implode(", ", $datos);
		//echo "UPDATE {$this->tabla} SET $datos $where";
		mysqli_query($this->l, "UPDATE {$this->tabla} SET $datos $where");
	}
	public function updateRow($dataValues, $where_str)
	{
		$where = $where_str ? "WHERE $where_str" : "";
		$data = array();
		foreach ($dataValues as $k => $v) {
			array_push($data, $k . "=" . $v);
		}
		$datos = implode(",", $data);
		$nombretabla = mb_strtolower($this->tabla, "utf8");
		// echo "UPDATE {$nombretabla} SET $datos $where";
		// echo "<br>";
		return mysqli_query($this->l, "UPDATE $nombretabla SET $datos $where");
	}
	public function vaciar()
	{
		mysqli_query($this->l, "TRUNCATE TABLE {$this->tabla}");
	}
	private function getTableFields($asArray = false)
	{
		$return = $this->getNameFields('private');
		$return += $this->getNameFields('public');
		return $asArray ? $return : implode(', ', $return);
	}
	private function getDefaultValues($asArray = false)
	{
		$return = array();
		$fields = $this->getFieldsByType('private');
		foreach ($fields as $field) {
			array_push($return, $field[2]);
		}
		return $asArray ? $return : implode(', ', $return);
	}
	private function getNameFields($type)
	{
		$return = array();
		$fields = $this->getFieldsByType($type);
		foreach ($fields as $field) {
			array_push($return, $field[1]);
		}
		return $return;
	}
	private function getFieldsByType($type = '')
	{
		$return = array();
		$types = explode('|', $type);
		foreach ($this->campos as $field) {
			$includeField = false;
			foreach ($types as $t) {
				if ($field[0] == $t) {
					array_push($return, $field);
				}
			}
		}
		return $return;
	}

	/*Funciones Propias*/
	function estadoTabla()
	{
		return $this->statusTable();
	}
	function insertarRegistro($Values, $Todo = 1)
	{
		if ($Todo == 1) {
			$fecha = date("Y-m-d");
			$hora = date("H:i:s");
			$CodUsuario = isset($_SESSION['CodUsuarioLog']) ? $_SESSION['CodUsuarioLog'] : 0;
			$Nivel = isset($_SESSION['Nivel']) ? $_SESSION['Nivel'] : 0;

			if (!isset($Values['Nivel']) && empty($Values['Nivel'])) {
				$Values['Nivel'] = "$Nivel";
			}
			if (!isset($Values['FechaRegistro']) && empty($Values['FechaRegistro'])) {
				$Values['FechaRegistro'] = "'$fecha'";
			}
			if (!isset($Values['HoraRegistro']) && empty($Values['HoraRegistro'])) {
				$Values['HoraRegistro'] = "'$hora'";
			}
			if (!isset($Values['CodUsuario']) && empty($Values['CodUsuario'])) {
				$Values['CodUsuario'] = "$CodUsuario";
			}
			$Values['Activo'] = 1;
		} else { //,array("Activo"=>1)
			$Values = array_merge($Values);
		}

		//print_r($Values);
		return $this->insertRow($Values, 1);
	}
	function mostrarRegistro($Codigo, $activo = 1)
	{

		$this->campos = array('*');
		if ($activo == "") :
			$condicion = "";
		elseif ($activo == 1) :
			$condicion = " and Activo=1";
		elseif ($activo == 0) :
			$condicion = " and Activo=0";
		endif;
		return $this->getRecords("Cod" . ucfirst(mb_strtolower($this->tabla, "utf8")) . "=$Codigo " . $condicion);
	}
	function mostrarTodoRegistro($where = '', $activo = 1, $orden = "")
	{

		if (empty($this->campos)) {
			$this->campos = array('*');
		}
		if ($activo == "") :
			$condicion = "";
		elseif ($activo == 1) :
			if ($where == "") {
				$condicion = " Activo=1";
			} else {
				$condicion = " and Activo=1";
			}
		elseif ($activo == 0) :
			if ($where == "") {
				$condicion = " Activo=0";
			} else {
				$condicion = " and Activo=0";
			}
		endif;
		return $this->getRecords($where . $condicion, $orden);
	}
	function actualizarRegistro($values, $Where)
	{
		return $this->updateRow($values, $Where);
	}
	function eliminarRegistro($Where)
	{
		return $this->updateRow(array("Activo" => "0"), $Where);
	}
	function optimizarTablas()
	{
		global $tablas_optimizar;
		//print_r($tablas_optimizar);
		if (count($tablas_optimizar) > 0) {
			foreach ($tablas_optimizar as $to) {
				//echo $to;
				mysqli_query($this->l, "FLUSH TABLE $to");
				mysqli_query($this->l, "OPTIMIZE TABLE $to");
				mysqli_query($this->l, "REPAIR TABLE $to");
			}
		}
	}
}
