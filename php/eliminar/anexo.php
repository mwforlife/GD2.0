<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $c->eliminarclausulaanexo($id);
    $c->eliminaranexo($id);
    echo 1;
}