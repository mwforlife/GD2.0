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

if (isset($_POST['EnterpriseRut']) && isset($_POST['EnterpriseNombre']) && isset($_POST['EnterpriseDireccion']) && isset($_POST['EnterpriseRegion']) && isset($_POST['EnterpriseComuna']) && isset($_POST['EnterpriseCiudad']) && isset($_POST['EnterpriseTelefono']) && isset($_POST['EnterpriseCorreo']) && isset($_POST['EnterpriseGire']) && isset($_POST['EnterpriseCaja']) && isset($_POST['EnterpriseMutual']) && isset($_POST['EnterpriseCotizacionB']) && isset($_POST['EnterpriseCotizacionL']) && isset($_POST['EnterpriseCotizacionC'])) {
    $EnterpriseRut = $_POST['EnterpriseRut'];
    $EnterpriseNombre = $_POST['EnterpriseNombre'];
    $EnterpriseNombre = $c->escapeString($EnterpriseNombre);
    $EnterpriseNombre = strtoupper($EnterpriseNombre);
    $EnterpriseDireccion = $_POST['EnterpriseDireccion'];
    $EnterpriseDireccion = $c->escapeString($EnterpriseDireccion);
    $EnterpriseDireccion = strtoupper($EnterpriseDireccion);
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
    $EnterpriseTelefono = $c->escapeString($EnterpriseTelefono);
    $EnterpriseCorreo = $_POST['EnterpriseCorreo'];
    $EnterpriseCorreo = $c->escapeString($EnterpriseCorreo);
    $EnterpriseGire = $_POST['EnterpriseGire'];
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
    $EnterpriseCotizacionB = floatval($EnterpriseCotizacionB);
    $EnterpriseCotizacionL = $_POST['EnterpriseCotizacionL'];
    $EnterpriseCotizacionL = floatval($EnterpriseCotizacionL);
    $EnterpriseCotizacionC = $_POST['EnterpriseCotizacionC'];
    $EnterpriseCotizacionC = floatval($EnterpriseCotizacionC);

    $valid = $c->validarEmpresa($EnterpriseRut);
    if ($valid == true) {
        echo 2;
    } else {
        $result = $c->RegistrarEmpresa($EnterpriseRut, $EnterpriseNombre, $EnterpriseDireccion, $EnterpriseRegion, $EnterpriseComuna, $EnterpriseCiudad, $EnterpriseTelefono, $EnterpriseCorreo, $EnterpriseGire, $EnterpriseCaja, $EnterpriseMutual, $EnterpriseCotizacionB, $EnterpriseCotizacionL, $EnterpriseCotizacionC);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
