<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		echo json_encode(array('status' => false, 'message' => 'Error con la sesion, vuelva a iniciar sesion'));
	}
}

if(isset($_POST['id'])){

$id = $_POST['id'];
$usuario = $_SESSION['USER_ID'];

$topeapvanual = $c->buscartopeapvanualbyid($id);
$result = $c->eliminartopeapvanual($id);

$usuario = $_SESSION['USER_ID'];

$periodo = $topeapvanual->getPeriodo();
$mes = date("m", strtotime($periodo));
$anio = date("Y", strtotime($periodo));
switch ($mes) {
	case 1:
		$mes = "Enero";
		break;
	case 2:
		$mes = "Febrero";
		break;
	case 3:
		$mes = "Marzo";
		break;
	case 4:
		$mes = "Abril";
		break;
	case 5:
		$mes = "Mayo";
		break;
	case 6:
		$mes = "Junio";
		break;
	case 7:
		$mes = "Julio";
		break;
	case 8:
		$mes = "Agosto";
		break;
	case 9:
		$mes = "Septiembre";
		break;
	case 10:
		$mes = "Octubre";
		break;
	case 11:
		$mes = "Noviembre";
		break;
	case 12:
		$mes = "Diciembre";
		break;
}
$periodo = $mes . " " . $anio;
$eventos = "Se elimino el TOPE AFP del Periodo ".$periodo . " con el tope: ".$topeapvanual->getTasa() . " con el ID: ".$id;
$c->RegistrarAuditoriaEventos($usuario, $eventos);


if($result == true){
    echo json_encode(array('status' => true, 'message' => 'TOPE AFP eliminada correctamente'));
}else{
    echo json_encode(array('status' => false, 'message' => 'Error al eliminar TOPE AFP'));
}
}else{
	echo json_encode(array('status' => false, 'message' => 'No se recibieron los datos'));
}