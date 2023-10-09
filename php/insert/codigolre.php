<?php
if(isset($_POST['articulo']) && isset($_POST['codigo']) && isset($_POST['codigoprevired']) && isset($_POST['Nombre'])){
    require '../controller.php';
    $c = new Controller();

    $articulo = $_POST['articulo'];
    $codigo = $_POST['codigo'];
    $codigoprevired = $_POST['codigoprevired'];
    $descripcion = $_POST['Nombre'];
    
    $result = $c->registrarcodigolre($articulo, $codigo, $codigoprevired, $descripcion);
    if($result==true){
        echo "1";
    }else{
        echo "0";
    }
}else{
    echo "0";
}