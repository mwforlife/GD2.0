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

if(isset($_POST['id']) && isset($_POST['pass'])){
    $id = $_POST['id'];
    $password = $_POST['pass'];
    if(strlen($password) <=0){
        echo "La contraseña no puede estar vacia";
        return;
    }
    $password = sha1($password);
    $result = $c->actualizarpass($id, $password);
    if($result==true){
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Actualizo la contraseña del usuario : ".$id;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    }else{
        echo 0;
    }
}