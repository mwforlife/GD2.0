<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_SESSION['USER_ID'])  && isset($_POST['tipocontratoid'])  && isset($_POST['empresa']) && isset($_POST['fechafiniquito']) && isset($_POST['fechatermino']) && isset($_POST['causal'])) {
    $usuario = $_SESSION['USER_ID'];
    $tipocontratoid = $_POST['tipocontratoid'];
    $trabajadorid = $_POST['trabajadorid'];
    $empresa = $_POST['empresa'];
    $fechafiniquito = $_POST['fechafiniquito'];
    $fechatermino = $_POST['fechatermino'];
    $causal = $_POST['causal'];

    $resum = $c->listarresumenfiniquitoids($usuario);

    $lista = $c->buscarlotefiniquito($usuario);
    foreach ($lista as $object) {
        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        $trabajadorid = $contrato->getFecharegistro();
        $contrato = $object->getId();
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
            }
        }
    }
    $sql = "delete from resumenfiniquito where usuario = $usuario;";
    $result = $c->query($sql);
    $c->eliminartodolotefiniquito($usuario);
    echo 1;
} else {
    echo "Error al registrar finiquito";
}
