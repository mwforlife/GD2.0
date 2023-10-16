<?php
require '../controller.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $c = new Controller();
    $documento = $c->buscardocumentoempresaid($id);
    $result = $c->eliminardocumentoempresa($id);
    $documentos = $c->buscardocumentoempresadocumento($documento->getDocumento());
    if(count($documentos)==0){
        unlink("../../uploads/documento_empresa/".$documento->getDocumento());
    }
    echo json_encode(array('status' => true, 'message' => 'Documento Eliminado con Exito'));
}else{
    echo json_encode(array('status' => false, 'message' => 'No se pudo eliminar el documento'));
}