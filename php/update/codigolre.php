<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
$id = $_POST['id'];
$articulo = $_POST['articulo'];
$articulo = strtoupper($articulo);
$articulo = $c->escapeString($articulo);
$codigo = $_POST['codigo'];
$codigo = strtoupper($codigo);
$codigo = $c->escapeString($codigo);
$codigoPrevired = $_POST['codigoprevired'];
$codigoPrevired = strtoupper($codigoPrevired);
$codigoPrevired = $c->escapeString($codigoPrevired);
$nombre = $_POST['nombre'];
$nombre = strtoupper($nombre);
$nombre = $c->escapeString($nombre);


$result = $c->editarcodigolre($id, $articulo, $codigo, $codigoPrevired, $nombre);

if($result == true){
    echo 1;
	$usuario = $_SESSION['USER_ID'];
	$eventos = "Se Actualizo el Codigo LRE : ".$nombre . " con el Codigo: ".$codigo;
	$c->RegistrarAuditoriaEventos($usuario, $eventos);
    $c->actualizarciudad($id, $codigo, $codigoPrevired, $nombre);
}else{
    echo 0;
}
