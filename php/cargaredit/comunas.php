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
$id = $_POST['id'];

$isapre = $c->buscarcomuna($id);

if($isapre != null){
    echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<label>Codigo</label>";
        echo "<input type='text' class='form-control' id='codigo' value='".$isapre->getCodigo()."'/>";
        echo "</div>";

        echo "<div class='col-md-12'>";
        echo "<label>Codigo (PREVIRED)</label>";
        echo "<input type='text' class='form-control' id='codigoPrevired' value='".$isapre->getCodigoPrevired()."'/>";
        echo "</div>";

        echo "<div class='col-md-12'>";
        echo "<label>Codigo (XLS Despidos)</label>";
        echo "<input type='text' class='form-control' id='codigoxedit' value='".$isapre->getCodigox()."'/>";
        echo "</div>";

        echo "<div class='col-md-12'>";
        echo "<label>Nombre</label>";
        echo "<input type='text' class='form-control' id='nombre' value='".$isapre->getNombre()."'/>";
        echo "</div>";

        $provincias = $c->listarprovincias($isapre->getRegion());
        echo "<div class='col-md-12'>";
        echo "<label>Provincia</label>";
        echo "<select class='form-control' name='provincia' id='provincia'>";
        foreach ($provincias as $provincia) {
            if($provincia->getId() == $isapre->getProvincia()){
                echo "<option value='".$provincia->getId()."' selected>".$provincia->getNombre()."</option>";
            }else{
                echo "<option value='".$provincia->getId()."'>".$provincia->getNombre()."</option>";
            }
        }
        echo "</select>";
        echo "</div>";
        
        echo "<div class='col-md-12 text-right mt-3'>";
        echo "<button class='btn btn-primary' onclick='Actualizar(".$isapre->getId().")'> <i class='fa fa-refresh'></i> Actualizar</button>";
        echo "</div>";

    echo "</div>";
}else{
    echo "<div class='alert alert-danger'>No se encontro la Comuna</div>";
}