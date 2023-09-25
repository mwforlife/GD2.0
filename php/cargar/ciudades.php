<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
$id = $_POST['id'];

$lista = $c->listarciudades($id);


if (count($lista) > 0) {
	foreach ($lista as $ciudad) {
		echo "<option value='" . $ciudad->getId() . "'>" . $ciudad->getNombre() . "</option>";
	}
} else {
	echo "<option value='0'>No hay ciudades</option>";
}
