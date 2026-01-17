<?php
class Contrato
{
    private $id;
    private $trabajador;
    private $empresa;
    private $centrocosto;
    private $tipocontrato;
    private $cargo;
    private $sueldo;
    private $fechainicio;
    private $fechatermino;
    private $documento;
    private $estado;
    private $fecharegistro;

    // Nuevos campos básicos del contrato
    private $formato_contrato;
    private $categoria_contrato;
    private $fecha_suscripcion;
    private $region_celebracion;
    private $comuna_celebracion;
    private $fecha_celebracion;

    // Información del cargo
    private $centro_costo;
    private $cargo_descripcion;
    private $region_especifica;
    private $comuna_especifica;
    private $calle_especifica;
    private $numero_especifico;
    private $dept_oficina_especifico;
    private $territorio_zona;

    // Subcontratación y servicios transitorios
    private $subcontratacion;
    private $subcontratacion_rut;
    private $subcontratacion_razon_social;
    private $servicios_transitorios;
    private $transitorios_rut;
    private $transitorios_razon_social;

    // Remuneración
    private $tipo_sueldo;
    private $sueldo_base;
    private $asignacion_zona;

    // Forma de pago
    private $forma_pago;
    private $periodo_pago_gratificacion;
    private $detalle_gratificacion;
    private $periodo_pago_trabajador;
    private $fecha_pago_trabajador;
    private $forma_pago_trabajador;
    private $banco_id;
    private $tipo_cuenta_id;
    private $numero_cuenta;
    private $anticipo;

    // Previsión
    private $afp_id;
    private $salud_id;

    // Pactos adicionales
    private $pacto_badi;
    private $otros_terminos;

    // Jornada laboral
    private $jornada_excepcional;
    private $jornada_excluida;
    private $no_resolucion;
    private $fecha_excepcion;
    private $tipo_jornada;
    private $incluye_domingos;
    private $dias_trabajo;
    private $duracion_jornada;
    private $dias_trabajo_semanal;
    private $horario_turno;
    private $colacion;
    private $rotativo;
    private $colacion_imputable;
    private $colacion_imputable_tiempo;

    // Constructor básico (mantiene compatibilidad con código existente)
    public function __construct($id, $trabajador, $empresa, $centrocosto, $tipocontrato, $cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $fecharegistro)
    {
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->centrocosto = $centrocosto;
        $this->tipocontrato = $tipocontrato;
        $this->cargo = $cargo;
        $this->sueldo = $sueldo;
        $this->fechainicio = $fechainicio;
        $this->fechatermino = $fechatermino;
        $this->documento = $documento;
        $this->estado = $estado;
        $this->fecharegistro = $fecharegistro;
    }

    // Método estático para crear desde array (para nuevos campos)
    public static function fromArray($data)
    {
        $contrato = new self(
            $data['id'] ?? null,
            $data['trabajador'] ?? null,
            $data['empresa'] ?? null,
            $data['centrocosto'] ?? null,
            $data['tipocontrato'] ?? null,
            $data['cargo'] ?? null,
            $data['sueldo'] ?? null,
            $data['fechainicio'] ?? null,
            $data['fechatermino'] ?? null,
            $data['documento'] ?? null,
            $data['estado'] ?? null,
            $data['register_at'] ?? null
        );

        // Asignar nuevos campos si existen
        $contrato->formato_contrato = $data['formato_contrato'] ?? null;
        $contrato->categoria_contrato = $data['categoria_contrato'] ?? null;
        $contrato->fecha_suscripcion = $data['fecha_suscripcion'] ?? null;
        $contrato->region_celebracion = $data['region_celebracion'] ?? null;
        $contrato->comuna_celebracion = $data['comuna_celebracion'] ?? null;
        $contrato->fecha_celebracion = $data['fecha_celebracion'] ?? null;
        $contrato->centro_costo = $data['centro_costo'] ?? null;
        $contrato->cargo_descripcion = $data['cargo_descripcion'] ?? null;
        $contrato->region_especifica = $data['region_especifica'] ?? null;
        $contrato->comuna_especifica = $data['comuna_especifica'] ?? null;
        $contrato->calle_especifica = $data['calle_especifica'] ?? null;
        $contrato->numero_especifico = $data['numero_especifico'] ?? null;
        $contrato->dept_oficina_especifico = $data['dept_oficina_especifico'] ?? null;
        $contrato->territorio_zona = $data['territorio_zona'] ?? null;
        $contrato->subcontratacion = $data['subcontratacion'] ?? null;
        $contrato->subcontratacion_rut = $data['subcontratacion_rut'] ?? null;
        $contrato->subcontratacion_razon_social = $data['subcontratacion_razon_social'] ?? null;
        $contrato->servicios_transitorios = $data['servicios_transitorios'] ?? null;
        $contrato->transitorios_rut = $data['transitorios_rut'] ?? null;
        $contrato->transitorios_razon_social = $data['transitorios_razon_social'] ?? null;
        $contrato->tipo_sueldo = $data['tipo_sueldo'] ?? null;
        $contrato->sueldo_base = $data['sueldo_base'] ?? null;
        $contrato->asignacion_zona = $data['asignacion_zona'] ?? null;
        $contrato->forma_pago = $data['forma_pago'] ?? null;
        $contrato->periodo_pago_gratificacion = $data['periodo_pago_gratificacion'] ?? null;
        $contrato->detalle_gratificacion = $data['detalle_gratificacion'] ?? null;
        $contrato->periodo_pago_trabajador = $data['periodo_pago_trabajador'] ?? null;
        $contrato->fecha_pago_trabajador = $data['fecha_pago_trabajador'] ?? null;
        $contrato->forma_pago_trabajador = $data['forma_pago_trabajador'] ?? null;
        $contrato->banco_id = $data['banco_id'] ?? null;
        $contrato->tipo_cuenta_id = $data['tipo_cuenta_id'] ?? null;
        $contrato->numero_cuenta = $data['numero_cuenta'] ?? null;
        $contrato->anticipo = $data['anticipo'] ?? null;
        $contrato->afp_id = $data['afp_id'] ?? null;
        $contrato->salud_id = $data['salud_id'] ?? null;
        $contrato->pacto_badi = $data['pacto_badi'] ?? null;
        $contrato->otros_terminos = $data['otros_terminos'] ?? null;
        $contrato->jornada_excepcional = $data['jornada_excepcional'] ?? null;
        $contrato->jornada_excluida = $data['jornada_excluida'] ?? null;
        $contrato->no_resolucion = $data['no_resolucion'] ?? null;
        $contrato->fecha_excepcion = $data['fecha_excepcion'] ?? null;
        $contrato->tipo_jornada = $data['tipo_jornada'] ?? null;
        $contrato->incluye_domingos = $data['incluye_domingos'] ?? null;
        $contrato->dias_trabajo = $data['dias_trabajo'] ?? null;
        $contrato->duracion_jornada = $data['duracion_jornada'] ?? null;
        $contrato->dias_trabajo_semanal = $data['dias_trabajo_semanal'] ?? null;
        $contrato->horario_turno = $data['horario_turno'] ?? null;
        $contrato->colacion = $data['colacion'] ?? null;
        $contrato->rotativo = $data['rotativo'] ?? null;
        $contrato->colacion_imputable = $data['colacion_imputable'] ?? null;
        $contrato->colacion_imputable_tiempo = $data['colacion_imputable_tiempo'] ?? null;

        return $contrato;
    }

    // Getters originales
    public function getId()
    {
        return $this->id;
    }

    public function getTrabajador()
    {
        return $this->trabajador;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getCentrocosto()
    {
        return $this->centrocosto;
    }

    public function getTipocontrato()
    {
        return $this->tipocontrato;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function getSueldo()
    {
        return $this->sueldo;
    }

    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    public function getFechatermino()
    {
        return $this->fechatermino;
    }

    public function setFechatermino($fechatermino){
        $this->fechatermino = $fechatermino;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    // Nuevos getters - Campos básicos del contrato
    public function getFormatoContrato()
    {
        return $this->formato_contrato;
    }

    public function getCategoriaContrato()
    {
        return $this->categoria_contrato;
    }

    public function getFechaSuscripcion()
    {
        return $this->fecha_suscripcion;
    }

    public function getRegionCelebracion()
    {
        return $this->region_celebracion;
    }

    public function getComunaCelebracion()
    {
        return $this->comuna_celebracion;
    }

    public function getFechaCelebracion()
    {
        return $this->fecha_celebracion;
    }

    // Getters - Información del cargo
    public function getCargoDescripcion()
    {
        return $this->cargo_descripcion;
    }

    public function getRegionEspecifica()
    {
        return $this->region_especifica;
    }

    public function getComunaEspecifica()
    {
        return $this->comuna_especifica;
    }

    public function getCalleEspecifica()
    {
        return $this->calle_especifica;
    }

    public function getNumeroEspecifico()
    {
        return $this->numero_especifico;
    }

    public function getDeptOficinaEspecifico()
    {
        return $this->dept_oficina_especifico;
    }

    public function getTerritorioZona()
    {
        return $this->territorio_zona;
    }

    // Getters - Subcontratación y servicios transitorios
    public function getSubcontratacion()
    {
        return $this->subcontratacion;
    }

    public function getSubcontratacionRut()
    {
        return $this->subcontratacion_rut;
    }

    public function getSubcontratacionRazonSocial()
    {
        return $this->subcontratacion_razon_social;
    }

    public function getServiciosTransitorios()
    {
        return $this->servicios_transitorios;
    }

    public function getTransitoriosRut()
    {
        return $this->transitorios_rut;
    }

    public function getTransitoriosRazonSocial()
    {
        return $this->transitorios_razon_social;
    }

    // Getters - Remuneración
    public function getTipoSueldo()
    {
        return $this->tipo_sueldo;
    }

    public function getSueldoBase()
    {
        return $this->sueldo_base;
    }

    public function getAsignacionZona()
    {
        return $this->asignacion_zona;
    }

    // Getters - Forma de pago
    public function getFormaPago()
    {
        return $this->forma_pago;
    }

    public function getPeriodoPagoGratificacion()
    {
        return $this->periodo_pago_gratificacion;
    }

    public function getDetalleGratificacion()
    {
        return $this->detalle_gratificacion;
    }

    public function getPeriodoPagoTrabajador()
    {
        return $this->periodo_pago_trabajador;
    }

    public function getFechaPagoTrabajador()
    {
        return $this->fecha_pago_trabajador;
    }

    public function getFormaPagoTrabajador()
    {
        return $this->forma_pago_trabajador;
    }

    public function getBancoId()
    {
        return $this->banco_id;
    }

    public function getTipoCuentaId()
    {
        return $this->tipo_cuenta_id;
    }

    public function getNumeroCuenta()
    {
        return $this->numero_cuenta;
    }

    public function getAnticipo()
    {
        return $this->anticipo;
    }

    // Getters - Previsión
    public function getAfpId()
    {
        return $this->afp_id;
    }

    public function getSaludId()
    {
        return $this->salud_id;
    }

    // Getters - Pactos adicionales
    public function getPactoBadi()
    {
        return $this->pacto_badi;
    }

    public function getOtrosTerminos()
    {
        return $this->otros_terminos;
    }

    // Getters - Jornada laboral
    public function getJornadaExcepcional()
    {
        return $this->jornada_excepcional;
    }

    public function getJornadaExcluida()
    {
        return $this->jornada_excluida;
    }

    public function getNoResolucion()
    {
        return $this->no_resolucion;
    }

    public function getFechaExcepcion()
    {
        return $this->fecha_excepcion;
    }

    public function getTipoJornada()
    {
        return $this->tipo_jornada;
    }

    public function getIncluyeDomingos()
    {
        return $this->incluye_domingos;
    }

    public function getDiasTrabajo()
    {
        return $this->dias_trabajo;
    }

    public function getDuracionJornada()
    {
        return $this->duracion_jornada;
    }

    public function getDiasTrabajoSemanal()
    {
        return $this->dias_trabajo_semanal;
    }

    public function getHorarioTurno()
    {
        return $this->horario_turno;
    }

    public function getColacion()
    {
        return $this->colacion;
    }

    public function getRotativo()
    {
        return $this->rotativo;
    }

    public function getColacionImputable()
    {
        return $this->colacion_imputable;
    }

    public function getColacionImputableTiempo()
    {
        return $this->colacion_imputable_tiempo;
    }

    // Setters para nuevos campos
    public function setFormatoContrato($formato_contrato)
    {
        $this->formato_contrato = $formato_contrato;
    }

    public function setCategoriaContrato($categoria_contrato)
    {
        $this->categoria_contrato = $categoria_contrato;
    }

    public function setFechaSuscripcion($fecha_suscripcion)
    {
        $this->fecha_suscripcion = $fecha_suscripcion;
    }

    public function setRegionCelebracion($region_celebracion)
    {
        $this->region_celebracion = $region_celebracion;
    }

    public function setComunaCelebracion($comuna_celebracion)
    {
        $this->comuna_celebracion = $comuna_celebracion;
    }

    public function setFechaCelebracion($fecha_celebracion)
    {
        $this->fecha_celebracion = $fecha_celebracion;
    }

    public function setCentroCosto($centro_costo)
    {
        $this->centro_costo = $centro_costo;
    }

    public function setCargoDescripcion($cargo_descripcion)
    {
        $this->cargo_descripcion = $cargo_descripcion;
    }

    public function setRegionEspecifica($region_especifica)
    {
        $this->region_especifica = $region_especifica;
    }

    public function setComunaEspecifica($comuna_especifica)
    {
        $this->comuna_especifica = $comuna_especifica;
    }

    public function setCalleEspecifica($calle_especifica)
    {
        $this->calle_especifica = $calle_especifica;
    }

    public function setNumeroEspecifico($numero_especifico)
    {
        $this->numero_especifico = $numero_especifico;
    }

    public function setDeptOficinaEspecifico($dept_oficina_especifico)
    {
        $this->dept_oficina_especifico = $dept_oficina_especifico;
    }

    public function setTerritorioZona($territorio_zona)
    {
        $this->territorio_zona = $territorio_zona;
    }

    public function setSubcontratacion($subcontratacion)
    {
        $this->subcontratacion = $subcontratacion;
    }

    public function setSubcontratacionRut($subcontratacion_rut)
    {
        $this->subcontratacion_rut = $subcontratacion_rut;
    }

    public function setSubcontratacionRazonSocial($subcontratacion_razon_social)
    {
        $this->subcontratacion_razon_social = $subcontratacion_razon_social;
    }

    public function setServiciosTransitorios($servicios_transitorios)
    {
        $this->servicios_transitorios = $servicios_transitorios;
    }

    public function setTransitoriosRut($transitorios_rut)
    {
        $this->transitorios_rut = $transitorios_rut;
    }

    public function setTransitoriosRazonSocial($transitorios_razon_social)
    {
        $this->transitorios_razon_social = $transitorios_razon_social;
    }

    public function setTipoSueldo($tipo_sueldo)
    {
        $this->tipo_sueldo = $tipo_sueldo;
    }

    public function setSueldoBase($sueldo_base)
    {
        $this->sueldo_base = $sueldo_base;
    }

    public function setAsignacionZona($asignacion_zona)
    {
        $this->asignacion_zona = $asignacion_zona;
    }

    public function setFormaPago($forma_pago)
    {
        $this->forma_pago = $forma_pago;
    }

    public function setPeriodoPagoGratificacion($periodo_pago_gratificacion)
    {
        $this->periodo_pago_gratificacion = $periodo_pago_gratificacion;
    }

    public function setDetalleGratificacion($detalle_gratificacion)
    {
        $this->detalle_gratificacion = $detalle_gratificacion;
    }

    public function setPeriodoPagoTrabajador($periodo_pago_trabajador)
    {
        $this->periodo_pago_trabajador = $periodo_pago_trabajador;
    }

    public function setFechaPagoTrabajador($fecha_pago_trabajador)
    {
        $this->fecha_pago_trabajador = $fecha_pago_trabajador;
    }

    public function setFormaPagoTrabajador($forma_pago_trabajador)
    {
        $this->forma_pago_trabajador = $forma_pago_trabajador;
    }

    public function setBancoId($banco_id)
    {
        $this->banco_id = $banco_id;
    }

    public function setTipoCuentaId($tipo_cuenta_id)
    {
        $this->tipo_cuenta_id = $tipo_cuenta_id;
    }

    public function setNumeroCuenta($numero_cuenta)
    {
        $this->numero_cuenta = $numero_cuenta;
    }

    public function setAnticipo($anticipo)
    {
        $this->anticipo = $anticipo;
    }

    public function setAfpId($afp_id)
    {
        $this->afp_id = $afp_id;
    }

    public function setSaludId($salud_id)
    {
        $this->salud_id = $salud_id;
    }

    public function setPactoBadi($pacto_badi)
    {
        $this->pacto_badi = $pacto_badi;
    }

    public function setOtrosTerminos($otros_terminos)
    {
        $this->otros_terminos = $otros_terminos;
    }

    public function setJornadaExcepcional($jornada_excepcional)
    {
        $this->jornada_excepcional = $jornada_excepcional;
    }

    public function setJornadaExcluida($jornada_excluida)
    {
        $this->jornada_excluida = $jornada_excluida;
    }

    public function setNoResolucion($no_resolucion)
    {
        $this->no_resolucion = $no_resolucion;
    }

    public function setFechaExcepcion($fecha_excepcion)
    {
        $this->fecha_excepcion = $fecha_excepcion;
    }

    public function setTipoJornada($tipo_jornada)
    {
        $this->tipo_jornada = $tipo_jornada;
    }

    public function setIncluyeDomingos($incluye_domingos)
    {
        $this->incluye_domingos = $incluye_domingos;
    }

    public function setDiasTrabajo($dias_trabajo)
    {
        $this->dias_trabajo = $dias_trabajo;
    }

    public function setDuracionJornada($duracion_jornada)
    {
        $this->duracion_jornada = $duracion_jornada;
    }

    public function setDiasTrabajoSemanal($dias_trabajo_semanal)
    {
        $this->dias_trabajo_semanal = $dias_trabajo_semanal;
    }

    public function setHorarioTurno($horario_turno)
    {
        $this->horario_turno = $horario_turno;
    }

    public function setColacion($colacion)
    {
        $this->colacion = $colacion;
    }

    public function setRotativo($rotativo)
    {
        $this->rotativo = $rotativo;
    }

    public function setColacionImputable($colacion_imputable)
    {
        $this->colacion_imputable = $colacion_imputable;
    }

    public function setColacionImputableTiempo($colacion_imputable_tiempo)
    {
        $this->colacion_imputable_tiempo = $colacion_imputable_tiempo;
    }

    // Método para convertir a array
    public function toArray()
    {
        return [
            'id' => $this->id,
            'trabajador' => $this->trabajador,
            'empresa' => $this->empresa,
            'centrocosto' => $this->centrocosto,
            'tipocontrato' => $this->tipocontrato,
            'cargo' => $this->cargo,
            'sueldo' => $this->sueldo,
            'fechainicio' => $this->fechainicio,
            'fechatermino' => $this->fechatermino,
            'documento' => $this->documento,
            'estado' => $this->estado,
            'fecharegistro' => $this->fecharegistro,
            'formato_contrato' => $this->formato_contrato,
            'categoria_contrato' => $this->categoria_contrato,
            'fecha_suscripcion' => $this->fecha_suscripcion,
            'region_celebracion' => $this->region_celebracion,
            'comuna_celebracion' => $this->comuna_celebracion,
            'fecha_celebracion' => $this->fecha_celebracion,
            'centro_costo' => $this->centro_costo,
            'cargo_descripcion' => $this->cargo_descripcion,
            'region_especifica' => $this->region_especifica,
            'comuna_especifica' => $this->comuna_especifica,
            'calle_especifica' => $this->calle_especifica,
            'numero_especifico' => $this->numero_especifico,
            'dept_oficina_especifico' => $this->dept_oficina_especifico,
            'territorio_zona' => $this->territorio_zona,
            'subcontratacion' => $this->subcontratacion,
            'subcontratacion_rut' => $this->subcontratacion_rut,
            'subcontratacion_razon_social' => $this->subcontratacion_razon_social,
            'servicios_transitorios' => $this->servicios_transitorios,
            'transitorios_rut' => $this->transitorios_rut,
            'transitorios_razon_social' => $this->transitorios_razon_social,
            'tipo_sueldo' => $this->tipo_sueldo,
            'sueldo_base' => $this->sueldo_base,
            'asignacion_zona' => $this->asignacion_zona,
            'forma_pago' => $this->forma_pago,
            'periodo_pago_gratificacion' => $this->periodo_pago_gratificacion,
            'detalle_gratificacion' => $this->detalle_gratificacion,
            'periodo_pago_trabajador' => $this->periodo_pago_trabajador,
            'fecha_pago_trabajador' => $this->fecha_pago_trabajador,
            'forma_pago_trabajador' => $this->forma_pago_trabajador,
            'banco_id' => $this->banco_id,
            'tipo_cuenta_id' => $this->tipo_cuenta_id,
            'numero_cuenta' => $this->numero_cuenta,
            'anticipo' => $this->anticipo,
            'afp_id' => $this->afp_id,
            'salud_id' => $this->salud_id,
            'pacto_badi' => $this->pacto_badi,
            'otros_terminos' => $this->otros_terminos,
            'jornada_excepcional' => $this->jornada_excepcional,
            'jornada_excluida' => $this->jornada_excluida,
            'no_resolucion' => $this->no_resolucion,
            'fecha_excepcion' => $this->fecha_excepcion,
            'tipo_jornada' => $this->tipo_jornada,
            'incluye_domingos' => $this->incluye_domingos,
            'dias_trabajo' => $this->dias_trabajo,
            'duracion_jornada' => $this->duracion_jornada,
            'dias_trabajo_semanal' => $this->dias_trabajo_semanal,
            'horario_turno' => $this->horario_turno,
            'colacion' => $this->colacion,
            'rotativo' => $this->rotativo,
            'colacion_imputable' => $this->colacion_imputable,
            'colacion_imputable_tiempo' => $this->colacion_imputable_tiempo
        ];
    }
}
