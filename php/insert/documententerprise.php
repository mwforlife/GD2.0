<?php
require '../controller.php';
$c = new Controller();
session_start();
$empresa = $_SESSION['CURRENT_ENTERPRISE'];
if(isset($_POST['tipo']) && isset($_POST['centrocosto']) && isset($_POST['periodo']) && isset($_FILES['documento'])){
    $tipo = $_POST['tipo'];
    $centrocosto = $_POST['centrocosto'];
    $centrocostoarray = array();

    if($centrocosto<=0){
        $centrocostoarray = $c->listarcentrocosto($empresa);
    }

    $periodo = $_POST['periodo'];
    if($periodo==""){
        echo json_encode(array('status' => false, 'message' => 'Ingrese el Periodo'));
        return false;
    }else{
        $periodo = date('Y-m-01',strtotime($periodo));
    }

    if (isset($_FILES['documento'])) {
        //Validar si viene un archivo
        if ($_FILES['documento']['name'] != "") {
            //Sacar Nombre del Archivo
            $name_afp_documento = "DOCUMENTO_EMPRESA" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/documento_empresa/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $name_afp_documento);

            if($centrocosto<=0){
                foreach($centrocostoarray as $centro){
                    $result = $c->registrardocumentoempresa($tipo,$centro->getId(),$name_afp_documento,$periodo,$empresa);
                }
            }else{
                $result = $c->registrardocumentoempresa($tipo,$centrocosto,$name_afp_documento,$periodo,$empresa);
            }

            echo json_encode(array('status' => true, 'message' => 'Documento Registrado con Exito'));
        }else{
            echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el documento'));
            return false;
        }
    } else {
        echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el contrato firmado'));
        return false;
    }

}else if(isset($_POST['tipo']) && isset($_POST['centrocosto']) && isset($_FILES['documento'])){
    $tipo = $_POST['tipo'];
    $centrocosto = $_POST['centrocosto'];
    $periodo = "";

    $centrocostoarray = array();

    if($centrocosto<=0){
        $centrocostoarray = $c->listarcentrocosto($empresa);
    }

    if (isset($_FILES['documento'])) {
        //Validar si viene un archivo
        if ($_FILES['documento']['name'] != "") {
            //Sacar Nombre del Archivo
            $name_afp_documento = "DOCUMENTO_EMPRESA" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);

            //Ruta de la carpeta destino en servidor
            $target_path = "../../uploads/documento_empresa/";

            //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
            move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $name_afp_documento);

            if($centrocosto<=0){
                foreach($centrocostoarray as $centro){
                    $result = $c->registrardocumentoempresa($tipo,$centro->getId(),$name_afp_documento,$periodo,$empresa);
                }
            }else{
                $result = $c->registrardocumentoempresa($tipo,$centrocosto,$name_afp_documento,$periodo,$empresa);
            }
            echo json_encode(array('status' => true, 'message' => 'Documento Registrado Correctamente'));
        }else{
            echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el documento'));
            return false;
        }
    } else {
        echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el contrato firmado'));
        return false;
    }
    
}else{
    echo json_encode(array('status' => 'error', 'message' => 'No se enviaron todos los datos'));
    exit();
}