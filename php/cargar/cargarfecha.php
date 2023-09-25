<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->buscarfechainiciocontrato($id);
    if($result==false){
        echo 0;
    }else{
        echo $result;
    }
}