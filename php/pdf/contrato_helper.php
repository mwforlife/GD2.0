<?php
/**
 * Helper Functions para Procesamiento de Contratos
 * Este archivo contiene funciones auxiliares para validar y procesar
 * los datos del formulario de contratos
 */

class ContratoHelper {
    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }

    /**
     * Captura y valida todos los datos del formulario de contrato
     * @return array Datos procesados del contrato
     */
    public function capturarDatosContrato() {
        $datos = [];

        try {
            // ==================== VALIDACIÓN DE DATOS BÁSICOS ====================
            if (!isset($_POST['idempresa']) || !isset($_POST['idtrabajador']) || !isset($_POST['tipocontratoid'])) {
                throw new Exception("Faltan datos básicos del contrato");
            }

            $datos['idtrabajador'] = $this->validarNumero($_POST['idtrabajador'], 'ID Trabajador');
            $datos['idempresa'] = $this->validarNumero($_POST['idempresa'], 'ID Empresa');
            $datos['tipocontratoid'] = $this->validarNumero($_POST['tipocontratoid'], 'Tipo de Contrato');

            // ==================== INFORMACIÓN DE CELEBRACIÓN ====================
            $datos['categoria_contrato'] = $this->obtenerPost('categoria_contrato');
            $datos['regioncelebracion'] = $this->validarNumero($_POST['regioncelebracion'] ?? 0, 'Región Celebración');
            $datos['comunacelebracion'] = $this->validarNumero($_POST['comunacelebracion'] ?? 0, 'Comuna Celebración');
            $datos['fechacelebracion'] = $this->validarFecha($_POST['fechacelebracion'] ?? '', 'Fecha Celebración');

            // ==================== INFORMACIÓN EMPRESA ====================
            $datos['representante_legal'] = $this->validarNumero($_POST['representante_legal'] ?? 0, 'Representante Legal');
            $datos['codigoactividadid'] = $this->validarNumero($_POST['codigoactividadid'] ?? 0, 'Código Actividad');
            $datos['empresaregion'] = $this->validarNumero($_POST['empresaregion'] ?? 0, 'Empresa Región');
            $datos['empresacomuna'] = $this->validarNumero($_POST['empresacomuna'] ?? 0, 'Empresa Comuna');
            $datos['calle'] = $this->obtenerPost('calle');
            $datos['numero'] = $this->obtenerPost('numero');
            $datos['departamento'] = $this->obtenerPost('departamento');

            // ==================== INFORMACIÓN TRABAJADOR ====================
            $datos['nacionalidad'] = $this->validarNumero($_POST['nacionalidad'] ?? 0, 'Nacionalidad');
            $datos['sexo'] = $this->obtenerPost('sexo');
            $datos['correotrabajador'] = $this->obtenerPost('correotrabajador');
            $datos['telefonotrabajador'] = $this->obtenerPost('telefonotrabajador');
            $datos['trabajadorregion'] = $this->obtenerPost('trabajadorregion');
            $datos['trabajadorcomuna'] = $this->obtenerPost('trabajadorcomuna');
            $datos['calletrabajador'] = $this->obtenerPost('calletrabajador');
            $datos['numerotrabajador'] = $this->obtenerPost('numerotrabajador');
            $datos['departamentotrabajador'] = $this->obtenerPost('departamentotrabajador');
            $datos['discapacidad'] = isset($_POST['discapacidad']) ? 1 : 0;
            $datos['pensionado'] = isset($_POST['pensionado']) ? 1 : 0;

            // ==================== CARGO Y LUGAR DE TRABAJO ====================
            $datos['centrocosto'] = $this->validarNumero($_POST['centrocosto'] ?? 0, 'Centro de Costo');
            $datos['Charge'] = $this->obtenerPost('Charge'); // Puede ser texto o número
            $datos['ChargeDescripcion'] = $this->obtenerPost('ChargeDescripcion');
            $datos['regionespecifica'] = $this->validarNumero($_POST['regionespecifica'] ?? 0, 'Región Específica');
            $datos['comunaespecifica'] = $this->validarNumero($_POST['comunaespecifica'] ?? 0, 'Comuna Específica');
            $datos['calleespecifica'] = $this->obtenerPost('calleespecifica');
            $datos['numeroespecifica'] = $this->obtenerPost('numeroespecifica');
            $datos['departamentoespecifica'] = $this->obtenerPost('departamentoespecifica');

            // ==================== TERRITORIO Y ZONAS ====================
            $datos['territoriozona'] = isset($_POST['territoriozona']) ? 1 : 0;
            $datos['zonaregion'] = $this->obtenerPost('zonaregion');
            $datos['zonaprovincia'] = $this->obtenerPost('zonaprovincia');
            $datos['zonacomuna'] = $this->obtenerPost('zonacomuna');

            // ==================== SUBCONTRATACIÓN Y TRANSITORIOS ====================
            $datos['subcontratacionval'] = isset($_POST['subcontratacionval']) && $_POST['subcontratacionval'] == 1 ? 1 : 0;
            $datos['subcontratacionrut'] = $this->obtenerPost('subcontratacionrut');
            $datos['subcontratacionrazonsocial'] = $this->obtenerPost('subcontratacionrazonsocial');
            $datos['transitoriosval'] = isset($_POST['transitoriosval']) && $_POST['transitoriosval'] == 1 ? 1 : 0;
            $datos['transitoriosrut'] = $this->obtenerPost('transitoriosrut');
            $datos['transitoriosrazonsocial'] = $this->obtenerPost('transitoriosrazonsocial');

            // ==================== REMUNERACIÓN ====================
            $datos['tiposueldo'] = $this->validarNumero($_POST['tiposueldo'] ?? 0, 'Tipo Sueldo');
            $datos['sueldo'] = $this->obtenerPost('sueldo');
            $datos['asignacion'] = $this->obtenerPost('asignacion');

            // ==================== HABERES IMPONIBLES ====================
            $datos['tipohaber'] = $this->obtenerPost('tipohaber');
            $datos['montohaber'] = $this->obtenerPost('montohaber');
            $datos['periodohaber'] = $this->obtenerPost('periodohaber');
            $datos['detallerenumeracion'] = $this->obtenerPost('detallerenumeracion');

            // ==================== HABERES NO IMPONIBLES ====================
            $datos['tipohaberno'] = $this->obtenerPost('tipohaberno');
            $datos['montohaberno'] = $this->obtenerPost('montohaberno');
            $datos['periodohaberno'] = $this->obtenerPost('periodohaberno');
            $datos['detallerenumeracionno'] = $this->obtenerPost('detallerenumeracionno');

            // ==================== HABERES IMPONIBLES NO TRIBUTABLES ====================
            $datos['tipohabernotributable'] = $this->obtenerPost('tipohabernotributable');
            $datos['montohabernotributable'] = $this->obtenerPost('montohabernotributable');
            $datos['periodohabernotributable'] = $this->obtenerPost('periodohabernotributable');
            $datos['detallerenumeracionnotributable'] = $this->obtenerPost('detallerenumeracionnotributable');

            // ==================== HABERES NO IMPONIBLES NO TRIBUTABLES ====================
            $datos['tipohabernonotributable'] = $this->obtenerPost('tipohabernonotributable');
            $datos['montohabernonotributable'] = $this->obtenerPost('montohabernonotributable');
            $datos['periodohabernonotributable'] = $this->obtenerPost('periodohabernonotributable');
            $datos['detallerenumeracionnonotributable'] = $this->obtenerPost('detallerenumeracionnonotributable');

            // ==================== FORMA DE PAGO ====================
            $datos['formapago'] = $this->obtenerPost('formapago');
            $datos['periodopagogra'] = $this->obtenerPost('periodopagogra');
            $datos['detallerenumeraciongra'] = $this->obtenerPost('detallerenumeraciongra');
            $datos['periodopagot'] = $this->obtenerPost('periodopagot');
            $datos['fechapagot'] = $this->obtenerPost('fechapagot');
            $datos['formapagot'] = $this->obtenerPost('formapagot');
            $datos['banco'] = $this->obtenerPost('banco');
            $datos['tipocuenta'] = $this->obtenerPost('tipocuenta');
            $datos['numerocuenta'] = $this->obtenerPost('numerocuenta');
            $datos['anticipot'] = $this->obtenerPost('anticipot');

            // ==================== PREVISIÓN ====================
            $datos['afp'] = $this->validarNumero($_POST['afp'] ?? 0, 'AFP');
            $datos['salud'] = $this->validarNumero($_POST['salud'] ?? 0, 'Salud');

            // ==================== PACTOS ADICIONALES ====================
            $datos['badi'] = isset($_POST['badi']) && $_POST['badi'] == 1 ? 1 : 0;
            $datos['otrter'] = $this->obtenerPost('otrter');

            // ==================== JORNADA LABORAL ====================
            $datos['jornadaesc'] = isset($_POST['jornadaesc']) && $_POST['jornadaesc'] == 1 ? 1 : 0;
            $datos['exluido'] = isset($_POST['exluido']) && $_POST['exluido'] == 1 ? 1 : 0;
            $datos['noresolucion'] = $this->obtenerPost('noresolucion');
            $datos['exfech'] = $this->obtenerPost('exfech');
            $datos['tipojornada'] = $this->obtenerPost('tipojornada');
            $datos['incluye'] = isset($_POST['incluye']) && $_POST['incluye'] == 1 ? 1 : 0;
            $datos['dias'] = $this->obtenerPost('dias');
            $datos['duracionjor'] = $this->obtenerPost('duracionjor');
            $datos['diasf'] = $this->obtenerPost('diasf');
            $datos['horarioturno'] = $this->obtenerPost('horarioturno');
            $datos['colacion'] = $this->obtenerPost('colacion');
            $datos['rotativo'] = $this->obtenerPost('rotativo');
            $datos['colanoipu'] = $this->obtenerPost('colanoipu');
            $datos['colacionimp'] = $this->obtenerPost('colacionimp');

            // ==================== DISTRIBUCIÓN HORARIA ====================
            $datos['distribucion_horaria'] = $this->capturarDistribucionHoraria();

            // ==================== ESTIPULACIONES ====================
            $datos['estipulaciones'] = $this->capturarEstipulaciones();

            // ==================== FECHAS DE CONTRATO ====================
            $datos['fecha_inicio'] = $this->validarFecha($_POST['fecha_inicio'] ?? '', 'Fecha Inicio');
            $datos['fecha_termino'] = $this->obtenerPost('fecha_termino');

            return $datos;

        } catch (Exception $e) {
            throw new Exception("Error al capturar datos: " . $e->getMessage());
        }
    }

    /**
     * Captura la distribución horaria de todos los turnos
     */
    private function capturarDistribucionHoraria() {
        $distribucion = [];
        $turnos = ['normal' => 1, 'matutino' => 2, 'tarde' => 3, 'noche' => 4];

        foreach ($turnos as $nombre => $numero) {
            for ($dia = 1; $dia <= 7; $dia++) {
                $checkbox_id = "dias{$numero}{$dia}";
                $hora_inicio_id = "hora{$numero}{$dia}";
                $hora_termino_id = "horat{$numero}{$dia}";

                $distribucion[] = [
                    'turno' => $nombre,
                    'dia' => $dia,
                    'seleccionado' => isset($_POST[$checkbox_id]) ? 1 : 0,
                    'hora_inicio' => $this->obtenerPost($hora_inicio_id),
                    'hora_termino' => $this->obtenerPost($hora_termino_id)
                ];
            }
        }

        return $distribucion;
    }

    /**
     * Captura las estipulaciones adicionales
     */
    private function capturarEstipulaciones() {
        $estipulaciones = [];

        for ($i = 1; $i <= 13; $i++) {
            $contenido = $this->obtenerPost("estipulacion{$i}");
            if (!empty($contenido)) {
                $estipulaciones[] = [
                    'numero' => $i,
                    'contenido' => $contenido
                ];
            }
        }

        return $estipulaciones;
    }

    /**
     * Obtiene un valor POST de forma segura
     */
    private function obtenerPost($key, $default = '') {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    /**
     * Valida que un valor sea numérico
     */
    private function validarNumero($valor, $campo) {
        if (!is_numeric($valor)) {
            throw new Exception("El campo {$campo} debe ser numérico");
        }
        return intval($valor);
    }

    /**
     * Valida una fecha
     */
    private function validarFecha($fecha, $campo) {
        if (empty($fecha)) {
            return null;
        }

        $timestamp = strtotime($fecha);
        if ($timestamp === false) {
            throw new Exception("El campo {$campo} no es una fecha válida");
        }

        return date('Y-m-d', $timestamp);
    }

    /**
     * Prepara el SQL INSERT para el contrato principal
     */
    public function prepararSQLInsertContrato($datos) {
        $sql = "INSERT INTO contratos (
            trabajador, empresa, centrocosto, tipocontrato, cargo, sueldo,
            fechainicio, fechatermino, documento, estado,
            formato_contrato, categoria_contrato, fecha_suscripcion,
            region_celebracion, comuna_celebracion, fecha_celebracion,
            centro_costo, cargo_descripcion,
            region_especifica, comuna_especifica, calle_especifica,
            numero_especifico, dept_oficina_especifico,
            territorio_zona,
            subcontratacion, subcontratacion_rut, subcontratacion_razon_social,
            servicios_transitorios, transitorios_rut, transitorios_razon_social,
            tipo_sueldo, sueldo_base, asignacion_zona,
            haber_imponible_tipo, haber_imponible_monto, haber_imponible_periodo, haber_imponible_detalle,
            haber_no_imponible_tipo, haber_no_imponible_monto, haber_no_imponible_periodo, haber_no_imponible_detalle,
            haber_imponible_notributable_tipo, haber_imponible_notributable_monto,
            haber_imponible_notributable_periodo, haber_imponible_notributable_detalle,
            haber_no_imponible_notributable_tipo, haber_no_imponible_notributable_monto,
            haber_no_imponible_notributable_periodo, haber_no_imponible_notributable_detalle,
            forma_pago, periodo_pago_gratificacion, detalle_gratificacion,
            periodo_pago_trabajador, fecha_pago_trabajador, forma_pago_trabajador,
            banco_id, tipo_cuenta_id, numero_cuenta, anticipo,
            afp_id, salud_id,
            pacto_badi, otros_terminos,
            jornada_excepcional, jornada_excluida, no_resolucion, fecha_excepcion,
            tipo_jornada, incluye_domingos, dias_trabajo, duracion_jornada,
            dias_trabajo_semanal, horario_turno, colacion, rotativo,
            colacion_imputable, colacion_imputable_tiempo,
            register_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        return $sql;
    }

    /**
     * Prepara los parámetros para el INSERT
     */
    public function prepararParametrosInsert($datos, $nombre_documento, $tipo_contrato, $sueldo_numerico) {
        return [
            $datos['idtrabajador'],
            $datos['idempresa'],
            $datos['centrocosto'],
            $tipo_contrato,
            $datos['Charge'],
            $sueldo_numerico,
            $datos['fecha_inicio'],
            $datos['fecha_termino'],
            $nombre_documento,
            1, // estado
            $datos['tipocontratoid'],
            $datos['categoria_contrato'],
            $datos['fechacelebracion'],
            $datos['regioncelebracion'],
            $datos['comunacelebracion'],
            $datos['fechacelebracion'],
            $datos['centrocosto'],
            $datos['ChargeDescripcion'],
            $datos['regionespecifica'],
            $datos['comunaespecifica'],
            $datos['calleespecifica'],
            $datos['numeroespecifica'],
            $datos['departamentoespecifica'],
            $datos['territoriozona'],
            $datos['subcontratacionval'],
            $datos['subcontratacionrut'],
            $datos['subcontratacionrazonsocial'],
            $datos['transitoriosval'],
            $datos['transitoriosrut'],
            $datos['transitoriosrazonsocial'],
            $datos['tiposueldo'],
            $sueldo_numerico,
            $datos['asignacion'],
            $datos['tipohaber'],
            $datos['montohaber'],
            $datos['periodohaber'],
            $datos['detallerenumeracion'],
            $datos['tipohaberno'],
            $datos['montohaberno'],
            $datos['periodohaberno'],
            $datos['detallerenumeracionno'],
            $datos['tipohabernotributable'],
            $datos['montohabernotributable'],
            $datos['periodohabernotributable'],
            $datos['detallerenumeracionnotributable'],
            $datos['tipohabernonotributable'],
            $datos['montohabernonotributable'],
            $datos['periodohabernonotributable'],
            $datos['detallerenumeracionnonotributable'],
            $datos['formapago'],
            $datos['periodopagogra'],
            $datos['detallerenumeraciongra'],
            $datos['periodopagot'],
            $datos['fechapagot'],
            $datos['formapagot'],
            $datos['banco'],
            $datos['tipocuenta'],
            $datos['numerocuenta'],
            $datos['anticipot'],
            $datos['afp'],
            $datos['salud'],
            $datos['badi'],
            $datos['otrter'],
            $datos['jornadaesc'],
            $datos['exluido'],
            $datos['noresolucion'],
            $datos['exfech'],
            $datos['tipojornada'],
            $datos['incluye'],
            $datos['dias'],
            $datos['duracionjor'],
            $datos['diasf'],
            $datos['horarioturno'],
            $datos['colacion'],
            $datos['rotativo'],
            $datos['colanoipu'],
            $datos['colacionimp']
        ];
    }
}
