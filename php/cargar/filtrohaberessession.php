<?php
session_start();

if(isset($_POST['periodoinico']) && isset($_POST['periodofin']) && isset($_POST['funcionario'])){
    $_SESSION['periodoinico'] = $_POST['periodoinico'].'-01';
    $_SESSION['periodofin'] = $_POST['periodofin'].'-01';
    $_SESSION['funcionario'] = $_POST['funcionario'];
    echo json_encode(array('status' => true, 'message' => 'Parametros cargados correctamente'));
}else{
    unset($_SESSION['periodoinico']);
    unset($_SESSION['periodofin']);
    unset($_SESSION['funcionario']);
    echo json_encode(array('status' => false, 'message' => 'Ups, no se pudo cargar el filtro'));
}