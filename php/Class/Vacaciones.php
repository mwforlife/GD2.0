<?php
class Vacaciones
{
    private $id;
    private $trabajador;
    private $periodoinicio;
    private $periodotermino;
    private $diasacumulados;
    private $anosacumulados;
    private $diasprogesivas;
    private $tipodocumento;
    private $fechainicio;
    private $fechatermino;
    private $diashabiles;
    private $diasinhabiles;
    private $diasferiados;
    private $totales;
    private $diasrestantes;
    private $observacion;
    private $comprobantefirmado;
    private $registro;

    public function __construct($id, $trabajador, $periodoinicio, $periodotermino, $diasacumulados, $anosacumulados, $diasprogesivas, $tipodocumento, $fechainicio, $fechatermino, $diashabiles, $diasinhabiles, $diasferiados, $totales, $diasrestantes, $observacion, $comprobantefirmado, $registro)
    {
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->periodoinicio = $periodoinicio;
        $this->periodotermino = $periodotermino;
        $this->diasacumulados = $diasacumulados;
        $this->anosacumulados = $anosacumulados;
        $this->diasprogesivas = $diasprogesivas;
        $this->tipodocumento = $tipodocumento;
        $this->fechainicio = $fechainicio;
        $this->fechatermino = $fechatermino;
        $this->diashabiles = $diashabiles;
        $this->diasinhabiles = $diasinhabiles;
        $this->diasferiados = $diasferiados;
        $this->totales = $totales;
        $this->diasrestantes = $diasrestantes;
        $this->observacion = $observacion;
        $this->comprobantefirmado = $comprobantefirmado;
        $this->registro = $registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTrabajador()
    {
        return $this->trabajador;
    }

    public function getPeriodoinicio()
    {
        return $this->periodoinicio;
    }

    public function getPeriodotermino()
    {
        return $this->periodotermino;
    }

    public function getDiasacumulados()
    {
        return $this->diasacumulados;
    }

    public function getAnosacumulados()
    {
        return $this->anosacumulados;
    }

    public function getDiasprogesivas()
    {
        return $this->diasprogesivas;
    }

    public function getTipodocumento()
    {
        return $this->tipodocumento;
    }

    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    public function getFechatermino()
    {
        return $this->fechatermino;
    }

    public function getDiashabiles()
    {
        return $this->diashabiles;
    }

    public function getDiasinhabiles()
    {
        return $this->diasinhabiles;
    }

    public function getDiasferiados()
    {
        return $this->diasferiados;
    }

    public function getTotales()
    {
        return $this->totales;
    }

    public function getDiasrestantes()
    {
        return $this->diasrestantes;
    }

    public function getObservacion()
    {
        return $this->observacion;
    }

    public function getComprobantefirmado()
    {
        return $this->comprobantefirmado;
    }

    public function getRegistro()
    {
        return $this->registro;
    }
}
