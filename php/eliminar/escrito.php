<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['empresa'])){
    $id = $_POST['id'];
    $empresa = $_POST['empresa'];
    $valid = $c->validardocumento($empresa,$id);
    $c->retirardocumento($empresa,$id);
    echo 1;
}else{
    echo 0;
}