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

$isapre = $c->buscarhaberesydescuentos($id);

if ($isapre != null) {
    echo "<div class='row'>";

    echo "<div class='col-md-6'>";
    echo "<label>Codigo</label>";
    echo "<input type='text' class='form-control' id='codigoedit' value='" . $isapre->getCodigo() . "' placeholder='Ingrese el Codigo'/>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Descrpcion</label>";
    echo "<input type='text' class='form-control' id='descripcionedit' value='" . $isapre->getDescripcion() . "' placeholder='Ingrese la Descripcion'/>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Tipo</label>";
    echo "<select class='form-control' id='tipoedit'>";
    if ($isapre->getTipo() == 1) {
        echo "<option value='1' selected>Haber</option>";
        echo "<option value='2'>Descuento</option>";
    } else {
        echo "<option value='1'>Haber</option>";
        echo "<option value='2' selected>Descuento</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Imponible</label>";
    echo "<select class='form-control' id='imponibleedit'>";
    if ($isapre->getImponible()==1){
        echo "<option value='1' selected>Si</option>";
        echo "<option value='0'>No</option>";
    }else{
        echo "<option value='1'>Si</option>";
        echo "<option value='2' selected>No</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Tributable</label>";
    echo "<select class='form-control' id='tributableedit'>";
    if ($isapre->getTributable()==1){
        echo "<option value='1' selected>Si</option>";
        echo "<option value='0'>No</option>";
    }else{
        echo "<option value='1'>Si</option>";
        echo "<option value='2' selected>No</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Gratificacion</label>";
    echo "<select class='form-control' id='gratificacionedit'>";
    if ($isapre->getGratificacion()==1){
        echo "<option value='1' selected>Si</option>";
        echo "<option value='0'>No</option>";
    }else{
        echo "<option value='1'>Si</option>";
        echo "<option value='2' selected>No</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Reservado</label>";
    echo "<select class='form-control' id='reservadoedit'>";
    if ($isapre->getReservado()==1){
        echo "<option value='1' selected>Si</option>";
        echo "<option value='0'>No</option>";
    }else{
        echo "<option value='1'>Si</option>";
        echo "<option value='2' selected>No</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>LRE</label>";
    echo "<select class='form-control' id='lreedit'>";
    $codigo = $c->listarcodigoslre();
    foreach ($codigo as $object) {
        if ($object->getCodigo() == $isapre->getLre()) {
            echo "<option value='" . $object->getCodigo() . "' selected>" . $object->getDescripcion() . "  (Cód. " . $object->getCodigo() . ")</option>";
        } else {
            echo "<option value='" . $object->getCodigo() . "'>" . $object->getDescripcion() . " (Cód. " . $object->getCodigo() . ")</option>";
        }
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo "<label>Agrupacion</label>";
    echo "<select class='form-control' id='agrupacionedit'>";
    if($isapre->getAgrupacion()==1){
        echo "<option value='1' selected>Valor</option>";
        echo "<option value='2'>Horas</option>";
        echo "<option value='3'>Dias</option>";
    }else if($isapre->getAgrupacion()==2){
        echo "<option value='1'>Valor</option>";
        echo "<option value='2' selected>Horas</option>";
        echo "<option value='3'>Dias</option>";
    }else{
        echo "<option value='1'>Valor</option>";
        echo "<option value='2'>Horas</option>";
        echo "<option value='3' selected>Dias</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='col-md-12 text-right mt-3'>";
    echo "<button class='btn btn-primary' onclick='actualizarhaber(" . $isapre->getId() . ")'> <i class='fa fa-refresh'></i> Actualizar</button>";
    echo "</div>";

    echo "</div>";
} else {
    echo "<div class='alert alert-danger'>No se encontro la Comuna</div>";
}
