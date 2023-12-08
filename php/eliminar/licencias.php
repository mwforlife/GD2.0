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
$licencia = $c->buscarlicencia($id);
if ($licencia != null) {
	$fechainicio = $licencia->getFechainicio();
	$fechatermino = $licencia->getFechafin();
	$trabajador = $licencia->getTrabajador();
	$movimiento = $c->buscarmovimientoxfechaexaca($trabajador, $fechainicio, $fechatermino, 3);
	if ($movimiento != null) {
		$c->eliminarmovimiento($movimiento->getId());
	}
	$TrabajadorId = $trabajador;
	$contrato = $c->buscarcontrato($TrabajadorId);
	if ($contrato != null) {
		$contrato = $contrato->getId();
		$init = new DateTime($fechainicio);
		$end = new DateTime($fechatermino);
		while ($init <= $end) {
			$fechita = $init->format('Y-m-d');
			//Comprobar si el dia esta dentro de la licencia
			$asistencia = $c->validarasistencia($TrabajadorId, $contrato, $fechita);
			if ($asistencia == false) {
			} else {
				$c->eliminarasistencia($asistencia);
			}
			$init->modify('+1 day');
		}
	}
}
$result = $c->eliminarlicencia($id);

$usuario = $_SESSION['USER_ID'];
$eventos = "Se elimino la licencia con el ID: " . $id;
$c->RegistrarAuditoriaEventos($usuario, $eventos);
if ($result == true) {
	echo 1;
} else {
	echo 0;
}
