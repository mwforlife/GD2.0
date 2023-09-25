<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id <=0){
        echo "Error: ID no válido";
        return;
    }
    $result = $c->eliminaranotacion($id);
    if($result==true){
        echo 1;
    }else{
        echo 0;
    }
}