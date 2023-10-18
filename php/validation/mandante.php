<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['empresa']) && isset($_POST['usuario'])){
$id = $_POST['empresa'];
$usuario = $_POST['usuario'];
$lista = $c->listarcentrocosto($id);
if (count($lista) > 0) {
    foreach ($lista as $object) {
        echo "<tr>";
        echo "<td>" . $object->getCodigo() . "</td>";
        echo "<td>" . $object->getCodigoPrevired() . "</td>";
        echo "<td>" . $object->getNombre() . "</td>";
        echo "<td class='text-center'>";
        if ($c->validarcentrocosto($usuario, $object->getId()) == true) {
            echo "<a href='#' class='btn btn-success btn-sm' onclick='revocar($usuario," . $object->getId() . ")'><i class='fa fa-check'></i></a>";
        } else {
            echo "<a href='#' class='btn btn-danger btn-sm' onclick='asignar($usuario," . $object->getId() . ")'><i class='fa fa-times'></i></a>";
        }
        echo "</td>";
        echo "</tr>";
    }
}else{
    echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
}
}else{
    echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
}

?>