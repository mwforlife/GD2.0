<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $contrato = $c->buscarcontratoid($id);

    if($contrato == null){
        echo json_encode(array("status"=>false,"message"=>"Contrato no encontrado."));
        exit;
    }

    // Obtener información del trabajador
    // El método buscarcontratoid() guarda el nombre completo en getTrabajador() y el ID en getFecharegistro()
    $nombreTrabajador = $contrato->getTrabajador(); // Ya viene el nombre completo
    $trabajadorId = $contrato->getFecharegistro(); // Aquí viene el ID del trabajador

    // Buscar el trabajador para obtener el RUT
    $trabajador = $c->buscartrabajador($trabajadorId);

    // Contador de registros relacionados
    $detalles = array(
        'trabajador' => array(
            'nombre' => $nombreTrabajador,
            'rut' => $trabajador ? $trabajador->getRut() : 'N/A'
        ),
        'contrato' => array(
            'tipocontrato' => $contrato->getTipocontrato(),
            'cargo' => $contrato->getCargo(),
            'fechainicio' => $contrato->getFechainicio(),
            'fechatermino' => $contrato->getFechatermino(),
            'documento' => $contrato->getDocumento()
        ),
        'registros_relacionados' => array()
    );

    // 1. Verificar asistencias
    $asistencias = $c->listarasistenciasporcontrato($id);
    if($asistencias && count($asistencias) > 0){
        $detalles['registros_relacionados']['asistencias'] = array(
            'cantidad' => count($asistencias),
            'tabla' => 'Asistencias'
        );
    }

    // 2. Verificar finiquitos
    if($c->buscarfiniquitocontrato($id)){
        $finiquitos = $c->listarfiniquitosporcontrato($id);
        $detalles['registros_relacionados']['finiquitos'] = array(
            'cantidad' => is_array($finiquitos) ? count($finiquitos) : 1,
            'tabla' => 'Finiquitos'
        );
    }

    // 3. Verificar contratos firmados
    if($c->buscarcontratofirmadocontrato($id)){
        $contratosfirmados = $c->listarcontratosfirmadosporcontrato($id);
        $detalles['registros_relacionados']['contratosfirmados'] = array(
            'cantidad' => is_array($contratosfirmados) ? count($contratosfirmados) : 1,
            'tabla' => 'Contratos Firmados'
        );
    }

    // 4. Verificar anexos
    if($c->buscaranexoscontrato($id)){
        $anexos = $c->listaranexosporcontrato($id);
        $detalles['registros_relacionados']['anexos'] = array(
            'cantidad' => is_array($anexos) ? count($anexos) : 1,
            'tabla' => 'Anexos de Contrato'
        );
    }

    // 5. Verificar detallelotes
    $detallelotes = $c->listardetallelotesporcontrato($id);
    if($detallelotes && count($detallelotes) > 0){
        $detalles['registros_relacionados']['detallelotes'] = array(
            'cantidad' => count($detallelotes),
            'tabla' => 'Detalle de Lotes'
        );
    }

    // 6. Verificar lote2
    $lote2 = $c->listarlote2porcontrato($id);
    if($lote2 && count($lote2) > 0){
        $detalles['registros_relacionados']['lote2'] = array(
            'cantidad' => count($lote2),
            'tabla' => 'Lote 2'
        );
    }

    // 7. Verificar lote4
    $lote4 = $c->listarlote4porcontrato($id);
    if($lote4 && count($lote4) > 0){
        $detalles['registros_relacionados']['lote4'] = array(
            'cantidad' => count($lote4),
            'tabla' => 'Lote 4'
        );
    }

    // 8. Verificar documentos
    $documentos = $c->listardocumentosporcontrato($id);
    if($documentos && count($documentos) > 0){
        $detalles['registros_relacionados']['documentos'] = array(
            'cantidad' => count($documentos),
            'tabla' => 'Documentos Generados'
        );
    }

    // 9. Verificar liquidaciones
    $liquidaciones = $c->listarliquidacionesporcontrato($id);
    if($liquidaciones && count($liquidaciones) > 0){
        $detalles['registros_relacionados']['liquidaciones'] = array(
            'cantidad' => count($liquidaciones),
            'tabla' => 'Liquidaciones de Sueldo'
        );
    }

    // 10. Verificar horaspactadas
    $horaspactadas = $c->listarhoraspactadasporcontrato($id);
    if($horaspactadas && count($horaspactadas) > 0){
        $detalles['registros_relacionados']['horaspactadas'] = array(
            'cantidad' => count($horaspactadas),
            'tabla' => 'Horas Pactadas'
        );
    }

    // Contar total de registros relacionados
    $totalRegistros = 0;
    foreach($detalles['registros_relacionados'] as $registro){
        $totalRegistros += $registro['cantidad'];
    }

    $detalles['total_registros_relacionados'] = $totalRegistros;

    echo json_encode(array(
        "status" => true,
        "data" => $detalles
    ));

}else{
    echo json_encode(array("status"=>false,"message"=>"ID de contrato no proporcionado."));
}
?>
