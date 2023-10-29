<?php
class TrabajadorCargo
{
    private $id;
    private $contrato;
    private $centrocosto;
    private $cargo;
    private $cargodescripcion;
    private $tipocontrato;
    private $desde;
    private $hasta;
    private $jornada;
    private $horaspactadas;
    private $registro;

    public function __construct($id, $contrato, $centrocosto, $cargo, $cargodescripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas, $registro)
    {
        $this->id = $id;
        $this->contrato = $contrato;
        $this->centrocosto = $centrocosto;
        $this->cargo = $cargo;
        $this->cargodescripcion = $cargodescripcion;
        $this->tipocontrato = $tipocontrato;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->jornada = $jornada;
        $this->horaspactadas = $horaspactadas;
        $this->registro = $registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContrato()
    {
        return $this->contrato;
    }

    public function getCentrocosto()
    {
        return $this->centrocosto;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function getCargodescripcion()
    {
        return $this->cargodescripcion;
    }

    public function getTipocontrato()
    {
        return $this->tipocontrato;
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function getHasta()
    {
        return $this->hasta;
    }

    public function getJornada()
    {
        return $this->jornada;
    }

    public function getHoraspactadas()
    {
        return $this->horaspactadas;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    
    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
    }
    public function setCentrocosto($centrocosto)
    {
        $this->centrocosto = $centrocosto;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    public function setCargodescripcion($cargodescripcion)
    {
        $this->cargodescripcion = $cargodescripcion;
    }

    public function setTipocontrato($tipocontrato)
    {
        $this->tipocontrato = $tipocontrato;
    }

    public function setDesde($desde)
    {
        $this->desde = $desde;
    }

    public function setHasta($hasta)
    {
        $this->hasta = $hasta;
    }

    public function setJornada($jornada)
    {
        $this->jornada = $jornada;
    }

    public function setHoraspactadas($horaspactadas)
    {
        $this->horaspactadas = $horaspactadas;
    }

    public function setRegistro($registro)
    {
        $this->registro = $registro;
    }
}
