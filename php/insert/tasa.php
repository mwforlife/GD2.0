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

if(isset($_POST['id'])&& isset($_POST['capitalizacion_individual']) && isset($_POST['tasa']) && isset($_POST['fecha'])){
    $id = $_POST['id'];
    $capitalizacion_individual = $_POST['capitalizacion_individual'];
    $tasa = $_POST['tasa'];
    $fecha = $_POST['fecha'];

    if(strlen($tasa) > 0 && strlen($fecha) > 0){
        $fecha = $fecha . "-01";
    }else{
        echo "No se recibieron los datos";
        return;
    }
        

    //Validar si existe la tasa
    $tasaid = $c->validartasaafp($id, $fecha);
    if($tasaid == false){
        $result = $c->registrartasaafp($id, $fecha,$capitalizacion_individual, $tasa);
        if($result == true){
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Registro la tasa : ".$tasa . " con el ID: ".$id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }else{
            echo 0;
        }
    }else{
        $result = $c->actualizartasaafp($tasa,$capitalizacion_individual, $tasaid);
        if($result==true){
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Registro la tasa : ".$tasa . " con el ID: ".$id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }else{
            echo 0;
        }
    }
}else{
    echo "No se recibieron los datos";
}