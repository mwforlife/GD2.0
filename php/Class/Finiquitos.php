<?php
class Finiquito{
    private $id;
    private $contrato;
    private $tipodocumento;
    private $fechafiniquito;
    private $fechainicio;
    private $fechatermino;
    private $causal;
    private $trabajador;
    private $empresa;
    private $fecha;

    public function __construct($id, $contrato, $tipodocumento, $fechafiniquito, $fechainicio, $fechatermino, $causal, $trabajador, $empresa, $fecha) {
        $this->id = $id;
        $this->contrato = $contrato;
        $this->tipodocumento = $tipodocumento;
        $this->fechafiniquito = $fechafiniquito;
        $this->fechainicio = $fechainicio;
        $this->fechatermino = $fechatermino;
        $this->causal = $causal;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->fecha = $fecha;
    }

    public function getId() {
        return $this->id;
    }

    public function getContrato() {
        return $this->contrato;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getFechafiniquito() {
        return $this->fechafiniquito;
    }

    public function getFechainicio() {
        return $this->fechainicio;
    }

    public function getFechatermino() {
        return $this->fechatermino;
    }

    public function getCausal() {
        return $this->causal;
    }

    public function getTrabajador() {
        return $this->trabajador;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function getFecha() {
        return $this->fecha;
    }
}