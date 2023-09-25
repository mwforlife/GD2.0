<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
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

if (isset($_GET['periodoinicio']) &&  isset($_GET['periodotermino']) && isset($_GET['restantes'])  && isset($_GET['anos']) && isset($_GET['progresivas']) && isset($_GET['trabajadorid']) && isset($_GET['tipocontratoid']) && isset($_GET['fechainicio']) && isset($_GET['fechatermino'])  &&  isset($_GET['cantidaddias']) && isset($_GET['diasinhabiles']) && isset($_GET['diasferiados']) &&  isset($_GET['comentario']) && isset($_GET['fechacomprobante'])) {
    $periodoinicio = $_GET['periodoinicio'];
    $periodotermino = $_GET['periodotermino'];
    $restantes = $_GET['restantes'];
    $anos = $_GET['anos'];
    $progresivas = $_GET['progresivas'];
    $trabajadorid = $_GET['trabajadorid'];
    $restantes = $_GET['restantes'];
    $tipocontratoid = $_GET['tipocontratoid'];
    $fechainicio = $_GET['fechainicio'];
    $fechatermino = $_GET['fechatermino'];
    $cantidaddias = $_GET['cantidaddias'];
    $diasinhabiles = $_GET['diasinhabiles'];
    $tot = $cantidaddias + $diasinhabiles;
    $diasferiados = $_GET['diasferiados'];
    $comentario = $_GET['comentario'];
    $fechacomprobante = $_GET['fechacomprobante'];
    $diasrestantes = $_GET['diasrestantes'];

    if ($restantes <= 0) {
        echo "No se puede ingresar vacaciones, ya que no tiene vacaciones disponibles";
        return;
    }


    $tomadas = $c->sumardiasvacaciones($trabajadorid);

    /************************************************************************************************************************************************* */
    //Calcular cantidad de dias habiles
    $fechainicio = $_GET['fechainicio'];
    $fechatermino = $_GET['fechatermino'];
    $diashabiles = $c->contardiasnaturales($fechainicio, $fechatermino);
    $diashabiles = $diashabiles + 1;
    /************************************************************************************************************************************************* */
    //Calcular fines de semana
    $fechainicio = $_GET['fechainicio'];
    $fechatermino = $_GET['fechatermino'];
    //Crear proceso automatico para calcular los fines de semana
    $finesdesemana = 0;
    while (strtotime($fechainicio) <= strtotime($fechatermino)) {
        $dia = date('w', strtotime($fechainicio));
        if ($dia == 0 || $dia == 6) {
            $finesdesemana++;
        }
        $fechainicio = date('Y-m-d', strtotime($fechainicio . "+ 1 days"));
    }

    /************************************************************************************************************************************************* */
    //Calcular dias feriados
    $fechainicio = $_GET['fechainicio'];
    $fechatermino = $_GET['fechatermino'];
    $diasferiados = $c->contardiasferiados($fechainicio, $fechatermino);
    /************************************************************************************************************************************************* */

    $cantidaddias = $diashabiles - $finesdesemana - $diasferiados;



    /************************************************************************************************************************************************* */
    //Calcular Periodo
    $inicio = $c->buscarfechainicioultimocontrato($trabajadorid);
    if ($inicio == null) {
        echo "No se encontro ningun contrato para este trabajador";
        return;
    }
    $inicio2 = $c->buscarfechaterminoultimoperiodovacaciones($trabajadorid);
    if ($inicio2 != null) {
        if ($inicio2 > $inicio) {
            //Si la fecha de termino del ultimo periodo de vacaciones es mayor a la fecha de inicio del ultimo contrato
            //La fecha de inicio del periodo de vacaciones sera la fecha de termino del ultimo periodo de vacaciones + 1 dia
            $inicio = date('Y-m-d', strtotime($inicio2 . "+ 1 days"));
        }
    }
    //Calcular la fecha para cumplir el periodo de un año desde la fecha de inicio del contrato - 1 dia
    $periodotermino = date('Y-m-d', strtotime($inicio . "+ 1 years"));
    //Restar 1 dia para que el periodo sea de un año
    $periodotermino = date('Y-m-d', strtotime($periodotermino . "- 1 days"));
    /************************************************************************************************************************************************** */
    /************************************************************************************************************************************************** */
    //Calcular vacaciones progresivas
    $fecafec = $c->buscarfechaafectovacaciones($trabajadorid); //Comprar la fecha de inicio con la fecha de vacaciones progresiva
    $inicomparacion = "";
    if ($fecafec > $inicio) {
        $inicomparacion = $fecafec;
    } else {
        $inicomparacion = $inicio;
    }

    //Calcular cantidad de años desde la fecha de iniciocomparacion hasta hoy
    $datetime1 = new DateTime($inicomparacion);
    $datetime2 = new DateTime(date('Y-m-d'));
    $interval = $datetime1->diff($datetime2);
    $anios = $interval->format('%y');

    //Calcular vacaciones progresivas sumando 1 dias por cada 3 años trabajados
    $canti = $anios / 3;
    $vacacionesprogresivas = floor($canti) * 1;
    /************************************************************************************************************************************************** */
    /************************************************************************************************************************************************** */
    //Calcular cantidad de meses desde la fecha de inicio hasta hoy
    //Agregar la hora a la fecha de inicio para poder calcular la diferencia
    $inicio = $inicio . " 00:00:00";
    $fin = date('Y-m-d H:i:s');
    $datetime1 = new DateTime($inicio);
    $datetime2 = new DateTime($fin);

    # obtenemos la diferencia entre las dos fechas
    # obtenemos la diferencia entre las dos fechas
    $interval = $datetime2->diff($datetime1);

    # obtenemos la diferencia en meses
    $intervalMeses = $interval->format("%m");
    # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
    $intervalAnos = $interval->format("%y") * 12;
    # sumamos los meses
    $intervalMeses = $intervalMeses + $intervalAnos;
    //Calcular cantidad de dias de vacaciones que le corresponden al trabajador
    $diasvacaciones = $intervalMeses * 1.25;
    //Calcular cantidad de dias de vacaciones que le corresponden al trabajador
    $periodoinicio = $inicio;
    $restantes = $diasvacaciones;
    $anos = $anios;
    $progresivas = $vacacionesprogresivas;
    $diasvacaciones = $diasvacaciones - $tomadas;

    if ($diasvacaciones <= 0) {
        echo "No Puede Solicitar Vacaciones, No Cumple Con El Periodo Minimo";
        return;
    }

    if(strlen($fechacomprobante) == 0){
        echo "Debe Ingresar Una Fecha Para El Comprobante";
        return;
    }

        $representante = $c->BuscarRepresentanteLegal1($_SESSION['CURRENT_ENTERPRISE']);
        $empresa = $c->buscarEmpresavalor2($_SESSION['CURRENT_ENTERPRISE']);
        $trabajador = $c->buscartrabajador($trabajadorid);
        $total = $cantidaddias + $vacacionesprogresivas;
        $fechainicio = date("d-m-Y", strtotime($fechainicio));
        $fechatermino = date("d-m-Y", strtotime($fechatermino));

        $iniciomes = date("m", strtotime($inicio));
        $inicioano = date("Y", strtotime($inicio));
        $terminomes = date("m", strtotime($periodotermino));
        $terminoano = date("Y", strtotime($periodotermino));

        switch ($iniciomes){
            case 1:
                $iniciomes = "Enero";
                break;
            case 2:
                $iniciomes = "Febrero";
                break;
            case 3:
                $iniciomes = "Marzo";
                break;
            case 4:
                $iniciomes = "Abril";
                break;
            case 5:
                $iniciomes = "Mayo";
                break;
            case 6:
                $iniciomes = "Junio";
                break;
            case 7:
                $iniciomes = "Julio";
                break;
            case 8:
                $iniciomes = "Agosto";
                break;
            case 9:
                $iniciomes = "Septiembre";
                break;
            case 10:
                $iniciomes = "Octubre";
                break;
            case 11:
                $iniciomes = "Noviembre";
                break;
            case 12:
                $iniciomes = "Diciembre";
                break;
        }

        switch ($terminomes){
            case 1:
                $terminomes = "Enero";
                break;
            case 2:
                $terminomes = "Febrero";
                break;
            case 3:
                $terminomes = "Marzo";
                break;
            case 4:
                $terminomes = "Abril";
                break;
            case 5:
                $terminomes = "Mayo";
                break;
            case 6:
                $terminomes = "Junio";
                break;
            case 7:
                $terminomes = "Julio";
                break;
            case 8:
                $terminomes = "Agosto";
                break;
            case 9:
                $terminomes = "Septiembre";
                break;
            case 10:
                $terminomes = "Octubre";
                break;
            case 11:
                $terminomes = "Noviembre";
                break;
            case 12:
                $terminomes = "Diciembre";
                break;
        }

        $inicio = $iniciomes . " de " . $inicioano;
        $periodotermino = $terminomes . " de " . $terminoano;

        $swap_var = array(
            "{NUMERO_COMPROBANTE}" => "null",
            "{FECHA_COMPROBANTE}" => date("d-m-Y", strtotime($fechacomprobante)),
            "{REPRESENTANTE_LEGAL}" => $representante->getNombre() . " " . $representante->getApellido1() . " " . $representante->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $representante->getRut(),
            "{CALLE_EMPRESA}" => $empresa->getCalle(),
            "{NUMERO_EMPRESA}" => $empresa->getNumero(),
            "{COMUNA_EMPRESA}" => $empresa->getComuna(),
            "{REGION_EMPRESA}" => $empresa->getRegion(),
            "{PERIODO_VACACIONES}" => $periodoinicio . " - " . $periodotermino,
            "{FECHA_INICIO_VACACIONES}" => date("d-m-Y", strtotime($fechainicio)),
            "{FECHA_TERMINO_VACACIONES}" => date("d-m-Y", strtotime($fechatermino)),
            "{DIAS_VACACIONES}" => $total,
            "{OBSERVACIONES_VACACIONES}" => $comentario,
            "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
            "{APELLIDO_1}" => $trabajador->getApellido1(),
            "{APELLIDO_2}" => $trabajador->getApellido2(),
            "{RUT_TRABAJADOR}" => $trabajador->getRut(),
            "{INICIO_PERIODO_VACACIONES}" => $inicio,
            "{TERMINO_PERIODO_VACACIONES}" => $periodotermino. " : ".$total . " día(s) hábil(es)",
            "{TOTAL_DIAS_VACACIONES}" => $tot,
            "{DIAS_HABILES_RESTANTES}" => $diasrestantes
        );

        $contenido = $c->buscarplantilla($tipocontratoid);

        foreach (array_keys($swap_var) as $key) {
            $contenido = str_replace($key, $swap_var[$key], $contenido);
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->title = 'Comporbante de Vacaciones';
        $mpdf->author = 'Wilkens Mompoint';
        $mpdf->creator = 'Wilkens Mompoint';
        $mpdf->subject = 'Comporbante de Vacaciones';
        $mpdf->keywords = 'Comporbante de Vacaciones';
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($contenido);
        $fecha = date('Ymdhis');
        //Generar nombre documento
        $nombre_documento = 'Comprobante_Vacaciones' . $fechainicio . "_" . $fechatermino . '.pdf';
        //Generar e imprimir documento
        $mpdf->Output($nombre_documento, 'I');
    
}
