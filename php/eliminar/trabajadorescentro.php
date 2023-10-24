<?php
require '../controller.php';
$c = new Controller();

session_start();
unset($_SESSION['COST_CENTER']);