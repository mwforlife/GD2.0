<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscaridcontratofiniquito($id);
    if($contrato!=false){
        $c->query("update contratos set estado = 1, fechatermino='' where id = $contrato;");
        $c->eliminardetallefiniquito($id);
        $c->eliminarfiniquito($id);
        echo 1;
    }
}