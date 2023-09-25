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

if(isset($_POST['Codigo']) && isset($_POST['CodigoPrevired']) && isset($_POST['Nombre']) ){
    $codigo = $_POST['Codigo'];
    $codigoPrevired = $_POST['CodigoPrevired'];
    $nombre = $_POST['Nombre'];
    $nombre = strtoupper($nombre);
    $result = $c->registrarpagador($codigo,$codigoPrevired, $nombre);

    if($result == true){
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Registro el pagador : ".$nombre . " con el RUT: ".$codigoPrevired;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    }else{
        echo 0;
    }
}