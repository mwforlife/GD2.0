<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $finiquito = $c->buscarfiniquitotext($id);
    if ($finiquito == false) {
        echo "<div class='col-md-12'><div class='alert alert-danger' role='alert'>No se encontro el registro</div></div>";
    } else {
        /*<div class="col-lg-6 mt-1">
        <label for="">Fecha Finiquito:</label>
        <input type="date" class="form-control text-dark" id="fechafiniquito" name="fechafiniquito" required="">

        </div>
        <div class="col-lg-6 mt-1">
            <label for="">Fecha Ingreso:</label>
            <input type="date" class="form-control text-dark" id="fechainicio" name="fechainicio" required="" readonly>

        </div>
        <div class="col-lg-6 mt-1">
            <label for="">Fecha de Termino de relacion laboral:</label>
            <input type="date" class="form-control text-dark" id="fechatermino" name="fechaingreso" required="">
        </div>*/
        echo "<div class='col-md-6 mt-1'>
        <label for=''>Fecha Finiquito:</label>
        <input type='date' class='form-control text-dark' id='fechafiniquito' name='fechafiniquito'readonly ' value='" . $finiquito->getFechafiniquito() . "'>
        </div>
        <div class='col-md-6 mt-1'>
        <label for=''>Fecha Ingreso:</label>
        <input type='date' class='form-control text-dark' id='fechainicio' name='fechainicio'  readonly value='" . $finiquito->getFechainicio() . "'>
        </div>
        <div class='col-md-6 mt-1'>
        <label for=''>Fecha de Termino de relacion laboral:</label>
        <input type='date' class='form-control text-dark' id='fechatermino' name='fechatermino' readonly value='" . $finiquito->getFechatermino() . "'>
    </div>";
    }
}
