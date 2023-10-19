<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id > 0){
        $documento = $c->buscarotrosdocumentosfirmados($id);
        if($documento==false){
            echo json_encode(array('status' => false, 'message' => 'No hay contrato firmado'));
        }else{
            $docu = $documento->getDocumento();
            echo json_encode(array('status' => true, 'message' => '<div class="alert alert-warning" role="alert"><strong><i class="fa fa-warning"></i> Advertencia:</strong> Ya se subió un contrato firmado anteriormente, si sube uno nuevo, el anterior será reemplazado.<br/><a href="uploads/documentosfirmados/'.$docu.'" target="_blank" class="btn btn-success btn-sm mt-2"><i class="fa fa-eye"></i> Ver Contrato</a></div>', 'filename' => $docu));
        }
    }else{
        echo json_encode(array('status' => false, 'message' => 'No se ha encontrado el contrato firmado'));
    }

}else{
    echo json_encode(array('status' => false, 'message' => 'No se pudo validar el contrato firmado'));
}