<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $mov = $c->buscarmovimiento($id);
    if($mov != null){
        $fechainicio = $mov->getFechaInicio();
        $fechatermino = $mov->getFechaTermino();
        if($fechatermino == null || $fechatermino == '' || $fechatermino == '0000-00-00'){
            $fechatermino = $fechainicio;
        }
        $contrato = $c->buscarultimocontratoactivoperiodo($mov->getTrabajador(),$fechainicio);
        $evento = $mov->getEvento();
        $trabajador = $mov->getTrabajador();
        $evento = $c->buscarjornada($evento);
        if($evento->getCodigoPrevired() == 4 || $evento->getCodigoPrevired() == 11 || $evento->getCodigoPrevired() == 3 && $contrato != false){
            $fechainicio = new Datetime($fechainicio);
            $fechatermino = new Datetime($fechatermino);
            while($fechainicio <= $fechatermino){
                $asistencia = $c->validarasistencia($mov->getTrabajador(),$contrato->getId(),$fechainicio->format('Y-m-d'));
                if($asistencia!=false){
                    $c->eliminarasistencia($asistencia);
                }
                $fechainicio->modify('+1 day');
            }
        }
        $c->eliminarmovimiento($id);
    }
    $c->eliminarmovimiento($id);
    echo json_encode(array('status'=> true, 'message'=> 'Se ha eliminado el movimiento'));
}else{
    echo json_encode(array('status'=> false, 'message'=> 'No se ha seleccionado ningun movimiento'));
}