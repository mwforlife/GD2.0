<?php
require '../controller.php';
$c = new Controller();
session_start();

$empresa = $_SESSION['CURRENT_ENTERPRISE'];

if (isset($_POST['trabajadores']) && isset($_POST['periodo']) && isset($_POST['tipomovimiento']) && isset($_POST['evento']) && isset($_POST['termino']) && isset($_POST['entidad']) && isset($_POST['fechainicio'])) {
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
    if (count($trabajadores) <= 0) {
        echo json_encode(array('status' => false, 'message' => 'No se ha seleccionado ningun trabajador'));
        return;
    }

    if ($periodo == '') {
        echo json_encode(array('status' => false, 'message' => 'No se ha seleccionado ningun periodo'));
        return;
    }

    $periodo = $periodo . '-01';

    if ($tipomovimiento == '' || $tipomovimiento == '0') {
        echo json_encode(array('status' => false, 'message' => 'No se ha seleccionado ningun tipo de movimiento'));
        return;
    }

    if ($evento == '' || $evento == '0') {
        echo json_encode(array('status' => false, 'message' => 'No se ha seleccionado ningun evento'));
        return;
    }

    if ($termino == '' || $termino == '0') {
        echo json_encode(array('status' => false, 'message' => 'Hubo un error, rellene el formulario nuevamente'));
        return;
    }

    if ($entidad == '' || $entidad == '0') {
        echo json_encode(array('status' => false, 'message' => 'Hubo un error, rellene el formulario nuevamente'));
        return;
    }

    if ($fechainicio == '') {
        echo json_encode(array('status' => false, 'message' => 'No se ha seleccionado ninguna fecha de inicio'));
        return;
    }

    if ($termino == 1) {
        if (isset($_POST['fechatermino'])) {
            $fechatermino = $_POST['fechatermino'];
        } else {
            echo json_encode(array('status' => false, 'message' => 'No se ha seleccionado ninguna fecha de termino'));
            return;
        }
    }

    $eventoobject = $c->buscarjornada($evento);
    $errores = array();
    $exito = array();

    foreach ($trabajadores as $trabajador) {
        $contrato = $c->buscarultimocontratoactivoperiodo($trabajador->id, $fechainicio);
        if ($entidad == 1) {
            $licencia = $c->buscarlicenciastrabajador($trabajador->id, date("Y-m-01", strtotime($periodo)), date("Y-m-t", strtotime($periodo)));
            if ($licencia != null) {
                $rutentidad = $licencia->getRegistro();
                $entidadpagadora = $licencia->getPagadora();
            }
        }

        $fechatermino1 = $fechainicio;

        if ($fechatermino != "") {
            $fechatermino1 = $fechatermino;
        }

        $valid = $c->validarmovimiento($trabajador->id, $fechainicio, $fechatermino1, $evento);
        if ($valid == true) {
            $errores[] = "El trabajador " . $trabajador->nombre . " ya tiene registrado el evento " . $eventoobject->getNombre() . " en el periodo de " . date("d-m-Y", strtotime($fechainicio)) . " a " . date("d-m-Y", strtotime($fechatermino1));
            continue;
        }
        $result = $c->registrarmovimiento($trabajador->id, $empresa, $periodo, $tipomovimiento, $evento, $fechainicio, $fechatermino, $rutentidad, $entidadpagadora);

        if ($result == true) {
            $exito[] = "Se ha registrado el movimiento para el trabajador " . $trabajador->nombre;
        } else {
            $errores[] = "No se ha registrado el movimiento para el trabajador " . $trabajador->nombre;
        }

        if ($eventoobject->getCodigoPrevired() == 4) {
            //Verificar si viene fecha de termino
            if ($termino == 1) {
                //Recorrer el range de fechas de inicio a termino
                $fechainicio = new DateTime($fechainicio);
                $fechatermino = new DateTime($fechatermino);
                while ($fechainicio <= $fechatermino) {
                    $asistencia = $c->validarasistencia($trabajador->id, $contrato->getId(), $fechainicio->format('Y-m-d'));
                    if ($asistencia == false) {
                        $c->registrarasistencia($id, $contrato->getId(), $fechainicio->format('Y-m-d'), 5);
                    } else {
                        $c->actualizarasistencia($asistencia, 5);
                    }
                    $fechainicio->modify('+1 day');
                }
            } else {
                $asistencia = $c->validarasistencia($trabajador->id, $contrato->getId(), $fechainicio);
                if ($asistencia == false) {
                    $c->registrarasistencia($id, $contrato->getId(), $fechainicio, 5);
                } else {
                    $c->actualizarasistencia($asistencia, 5);

                }

            }
        } else if ($eventoobject->getCodigoPrevired() == 11) {
            //Verificar si viene fecha de termino
            if ($termino == 1) {
                //Recorrer el range de fechas de inicio a termino
                $fechainicio = new DateTime($fechainicio);
                $fechatermino = new DateTime($fechatermino);
                while ($fechainicio <= $fechatermino) {
                    $asistencia = $c->validarasistencia($trabajador->id, $contrato->getId(), $fechainicio->format('Y-m-d'));
                    if ($asistencia == false) {
                        $c->registrarasistencia($trabajador->id, $contrato->getId(), $fechainicio->format('Y-m-d'), 3);
                    } else {
                        $c->actualizarasistencia($asistencia, 3);
                    }
                    $fechainicio->modify('+1 day');
                }
            } else {
                $asistencia = $c->validarasistencia($trabajador->id, $contrato->getId(), $fechainicio);
                if ($asistencia == false) {
                    $c->registrarasistencia($trabajador->id, $contrato->getId(), $fechainicio, 3);
                } else {
                    $c->actualizarasistencia($asistencia, 3);

                }

            }
        }else if ($eventoobject->getCodigoPrevired() == 3) {
            //Verificar si viene fecha de termino
            if ($termino == 1) {
                //Recorrer el range de fechas de inicio a termino
                $fechainicio = new DateTime($fechainicio);
                $fechatermino = new DateTime($fechatermino);
                while ($fechainicio <= $fechatermino) {
                    $asistencia = $c->validarasistencia($trabajador->id, $contrato->getId(), $fechainicio->format('Y-m-d'));
                    if ($asistencia == false) {
                        $c->registrarasistencia($trabajador->id, $contrato->getId(), $fechainicio->format('Y-m-d'), 4);
                    } else {
                        $c->actualizarasistencia($asistencia, 4);
                    }
                    $fechainicio->modify('+1 day');
                }
            } else {
                $asistencia = $c->validarasistencia($trabajador->id, $contrato->getId(), $fechainicio);
                if ($asistencia == false) {
                    $c->registrarasistencia($trabajador->id, $contrato->getId(), $fechainicio, 4);
                } else {
                    $c->actualizarasistencia($asistencia, 4);

                }

            }
        }
    }

    echo json_encode(array('status' => true, 'exito' => $exito, 'errores' => $errores));


} else {
    echo json_encode(array('status' => false, 'message' => 'UPS! Hubo un error, rellene el formulario nuevamente'));
    return;
}