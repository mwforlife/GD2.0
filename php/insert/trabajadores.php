<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: ../../lockscreen.php");
    }
}

if (isset($_POST['TrabajadorRut'])  && isset($_POST['TrabajadorNombre']) && isset($_POST['TrabajadorApellido1'])  && isset($_POST['TrabajadorNacimiento']) && isset($_POST['TrabajadorSexo']) && isset($_POST['TrabajadorCivil']) && isset($_POST['TrabajadorNacionalidad']) && isset($_POST['TrabajadorDiscapacidad']) && isset($_POST['TrabajadorPension']) && isset($_POST['TrabajadorCalle']) && isset($_POST['Trabajadorvilla']) && isset($_POST['TrabajadorNumero']) && isset($_POST['TrabajadorRegion']) && isset($_POST['TrabajadorComuna']) && isset($_POST['TrabajadorCiudad']) && isset($_POST['TrabajadorTelefono']) && isset($_POST['TrabajadorCorreo']) && $_SESSION['CURRENT_ENTERPRISE'] /*&& $_POST['centrocosto'] && $_POST['Charge'] && $_POST['ChargeDescripcion'] && $_POST['tipocontrato'] && $_POST['desde'] && $_POST['Jornada'] && $_POST['Horaspactadas'] && $_POST['tiposueldo'] && $_POST['sueldo'] && $_POST['asignacion']*/) {
    $rut = $_POST['TrabajadorRut'];
    $dni = $_POST['TrabajadorDNI'];
    $nombre = $_POST['TrabajadorNombre'];
    $apellido1 = $_POST['TrabajadorApellido1'];
    $apellido2 = $_POST['TrabajadorApellido2'];
    $nacimiento = $_POST['TrabajadorNacimiento'];
    $sexo = $_POST['TrabajadorSexo'];
    $civil = $_POST['TrabajadorCivil'];
    $nacionalidad = $_POST['TrabajadorNacionalidad'];
    $discapacidad = $_POST['TrabajadorDiscapacidad'];
    $pension = $_POST['TrabajadorPension'];
    $calle = $_POST['TrabajadorCalle'];
    $calle = $c->escapeString($calle);
    $villa = $_POST['Trabajadorvilla'];
    $numero = $_POST['TrabajadorNumero'];
    $numero = $c->escapeString($numero);
    $numero = strtoupper($numero);
    $departamento = $_POST['TrabajadorDepartamento'];
    $region = $_POST['TrabajadorRegion'];
    if ($region == 0) {
        echo "error";
        return;
    }
    $comuna = $_POST['TrabajadorComuna'];
    if ($comuna < 1) {
        echo "Error";
        return;
    }
    $ciudad = $_POST['TrabajadorCiudad'];
    if ($ciudad < 1) {
        echo "Error";
        return;
    }
    $telefono = $_POST['TrabajadorTelefono'];
    $correo = $_POST['TrabajadorCorreo'];
    /*$centrocosto = $_POST['centrocosto'];
    if($centrocosto <=0){
        echo "error";
        return;
    }
    $cargo = $_POST['Charge'];
    if($cargo <=0){
        echo "error";
        return;
    }
    $cargodescripcion = $_POST['ChargeDescripcion'];
    $cargodescripcion = strtoupper($cargodescripcion);
    $tipocontrato = $_POST['tipocontrato'];
    if($tipocontrato <=0){
        echo "error";
        return;
    }
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $jornada = $_POST['Jornada'];
    if($jornada <=0){
        echo "error";
        return;
    }
    $horaspactadas = $_POST['Horaspactadas'];
    $tiposueldo = $_POST['tiposueldo'];
    if($tiposueldo <=0){
        echo "error";
        return;
    }
    $sueldo = $_POST['sueldo'];
    $asignacion = $_POST['asignacion'];
    //validar si la asignacion es un valor numerico o decimnal
    if (!is_numeric($asignacion)) {
        echo "error";
        return;
    }*/




    $correo = $c->escapeString($correo);
    $correo = strtoupper($correo);
    $nombre = strtoupper($nombre);
    $apellido1 = strtoupper($apellido1);
    $apellido2 = strtoupper($apellido2);
    $calle = strtoupper($calle);
    $departamento = strtoupper($departamento);
    $ciudad = strtoupper($ciudad);
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];
    $valid = $c->validartrabajador($rut, $empresa);
    if ($valid == false) {
        $result = $c->registrartrabajador($rut, $dni, $nombre, $apellido1, $apellido2, $nacimiento, $sexo, $civil, $nacionalidad, $discapacidad, $pension, $empresa);
        if ($result == true) {
            $id = $c->validartrabajador($rut, $empresa);
            $_SESSION['TRABAJADOR_ID'] = $id;
            $c->registrardomicilio($calle,$villa, $numero, $departamento, $region, $comuna, $ciudad, $id);
            $c->registrarcontacto($telefono, $correo, $id);
            //$c->registrartrabajadorcargo($id, $centrocosto, $cargo, $cargodescripcion, $tipocontrato, $desde, $hasta, $jornada, $horaspactadas);
            //$c->registrartrabajadorremuneracion($id, $tiposueldo, $sueldo, $asignacion);
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Registro el Trabajador : " . $nombre . " con el Rut: " . $rut;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
} else {
    echo "No se han recibido los datos";
}
