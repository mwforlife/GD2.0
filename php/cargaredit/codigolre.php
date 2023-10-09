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

$isapre = $c->buscarcodigolre($id);

if ($isapre != null) {
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<label>Articulo</label>";
    echo "<input type='text' class='form-control' id='articuloco' value='" . $isapre->getArticulo() . "' placeholder='Ingrese un Articulo'/>";
    echo "</div>";

    echo "<div class='col-md-12'>";
    echo "<label>Codigo (DT)</label>";
    echo "<input type='text' class='form-control' id='codigodt' value='" . $isapre->getCodigo() . "' placeholder='Ingrese el Codigo DT'/>";
    echo "</div>";

    echo "<div class='col-md-12'>";
    echo "<label>Codigo (PREVIRED)</label>";
    echo "<input type='text' class='form-control' id='codigoprevi' value='" . $isapre->getCodigoPrevired() . "' placeholder='Ingrese el Codigo previred'/>";
    echo "</div>";

    echo "<div class='col-md-12'>";
    echo "<label>Descripcion</label>";
    echo "<input type='text' class='form-control' id='descripcionco' value='" . $isapre->getDescripcion() . "' placeholder='Ingrese una descripcion'/>";
    echo "</div>";

    echo "<div class='col-md-12 text-right mt-3'>";
    echo "<button class='btn btn-primary' onclick='Actualizarcodigolre(" . $isapre->getId() . ")'> <i class='fa fa-refresh'></i> Actualizar</button>";
    echo "</div>";

    echo "</div>";
} else {
    echo "<div class='alert alert-danger'>No se encontro la Comuna</div>";
}
