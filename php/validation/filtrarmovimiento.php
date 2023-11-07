<?php
session_start();
if(isset($_POST['periodo']) && isset($_POST['periodo_termino']) && isset($_POST['centrocosto'])){
    $_SESSION['PERIODO_REPORTE'] = $_POST['periodo'];
    $_SESSION['PERIODO_REPORTE_TERMINO'] = $_POST['periodo_termino'];
    $centrocosto = $_POST['centrocosto'];
    if($centrocosto < 1){
        unset($_SESSION['CENTRO_COSTO_REPORTE']);
    }else{
        $_SESSION['CENTRO_COSTO_REPORTE'] = $centrocosto;
    }
}else{
    unset($_SESSION['PERIODO_REPORTE']);
    unset($_SESSION['PERIODO_REPORTE_TERMINO']);
    unset($_SESSION['CENTRO_COSTO_REPORTE']);
}