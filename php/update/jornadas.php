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
$nombre = $_POST['nombre'];
$nombre = strtoupper($nombre);
$nombre = $c->escapeString($nombre);
$termino = $_POST['termino'];
$entidad = $_POST['entidad'];

$result = $c->actualizarjornada($id, $codigo, $codigoPrevired, $nombre, $termino, $entidad);

if($result == true){
    echo 1;
	$usuario = $_SESSION['USER_ID'];
	$eventos = "Se Actualizo la jornada : ".$nombre . " con el Codigo: ".$codigo;
	$c->RegistrarAuditoriaEventos($usuario, $eventos);
}else{
    echo 0;
}
