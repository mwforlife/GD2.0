<?php
class ResumenFiniquito{
    private $id;
    private $indemnizacion;
    private $tipo;
    private $descripcion;
    private $monto;

    public function __construct($id, $indemnizacion, $tipo, $descripcion, $monto){
        $this->id = $id;
        $this->indemnizacion = $indemnizacion;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->monto = $monto;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getIndemnizacion(){
        return $this->indemnizacion;
    }

    public function setIndemnizacion($indemnizacion){
        $this->indemnizacion = $indemnizacion;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function getMonto(){
        return $this->monto;
    }

    public function setMonto($monto){
        $this->monto = $monto;
    }
}