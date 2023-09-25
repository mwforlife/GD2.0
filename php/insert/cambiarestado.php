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

if(isset($_POST['id']) && isset($_POST['estado'])){
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $result = $c->cambiarEstadoUsuarioEmpresa($id, $estado);
    if ($result==true) {
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Cambio el Estado de la Empresa con el ID".$id;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    } else {
        echo 0;
    }
}