<?php
require '../controller.php';
$c = new Controller();
session_start();
$lista = $c->listartrabajadoresactivos($_SESSION['CURRENT_ENTERPRISE']);
$trabajadores = array();
foreach ($lista as $object) {
    $trabajadores[] = array(
        'id' => $object->getId(),
        'rut' => $object->getRut(),
        'nombre' => $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2(),
        'contrato' => $object->getNacionalidad()
    );
}
echo json_encode($trabajadores);
