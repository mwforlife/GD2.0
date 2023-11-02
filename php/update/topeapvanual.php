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

if( isset($_POST['idedit']) && $_POST['periodoedit'] && isset($_POST['topeedit'])){
    $id = $_POST['idedit'];
    $periodo = $_POST['periodoedit'];
    $tasa = $_POST['topeedit'];
    $tasa = str_replace(".", "", $tasa);
    $tasa = str_replace(",", ".", $tasa);
    $topeapvanual = $c->buscartopeapvanualbyid($id);
    
    //Validar campos
    if(strlen($periodo) == 0 || strlen($tasa) == 0){
        echo json_encode(array('status' => false, 'message' => 'Error: Campos vacios'));
    }else{
        $result = $c->actualizartopeapvanual($id, $periodo, $tasa);
        if($result==true){
            echo json_encode(array('status' => true, 'message' => 'TOPE APV ANUAL Actualizada correctamente'));
        }else{
            echo json_encode(array('status' => false, 'message' => 'Error al actualizar TOPE APV ANUAL'));
        }
    }

    
$usuario = $_SESSION['USER_ID'];
$eventos = "Se actualizo el TOPE APV ANUAL con el ID: ".$id." por el Año ".$periodo . " con el tope: ".$tasa;
$c->RegistrarAuditoriaEventos($usuario, $eventos);
}else{
    echo json_encode(array('status' => false, 'message' => 'Error: No se pudo actualizar el TOPE APV ANUAL'));
}