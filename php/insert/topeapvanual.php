<?php
require '../controller.php';
$c = new Controller();
session_start();

if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        echo json_encode(array('status' => false, 'message' => 'Error con la sesion, vuelva a iniciar sesion'));
    }
}

if (isset($_POST['periodo']) && isset($_POST['tope'])) {
    $periodo = $_POST['periodo'];
    $tope = $_POST['tope'];
    $tope = str_replace(".", "", $tope);
    $tope = str_replace(",", ".", $tope);

    //Validar campos
    if (strlen($periodo) == 0 || strlen($tope) == 0) {
        echo json_encode(array('status' => false, 'message' => 'Error: Campos vacios'));
    } else {
        $result = $c->registrartopeapvanual($periodo, $tope);
        if ($result == true) {
            echo json_encode(array('status' => true, 'message' => 'TOPE APV ANUAL registrada correctamente'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Error al registrar TOPE APV ANUAL'));
        }
    }


    $usuario = $_SESSION['USER_ID'];

    $eventos = "Se registro la TOPE APV ANUAL del Año " . $periodo . " con la tope: " . $tope;
    $c->RegistrarAuditoriaEventos($usuario, $eventos);
} else {
    echo json_encode(array('status' => false, 'message' => 'Error al registrar TOPE APV ANUAL'));
}
