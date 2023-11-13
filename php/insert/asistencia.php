<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../controller.php";
$c = new Controller();
session_start();
$empresa = $_SESSION['CURRENT_ENTERPRISE'];
if (isset($_POST['periodo']) && isset($_FILES['asistencia'])) {
    $periodo = $_POST['periodo'];
    //Validar que el periodo no este vacio
    if ($periodo == "") {
        echo json_encode(array("status" => false, "message" => "El periodo no puede estar vacio"));
        return;
    }

    //Validar que el periodo no sea del mes siguiente
    $mes = date('m');
    $anio = date('Y');
    $inicioperiodo = $periodo . "-01";
    $terminoperiodo = date('Y-m-t', strtotime($inicioperiodo));
    $ultimodia = date('d', strtotime($terminoperiodo));
    $mes1 = date('m', strtotime($periodo));
    $anio1 = date('Y', strtotime($periodo));
    if ($anio1 > $anio || ($anio1 == $anio && $mes1 > $mes)) {
        echo json_encode(array("status" => false, "errores" => "El periodo no puede ser superior al periodo actual", "success" => ""));
        return;
    }

    $asistencia = $_FILES['asistencia']['tmp_name'];

    //Validar que el archivo sea de tipo csv
    $ext = pathinfo($_FILES['asistencia']['name'], PATHINFO_EXTENSION);
    if ($ext != 'csv') {
        echo json_encode(array("status" => false, "errores" => "El archivo debe ser CSV"));
        return;
    }

    //Abrir el archivo
    $handle = fopen($asistencia, "r");

    //Validar que el archivo no este vacio
    if ($handle == false) {
        echo json_encode(array("status" => false, "errores" => "El archivo esta vacio"));
        return;
    }

    //Variables
    $i = 1;
    $errores = "";
    $success = "";

    //Recorrer el archivo
    while (($data = fgetcsv($handle, 1000, ";")) !== false) {
        if ($i == 1) {
            $i++;
            continue;
        }
        $rut = $data[0];
        $trabajador = $c->buscartrabajadorbyRut1($rut, $empresa);
        if ($trabajador == false) {
            $errores .= "El Trabajador con rut $rut no esta registrado en la empresa <br>";
            continue;
        }
        $licencias = $c->buscarlicencias($trabajador->getId(), $inicioperiodo, $terminoperiodo);

        $contrato = $c->buscarcontratotrabajador($trabajador->getId(), $empresa);
        if ($contrato == false) {
            $errores .= "El Trabajador " . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . " no tiene un contrato activo <br>";
            continue;
        }


        for ($j = 1; $j <= $ultimodia; $j++) {
            $fec = "";
            if ($j < 10) {
                $fec = "0" . $j;
            } else {
                $fec = $j;
            }
            $fecha = $periodo . "-" . "$fec";

            //Validar si el dia esta incluido en las licencias
            $licencia = false;
            if ($licencias != null) {
                $init = new DateTime($inicioperiodo);
                $end = new DateTime($terminoperiodo);
                while ($init <= $end) {
                    $fechita = $init->format('Y-m-d');
                    //Comprobar si el dia esta dentro de la licencia
                    if ($fecha == $fechita) {
                        $licencia = true;
                        break;
                    }
                    $init->modify('+1 day');
                }
            }

            if ($licencia == true) {
                continue;
            }


            $asistencia = $c->validarasistencia($trabajador->getId(), $contrato->getId(), $fecha);
            $estado = $data[$j];
            $contratoobject = $c->buscarcontratoid($contrato->getId());
            $dia = $fecha;
            $id = $trabajador->getId();
            if ($asistencia == false) {
                if($estado==5){
                    $evento = $c->buscarjornadaxcodigo(4);
                    $c->registrarasistencia($id, $contratoobject->getId(), $dia, $estado);
                    $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, date('Y-m-01', strtotime($dia)), 2, $evento->getId(), $dia, $dia, '', '');
                }else if($estado==3){
                    $evento = $c->buscarjornadaxcodigo(11);
                    $c->registrarasistencia($id, $contratoobject->getId(), $dia, $estado);
                    $c->registrarmovimiento($contratoobject->getFecharegistro(), $empresa, date('Y-m-01', strtotime($dia)), 2, $evento->getId(), $dia, $dia, '', '');
                }else if($estado==2){
                    $c->registrarasistencia($id, $contratoobject->getId(), $dia, $estado);
                }
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
        $i++;
    }
    if (strlen($errores) <= 0) {
        $success .= "Todos los registros fueron cargados con exito";
    } else {
        $errores .= "No se pudieron cargar todos los registros";
    }

    //Cerrar el archivo
    fclose($handle);

    //Retornar el resultado
    if ($errores != "") {
        echo json_encode(array("status" => false, "errores" => $errores, "success" => $success));
        return;
    } else if ($success != "") {
        echo json_encode(array("status" => true, "success" => $success, "errores" => $errores));
        return;
    }


} else {
    echo json_encode(array("status" => false, "message" => "No se recibieron los datos"));
    return;
}