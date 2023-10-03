<?php
class Clausulaanexo{
    private $id;
    private $anexo;
    private $clausula;
    private $tipodocumento;
    private $registro;
    
    public function __construct($id, $anexo, $clausula, $tipodocumento, $registro){
        $this->id = $id;
        $this->anexo = $anexo;
        $this->clausula = $clausula;
        $this->tipodocumento = $tipodocumento;
        $this->registro = $registro;
    }

    public function getId(){
        return $this->id;
    }

    public function getAnexo(){
        return $this->anexo;
    }

    public function getClausula(){
        return $this->clausula;
    }

    public function getTipodocumento(){
        return $this->tipodocumento;
    }

    public function getRegistro(){
        return $this->registro;
    }
}