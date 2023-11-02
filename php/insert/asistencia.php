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
        echo $rut;
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
            if ($asistencia == false) {
                
                if (intval($data[$j]) == 1) {
                } else {
                    $c->registrarasistencia($trabajador->getId(), $contrato->getId(), $fecha, $data[$j]);
                }
                
                $success .= "Asistencia del trabajador " . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . " de dia $fecha Cargado con exito <br>";
            } else {
                if (intval($data[$j]) == 1) {
                    $c->eliminarasistencia($asistencia);
                } else {
                    $c->actualizarasistencia($asistencia, $data[$j]);
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