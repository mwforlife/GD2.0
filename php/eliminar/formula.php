<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->eliminarformula($id);
    if($result==true){
        echo json_encode(array('status'=>true, 'message'=>'Formula eliminada correctamente'));
    }else{
        echo json_encode(array('status'=>false, 'message'=>'Error al eliminar la formula'));
    }
}else{
    echo json_encode(array('status'=>false, 'message'=>'Error al eliminar la formula'));
}