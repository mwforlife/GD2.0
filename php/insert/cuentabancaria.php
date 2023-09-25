<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['banco']) && isset($_POST['tipocuenta']) && isset($_POST['numerocuenta']) && isset($_POST['trabajador'])){
    $banco = $_POST['banco'];
    $tipocuenta = $_POST['tipocuenta'];
    $numerocuenta = $_POST['numerocuenta'];
    $trabajador = $_POST['trabajador'];
    if($banco<=0){
        echo "Seleccione un banco";
    }else if($tipocuenta<=0){
        echo "Seleccione un tipo de cuenta";
    }else if($numerocuenta==""){
        echo "Ingrese un número de cuenta";
    }else if($trabajador<=0){
        echo "Seleccione un trabajador";
    }else{
        $result = $c->registrarcuentabancaria($banco,$tipocuenta,$numerocuenta,$trabajador);
        if($result==true){
            echo 1;
        }else{
            echo 0;
        }    
    }
}