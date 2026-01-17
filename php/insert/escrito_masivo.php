<?php
header('Content-Type: application/json');
require '../controller.php';
$c = new Controller();

$response = array(
    'success' => false,
    'message' => '',
    'procesados' => 0
);

if(isset($_POST['empresa']) && isset($_POST['accion'])){
    $empresa = intval($_POST['empresa']);
    $accion = $_POST['accion'];

    if($accion == 'asignar_todos'){
        // Usar función optimizada (una sola query INSERT...SELECT)
        $asignados = $c->asignarTodosDocumentos($empresa);

        $response['success'] = true;
        $response['procesados'] = $asignados;

        if($asignados > 0){
            $response['message'] = "Se asignaron $asignados documento(s) correctamente";
        } else {
            $response['message'] = "Todos los documentos ya estaban asignados";
        }

    } else if($accion == 'desasignar_todos'){
        // Usar función optimizada (una sola query DELETE)
        $desasignados = $c->desasignarTodosDocumentos($empresa);

        $response['success'] = true;
        $response['procesados'] = $desasignados;

        if($desasignados > 0){
            $response['message'] = "Se desasignaron $desasignados documento(s) correctamente";
        } else {
            $response['message'] = "No había documentos para desasignar";
        }
    } else {
        $response['message'] = 'Acción no válida';
    }
} else {
    $response['message'] = 'Parámetros incompletos';
}

echo json_encode($response);
