<?php
class TrabajadorContacto
{
    private $id;
    private $telefono;
    private $correo;
    private $registro;

    public function __construct($id, $telefono, $correo, $registro)
    {
        $this->id = $id;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->registro = $registro;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function setRegistro($registro)
    {
        $this->registro = $registro;
    }
}
