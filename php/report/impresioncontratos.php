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
        if(trim($object['ruta_documento']) != "" && trim($object['ruta_documento']) != null && $object['formato_contrato'] == 1 ){
            if (file_exists("../../uploads/Contratos/" . $object['ruta_documento'])) {
                $pdffiles[] = "../../uploads/Contratos/" . $object['ruta_documento'];
            }
        }
    }

    //Verificar si hay archivos para combinar
    if (count($pdffiles) == 0) {
        echo "No hay contratos disponibles para imprimir.";
        exit;
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
}else{
    echo "No se proporcionó un ID de Lote válido.";
}