<?php
class Anotacion{
    private $id;
    private $trabajador;
    private $empresa;
    private $tipoanotacion;
    private $anotacion;
    private $fecha;

    public function __construct($id, $trabajador, $empresa, $tipoanotacion, $anotacion, $fecha){
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->tipoanotacion = $tipoanotacion;
        $this->anotacion = $anotacion;
        $this->fecha = $fecha;
    }

    public function getId(){
        return $this->id;
    }

    public function getTrabajador(){
        return $this->trabajador;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getTipoanotacion(){
        return $this->tipoanotacion;
    }

    public function getAnotacion(){
        return $this->anotacion;
    }

    public function getFecha(){
        return $this->fecha;
    }
    
}