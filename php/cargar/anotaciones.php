<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $val = $c->buscaranotacionporid($id);
    if($val==false){
        echo "<div class='alert alert-danger' role='alert'>Error: ID no válido</div>";
    }else{
        echo "<p class='text-justify p-4'>".$val."</p>";
    }
}