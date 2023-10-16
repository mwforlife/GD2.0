<?php
class DocumentoEmpresa{
    private $id;
    private $tipo;
    private $centrocosto;
    private $documento;
    private $periodo;
    private $empresa;
    private $register_at;

    public function __construct($id, $tipo, $centrocosto, $documento, $periodo, $empresa, $register_at){
        $this->id = $id;
        $this->tipo = $tipo;
        $this->centrocosto = $centrocosto;
        $this->documento = $documento;
        $this->periodo = $periodo;
        $this->empresa = $empresa;
        $this->register_at = $register_at;
    }

    public function getId(){
        return $this->id;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getCentrocosto(){
        return $this->centrocosto;
    }

    public function getDocumento(){
        return $this->documento;
    }

    public function getPeriodo(){
        return $this->periodo;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getRegister_at(){
        return $this->register_at;
    }
}