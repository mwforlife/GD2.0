<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $loteId = $_POST['id'];

    // Obtener lista de contratos en el lote
    $contratos = $c->listarlotestext3($loteId);

    if(!$contratos || count($contratos) == 0){
        echo json_encode(array("status"=>false,"message"=>"No se encontraron contratos en este lote."));
        exit;
    }

    $detallesContratos = array();
    $totalRegistrosGlobal = 0;

    // Procesar cada contrato del lote
    foreach($contratos as $loteContrato){
        $contratoId = $loteContrato->getContrato();
        $contrato = $c->buscarcontratoid($contratoId);

        if($contrato == null){
            continue; // Saltar si el contrato no existe
        }

        // Obtener información del trabajador
        $nombreTrabajador = $loteContrato->getTrabajador(); // Nombre completo del trabajador
        $trabajadorId = $contrato->getFecharegistro(); // ID del trabajador

        // Buscar el trabajador para obtener el RUT
        $trabajador = $c->buscartrabajador($trabajadorId);

        // Contador de registros relacionados para este contrato
        $registrosRelacionados = array();
        $totalRegistros = 0;

        // 1. Verificar asistencias
        $asistencias = $c->listarasistenciasporcontrato($contratoId);
        if($asistencias && count($asistencias) > 0){
            $registrosRelacionados['asistencias'] = count($asistencias);
            $totalRegistros += count($asistencias);
        }

        // 2. Verificar finiquitos
        if($c->buscarfiniquitocontrato($contratoId)){
            $finiquitos = $c->listarfiniquitosporcontrato($contratoId);
            $cantidad = is_array($finiquitos) ? count($finiquitos) : 1;
            $registrosRelacionados['finiquitos'] = $cantidad;
            $totalRegistros += $cantidad;
        }

        // 3. Verificar contratos firmados
        if($c->buscarcontratofirmadocontrato($contratoId)){
            $contratosfirmados = $c->listarcontratosfirmadosporcontrato($contratoId);
            $cantidad = is_array($contratosfirmados) ? count($contratosfirmados) : 1;
            $registrosRelacionados['contratosfirmados'] = $cantidad;
            $totalRegistros += $cantidad;
        }

        // 4. Verificar anexos
        if($c->buscaranexoscontrato($contratoId)){
            $anexos = $c->listaranexosporcontrato($contratoId);
            $cantidad = is_array($anexos) ? count($anexos) : 1;
            $registrosRelacionados['anexos'] = $cantidad;
            $totalRegistros += $cantidad;
        }

        // 5. Verificar detallelotes
        $detallelotes = $c->listardetallelotesporcontrato($contratoId);
        if($detallelotes && count($detallelotes) > 0){
            $registrosRelacionados['detallelotes'] = count($detallelotes);
            $totalRegistros += count($detallelotes);
        }

        // 6. Verificar lote2
        $lote2 = $c->listarlote2porcontrato($contratoId);
        if($lote2 && count($lote2) > 0){
            $registrosRelacionados['lote2'] = count($lote2);
            $totalRegistros += count($lote2);
        }

        // 7. Verificar lote4
        $lote4 = $c->listarlote4porcontrato($contratoId);
        if($lote4 && count($lote4) > 0){
            $registrosRelacionados['lote4'] = count($lote4);
            $totalRegistros += count($lote4);
        }

        // 8. Verificar documentos
        $documentos = $c->listardocumentosporcontrato($contratoId);
        if($documentos && count($documentos) > 0){
            $registrosRelacionados['documentos'] = count($documentos);
            $totalRegistros += count($documentos);
        }

        // 9. Verificar liquidaciones
        $liquidaciones = $c->listarliquidacionesporcontrato($contratoId);
        if($liquidaciones && count($liquidaciones) > 0){
            $registrosRelacionados['liquidaciones'] = count($liquidaciones);
            $totalRegistros += count($liquidaciones);
        }

        // 10. Verificar horaspactadas
        $horaspactadas = $c->listarhoraspactadasporcontrato($contratoId);
        if($horaspactadas && count($horaspactadas) > 0){
            $registrosRelacionados['horaspactadas'] = count($horaspactadas);
            $totalRegistros += count($horaspactadas);
        }

        // Agregar detalles de este contrato al array
        $detallesContratos[] = array(
            'contrato_id' => $contratoId,
            'trabajador' => array(
                'nombre' => $nombreTrabajador,
                'rut' => $trabajador ? $trabajador->getRut() : 'N/A'
            ),
            'contrato' => array(
                'tipocontrato' => $contrato->getTipocontrato(),
                'cargo' => $contrato->getCargo(),
                'fechainicio' => $contrato->getFechainicio(),
                'fechatermino' => $contrato->getFechatermino()
            ),
            'registros_relacionados' => $registrosRelacionados,
            'total_registros' => $totalRegistros
        );

        $totalRegistrosGlobal += $totalRegistros;
    }

    // Obtener nombre del lote
    $nombreLote = count($contratos) > 0 ? $contratos[0]->getNombre_lote() : 'Lote';

    echo json_encode(array(
        "status" => true,
        "data" => array(
            'nombre_lote' => $nombreLote,
            'total_contratos' => count($detallesContratos),
            'total_registros_relacionados' => $totalRegistrosGlobal,
            'contratos' => $detallesContratos
        )
    ));

}else{
    echo json_encode(array("status"=>false,"message"=>"ID de lote no proporcionado."));
}
?>
