<?php
class Formula{
    private $id;
    private $codigo;
    private $nombre;
    private $representacion;
    private $formula;
    
    public function __construct($id, $codigo, $nombre, $representacion, $formula){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->representacion = $representacion;
        $this->formula = $formula;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getRepresentacion(){
        return $this->representacion;
    }

    public function getFormula(){
        return $this->formula;
    }

}