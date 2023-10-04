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
$empresa = $_SESSION['CURRENT_ENTERPRISE'];

$result = $c->eliminartodoloteanexo($_SESSION['USER_ID'], $empresa);
if ($result == true) {
    echo 1;
} else {
    echo 0;
}
