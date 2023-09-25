<?php
require '../controller.php';
$c = new Controller();
session_start();
$valor = $c->cantidadvacaciones(1);
//Convertir valor en entero
echo "La cantidad de dias de Vacacaciones son: " . $valor;