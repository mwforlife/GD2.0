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


if (isset($_POST['TrabajadorTelefono']) && isset($_POST['TrabajadorCorreo']) && $_SESSION['TRABAJADOR_ID']) {
    
    $telefono = $_POST['TrabajadorTelefono'];
    $correo = $_POST['TrabajadorCorreo'];
    $id = $_SESSION['TRABAJADOR_ID'];
            $result = $c->registrarcontacto($telefono, $correo, $id);
            if($result == true){
            echo 1;
            }else{
            echo 0;
            }
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Registro Nueva Información de Contacto para el Trabajador con ID: " . $id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
} else {
    echo "No se han recibido los datos";
}
