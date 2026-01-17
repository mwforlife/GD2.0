<?php
/**
 * Confirmar Contratos Masivos - Guardar Definitivamente
 * Este archivo se ejecuta cuando el usuario confirma los contratos después del preview masivo
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
    if (!isset($_SESSION['contrato_masivo_preview'])) {
        throw new Exception("No hay contratos pendientes de confirmación. Por favor, genera el preview nuevamente.");
    }

    $preview = $_SESSION['contrato_masivo_preview'];

    // Verificar que no haya expirado (30 minutos)
    if (time() - $preview['timestamp'] > 1800) {
        unset($_SESSION['contrato_masivo_preview']);
        throw new Exception("La sesión de preview ha expirado. Por favor, genera los contratos nuevamente.");
    }

    $pdfContent = $preview['pdf_content'];
    $pdfsIndividuales = $preview['pdfs_individuales'] ?? []; // PDFs individuales por trabajador
    $empresa = $preview['empresa'];
    $tipocontrato = $preview['tipocontrato'];
    $trabajadoresInfo = $preview['trabajadores'];
    $trabajadoresIds = $preview['trabajadores_ids'];
    $_POST = $preview['post_data']; // Restaurar datos POST

    // ==================== GENERAR NOMBRE Y GUARDAR PDF ====================
    $timestamp = date('Ymdhis');
    $nombreDocumento = "Contrato_Masivo_{$timestamp}.pdf";
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

    // ==================== PREPARAR DATOS COMUNES DEL CONTRATO ====================
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
    $typecontract = $_POST['typecontract'] ?? 1;
    if (empty($typecontract) || !is_numeric($typecontract)) {
        $typecontract = 1; // Por defecto: Indefinido
    }
    $typecontract = intval($typecontract);
    $tipo_contrato = $_POST['tipo_contrato'] ?? '';

    // Procesar duración jornada
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
    }

    // ==================== INSERTAR CONTRATOS PARA CADA TRABAJADOR ====================
    $contratosRegistrados = [];
    $errores = [];

    foreach ($trabajadoresIds as $index => $trabajadorId) {
        try {
            $tra = $c->buscartrabajador($trabajadorId);

            // Generar nombre de documento individual
            $nombreDocIndividual = "Contrato_{$trabajadorId}_{$timestamp}.pdf";
            $rutaArchivoIndividual = "../../uploads/Contratos/{$nombreDocIndividual}";

            // Guardar PDF individual en disco si existe
            if (isset($pdfsIndividuales[$trabajadorId])) {
                $resultadoIndividual = file_put_contents($rutaArchivoIndividual, $pdfsIndividuales[$trabajadorId]);
                if ($resultadoIndividual === false) {
                    error_log("Error al guardar PDF individual para trabajador {$trabajadorId}");
                }
            }

            // SQL INSERT para cada trabajador
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
                $trabajadorId,
                $empresa,
                $centrocosto,
                $tipo_contrato,
                '" . addslashes($cargo) . "',
                $sueldoNumerico,
                '$fechaInicio',
                " . ($fechaTermino ? "'$fechaTermino'" : "NULL") . ",
                '$nombreDocIndividual',
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

            // Debug: guardar SQL para revisión
            error_log("SQL Contrato Masivo: " . $sql);

            $contratoId = $c->query_id($sql);

            if (!$contratoId || $contratoId <= 0) {
                $errorSQL = $c->getLastError();
                error_log("Error MySQL Contrato Masivo: " . $errorSQL);
                $errores[] = "Error al registrar contrato para " . $trabajadoresInfo[$index]['nombre'];
                continue;
            }

            // Insertar horas pactadas
            $c->query("INSERT INTO horaspactadas VALUES(NULL, $horaspac, $contratoId, NOW())");

            // Insertar distribución horaria
            $turnos = ['normal' => 1, 'matutino' => 2, 'tarde' => 3, 'noche' => 4];
            foreach ($turnos as $nombreTurno => $numeroTurno) {
                for ($dia = 1; $dia <= 7; $dia++) {
                    $checkboxId = "dias{$numeroTurno}{$dia}";
                    $horaInicioId = "hora{$numeroTurno}{$dia}";
                    $horaTerminoId = "horat{$numeroTurno}{$dia}";

                    $diaSeleccionado = isset($_POST[$checkboxId]) ? 1 : 0;
                    $horaInicio = isset($_POST[$horaInicioId]) ? $_POST[$horaInicioId] : null;
                    $horaTermino = isset($_POST[$horaTerminoId]) ? $_POST[$horaTerminoId] : null;

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
                    }
                }
            }

            // Insertar estipulaciones
            for ($i = 1; $i <= 13; $i++) {
                $estipulacionKey = "estipulacion{$i}";
                if (isset($_POST[$estipulacionKey]) && !empty(trim($_POST[$estipulacionKey]))) {
                    $contenido = addslashes(trim($_POST[$estipulacionKey]));
                    $sqlEstipulacion = "INSERT INTO contrato_estipulaciones
                        (contrato_id, numero_estipulacion, contenido)
                        VALUES ($contratoId, $i, '$contenido')";
                    $c->query($sqlEstipulacion);
                }
            }

            // Registrar auditoría
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Registró contrato de trabajo masivo para el trabajador " .
                       $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2();
            $c->RegistrarAuditoriaEventos($usuario, $eventos);

            $contratosRegistrados[] = [
                'id' => $contratoId,
                'trabajador' => $trabajadoresInfo[$index]['nombre'],
                'documento' => $nombreDocIndividual
            ];

        } catch (Exception $e) {
            $errores[] = "Error con trabajador " . $trabajadoresInfo[$index]['nombre'] . ": " . $e->getMessage();
            error_log("Error contrato masivo trabajador {$trabajadorId}: " . $e->getMessage());
        }
    }

    // ==================== REGISTRAR LOTE DE CONTRATOS ====================
    // Solo si hay contratos registrados exitosamente
    $loteId = null;
    $nomlote = null;
    $centrocosto = $c->buscarcentrcosto($centrocosto);
    if (count($contratosRegistrados) > 0) {
        $fecha = date('Ymdhis');
        $nomlote = "TRABAJADORES ". $centrocosto->getNombre() . "_" . $fecha;

        // Insertar el lote y obtener ID directamente (evita condición de carrera)
        $loteId = $c->query_id("INSERT INTO lotes VALUES(NULL, '$nomlote', $empresa, NOW())");

        if ($loteId && $loteId > 0) {
            // Recorrer los IDs de contratos y guardarlos en detalle de lotes
            foreach ($contratosRegistrados as $contrato) {
                $contratoId = $contrato['id'];
                $valid = $c->validarloteids($loteId, $contratoId);
                if ($valid == false) {
                    $c->query("INSERT INTO detallelotes VALUES(NULL, $contratoId, $loteId, NOW())");
                }
            }

            // Registrar auditoria del lote
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Registró lote de contratos masivos '$nomlote' con " . count($contratosRegistrados) . " contratos";
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }
    }

    // ==================== LIMPIAR SESIÓN TEMPORAL ====================
    unset($_SESSION['contrato_masivo_preview']);

    // ==================== LIMPIAR LOTE DE TRABAJADORES ====================
    $c->eliminarlote($_SESSION['USER_ID']);

    // ==================== RESPONDER CON ÉXITO ====================
    header('Content-Type: application/json');

    if (count($errores) > 0 && count($contratosRegistrados) == 0) {
        // Todos fallaron
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Error al registrar los contratos',
            'errores' => $errores
        ]);
    } else if (count($errores) > 0) {
        // Algunos fallaron
        echo json_encode([
            'success' => true,
            'partial' => true,
            'contratos_registrados' => count($contratosRegistrados),
            'contratos' => $contratosRegistrados,
            'errores' => $errores,
            'message' => 'Algunos contratos fueron registrados con errores'
        ]);
    } else {
        // Todos exitosos
        echo json_encode([
            'success' => true,
            'contratos_registrados' => count($contratosRegistrados),
            'contratos' => $contratosRegistrados,
            'documento_general' => $nombreDocumento,
            'empresa' => $emp->getRazonSocial(),
            'lote_id' => isset($loteId) ? $loteId : null,
            'lote_nombre' => isset($nomlote) ? $nomlote : null,
            'message' => 'Contratos registrados exitosamente'
        ]);
    }

} catch (Exception $e) {
    // Registrar error en log
    error_log("Error al confirmar contratos masivos: " . $e->getMessage());

    // Responder con error
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
