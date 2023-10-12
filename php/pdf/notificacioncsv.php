<?php
require '../controller.php';
$c = new Controller();
require '../plugins/vendor/autoload.php';
//phpspreadsheet for CSV
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

session_start();

if (isset($_SESSION['USER_ID']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id <= 0) {
        echo "Debe seleccionar un documento de notificacion";
        return;
    }
    $notif = $c->buscarnotificacion($id);
    if ($notif == false) {
        echo "No se encontro el documento de notificacion";
        return;
    }
    $usuario = $_SESSION['USER_ID'];
    $fechanotificacion = $notif->getFechanotificacion();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechanotificacion = date("d/m/Y", strtotime($fechanotificacion));
    $finiquito = $notif->getFiniquito();
    $finiquito = $c->buscarfiniquitotext($finiquito);
    $contrato = $c->buscarcontratoid($finiquito->getContrato());
    $tipocontratoid = $notif->getTipodocumento();
    $causal = $notif->getCausal();
    $causalhechos = $notif->getCausalhechos();
    $comunicacion = $notif->getComunicacion();
    $comunac = "";
    if ($comunicacion == 2) {
        $comunicacion = "C";
        $comuna = $notif->getComuna();
        $comunac = $c->buscarcomuna($comuna);
        $comunac = $comunac->getNombre();
    } else {
        $comunicacion = "P";
    }
    $cotipre = $notif->getCotizacionprevisional();

    $acreditacion = $notif->getAcrediacion();
    $trabajadorid = $finiquito->getTrabajador();
    $empresa = $finiquito->getEmpresa();
    $fechafiniquito = $finiquito->getFechafiniquito();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechafiniquito = date("d/m/Y", strtotime($fechafiniquito));
    $fechainicio = $finiquito->getFechainicio();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechainicio = date("d/m/Y", strtotime($fechainicio));
    $fechatermino = $finiquito->getFechatermino();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechatermino = date("d/m/Y", strtotime($fechatermino));


    $causal = $c->buscarcausalterminacioncontrato($causal);
    $causalcod = $causal->getCodigo();
    $acticulo = $causal->getNombre();
    //Extraer texto dentro de parentesis
    $acticulo = $c->extrartexto($acticulo);
    $trabajador = $c->buscartrabajador($trabajadorid);
    $dom = $c->ultimodomicilio($trabajadorid);
    $comunatra = $c->buscarcomuna($dom->getComuna());
    $regiontra = $dom->getRegion();
    $regiontra = $c->buscarregion($regiontra);

    $empresa = $c->buscarempresa($empresa);
    $comuna = $empresa->getComuna();
    $region = $empresa->getRegion();
    $sexo = $trabajador->getSexo();
    if($sexo == 1){
        $sexo = "M";
    }else{
        $sexo = "F";
    }
    $repre = $c->BuscarRepresentanteLegal($empresa->getId());
    $detfin = $c->listardetallefiniquitoids($notif->getFiniquito());

    $detalle = "";
    $descuento = 0;
    $haber = 0;
    $saldo = 0;
    $montoanioservicio = 0;
    $montoavisoprevio = 0;
    foreach ($detfin as $df) {
        if($df->getIndemnizacion()==3){
            $montoanioservicio = $df->getMonto();
        }else if($df->getIndemnizacion()==6){
            $montoavisoprevio = $df->getMonto();
        }
    }

    $trarut = str_replace(".", "", $trabajador->getRut());
    $dv = "";
    //dv = el ultimo digito del rut despues del guion
    $dv = substr($trarut, -1);
    //rut = el rut sin el guion ni el ultimo digito
    $rut = substr($trarut, 0, -2);

    $spreadsheet = new Spreadsheet();
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
    $spreadsheet->getActiveSheet()->setCellValue('A1', 'rut_tr');
    $spreadsheet->getActiveSheet()->setCellValue('B1', 'dv_tr');
    $spreadsheet->getActiveSheet()->setCellValue('C1', 'nombres_tr');
    $spreadsheet->getActiveSheet()->setCellValue('D1', 'ap_paterno_tr');
    $spreadsheet->getActiveSheet()->setCellValue('E1', 'ap_materno_tr');
    $spreadsheet->getActiveSheet()->setCellValue('F1', 'comuna_tr');
    $spreadsheet->getActiveSheet()->setCellValue('G1', 'sexo');
    $spreadsheet->getActiveSheet()->setCellValue('H1', 'fecha_notificacion');
    $spreadsheet->getActiveSheet()->setCellValue('I1', 'medio_notificacion');
    $spreadsheet->getActiveSheet()->setCellValue('J1', 'oficica_correos');
    $spreadsheet->getActiveSheet()->setCellValue('K1', 'fecha_inicio');
    $spreadsheet->getActiveSheet()->setCellValue('L1', 'fecha_termino');
    $spreadsheet->getActiveSheet()->setCellValue('M1', 'monto_anio_servicio');
    $spreadsheet->getActiveSheet()->setCellValue('N1', 'monto_aviso_previo');
    $spreadsheet->getActiveSheet()->setCellValue('O1', 'CodigoTipoCausal');
    $spreadsheet->getActiveSheet()->setCellValue('P1', 'ArticuloCausal');
    $spreadsheet->getActiveSheet()->setCellValue('Q1', 'HechosCausal');
    $spreadsheet->getActiveSheet()->setCellValue('R1', 'EstadoCotizaciones');
    $spreadsheet->getActiveSheet()->setCellValue('S1', 'TipoDocCotizaciones');

    $spreadsheet->getActiveSheet()->setCellValue('A2', $rut);
    $spreadsheet->getActiveSheet()->setCellValue('B2', $dv);
    $spreadsheet->getActiveSheet()->setCellValue('C2', $trabajador->getNombre());
    $spreadsheet->getActiveSheet()->setCellValue('D2', $trabajador->getApellido1());
    $spreadsheet->getActiveSheet()->setCellValue('E2', $trabajador->getApellido2());
    $spreadsheet->getActiveSheet()->setCellValue('F2', $comunatra->getCodigox());
    $spreadsheet->getActiveSheet()->setCellValue('G2', $sexo);
    $spreadsheet->getActiveSheet()->setCellValue('H2', $fechanotificacion);
    $spreadsheet->getActiveSheet()->setCellValue('I2', $comunicacion);
    $spreadsheet->getActiveSheet()->setCellValue('J2', $comunac);
    $spreadsheet->getActiveSheet()->setCellValue('K2', $fechainicio);
    $spreadsheet->getActiveSheet()->setCellValue('L2', $fechatermino);
    $spreadsheet->getActiveSheet()->setCellValue('M2', $montoanioservicio);
    $spreadsheet->getActiveSheet()->setCellValue('N2', $montoavisoprevio);
    $spreadsheet->getActiveSheet()->setCellValue('O2', $causalcod);
    $spreadsheet->getActiveSheet()->setCellValue('P2', $acticulo);
    $spreadsheet->getActiveSheet()->setCellValue('Q2', $causalhechos);
    $spreadsheet->getActiveSheet()->setCellValue('R2', $cotipre);
    $spreadsheet->getActiveSheet()->setCellValue('S2', $acreditacion);

    $fechadate = date("d-m-YHis");

    //Descargar por navegador
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="notificaciones'.$fechadate.'.xls"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}
