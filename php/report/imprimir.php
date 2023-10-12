<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
use TCPDF\FPDF;
use setasign\Fpdi\Tcpdf\Fpdi;

$c = new Controller();
if (isset($_GET['cart'])) {
    //Cart es un json que contiene tipo, id, contrato, trabajador y ruta
    $cart = json_decode($_GET['cart']);
    $pdffiles = array();
    foreach ($cart as $object) {
        $pdffiles[] = "../../uploads/Contratos/" . $object->ruta;
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