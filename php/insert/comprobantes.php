<?php
require '../controller.php';
$c = new Controller();

if(isset($_FILES['documentocom']) && isset($_POST['idvacaciones'])){
    $file_name = "";
    if (isset($_FILES['documentocom'])) {
        //Validar si viene un archivo
        if ($_FILES['documentocom']['name'] != "") {
            //Sacar Nombre del Archivo
            $file_name = "Comprobante_" . date("dHis") . "." . pathinfo($_FILES['documentocom']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/Comprobantes/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documentocom']['tmp_name'], $target_path . $file_name);
        }else{
            echo "Debe subir un documento de Comprobante";
            return false;
        }
    }else{
        echo "Debe subir un documento de Comprobante";
        return false;
    }
    $idvacaciones = $_POST['idvacaciones'];
    $result = $c->cargarcomprobantefirmado($file_name, $idvacaciones);
    if($result==true){
        echo 1;
    }else{
        echo "No se pudo cargar el comprobante";
    }
}else{
    echo "No llegaron los datos";
}