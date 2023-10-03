<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: lockscreen.php");
    }
}

if(isset($_POST['id']) && isset($_SESSION['EMPRESA_ID'])){
    $codigo = $_POST['id'];
    $id = $_SESSION['EMPRESA_ID'];
    $valid = $c->ValidarCodigoActividadEmpresa($id, $codigo);
    if($valid == true){
        echo 2;
    }else{
        $result = $c->RegistrarCodigoActividadEmpresa($id, $codigo);
        if($result == true){
            echo 1;
        }else{
            echo 0;
        }
    }
}else if(isset($_POST['id']) && isset($_POST['EMPRESAID'])){
    $codigo = $_POST['id'];
    $id = $_POST['EMPRESAID'];
    $valid = $c->ValidarCodigoActividadEmpresa($id, $codigo);
    if($valid == true){
        echo 2;
    }else{
        $result = $c->RegistrarCodigoActividadEmpresa($id, $codigo);
        if($result == true){
            echo 1;
        }else{
            echo 0;
        }
    }
}else{
    echo 0;
}