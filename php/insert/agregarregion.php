<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['region']) && isset($_POST['trabajador'])){
    $region = $_POST['region'];
    $trabajador = $_POST['trabajador'];
    $ver = $c->verificarzonaregion($trabajador, $region);
    if($ver==true){
        echo 2;
        return;
    }
    $result = $c->zonaregion($trabajador, $region);
    if($result==true){
        echo 1;
    }else{
        echo 0;
    }
}