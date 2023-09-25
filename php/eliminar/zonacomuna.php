<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id']) && isset($_POST['trabajador'])) {
    $c->eliminarzonacomuna($object->getId(), $_POST['trabajador']);
    echo 1;
}
