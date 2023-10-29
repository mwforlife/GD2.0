<?php
class TrabajadorDomicilio{
    private $id;
    private $calle;
    private $villa;
    private $numero;
    private $departamento;
    private $region;
    private $comuna;
    private $ciudad;
    private $registro;

    public function __construct($id, $calle,$villa, $numero, $departamento, $region, $comuna, $ciudad, $registro){
        $this->id = $id;
        $this->calle = $calle;
        $this->villa = $villa;
        $this->numero = $numero;
        $this->departamento = $departamento;
        $this->region = $region;
        $this->comuna = $comuna;
        $this->ciudad = $ciudad;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getCalle(){
        return $this->calle;
    }

    public function getVilla(){
        return $this->villa;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function getDepartamento(){
        return $this->departamento;
    }

    public function getRegion(){
        return $this->region;
    }

    public function getComuna(){
        return $this->comuna;
    }

    public function getCiudad(){
        return $this->ciudad;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setCalle($calle){
        $this->calle = $calle;
    }

    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function setDepartamento($departamento){
        $this->departamento = $departamento;
    }

    public function setRegion($region){
        $this->region = $region;
    }

    public function setComuna($comuna){
        $this->comuna = $comuna;
    }

    public function setCiudad($ciudad){
        $this->ciudad = $ciudad;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function setRegistro($registro){
        $this->registro = $registro;
    }
}