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

if (isset($_POST['rut']) && isset($_POST['nombre']) && isset($_POST['apellido1']) && isset($_POST['apellido2']) && isset($_POST['nacimiento']) && isset($_POST['civil']) && isset($_POST['reconocimiento']) && isset($_POST['pago']) && isset($_POST['causante']) && isset($_POST['sexo']) && isset($_POST['tramo']) && isset($_POST['comentario']) && isset($_SESSION['TRABAJADOR_ID']) && isset($_POST['id'])) {
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $nombre = strtoupper($nombre);
    $apellido1 = $_POST['apellido1'];
    $apellido1 = strtoupper($apellido1);
    $apellido2 = $_POST['apellido2'];
    $apellido2 = strtoupper($apellido2);
    $nacimiento = $_POST['nacimiento'];
    $civil = $_POST['civil'];
    $reconocimiento = $_POST['reconocimiento'];
    $pago = $_POST['pago'];
    $causante = $_POST['causante'];
    $sexo = $_POST['sexo'];
    $tramo = $_POST['tramo'];
    $comentario = $_POST['comentario'];
    $comentario = strtoupper($comentario);
    $vigencia = null;
    $id = $_POST['id'];
    if (isset($_POST['vigencia'])) {
        $vigencia = $_POST['vigencia'];
    }

    $trabajador = $_SESSION['TRABAJADOR_ID'];


    $file_name = "";
    if (isset($_FILES['documento'])) {
        //Validar si viene un archivo
        if ($_FILES['documento']['name'] != "") {
            //Sacar Nombre del Archivo
            $file_name = "carga_" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $file_name);
        }
    }



    if ($file_name != "") {
        $result = $c->actualizarcarga($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $causante, $sexo, $tramo, $file_name, $trabajador, $comentario);
        if ($result == true) {
            echo "1";
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la carga : " . $nombre . " con el Rut: " . $rut;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo "0";
        }
    } else {
        $result = $c->actualizarcarga1($id, $rut, $nombre, $apellido1, $apellido2, $nacimiento, $civil, $reconocimiento, $pago, $vigencia, $causante, $sexo, $tramo, $trabajador, $comentario);
        if ($result == true) {
            echo "1";
            $usuario = $_SESSION['USER_ID'];
            $eventos = "Se Actualizo la carga : " . $nombre . " con el Rut: " . $rut;
            $c->RegistrarAuditoriaEventos($usuario, $eventos);
        } else {
            echo "0";
        }
    }
}
