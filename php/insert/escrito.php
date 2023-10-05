<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['empresa'])){
    $id = $_POST['id'];
    $empresa = $_POST['empresa'];
    $valid = $c->validardocumento($empresa,$id);
    if($valid==false){
        $c->asignardocumento($empresa,$id);
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}