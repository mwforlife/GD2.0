<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    echo 0;
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        echo 0;
    }
}
if(isset($_POST['EMPRESAID'])){
    $id = $_POST['EMPRESAID'];
    $lista = $c->ListarCodigoActividadEmpresa($id);
    if (count($lista) > 0) {
        foreach ($lista as $codigo) {
            echo "<tr>";
            echo "<td>" . $codigo->getCodigoSii() . "</td>";
            echo "<td>" . $codigo->getNombre() . "</td>";
            echo "<td><a href='#' class='btn btn-outline-danger btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Eliminar' onclick='EliminarCodigoActividad(" . $codigo->getId() . ")'><i class='fa fa-trash'></i> </a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan='3' class='text-center'>No hay códigos de actividad</td>";
        echo "</tr>";
    }
}else if(isset($_SESSION['EMPRESA_ID'])){
    $id = $_SESSION['EMPRESA_ID'];
    $lista = $c->ListarCodigoActividadEmpresa($id);
    if (count($lista) > 0) {
        foreach ($lista as $codigo) {
            echo "<tr>";
            echo "<td>" . $codigo->getCodigoSii() . "</td>";
            echo "<td>" . $codigo->getNombre() . "</td>";
            echo "<td><a href='#' class='btn btn-outline-danger btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Eliminar' onclick='EliminarCodigoActividad(" . $codigo->getId() . ")'><i class='fa fa-trash'></i> </a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan='3' class='text-center'>No hay códigos de actividad</td>";
        echo "</tr>";
    }
}