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

if (isset($_POST['RepresentanteRut']) && isset($_POST['RepresentanteNombre']) && isset($_POST['RepresentanteApellido1']) && isset($_POST['RepresentanteApellido2']) && isset($_SESSION['EMPRESA_ID'])) {
    $rut = $_POST['RepresentanteRut'];
    $nombre = $_POST['RepresentanteNombre'];
    $nombre = strtoupper($nombre);
    $apellido1 = $_POST['RepresentanteApellido1'];
    $apellido1 = strtoupper($apellido1);
    $apellido2 = $_POST['RepresentanteApellido2'];
    $apellido2 = strtoupper($apellido2);
    if(strlen($apellido2)==0){
        $apellido2 = "";
    }
    $empresa = $_SESSION['EMPRESA_ID'];
    $valid = $c->validarRepresentanteLegal($rut, $empresa);
    if ($valid == false) {
        $result = $c->RegistrarRepresentanteLegal($rut, $nombre, $apellido1, $apellido2, $empresa);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
}else if (isset($_POST['RepresentanteRut']) && isset($_POST['RepresentanteNombre']) && isset($_POST['RepresentanteApellido1']) && isset($_POST['RepresentanteApellido2']) && isset($_SESSION['EMPRESA_EDIT'])) {
    $rut = $_POST['RepresentanteRut'];
    $nombre = $_POST['RepresentanteNombre'];
    $nombre = strtoupper($nombre);
    $apellido1 = $_POST['RepresentanteApellido1'];
    $apellido1 = strtoupper($apellido1);
    $apellido2 = $_POST['RepresentanteApellido2'];
    $apellido2 = strtoupper($apellido2);
    if(strlen($apellido2)==0){
        $apellido2 = "No posee";
    }
    $empresa = $_SESSION['EMPRESA_EDIT'];
    $valid = $c->validarRepresentanteLegal($rut, $empresa);
    if ($valid == false) {
        $result = $c->RegistrarRepresentanteLegal($rut, $nombre, $apellido1, $apellido2, $empresa);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
} else {
    echo 0;
}
