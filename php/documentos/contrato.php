<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
$c = new Controller();
$mpdf = new \Mpdf\Mpdf();

//Captura de datos
$regioncelebracion = $_POST['regioncelebracion'];
$comunacelebracion = $_POST['comunacelebracion'];
