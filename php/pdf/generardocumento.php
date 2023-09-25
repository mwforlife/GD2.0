<?php
require_once '../plugins/vendor/autoload.php';
$id = $_POST['id'];
$contenido = $_POST['contenido'];

$swap = array(
    '{RUT}' => '12345678-9',
    '{NOMBRE}' => 'Juan Perez',
    '{DIRECCION}' => 'Av. Siempre Viva 123',
    '{COMUNA}' => 'Santiago',
    '{CIUDAD}' => 'Santiago',
    '{TELEFONO}' => '123456789',
    '{EMAIL}' => 'mwforlife24@gmail.com',
    '{FECHA}' => '01/01/2018',
    '{HORA}' => '12:00',
);

foreach (array_keys($swap) as $key) {
    $contenido = str_replace($key, $swap[$key], $contenido);
}



$mpdf = new \Mpdf\Mpdf();
$mpdf->title = 'Contrato de Trabajo';
$mpdf->author = 'Wilkens Mompoint';
$mpdf->creator = 'Wilkens Mompoint';
$mpdf->subject = 'Contrato de Trabajo';
$mpdf->keywords = 'Contrato, Trabajo, Empleo';
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($contenido);
$fecha = date('Ymdhis');
$mpdf->Output('documentos/Contrato_'.$id.'_'.$fecha.'.pdf', 'F');

/*$mpdf->AddPage();
$mpdf->title = 'Contrato de Trabajo';
$mpdf->author = 'KaiserTech';
$mpdf->creator = 'KaiserTech';
$mpdf->subject = 'Contrato de Trabajo';
$mpdf->keywords = 'Contrato, Trabajo, Empleo';
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($contenido);
$mpdf->Output('contrato.pdf' , 'F' );
echo 1;*/