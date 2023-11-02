<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['codigo']) && isset($_POST['periodoini']) && isset($_POST['periodofin']) && isset($_POST['monto']) && isset($_POST['tipo']) && isset($_POST['modalidad']) && isset($_POST['trabajadores'])){
    $codigo = $_POST['codigo'];
    $periodoini = $_POST['periodoini'];
    $periodofin = $_POST['periodofin'];
    $monto = $_POST['monto'];
    $tipo = $_POST['tipo'];
    $modalidad = $_POST['modalidad'];
    $trabajadores = $_POST['trabajadores'];
    $dias = $_POST['dias'];
    $horas = $_POST['horas'];
    $trabajadores = $_POST['trabajadores'];
    //Recibir el array
    $trabajadores = json_decode($trabajadores, true);

    $monto = str_replace('.', '', $monto);
    $monto = str_replace(',', '.', $monto);

    //Validacion de datos
    if($codigo == "" || $periodoini == "" || $periodofin == "" || $tipo == "" || $modalidad == "" || $trabajadores == ""){
        echo json_encode(array("status" => false, "message" => "No se han recibido los datos necesarios"));
        return;
    }

    $periodoini = $periodoini. "-01";
    $periodofin = $periodofin. "-01";

    //Validacion de datos
    if($tipo==1){
        if($monto == "" || $monto <= 0){
            echo json_encode(array("status" => false, "message" => "Debes ingresar un monto mayor a 0"));
            return;
        }else{
            $dias = 0;
            $horas = 0;
        }
    }else if($tipo==3){
        if($dias == "" || $dias <= 0){
            echo json_encode(array("status" => false, "message" => "Debes ingresar un numero de dias mayor a 0"));
            return;
        }else{
            $monto = 0;
            $horas = 0;
        }
    }else if($tipo==2){
        if($horas == "" || $horas <= 0){
            echo json_encode(array("status" => false, "message" => "Debes ingresar un numero de horas mayor a 0"));
            return;
        }else{
            $monto = 0;
            $dias = 0;
        }
    }

    $empresa = $_SESSION['CURRENT_ENTERPRISE'];

    $resultado = false;
    foreach($trabajadores as $trabajador){
        $id = $trabajador['id'];
        $result = $c->registrarhaberes_descuentos_trabajador($codigo,$periodoini,$periodofin,$monto,$dias,$horas,$modalidad,$id,$empresa);
        if($result==true){
            $resultado = true;
        }else{
            $resultado = false;
            break;
        }
    }

    if($resultado==true){
        echo json_encode(array("status" => true, "message" => "Se ha registrado el haber/descuento correctamente"));
    }else{
        echo json_encode(array("status" => false, "message" => "No se ha podido registrar el haber/descuento"));
    }

}else{
    echo json_encode(array("status" => false, "message" => "No se han recibido los datos necesarios"));
    return;
}