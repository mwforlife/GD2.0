<?php
class CuentaBancaria
{
    private $id;
    private $trabajador;
    private $banco;
    private $tipo;
    private $numero;
    private $registro;

    public function __construct($id, $trabajador, $banco, $tipo, $numero, $registro)
    {
        $this->id = $id;
        $this->trabajador = $trabajador;
        $this->banco = $banco;
        $this->tipo = $tipo;
        $this->numero = $numero;
        $this->registro = $registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTrabajador()
    {
        return $this->trabajador;
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getRegistro()
    {
        return $this->registro;
    }
}
