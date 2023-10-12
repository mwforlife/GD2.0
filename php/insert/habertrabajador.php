<?php
//Recepcion de datos
/*codigo: 1
periodoini: 2023-10
periodofin: 2023-10
monto: 2.0.0.0.0.000
dias: 
horas: 
tipo: 1
modalidad: 1
trabajadores: [{"id":"9","rut":"11.337.156-0","nombre":"PATRICIO JACOB MOENA AGUAYO"},{"id":"10","rut":"8.054.994-6","nombre":"RENE DANIEL REYES FUENZALIDA"},{"id":"11","rut":"12.515.380-1","nombre":"DANIEL ANDRES CANTILLANA ESPINOSA"},{"id":"12","rut":"13.261.793-7","nombre":"RODOLFO ANDRES  VALLEJOS REYES"}]*/

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

    //Validacion de datos
    if($codigo == "" || $periodoini == "" || $periodofin == "" || $tipo == "" || $modalidad == "" || $trabajadores == ""){
        echo json_encode(array("status" => false, "message" => "No se han recibido los datos necesarios"));
        return;
    }

    //Validacion de datos
    if($tipo==1){
        if($monto == "" || $monto <= 0){
            echo json_encode(array("status" => false, "message" => "Debes ingresar un monto mayor a 0"));
            return;
        }
    }else if($tipo==3){
        if($dias == "" || $dias <= 0){
            echo json_encode(array("status" => false, "message" => "Debes ingresar un numero de dias mayor a 0"));
            return;
        }
    }else if($tipo==2){
        if($horas == "" || $horas <= 0){
            echo json_encode(array("status" => false, "message" => "Debes ingresar un numero de horas mayor a 0"));
            return;
        }
    }

    foreach($trabajadores as $trabajador){
        $id = $trabajador['id'];
        $c->registrarhaberes_descuentos_trabajador($codigo,)
    }

}else{
    echo json_encode(array("status" => false, "message" => "No se han recibido los datos necesarios"));
    return;
}