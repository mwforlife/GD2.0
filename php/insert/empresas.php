<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: lockscreen.php");
    }
}


if (isset($_POST['EnterpriseRut']) && isset($_POST['EnterpriseNombre']) && isset($_POST['Enterprisecalle']) && isset($_POST['Enterprisevilla']) && isset($_POST['Enterprisenumero']) && isset($_POST['Enterprisedept']) && isset($_POST['EnterpriseRegion']) && isset($_POST['EnterpriseComuna']) && isset($_POST['EnterpriseCiudad']) && isset($_POST['EnterpriseTelefono']) && isset($_POST['EnterpriseCorreo']) && isset($_POST['EnterpriseGire']) && isset($_POST['EnterpriseCaja']) && isset($_POST['EnterpriseMutual']) && isset($_POST['EnterpriseCotizacionB']) && isset($_POST['EnterpriseCotizacionL']) && isset($_POST['EnterpriseCotizacionC']) && isset($_POST['plan'])) {
    $EnterpriseRut = $_POST['EnterpriseRut'];
    if (strlen($EnterpriseRut) <= 0) {
        echo "El rut no puede estar vacio";
        return;
    }
    $EnterpriseNombre = $_POST['EnterpriseNombre'];
    if (strlen($EnterpriseNombre) <= 0) {
        echo "El nombre no puede estar vacio";
        return;
    }
    $EnterpriseNombre = $c->escapeString($EnterpriseNombre);
    $EnterpriseNombre = strtoupper($EnterpriseNombre);
    $Enterprisecalle = $_POST['Enterprisecalle'];
    if (strlen($Enterprisecalle) <= 0) {
        echo "La calle no puede estar vacia";
        return;
    }
    $Enterprisecalle = $c->escapeString($Enterprisecalle);
    $Enterprisecalle = strtoupper($Enterprisecalle);
    $Enterprisenumero = $_POST['Enterprisenumero'];
    if (strlen($Enterprisenumero) <= 0) {
        echo "El numero no puede estar vacio";
        return;
    }
    $Enterprisevilla = $_POST['Enterprisevilla'];
    $Enterprisenumero = $c->escapeString($Enterprisenumero);
    $Enterprisenumero = strtoupper($Enterprisenumero);
    $Enterprisedept = $_POST['Enterprisedept'];
    $Enterprisedept = $c->escapeString($Enterprisedept);
    $Enterprisedept = strtoupper($Enterprisedept);
    $EnterpriseRegion = $_POST['EnterpriseRegion'];
    if ($EnterpriseRegion < 1) {
        echo "La region no puede estar vacia";
        return;
    }
    $EnterpriseComuna = $_POST['EnterpriseComuna'];
    if ($EnterpriseComuna < 1) {
        echo "La comuna no puede estar vacia";
        return;
    }
    $EnterpriseCiudad = $_POST['EnterpriseCiudad'];
    if ($EnterpriseCiudad < 1) {
        echo "La ciudad no puede estar vacia";
        return;
    }
    $EnterpriseTelefono = $_POST['EnterpriseTelefono'];
    if (strlen($EnterpriseTelefono) <= 0) {
        echo "El telefono no puede estar vacio";
        return;
    }
    $EnterpriseTelefono = $c->escapeString($EnterpriseTelefono);
    $EnterpriseCorreo = $_POST['EnterpriseCorreo'];
    if (strlen($EnterpriseCorreo) <= 0) {
        echo "El correo no puede estar vacio";
        return;
    }
    $EnterpriseCorreo = $c->escapeString($EnterpriseCorreo);
    $EnterpriseGire = $_POST['EnterpriseGire'];
    if (strlen($EnterpriseGire) <= 0) {
        echo "El giro no puede estar vacio";
        return;
    }
    $EnterpriseGire = $c->escapeString($EnterpriseGire);
    $EnterpriseGire = strtoupper($EnterpriseGire);
    $EnterpriseCaja = $_POST['EnterpriseCaja'];
    if ($EnterpriseCaja < 1) {
        echo "La caja de compensacion no puede estar vacia";
        return;
    }
    $EnterpriseMutual = $_POST['EnterpriseMutual'];
    if ($EnterpriseMutual < 1) {
        echo "La mutual no puede estar vacia";
        return;
    }
    $EnterpriseCotizacionB = $_POST['EnterpriseCotizacionB'];
    if ($EnterpriseCotizacionB <= 0) {
        echo "La cotizacion base no puede estar vacia";
        return;
    }
    $EnterpriseCotizacionB = floatval($EnterpriseCotizacionB);
    $EnterpriseCotizacionL = $_POST['EnterpriseCotizacionL'];
    if ($EnterpriseCotizacionL <= 0) {
        echo "La cotizacion limite no puede estar vacia";
        return;
    }
    $EnterpriseCotizacionL = floatval($EnterpriseCotizacionL);
    $EnterpriseCotizacionC = $_POST['EnterpriseCotizacionC'];
    $EnterpriseCotizacionC = floatval($EnterpriseCotizacionC);
    $plan = 0;
    if(isset($_POST['plan'])){
        $plan = $_POST['plan'];
    }else{
        echo "Debe seleccionar un plan";
        return;
    }


    if (isset($_SESSION['EMPRESA_EDIT'])) {
        $EnterpriseId = $_SESSION['EMPRESA_EDIT'];
        $result = $c->actualizarEmpresa($EnterpriseId, $EnterpriseRut, $EnterpriseNombre, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $EnterpriseRegion, $EnterpriseComuna, $EnterpriseCiudad, $EnterpriseTelefono, $EnterpriseCorreo, $EnterpriseGire, $EnterpriseCaja, $EnterpriseMutual, $EnterpriseCotizacionB, $EnterpriseCotizacionL, $EnterpriseCotizacionC);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la empresa " . $EnterpriseNombre . " con RUT " . $EnterpriseRut . " en el sistema";
            $emp = $c->BuscarEmpresaporRut($EnterpriseRut);
            $id = $emp->getId();
            $plani = $c->buscarplanempresa($id);
            if($plani==null){
                $c->asignarplan($id, $plan);
            }else{
                $c->actualizarplan($id, $plan);
            }  
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }
    } else {
        $valid = $c->validarEmpresa($EnterpriseRut);
        if ($valid == true) {
            echo 2;
        } else {
            $result = $c->RegistrarEmpresa($EnterpriseRut, $EnterpriseNombre, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $EnterpriseRegion, $EnterpriseComuna, $EnterpriseCiudad, $EnterpriseTelefono, $EnterpriseCorreo, $EnterpriseGire, $EnterpriseCaja, $EnterpriseMutual, $EnterpriseCotizacionB, $EnterpriseCotizacionL, $EnterpriseCotizacionC);
            if ($result == true) {
                echo 1;
                $usuario = $_SESSION['USER_ID'];
                $eventos = "Se Registro la empresa " . $EnterpriseNombre . " con RUT " . $EnterpriseRut . " en el sistema";
                $emp = $c->BuscarEmpresaporRut($EnterpriseRut);
                $id = $emp->getId();
                $c->asignarplan($id, $plan);        
                $_SESSION['EMPRESA_ID'] = $id;
                $c->RegistrarAuditoriaEventos($usuario, $eventos);
            } else {
                echo 0;
            }
        }
    }
}
