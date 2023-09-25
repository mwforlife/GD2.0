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
$id = $_POST['id'];
$usuarios = $c->getuser1($id);
if ($usuarios!=null) {
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<label>Nombre</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getNombre()."' readonly>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<label>Apellido</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getApellido()."' readonly>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<label>Correo</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getCorreo()."' readonly>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<label>Dirección</label>";
    echo "<input type='text' class='form-control' value=\"".$usuarios->getDireccion()."\" readonly>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<label>Región</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getRegion()."' readonly>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<label>Comuna</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getComuna()."' readonly>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<label>Teléfono</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getTelefono()."' readonly>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<label>Estado</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getEstado()."' readonly>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<label>Fecha de Registro</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getRegistro()."' readonly>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<label>Ultima Actualización</label>";
    echo "<input type='text' class='form-control' value='".$usuarios->getUpdate()."' readonly>";
    echo "</div>";
    echo "</div>";
}