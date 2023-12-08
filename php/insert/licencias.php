<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: ../../lockscreen.php");
    }
}


if (isset($_POST['folio']) && isset($_POST['tipolicencia']) && isset($_POST['fechainicio']) && isset($_POST['fechatermino']) && isset($_POST['TrabajadorAfp']) && isset($_POST['comentario']) && isset($_FILES['documentolicencia']) && isset($_FILES['comprobantetramite'])) {
    $folio = $_POST['folio'];
    $tipolicencia = $_POST['tipolicencia'];
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = $_POST['fechatermino'];
    $pagadora = $_POST['TrabajadorAfp'];
    $TrabajadorId = $_SESSION['TRABAJADOR_ID'];
    $comentario = $_POST['comentario'];
    $comentario = strtoupper($comentario);
    $licenciadoc = "";
    //Validar si viene un archivo
    if ($_FILES['documentolicencia']['name'] != "") {
        //Sacar Nombre del Archivo
        $licenciadoc = "Licencia_" . date("dHis") . "." . pathinfo($_FILES['documentolicencia']['name'], PATHINFO_EXTENSION);

        //Ruta de la carpeta destino en servidor
        $target_path = "../../uploads/";

        //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
        move_uploaded_file($_FILES['documentolicencia']['tmp_name'], $target_path . $licenciadoc);
    } else {
        echo "No se ha seleccionado el archivo de la Licencia";
        return;
    }

    //Comprobar que la fecha de inicio no sea mayor a la fecha de termino
    if ($fechainicio > $fechatermino) {
        echo "La fecha de inicio no puede ser mayor a la fecha de termino";
        return;
    }

    $file_licenciadoc = $licenciadoc;

    $tramitedoc = "";
    //Validar si viene un archivo
    if ($_FILES['comprobantetramite']['name'] != "") {
        //Sacar Nombre del Archivo
        $tramitedoc = "Tramite_" . date("dHis") . "." . pathinfo($_FILES['comprobantetramite']['name'], PATHINFO_EXTENSION);

        //Ruta de la carpeta destino en servidor
        $target_path = "../../uploads/";

        //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
        move_uploaded_file($_FILES['comprobantetramite']['tmp_name'], $target_path . $tramitedoc);
    } else {
        echo "No se ha seleccionado el comprobante del tramite";
        return;
    }

    $file_tramitedoc = $tramitedoc;


    $result = $c->registrarlicencia($folio, $tipolicencia, $fechainicio, $fechatermino, $pagadora, $comentario, $file_licenciadoc, $file_tramitedoc, $TrabajadorId);
    if ($result == true) {
        echo 1;
        $evento = $c->buscarjornadaxcodigo(3);
        $pagador = $c->buscarpagadoresubsidio($pagadora);
        $c->registrarmovimiento($TrabajadorId, $_SESSION['CURRENT_ENTERPRISE'], date("Y-m-01", strtotime($fechainicio)), 2, $evento->getId(), $fechainicio, $fechatermino, $pagador->getCodigoPrevired(), $pagador->getNombre());
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Registro La Licencia del Trabajador con ID: " . $TrabajadorId . " Fecha Inicio: " . $fechainicio . " Fecha Termino: " . $fechatermino;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
        $contrato = $c->buscarcontrato($TrabajadorId);
        if ($contrato != null) {
            $contrato = $contrato->getId();
            $init = new DateTime($fechainicio);
            $end = new DateTime($fechatermino);
            while ($init <= $end) {
                $fechita = $init->format('Y-m-d');
                //Comprobar si el dia esta dentro de la licencia
                $asistencia = $c->validarasistencia($TrabajadorId, $contrato, $fechita);
                if ($asistencia == false) {
                    $c->registrarasistencia($TrabajadorId, $contrato, $fechita, 4);
                } else {
                    $c->actualizarasistencia($asistencia, 4);
                }
                $init->modify('+1 day');
            }
        }
    } else {
        echo 0;
    }
} else {
    echo "No se han recibido todos los datos";
}
