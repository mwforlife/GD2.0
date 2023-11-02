<?php
session_start();

if(isset($_POST['periodo']) && isset($_POST['centrocosto'])){
    $periodo = $_POST['periodo'];
    $centrocosto = $_POST['centrocosto'];
    
    if(strlen($periodo) > 0 ){
        $_SESSION['PERIOD_LIQUIDACION'] = $periodo;
    }else{
        unset($_SESSION['PERIOD_LIQUIDACION']);
    }

    if(strlen($centrocosto) > 0 ){
        $_SESSION['CENTRO_COSTO_LIQUIDACION'] = $centrocosto;
    }else{
        unset($_SESSION['CENTRO_COSTO_LIQUIDACION']);
    }
}