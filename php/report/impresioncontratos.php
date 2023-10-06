<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
use TCPDF\FPDF;
use setasign\Fpdi\Tcpdf\Fpdi;

$c = new Controller();
if(isset($_GET['id'])){
    $lista1 = $c->listarlotestext2($_GET['id']);
    $pdffiles = array();
    foreach ($lista1 as $object) {
        $pdffiles[] = "../../uploads/Contratos/".$object->getFecha_inicio();
    }

    $pdf = new Fpdi();
    $pdf->SetPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();

    foreach ($pdffiles as $pdfFile) {
        $pdf->setSourceFile($pdfFile);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);
        if($pdfFile != end($pdffiles)){
            $pdf->AddPage();
        }
    }
    $pdf->Output("contratos.pdf", "I");
}