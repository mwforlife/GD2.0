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

$empresa = $_SESSION['CURRENT_ENTERPRISE'];

$lista = $c->buscarloteanexo($_SESSION['USER_ID'], $empresa);
foreach ($lista as $object1) {
    echo "<tr class='border-bottom-0'>";
    echo "<td class='coin_icon d-flex fs-15 font-weight-semibold'>";
    $fecha = $object1->getFechainicio();
    //Convertir fecha en formato dd-mm-YYYY
    $fecha = date("d-m-Y", strtotime($fecha));
    
    echo $object1->getTipocontrato() . " - " . $fecha;
    echo "</td>";
    echo "<td class='text-muted fs-15 font-weight-semibold'>";
    echo $object1->getTrabajador();
    echo "</td>";
    echo "<td class='text-center'>";
    echo "<a class='btn btn-outline-danger btn-sm rounded-11' onclick='Eliminardelloteanexo(" . $object1->getEmpresa() . ")' data-toggle='tooltip' data-original-title='Eliminar Del Lote'>";
    echo "<i class='fa fa-trash'>";
    echo "</i>";
    echo "</a>";
    echo "</td>";
    echo "</tr>";
}
