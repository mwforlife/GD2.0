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

$object = $c->buscarcodigolre($id);
$result = $c->eliminarcodigolre($id);

$usuario = $_SESSION['USER_ID'];
$codigo = $object->getCodigo();
$nombre = $object->getDescripcion();
$eventos = "Se elimino la Codigo LRE: ".$codigo . " con el Nombre: ".$nombre;
$c->RegistrarAuditoriaEventos($usuario, $eventos);

if($result == true){
    echo 1;
}else{
    echo 0;
}