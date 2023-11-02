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

if( isset($_POST['idedit']) && $_POST['periodoedit'] && isset($_POST['tasaedit'])){
    $id = $_POST['idedit'];
    $periodo = $_POST['periodoedit'];
    $tasa = $_POST['tasaedit'];
    $tasa = str_replace(".", "", $tasa);
    $tasa = str_replace(",", ".", $tasa);
    $utm = $c->buscarutmbyid($id);
    
    //Validar campos
    if(strlen($periodo) == 0 || strlen($tasa) == 0){
        echo json_encode(array('status' => false, 'message' => 'Error: Campos vacios'));
    }else{
        $periodo = $periodo."-01";
        $result = $c->actualizarutm($id, $periodo, $tasa);
        if($result==true){
            echo json_encode(array('status' => true, 'message' => 'UTM Actualizada correctamente'));
        }else{
            echo json_encode(array('status' => false, 'message' => 'Error al actualizar UTM'));
        }
    }

    
$usuario = $_SESSION['USER_ID'];
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
$eventos = "Se actualizo la UTM con el ID: ".$id." por el Periodo ".$periodo . " con la tasa: ".$tasa;
$c->RegistrarAuditoriaEventos($usuario, $eventos);
}else{
    echo json_encode(array('status' => false, 'message' => 'Error: No se pudo actualizar la UTM'));
}