<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $c->eliminaranexo($id);
    $c->eliminarclausulaanexo($id);
    echo 1;
}