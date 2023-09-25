<?php
class CargaFamiliar{
    private $id;
    private $rut;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $fechaNacimiento;
    private $estadoCivil;
    private $fechaReconocimiento;
    private $fechaPago;
    private $vigencia;
    private $tipoCausante;
    private $sexo;
    private $tipoCarga;
    private $documento;
    private $fechaRegistro;
    private $trabajador;
    private $comentario;

    public function CargaFamiliar($id, $rut, $nombre, $apellido1, $apellido2, $fechaNacimiento, $estadoCivil, $fechaReconocimiento, $fechaPago, $vigencia, $tipoCausante, $sexo, $tipoCarga, $documento, $fechaRegistro, $trabajador, $comentario){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->estadoCivil = $estadoCivil;
        $this->fechaReconocimiento = $fechaReconocimiento;
        $this->fechaPago = $fechaPago;
        $this->vigencia = $vigencia;
        $this->tipoCausante = $tipoCausante;
        $this->sexo = $sexo;
        $this->tipoCarga = $tipoCarga;
        $this->documento = $documento;
        $this->fechaRegistro = $fechaRegistro;
        $this->trabajador = $trabajador;
        $this->comentario = $comentario;
    }

    public function getId(){
        return $this->id;
    }

    public function getRut(){
        return $this->rut;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido1(){
        return $this->apellido1;
    }

    public function getApellido2(){
        return $this->apellido2;
    }

    public function getFechaNacimiento(){
        return $this->fechaNacimiento;
    }

    public function getEstadoCivil(){
        return $this->estadoCivil;
    }

    public function getFechaReconocimiento(){
        return $this->fechaReconocimiento;
    }

    public function getFechaPago(){
        return $this->fechaPago;
    }

    public function getVigencia(){
        return $this->vigencia;
    }

    public function getTipoCausante(){
        return $this->tipoCausante;
    }

    public function getSexo(){
        return $this->sexo;
    }

    public function getTipoCarga(){
        return $this->tipoCarga;
    }

    public function getDocumento(){
        return $this->documento;
    }

    public function getFechaRegistro(){
        return $this->fechaRegistro;
    }

    public function getTrabajador(){
        return $this->trabajador;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setRut($rut){
        $this->rut = $rut;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellido1($apellido1){
        $this->apellido1 = $apellido1;
    }

    public function setApellido2($apellido2){
        $this->apellido2 = $apellido2;
    }

    public function setFechaNacimiento($fechaNacimiento){
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setEstadoCivil($estadoCivil){
        $this->estadoCivil = $estadoCivil;
    }

    public function setFechaReconocimiento($fechaReconocimiento){
        $this->fechaReconocimiento = $fechaReconocimiento;
    }

    public function setFechaPago($fechaPago){
        $this->fechaPago = $fechaPago;
    }

    public function setVigencia($vigencia){
        $this->vigencia = $vigencia;
    }

    public function setTipoCausante($tipoCausante){
        $this->tipoCausante = $tipoCausante;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }

    public function setTipoCarga($tipoCarga){
        $this->tipoCarga = $tipoCarga;
    }

    public function setDocumento($documento){
        $this->documento = $documento;
    }

    public function setFechaRegistro($fechaRegistro){
        $this->fechaRegistro = $fechaRegistro;
    }

    public function setTrabajador($trabajador){
        $this->trabajador = $trabajador;
    }

    public function getComentario(){
        return $this->comentario;
    }

    public function setComentario($comentario){
        $this->comentario = $comentario;
    }
    
}