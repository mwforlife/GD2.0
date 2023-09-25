<?php
class Trabajadores
{
    private $id;
    private $rut;
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $nacimiento;
    private $sexo;
    private $civil;
    private $nacionalidad;
    private $discapacidad;
    private $pension;
    private $empresa;
    private $registrar;

    public function Trabajadores($id, $rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $civil, $nacionalidad, $discapacidad, $pension, $empresa, $registrar)
    {
        $this->id = $id;
        $this->rut = $rut;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->nacimiento = $nacimiento;
        $this->sexo = $sexo;
        $this->civil = $civil;
        $this->nacionalidad = $nacionalidad;
        $this->discapacidad = $discapacidad;
        $this->pension = $pension;
        $this->empresa = $empresa;
        $this->registrar = $registrar;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRut()
    {
        return $this->rut;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido1()
    {
        return $this->apellido1;
    }

    public function getApellido2()
    {
        return $this->apellido2;
    }

    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getCivil()
    {
        return $this->civil;
    }

    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    public function getDiscapacidad()
    {
        return $this->discapacidad;
    }

    public function getPension()
    {
        return $this->pension;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getRegistrar()
    {
        return $this->registrar;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRut($rut)
    {
        $this->rut = $rut;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }

    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }

    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function setCivil($civil)
    {
        $this->civil = $civil;
    }

    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;
    }

    public function setDiscapacidad($discapacidad)
    {
        $this->discapacidad = $discapacidad;
    }

    public function setPension($pension)
    {
        $this->pension = $pension;
    }

    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    public function setRegistrar($registrar)
    {
        $this->registrar = $registrar;
    }
}
