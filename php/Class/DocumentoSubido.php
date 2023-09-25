<?php
class DocumentoSubido{
    private $id;
    private $titulo;
    private $tipo;
    private $comentario;
    private $trabajadorid;
    private $empresaid;
    private $documento;
    private $fecha;
    
    public function __construct($id, $titulo, $tipo, $comentario, $trabajadorid, $empresaid, $documento, $fecha) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->tipo = $tipo;
        $this->comentario = $comentario;
        $this->trabajadorid = $trabajadorid;
        $this->empresaid = $empresaid;
        $this->documento = $documento;
        $this->fecha = $fecha;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function getTrabajadorid() {
        return $this->trabajadorid;
    }

    public function getEmpresaid() {
        return $this->empresaid;
    }

    public function getDocumento() {
        return $this->documento;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function setTrabajadorid($trabajadorid) {
        $this->trabajadorid = $trabajadorid;
    }

    public function setEmpresaid($empresaid) {
        $this->empresaid = $empresaid;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}