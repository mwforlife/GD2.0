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

if(isset($_SESSION['TRABAJADOR_ID'])){
    $cargas = $c->listarcargas($_SESSION['TRABAJADOR_ID']);
    if(count($cargas)>0){
        foreach($cargas as $carga){
            echo "<tr>";
            echo "<td>".$carga->getRut()."</td>";
            echo "<td>".$carga->getNombre()."</td>";
            echo "<td>".$carga->getApellido1()."</td>";
            echo "<td>".$carga->getApellido2()."</td>";
            echo "<td>".$carga->getFechaNacimiento()."</td>";
            echo "<td>".$carga->getEstadoCivil()."</td>";
            echo "<td>".$carga->getFechaReconocimiento()."</td>";
            echo "<td>".$carga->getFechaPago()."</td>";
            if($carga->getVigencia() == "0000-00-00"){
                echo "<td></td>";
            }else{
            echo "<td>".$carga->getVigencia()."</td>";
            }
            echo "<td>".$carga->getTipoCausante()."</td>";
            echo "<td>".$carga->getSexo()."</td>";
            echo "<td>".$carga->getTipoCarga()."</td>";
            echo "<td>".$carga->getFechaRegistro()."</td>";
            echo "<td>".$carga->getComentario()."</td>";
            if(strlen($carga->getDocumento())>0){
            echo "<td><a href='uploads/".$carga->getDocumento()."' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
            }else{
                echo "<td></td>";
            }
            echo "<tr/>";
        }
            
    }else{
        echo "<tr><td colspan='15'>No hay cargas familiares registradas</td></tr>";
    }
}