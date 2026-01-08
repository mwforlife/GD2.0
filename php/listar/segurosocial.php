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

if(isset($_POST['tabla'])){
    $tabla = $_POST['tabla'];

    // Validar nombre de tabla para seguridad
    $tablasPermitidas = array('expectativadevida', 'rentabilidadprotegida', 'sis');
    if(!in_array($tabla, $tablasPermitidas)){
        echo "Tabla no permitida";
        exit;
    }

    // Nombre completo de la tabla
    $nombreTabla = 'segurosocial_' . $tabla;

    // Si se solicita un registro específico
    if(isset($_POST['id']) && isset($_POST['accion']) && $_POST['accion'] == 'obtener_uno'){
        $id = $_POST['id'];
        $registro = $c->buscarsegurosocial($nombreTabla, $id);

        if($registro != null){
            // Formatear fecha para input type="month" (YYYY-MM)
            $fecha = $registro->getFecha();
            $periodo = date('Y-m', strtotime($fecha));

            $data = array(
                'id' => $registro->getId(),
                'codigo' => $registro->getCodigo(),
                'codigoprevired' => $registro->getCodigoPrevired(),
                'fecha' => $fecha,
                'periodo' => $periodo,
                'tasa' => $registro->getTasa()
            );

            header('Content-Type: application/json');
            echo json_encode($data);
        }else{
            echo json_encode(null);
        }
    }else{
        // Listar todos los registros
        $lista = $c->listarsegurosocial($nombreTabla);

        if($lista && count($lista) > 0){
            foreach($lista as $item){
                // Formatear fecha para mostrar (Mes Año)
                $fechaCompleta = $item->getFecha();
                $timestamp = strtotime($fechaCompleta);

                // Obtener mes y año
                $mes = date('n', $timestamp); // Mes numérico sin ceros
                $ano = date('Y', $timestamp);

                // Array de nombres de meses
                $meses = array(
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                );

                $nombreMes = $meses[$mes];
                $fechaMostrar = $nombreMes . " " . $ano;

                // data-order para ordenamiento: formato YYYYMM (ej: 202601, 202602, 202512)
                // Esto permite ordenar correctamente por año primero, luego por mes
                $dataOrder = $ano . sprintf("%02d", $mes);

                echo "<tr>";
                echo "<td data-order='" . $item->getCodigo() . "'>" . ($item->getCodigo() ? $item->getCodigo() : '-') . "</td>";
                echo "<td data-order='" . $item->getCodigoPrevired() . "'>" . ($item->getCodigoPrevired() ? $item->getCodigoPrevired() : '-') . "</td>";
                echo "<td data-order='" . $dataOrder . "'>" . $fechaMostrar . "</td>";
                echo "<td data-order='" . $item->getTasa() . "'>" . $item->getTasa() . "%</td>";
                echo "<td class='text-center' data-order=''>";

                // Validar permisos de actualización
                if(isset($_SESSION['ACTUALIZACION_PERMISO']) && $_SESSION['ACTUALIZACION_PERMISO'] == true){
                    echo "<button class='btn btn-sm btn-warning' onclick='Editar(" . $item->getId() . ")'><i class='fa fa-edit'></i> Editar</button> ";
                }

                // Validar permisos de eliminación
                if(isset($_SESSION['ELIMINACION_PERMISO']) && $_SESSION['ELIMINACION_PERMISO'] == true){
                    echo "<button class='btn btn-sm btn-danger' onclick='Eliminar(" . $item->getId() . ")'><i class='fa fa-trash'></i> Eliminar</button>";
                }

                echo "</td>";
                echo "</tr>";
            }
        }else{
            // No devolver nada si no hay registros
            // El JavaScript manejará el mensaje de "No hay registros"
            echo "";
        }
    }
}else{
    echo "No se recibió el parámetro de tabla";
}
