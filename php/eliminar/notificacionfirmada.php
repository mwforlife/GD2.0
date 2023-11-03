<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarnotificacionfirmada1($id);
    if($contrato!=false){
        $c->eliminarnotificacionfirmada($id);
        //Eliminar el archivo si existe
        if(file_exists('../../uploads/documentosfirmados/'.$contrato->getDocumento())){
            unlink('../../uploads/documentosfirmados/'.$contrato->getDocumento());
        }

        //Eliminar la carta si existe
        if(file_exists('../../'.$contrato->getCarta())){
            unlink('../../uploads/documentosfirmados/'.$contrato->getCarta());
        }

        echo json_encode(array('status'=>true,'message'=>'Notificacion Eliminada'));
    }else{
        echo json_encode(array('status'=>false,'message'=>'Ups! No se encontro la notificacion'));
    }
    
}