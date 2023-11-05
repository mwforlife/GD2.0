<?php
class Jornadas{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $nombre;
    private $termino;
    private $entidad;

    public function __construct($id, $codigo, $codigoPrevired, $nombre, $termino, $entidad){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->nombre = $nombre;
        $this->termino = $termino;
        $this->entidad = $entidad;
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

    public function getTermino(){
        return $this->termino;
    }

    public function setTermino($termino){
        $this->termino = $termino;
    }

    public function getEntidad(){
        return $this->entidad;
    }

    public function setEntidad($entidad){
        $this->entidad = $entidad;
    }
}