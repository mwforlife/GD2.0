<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['vacacionesprogresivas']) && isset($_POST['afecto']) && isset($_POST['idtrabajador'])){
    $vacacionesprogresivas = $_POST['vacacionesprogresivas'];
    $afecto = $_POST['afecto'];
    $idtrabajador = $_POST['idtrabajador'];
    $valid = $c->validarafectovacaciones($idtrabajador);
    if($valid == true){
        $retult = $c->actualizarafectovacaciones($idtrabajador, $vacacionesprogresivas, $afecto);
        if($retult == true){
            echo 3;
        }else{
            echo 4;
        }
    }else{
        $result = $c->registrarafectovacaciones($idtrabajador, $vacacionesprogresivas, $afecto);
        if($result == true){
            echo 1;
        }else{
            echo 2;
        }
    }
}