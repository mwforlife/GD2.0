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

    // Obtener lista de contratos en el lote
    $lista1 = $c->listarlotestext3($id);

    if(!$lista1 || count($lista1) == 0){
        echo json_encode(array("status"=>false,"message"=>"No se encontraron contratos en este lote."));
        exit;
    }

    $errores = array();
    $archivosEliminados = array();

    // Procesar cada contrato del lote
    foreach ($lista1 as $object) {
        $contratoId = $object->getContrato();
        $contrato = $c->buscarcontratoid($contratoId);

        if ($contrato == null) {
            continue; // Saltar si el contrato no existe
        }

        // 1. Eliminar asistencias
        if($c->buscarasistenciacontrato($contratoId)){
            $asistencias = $c->listarasistenciasporcontrato($contratoId);
            foreach($asistencias as $asistencia){
                if(!$c->eliminarasistencia($asistencia->id)){
                    $errores[] = "Error al eliminar asistencia ID: ".$asistencia->id." del contrato ID: ".$contratoId;
                }
            }
        }

        // 2. Eliminar detalle de liquidaciones y liquidaciones
        $liquidaciones = $c->listarliquidacionesporcontrato($contratoId);
        if($liquidaciones && count($liquidaciones) > 0){
            foreach($liquidaciones as $liquidacion){
                // Primero eliminar detalle de liquidación
                if(!$c->eliminardetalleliquidacion($liquidacion->getId())){
                    $errores[] = "Error al eliminar detalle de liquidación ID: ".$liquidacion->getId()." del contrato ID: ".$contratoId;
                }
                // Luego eliminar aporte empleador
                if(!$c->eliminaraporteempleador($liquidacion->getId())){
                    $errores[] = "Error al eliminar aporte empleador de liquidación ID: ".$liquidacion->getId()." del contrato ID: ".$contratoId;
                }
                // Finalmente eliminar liquidación
                if(!$c->eliminarliquidacion($liquidacion->getId())){
                    $errores[] = "Error al eliminar liquidación ID: ".$liquidacion->getId()." del contrato ID: ".$contratoId;
                }
            }
        }

        // 3. Eliminar clausulas de anexos y luego anexos
        if($c->buscaranexoscontrato($contratoId)){
            $anexos = $c->listaranexosporcontrato($contratoId);
            foreach($anexos as $anexo){
                // Eliminar clausulas del anexo
                if(!$c->eliminarclausulasanexo($anexo->getId())){
                    $errores[] = "Error al eliminar cláusulas del anexo ID: ".$anexo->getId()." del contrato ID: ".$contratoId;
                }
                // Eliminar anexo
                if(!$c->eliminaranexo($anexo->getId())){
                    $errores[] = "Error al eliminar anexo ID: ".$anexo->getId()." del contrato ID: ".$contratoId;
                }
            }
        }

        // 4. Eliminar finiquitos y sus relaciones
        if($c->buscarfiniquitocontrato($contratoId)){
            $finiquitos = $c->listarfiniquitosporcontrato($contratoId);
            foreach($finiquitos as $finiquito){
                // Eliminar detalle de finiquito
                if(!$c->eliminardetallefiniquito($finiquito->getId())){
                    $errores[] = "Error al eliminar detalle de finiquito ID: ".$finiquito->getId()." del contrato ID: ".$contratoId;
                }
                // Eliminar notificaciones del finiquito
                if(!$c->eliminarnotificacionesfiniquito($finiquito->getId())){
                    $errores[] = "Error al eliminar notificaciones del finiquito ID: ".$finiquito->getId()." del contrato ID: ".$contratoId;
                }
                // Eliminar finiquitos firmados
                if(!$c->eliminarfiniquitosfirmados($finiquito->getId())){
                    $errores[] = "Error al eliminar finiquitos firmados ID: ".$finiquito->getId()." del contrato ID: ".$contratoId;
                }
                // Eliminar lote3
                if(!$c->eliminarlote3finiquito($finiquito->getId())){
                    $errores[] = "Error al eliminar lote3 del finiquito ID: ".$finiquito->getId()." del contrato ID: ".$contratoId;
                }
                // Eliminar finiquito
                if(!$c->eliminarfiniquito($finiquito->getId())){
                    $errores[] = "Error al eliminar finiquito ID: ".$finiquito->getId()." del contrato ID: ".$contratoId;
                }
            }
        }

        // 5. Eliminar contratos firmados y sus archivos
        if($c->buscarcontratofirmadocontrato($contratoId)){
            $contratosfirmados = $c->listarcontratosfirmadosporcontrato($contratoId);
            foreach($contratosfirmados as $cf){
                $documentoFirmado = $cf->documento;
                if(!$c->eliminarcontratofirmado($cf->id)){
                    $errores[] = "Error al eliminar contrato firmado ID: ".$cf->id." del contrato ID: ".$contratoId;
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
        $documentos = $c->listardocumentosporcontrato($contratoId);
        if($documentos && count($documentos) > 0){
            foreach($documentos as $doc){
                $archivoDoc = $doc->getDocumento();
                if(!$c->eliminardocumento($doc->getId())){
                    $errores[] = "Error al eliminar documento ID: ".$doc->getId()." del contrato ID: ".$contratoId;
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
        $horaspactadas = $c->listarhoraspactadasporcontrato($contratoId);
        if($horaspactadas && count($horaspactadas) > 0){
            foreach($horaspactadas as $hp){
                if(!$c->eliminarhoraspactadas($hp->id)){
                    $errores[] = "Error al eliminar horas pactadas ID: ".$hp->id." del contrato ID: ".$contratoId;
                }
            }
        }

        // 8. Eliminar detalle de lotes
        $detallelotes = $c->listardetallelotesporcontrato($contratoId);
        if($detallelotes && count($detallelotes) > 0){
            foreach($detallelotes as $dl){
                if(!$c->eliminardetallelote($dl->id)){
                    $errores[] = "Error al eliminar detalle de lote ID: ".$dl->id." del contrato ID: ".$contratoId;
                }
            }
        }

        // 9. Eliminar lote2
        $lote2 = $c->listarlote2porcontrato($contratoId);
        if($lote2 && count($lote2) > 0){
            foreach($lote2 as $l2){
                if(!$c->eliminarlote2($l2->id)){
                    $errores[] = "Error al eliminar lote2 ID: ".$l2->id." del contrato ID: ".$contratoId;
                }
            }
        }

        // 10. Eliminar lote4
        $lote4 = $c->listarlote4porcontrato($contratoId);
        if($lote4 && count($lote4) > 0){
            foreach($lote4 as $l4){
                if(!$c->eliminarlote4($l4->id)){
                    $errores[] = "Error al eliminar lote4 ID: ".$l4->id." del contrato ID: ".$contratoId;
                }
            }
        }

        // 11. Finalmente, eliminar el contrato
        $documentoContrato = $contrato->getDocumento();
        $result = $c->eliminarcontrato($contratoId);

        if($result == true){
            // Eliminar archivo físico del contrato
            if($documentoContrato && file_exists("../../uploads/Contratos/".$documentoContrato)){
                if(unlink("../../uploads/Contratos/".$documentoContrato)){
                    $archivosEliminados[] = $documentoContrato;
                }
            }
        }else{
            $errores[] = "Error al eliminar el contrato ID: ".$contratoId;
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

    // Eliminar el lote
    $resultLote = $c->eliminarlotecontrato($id);

    if($resultLote){
        echo json_encode(array(
            "status" => true,
            "message" => "Lote de contratos y todos sus registros relacionados eliminados correctamente.",
            "archivos_eliminados" => $archivosEliminados,
            "total_contratos_eliminados" => count($lista1)
        ));
    }else{
        echo json_encode(array("status"=>false,"message"=>"Error al eliminar el lote."));
    }

}else{
    echo json_encode(array("status"=>false,"message"=>"Parámetros incompletos para eliminar el lote de contratos."));
}
?>