<?php
class Anexo{
    private $id;
    private $contrato;
    private $fechageneracion;
    private $base;
    private $sueldo_base;
    private $estado;
    private $registro;
    
    public function __construct($id, $contrato, $fechageneracion, $base, $sueldo_base, $estado, $registro){
        $this->id = $id;
        $this->contrato = $contrato;
        $this->fechageneracion = $fechageneracion;
        $this->base = $base;
        $this->sueldo_base = $sueldo_base;
        $this->estado = $estado;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getContrato(){
        return $this->contrato;
    }

    public function getFechageneracion(){
        return $this->fechageneracion;
    }

    public function getBase(){
        return $this->base;
    }

    public function getSueldo_base(){
        return $this->sueldo_base;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getRegistro(){
        return $this->registro;
    }
}