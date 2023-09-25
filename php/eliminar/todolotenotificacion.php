<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: ../../lockscreen.php");
    }
}


$result = $c->eliminartodolotenotificacion($_SESSION['USER_ID']);
if ($result == true) {
    echo 1;
} else {
    echo 0;
}
