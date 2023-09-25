<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['banco']) && isset($_POST['tipocuenta']) && isset($_POST['numerocuenta'])  && isset($_POST['id'])){
    $banco = $_POST['banco'];
    $tipocuenta = $_POST['tipocuenta'];
    $numerocuenta = $_POST['numerocuenta'];
    $id = $_POST['id'];
    if($banco<=0){
        echo "Seleccione un banco";
    }else if($tipocuenta<=0){
        echo "Seleccione un tipo de cuenta";
    }else if($numerocuenta==""){
        echo "Ingrese un número de cuenta";
    }else{
        $result = $c->actualizarcuentabancaria($id,$banco,$tipocuenta,$numerocuenta);
        if($result==true){
            echo 1;
        }else{
            echo 0;
        }    
    }
}