<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['codigo']) && isset($_POST['descripcion']) && isset($_POST['tipo']) && isset($_POST['imponible']) && isset($_POST['tributable']) && isset($_POST['gratificacion']) && isset($_POST['reservado']) && isset($_POST['lre']) && isset($_POST['agrupacion']) && isset($_POST['categoria'])){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $imponible = $_POST['imponible'];
    $tributable = $_POST['tributable'];
    $gratificacion = $_POST['gratificacion'];
    $reservado = $_POST['reservado'];
    $agrupacion = $_POST['agrupacion'];
    $lre = $_POST['lre'];
    $categoria = $_POST['categoria'];
    $empresa = 0;
    if($categoria == 2){
        session_start();
        if(isset($_SESSION['CURRENT_ENTERPRISE'])){
            $empresa = $_SESSION['CURRENT_ENTERPRISE'];
        }else{
            echo json_encode(array("status"=>false, "message"=>"No se ha seleecionado una empresa"));
            return;
        }
    }

    if($c->validarcodigohaberes($categoria, $empresa, $codigo) == true){
        echo json_encode(array("status"=>false, "message"=>"El código ingresado ya existe"));
        return;
    }

    $result = $c->registrarhaberesydescuentos($codigo, $nombre, $tipo, $imponible, $tributable, $gratificacion, $reservado, $lre, $agrupacion,$categoria, $empresa);
    if($result==true){
        if($tipo == 1){
            echo json_encode(array("status"=>true, "message"=>"Haber registrado correctamente"));
        }else{
            echo json_encode(array("status"=>true, "message"=>"Descuento registrado correctamente"));
        }
    }else{
        echo json_encode(array("status"=>false, "message"=>"No se pudo registrar el haber"));
    }
}else{
    echo json_encode(array("status"=>false, "message"=>"No se recibieron los datos"));
}