<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarotrosdocumentosfirmadosid($id);
    if($contrato!=false){
        //Eliminar el archivo si existe
        if(file_exists('../../uploads/documentosfirmados/'.$contrato->getDocumento())){
            unlink('../../uploads/documentosfirmados/'.$contrato->getDocumento());
        }
    }
    $c->eliminarotrosdocumentosfirmados($id);
    echo json_encode(array('status'=>true,'message'=>'Documento eliminado'));
    
}