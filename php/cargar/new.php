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
if(isset($_POST['id'])){
    $_SESSION['TRABJADOR_CONTRATO'] = $_POST['id'];
    echo 1;
}else if(isset($_POST['rut'])){
    $rut = $_POST['rut'];
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];
    $trabajador = $c->buscartrabajadorporrut($rut, $empresa);
    if($trabajador != false){
        $_SESSION['TRABJADOR_CONTRATO'] = $trabajador->getId();
        echo "El Rut Pertenece al Trabajador: ".$trabajador->getNombre()." ".$trabajador->getApellido1()." ".$trabajador->getApellido2();
        
    }else{
        echo 0;
    }
}