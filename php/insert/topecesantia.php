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
        $periodo = $periodo . "-01";
        $result = $c->registrartopecesantia($periodo, $tope);
        if ($result == true) {
            echo json_encode(array('status' => true, 'message' => 'TOPE CESANTIA registrada correctamente'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Error al registrar TOPE CESANTIA'));
        }
    }


    $usuario = $_SESSION['USER_ID'];

    $mes = date("m", strtotime($periodo));
    $anio = date("Y", strtotime($periodo));
    switch ($mes) {
        case 1:
            $mes = "Enero";
            break;
        case 2:
            $mes = "Febrero";
            break;
        case 3:
            $mes = "Marzo";
            break;
        case 4:
            $mes = "Abril";
            break;
        case 5:
            $mes = "Mayo";
            break;
        case 6:
            $mes = "Junio";
            break;
        case 7:
            $mes = "Julio";
            break;
        case 8:
            $mes = "Agosto";
            break;
        case 9:
            $mes = "Septiembre";
            break;
        case 10:
            $mes = "Octubre";
            break;
        case 11:
            $mes = "Noviembre";
            break;
        case 12:
            $mes = "Diciembre";
            break;
    }
    $periodo = $mes . " " . $anio;
    $eventos = "Se registro la TOPE CESANTIA del Periodo " . $periodo . " con la tope: " . $tope;
    $c->RegistrarAuditoriaEventos($usuario, $eventos);
} else {
    echo json_encode(array('status' => false, 'message' => 'Error al registrar TOPE CESANTIA'));
}
