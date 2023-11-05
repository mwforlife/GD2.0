<?php
class MovPersonal{
    private $id;
    private $trabajador;
    private $empresa;
    private $periodo;
    private $tipo;
    private $evento;
    private $fechainicio;
    private $fechatermino;
    private $rutentidad;
    private $nombreentidad;
    private $register_at;

    public function __construct($id, $trabajador, $empresa, $periodo, $tipo, $evento, $fechainicio, $fechatermino, $rutentidad, $nombreentidad, $register_at){
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->periodo = $periodo;
        $this->tipo = $tipo;
        $this->evento = $evento;
        $this->fechainicio = $fechainicio;
        $this->fechatermino = $fechatermino;
        $this->rutentidad = $rutentidad;
        $this->nombreentidad = $nombreentidad;
        $this->register_at = $register_at;
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

    public function getPeriodo(){
        return $this->periodo;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getEvento(){
        return $this->evento;
    }

    public function getFechainicio(){
        return $this->fechainicio;
    }

    public function getFechatermino(){
        return $this->fechatermino;
    }

    public function getRutentidad(){
        return $this->rutentidad;
    }

    public function getNombreentidad(){
        return $this->nombreentidad;
    }

    public function getRegister_at(){
        return $this->register_at;
    }
}