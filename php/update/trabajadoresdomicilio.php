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


if (isset($_POST['TrabajadorCalle']) && isset($_POST['Trabajadorvilla']) && isset($_POST['TrabajadorNumero']) && isset($_POST['TrabajadorRegion']) && isset($_POST['TrabajadorComuna']) && isset($_POST['TrabajadorCiudad']) && $_SESSION['TRABAJADOR_ID']) {

    $calle = $_POST['TrabajadorCalle'];
    $calle = $c->escapeString($calle);
    $villa = $_POST['Trabajadorvilla'];
    $numero = $_POST['TrabajadorNumero'];
    $departamento = $_POST['TrabajadorDepartamento'];
    $region = $_POST['TrabajadorRegion'];
    if ($region == 0) {
        echo "error";
        return;
    }
    $comuna = $_POST['TrabajadorComuna'];
    if ($comuna < 1) {
        echo "Error";
        return;
    }
    $ciudad = $_POST['TrabajadorCiudad'];
    if ($ciudad < 1) {
        echo "Error";
        return;
    }

    $calle = strtoupper($calle);
    $departamento = strtoupper($departamento);
    $ciudad = strtoupper($ciudad);

    $id = $_SESSION['TRABAJADOR_ID'];
    $c->registrardomicilio($calle,$villa, $numero, $departamento, $region, $comuna, $ciudad, $id);
    echo 1;
    $usuario = $_SESSION['USER_ID'];
    $eventos = "Se Registro Neuva Informacion de Domicilio para el trabajar con el ID: " . $id;
    $c->RegistrarAuditoriaEventos($usuario, $eventos);
} else {
    echo "No se han recibido los datos";
}
