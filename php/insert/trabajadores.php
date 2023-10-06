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
    $trabajador = $c->buscartrabajadorbyRut($rut);
    $empeladoid = 0;
    if($trabajador!=false){
        $empeladoid = $trabajador->getId();
    }
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
            if($empeladoid>0){
                $previsiones = $c->buscarprevisiones($empeladoid);
                $cuentas = $c->listarcuentasbancarias($empeladoid);
                if(count($previsiones)>0){
                    foreach($previsiones as $prevision){
                        $c->insertarprevision($prevision->getPeriodo(), $prevision->getAfp(), $prevision->getJubilado(), $prevision->getCesantia(), $prevision->getSeguro(), $prevision->getPeriodocesantia(), $prevision->getIsapre(), $prevision->getMonedapacto(), $prevision->getMonto(), $prevision->getTipoges(), $prevision->getGes(), $id, $prevision->getComentario(), $prevision->getDocumentoafp(), $prevision->getDocumentosalud(), $prevision->getDocumentojubilacion());
                    }
                }
                if(count($cuentas)>0){
                    foreach($cuentas as $cuenta){
                        $c->registrarcuentabancaria($cuenta->getBanco(), $cuenta->getTipo(), $cuenta->getNumero(), $id);
                    }
                }
            }
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
