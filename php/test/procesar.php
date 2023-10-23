<?php
require '../controller.php';
$c = new Controller();
session_start();
$lista = $c->listarhaberesdescuentos1($_SESSION['CURRENT_ENTERPRISE']);
echo "<table style='width:100%; border: 1px solid black;'>";
echo "<tr>";
echo "<td>Periodo</td>";
echo "<td>Trabajador</td>";
echo "<td>Codigo</td>";
echo "<td>Tipo</td>";
echo "<td>Modalidad</td>";
echo "<td>Monto</td>";
echo "<td>Acciones</td>";
echo "</tr>";
foreach ($lista as $object) {
    echo "<tr>";
    $periodoinit = date("Y-m", strtotime($object->getPeriodoini()));
    $mesinit = date("m", strtotime($object->getPeriodoini()));
    $anoinit = date("Y", strtotime($object->getPeriodoini()));
    $periodofin = date("Y-m", strtotime($object->getPeriodofin()));
    $mesfin = date("m", strtotime($object->getPeriodofin()));
    $anofin = date("Y", strtotime($object->getPeriodofin()));
    echo "<td>" . $mesinit . " " . $anoinit . " - " . $mesfin . " " . $anofin . "</td>";
    echo "<td>" . $object->getTrabajador() . "</td>";
    echo "<td>" . $object->getCodigo() . "</td>";
    if ($object->getTipo() == 1) {
        echo "<td>HABER</td>";
    } else {
        echo "<td>DESCUENTO</td>";
    }
    if ($object->getModalidad() == 1) {
        echo "<td>FIJO</td>";
    } else {
        echo "<td>PROPORCIONAL</td>";
    }
    if ($object->getMonto() > 0) {
        echo "<td>" . $object->getMonto() . "</td>";
    } else if ($object->getDias() > 0) {
        echo "<td>" . $object->getDias() . " Dias</td>";
    } else {
        echo "<td>" . $object->getHoras() . " Horas</td>";
    }
    echo "<td><a class='btn btn-outline-danger' href='#' onclick='eliminarhabertrabajador(" . $object->getId() . ")'><i class='fa fa-trash'></i></a></td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><br>";


$formulas = $c->listarformulas();
echo "<table style='width:100%; border: 1px solid black;'>";
echo "<tr>";
echo "<td>Codigo</td>";
echo "<td>Nombre</td>";
echo "<td>Representacion</td>";
echo "<td>Formula</td>";
echo "<td>Acciones</td>";
echo "</tr>";

$formulitas = array();

foreach ($formulas as $formula) {
    echo "<tr>";
    echo "<td>" . $formula->getCodigo() . "</td>";
    echo "<td>" . $formula->getNombre() . "</td>";
    echo "<td>" . $formula->getRepresentacion() . "</td>";
    echo "<td>" . $formula->getFormula() . "</td>";
    echo "<td><button type='button' class='btn btn-outline-primary btn-sm' onclick='utilizar(\"" . $formula->getRepresentacion() . "\")'><i class='fa fa-plus'></i></button></td>";
    echo "<td>";
    echo "<button type='button' class='btn btn-outline-danger btn-sm' onclick='eliminar(" . $formula->getId() . ")'><i class='fa fa-trash'></i></button>";
    echo "</td>";
    echo "</tr>";

    $formula1 = $formula->getFormula();
    // Parseo de la fórmula
    $pattern = '/\{([^;]+);ID:(\d+)\}/';
    $formula1 = preg_replace_callback($pattern, function ($matches) {
        $representacion = $matches[1];
        $id = $matches[2];

        $formulitas[] = array(
            'id' => $id,
            'representacion' => $representacion
        );

        return $formulitas;

    }, $formula1);
}
echo "</table>";
   