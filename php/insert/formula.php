<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['codigo']) && isset($_POST['nombre']) && isset($_POST['represent']) && isset($_POST['formula'])){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $representacion = $_POST['represent'];
    $formula = $_POST['formula'];
    $valid = $c->buscarformularepresentacion($representacion);
    if($valid==true){
        echo json_encode(array('status'=>false, 'message'=>'La representacion ya existe'));
        return;
    }
    $result = $c->registrarformula($codigo, $nombre, $representacion, $formula);
    if($result==true){
        echo json_encode(array('status'=>true, 'message'=>'Formula registrada correctamente'));
    }else{
        echo json_encode(array('status'=>false, 'message'=>'Error al registrar la formula'));
    }
}else{
    echo json_encode(array('status'=>false, 'message'=>'Error al registrar la formula'));
}