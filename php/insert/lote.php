<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: ../../lockscreen.php");
    }
}

if (isset($_POST['trabajador'])) {
    $trabajador = $_POST['trabajador'];
    $usuario = $_SESSION['USER_ID'];
    $token = $_SESSION['USER_TOKEN'];
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];

    if ($trabajador == "all") {
        $lista = $c->listartrabajadores($empresa);
        foreach ($lista as $key) {
            $trabajador = $key->getId();
            if ($c->validarlote($trabajador, $_SESSION['USER_ID']) == true) {

            } else {
                $result = $c->crearlote($trabajador, $token, $usuario);
            }
            
        }
        echo 1;
    } else {
        if ($c->validarlote($trabajador, $_SESSION['USER_ID']) == true) {
            echo 2;
        } else {
            $result = $c->crearlote($trabajador, $token, $usuario);
            if ($result == true) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
} else {
    echo "No se ha recibido el trabajador";
}
