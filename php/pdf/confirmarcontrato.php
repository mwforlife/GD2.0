<?php
/**
 * Confirmar Contrato - Guardar Definitivamente
 * Este archivo se ejecuta cuando el usuario confirma el contrato después del preview
 */

require '../controller.php';
require 'contrato_helper.php';

$c = new Controller();
$helper = new ContratoHelper($c);

// Iniciar sesión
session_start();

// Validar sesión de usuario
if (!isset($_SESSION['USER_ID'])) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Sesión no válida'
    ]);
    exit;
}

$valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
if ($valid == false) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Sesión expirada'
    ]);
    exit;
}

try {
    // ==================== RECUPERAR DATOS DE SESIÓN TEMPORAL ====================
    if (!isset($_SESSION['contrato_preview'])) {
        throw new Exception("No hay contrato pendiente de confirmación. Por favor, genera el preview nuevamente.");
    }

    $preview = $_SESSION['contrato_preview'];

    // Verificar que no haya expirado (30 minutos)
    if (time() - $preview['timestamp'] > 1800) {
        unset($_SESSION['contrato_preview']);
        throw new Exception("La sesión de preview ha expirado. Por favor, genera el contrato nuevamente.");
    }

    $pdfContent = $preview['pdf_content'];
    $trabajador = $preview['trabajador'];
    $empresa = $preview['empresa'];
    $tipocontrato = $preview['tipocontrato'];
    $_POST = $preview['post_data']; // Restaurar datos POST

    // ==================== GENERAR NOMBRE Y GUARDAR PDF ====================
    $timestamp = date('Ymdhis');
    $nombreDocumento = "Contrato_{$timestamp}.pdf";
    $rutaArchivo = "../../uploads/Contratos/{$nombreDocumento}";

    // Verificar que la carpeta existe
    if (!file_exists("../../uploads/Contratos/")) {
        mkdir("../../uploads/Contratos/", 0777, true);
    }

    // Guardar PDF en disco
    $resultado = file_put_contents($rutaArchivo, $pdfContent);

    if ($resultado === false) {
        throw new Exception("Error al guardar el archivo PDF en el servidor");
    }

    // ==================== PREPARAR DATOS DEL CONTRATO ====================

    // Obtener datos básicos
    $tra = $c->buscartrabajador($trabajador);
    $emp = $c->buscarEmpresavalor($empresa);

    // Procesar cargo
    $cargo = $_POST['Charge'] ?? '';
    if (is_numeric($cargo) && $cargo > 0) {
        $cargito = $c->buscarcargo($cargo);
        $cargo = $cargito->getNombre();
    }

    $cargoDescripcion = $_POST['ChargeDescripcion'] ?? '';
    $centrocosto = $_POST['centrocosto'] ?? 0;

    // Procesar sueldo
    $sueldo = $_POST['sueldo'] ?? 0;
    $sueldo = str_replace(".", "", $sueldo);
    $sueldo = str_replace(",", "", $sueldo);
    $sueldoNumerico = floatval($sueldo);

    // Procesar fechas
    $fechaInicio = $_POST['fecha_inicio'] ?? '';
    $fechaInicio = date('Y-m-d', strtotime($fechaInicio));

    $fechaTermino = $_POST['fecha_termino'] ?? '';
    if (!empty($fechaTermino)) {
        $fechaTermino = date('Y-m-d', strtotime($fechaTermino));
    } else {
        $fechaTermino = null;
    }

    // Tipo de contrato
    $typecontract = $_POST['typecontract'] ?? '';
    $tipo_contrato = $_POST['tipo_contrato'] ?? '';
    // ==================== INSERTAR CONTRATO PRINCIPAL ====================

    // Preparar datos básicos para el INSERT
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
        territorio_zona,
        subcontratacion,
        subcontratacion_rut,
        subcontratacion_razon_social,
        servicios_transitorios,
        transitorios_rut,
        transitorios_razon_social,
        tipo_sueldo,
        sueldo_base,
        asignacion_zona,
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
        afp_id,
        salud_id,
        pacto_badi,
        otros_terminos,
        jornada_excepcional,
        jornada_excluida,
        no_resolucion,
        fecha_excepcion,
        tipo_jornada,
        incluye_domingos,
        dias_trabajo,
        duracion_jornada,
        dias_trabajo_semanal,
        horario_turno,
        colacion,
        rotativo,
        colacion_imputable,
        colacion_imputable_tiempo,
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
        '$nombreDocumento',
        1,
        " . $typecontract . ",
        '" . addslashes($_POST['categoria_contrato'] ?? '') . "',
        " . (!empty($_POST['fechacelebracion']) ? "'" . date('Y-m-d', strtotime($_POST['fechacelebracion'])) . "'" : "NULL") . ",
        " . (isset($_POST['regioncelebracion']) && $_POST['regioncelebracion'] > 0 ? $_POST['regioncelebracion'] : "NULL") . ",
        " . (isset($_POST['comunacelebracion']) && $_POST['comunacelebracion'] > 0 ? $_POST['comunacelebracion'] : "NULL") . ",
        " . (!empty($_POST['fechacelebracion']) ? "'" . date('Y-m-d', strtotime($_POST['fechacelebracion'])) . "'" : "NULL") . ",
        $centrocosto,
        '" . addslashes($cargoDescripcion) . "',
        " . (isset($_POST['regionespecifica']) && $_POST['regionespecifica'] > 0 ? $_POST['regionespecifica'] : "NULL") . ",
        " . (isset($_POST['comunaespecifica']) && $_POST['comunaespecifica'] > 0 ? $_POST['comunaespecifica'] : "NULL") . ",
        '" . addslashes($_POST['calleespecifica'] ?? '') . "',
        '" . addslashes($_POST['numeroespecifica'] ?? '') . "',
        '" . addslashes($_POST['departamentoespecifica'] ?? '') . "',
        " . (isset($_POST['territoriozona']) && $_POST['territoriozona'] == 1 ? "1" : "0") . ",
        " . (isset($_POST['subcontratacionval']) && $_POST['subcontratacionval'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['subcontratacionrut'] ?? '') . "',
        '" . addslashes($_POST['subcontratacionrazonsocial'] ?? '') . "',
        " . (isset($_POST['transitoriosval']) && $_POST['transitoriosval'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['transitoriosrut'] ?? '') . "',
        '" . addslashes($_POST['transitoriosrazonsocial'] ?? '') . "',
        " . (isset($_POST['tiposueldo']) && $_POST['tiposueldo'] > 0 ? $_POST['tiposueldo'] : "NULL") . ",
        $sueldoNumerico,
        " . (isset($_POST['asignacion']) && !empty($_POST['asignacion']) ? floatval(str_replace(['.', ','], ['', ''], $_POST['asignacion'])) : "NULL") . ",
        " . (isset($_POST['formapago']) && $_POST['formapago'] > 0 ? $_POST['formapago'] : "NULL") . ",
        '" . addslashes($_POST['periodopagogra'] ?? '') . "',
        '" . addslashes($_POST['detallerenumeraciongra'] ?? '') . "',
        '" . addslashes($_POST['periodopagot'] ?? '') . "',
        '" . addslashes($_POST['fechapagot'] ?? '') . "',
        " . (isset($_POST['formapagot']) && $_POST['formapagot'] > 0 ? $_POST['formapagot'] : "NULL") . ",
        " . (isset($_POST['banco']) && $_POST['banco'] > 0 ? $_POST['banco'] : "NULL") . ",
        " . (isset($_POST['tipocuenta']) && $_POST['tipocuenta'] > 0 ? $_POST['tipocuenta'] : "NULL") . ",
        '" . addslashes($_POST['numerocuenta'] ?? '') . "',
        '" . addslashes($_POST['anticipot'] ?? '') . "',
        " . (isset($_POST['afp']) && $_POST['afp'] > 0 ? $_POST['afp'] : "NULL") . ",
        " . (isset($_POST['salud']) && $_POST['salud'] > 0 ? $_POST['salud'] : "NULL") . ",
        " . (isset($_POST['badi']) && $_POST['badi'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['otrter'] ?? '') . "',
        " . (isset($_POST['jornadaesc']) && $_POST['jornadaesc'] == 1 ? "1" : "0") . ",
        " . (isset($_POST['exluido']) && $_POST['exluido'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['noresolucion'] ?? '') . "',
        " . (!empty($_POST['exfech']) ? "'" . date('Y-m-d', strtotime($_POST['exfech'])) . "'" : "NULL") . ",
        " . (isset($_POST['tipojornada']) && $_POST['tipojornada'] > 0 ? $_POST['tipojornada'] : "NULL") . ",
        " . (isset($_POST['incluye']) && $_POST['incluye'] == 1 ? "1" : "0") . ",
        '" . addslashes($_POST['dias'] ?? '') . "',
        '" . addslashes($_POST['duracionjor'] ?? '') . "',
        '" . addslashes($_POST['diasf'] ?? '') . "',
        " . (isset($_POST['horarioturno']) && $_POST['horarioturno'] > 0 ? $_POST['horarioturno'] : "NULL") . ",
        '" . addslashes($_POST['colacion'] ?? '') . "',
        '" . addslashes($_POST['rotativo'] ?? '') . "',
        '" . addslashes($_POST['colacionimp'] ?? '') . "',
        '" . addslashes($_POST['colanoipu'] ?? '') . "',
        NOW()
    )";

    $duracionjor = $_POST['duracionjor'] ?? '';
    $horaspac = 0;
    switch ($duracionjor) {
        case '1':
            $duracionjor = "45 Horas";
            $horaspac = 45;
            break;
        case '2':
            $duracionjor = "44 Horas";
            $horaspac = 44;
            break;
        case '3':
            $duracionjor = "43 Horas";
            $horaspac = 43;
            break;
        case '4':
            $duracionjor = "42 Horas";
            $horaspac = 42;
            break;
        case '5':
            $duracionjor = "41 Horas";
            $horaspac = 41;
            break;
        case '6':
            $duracionjor = "40 Horas";
            $horaspac = 40;
            break;
        case '7':
            $duracionjor = "39 Horas";
            $horaspac = 39;
            break;
        case '8':
            $duracionjor = "38 Horas";
            $horaspac = 38;
            break;
        case '9':
            $duracionjor = "37 Horas";
            $horaspac = 37;
            break;
        case '10':
            $duracionjor = "36 Horas";
            $horaspac = 36;
            break;
        case '11':
            $duracionjor = "35 Horas";
            $horaspac = 35;
            break;
        case '12':
            $duracionjor = "34 Horas";
            $horaspac = 34;
            break;
        case '13':
            $duracionjor = "33 Horas";
            $horaspac = 33;
            break;
        case '14':
            $duracionjor = "32 Horas";
            $horaspac = 32;
            break;
        case '15':
            $duracionjor = "31 Horas";
            $horaspac = 31;
            break;
        case '16':
            $duracionjor = "30 Horas";
            $horaspac = 30;
            break;
        case '17':
            $duracionjor = "29 Horas";
            $horaspac = 29;
            break;
        case '18':
            $duracionjor = "28 Horas";
            $horaspac = 28;
            break;
        case '19':
            $duracionjor = "27 Horas";
            $horaspac = 27;
            break;
        case '20':
            $duracionjor = "26 Horas";
            $horaspac = 26;
            break;
        case '21':
            $duracionjor = "25 Horas";
            $horaspac = 25;
            break;
        case '22':
            $duracionjor = "24 Horas";
            $horaspac = 24;
            break;
        case '23':
            $duracionjor = "23 Horas";
            $horaspac = 23;
            break;
        case '24':
            $duracionjor = "22 Horas";
            $horaspac = 22;
            break;
        case '25':
            $duracionjor = "21 Horas";
            $horaspac = 21;
            break;
        case '26':
            $duracionjor = "20 Horas";
            $horaspac = 20;
            break;
        case '27':
            $duracionjor = "19 Horas";
            $horaspac = 19;
            break;
        case '28':
            $duracionjor = "18 Horas";
            $horaspac = 18;
            break;
        case '29':
            $duracionjor = "17 Horas";
            $horaspac = 17;
            break;
        case '30':
            $duracionjor = "16 Horas";
            $horaspac = 16;
            break;
        case '31':
            $duracionjor = "15 Horas";
            $horaspac = 15;
            break;
        case '32':
            $duracionjor = "14 Horas";
            $horaspac = 14;
            break;
        case '33':
            $duracionjor = "13 Horas";
            $horaspac = 13;
            break;
        case '34':
            $duracionjor = "12 Horas";
            $horaspac = 12;
            break;
        case '35':
            $duracionjor = "11 Horas";
            $horaspac = 11;
            break;
        case '36':
            $duracionjor = "10 Horas";
            $horaspac = 10;
            break;
        case '37':
            $duracionjor = "9 Horas";
            $horaspac = 9;
            break;
        case '38':
            $duracionjor = "8 Horas";
            $horaspac = 8;
            break;
        case '39':
            $duracionjor = "7 Horas";
            $horaspac = 7;
            break;
        case '40':
            $duracionjor = "6 Horas";
            $horaspac = 6;
            break;
        case '41':
            $duracionjor = "5 Horas";
            $horaspac = 5;
            break;
        case '42':
            $duracionjor = "4 Horas";
            $horaspac = 4;
            break;
        case '43':
            $duracionjor = "3 Horas";
            $horaspac = 3;
            break;
        case '44':
            $duracionjor = "2 Horas";
            $horaspac = 2;
            break;
        case '45':
            $duracionjor = "1 Hora";
            $horaspac = 1;
            break;
        case '46':
            $duracionjor = "30 Minutos";
            $horaspac = 0.5;
            break;
    }

    // Debug: guardar SQL para revisión
    error_log("SQL Contrato: " . $sql);

    $contratoId = $c->query_id($sql);

    if (!$contratoId || $contratoId <= 0) {
        // Obtener error de MySQL
        $errorSQL = $c->getLastError();
        error_log("Error MySQL: " . $errorSQL);
        throw new Exception("Error al registrar el contrato en la base de datos. Detalle: " . $errorSQL);
    }

    // ==================== INSERTAR HORAS PACTADAS ====================

    $c->query("insert into horaspactadas values(null,$horaspac,$contratoId,now())");

    // ==================== INSERTAR DISTRIBUCIÓN HORARIA ====================
    $turnos = ['normal' => 1, 'matutino' => 2, 'tarde' => 3, 'noche' => 4];
    $distribucionInsertada = false;

    foreach ($turnos as $nombreTurno => $numeroTurno) {
        for ($dia = 1; $dia <= 7; $dia++) {
            $checkboxId = "dias{$numeroTurno}{$dia}";
            $horaInicioId = "hora{$numeroTurno}{$dia}";
            $horaTerminoId = "horat{$numeroTurno}{$dia}";

            $diaSeleccionado = isset($_POST[$checkboxId]) ? 1 : 0;
            $horaInicio = isset($_POST[$horaInicioId]) ? $_POST[$horaInicioId] : null;
            $horaTermino = isset($_POST[$horaTerminoId]) ? $_POST[$horaTerminoId] : null;

            // Solo insertar si hay datos significativos
            if ($diaSeleccionado || $horaInicio || $horaTermino) {
                $sqlHorario = "INSERT INTO contrato_distribucion_horaria
                    (contrato_id, tipo_turno, dia_semana, dia_seleccionado, hora_inicio, hora_termino)
                    VALUES (
                        $contratoId,
                        '$nombreTurno',
                        $dia,
                        $diaSeleccionado,
                        " . ($horaInicio ? "'$horaInicio'" : "NULL") . ",
                        " . ($horaTermino ? "'$horaTermino'" : "NULL") . "
                    )";

                $c->query($sqlHorario);
                $distribucionInsertada = true;
            }
        }
    }

    // ==================== INSERTAR ESTIPULACIONES ====================
    $estipulacionesInsertadas = 0;
    for ($i = 1; $i <= 13; $i++) {
        $estipulacionKey = "estipulacion{$i}";
        if (isset($_POST[$estipulacionKey]) && !empty(trim($_POST[$estipulacionKey]))) {
            $contenido = addslashes(trim($_POST[$estipulacionKey]));
            $sqlEstipulacion = "INSERT INTO contrato_estipulaciones
                (contrato_id, numero_estipulacion, contenido)
                VALUES ($contratoId, $i, '$contenido')";
            $c->query($sqlEstipulacion);
            $estipulacionesInsertadas++;
        }
    }

    // ==================== REGISTRAR AUDITORÍA ====================
    $usuario = $_SESSION['USER_ID'];
    $eventos = "Registró contrato de trabajo para el trabajador " .
               $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2();
    $c->RegistrarAuditoriaEventos($usuario, $eventos);

    // ==================== LIMPIAR SESIÓN TEMPORAL ====================
    unset($_SESSION['contrato_preview']);

    // ==================== RESPONDER CON ÉXITO ====================
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'contrato_id' => $contratoId,
        'documento' => $nombreDocumento,
        'trabajador' => $tra->getNombre() . ' ' . $tra->getApellido1(),
        'empresa' => $emp->getRazonSocial(),
        'distribucion_insertada' => $distribucionInsertada,
        'estipulaciones_insertadas' => $estipulacionesInsertadas,
        'message' => 'Contrato registrado exitosamente'
    ]);

} catch (Exception $e) {
    // Registrar error en log
    error_log("Error al confirmar contrato: " . $e->getMessage());

    // Responder con error
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
