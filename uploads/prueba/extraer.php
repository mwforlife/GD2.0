<?php
require '../../php/plugins/vendor/autoload.php';
use TCPDF\FPDF;
use setasign\Fpdi\Tcpdf\Fpdi;


// Crear una instancia de TCPDF
$pdf = new TCPDF();

// Especifica el archivo PDF que deseas procesar
$pdfFile = 'Planilla.pdf'; // Reemplaza con la ruta de tu archivo PDF

// Crear una instancia de FPDI
$pdfParser = new \setasign\Fpdi\Tcpdf\Fpdi();

// Agregar una página vacía a TCPDF
$pdf->AddPage();

// Importar la página del PDF al documento TCPDF
$pageCount = $pdfParser->setSourceFile($pdfFile);
$templateId = $pdfParser->importPage(1);
$pdfParser->useTemplate($templateId);

// Crear una instancia de PDFParser
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile($pdfFile);

// Obtener el texto del PDF
$text = $pdf->getText();

// Imprimir el texto extraído
echo $text;

// Puedes procesar $text como desees

// Cerrar el documento TCPDF
$pdf->Output();