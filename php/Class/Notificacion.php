<?php
class Notificacion{
    private $id;
    private $fechanotificacion;
    private $finiquito;
    private $tipodocumento;
    private $causal;
    private $causalhechos;
    private $cotizacionprevisional;
    private $comunicacion;
    private $acrediacion;
    private $comuna;
    private $texto;
    private $registro;

    public function __construct($id, $fechanotificacion, $finiquito,$tipodocumento, $causal, $causalhechos, $cotizacionprevisional, $comunicacion, $acrediacion, $comuna,$texto, $registro) {
        $this->id = $id;
        $this->fechanotificacion = $fechanotificacion;
        $this->finiquito = $finiquito;
        $this->tipodocumento = $tipodocumento;
        $this->causal = $causal;
        $this->causalhechos = $causalhechos;
        $this->cotizacionprevisional = $cotizacionprevisional;
        $this->comunicacion = $comunicacion;
        $this->acrediacion = $acrediacion;
        $this->comuna = $comuna;
        $this->texto = $texto;
        $this->registro = $registro;
    }

    public function getId() {
        return $this->id;
    }

    public function getFechanotificacion() {
        return $this->fechanotificacion;
    }

    public function getFiniquito() {
        return $this->finiquito;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getCausal() {
        return $this->causal;
    }

    public function getCausalhechos() {
        return $this->causalhechos;
    }

    public function getCotizacionprevisional() {
        return $this->cotizacionprevisional;
    }

    public function getComunicacion() {
        return $this->comunicacion;
    }

    public function getAcrediacion() {
        return $this->acrediacion;
    }

    public function getComuna() {
        return $this->comuna;
    }

    public function getTexto(){
        return $this->texto;
    }

    public function getRegistro() {
        return $this->registro;
    }
}