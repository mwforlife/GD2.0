<?php
class Documento{
    private $id;
    private $trabajador;
    private $empresa;
    private $tipodocumento;
    private $fechageneracion;
    private $documento;
    private $registro;

    public function __construct($id, $trabajador, $empresa, $tipodocumento, $fechageneracion,$documento, $registro){
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->tipodocumento = $tipodocumento;
        $this->fechageneracion = $fechageneracion;
        $this->documento = $documento;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getTrabajador(){
        return $this->trabajador;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getTipodocumento(){
        return $this->tipodocumento;
    }

    public function getFechageneracion(){
        return $this->fechageneracion;
    }

    public function getDocumento(){
        return $this->documento;
    }

    public function getRegistro(){
        return $this->registro;
    }
}