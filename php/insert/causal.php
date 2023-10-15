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

if(isset($_POST['Codigo']) && isset($_POST['CodigoPrevired']) && isset($_POST['articulo']) && isset($_POST['letra']) && isset($_POST['Nombre']) ){
    $codigo = $_POST['Codigo'];
    $codigoPrevired = $_POST['CodigoPrevired'];
    $articulo = $_POST['articulo'];
    $letra = $_POST['letra'];
    $nombre = $_POST['Nombre'];
    $codigo = strtoupper($codigo);
    $codigo = $c->escapeString($codigo);
    $codigoPrevired = strtoupper($codigoPrevired);
    $codigoPrevired = $c->escapeString($codigoPrevired);
    $articulo = strtoupper($articulo);
    $articulo = $c->escapeString($articulo);
    $letra = strtoupper($letra);
    $letra = $c->escapeString($letra);
    $nombre = strtoupper($nombre);
    $nombre = $c->escapeString($nombre);
    $result = $c->registrarcausaltermino($codigo,$codigoPrevired,$articulo,$letra,$nombre);

    if($result == true){
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Registro El Causal de termino contrato : ".$nombre . " con el Codigo: ".$codigo;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    }else{
        echo 0;
    }
}