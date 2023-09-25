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

if(isset($_POST['Codigo']) && isset($_POST['CodigoPrevired']) && isset($_POST['Nombre']) && isset($_POST['provincia'])){
    $codigo = $_POST['Codigo'];
    $codigoPrevired = $_POST['CodigoPrevired'];
    $nombre = $_POST['Nombre'];
    $nombre = strtoupper($nombre);
    $region = $_POST['Region'];
    $provincia = $_POST['provincia'];
    if($provincia<=0){
        echo "No hay Provincias Seleccionada";
        return;
    }
    $result = $c->registrarcomunas($codigo,$codigoPrevired, $nombre, $region, $provincia);

    if($result == true){
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Registro la Comuna : ".$nombre . " con el Codigo: ".$codigo;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
        $c->registrarciudad($codigo, $codigoPrevired, $nombre, $region);
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Registro la Ciudad : ".$nombre . " con el Codigo: ".$codigo;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    }else{
        echo 0;
    }
}