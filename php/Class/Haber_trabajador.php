<?php
class haberes_trabajador{
    private $id;
    private $codigo;
    private $periodoini;
    private $periodofin;
    private $monto;
    private $dias;
    private $horas;
    private $modalidad;
    private $trabajador;
    private $empresa;
    private $tipo;
    private $registro;

    public function __construct($id, $codigo, $periodoini, $periodofin, $monto, $dias, $horas, $modalidad, $trabajador, $empresa, $tipo, $registro){
        $this->id = $id;
        $this->codigo = $codigo;
        $this->periodoini = $periodoini;
        $this->periodofin = $periodofin;
        $this->monto = $monto;
        $this->dias = $dias;
        $this->horas = $horas;
        $this->modalidad = $modalidad;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->tipo = $tipo;
        $this->registro = $registro;
    }

    function getId(){
        return $this->id;
    }

    function getCodigo(){
        return $this->codigo;
    }

    function getPeriodoini(){
        return $this->periodoini;
    }

    function getPeriodofin(){
        return $this->periodofin;
    }

    function getMonto(){
        return $this->monto;
    }

    function getDias(){
        return $this->dias;
    }

    function getHoras(){
        return $this->horas;
    }

    function getModalidad(){
        return $this->modalidad;
    }

    function getTrabajador(){
        return $this->trabajador;
    }

    function getEmpresa(){
        return $this->empresa;
    }

    function getTipo(){
        return $this->tipo;
    }

    function getRegistro(){
        return $this->registro;
    }

}