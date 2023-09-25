<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['trabajador'])) {
    $trabajador = $_POST['trabajador'];
    $lista = $c->listarzonaprovinciatrabajador($trabajador);

    foreach ($lista as $object) {
        echo "<tr>";
        echo "<td>" . $object->getNombre() . "</td>";
        //Button to delete
        echo "<td><button type='button' class='btn btn-danger btn-sm' onclick='eliminarzonaprovincia(" . $object->getCodigo() . "," . $trabajador . ")'><i class='fa fa-trash'></i></button></td>";
        echo "</tr>";
    }
}
