<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "delete from vacaciones where id = $id";
    $result = $c->query($sql);
    if($result==true){
        echo 1;
    }else{
        echo 0;
    }
}