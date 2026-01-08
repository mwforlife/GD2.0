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

if(isset($_POST['tabla']) && isset($_POST['id'])){
    $tabla = $_POST['tabla'];
    $id = $_POST['id'];

    // Validar nombre de tabla para seguridad
    $tablasPermitidas = array('expectativadevida', 'rentabilidadprotegida', 'sis');
    if(!in_array($tabla, $tablasPermitidas)){
        echo "Tabla no permitida";
        exit;
    }

    // Nombre completo de la tabla
    $nombreTabla = 'segurosocial_' . $tabla;

    try {
        // Llamar función del controlador para eliminar
        $result = $c->eliminarsegurosocial($nombreTabla, $id);

        if($result == true){
            echo 1;
            // Registrar auditoría
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se eliminó registro de " . $nombreTabla . " con ID: " . $id;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }else{
            echo 0;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}else{
    echo "No se recibieron los datos completos";
}
