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

if(isset($_SESSION['EMPRESA_ID'])){
$id = $_SESSION['EMPRESA_ID'];
$lista = $c->listarRepresentantelegal($id);
if (count($lista) > 0) {
    foreach ($lista as $codigo) {
        echo "<tr>";
        echo "<td>" . $codigo->getRut() . "</td>";
        echo "<td>" . $codigo->getNombre() . "</td>";
        echo "<td>" . $codigo->getApellido1() . " " .$codigo->getApellido2(). "</td>";
        echo "<td><a href='#' class='btn btn-outline-danger btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Eliminar' onclick='EliminarRepresentante(" . $codigo->getId() . ")'><i class='fa fa-trash'></i> </a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr>";
    echo "<td colspan='4' class='text-center'>No hay Representante Legal Registrados</td>";
    echo "</tr>";
}
}else if(isset($_SESSION['EMPRESA_EDIT'])){
$id = $_SESSION['EMPRESA_EDIT'];
$lista = $c->listarRepresentantelegal($id);
if (count($lista) > 0) {
    foreach ($lista as $codigo) {
        echo "<tr>";
        echo "<td>" . $codigo->getRut() . "</td>";
        echo "<td>" . $codigo->getNombre() . "</td>";
        echo "<td>" . $codigo->getApellido1() . " " .$codigo->getApellido2(). "</td>";
        echo "<td><a href='#' class='btn btn-outline-danger btn-sm rounded-11 mr-2' data-toggle='tooltip'  data-original-title='Eliminar' onclick='EliminarRepresentante(" . $codigo->getId() . ")'><i class='fa fa-trash'></i> </a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr>";
    echo "<td colspan='4' class='text-center'>No hay Representante Legal Registrados</td>";
    echo "</tr>";
}
}