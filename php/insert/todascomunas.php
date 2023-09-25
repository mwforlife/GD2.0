<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['trabajador'])) {
    $trabajador = $_POST['trabajador'];
    $lista = $c->listarzonaprovinciatrabajador($trabajador);
    $sql = "";
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
            $comuna = $object->getId();
            $ver = $c->verificarzonacomuna($trabajador, $comuna);
            if ($ver == false) {
                $result = $c->zonacomuna($trabajador, $comuna);
            }
        }
        echo 1;
    }
}
