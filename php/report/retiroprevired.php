<?php
require '../controller.php';
$c = new Controller();
require '../plugins/vendor/autoload.php';
//phpspreadsheet for CSV
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $notificacion = $c->buscarnotificacion($id);
    $finiquito= $notificacion->getFiniquito();
    $finiquito = $c->buscarfiniquito1($finiquito);
    $contrato = $c->searchcontrato($finiquito->getContrato());
    $trabajador= $contrato->getTrabajador();
    $trabajador = $c->buscartrabajador($trabajador);
    $nacionalidad = $c->buscarnacionalidad($trabajador->getNacionalidad());
    $prevision = $c->buscarprevisiontrabajador($trabajador->getId());
    $afp = $c->buscarafp($prevision->getAfp());
    $isapre = $c->buscarisapre($prevision->getIsapre());
    $licencia = $c->ultimalicencia($trabajador->getId());
    if($licencia == false){
        echo "Este trabajador no tiene licencias medicas registradas";
    return;
    }
    $sexo = "M";
    if ($trabajador->getSexo() == 2) {
        $sexo = "F";
    }
    if($id > 0){
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('Hoja 1');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setDelimiter(';');
        $writer->setEnclosure('"');
        $writer->setLineEnding("\r\n");
        $spreadsheet->getActiveSheet()->setTitle('Hoja 1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'RUT del Trabajador');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'Digito Verificador del Trabajador');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Apellido Paterno del Trabajador');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'Apellido Materno del Trabajador');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Nombres del Trabajador');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'Código de Movimiento de Personal');
        $spreadsheet->getActiveSheet()->setCellValue('G1', 'Fecha de Inicio (Desde)');
        $spreadsheet->getActiveSheet()->setCellValue('H1', 'Fecha de Término (Hasta)');
        $spreadsheet->getActiveSheet()->setCellValue('I1', 'Código AFP');
        $spreadsheet->getActiveSheet()->setCellValue('J1', 'Código Institución de Salud');
        $spreadsheet->getActiveSheet()->setCellValue('K1', 'RUT Pagador de Subsidios');
        $spreadsheet->getActiveSheet()->setCellValue('L1', 'Digito Verificador Pagador de Subsidios');


            $trarut = str_replace(".", "", $trabajador->getRut());

            $dv = "";
            //dv = el ultimo digito del rut despues del guion
            $dv = substr($trarut, -1);
            //rut = el rut sin el guion ni el ultimo digito
            $rut = substr($trarut, 0, -2);
            $pos = 2;

            $spreadsheet->getActiveSheet()->setCellValue('A' . $pos, $rut);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $pos, $dv);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $pos, $trabajador->getNombre());
            $spreadsheet->getActiveSheet()->setCellValue('D' . $pos, $trabajador->getApellido1());
            $spreadsheet->getActiveSheet()->setCellValue('E' . $pos, $trabajador->getApellido2());
            $spreadsheet->getActiveSheet()->setCellValue('F' . $pos, "2");
            $spreadsheet->getActiveSheet()->setCellValue('G' . $pos, $contrato->getFechainicio());
            $spreadsheet->getActiveSheet()->setCellValue('H' . $pos, $notificacion->getFechanotificacion());
            $spreadsheet->getActiveSheet()->setCellValue('I' . $pos, $afp->getCodigoPrevired());
            $spreadsheet->getActiveSheet()->setCellValue('J' . $pos, $isapre->getCodigo());
            
            $pagador = str_replace(".", "", $licencia->getRegistro());
            $dv = "";
            //dv = el ultimo digito del rut despues del guion
            $dv = substr($pagador, -1);
            //rut = el rut sin el guion ni el ultimo digito
            $rut = substr($pagador, 0, -2);
            $spreadsheet->getActiveSheet()->setCellValue('K' . $pos, $rut);
            $spreadsheet->getActiveSheet()->setCellValue('L' . $pos, $dv);
            $pos++;                     


        $fecha = date("d-m-YHis");
        //Descargar por navegador
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="retiroprevired' . $fecha . '.csv"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    } else {
        echo "No se encontro el registro";
    }
}