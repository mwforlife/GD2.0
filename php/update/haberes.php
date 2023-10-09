<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['id']) && isset($_POST['codigo']) && isset($_POST['descripcion']) && isset($_POST['tipo']) && isset($_POST['imponible']) && isset($_POST['tributable']) && isset($_POST['gratificacion']) && isset($_POST['reservado']) && isset($_POST['lre']) && isset($_POST['agrupacion'])){
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $imponible = $_POST['imponible'];
    $tributable = $_POST['tributable'];
    $gratificacion = $_POST['gratificacion'];
    $reservado = $_POST['reservado'];
    $lre = $_POST['lre'];
    $agrupacion = $_POST['agrupacion'];

    $result = $c->editarhaberesydescuentos($id, $codigo, $descripcion, $tipo, $imponible, $tributable, $gratificacion, $reservado, $lre, $agrupacion);
    if($result==true){
        if($tipo == 1){
            echo json_encode(array("status"=>true, "message"=>"Haber actualizado correctamente"));
            $usuario = $_SESSION['USER_ID'];
            $eventos = "";
            if($tipo==1){
                $eventos = "Se Actualizo el haber : ".$descripcion . " con el Codigo: ".$codigo;
            }else{
                $eventos = "Se Actualizo el descuento : ".$descripcion . " con el Codigo: ".$codigo;
            }
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        }else{
            echo json_encode(array("status"=>true, "message"=>"Descuento actualizado correctamente"));
        }
    }else{
        echo json_encode(array("status"=>false, "message"=>"No se pudo actualizar el haber"));
    }
}else{
    echo json_encode(array("status"=>false, "message"=>"No se recibieron los datos"));
}