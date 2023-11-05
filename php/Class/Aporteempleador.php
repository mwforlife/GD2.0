<?php
class Aporteempleador{
    private $id;
    private $liquidacion;
    private $cesantiaempleador;
    private $cotizacionbasica;
    private $cotizacionleysanna;
    private $cotizacionadicional;
    private $seguroaccidentes;
    private $registro;

    public function __construct($id, $liquidacion, $cesantiaempleador, $cotizacionbasica, $cotizacionleysanna, $cotizacionadicional, $seguroaccidentes, $registro){
        $this->id = $id;
        $this->liquidacion = $liquidacion;
        $this->cesantiaempleador = $cesantiaempleador;
        $this->cotizacionbasica = $cotizacionbasica;
        $this->cotizacionleysanna = $cotizacionleysanna;
        $this->cotizacionadicional = $cotizacionadicional;
        $this->seguroaccidentes = $seguroaccidentes;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getLiquidacion(){
        return $this->liquidacion;
    }

    public function getCesantiaempleador(){
        return $this->cesantiaempleador;
    }

    public function getCotizacionbasica(){
        return $this->cotizacionbasica;
    }

    public function getCotizacionleysanna(){
        return $this->cotizacionleysanna;
    }

    public function getCotizacionadicional(){
        return $this->cotizacionadicional;
    }

    public function getSeguroaccidentes(){
        return $this->seguroaccidentes;
    }

    public function getRegistro(){
        return $this->registro;
    }
}