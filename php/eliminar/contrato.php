<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarcontratoid($id);
    if($contrato!=null){
        $c->eliminarcontrato($id);
        unlink("../../uploads/Contratos/".$contrato->getDocumento());
    }
    $result = $c->eliminarcontrato($id);
    if($result==true){
        echo 1;
    }else{
        echo 0;
    }
}