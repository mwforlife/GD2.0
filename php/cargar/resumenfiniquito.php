<?php
require '../controller.php';
$c = new Controller();
session_start();
if (isset($_SESSION['USER_ID'])) {
    $id = $_SESSION['USER_ID'];
    $result = $c->listarresumenfiniquito($id);
    $haberes = 0;
    $descuentos = 0;
    $saldo = 0;
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered table-striped table-hover" >';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Tipo</th>';
    echo '<th>Descripción</th>';
    echo '<th>Monto</th>';
    echo '<th>Acciones</th>';
    echo '</tr>';
    echo '</thead>';
    echo "<tbody>";
    if (count($result) == 0) {
    } else {
        foreach ($result as $res) {
            echo "<tr>";
            echo "<td>" . $res->getIndemnizacion() . "</td>";
            echo "<td>" . $res->getDescripcion() . "</td>";
            //Imprimir monto con separador de miles
            $monto = number_format($res->getMonto(), 0, ',', '.');
            echo "<td>$" . $monto . "</td>";
            echo "<td><button type='button' class='btn btn-danger' onclick='eliminar(" . $res->getId() . ")'><i class='fa fa-trash'></i></button></td>";
            echo "</tr>";
            if ($res->getTipo() == 1) {
                $descuentos = $descuentos + $res->getMonto();
            } else {
                $haberes = $haberes + $res->getMonto();
            }
        }
    }
    $saldo = $haberes - $descuentos;
    $saldo = number_format($saldo, 0, ',', '.');
    $haberes = number_format($haberes, 0, ',', '.');
    $descuentos = number_format($descuentos, 0, ',', '.');
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo "<div class='row justify-content-end'>";
    echo "<div class='col-md-2'>";
    echo "<p>Total Haberes:</p>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<p>$ $haberes</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='row justify-content-end'>";
    echo "<div class='col-md-2'>";
    echo "<p>Total Descuentos:</p>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<p>$ $descuentos</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='row justify-content-end'>";
    echo "<div class='col-md-2'>";
    echo "<p>Saldo:</p>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<p>$ $saldo</p>";
    echo "</div>";
    echo "</div>";
}
