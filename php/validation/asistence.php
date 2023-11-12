<?php
require '../controller.php';
$c = new Controller();
session_start();
if (isset($_POST['id']) && isset($_POST['empresa']) && isset($_POST['contrato']) && isset($_POST['dia']) && isset($_POST['estado'])) {
    $id = $_POST['id'];
    $empresa = $_POST['empresa'];
    $contrato = $_POST['contrato'];
    $dia = $_POST['dia'];
    $estado = $_POST['estado'];
    switch ($estado) {
        case 1:
            $estado = 2;
            break;
        case 2:
            $estado = 3;
            break;
        case 3:
            $estado = 5;
            break;
        case 5:
            $estado = 1;
            break;
    }
    $asistencia = $c->validarasistencia($id, $contrato, $dia);
    $contratoobject = $c->buscarcontratoid($contrato);
    if ($asistencia == false) {
        $c->registrarasistencia($id, $contrato, $dia, 2);
    } else {
        $c->actualizarasistencia($asistencia, $estado);
        if ($estado == 1) {
            $c->eliminarasistencia($asistencia);
            $valid = $c->buscarmovimientoxfecha($contratoobject->getFecharegistro(), $dia, 4);
            if ($valid != false) {
                $id = $valid->getId();
                $c->eliminarmovimiento($id);
            } else {
                $valid = $c->buscarmovimientoxfecha($contratoobject->getFecharegistro(), $dia, 11);
                if ($valid != false) {
                    $id = $valid->getId();
                    $c->eliminarmovimiento($id);
                }

            }
        } else if ($estado == 5) {
            $evento = $c->buscarjornadaxcodigo(4);
            $valid = $c->buscarmovimientoxfecha($contratoobject->getFecharegistro(), $dia, 4);
            if ($valid == false) {
                $valid = $c->buscarmovimientoxfecha($contratoobject->getFecharegistro(), $dia, 11);
                if ($valid != false) {
                    $id = $valid->getId();
                    $c->eliminarmovimiento($id);
                    $periodo = $valid->getPeriodo();
                    $tipo = $valid->getTipo();
                    $rutentidad = $valid->getRutEntidad();
                    $nombreentidad = $valid->getNombreEntidad();
                    $fechainicio1 = $valid->getFechaInicio();
                    $fechatermino1 = date('Y-m-d', strtotime($dia . ' -1 day'));
                    $fechainicio2 = date('Y-m-d', strtotime($dia . ' +1 day'));
                    $fechatermino2 = $valid->getFechaTermino();

                    if($fechainicio1 == $fechatermino2){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $fechainicio1,$fechatermino2, $rutentidad, $nombreentidad);
                       
                    }else{
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $dia,$dia, $rutentidad, $nombreentidad);

                        if($fechainicio1 < $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio1,$fechatermino1, $rutentidad, $nombreentidad);
                        }

                        if($fechatermino2 > $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio2,$fechatermino2, $rutentidad, $nombreentidad);
                        }
                    }
                } else {
                    $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, date('Y-m-01', strtotime($dia)), 2, $evento->getId(), $dia, $dia, '', '');
                }
            } else {
                $id = $valid->getId();
                    $c->eliminarmovimiento($id);
                    $periodo = $valid->getPeriodo();
                    $tipo = $valid->getTipo();
                    $rutentidad = $valid->getRutEntidad();
                    $nombreentidad = $valid->getNombreEntidad();
                    $fechainicio1 = $valid->getFechaInicio();
                    $fechatermino1 = date('Y-m-d', strtotime($dia . ' -1 day'));
                    $fechainicio2 = date('Y-m-d', strtotime($dia . ' +1 day'));
                    $fechatermino2 = $valid->getFechaTermino();

                    if($fechainicio1 == $fechatermino2){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio1,$fechatermino2, $rutentidad, $nombreentidad);
                       
                    }else{
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $dia,$dia, $rutentidad, $nombreentidad);

                        if($fechainicio1 < $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio1,$fechatermino1, $rutentidad, $nombreentidad);
                        }

                        if($fechatermino2 > $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio2,$fechatermino2, $rutentidad, $nombreentidad);
                        }
                    }
            }
        } else if ($estado == 3) {
            $valid = $c->buscarmovimientoxfecha($contratoobject->getFecharegistro(), $dia, 11);
            $evento = $c->buscarjornadaxcodigo(11);
            if ($valid == false) {
                $valid = $c->buscarmovimientoxfecha($contratoobject->getFecharegistro(), $dia, 4);
                if ($valid != false) {
                    $id = $valid->getId();
                    $c->eliminarmovimiento($id);
                    $periodo = $valid->getPeriodo();
                    $tipo = $valid->getTipo();
                    $rutentidad = $valid->getRutEntidad();
                    $nombreentidad = $valid->getNombreEntidad();
                    $fechainicio1 = $valid->getFechaInicio();
                    $fechatermino1 = date('Y-m-d', strtotime($dia . ' -1 day'));
                    $fechainicio2 = date('Y-m-d', strtotime($dia . ' +1 day'));
                    $fechatermino2 = $valid->getFechaTermino();

                    if($fechainicio1 == $fechatermino2){
                       $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $fechainicio1,$fechatermino2, $rutentidad, $nombreentidad);
                    }else{
                        if($fechainicio1 < $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio1,$fechatermino1, $rutentidad, $nombreentidad);
                        }

                        if($fechatermino2 > $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio2,$fechatermino2, $rutentidad, $nombreentidad);
                        }

                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $dia,$dia, $rutentidad, $nombreentidad);
                    }
                } else {
                    $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, date('Y-m-01', strtotime($dia)), 2, $evento->getId(), $dia, $dia, '', '');
                }
            } else {
                $id = $valid->getId();
                    $c->eliminarmovimiento($id);
                    $periodo = $valid->getPeriodo();
                    $tipo = $valid->getTipo();
                    $rutentidad = $valid->getRutEntidad();
                    $nombreentidad = $valid->getNombreEntidad();
                    $fechainicio1 = $valid->getFechaInicio();
                    $fechatermino1 = date('Y-m-d', strtotime($dia . ' -1 day'));
                    $fechainicio2 = date('Y-m-d', strtotime($dia . ' +1 day'));
                    $fechatermino2 = $valid->getFechaTermino();

                    if($fechainicio1 == $fechatermino2){
                       $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $fechainicio1,$fechatermino2, $rutentidad, $nombreentidad);
                    }else{
                        if($fechainicio1 < $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio1,$fechatermino1, $rutentidad, $nombreentidad);
                        }

                        if($fechatermino2 > $dia){
                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $valid->getEvento(), $fechainicio2,$fechatermino2, $rutentidad, $nombreentidad);
                        }

                        $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, $periodo, $tipo, $evento->getId(), $dia,$dia, $rutentidad, $nombreentidad);
                    }
            }
        }

    }
}