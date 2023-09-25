<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['trabajador'])) {
    $trabajador = $_POST['trabajador'];
    $lista = $c->listarregiones();

    foreach ($lista as $object) {
        $region = $object->getId();
        $ver = $c->verificarzonaregion($trabajador, $region);
        if ($ver == false) {
            $result = $c->zonaregion($trabajador, $region);
        }
    }

    echo 1;
}
