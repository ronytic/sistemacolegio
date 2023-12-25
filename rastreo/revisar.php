<?php
$Archivo = $_SERVER['SCRIPT_NAME'];
$Get = "";
$Post = "";
$Session = "";
$Ip = $_SERVER['REMOTE_ADDR'];
@$Referencia = $_SERVER['HTTP_REFERER'];
/*foreach ($_GET as $k => $v)
	$Get .= "$k=$v|";
foreach ($_POST as $k => $v)
	$Post .= "$k=$v|";
foreach ($_SESSION as $k => $v)
	$Session .= "$k=$v|";*/
$post = $_POST;
$get = $_GET;
$session = $_SESSION;
if (isset($post['CodigoSeguimientoNotasDocente'])) {
	$post['CodigoSeguimientoNotasDocente'] = base64_encode($post['CodigoSeguimientoNotasDocente']);
}
if (isset($post['CodigoSeguimientoSistema'])) {
	$post['CodigoSeguimientoSistema'] = base64_encode($post['CodigoSeguimientoSistema']);
}
if (isset($post['CodigoAdicionalSistemaLogin'])) {
	$post['CodigoAdicionalSistemaLogin'] = base64_encode($post['CodigoAdicionalSistemaLogin']);
}
$Get = json_encode($get);
$Post = json_encode($post);
$Session = json_encode($session);
//$Ip=ip2long($Ip);
include_once(RAIZ . "class/lograstreo.php");
$lograstreo = new lograstreo;
//escapar las comillas
$Archivo = addslashes($Archivo);
$Get = addslashes($Get);
$Post = addslashes($Post);
// echo $Post;
// exit();
$Session = addslashes($Session);
$valores = array(
	"`Archivo`" => "'$Archivo'",
	"`Post`" => "'$Post'",
	"`Get`" => "'$Get'",
	"`Session`" => "'$Session'",
	"`Ip`" => "'$Ip'",
	"`Referencia`" => "'$Referencia'"
);
$lograstreo->insertarRegistro($valores);
