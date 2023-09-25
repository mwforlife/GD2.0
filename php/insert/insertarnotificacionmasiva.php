<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_SESSION['USER_ID']) && isset($_POST['tipocontratoid']) && isset($_POST['causal']) && isset($_POST['causalhechos']) && isset($_POST['comunicacion']) && isset($_POST['cotipre']) && isset($_POST['acreditacion']) && isset($_POST['fechanotificacion']) && isset($_POST['texto'])) {
    $usuario = $_SESSION['USER_ID'];
    $fechanotificacion = $_POST['fechanotificacion'];
    $tipocontratoid = $_POST['tipocontratoid'];
    if($tipocontratoid==0){
        echo "Debe seleccionar un tipo de Documento";
        return;
    }
    $causal = $_POST['causal'];
    if($causal<=0){
        echo "Debe seleccionar una causal";
        return;
    }
    $causalhechos = $_POST['causalhechos'];
    if($causalhechos==""){
        echo "Debe ingresar el causal de hechos";
        return;
    }
    $causalhechos = $c->escapeString($causalhechos);
    $comunicacion = $_POST['comunicacion'];
    $comuna="";
    if($comunicacion==2){
        $comuna = $_POST['comuna'];
        if($comuna<=0){
            echo "Debe seleccionar una comuna";
            return;
        }
        $comuna = $c->buscarcomuna($comuna);
        $comuna = $comuna->getNombre();
    }
    $cotipre = $_POST['cotipre'];
    if(strlen($cotipre)<=0){
        echo "Debe ingresar la Informacion de Cotizaciones Previsionales";
        return;
    }
    $cotipre = $c->escapeString($cotipre);

    $acreditacion = $_POST['acreditacion'];
    if(strlen($acreditacion)<=0){
        echo "Debe Elegir una opcion de Acreditacion de pago Previsional";
        return;
    }
    $texto = $_POST['texto'];
    if (strlen($texto) <= 0) {
        echo "Debe ingresar el texto de la notificacion";
        return;
    }
    if ($texto == 1) {
        $texto = $_POST['texto1'];
    } else if ($texto == 2) {
        $texto = $_POST['texto2'];
    }


    $lista = $c->buscarlotenotifacion($usuario);
    foreach($lista as $object){
        $finiquito = $object->getId();
        $finiid= $finiquito;
        $finiquito = $c->buscarfiniquitotext($finiquito);
        $contrato = $c->buscarcontratoid($finiquito->getContrato());
        
        $sql = "insert into notificaciones values (null,'$fechanotificacion',$finiid,$tipocontratoid,$causal,'$causalhechos','$cotipre',$comunicacion,$acreditacion,'$comuna','$texto',now())";
        $result = $c->query($sql);
    }
    $c->eliminartodolotenotificacion($usuario);
    echo 1;   
    
}