<?php
require '../controller.php';
$c = new Controller();
session_start();
if (isset($_SESSION['USER_ID']) && isset($_POST['tipo']) && isset($_POST['descripcion']) && isset($_POST['monto'])) {
    $id = $_SESSION['USER_ID'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    //Eliminar los puntos en el monto
    $monto = str_replace(".", "", $monto);

    if($id<=0){
        echo "Hubo un error al cargar el usuario";
        return;
    }

    if($tipo<=0){
        echo "Hubo un error al cargar la indemnización";
        return;
    }

    if($descripcion==""){
        echo "Hubo un error al cargar la descripción";
        return;
    }

    if($monto<=0){
        echo "Hubo un error al cargar el monto";
        return;
    }

    $tipo1 = $c->buscartipoindezacion($tipo);
    if($tipo1==false){
        echo "Hubo un error al cargar el tipo";
        return;
    }

    $result = $c->registrarresumenfiniquito($tipo,$tipo1,$descripcion,$monto,$id);
    if($result==false){
        echo 0;
    }else if($result==true){
        echo 1;
    }else{
        echo $result;
    }

}else{
    echo "Hubo un error al cargar los datos";
}