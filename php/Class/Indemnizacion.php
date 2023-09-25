<?php
class Indemnizacion{
    private $id;
    private $nombre;
    private $tipo;

    public function __construct($id, $nombre, $tipo){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getTipo(){
        return $this->tipo;
    }
}