<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_SESSION['USER_ID'])  && isset($_POST['empresa']) && isset($_POST['clausulas'])){
    $usuario = $_SESSION['USER_ID'];
    $empresa = $_POST['empresa'];
    $clausulas = $_POST['clausulas'];

    $lista = $c->buscarloteanexo($usuario);
    foreach ($lista as $object) {
        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        $trabajadorid = $contrato->getFecharegistro();
        $contrato = $object->getId();
        $res = $c->registraraenxo($contrato, $tipocontratoid, $fechaanexo, $trabajadorid, $empresa);
        if ($res>0) {
            foreach($clausulas as $clausula){
                $c->query("insert into clausulasanexo (anexo, clausula) values ($res, $clausula);");
            }
        }
    }
    $c->eliminartodoloteanexo($usuario);
    echo 1;
} else {
    echo "Error al procesar la solicitud";
}
