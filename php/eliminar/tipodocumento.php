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

$objeto = $c->buscartipodocumento($id);
$result = $c->eliminartipodocumento($id);

$usuario = $_SESSION['USER_ID'];
$nombre = $object->getNombre();
$eventos = "Se Elimino El tipo documento: ".$nombre . " con el ID: ".$id;
$c->RegistrarAuditoriaEventos($usuario, $eventos);
if($result == true){
    echo 1;
}else{
    echo 0;
}