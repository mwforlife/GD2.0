<?php
class Lotes_contrato{
    private $id;
    private $contrato;
    private $trabajador;
    private $nombre_lote;
    private $fecha_inicio;
    private $fecha_fin;

    public function __construct($id, $contrato, $trabajador, $nombre_lote, $fecha_inicio, $fecha_fin){
        $this->id = $id;
        $this->contrato = $contrato;
        $this->trabajador = $trabajador;
        $this->nombre_lote = $nombre_lote;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function getId(){
        return $this->id;
    }

    public function getContrato(){
        return $this->contrato;
    }

    public function getTrabajador(){
        return $this->trabajador;
    }

    public function getNombre_lote(){
        return $this->nombre_lote;
    }

    public function getFecha_inicio(){
        return $this->fecha_inicio;
    }

    public function getFecha_fin(){
        return $this->fecha_fin;
    }
}