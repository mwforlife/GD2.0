<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id > 0){
        $documento = $c->buscarnotificacionfirmada($id);
        if($documento==false){
            echo json_encode(array('status' => false, 'message' => 'No hay Documento firmado'));
        }else{
            $docu = $documento->getDocumento();
            $carta = $documento->getCarta();

            $message = "<div class='alert alert-warning' role='alert'><strong><i class='fa fa-warning'></i> Advertencia:</strong> Ya se subió Algún documento firmado anteriormente, si sube uno nuevo, el anterior será reemplazado.<br/>";

            if($docu!=""){
                $message .='<a href="uploads/documentosfirmados/'.$docu.'" target="_blank" class="btn btn-primary btn-sm mt-2"><i class="fa fa-eye"></i> Ver Documento</a>';
            }

            if($carta!=""){
                $message .= '<a href="uploads/documentosfirmados/'.$carta.'" target="_blank" class="btn btn-success btn-sm mt-2"><i class="fa fa-eye"></i> Ver Carta</a>';
            }

            $message .= "</div>";

            echo json_encode(array('status' => true, 'message' => $message, 'filename' => $docu));
        }
    }else{
        echo json_encode(array('status' => false, 'message' => 'No se ha encontrado el Finiquito firmado'));
    }

}else{
    echo json_encode(array('status' => false, 'message' => 'No se pudo validar el Finiquito firmado'));
}