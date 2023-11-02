<?php
class UF{
    private $id;
    private $periodo;
    private $tasa;
    private $registro;

    public function __construct($id, $periodo, $tasa, $registro){
        $this->id = $id;
        $this->periodo = $periodo;
        $this->tasa = $tasa;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getPeriodo(){
        return $this->periodo;
    }

    public function getTasa(){
        return $this->tasa;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setPeriodo($periodo){
        $this->periodo = $periodo;
    }

    public function setTasa($tasa){
        $this->tasa = $tasa;
    }

    public function setRegistro($registro){
        $this->registro = $registro;
    }
}