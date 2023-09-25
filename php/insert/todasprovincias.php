<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['trabajador'])) {
    $trabajador = $_POST['trabajador'];
    $lista = $c->listarzonasregion($trabajador);
    $sql = "select * from provincias where (";
    foreach ($lista as $object) {
        $sql .= "region = " . $object->getCodigo() . " or ";
    }
    $sql = substr($sql, 0, -4);
    $sql .= ")";
    $provincias = $c->listarzonaprovincia($sql);
    if (count($provincias) <= 0) {
        echo "<option value='0'>No hay provincias</option>";
    } else {
        foreach ($provincias as $object) {
            $provincia = $object->getId();
            $ver = $c->verificarzonaprovincia($trabajador, $provincia);
            if ($ver == false) {
                $result = $c->zonaprovincia($trabajador, $provincia);
            }
        }
        echo 1;
    }
}
