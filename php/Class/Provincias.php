<?php
class Provincias
{
    private $id;
    private $codigo;
    private $codigoPrevired;
    private $nombre;
    private $region;

    public function __construct($id, $codigo, $codigoPrevired, $nombre, $region)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->codigoPrevired = $codigoPrevired;
        $this->nombre = $nombre;
        $this->region = $region;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getCodigoPrevired()
    {
        return $this->codigoPrevired;
    }

    public function setCodigoPrevired($codigoPrevired)
    {
        $this->codigoPrevired = $codigoPrevired;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;
    }
}
