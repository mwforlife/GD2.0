<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarcontratoid($id);
    if($contrato!=null){
        //Eliminar el archivo si existe
        if(file_exists("../../uploads/Contratos/".$contrato->getDocumento())){
            unlink("../../uploads/Contratos/".$contrato->getDocumento());
        }
    }
    $c->eliminarcontratohoraspactadas($id);
    $result = $c->eliminarcontrato($id);
    if($result==true){
        echo 1;
    }else{
        echo 0;
    }
}