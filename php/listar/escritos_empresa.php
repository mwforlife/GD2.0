<?php
header('Content-Type: application/json');
require '../controller.php';
$c = new Controller();

$response = array(
    'success' => false,
    'asignados' => array(),
    'disponibles' => array(),
    'totalAsignados' => 0,
    'totalDisponibles' => 0,
    'totalDocumentos' => 0,
    'message' => ''
);

if(isset($_POST['empresa']) && !empty($_POST['empresa'])){
    $empresa = intval($_POST['empresa']);

    // Usar funciones optimizadas con JOINs (solo 2 queries en lugar de N+1)
    $asignados = $c->listarDocumentosAsignados($empresa);
    $disponibles = $c->listarDocumentosDisponibles($empresa);

    $response['asignados'] = $asignados;
    $response['disponibles'] = $disponibles;
    $response['totalAsignados'] = count($asignados);
    $response['totalDisponibles'] = count($disponibles);
    $response['totalDocumentos'] = count($asignados) + count($disponibles);
    $response['success'] = true;
} else {
    $response['message'] = 'Empresa no especificada';
}

echo json_encode($response);
