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
if (isset($_POST['finiquito'])) {
    $finiquito = $_POST['finiquito'];
    if ($finiquito == "all") {
        $usuario = $_SESSION['USER_ID'];
        $token = $_SESSION['USER_TOKEN'];
        $empresa = $_SESSION['CURRENT_ENTERPRISE'];
        $lista = $c->listarfiniquitofiniquitosnonotificados();
        if (count($lista) == 0) {
            echo 0;
        } else {
            foreach ($lista as $l) {
                $finiquito = $l->getId();
                $valid = $c->validarlotenotificacion($finiquito, $usuario);
                if ($valid == false) {
                    $result = $c->registrarlotenotificacion($finiquito, $usuario);
                }
            }
            echo 1;
        }
    } else {
        if ($finiquito <= 0) {
            echo "Debe seleccionar un finiquito";
            return;
        }
        $finiquito = $_POST['finiquito'];
        $usuario = $_SESSION['USER_ID'];
        $token = $_SESSION['USER_TOKEN'];
        $empresa = $_SESSION['CURRENT_ENTERPRISE']; 
            $valid = $c->validarlotenotificacion($finiquito, $usuario);
            if ($valid == false) {
                $result = $c->registrarlotenotificacion($finiquito, $usuario);
                if ($result == true) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 2;
            }
        
    }
} else {
    echo "No se recibieron datos";
}
