<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['tipo']) && isset($_POST['trabajadorid']) && isset($_POST['empresa']) && isset($_POST['anotacion'])){
    $tipo = $_POST['tipo'];
    if($tipo <=0){
        echo "Error: Tipo de anotación no válido";
        return;
    }
    $trabajadorid = $_POST['trabajadorid'];
    if($trabajadorid <=0){
        echo "Error: Trabajador no válido";
        return;
    }
    $empresa = $_POST['empresa'];
    if($empresa <=0){
        echo "Error: Empresa no válida";
        return;
    }
    $anotacion = $_POST['anotacion'];
    if($anotacion == ""){
        echo "Error: Anotación no válida";
        return;
    }
    $result = $c->registraranotacion($trabajadorid, $empresa,$tipo ,$anotacion);
    if($result==true){
        echo 1;
    }else{
        echo 0;
    }
}