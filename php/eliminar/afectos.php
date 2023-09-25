<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['trabajador'])){
    $id = $_POST['trabajador'];
    $c->eliminarafectovacaciones($id);
}