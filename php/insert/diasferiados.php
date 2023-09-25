<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['periodo']) && isset($_POST['fecha']) && isset($_POST['descripcion'])) {
    $periodo = $_POST['periodo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $result = $c->query("insert into diasferiado values (null, $periodo, '$fecha', '$descripcion')");
    if ($result == true) {
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Agrego el dia " . $fecha . " como feriado";
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    } else {
        echo 0;
    }
}
