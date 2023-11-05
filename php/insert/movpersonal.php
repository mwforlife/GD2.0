<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['trabajadores']) && isset($_POST['periodo']) && isset($_POST['tipomovimiento']) && isset($_POST['evento']) && isset($_POST['termino']) && isset($_POST['entidad']) && isset($_POST['fechainicio'])){
    $trabajadores = $_POST['trabajadores'];
    $periodo = $_POST['periodo'];
    $tipomovimiento = $_POST['tipomovimiento'];
    $evento = $_POST['evento'];
    $termino = $_POST['termino'];
    $entidad = $_POST['entidad'];
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = "";
    $rutentidad = "";
    $entidadpagadora = "";

    $trabajadores = json_decode($trabajadores);
    //Validar que los datos no esten vacios
    if(count($trabajadores) <= 0){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ningun trabajador'));
        return;
    }

    if($periodo == ''){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ningun periodo'));
        return;
    }

    if($tipomovimiento == '' || $tipomovimiento == '0'){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ningun tipo de movimiento'));
        return;
    }

    if($evento == '' || $evento == '0'){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ningun evento'));
        return;
    }

    if($termino == '' || $termino == '0'){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ningun termino'));
        return;
    }

    if($entidad == '' || $entidad == '0'){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ninguna entidad'));
        return;
    }

    if($fechainicio == ''){
        echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ninguna fecha de inicio'));
        return;
    }

    if($termino == 1){
        if(isset($_POST['fechatermino'])){
            $fechatermino = $_POST['fechatermino'];
        }else{
            echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ninguna fecha de termino'));
            return;
        }
    }

    foreach($trabajadores as $trabajador){
        
    }

    
}