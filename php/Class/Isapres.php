<?php
class ISAPRES{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $nombre;
    private $tipo;

    public function ISAPRES($id, $codigo, $codigoPrevired, $nombre, $tipo){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function getCodigoPrevired(){
        return $this->codigoPrevired;
    }

    public function setCodigoPrevired($codigoPrevired){
        $this->codigoPrevired = $codigoPrevired;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    
}