<?php
require "../controller.php";
$c = new Controller();

if(isset($_POST['trabajador']) && isset($_POST['periodo_inicio']) && isset($_POST['periodo_fin'])){
    $trabajador = $_POST['trabajador'];
    $periodo_inicio = $_POST['periodo_inicio'];
    $periodo_fin = $_POST['periodo_fin'];
    $c->cargarAsistencia($trabajador, $periodo_inicio, $periodo_fin);
}else{
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos']);
}
?>