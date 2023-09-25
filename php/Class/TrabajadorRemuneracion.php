<?php
class TrabajadorRemuneracion{
    private $id;
    private $contrato;
    private $tiposueldo;
    private $sueldo;
    private $asignacion;
    private $registro;

    public function TrabajadorRemuneracion($id, $contrato, $tiposueldo, $sueldo, $asignacion, $registro){
        $this->id = $id;
        $this->contrato = $contrato;
        $this->tiposueldo = $tiposueldo;
        $this->sueldo = $sueldo;
        $this->asignacion = $asignacion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getContrato(){
        return $this->contrato;
    }

    public function getTiposueldo(){
        return $this->tiposueldo;
    }

    public function getSueldo(){
        return $this->sueldo;
    }

    public function getAsignacion(){
        return $this->asignacion;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setContrato($contrato){
        $this->contrato = $contrato;
    }

    public function setTiposueldo($tiposueldo){
        $this->tiposueldo = $tiposueldo;
    }

    public function setSueldo($sueldo){
        $this->sueldo = $sueldo;
    }

    public function setAsignacion($asignacion){
        $this->asignacion = $asignacion;
    }

    public function setRegistro($registro){
        $this->registro = $registro;
    }
}