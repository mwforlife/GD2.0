<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->buscarfechaterminocontrato($id);
    if($result==false){
        echo 0;
    }else{
        if($result==""){
            echo 0;
        }else{
            echo $result;
        }
    }
}