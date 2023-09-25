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


if (isset($_POST['TrabajadorTelefono']) && isset($_POST['TrabajadorCorreo']) && isset($_POST['id'])) {
            $telefono = $_POST['TrabajadorTelefono'];
            $correo = $_POST['TrabajadorCorreo'];
            $id = $_POST['id'];
            $result = $c->actualizarcontacto($id,$telefono, $correo);
            if($result == true){
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la Información de Contacto para el Trabajador con ID: " . $id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
            }else{
            echo 0;
            }
} else {
    echo "No se han recibido los datos";
}
