<?php
class Codigolre{
    private $id;
    private $articulo;
    private $codigo;
    private $codigoprevired;
    private $descripcion;
    private $registro;

    public function __construct($id,$articulo, $codigo, $codigoprevired, $descripcion, $registro){
        $this->id = $id;
        $this->articulo = $articulo;
        $this->codigo = $codigo;
        $this->codigoprevired = $codigoprevired;
        $this->descripcion = $descripcion;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getArticulo(){
        return $this->articulo;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getCodigoprevired(){
        return $this->codigoprevired;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getRegistro(){
        return $this->registro;
    }
}