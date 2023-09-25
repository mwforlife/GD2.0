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
$usuario = $_POST['usuario'];
if($id == 0){
    $valid = $c->eliminarPermisoUsuario1($usuario);
    if($valid == true){
        echo 1;
        $object = $c->getuser($usuario);
        $usuario = $_SESSION['USER_ID'];
        $nombre = $object->getNombre();
        $eventos = "Se elimino Los Permisos del Usuario: ".$nombre . " con el ID: ".$id;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    }else{
        echo 0;
    }
}else{
    $result = $c->eliminarPermisoUsuario($id);
    if ($result==true) {
        echo 1;
    } else {
        echo 0;
    }
    $usuario = $_SESSION['USER_ID'];
    $nombre = $object->getNombre();
    $eventos = "Se Elimino Los Permisos del Usuario: ".$nombre . " con el ID: ".$id;
    $c->RegistrarAuditoriaEventos($usuario, $eventos);
}