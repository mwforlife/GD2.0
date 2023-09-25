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

if ( isset($_POST['tasa']) && isset($_POST['fecha'])) {
    $tasa = $_POST['tasa'];
    $fecha = $_POST['fecha'];
    $periodo = $fecha;

    if (strlen($tasa) > 0 && strlen($fecha) > 0) {
        $fecha = $fecha . "-01";
    } else {
        echo "No se recibieron los datos";
        return;
    }


    //Validar si existe la tasa
    $tasaid = $c->validartasacaja($fecha);
    if ($tasaid == false) {
        $result = $c->registrartasacaja($fecha, $tasa);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Registro la tasa : " . $tasa . " En el Periodo: " . $periodo;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    } else {
        $result = $c->actualizartasacaja($tasa, $tasaid);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la tasa : " . $tasa . " con el ID: " . $tasaid;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    }
} else {
    echo "No se recibieron los datos";
}
