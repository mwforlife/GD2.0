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
    $contrato = $_POST['contrato'];
    $usuario = $_SESSION['USER_ID'];
    $token = $_SESSION['USER_TOKEN'];
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];

    $id = $c->buscaridcontratolote($contrato);

    if($id == false){
        echo 0;
    }else{
        $valid = $c->validarloteanexo($id, $usuario);
        if($valid == false){
            $result = $c->registrarloteanexo($id, $usuario);
            if($result == true){
                echo 1;
            }else{
                echo 0;
            }
        }else{
        echo 2;
        }

    }
    
}else if($_POST['lote']){
    $usuario = $_SESSION['USER_ID'];
    $token = $_SESSION['USER_TOKEN'];
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];
    $lote = $_POST['lote'];
    $lista = $c->listarlotesids($lote);
    if(count($lista) == 0){
        echo 0;
    }else{
        foreach($lista as $l){
                $contrato = $l->getContrato();
                $valid = $c->validarloteanexo($contrato, $usuario);
                if($valid == false){
                    $result = $c->registrarloteanexo($contrato, $usuario);
                }
            
        }
        echo 1;
    }
}
