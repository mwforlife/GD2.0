<?php
require '../controller.php';
$c = new Controller();

/*fechacomprobante: 2023-06-22
periodoinicio: 22/05/2020
periodotermino: 21/05/2021
diasvacaciones: 46.25
restantes: 46.25
anos: 0
progresivas: 0
tipocontratoid: 6
trabajadorid: 1
fechainicio: 2023-01-01
fechatermino: 2023-01-31
cantidaddias: 19
diasinhabiles: 9
diasferiados: 3
diasrestantes: 27
comentario: */

if(isset($_POST['fechacomprobante']) && isset($_POST['periodoinicio']) && isset($_POST['periodotermino']) && isset($_POST['diasvacaciones']) && isset($_POST['restantes']) && isset($_POST['anos']) && isset($_POST['progresivas']) && isset($_POST['tipocontratoid']) && isset($_POST['trabajadorid']) && isset($_POST['fechainicio']) && isset($_POST['fechatermino']) && isset($_POST['cantidaddias']) && isset($_POST['diasinhabiles']) && isset($_POST['diasferiados']) && isset($_POST['diasrestantes']) && isset($_POST['comentario'])){
    $fechacomprobante = $_POST['fechacomprobante'];
    $periodoinicio = $_POST['periodoinicio'];
    $periodoinicio = date('Y-m-d', strtotime($periodoinicio));
    $periodotermino = $_POST['periodotermino'];
    $periodotermino = date('Y-m-d', strtotime($periodotermino));
    $diasvacaciones = $_POST['diasvacaciones'];
    $restantes = $_POST['restantes'];
    $anos = $_POST['anos'];
    $progresivas = $_POST['progresivas'];
    $tipocontratoid = $_POST['tipocontratoid'];
    $trabajadorid = $_POST['trabajadorid'];
    $fechainicio = $_POST['fechainicio'];
    $fechatermino = $_POST['fechatermino'];
    $cantidaddias = $_POST['cantidaddias'];
    $diasinhabiles = $_POST['diasinhabiles'];
    $diasferiados = $_POST['diasferiados']; 
    $diasrestantes = $_POST['diasrestantes'];
    $comentario = $_POST['comentario'];

    $resultado = $c->calcularDias($fechainicio, $fechatermino);
    $diasHabiles = $resultado['diasHabiles'];
    $diasFinSemana = $resultado['diasFinSemana'];
    $diasFeriados = $resultado['diasFeriados'];
    $totales = $resultado['totales'];

    $sql = "insert into vacaciones values(null, $trabajadorid, '$periodoinicio', '$periodotermino', $diasvacaciones, $anos, $progresivas, $tipocontratoid, '$fechainicio', '$fechatermino',$diasHabiles, $diasFinSemana, $diasFeriados, $totales,$diasrestantes, '$comentario','','$fechacomprobante')";   
    $result = $c->query($sql);
    if ($result == true) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo "No llegaron los datos";
}
