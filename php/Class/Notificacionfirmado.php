<?php
class NotificacionFirmada{
    private $id;
    private $empresa;
    private $centrocosto;
    private $tipodocumento;
    private $documento;
    private $carta;
    private $register_at;

    public function __construct($id, $empresa, $centrocosto, $tipodocumento, $documento,$carta, $register_at){
        $this->id = $id;
        $this->empresa = $empresa;
        $this->centrocosto = $centrocosto;
        $this->tipodocumento = $tipodocumento;
        $this->documento = $documento;
        $this->carta = $carta;
        $this->register_at = $register_at;
    }

    public function getId(){
        return $this->id;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getCentrocosto(){
        return $this->centrocosto;
    }

    public function getTipodocumento(){
        return $this->tipodocumento;
    }

    public function getDocumento(){
        return $this->documento;
    }

    public function getCarta(){
        return $this->carta;
    }

    public function getRegister_at(){
        return $this->register_at;
    }
}