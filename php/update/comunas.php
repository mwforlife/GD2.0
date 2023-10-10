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
$codigo = $_POST['codigo'];
$codigoPrevired = $_POST['codigoPrevired'];
$codigox = $_POST['codigoxedit'];
$nombre = $_POST['nombre'];
$nombre = strtoupper($nombre);
$nombre = $c->escapeString($nombre);
$provincia = $_POST['provincia'];

$result = $c->actualizarcomuna($id, $codigo, $codigoPrevired,$codigox, $nombre, $provincia);

if($result == true){
    echo 1;
	$usuario = $_SESSION['USER_ID'];
	$eventos = "Se Actualizo la comuna : ".$nombre . " con el Codigo: ".$codigo;
	$c->RegistrarAuditoriaEventos($usuario, $eventos);
    $c->actualizarciudad($id, $codigo, $codigoPrevired, $nombre);
	$usuario = $_SESSION['USER_ID'];
	$eventos = "Se Actualizo la ciudad : ".$nombre . " con el Codigo: ".$codigo;
	$c->RegistrarAuditoriaEventos($usuario, $eventos);
}else{
    echo 0;
}
