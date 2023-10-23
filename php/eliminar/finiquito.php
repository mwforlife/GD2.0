<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscaridcontratofiniquito($id);
    if($contrato!=false){
        $c->query("update contratos set estado = 1, fechatermino='' where id = $contrato;");
        $c->eliminardetallefiniquito($id);
        $result = $c->eliminarfiniquito($id);
        if($result==true){
        echo 1;
        }else{
            echo 0;
        }
    }
}