<?php
require '../controller.php';
$c = new Controller();
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada']);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de anexo no provisto']);
    exit;
}

$id = intval($_GET['id']);
$anexo = $c->buscaranexo($id);

if ($anexo === null) {
    echo json_encode(['success' => false, 'message' => 'Anexo no encontrado']);
    exit;
}

$contrato_id = $anexo->getContrato();
$contrato = $c->buscarcontratoid($contrato_id);

if ($contrato === false) {
    echo json_encode(['success' => false, 'message' => 'Contrato asociado no encontrado']);
    exit;
}

echo json_encode([
    'success' => true,
    'id' => $anexo->getId(),
    'contrato_id' => $contrato_id,
    'trabajador' => $contrato->getTrabajador(),
    'fecha_termino' => $anexo->getFechaTermino(),
    'modifica_fecha' => $anexo->getModificaFecha()
]);
