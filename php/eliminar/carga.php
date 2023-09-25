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

$result = $c->eliminarcarga($id);

$usuario = $_SESSION['USER_ID'];
$eventos = "Se elimino el Carga con el ID: " . $id;
$c->RegistrarAuditoriaEventos($usuario, $eventos);
if($result == true){
    echo 1;
    $c->eliminarciudad($id);
}else{
    echo 0;
}