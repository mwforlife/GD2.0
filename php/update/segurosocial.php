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

if(isset($_POST['tabla']) && isset($_POST['id']) && isset($_POST['fecha']) && isset($_POST['tasa'])){
    $tabla = $_POST['tabla'];
    $id = $_POST['id'];
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    $codigoPrevired = isset($_POST['codigoPrevired']) ? $_POST['codigoPrevired'] : '';
    $fecha = $_POST['fecha'];
    $tasa = $_POST['tasa'];

    // Validar nombre de tabla para seguridad
    $tablasPermitidas = array('expectativadevida', 'rentabilidadprotegida', 'sis');
    if(!in_array($tabla, $tablasPermitidas)){
        echo "Tabla no permitida";
        exit;
    }

    // Formatear fecha
    if(strlen($fecha) > 0){
        $fecha = $fecha . "-01";
    }else{
        echo "Fecha inválida";
        exit;
    }

    // Nombre completo de la tabla
    $nombreTabla = 'segurosocial_' . $tabla;

    try {
        // Llamar función del controlador para actualizar
        $result = $c->actualizarsegurosocial($nombreTabla, $id, $codigo, $codigoPrevired, $fecha, $tasa);

        if($result == true){
            echo 1;
            // Registrar auditoría
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se actualizó tasa en " . $nombreTabla . " ID: " . $id . " - Código: " . $codigo . ", Código Previred: " . $codigoPrevired . ", Fecha: " . $fecha . ", Tasa: " . $tasa;
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
