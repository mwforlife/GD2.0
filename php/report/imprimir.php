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
    $contratosExpress = array();

    foreach ($cart as $object) {
        // Validar que tenga ruta y que no sea contrato express (formato_contrato != 1)
        $ruta = isset($object->ruta) ? trim($object->ruta) : '';
        $formatoContrato = isset($object->formato_contrato) ? $object->formato_contrato : 1;

        // Si es contrato express (formato != 1) o no tiene ruta, lo saltamos
        if ($formatoContrato != 1 || empty($ruta)) {
            $contratosExpress[] = isset($object->trabajador) ? $object->trabajador : 'Desconocido';
            continue;
        }

        $rutaCompleta = "../../uploads/Contratos/" . $ruta;

        // Verificar que el archivo exista
        if (file_exists($rutaCompleta)) {
            $pdffiles[] = $rutaCompleta;
        }
    }

    // Verificar si hay archivos para combinar
    if (count($pdffiles) == 0) {
        // Mostrar mensaje HTML indicando que no hay documentos
        echo "<!DOCTYPE html><html><head><title>Sin documentos</title>";
        echo "<style>body{font-family:Arial,sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;background:#f5f5f5;}";
        echo ".container{text-align:center;background:white;padding:40px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}";
        echo ".icon{font-size:60px;color:#ffc107;margin-bottom:20px;}";
        echo "h2{color:#dc3545;margin-bottom:15px;}";
        echo "p{color:#666;margin-bottom:20px;}";
        echo "ul{text-align:left;color:#333;}</style></head><body>";
        echo "<div class='container'>";
        echo "<div class='icon'>&#9888;</div>";
        echo "<h2>No hay documentos disponibles para imprimir</h2>";
        if (count($contratosExpress) > 0) {
            echo "<p>Los siguientes contratos son <strong>Contratos Express</strong> y no generan documentos PDF:</p>";
            echo "<ul>";
            foreach ($contratosExpress as $nombre) {
                echo "<li>" . htmlspecialchars($nombre) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron archivos PDF válidos para los contratos seleccionados.</p>";
        }
        echo "</div></body></html>";
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
}