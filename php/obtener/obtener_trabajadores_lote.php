<?php
require '../controller.php';
$c = new Controller();

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $loteId = $_POST['id'];
    $lista = $c->listarlotestext2($loteId);

    $trabajadores = array();
    $contratosExpress = 0;
    $contratosNormales = 0;

    foreach ($lista as $item) {
        $trabajador = array(
            'id' => $item['idcontrato'],
            'nombre' => $item['nombre'],
            'contrato' => $item['contrato'],
            'ruta_documento' => $item['ruta_documento'],
            'formato_contrato' => $item['formato_contrato'],
            'es_express' => ($item['formato_contrato'] != 1)
        );
        $trabajadores[] = $trabajador;

        if ($item['formato_contrato'] == 1) {
            $contratosNormales++;
        } else {
            $contratosExpress++;
        }
    }

    $todosExpress = ($contratosNormales == 0 && $contratosExpress > 0);

    echo json_encode(array(
        'status' => true,
        'trabajadores' => $trabajadores,
        'total' => count($trabajadores),
        'contratos_normales' => $contratosNormales,
        'contratos_express' => $contratosExpress,
        'todos_express' => $todosExpress
    ));
} elseif (isset($_POST['cart'])) {
    $cart = json_decode($_POST['cart'], true);
    $trabajadores = array();
    $contratosExpress = 0;
    $contratosNormales = 0;

    foreach ($cart as $item) {
        // Obtener formato_contrato del carrito (si existe) o asumir 1
        $formatoContrato = isset($item['formato_contrato']) ? intval($item['formato_contrato']) : 1;
        $esExpress = ($formatoContrato != 1);

        $trabajador = array(
            'id' => $item['id'],
            'nombre' => $item['trabajador'],
            'contrato' => $item['contrato'],
            'ruta_documento' => isset($item['ruta']) ? $item['ruta'] : '',
            'formato_contrato' => $formatoContrato,
            'es_express' => $esExpress
        );
        $trabajadores[] = $trabajador;

        if ($formatoContrato == 1) {
            $contratosNormales++;
        } else {
            $contratosExpress++;
        }
    }

    $todosExpress = ($contratosNormales == 0 && $contratosExpress > 0);

    echo json_encode(array(
        'status' => true,
        'trabajadores' => $trabajadores,
        'total' => count($trabajadores),
        'contratos_normales' => $contratosNormales,
        'contratos_express' => $contratosExpress,
        'todos_express' => $todosExpress
    ));
} else {
    echo json_encode(array(
        'status' => false,
        'message' => 'No se proporcionaron datos'
    ));
}
