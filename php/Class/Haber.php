<?php
class Haber{
    private $id;
    private $codigo;
    private $descripcion;
    private $tipo;
    private $imponible;
    private $tributable;
    private $gratificacion;
    private $reservado;
    private $lre;
    private $agrupacion;
    private $tipohaber;
    private $registro;

    public function __construct($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $lre, $agrupacion,$tipohaber, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
        $this->imponible = $imponible;
        $this->tributable = $tributable;
        $this->gratificacion = $gratificacion;
        $this->reservado = $reservado;
        $this->lre = $lre;
        $this->agrupacion = $agrupacion;
        $this->tipohaber = $tipohaber;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getImponible(){
        return $this->imponible;
    }

    public function getTributable(){
        return $this->tributable;
    }

    public function getGratificacion(){
        return $this->gratificacion;
    }

    public function getReservado(){
        return $this->reservado;
    }

    public function getLre(){
        return $this->lre;
    }

    public function getAgrupacion(){
        return $this->agrupacion;
    }

    public function getTipohaber(){
        return $this->tipohaber;
    }

    public function getRegistro(){
        return $this->registro;
    }
}