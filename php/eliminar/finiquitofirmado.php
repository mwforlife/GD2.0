<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarfiniquitofirmado1($id);
    if($contrato!=false){
        $c->eliminarfiniquitofirmado($id);
        //Eliminar el archivo si existe
        if(file_exists('../../uploads/documentosfirmados/'.$contrato->getDocumento())){
            unlink('../../uploads/documentosfirmados/'.$contrato->getDocumento());
        }
        echo json_encode(array('status'=>true,'message'=>'Finiquito eliminado'));
    }else{
        echo json_encode(array('status'=>false,'message'=>'Ups! No se encontro el finiquito'));
    }
    
}