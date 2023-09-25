<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_SESSION['USER_ID']) && isset($_POST['contrato']) && isset($_POST['tipocontratoid']) && isset($_POST['trabajadorid'])  && isset($_POST['empresa']) && isset($_POST['fechafiniquito']) && isset($_POST['fechainicio']) && isset($_POST['fechatermino']) && isset($_POST['causal']) && isset($_POST['descripcion']) && isset($_POST['monto'])) {
    $usuario = $_SESSION['USER_ID'];
    $contrato = $_POST['contrato'];
    $tipocontratoid = $_POST['tipocontratoid'];
    $trabajadorid = $_POST['trabajadorid'];
    $empresa = $_POST['empresa'];
    $fechafiniquito = $_POST['fechafiniquito'];
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = $_POST['fechatermino'];
    $causal = $_POST['causal'];
    
    $resum = $c->listarresumenfiniquitoids($usuario);

    $sql = "insert into finiquito values(null, $contrato, $tipocontratoid, '$fechafiniquito', '$fechainicio', '$fechatermino', $causal, $trabajadorid, $empresa,now());";
    $result = $c->query($sql);
    if ($result == true) {
        $fin = $c->buscarultimoidfiniquito($trabajadorid);
        if ($fin != false) {
            foreach ($resum as $res) {
                $indemnizacion = $res->getIndemnizacion();
                $descripcion = $res->getDescripcion();
                $monto = $res->getMonto();
                $tipo = $res->getTipo();
                $sql = "insert into detallefiniquito values(null, $indemnizacion, $tipo, '$descripcion', $monto, $fin);";
                $result = $c->query($sql);
            }
            $sql = "update contratos set estado = 2, fechatermino='$fechatermino' where id = $contrato;";
            $result = $c->query($sql);
            $sql = "delete from resumenfiniquito where usuario = $usuario;";
            $result = $c->query($sql);
            echo 1;
        } else {
            echo "Error al registrar finiquito";
        }
    } else {
        echo "Error al registrar finiquito";
    }
} else {
    echo "Error al registrar finiquito";
}
