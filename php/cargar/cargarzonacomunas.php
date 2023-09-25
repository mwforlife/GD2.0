<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['trabajador'])) {
    $trabajador = $_POST['trabajador'];
    $lista = $c->listarzonaprovinciatrabajador($trabajador);

    if (count($lista) > 0) {
        $sql = "select * from comunas where (";
        foreach ($lista as $object) {
            $sql .= "provincia = " . $object->getCodigo() . " or ";
        }
        $sql = substr($sql, 0, -4);
        $sql .= ")";
    } else {
        $sql = "select * from comunas where provincia = 0";
    }
    $comunas = $c->listarzonacomunas($sql);
    if (count($comunas) <= 0) {
        echo "<option value='0'>No hay Comunas</option>";
    } else {
        foreach ($comunas as $object) {
            echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
        }
    }
}
