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

    // Validar que no esté ya asignado
    $valid = $c->validardocumento($empresa, $id);

    if($valid == false){
        $result = $c->asignardocumento($empresa, $id);
        if($result){
            $response['success'] = true;
            $response['message'] = 'Documento asignado correctamente';
            $response['code'] = 1;
        } else {
            $response['message'] = 'Error al asignar el documento';
            $response['code'] = 0;
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'El documento ya está asignado a esta empresa';
        $response['code'] = 2;
    }
} else {
    $response['message'] = 'Parámetros incompletos';
    $response['code'] = 0;
}

echo json_encode($response);
