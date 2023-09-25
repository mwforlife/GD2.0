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


if(isset($_POST['Codigo']) && isset($_POST['CodigoPrevired']) && isset($_POST['Nombre'])){
    $codigo = $_POST['Codigo'];
    $codigoPrevired = $_POST['CodigoPrevired'];
    $nombre = $_POST['Nombre'];
    $nombre = strtoupper($nombre);
    $tasa = 1;
    $result = $c->registrarafp($codigo,$codigoPrevired, $nombre, $tasa);

    if($result == true){
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Agrego el AFP : ".$nombre . " con el Codigo: ".$codigo;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);

    }else{
        echo 0;
    }
}