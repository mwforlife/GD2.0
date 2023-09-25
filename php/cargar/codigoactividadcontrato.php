<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $cod = $c->buscarCodigoActividad($id);
    if ($cod != null) {
        echo $cod->getNombre();
    } else {
        0;
    }
}
