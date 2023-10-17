<?php
require '../controller.php';
$c = new Controller();
session_start();

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
        $empresa = $_SESSION['CURRENT_ENTERPRISE'];
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
    }else if($tipodocumento == 3){
        $notificacion = $c->buscarnotificacion($idnotificacion);

        $finiquito = $c->buscarfiniquito1($notificacion->getFiniquito());
        $empresa = $_SESSION['CURRENT_ENTERPRISE'];
        $centrocosto = $finiquito->getFecha();
        $existe = false;
        $documentonotificacion = "";
        $carta = "";
        if (isset($_FILES['documento']) && isset($_FILES['carta'])) {
            //Validar si viene un archivo
            if ($_FILES['documento']['name'] != "") {
                //Sacar Nombre del Archivo
                $name_afp_documento = "NOTIFICACION_CARGADO" . date("dHis") . "." . pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
    
                //Ruta de la carpeta destino en servidor
                $target_path = "../../uploads/documentosfirmados/";
    
                //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['documento']['tmp_name'], $target_path . $name_afp_documento);
                $documentonotificacion = $name_afp_documento;
                $existe = true;
    
            }
            if ($_FILES['carta']['name'] != "") {
                //Sacar Nombre del Archivo
                $name_afp_carta = "NOTIFICACION_CARTA_CARGADO" . date("dHis") . "." . pathinfo($_FILES['carta']['name'], PATHINFO_EXTENSION);
    
                //Ruta de la carpeta destino en servidor
                $target_path = "../../uploads/documentosfirmados/";
    
                //Movemos el archivo desde la ruta temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['carta']['tmp_name'], $target_path . $name_afp_carta);
                $carta = $name_afp_carta;
                $existe = true;
    
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el finiquito firmado'));
            return false;
        }

        
        $firmado = $c->buscarnotificacionfirmada($idnotificacion);
        if($firmado==false){
        $result = $c->registrarnotificacionfirmada($enterpriseid,$centrocosto,$idnotificacion,$documentonotificacion,$carta);
            if ($result == true) {
                echo json_encode(array('status' => true, 'message' => 'Se cargó el finiquito firmado'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el finiquito firmado'));
            }
        }else{
            $docu = $firmado->getDocumento();
            $carta1 = $firmado->getCarta();
            $docu_update = false;
            $carta_update = false;

            if($documentonotificacion!=""){
                $c->actualizarnotificacionfirmada($firmado->getId(),$documentonotificacion);
                $docu_update = true;
            }

            if($carta!=""){
                $c->actualizarnotificacionfirmada($firmado->getId(),$carta);
                $carta_update = true;
            }

            $message = "";
            
            if ($docu_update == true) {
                $message = "Se cargó el documento de notificación firmado";
                //Eliminamos el archivo anterior si es que existe
                if (file_exists($target_path . $docu)) {
                    unlink($target_path . $docu);
                }
            }

            if ($carta_update == true) {
                $message = "Se cargó la carta de notificación firmada";
                //Eliminamos el archivo anterior si es que existe
                if (file_exists($target_path . $carta1)) {
                    unlink($target_path . $carta1);
                }
            }

            if($existe == true && $message != ""){
                echo json_encode(array('status' => true, 'message' => $message));
            }else{
                echo json_encode(array('status' => false, 'message' => 'No se pudo cargar el documento de notificación firmado'));
            }
        }

    }
}else{
    echo json_encode(array('status' => false, 'message' => 'No se pudo cargaron los datos'));
}