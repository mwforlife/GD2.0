<?php
class Users{
    private $id;
    private $rut;
    private $nombre;
    private $apellido;
    private $correo;
    private $direccion;
    private $region;
    private $comuna;
    private $telefono;
    private $pass;
    private $estado;
    private $token;
    private $registro;
    private $update;

    public function Users($id, $rut, $nombre, $apellido, $correo, $direccion, $region, $comuna, $telefono, $pass, $estado, $token, $registro, $update){
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->region = $region;
        $this->comuna = $comuna;
        $this->telefono = $telefono;
        $this->pass = $pass;
        $this->estado = $estado;
        $this->token = $token;
        $this->registro = $registro;
        $this->update = $update;
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

    public function getApellido(){
        return $this->apellido;
    }

    public function getCorreo(){
        return $this->correo;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function getRegion(){
        return $this->region;
    }

    public function getComuna(){
        return $this->comuna;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getPass(){
        return $this->pass;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getToken(){
        return $this->token;
    }

    public function getRegistro(){
        return $this->registro;
    }

    public function getUpdate(){
        return $this->update;
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

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function setCorreo($correo){
        $this->correo = $correo;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    public function setRegion($region){
        $this->region = $region;
    }

    public function setComuna($comuna){
        $this->comuna = $comuna;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function setPass($pass){
        $this->pass = $pass;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function setRegistro($registro){
        $this->registro = $registro;
    }

    public function setUpdate($update){
        $this->update = $update;
    }
}