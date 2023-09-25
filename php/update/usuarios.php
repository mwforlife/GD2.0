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

if(isset($_POST['UserRut']) && isset($_POST['UserNombre']) && isset($_POST['UserApellido']) && isset($_POST['UserEmail']) && isset($_POST['UserDireccion'])  &&isset($_POST['UserRegion']) && isset($_POST['UserComuna']) && isset($_POST['UserPhone']) && isset($_POST['UserId']) ){
    $UserRut = $_POST['UserRut'];
    $UserNombre = $_POST['UserNombre'];
    if(strlen($UserNombre) <=0){
        echo "El nombre no puede estar vacio";
        return;
    }
    $UserNombre = $c->escapeString($UserNombre);
    $UserNombre = strtoupper($UserNombre);
    $UserApellido = $_POST['UserApellido'];
    if(strlen($UserApellido) <=0){
        echo "El apellido no puede estar vacio";
        return;
    }
    $UserApellido = $c->escapeString($UserApellido);
    $UserApellido = strtoupper($UserApellido);
    $UserEmail = $_POST['UserEmail'];
    if(strlen($UserEmail) <=0){
        echo "El email no puede estar vacio";
        return;
    }
    $UserEmail = $c->escapeString($UserEmail);
    $UserDireccion = $_POST['UserDireccion'];
    if(strlen($UserDireccion) <=0){
        echo "La direccion no puede estar vacia";
        return;
    }
    $UserDireccion = $c->escapeString($UserDireccion);
    $UserDireccion = strtoupper($UserDireccion);
    $UserRegion = $_POST['UserRegion'];
    $UserComuna = $_POST['UserComuna'];
    $UserTelefono = $_POST['UserPhone'];
    if(strlen($UserTelefono) <=0){
        echo "El telefono no puede estar vacio";
        return;
    }
    $UserTelefono = $c->escapeString($UserTelefono);
    $UserId = $_POST['UserId'];

    $valid = $c->validarusuario1($UserEmail, $UserRut, $UserId);
    if ($valid==true) {
        $result = $c->actualizarusuario($UserId, $UserRut, $UserNombre, $UserApellido, $UserEmail, $UserDireccion, $UserRegion, $UserComuna, $UserTelefono);
        if ($result==true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo el usuario : ".$UserId;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    }else{
        echo "El rut o email ya se encuentra registrado";   
    }

}else{
    echo "Error";
}