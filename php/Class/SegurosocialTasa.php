<?php
class SegurosocialTasa
{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $fecha;
    private $tasa;

    public function __construct($id, $codigo, $codigoPrevired, $fecha, $tasa)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->fecha = $fecha;
        $this->tasa = $tasa;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getCodigoPrevired()
    {
        return $this->codigoPrevired;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getTasa()
    {
        return $this->tasa;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setCodigoPrevired($codigoPrevired)
    {
        $this->codigoPrevired = $codigoPrevired;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setTasa($tasa)
    {
        $this->tasa = $tasa;
    }
}
