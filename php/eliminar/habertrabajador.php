<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->eliminarhaberesdescuentos($id);
    if($result==true){
        echo json_encode(array('status' => true, 'message' => 'Haber eliminado correctamente'));
    }else{
        echo json_encode(array('status' => false, 'message' => 'Error al eliminar haber'));
    }
}else{
    echo json_encode(array('status' => false, 'message' => 'Error al eliminar haber'));
}