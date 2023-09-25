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


if (isset($_POST['folio']) && isset($_POST['tipolicencia']) && isset($_POST['fechainicio']) && isset($_POST['fechatermino']) && isset($_POST['TrabajadorAfp']) && isset($_POST['comentario']) && isset($_POST['id']) && isset($_FILES['documentolicencia']) && isset($_FILES['comprobantetramite'])) {
    $folio = $_POST['folio'];
    $tipolicencia = $_POST['tipolicencia'];
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = $_POST['fechatermino'];
    $pagadora = $_POST['TrabajadorAfp'];
    $comentario = $_POST['comentario'];
    $comentario = strtoupper($comentario);
    $id = $_POST['id'];

    $file_name = "";
    if ($_FILES['documentolicencia']['name'] != "") {
        //Sacar Nombre del Archivo
        $file_name = "Licencia_" . date("dHis") . "." . pathinfo($_FILES['documentolicencia']['name'], PATHINFO_EXTENSION);

        //Ruta de la carpeta destino en servidor
        $target_path = "../../uploads/";

        //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
        move_uploaded_file($_FILES['documentolicencia']['tmp_name'], $target_path . $file_name);
    }

    $file_name2 = "";
    if ($_FILES['comprobantetramite']['name'] != "") {
        //Sacar Nombre del Archivo
        $file_name2 = "Tramite_" . date("dHis") . "." . pathinfo($_FILES['comprobantetramite']['name'], PATHINFO_EXTENSION);

        //Ruta de la carpeta destino en servidor
        $target_path = "../../uploads/";

        //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
        move_uploaded_file($_FILES['comprobantetramite']['tmp_name'], $target_path . $file_name2);
    }

    $result = $c->actualizarlicencia($id, $folio, $tipolicencia, $fechainicio, $fechatermino, $pagadora, $comentario, $file_name, $file_name2);
    if ($result == true) {
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Actualizo La Licencia del Trabajador con ID: " . $id . " Fecha Inicio: " . $fechainicio . " Fecha Termino: " . $fechatermino;
        $c->RegistrarAuditoriaEventos($usuario, $eventos);
    } else {
        echo 0;
    }
} else {
    echo "No se han recibido todos los datos";
}
