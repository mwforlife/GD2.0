<?php
class Tasa{
    private $id;
    private $institucion;
    private $fecha;
    private $tasa;

    public function Tasa($id, $institucion, $fecha, $tasa) {
        $this->id = $id;
        $this->institucion = $institucion;
        $this->fecha = $fecha;
        $this->tasa = $tasa;
    }

    public function getId() {
        return $this->id;
    }

    public function getInstitucion() {
        return $this->institucion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getTasa() {
        return $this->tasa;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setInstitucion($institucion) {
        $this->institucion = $institucion;
    }   

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setTasa($tasa) {
        $this->tasa = $tasa;
    }


}