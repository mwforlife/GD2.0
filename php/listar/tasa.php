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
if(isset($_POST['id']) ){
    $id = $_POST['id'];
    $lista = $c->listartasaafp($id);
    foreach($lista as $l){
        echo "<tr>";
        echo "<td>" . $l->getFecha() . "</td>";
        echo "<td>" . $l->getTasa() . "%</td>";
        echo "</tr>";
    }
}else{
    echo "No se recibieron los datos";
}