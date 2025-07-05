<?php
class Users
{
    private $id;
    private $rut;
    private $nombre;
    private $apellidos;
    private $email;
    private $direccion;
    private $region;
    private $comuna;
    private $telefono;
    private $password;
    private $estado;
    private $token;
    private $tipo;
    private $created_at;
    private $updated_at;
    private $nacionalidad;
    private $estado_civil;
    private $profesion;

    public function __construct($id, $rut, $nombre, $apellidos, $email, $direccion, $region, $comuna, $telefono, $password, $estado, $token, $tipo, $created_at, $updated_at, $nacionalidad = 0, $estado_civil = 0, $profesion = null)
    {
        $this->id = $id;
        $this->rut = $rut;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->region = $region;
        $this->comuna = $comuna;
        $this->telefono = $telefono;
        $this->password = $password;
        $this->estado = $estado;
        $this->token = $token;
        $this->tipo = $tipo;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->nacionalidad = $nacionalidad;
        $this->estado_civil = $estado_civil;
        $this->profesion = $profesion;
    }

    // Getters existentes
    public function getId() { return $this->id; }
    public function getRut() { return $this->rut; }
    public function getNombre() { return $this->nombre; }
    public function getApellido() { return $this->apellidos; }
    public function getCorreo() { return $this->email; }
    public function getDireccion() { return $this->direccion; }
    public function getRegion() { return $this->region; }
    public function getComuna() { return $this->comuna; }
    public function getTelefono() { return $this->telefono; }
    public function getPassword() { return $this->password; }
    public function getEstado() { return $this->estado; }
    public function getToken() { return $this->token; }
    public function getTipo() { return $this->tipo; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Nuevos getters
    public function getNacionalidad() { return $this->nacionalidad; }
    public function getEstadoCivil() { return $this->estado_civil; }
    public function getProfesion() { return $this->profesion; }

    // Setters existentes
    public function setId($id) { $this->id = $id; }
    public function setRut($rut) { $this->rut = $rut; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellido($apellidos) { $this->apellidos = $apellidos; }
    public function setCorreo($email) { $this->email = $email; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setRegion($region) { $this->region = $region; }
    public function setComuna($comuna) { $this->comuna = $comuna; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setPassword($password) { $this->password = $password; }
    public function setEstado($estado) { $this->estado = $estado; }
    public function setToken($token) { $this->token = $token; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }

    // Nuevos setters
    public function setNacionalidad($nacionalidad) { $this->nacionalidad = $nacionalidad; }
    public function setEstadoCivil($estado_civil) { $this->estado_civil = $estado_civil; }
    public function setProfesion($profesion) { $this->profesion = $profesion; }
}
?>