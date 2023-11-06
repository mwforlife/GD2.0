<?php
session_start();
if(isset($_POST['periodo'])){
    $_SESSION['PERIODO_REPORTE'] = $_POST['periodo'];
}else{
    unset($_SESSION['PERIODO_REPORTE']);
}