<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['provincia']) && isset($_POST['trabajador'])) {
    $provincia = $_POST['provincia'];
    $trabajador = $_POST['trabajador'];
    $ver = $c->verificarzonaprovincia($trabajador, $provincia);
    if ($ver == true) {
        echo 2;
        return;
    }
    $result = $c->zonaprovincia($trabajador, $provincia);
    if ($result == true) {
        echo 1;
    } else {
        echo 0;
    }
}
