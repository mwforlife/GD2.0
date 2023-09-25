<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['comuna']) && isset($_POST['trabajador'])) {
    $comuna = $_POST['comuna'];
    $trabajador = $_POST['trabajador'];
    $ver = $c->verificarzonacomuna($trabajador, $comuna);
    if ($ver == true) {
        echo 2;
        return;
    }
    $result = $c->zonacomuna($trabajador, $comuna);
    if ($result == true) {
        echo 1;
    } else {
        echo 0;
    }
}
