<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
use TCPDF\FPDF;
use setasign\Fpdi\Tcpdf\Fpdi;

$c = new Controller();
if (isset($_GET['id'])) {
    $lista1 = $c->listarlotestext2($_GET['id']);
    $pdffiles = array();
    foreach ($lista1 as $object) {
        $pdffiles[] = "../../uploads/Contratos/" . $object->getFecha_inicio();
    }

    $pdf = new Fpdi();
    $pdf->SetPrintHeader(false);
    $pdf->setPrintFooter(false);

    foreach ($pdffiles as $pdfFile) {
        $pageCount = $pdf->setSourceFile($pdfFile);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplIdx = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx, 0, 0, 210);
        }
    }
    $pdf->Output("contratos.pdf", "I");
}