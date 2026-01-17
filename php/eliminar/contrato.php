<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['confirmado'])){
    $id = $_POST['id'];
    $confirmado = $_POST['confirmado'];

    // Verificar que el usuario confirmó la eliminación
    if($confirmado !== 'true'){
        echo json_encode(array("status"=>false,"message"=>"Eliminación cancelada por el usuario."));
        exit;
    }

    $contrato = $c->buscarcontratoid($id);
    if($contrato == null){
        echo json_encode(array("status"=>false,"message"=>"Contrato no encontrado."));
        exit;
    }

    $errores = array();
    $archivosEliminados = array();

        // 1. Eliminar asistencias
        if($c->buscarasistenciacontrato($id)){
            $asistencias = $c->listarasistenciasporcontrato($id);
            foreach($asistencias as $asistencia){
                if(!$c->eliminarasistencia($asistencia->id)){
                    $errores[] = "Error al eliminar asistencia ID: ".$asistencia->id;
                }
            }
        }

        // 2. Eliminar detalle de liquidaciones y liquidaciones
        $liquidaciones = $c->listarliquidacionesporcontrato($id);
        if($liquidaciones && count($liquidaciones) > 0){
            foreach($liquidaciones as $liquidacion){
                // Primero eliminar detalle de liquidación
                if(!$c->eliminardetalleliquidacion($liquidacion->getId())){
                    $errores[] = "Error al eliminar detalle de liquidación ID: ".$liquidacion->getId();
                }
                // Luego eliminar aporte empleador
                if(!$c->eliminaraporteempleador($liquidacion->getId())){
                    $errores[] = "Error al eliminar aporte empleador de liquidación ID: ".$liquidacion->getId();
                }
                // Finalmente eliminar liquidación
                if(!$c->eliminarliquidacion($liquidacion->getId())){
                    $errores[] = "Error al eliminar liquidación ID: ".$liquidacion->getId();
                }
            }
        }

        // 3. Eliminar clausulas de anexos y luego anexos
        if($c->buscaranexoscontrato($id)){
            $anexos = $c->listaranexosporcontrato($id);
            foreach($anexos as $anexo){
                // Eliminar clausulas del anexo
                if(!$c->eliminarclausulasanexo($anexo->getId())){
                    $errores[] = "Error al eliminar cláusulas del anexo ID: ".$anexo->getId();
                }
                // Eliminar anexo
                if(!$c->eliminaranexo($anexo->getId())){
                    $errores[] = "Error al eliminar anexo ID: ".$anexo->getId();
                }
            }
        }

        // 4. Eliminar finiquitos y sus relaciones
        if($c->buscarfiniquitocontrato($id)){
            $finiquitos = $c->listarfiniquitosporcontrato($id);
            foreach($finiquitos as $finiquito){
                // Eliminar detalle de finiquito
                if(!$c->eliminardetallefiniquito($finiquito->getId())){
                    $errores[] = "Error al eliminar detalle de finiquito ID: ".$finiquito->getId();
                }
                // Eliminar notificaciones del finiquito
                if(!$c->eliminarnotificacionesfiniquito($finiquito->getId())){
                    $errores[] = "Error al eliminar notificaciones del finiquito ID: ".$finiquito->getId();
                }
                // Eliminar finiquitos firmados
                if(!$c->eliminarfiniquitosfirmados($finiquito->getId())){
                    $errores[] = "Error al eliminar finiquitos firmados ID: ".$finiquito->getId();
                }
                // Eliminar lote3
                if(!$c->eliminarlote3finiquito($finiquito->getId())){
                    $errores[] = "Error al eliminar lote3 del finiquito ID: ".$finiquito->getId();
                }
                // Eliminar finiquito
                if(!$c->eliminarfiniquito($finiquito->getId())){
                    $errores[] = "Error al eliminar finiquito ID: ".$finiquito->getId();
                }
            }
        }

        // 5. Eliminar contratos firmados y sus archivos
        if($c->buscarcontratofirmadocontrato($id)){
            $contratosfirmados = $c->listarcontratosfirmadosporcontrato($id);
            foreach($contratosfirmados as $cf){
                $documentoFirmado = $cf->documento;
                if(!$c->eliminarcontratofirmado($cf->id)){
                    $errores[] = "Error al eliminar contrato firmado ID: ".$cf->id;
                }else{
                    // Eliminar archivo físico
                    if($documentoFirmado && file_exists("../../uploads/ContratosFirmados/".$documentoFirmado)){
                        if(unlink("../../uploads/ContratosFirmados/".$documentoFirmado)){
                            $archivosEliminados[] = $documentoFirmado;
                        }
                    }
                }
            }
        }

        // 6. Eliminar documentos generados por el contrato
        $documentos = $c->listardocumentosporcontrato($id);
        if($documentos && count($documentos) > 0){
            foreach($documentos as $doc){
                $archivoDoc = $doc->getDocumento();
                if(!$c->eliminardocumento($doc->getId())){
                    $errores[] = "Error al eliminar documento ID: ".$doc->getId();
                }else{
                    // Eliminar archivo físico
                    if($archivoDoc && file_exists("../../uploads/Documentos/".$archivoDoc)){
                        if(unlink("../../uploads/Documentos/".$archivoDoc)){
                            $archivosEliminados[] = $archivoDoc;
                        }
                    }
                }
            }
        }

        // 7. Eliminar horas pactadas
        $horaspactadas = $c->listarhoraspactadasporcontrato($id);
        if($horaspactadas && count($horaspactadas) > 0){
            foreach($horaspactadas as $hp){
                if(!$c->eliminarhoraspactadas($hp->id)){
                    $errores[] = "Error al eliminar horas pactadas ID: ".$hp->id;
                }
            }
        }

        // 8. Eliminar detalle de lotes
        $detallelotes = $c->listardetallelotesporcontrato($id);
        if($detallelotes && count($detallelotes) > 0){
            foreach($detallelotes as $dl){
                if(!$c->eliminardetallelote($dl->id)){
                    $errores[] = "Error al eliminar detalle de lote ID: ".$dl->id;
                }
            }
        }

        // 9. Eliminar lote2
        $lote2 = $c->listarlote2porcontrato($id);
        if($lote2 && count($lote2) > 0){
            foreach($lote2 as $l2){
                if(!$c->eliminarlote2($l2->id)){
                    $errores[] = "Error al eliminar lote2 ID: ".$l2->id;
                }
            }
        }

        // 10. Eliminar lote4
        $lote4 = $c->listarlote4porcontrato($id);
        if($lote4 && count($lote4) > 0){
            foreach($lote4 as $l4){
                if(!$c->eliminarlote4($l4->id)){
                    $errores[] = "Error al eliminar lote4 ID: ".$l4->id;
                }
            }
        }

    // Si hay errores, mostrar mensajes
    if(count($errores) > 0){
        echo json_encode(array(
            "status" => false,
            "message" => "Error al eliminar algunos registros relacionados",
            "errores" => $errores
        ));
        exit;
    }

    // 11. Finalmente, eliminar el contrato
    $documentoContrato = $contrato->getDocumento();
    $result = $c->eliminarcontrato($id);

    if($result == true){
        // Eliminar archivo físico del contrato
        if($documentoContrato && file_exists("../../uploads/Contratos/".$documentoContrato)){
            if(unlink("../../uploads/Contratos/".$documentoContrato)){
                $archivosEliminados[] = $documentoContrato;
            }
        }

        echo json_encode(array(
            "status" => true,
            "message" => "Contrato y todos sus registros relacionados eliminados correctamente.",
            "archivos_eliminados" => $archivosEliminados
        ));
    }else{
        echo json_encode(array("status"=>false,"message"=>"Error al eliminar el contrato."));
    }

}else{
    echo json_encode(array("status"=>false,"message"=>"Parámetros incompletos para eliminar el contrato."));
}
?>
