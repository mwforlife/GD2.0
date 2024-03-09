<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarcontratoid($id);

    if($c->buscarasistenciacontrato($id)==true || $c->buscarfiniquitocontrato($id)==true || $c->buscarcontratofirmadocontrato($id)==true || $c->buscarhoraspactadascontrato($id)==true || $c->buscaranexoscontrato($id)==true){
        echo 0;
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
        echo 1;
    }else{
        echo 0;
    }
}