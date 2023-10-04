<?php
require '../controller.php';
$c = new Controller();
session_start();

$empresa = $_SESSION['CURRENT_ENTERPRISE'];
if (isset($_SESSION['USER_ID'])  && isset($_POST['empresa']) && isset($_POST['clausulas']) && isset($_POST['fechageneracion']) && isset($_POST['base']) && isset($_POST['sueldo'])) {

    $usuario = $_SESSION['USER_ID'];
    $lista = $c->buscarloteanexo($usuario, $empresa);
    if (count($lista) == 0) {
        echo "Debe seleccionar al menos un contrato";
        return;
    }
    $fechageneracion = $_POST['fechageneracion'];
    $empresa = $_POST['empresa'];
    
    if ($empresa == 0) {
        echo "Debe seleccionar una empresa";
        return;
    }

    $clausulas = $_POST['clausulas'];
    if (count($clausulas) == 0) {
        echo "Debe seleccionar al menos una clausula";
        return;
    }

    $base = $_POST['base'];
    $sueldo = $_POST['sueldo'];

    if($base == 1){
        if($sueldo == 0){
            echo "Debe ingresar un sueldo";
            return;
        }
    }else{
        $sueldo = 0;
    }

    $lista = $c->buscarloteanexo($usuario, $empresa);
    foreach ($lista as $object) {
        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        $trabajadorid = $contrato->getFecharegistro();
        $contrato = $object->getId();
        $res = $c->registraraenxo($contrato,$fechageneracion,$base, $sueldo, 1);
        if($base==1){
            $c->query("update contratos set sueldo = $sueldo where id = $contrato;");
        }
        if ($res>0) {
            foreach($clausulas as $clausula){
                $clau = $clausula['clausula'];
                $plantilla = $clausula['tipodocumentoid'];
                $c->query("insert into clausulasanexos (anexo, clausula, tipodocumento) values ($res, '$clau',$plantilla);");
            }
        }
    }
    $c->eliminartodoloteanexo($usuario, $empresa);
    echo 1;
} else {
    echo "Error al procesar la solicitud";
}
