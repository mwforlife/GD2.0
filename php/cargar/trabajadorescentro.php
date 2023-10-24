<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['centrocosto'])){
    $centrocosto = $_POST['centrocosto'];
    session_start();
    $_SESSION['COST_CENTER'] = $centrocosto;
}