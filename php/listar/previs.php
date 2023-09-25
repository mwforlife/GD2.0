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

if (isset($_SESSION['TRABAJADOR_ID'])) {
    $id = $_SESSION['TRABAJADOR_ID'];
    $prevision = $c->listarprevision($id);
    if (count($prevision) > 0) {
        foreach ($prevision as $p) {
            echo "<tr>";
            echo "<td>" . $p->getPeriodo() . "</td>";
            echo "<td>" . $p->getAfp() . "</td>";
            echo "<td>" . $p->getJubilado() . "</td>";
            echo "<td>" . $p->getCesantia() . "</td>";
            echo "<td>" . $p->getSeguro() . "</td>";
            echo "<td>" . $p->getPeriodoCesantia() . "</td>";
            echo "<td>" . $p->getIsapre() . "</td>";
            if ($p->getMonedapacto() == 1) {
                echo "<td>Pesos</td>";
            } else if ($p->getMonedapacto() == 2) {
                echo "<td>UF</td>";
            } else {
                echo  "<td>7%</td>";
            }
            echo "<td>" . $p->getMonto() . "</td>";
            if ($p->getTipoges() == 1) {
                echo "<td>Pesos</td>";
            } else if ($p->getTipoges() == 2) {
                echo "<td>UF</td>";
            } else {
                echo  "<td>No Aplica</td>";
            }
            echo "<td>" . $p->getGes() . "</td>";
            echo "<td>" . $p->getComentario() . "</td>";
            if ($p->getDocumento() == null) {
                echo "<td>No Aplica</td>";
            } else {
                echo "<td><a class='btn btn-outline-success btn-sm rounded-11' href='uploads/" . $p->getDocumento() . "' target='_blank'><i class='fa fa-file'></i></td>";
            }
            echo "</tr>";
        }
    }
}
