<?php
class Licencias
{
    private $id;
    private $folio;
    private $tipolicencia;
    private $fechainicio;
    private $fechafin;
    private $pagadora;
    private $comentario;
    private $documentolicencia;
    private $comprobantetramite;
    private $trabajador;
    private $registro;

    public function Licencias($id, $folio, $tipolicencia, $fechainicio, $fechafin, $pagadora, $comentario, $documentolicencia, $comprobantetramite, $trabajador, $registro)
    {
        $this->id = $id;
        $this->folio = $folio;
        $this->tipolicencia = $tipolicencia;
        $this->fechainicio = $fechainicio;
        $this->fechafin = $fechafin;
        $this->pagadora = $pagadora;
        $this->comentario = $comentario;
        $this->documentolicencia = $documentolicencia;
        $this->comprobantetramite = $comprobantetramite;
        $this->trabajador = $trabajador;
        $this->registro = $registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFolio()
    {
        return $this->folio;
    }

    public function getTipolicencia()
    {
        return $this->tipolicencia;
    }

    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    public function getFechafin()
    {
        return $this->fechafin;
    }

    public function getPagadora()
    {
        return $this->pagadora;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function getDocumentolicencia()
    {
        return $this->documentolicencia;
    }

    public function getComprobantetramite()
    {
        return $this->comprobantetramite;
    }

    public function getTrabajador()
    {
        return $this->trabajador;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;
    }

    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;
    }

    public function setPagadora($pagadora)
    {
        $this->pagadora = $pagadora;
    }

    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    public function setDocumentolicencia($documentolicencia)
    {
        $this->documentolicencia = $documentolicencia;
    }

    public function setComprobantetramite($comprobantetramite)
    {
        $this->comprobantetramite = $comprobantetramite;
    }

    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;
    }

    public function setRegistro($registro)
    {
        $this->registro = $registro;
    }
}
