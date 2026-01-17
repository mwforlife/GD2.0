<?php
header('Content-Type: application/json');
require '../controller.php';
$c = new Controller();

$response = array(
    'success' => false,
    'message' => '',
    'code' => 0
);

if(isset($_POST['id']) && isset($_POST['empresa'])){
    $id = intval($_POST['id']);
    $empresa = intval($_POST['empresa']);

    // Verificar que el documento esté asignado
    $valid = $c->validardocumento($empresa, $id);

    if($valid == true){
        $result = $c->retirardocumento($empresa, $id);
        $response['success'] = true;
        $response['message'] = 'Documento desasignado correctamente';
        $response['code'] = 1;
    } else {
        $response['success'] = false;
        $response['message'] = 'El documento no estaba asignado';
        $response['code'] = 2;
    }
} else {
    $response['message'] = 'Parámetros incompletos';
    $response['code'] = 0;
}

echo json_encode($response);
