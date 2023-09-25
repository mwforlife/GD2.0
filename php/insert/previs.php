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


if (isset($_POST['periodo']) && isset($_POST['TrabajadorAfp']) && isset($_POST['jubilado']) && isset($_POST['cesantia']) && isset($_POST['seguro']) && isset($_POST['periodocesantia']) && isset($_POST['TrabajadorIsapre']) && isset($_POST['TrabajadorMonedaPacto']) && isset($_POST['TrabajadorMonto']) && isset($_POST['TrabajadorTipoGes']) && isset($_POST['TrabajadorGes']) && isset($_SESSION['TRABAJADOR_ID']) && isset($_POST['tipoIsapre']) && isset($_POST['comentario']) && isset($_FILES['documentoafp']) && isset($_FILES['documentosalud']) && isset($_FILES['documentojubilacion'])) {
    $periodo = $_POST['periodo'];
    if (strlen($periodo) <= 0) {
        echo "El periodo no puede estar vacio";
        return false;
    }
    $periodo = $periodo . "-01";
    $TrabajadorAFP = $_POST['TrabajadorAfp'];
    if ($TrabajadorAFP <= 0) {
        echo "El AFP no puede estar vacio";
        return false;
    }


    $jubilado = $_POST['jubilado'];
    $cesantia = $_POST['cesantia'];
    $seguro = $_POST['seguro'];
    $periodocesantia = $_POST['periodocesantia'];
    if (strlen($periodocesantia) <= 0) {
        echo "El periodo Inicio de cesantia no puede estar vacio";
        return false;
    }
    $TrabajadorIsapre = $_POST['TrabajadorIsapre'];
    if ($TrabajadorIsapre <= 0) {
        echo "La Institucion de Salud no puede estar vacio";
        return false;
    }
    $TrabajadorMonedaPacto = $_POST['TrabajadorMonedaPacto'];
    $TrabajadorMonto = $_POST['TrabajadorMonto'];
    $TrabajadorTipoGes = $_POST['TrabajadorTipoGes'];
    $TrabajadorGes = $_POST['TrabajadorGes'];
    $tipoIsapre = $_POST['tipoIsapre'];
    if ($tipoIsapre <= 1) {
        $TrabajadorMonedaPacto = 3;
        $TrabajadorMonto = 0;
        $TrabajadorTipoGes = 3;
        $TrabajadorGes = 0;
    }
    $TrabajadorId = $_SESSION['TRABAJADOR_ID'];
    $comentario = $_POST['comentario'];
    $comentario = strtoupper($comentario);
    $name_afp_documento = "";
    if (isset($_FILES['documentoafp'])) {
        //Validar si viene un archivo
        if ($_FILES['documentoafp']['name'] != "") {
            //Sacar Nombre del Archivo
            $name_afp_documento = "AFP_DOCUMENT_" . date("dHis") . "." . pathinfo($_FILES['documentoafp']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documentoafp']['tmp_name'], $target_path . $name_afp_documento);
        }
    } else {
        echo "Debe subir un documento de AFP";
        return false;
    }
    $name_salud_documento = "";
    if (isset($_FILES['documentosalud'])) {
        //Validar si viene un archivo
        if ($_FILES['documentosalud']['name'] != "") {
            //Sacar Nombre del Archivo
            $name_salud_documento = "SALUD_DOCUMENT_" . date("dHis") . "." . pathinfo($_FILES['documentosalud']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documentosalud']['tmp_name'], $target_path . $name_salud_documento);
        }
    } else {
        echo "Debe subir un documento de Salud";
        return false;
    }
    $file_name = "";
    if (isset($_FILES['documentojubilacion'])) {
        //Validar si viene un archivo
        if ($_FILES['documentojubilacion']['name'] != "") {
            //Sacar Nombre del Archivo
            $file_name = "Prevision_" . date("dHis") . "." . pathinfo($_FILES['documentojubilacion']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documentojubilacion']['tmp_name'], $target_path . $file_name);
        }
    }
    $idpre = $c->validarprevision($periodo, $TrabajadorId);
    if ($idpre == false) {
        $result = $c->insertarprevision($periodo, $TrabajadorAFP, $jubilado, $cesantia, $seguro, $periodocesantia, $TrabajadorIsapre, $TrabajadorMonedaPacto, $TrabajadorMonto, $TrabajadorTipoGes, $TrabajadorGes, $TrabajadorId, $comentario, $name_afp_documento, $name_salud_documento, $file_name);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Registro La información de Prevision del Trabajador con el id: " . $TrabajadorId;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    } else {

        if ($name_afp_documento == "") {
            $name_afp_documento = $_POST['name_afp_documento'];
        }
        if ($name_salud_documento == "") {
            $name_salud_documento = $_POST['name_salud_documento'];
        }
        if ($file_name == "") {
            $file_name = $_POST['name_jubilacion_documento'];
        }
        $result = $c->actualizarprevision($idpre, $TrabajadorAFP, $jubilado, $cesantia, $seguro, $periodocesantia, $TrabajadorIsapre, $TrabajadorMonedaPacto, $TrabajadorMonto, $TrabajadorTipoGes, $TrabajadorGes, $comentario, $name_afp_documento, $name_salud_documento, $file_name);
        if ($result == true) {
            echo 1;
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la prevision  del trabajador con id: " . $TrabajadorId;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo 0;
        }
    }
} else {
    echo "No se han recibido todos los datos";
}
