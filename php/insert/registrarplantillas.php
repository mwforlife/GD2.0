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

if(isset($_POST['id']) && isset($_POST['contenido'])){
    $id = $_POST['id'];
    $contenido = $_POST['contenido'];
    $valid = $c->buscarplantilla($id);
    if($valid==false){
        $result = $c->registrarplatilla($id,$contenido);
        if($result == true){
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Agrego la Plantilla : ".$id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }else{
            echo 0;
        }
    }else{
        $result = $c->actualizarplantilla($id,$contenido);
        if($result == true){
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la Plantilla : ".$id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }else{
            echo 0;
        }
    }
}