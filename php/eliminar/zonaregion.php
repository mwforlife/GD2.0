<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id']) && isset($_POST['trabajador'])) {
    $provincias = $c->listarprovincias($_POST['id']);
    foreach ($provincias as $object) {
        $c->eliminarzonaprovincia($object->getId(), $_POST['trabajador']);
    }
    $comunas = $c->listarcomunas($_POST['id']);
    foreach ($comunas as $object) {
        $c->eliminarzonacomuna($object->getId(), $_POST['trabajador']);
    }
    $c->eliminarzonaregion($_POST['id'], $_POST['trabajador']);
    echo 1;
}
