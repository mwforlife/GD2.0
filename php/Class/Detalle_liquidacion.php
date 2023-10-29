<?php
class Detalle_liquidacion{
    private $id;
    private $liquidacion;
    private $codigo;
    private $monto;
    private $tipo;
    private $register_at;

    public function __construct($id, $liquidacion, $codigo, $monto, $tipo, $register_at){
        $this->id = $id;
        $this->liquidacion = $liquidacion;
        $this->codigo = $codigo;
        $this->monto = $monto;
        $this->tipo = $tipo;
        $this->register_at = $register_at;
    }

    public function getId(){
        return $this->id;
    }

    public function getLiquidacion(){
        return $this->liquidacion;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getMonto(){
        return $this->monto;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getRegister_at(){
        return $this->register_at;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setLiquidacion($liquidacion){
        $this->liquidacion = $liquidacion;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function setMonto($monto){
        $this->monto = $monto;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function setRegister_at($register_at){
        $this->register_at = $register_at;
    }
}