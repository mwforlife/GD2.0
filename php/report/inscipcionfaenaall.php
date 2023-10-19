<?php
require '../controller.php';
$c = new Controller();
require '../plugins/vendor/autoload.php';
//phpspreadsheet for CSV
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

session_start();

if (isset($_GET['id'])) {
    $lista1 = $c->listarlotestext2($_GET['id']);
    $pdffiles = array();

    $spreadsheet = new Spreadsheet();
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
    $spreadsheet->getActiveSheet()->setTitle('PLANTILLA_TRABAJADORES');
    $writer->setDelimiter(';');
    $writer->setEnclosure('"');
    $writer->setLineEnding("\r\n");
    $spreadsheet->getActiveSheet()->setTitle('Hoja 1');
    $spreadsheet->getActiveSheet()->setCellValue('A1', 'RUT');
    $spreadsheet->getActiveSheet()->setCellValue('B1', 'DV');
    $spreadsheet->getActiveSheet()->setCellValue('C1', 'NOMBRE');
    $spreadsheet->getActiveSheet()->setCellValue('D1', 'PATERNO');
    $spreadsheet->getActiveSheet()->setCellValue('E1', 'MATERNO');
    $spreadsheet->getActiveSheet()->setCellValue('F1', 'SEXO');
    $spreadsheet->getActiveSheet()->setCellValue('G1', 'CONTACTADO');
    $spreadsheet->getActiveSheet()->setCellValue('H1', 'CONTRATADO');
    $spreadsheet->getActiveSheet()->setCellValue('I1', 'NACIONALIDAD');
    $pos = 2;
    foreach ($lista1 as $object) {
        $id = $object->getFecha_fin();
        $contrato = $c->searchcontrato($id);
        $trabajador = $contrato->getTrabajador();
        $trabajador = $c->buscartrabajador($trabajador);
        $nacionalidad = $c->buscarnacionalidad($trabajador->getNacionalidad());
        $sexo = "M";
        if ($trabajador->getSexo() == 2) {
            $sexo = "F";
        }
        if ($id > 0) {
            $trarut = str_replace(".", "", $trabajador->getRut());

            $dv = "";
            //dv = el ultimo digito del rut despues del guion
            $dv = substr($trarut, -1);
            //rut = el rut sin el guion ni el ultimo digito
            $rut = substr($trarut, 0, -2);
            $nombre = $trabajador->getNombre();
            $apellido1 = $trabajador->getApellido1();
            $apellido2 = $trabajador->getApellido2();

            //Pasar a formato UTF-8
            $nombre = iconv('UTF-8', 'ASCII//TRANSLIT', $nombre);
            $apellido1 = iconv('UTF-8', 'ASCII//TRANSLIT', $apellido1);
            $apellido2 = iconv('UTF-8', 'ASCII//TRANSLIT', $apellido2);
            
            $spreadsheet->getActiveSheet()->setCellValue('A' . $pos, $rut);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $pos, $dv);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $pos, $nombre);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $pos, $apellido1);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $pos, $apellido2);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $pos, $sexo);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $pos, "S");
            $spreadsheet->getActiveSheet()->setCellValue('H' . $pos, "S");
            $spreadsheet->getActiveSheet()->setCellValue('I' . $pos, $nacionalidad->getCodigo());
        }

        $pos++;

    }
    $fecha = date("dmYHis");
    //Descargar por navegador
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="PLANTILLA_TRABAJADORES.csv"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}