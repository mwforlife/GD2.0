<?php
require 'documentos_empresa_ajax.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    verpdf($c, $id);
} else {
    echo "ID de documento no proporcionado.";
}