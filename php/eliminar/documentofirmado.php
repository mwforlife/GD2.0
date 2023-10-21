<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarotrosdocumentosfirmadosid($id);
    if($contrato!=false){
        $c->eliminarotrosdocumentosfirmados($id);
        //Eliminar el archivo si existe
        if(file_exists('../../'.$contrato->getDocumento())){
            unlink('../../uploads/documentosfirmados/'.$contrato->getDocumento());
        }
        echo json_encode(array('status'=>true,'message'=>'Documento eliminado'));
    }else{
        echo json_encode(array('status'=>false,'message'=>'Ups! No se encontro el Documento'));
    }
    
}