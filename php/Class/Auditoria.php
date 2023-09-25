<?php
class Auditoria{
    private $id;
    private $usuario;
    private $fecha;
    private $accion;

    public function Auditoria($id, $usuario, $fecha, $accion){
        $this->id = $id;
        $this->usuario = $usuario;
        $this->fecha = $fecha;
        $this->accion = $accion;
    }

    public function getId(){
        return $this->id;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getAccion(){
        return $this->accion;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function setAccion($accion){
        $this->accion = $accion;
    }
}