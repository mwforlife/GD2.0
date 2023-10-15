<?php
class CausalTermino{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $articulo;
    private $letra;
    private $nombre;

    public function CausalTermino($id, $codigo, $codigoPrevired,$articulo, $letra, $nombre){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->articulo = $articulo;
        $this->letra = $letra;
        $this->nombre = $nombre;
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

    public function getArticulo(){
        return $this->articulo;
    }

    public function setArticulo($articulo){
        $this->articulo = $articulo;
    }

    public function getLetra(){
        return $this->letra;
    }

    public function setLetra($letra){
        $this->letra = $letra;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}