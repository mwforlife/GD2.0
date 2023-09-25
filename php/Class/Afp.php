<?php
class AFP
{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $nombre;
    private $descuento;

    public function __construct($id, $codigo, $codigoPrevired, $nombre, $descuento)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->nombre = $nombre;
        $this->descuento = $descuento;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescuento()
    {
        return $this->descuento;
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

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }
}
