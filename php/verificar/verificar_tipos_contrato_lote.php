<?php
/**
 * Verifica los tipos de contrato en el lote de anexos actual
 * Retorna información sobre contratos a plazo fijo e indefinidos
 */

session_start();
require '../controller.php';

header('Content-Type: application/json');

// Verificar que el usuario esté autenticado
if(!isset($_SESSION['USER_ID'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

// Verificar que se recibió el ID de empresa
if(!isset($_POST['empresa'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibió ID de empresa'
    ]);
    exit;
}

$c = new Controller();
$empresa = $_POST['empresa'];
$usuario = $_SESSION['USER_ID'];

try {
    // Obtener contratos del lote actual
    $lista = $c->buscarloteanexo($usuario, $empresa);

    $tiene_plazo_fijo = false;
    $tiene_indefinidos = false;
    $total_contratos = count($lista);
    $contratos_plazo_fijo = 0;
    $contratos_indefinidos = 0;

    // Analizar cada contrato
    foreach($lista as $contrato) {
        $fechaTermino = $contrato->getFechatermino();

        // Si la fecha de término está vacía o es null, es indefinido
        if(empty($fechaTermino) || $fechaTermino == '' || $fechaTermino == null || $fechaTermino == '0000-00-00') {
            $tiene_indefinidos = true;
            $contratos_indefinidos++;
        } else {
            $tiene_plazo_fijo = true;
            $contratos_plazo_fijo++;
        }
    }

    // Preparar respuesta
    $response = [
        'success' => true,
        'tiene_plazo_fijo' => $tiene_plazo_fijo,
        'tiene_indefinidos' => $tiene_indefinidos,
        'total' => $total_contratos,
        'contratos_plazo_fijo' => $contratos_plazo_fijo,
        'contratos_indefinidos' => $contratos_indefinidos,
        'message' => 'Verificación completada correctamente'
    ];

    echo json_encode($response);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al verificar contratos: ' . $e->getMessage()
    ]);
}
?>
