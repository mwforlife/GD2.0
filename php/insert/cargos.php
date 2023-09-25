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

if(isset($_POST['Codigo']) && isset($_POST['CodigoPrevired']) && isset($_POST['Nombre'])&& isset($_POST['empresa']) ){
    $codigo = $_POST['Codigo'];
    $codigoPrevired = $_POST['CodigoPrevired'];
    $nombre = $_POST['Nombre'];
    $nombre = strtoupper($nombre);
    $empresa = $_POST['empresa'];
    $result = $c->registrarcargo($codigo,$codigoPrevired, $nombre,$empresa);

    $usuario = $_SESSION['USER_ID'];
    $eventos = "Se Registro el cargo : ".$nombre . " con el Codigo: ".$codigo;
    $c->RegistrarAuditoriaEventos($usuario, $eventos);
    if($result == true){
        echo 1;
    }else{
        echo 0;
    }
}