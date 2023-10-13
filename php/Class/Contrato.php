<?php
class Contrato
{
    private $id;
    private $trabajador;
    private $empresa;
    private $centrocosto;
    private $tipocontrato;
    private $cargo;
    private $sueldo;
    private $fechainicio;
    private $fechatermino;
    private $documento;
    private $estado;
    private $fecharegistro;

    public function __construct($id, $trabajador, $empresa,$centrocosto, $tipocontrato,$cargo, $sueldo, $fechainicio, $fechatermino, $documento, $estado, $fecharegistro)
    {
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->empresa = $empresa;
        $this->centrocosto = $centrocosto;
        $this->tipocontrato = $tipocontrato;
        $this->cargo = $cargo;
        $this->sueldo = $sueldo;
        $this->fechainicio = $fechainicio;
        $this->fechatermino = $fechatermino;
        $this->documento = $documento;
        $this->estado = $estado;
        $this->fecharegistro = $fecharegistro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTrabajador()
    {
        return $this->trabajador;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getCentrocosto()
    {
        return $this->centrocosto;
    }

    public function getTipocontrato()
    {
        return $this->tipocontrato;
    }

    public function getCargo()
    {
        return $this->cargo;
    }
    
    public function getSueldo()
    {
        return $this->sueldo;
    }

    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    public function getFechatermino()
    {
        return $this->fechatermino;
    }

    public function setFechatermino($fechatermino){
        $this->fechatermino = $fechatermino;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }
}
