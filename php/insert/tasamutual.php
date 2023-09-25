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
if (isset($_POST['tasa1']) && isset($_POST['tasa2']) && isset($_POST['fecha'])) {
    $tasa1 = $_POST['tasa1'];
    $tasa2 = $_POST['tasa2'];
    $fecha = $_POST['fecha'];

    if (strlen($tasa1) > 0 && strlen($tasa2) > 0 && strlen($fecha) > 0) {
        $fecha = $fecha . "-01";
    } else {
        echo "No se recibieron los datos";
        return;
    }


    //Validar si existe la tasa
    $tasaid = $c->validartasamutual($fecha);
    if ($tasaid == false) {
        $result = $c->registrartasamutual($fecha, $tasa1, $tasa2);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Nuevo REgistro de Tasa Mutual de Seguridad con Tasa Basica : " . $tasa1 . " y Tasa LeySanna ".$tasa2;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    } else {
        $result = $c->actualizartasamutual($tasa1, $tasa2, $tasaid);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Nueva Actualizar de Tasa Mutual de Seguridad con Tasa Basica : " . $tasa1 . " y Tasa LeySanna ".$tasa2." con el ID: " . $tasaid;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    }
} else {
    echo "No se recibieron los datos";
}
