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

if (isset($_POST['TrabajadorRut'])  && isset($_POST['TrabajadorNombre']) && isset($_POST['TrabajadorApellido1'])  && isset($_POST['TrabajadorNacimiento']) && isset($_POST['TrabajadorSexo']) && isset($_POST['TrabajadorCivil']) && isset($_POST['TrabajadorNacionalidad']) && isset($_POST['TrabajadorDiscapacidad']) && isset($_POST['TrabajadorPension']) && $_SESSION['CURRENT_ENTERPRISE']) {
    $rut = $_POST['TrabajadorRut'];
    $dni = $_POST['TrabajadorDNI'];
    $nombre = $_POST['TrabajadorNombre'];
    $apellido1 = $_POST['TrabajadorApellido1'];
    $apellido2 = $_POST['TrabajadorApellido2'];
    $nacimiento = $_POST['TrabajadorNacimiento'];
    $sexo = $_POST['TrabajadorSexo'];
    $civil = $_POST['TrabajadorCivil'];
    $nacionalidad = $_POST['TrabajadorNacionalidad'];
    $discapacidad = $_POST['TrabajadorDiscapacidad'];
    $pension = $_POST['TrabajadorPension'];
    $nombre = strtoupper($nombre);
    $apellido1 = strtoupper($apellido1);
    $apellido2 = strtoupper($apellido2);
    $id = $_SESSION['TRABAJADOR_ID'];
        $result = $c->actualizartrabajador($id,$rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $civil, $nacionalidad, $discapacidad, $pension);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo el Trabajador : " . $nombre . " con el Rut: " . $rut;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
} else {
    echo "No se han recibido los datos";
}
