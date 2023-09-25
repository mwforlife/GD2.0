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

if (isset($_POST['CodigoPrevired']) && isset($_POST['Nombre'])) {
    $codigo = $_POST['CodigoPrevired'];
    $codigoPrevired = $_POST['CodigoPrevired'];
    $nombre = $_POST['Nombre'];
    $nombre = strtoupper($nombre);
    $region = $_POST['Region'];
    $result = $c->registrarcentrocosto($codigo, $codigoPrevired, $nombre, $region);

    if ($result == true) {
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Registro el Centro de Costo : " . $nombre . " con el Codigo: " . $codigo;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    } else {
        echo 0;
    }
}
