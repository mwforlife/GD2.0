<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $result = $c->listardetallefiniquito($id);
    $haberes=0;
    $descuentos=0;
    $saldo = 0;
    echo '<div class="table-responsive">';
        echo '<table class="table table-bordered table-striped table-hover" >';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Tipo</th>';
        echo '<th>Descripción</th>';
        echo '<th>Monto</th>';
        echo '</tr>';
        echo '</thead>';
        echo "<tbody>";
    if (count($result) == 0) {
    } else {
        foreach ($result as $res) {
            echo "<tr>";
            echo "<td>" . $res->getIndemnizacion() . "</td>";
            echo "<td>" . $res->getDescripcion() . "</td>";
            $monto = number_format($res->getMonto(), 0, ',', '.');
            echo "<td>" . $monto . "</td>";
            echo "</tr>";
            if($res->getTipo()==1){
                $descuentos = $descuentos + $res->getMonto();
            }else{
                $haberes = $haberes + $res->getMonto();
            }
        }

    }
    $saldo = $haberes - $descuentos;
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo "<div class='row justify-content-end'>";
    echo "<div class='col-md-2'>";
    echo "<p>Total Haberes:</p>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<p>$haberes</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='row justify-content-end'>";
    echo "<div class='col-md-2'>";
    echo "<p>Total Descuentos:</p>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<p>$descuentos</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='row justify-content-end'>";
    echo "<div class='col-md-2'>";
    echo "<p>Saldo:</p>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<p>$saldo</p>";
    echo "</div>";
    echo "</div>";


}
