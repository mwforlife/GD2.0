<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id']) && isset($_POST['trabajador'])) {
    $comunas = $c->listarcomunas2($_POST['id']);
    foreach ($comunas as $object) {
        $c->eliminarzonacomuna($object->getId(), $_POST['trabajador']);
    }
    $c->eliminarzonaprovincia($_POST['id'], $_POST['trabajador']);
    echo 1;
}
