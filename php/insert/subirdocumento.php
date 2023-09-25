<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['titulo']) && isset($_POST['tipo']) && isset($_POST['trabajadorid']) && isset($_POST['empresa']) && isset($_POST['comentario']) && isset($_FILES['documento'])) {
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $id = $_POST['trabajadorid'];
    $empresa = $_POST['empresa'];
    $comentario = $_POST['comentario'];
    $documento = $_FILES['documento'];

    if (strlen($titulo) <= 0) {
        echo "El titulo no puede estar vacio";
        return;
    }

    if ($tipo <= 0) {
        echo "Debe seleccionar un tipo de documento";
        return;
    }

    if ($id <= 0) {
        echo "Debe seleccionar un Trabajador";
        return;
    }

    if ($empresa <= 0) {
        echo "Debe seleccionar una Empresa";
        return;
    }


    if (isset($_FILES['documento'])) {
        //Validar si viene un archivo
        if ($_FILES['documento']['name'] != "") {
            //Sacar Nombre del Archivo
            $name_afp_documento = "DOCUMENTO_SUBIDO_" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/documentosubido/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $name_afp_documento);

            $result = $c->query("insert into documentosubido values (null, '$titulo', $tipo, '$comentario', $id, $empresa, '$name_afp_documento',now());");
            if ($result == true) {
                echo 1;
            } else {
                echo 0;
            }
        }
    } else {
        echo "Debe subir un documento ";
        return false;
    }
} else {
    echo "No llegaron todos los datos";
}
