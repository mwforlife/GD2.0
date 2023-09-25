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

if(isset($_POST['id']) && isset($_POST['usuario'])){
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $valid = $c->validarUsuarioEmpresa($usuario,$id);
    if($valid == false){
        $result = $c->asignarUsuarioEmpresa($usuario, $id);
        if ($result==true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Agrego Usuario con el ID".$usuario." a la Empresa con el ID".$id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    }else{
        echo 2;
    }
}