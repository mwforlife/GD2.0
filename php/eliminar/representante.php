<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: lockscreen.php");
    }
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $result = $c->EliminarRepresentanteLegal($id);
    if ($result == true) {
        echo 1;
    } else {
        echo 0;
    }
}
