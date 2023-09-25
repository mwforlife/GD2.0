<?php
require '../controller.php';
$c = new Controller();
$fechainicio = $_POST['fechainicio'];
$fechatermino = $_POST['fechatermino'];
$ano = date('Y', strtotime($fechainicio));


function calcularDias($fechaInicio, $fechaFin) {
    $diasHabiles = 0;
    $diasFinSemana = 0;
    
    $fechaInicio = strtotime($fechaInicio);
    $fechaFin = strtotime($fechaFin);
    $diasferiados =0;
    $c = new Controller();
    while ($fechaInicio <= $fechaFin) {
        $diaSemana = date('N', $fechaInicio);
        
        if ($diaSemana >= 1 && $diaSemana <= 5) {
            // Día hábil
            $diasHabiles++;
            $feriado = $c->buscarferiadoporfecha(date('Y-m-d', $fechaInicio));
            if($feriado != false){
                $diasferiados++;
            }
        } else {
            // Día fin de semana
            $diasFinSemana++;
        }
        
        $fechaInicio = strtotime('+1 day', $fechaInicio);
    }
    
    //$diasFeriados = count(array_intersect($feriados, obtenerFechas($fechaInicio, $fechaFin)));
    
    $diasHabiles -= $diasferiados;
    $totales = $diasHabiles + $diasFinSemana + $diasferiados;
    
    return [
        'diasHabiles' => $diasHabiles,
        'diasFinSemana' => $diasFinSemana,
        'diasFeriados' => $diasferiados,
        'totales' => $totales
    ];
}

function obtenerFechas($fechaInicio, $fechaFin) {
    $fechas = array();
    while ($fechaInicio <= $fechaFin) {
        $fechas[] = date('Y-m-d', $fechaInicio);
        $fechaInicio = strtotime('+1 day', $fechaInicio);
    }
    return $fechas;
}

$resultado = calcularDias($fechainicio, $fechatermino);

echo json_encode($resultado);