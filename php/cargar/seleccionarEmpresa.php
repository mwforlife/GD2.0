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

if(isset($_POST['id'])){
    $_SESSION['CURRENT_ENTERPRISE'] = $_POST['id'];
	$c->eliminartodolotefiniquito($_SESSION['USER_ID']);
	$c->eliminartodolotenotificacion($_SESSION['USER_ID']);
	$c->eliminartodoellote($_SESSION['USER_ID']);
}