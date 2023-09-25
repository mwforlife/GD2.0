<?php
class Prevision
{
    private $id;
    private $trabajador;
    private $periodo;
    private $afp;
    private $jubilado;
    private $cesantia;
    private $seguro;
    private $periodocesantia;
    private $isapre;
    private $monedapacto;
    private $monto;
    private $tipoges;
    private $ges;
    private $comentario;
    private $documentoafp;
    private $documentosalud;
    private $documentojubilacion;

    public function Prevision($id, $trabajador, $periodo, $afp, $jubilado, $cesantia, $seguro, $periodocesantia, $isapre, $monedapacto, $monto, $tipoges, $ges, $comentario, $documentoafp, $documentosalud, $documentojubilacion)
    {
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->periodo = $periodo;
        $this->afp = $afp;
        $this->jubilado = $jubilado;
        $this->cesantia = $cesantia;
        $this->seguro = $seguro;
        $this->periodocesantia = $periodocesantia;
        $this->isapre = $isapre;
        $this->monedapacto = $monedapacto;
        $this->monto = $monto;
        $this->tipoges = $tipoges;
        $this->ges = $ges;
        $this->comentario = $comentario;
        $this->documentoafp = $documentoafp;
        $this->documentosalud = $documentosalud;
        $this->documentojubilacion = $documentojubilacion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTrabajador()
    {
        return $this->trabajador;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function getAfp()
    {
        return $this->afp;
    }

    public function getJubilado()
    {
        return $this->jubilado;
    }

    public function getCesantia()
    {
        return $this->cesantia;
    }

    public function getSeguro()
    {
        return $this->seguro;
    }

    public function getPeriodocesantia()
    {
        return $this->periodocesantia;
    }

    public function getIsapre()
    {
        return $this->isapre;
    }

    public function getMonedapacto()
    {
        return $this->monedapacto;
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function getTipoges()
    {
        return $this->tipoges;
    }

    public function getGes()
    {
        return $this->ges;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    public function setAfp($afp)
    {
        $this->afp = $afp;
    }

    public function setJubilado($jubilado)
    {
        $this->jubilado = $jubilado;
    }

    public function setCesantia($cesantia)
    {
        $this->cesantia = $cesantia;
    }

    public function setSeguro($seguro)
    {
        $this->seguro = $seguro;
    }

    public function setPeriodocesantia($periodocesantia)
    {
        $this->periodocesantia = $periodocesantia;
    }

    public function setIsapre($isapre)
    {
        $this->isapre = $isapre;
    }

    public function setMonedapacto($monedapacto)
    {
        $this->monedapacto = $monedapacto;
    }

    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    public function setTipoges($tipoges)
    {
        $this->tipoges = $tipoges;
    }

    public function setGes($ges)
    {
        $this->ges = $ges;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    public function getDocumentoafp()
    {
        return $this->documentoafp;
    }

    public function setDocumentoafp($documentoafp)
    {
        $this->documentoafp = $documentoafp;
    }

    public function getDocumentosalud()
    {
        return $this->documentosalud;
    }

    public function setDocumentosalud($documentosalud)
    {
        $this->documentosalud = $documentosalud;
    }

    public function getDocumentojubilacion()
    {
        return $this->documentojubilacion;
    }

    public function setDocumentojubilacion($documentojubilacion)
    {
        $this->documentojubilacion = $documentojubilacion;
    }
}
