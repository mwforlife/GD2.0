<?php
require '../controller.php';
$c = new Controller();
$centrocosto = $_POST['centrocosto'];
$usuario = $_POST['usuario'];
$result = $c->asignarcentrocosto($usuario, $centrocosto);
if ($result) {
    echo "1";
} else {
    echo "0";
}
?>