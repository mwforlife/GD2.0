<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarcontratoid($id);

    if($c->buscarasistenciacontrato($id)==true){
        echo json_encode(array("status"=>false,"message"=>"No se puede eliminar el contrato porque tiene asistencias registradas."));
        return;
    } 
    
    if($c->buscarfiniquitocontrato($id)==true){
        echo json_encode(array("status"=>false,"message"=>"No se puede eliminar el contrato porque tiene finiquitos registrados."));
        return;
    }
    
    if($c->buscarcontratofirmadocontrato($id)==true){
        echo json_encode(array("status"=>false,"message"=>"No se puede eliminar el contrato porque tiene contratos firmados registrados."));
        return;
    }
    if($c->buscaranexoscontrato($id)==true){
        echo json_encode(array("status"=>false,"message"=>"No se puede eliminar el contrato porque tiene anexos registrados."));
        return;
    }

    $result = $c->eliminarcontrato($id);
    if($contrato!=null){
        //Eliminar el archivo si existe
        if(file_exists("../../uploads/Contratos/".$contrato->getDocumento())){
            unlink("../../uploads/Contratos/".$contrato->getDocumento());
        }
    }
    if($result==true){
        echo json_encode(array("status"=>true,"message"=>"Contrato eliminado correctamente."));
    }else{
        echo json_encode(array("status"=>false,"message"=>"Error al eliminar el contrato."));
    }
}else{
    echo json_encode(array("status"=>false,"message"=>"Error al eliminar el contrato."));
}