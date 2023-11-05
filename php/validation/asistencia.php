<?php
require '../controller.php';
$c = new Controller();
session_start();
if(isset($_POST['id']) && isset($_POST['inicio']) && isset($_POST['termino']) && isset($_POST['contrato'])){
    $id = $_POST['id'];
    $inicio = $_POST['inicio'];
    $termino = $_POST['termino'];
    $_SESSION['PERIOD_START'] = $inicio;
    $_SESSION['PERIOD_END'] = $termino;
    $contrato = $_POST['contrato'];
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];

    //Obtener los meses dentro del periodo de inicio y termino
    //Agregar el primer dia del mes
    $inicio = $inicio."-01";
    //Agregar el ultimo dia del mes
    $termino = $termino."-".date('t', strtotime($termino));

    //Arreglo de meses
    $meses = array();
    
    // Convertir las fechas de inicio y término a objetos DateTime
    $fechaInicio = new DateTime($inicio);
    $fechaTermino = new DateTime($termino);

    // Generar los meses y agregarlos al array
    while ($fechaInicio <= $fechaTermino) {
        $meses[] = $fechaInicio->format('Y-m');
        $fechaInicio->modify('+1 month');
    }

    // El array $meses ahora contendrá los meses dentro del período
    //Generar los dias de cada mes
    $dias = array();
    echo "<div class='w-100 text-center'>";
    echo "<button class='btn btn-success btn-sm mr-2' title='Presente'><i class='fa fa-check'></i> Presente</button>";
    echo "<button class='btn btn-info btn-sm mr-2' title='Medio Dia'><i class='fa fa-sun'></i> Medio Dia</button>";
    echo "<button class='btn btn-danger btn-sm mr-2' title='Ausente'><i class='fa fa-times'></i> Ausente</button>";
    echo "<button class='btn btn-warning btn-sm mr-2' title='Licencia'><i class='fa fa-user-times'></i> Permiso sin goce de sueldo</button>";
    echo "<button class='btn btn-secondary btn-sm mr-2' title='Licencia'><i class='fa fa-calendar'></i> Licencia</button>";
    echo "</div>";
    echo "<table class='table table-bordered table-hover table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Periodo</th>";
    echo "<th colspan='31' class='text-center'>Dias</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    $i = 1;
    foreach($meses as $mes){
        $mes = $mes."-01";
        $fechaInicio = new DateTime($mes);
        $fechaTermino = new DateTime($mes);
        $fechaTermino->modify('+1 month');
        $fechaTermino->modify('-1 day');
        $licencias = $c->buscarlicencias($id, $fechaInicio->format('Y-m-d'), $fechaTermino->format('Y-m-d'));
        echo "<tr>";
        $fechosa = $fechaInicio->format('Y-m-d');
        $mesosa = date('m', strtotime($fechosa));
        $anosa = date('Y', strtotime($fechosa));
        switch($mesosa){
            case 1:
                $mesosa = "Enero";
                break;
            case 2:
                $mesosa = "Febrero";
                break;
            case 3:
                $mesosa = "Marzo";
                break;
            case 4:
                $mesosa = "Abril";
                break;
            case 5:
                $mesosa = "Mayo";
                break;
            case 6:
                $mesosa = "Junio";
                break;
            case 7:
                $mesosa = "Julio";
                break;
            case 8:
                $mesosa = "Agosto";
                break;
            case 9:
                $mesosa = "Septiembre";
                break;
            case 10:
                $mesosa = "Octubre";
                break;
            case 11:
                $mesosa = "Noviembre";
                break;
            case 12:
                $mesosa = "Diciembre";
                break;
        }




        echo "<td>".$mesosa." ".$anosa."</td>";
        while ($fechaInicio <= $fechaTermino) {
            $dias[] = $fechaInicio->format('Y-m-d');
            $fechaInicio->modify('+1 day');
        }
        foreach($dias as $dia){
            echo "<td>".date('d', strtotime($dia))."</td>";
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td>Asistencia</td>";
        foreach($dias as $dia){
            //Validar si el dia esta incluido en las licencias
            $licencia = false;
            if($licencias != null){
            $init =new DateTime($licencias->getFechainicio());
            $end = new DateTime($licencias->getFechafin());
            while ($init <= $end) {
                $fechita = $init->format('Y-m-d');
                //Comprobar si el dia esta dentro de la licencia
                if($dia == $fechita){
                    echo "<td><button class='btn btn-secondary btn-sm' title='Licencia'><i class='fa fa-calendar'></i></button></td>";
                    $licencia = true;
                    break;
                }
                $init->modify('+1 day');
            }}

            if($licencia == true){
                continue;
            }
            $dia = date('Y-m-d', strtotime($dia));
            $asistencia = $c->comprobarasistencia($id,$contrato,$dia);
            $elemento = "button".$i;
            if($asistencia == 1){
                echo "<td><button class='btn btn-success btn-sm' id='$elemento' title='Presente' onclick='cargarasistencia(".$id.",$empresa,$contrato,\"".$dia."\",1,$i)'><i class='fa fa-check'></i></button></td>";
            }else if($asistencia == 2){
                echo "<td><button class='btn btn-info btn-sm' id='$elemento'  title='Medio Dia' onclick='cargarasistencia(".$id.",$empresa,$contrato,\"".$dia."\",2,$i)'><i class='fa fa-sun'></i></button></td>";
            }else if($asistencia == 3){
                echo "<td><button class='btn btn-danger btn-sm' id='$elemento'  title='Ausente' onclick='cargarasistencia(".$id.",$empresa,$contrato,\"".$dia."\",3,$i)'><i class='fa fa-times'></i></button></td>";
            }else if($asistencia == 4){
                echo "<td><button class='btn btn-secondary btn-sm' title='Licencia'><i class='fa fa-calendar'></i></button></td>";
            }else if($asistencia == 5){
                echo "<td><button class='btn btn-warning btn-sm' title='Permiso sin goce de sueldo' onclick='cargarasistencia(".$id.",$empresa,$contrato,\"".$dia."\",5,$i)'><i class='fa fa-user-times'></i></button></td>";
            }else if($asistencia==false){
                echo "<td><button class='btn btn-success btn-sm' id='$elemento'  title='Presente' onclick='cargarasistencia(".$id.",$empresa,$contrato,\"".$dia."\",1,$i)'><i class='fa fa-check'></i></button></td>";
            }
            $i++;
        }
        $dias = array();
    }
    echo "</tbody>";
    echo "</table>";
}else if(isset($_POST['id']) && isset($_POST['empresa']) && isset($_POST['contrato']) && isset($_POST['dia']) && isset($_POST['estado'])){
    $id = $_POST['id'];
    $empresa = $_POST['empresa'];
    $contrato = $_POST['contrato'];
    $dia = $_POST['dia'];
    $estado = $_POST['estado'];
    switch($estado){
        case 1:
            $estado = 2;
            break;
        case 2:
            $estado = 3;
            break;
        case 3:
            $estado = 5;
            break;
        case 5:
            $estado = 1;
            break;
    }
    $asistencia = $c->validarasistencia($id,$contrato,$dia);
    if($asistencia == false){
        $c->registrarasistencia($id,$contrato,$dia,2);
    }else{
        $c->actualizarasistencia($asistencia,$estado);
        if($estado==1){
            $c->eliminarasistencia($asistencia);
        }else if($estado==5){
            $contratoobject = $c->buscarcontrato($contrato);
            $valid = $c->buscarmovimientoxfecha($contratoobject->getTrabajador(),$dia,4);
            if($valid==false){
                $c->registrarmovimiento($contratoobject->getTrabajador(),$empresa,date('Y-m-01', strtotime($dia)),2,4,$dia,$dia,'','');
            }
        }else if($estado==2){
            $contratoobject = $c->buscarcontrato($contrato);
            $valid = $c->buscarmovimientoxfecha($contratoobject->getTrabajador(),$dia,4);
            if($valid==false){
                $c->registrarmovimiento($contratoobject->getTrabajador(),$empresa,date('Y-m-01', strtotime($dia)),2,4,$dia,$dia,'','');
            }
        }

    }
}else{
    echo "Error";
}