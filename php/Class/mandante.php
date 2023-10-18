<?php
class Mandante{
    private $id;
    private $usuario;
    private $centrocosto;
    private $register_at;

    public function __construct($id, $usuario, $centrocosto, $register_at){
        $this->id = $id;
        $this->usuario = $usuario;
        $this->centrocosto = $centrocosto;
        $this->register_at = $register_at;
    }

    public function getId(){
        return $this->id;
    }


    public function getUsuario(){
        return $this->usuario;
    }

    public function getCentrocosto(){
        return $this->centrocosto;
    }

    public function getRegister_at(){
        return $this->register_at;
    }
}