<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
use TCPDF\FPDF;
use setasign\Fpdi\Tcpdf\Fpdi;

$c = new Controller();
if(isset($_GET['cart'])){
    //Cart es un json que contiene tipo, id, contrato, trabajador y ruta
    $cart = json_decode($_GET['cart']);
    $pdffiles = array();
    foreach ($cart as $object) {
        $pdffiles[] = "../../uploads/documentos/".$object->documento;
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
    $pdf->Output("documentos.pdf", "I");
}