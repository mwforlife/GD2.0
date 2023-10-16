<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['enterpriseid']) && isset($_POST['idcontrato']) && isset($_POST['idfiniquito']) && isset($_POST['idnotificacion']) && isset($_POST['iddocumento']) && isset($_POST['tipodocumento']) && isset($_FILES['documento'])){
    $enterpriseid = $_POST['enterpriseid'];
    $idcontrato = $_POST['idcontrato'];
    $idfiniquito = $_POST['idfiniquito'];
    $idnotificacion = $_POST['idnotificacion'];
    $iddocumento = $_POST['iddocumento'];
    $tipodocumento = $_POST['tipodocumento'];
    $documento = $_FILES['documento'];

    if($tipodocumento==1){

        $contrato = $c->buscarcontratoid1($idcontrato);
        $empresa = $contrato->getEmpresa();
        $centrocosto = $contrato->getCentrocosto();
        if (isset($_FILES['documento'])) {
            //Validar si viene un archivo
            if ($_FILES['documento']['name'] != "") {
                //Sacar Nombre del Archivo
                $name_afp_documento = "CONTRATO_CARGADO" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
    
                //Ruta de la carpeta destino en servidor
                $target_path = "../../uploads/documentosfirmados/";
    
                //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $name_afp_documento);
    
                $firmado = $c->buscarcontratofirmado($idcontrato);
                if($firmado==false){
                $result = $c->registrarcontratofirmado($enterpriseid,$centrocosto,$idcontrato,$name_afp_documento);
                    if ($result == true) {
                        echo json_encode(array('status' => true, 'message' => 'Se cargó el contrato firmado'));
                    } else {
                        echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el contrato firmado'));
                    }
                }else{
                    $docu = $firmado->getDocumento();
                    $result = $c->actualizarcontratofirmado($firmado->getId(),$name_afp_documento);
                    if ($result == true) {
                        echo json_encode(array('status' => true, 'message' => 'Se cargó el contrato firmado'));
                        //Eliminamos el archivo anterior si es que existe
                        if (file_exists($target_path . $docu)) {
                            unlink($target_path . $docu);
                        }
                        
                    } else {
                        echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el contrato firmado'));
                    }
                }
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el contrato firmado'));
            return false;
        }


    }else if($tipodocumento==2){

        $finiquito = $c->buscarfiniquito1($idfiniquito);
        $empresa = $finiquito->getEmpresa();
        $centrocosto = $finiquito->getFecha();
        if (isset($_FILES['documento'])) {
            //Validar si viene un archivo
            if ($_FILES['documento']['name'] != "") {
                //Sacar Nombre del Archivo
                $name_afp_documento = "FINIQUITO_CARGADO" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
    
                //Ruta de la carpeta destino en servidor
                $target_path = "../../uploads/documentosfirmados/";
    
                //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $name_afp_documento);
    
                $firmado = $c->buscarfiniquitofirmado($idfiniquito);
                if($firmado==false){
                $result = $c->registrarfiniquitofirmado($enterpriseid,$centrocosto,$idfiniquito,$name_afp_documento);
                    if ($result == true) {
                        echo json_encode(array('status' => true, 'message' => 'Se cargó el finiquito firmado'));
                    } else {
                        echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el finiquito firmado'));
                    }
                }else{
                    $docu = $firmado->getDocumento();
                    $result = $c->actualizarfiniquitofirmado($firmado->getId(),$name_afp_documento);
                    if ($result == true) {
                        echo json_encode(array('status' => true, 'message' => 'Se cargó el finiquito firmado'));
                        //Eliminamos el archivo anterior si es que existe
                        if (file_exists($target_path . $docu)) {
                            unlink($target_path . $docu);
                        }
                        
                    } else {
                        echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el finiquito firmado'));
                    }
                }
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el finiquito firmado'));
            return false;
        }
    }
}else{
    echo json_encode(array('status' => false, 'message' => 'No se pudo cargaron los datos'));
}