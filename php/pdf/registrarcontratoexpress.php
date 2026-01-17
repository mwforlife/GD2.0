<?php
/**
 * Registrar Contrato Express - Sin documento PDF
 * Este archivo registra el contrato directamente sin generar PDF
 */

require '../controller.php';

$c = new Controller();

// Iniciar sesión
session_start();

// Configurar respuesta JSON
header('Content-Type: application/json');

// Validar sesión de usuario
if (!isset($_SESSION['USER_ID'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Sesión no válida'
    ]);
    exit;
}

$valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
if ($valid == false) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Sesión expirada'
    ]);
    exit;
}

try {
    // ==================== VALIDAR DATOS REQUERIDOS ====================
    $trabajador = isset($_POST['idtrabajador']) ? intval($_POST['idtrabajador']) : 0;
    $empresa = isset($_POST['idempresa']) ? intval($_POST['idempresa']) : 0;

    if ($trabajador <= 0) {
        throw new Exception("ID de trabajador no válido");
    }
    if ($empresa <= 0) {
        throw new Exception("ID de empresa no válido");
    }

    // ==================== OBTENER DATOS DEL TRABAJADOR Y EMPRESA ====================
    $tra = $c->buscartrabajador($trabajador);
    $emp = $c->buscarEmpresavalor($empresa);

    if (!$tra) {
        throw new Exception("Trabajador no encontrado");
    }
    if (!$emp) {
        throw new Exception("Empresa no encontrada");
    }

    // ==================== PROCESAR DATOS DEL FORMULARIO ====================

    // Procesar cargo
    $cargo = $_POST['Charge'] ?? '';
    if (is_numeric($cargo) && $cargo > 0) {
        $cargito = $c->buscarcargo($cargo);
        if ($cargito) {
            $cargo = $cargito->getNombre();
        }
    }

    $cargoDescripcion = $_POST['ChargeDescripcion'] ?? '';
    $centrocosto = isset($_POST['centrocosto']) ? intval($_POST['centrocosto']) : 0;

    // Procesar sueldo
    $sueldo = $_POST['sueldo'] ?? 0;
    $sueldo = str_replace(".", "", $sueldo);
    $sueldo = str_replace(",", "", $sueldo);
    $sueldoNumerico = floatval($sueldo);

    // Procesar fechas
    $fechaInicio = $_POST['fecha_inicio'] ?? '';
    if (!empty($fechaInicio)) {
        $fechaInicio = date('Y-m-d', strtotime($fechaInicio));
    }

    $fechaTermino = $_POST['fecha_termino'] ?? '';
    if (!empty($fechaTermino)) {
        $fechaTermino = date('Y-m-d', strtotime($fechaTermino));
    } else {
        $fechaTermino = null;
    }

    // Tipo de contrato
    $tipo_contrato = $_POST['tipo_contrato'] ?? 1;
    $typecontract = $_POST['typecontract'] ?? 2; // 2 = Express

    // Procesar duración de jornada
    $duracionjor = $_POST['duracionjor'] ?? '';
    $horaspac = 0;
    switch ($duracionjor) {
        case '1': $horaspac = 45; break;
        case '2': $horaspac = 44; break;
        case '3': $horaspac = 43; break;
        case '4': $horaspac = 42; break;
        case '5': $horaspac = 41; break;
        case '6': $horaspac = 40; break;
        case '7': $horaspac = 39; break;
        case '8': $horaspac = 38; break;
        case '9': $horaspac = 37; break;
        case '10': $horaspac = 36; break;
        case '11': $horaspac = 35; break;
        case '12': $horaspac = 34; break;
        case '13': $horaspac = 33; break;
        case '14': $horaspac = 32; break;
        case '15': $horaspac = 31; break;
        case '16': $horaspac = 30; break;
        case '17': $horaspac = 29; break;
        case '18': $horaspac = 28; break;
        case '19': $horaspac = 27; break;
        case '20': $horaspac = 26; break;
        case '21': $horaspac = 25; break;
        case '22': $horaspac = 24; break;
        case '23': $horaspac = 23; break;
        case '24': $horaspac = 22; break;
        case '25': $horaspac = 21; break;
        case '26': $horaspac = 20; break;
        case '27': $horaspac = 19; break;
        case '28': $horaspac = 18; break;
        case '29': $horaspac = 17; break;
        case '30': $horaspac = 16; break;
        case '31': $horaspac = 15; break;
        case '32': $horaspac = 14; break;
        case '33': $horaspac = 13; break;
        case '34': $horaspac = 12; break;
        case '35': $horaspac = 11; break;
        case '36': $horaspac = 10; break;
        case '37': $horaspac = 9; break;
        case '38': $horaspac = 8; break;
        case '39': $horaspac = 7; break;
        case '40': $horaspac = 6; break;
        case '41': $horaspac = 5; break;
        case '42': $horaspac = 4; break;
        case '43': $horaspac = 3; break;
        case '44': $horaspac = 2; break;
        case '45': $horaspac = 1; break;
        case '46': $horaspac = 0.5; break;
        default: $horaspac = 45; break;
    }

    // ==================== INSERTAR CONTRATO PRINCIPAL ====================

    $sql = "INSERT INTO contratos (
        trabajador,
        empresa,
        centrocosto,
        tipocontrato,
        cargo,
        sueldo,
        fechainicio,
        fechatermino,
        documento,
        estado,
        formato_contrato,
        categoria_contrato,
        fecha_suscripcion,
        region_celebracion,
        comuna_celebracion,
        fecha_celebracion,
        centro_costo,
        cargo_descripcion,
        region_especifica,
        comuna_especifica,
        calle_especifica,
        numero_especifico,
        dept_oficina_especifico,
        subcontratacion,
        subcontratacion_rut,
        subcontratacion_razon_social,
        servicios_transitorios,
        transitorios_rut,
        transitorios_razon_social,
        tipo_sueldo,
        sueldo_base,
        forma_pago,
        periodo_pago_gratificacion,
        detalle_gratificacion,
        periodo_pago_trabajador,
        fecha_pago_trabajador,
        forma_pago_trabajador,
        banco_id,
        tipo_cuenta_id,
        numero_cuenta,
        anticipo,
        pacto_badi,
        otros_terminos,
        duracion_jornada,
        register_at
    ) VALUES (
        $trabajador,
        $empresa,
        $centrocosto,
        '$tipo_contrato',
        '" . addslashes($cargo) . "',
        $sueldoNumerico,
        '$fechaInicio',
        " . ($fechaTermino ? "'$fechaTermino'" : "NULL") . ",
        NULL,
        1,
        " . intval($typecontract) . ",
        '" . addslashes($_POST['categoria_contrato'] ?? '1') . "',
        " . (!empty($_POST['fechacelebracion']) ? "'" . date('Y-m-d', strtotime($_POST['fechacelebracion'])) . "'" : "NULL") . ",
        " . (isset($_POST['regioncelebracion']) && $_POST['regioncelebracion'] > 0 ? intval($_POST['regioncelebracion']) : "NULL") . ",
        " . (isset($_POST['comunacelebracion']) && $_POST['comunacelebracion'] > 0 ? intval($_POST['comunacelebracion']) : "NULL") . ",
        " . (!empty($_POST['fechacelebracion']) ? "'" . date('Y-m-d', strtotime($_POST['fechacelebracion'])) . "'" : "NULL") . ",
        $centrocosto,
        '" . addslashes($cargoDescripcion) . "',
        " . (isset($_POST['regionespecifica']) && $_POST['regionespecifica'] > 0 ? intval($_POST['regionespecifica']) : "NULL") . ",
        " . (isset($_POST['comunaespecifica']) && $_POST['comunaespecifica'] > 0 ? intval($_POST['comunaespecifica']) : "NULL") . ",
        '" . addslashes($_POST['calleespecifica'] ?? '') . "',
        '" . addslashes($_POST['numeroespecifica'] ?? '') . "',
        '" . addslashes($_POST['departamentoespecifica'] ?? '') . "',
        " . (isset($_POST['subcontratacionval']) && $_POST['subcontratacionval'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['subcontratacionrut'] ?? '') . "',
        '" . addslashes($_POST['subcontratacionrazonsocial'] ?? '') . "',
        " . (isset($_POST['transitoriosval']) && $_POST['transitoriosval'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['transitoriosrut'] ?? '') . "',
        '" . addslashes($_POST['transitoriosrazonsocial'] ?? '') . "',
        " . (isset($_POST['tiposueldo']) && $_POST['tiposueldo'] > 0 ? intval($_POST['tiposueldo']) : "NULL") . ",
        $sueldoNumerico,
        " . (isset($_POST['formapago']) && $_POST['formapago'] > 0 ? intval($_POST['formapago']) : "NULL") . ",
        '" . addslashes($_POST['periodopagogra'] ?? '') . "',
        '" . addslashes($_POST['detallerenumeraciongra'] ?? '') . "',
        '" . addslashes($_POST['periodopagot'] ?? '') . "',
        '" . addslashes($_POST['fechapagot'] ?? '') . "',
        " . (isset($_POST['formapagot']) && $_POST['formapagot'] > 0 ? intval($_POST['formapagot']) : "NULL") . ",
        " . (isset($_POST['banco']) && $_POST['banco'] > 0 ? intval($_POST['banco']) : "NULL") . ",
        " . (isset($_POST['tipocuenta']) && $_POST['tipocuenta'] > 0 ? intval($_POST['tipocuenta']) : "NULL") . ",
        '" . addslashes($_POST['numerocuenta'] ?? '') . "',
        '" . addslashes($_POST['anticipot'] ?? '') . "',
        " . (isset($_POST['badi']) && $_POST['badi'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['otrter'] ?? '') . "',
        '" . addslashes($duracionjor) . "',
        NOW()
    )";

    // Debug: guardar SQL para revisión
    error_log("SQL Contrato Express: " . $sql);

    $contratoId = $c->query_id($sql);

    if (!$contratoId || $contratoId <= 0) {
        $errorSQL = $c->getLastError();
        error_log("Error MySQL Contrato Express: " . $errorSQL);
        throw new Exception("Error al registrar el contrato en la base de datos. Detalle: " . $errorSQL);
    }

    // ==================== INSERTAR HORAS PACTADAS ====================

    $c->query("INSERT INTO horaspactadas VALUES(null, $horaspac, $contratoId, now())");

    // ==================== REGISTRAR AUDITORÍA ====================
    $usuario = $_SESSION['USER_ID'];
    $eventos = "Registró contrato express de trabajo para el trabajador " .
               $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2();
    $c->RegistrarAuditoriaEventos($usuario, $eventos);

    // ==================== RESPONDER CON ÉXITO ====================
    echo json_encode([
        'success' => true,
        'contrato_id' => $contratoId,
        'trabajador' => $tra->getNombre() . ' ' . $tra->getApellido1() . ' ' . $tra->getApellido2(),
        'empresa' => $emp->getRazonSocial(),
        'message' => 'Contrato express registrado exitosamente'
    ]);

} catch (Exception $e) {
    // Registrar error en log
    error_log("Error al registrar contrato express: " . $e->getMessage());

    // Responder con error
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
