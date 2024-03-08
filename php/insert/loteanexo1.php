<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: ../../lockscreen.php");
    }
}
if (isset($_POST['contrato'])) {
    $id = $_POST['contrato'];
    $usuario = $_SESSION['USER_ID'];
    $token = $_SESSION['USER_TOKEN'];
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];


    if($id == false){
        echo 0;
    }else{
        $valid = $c->validarloteanexo($id, $usuario,$empresa);
        if($valid == false){
            $result = $c->registrarloteanexo($id, $usuario,$empresa);
            if($result == true){
                echo 1;
            }else{
                echo 0;
            }
        }else{
        echo 2;
        }

    }
    
}else{
    echo 0;
}

