<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
//Orientacion horizontal
$mpdf->AddPage('L');
$contenido = "";

if (isset($_GET['periodo'])) {
    $periodo = $_GET['periodo'];
    if (strlen($periodo) == 0) {
        $contenido .= "<div class='alert alert-danger'>Debe ingresar un periodo</div>";
        return;
    }
    $periodo = $periodo . "-01";
    $mes = date("m", strtotime($periodo));
    $anio = date("Y", strtotime($periodo));
    switch ($mes) {
        case 1:
            $mes = "Enero";
            break;
        case 2:
            $mes = "Febrero";
            break;
        case 3:
            $mes = "Marzo";
            break;
        case 4:
            $mes = "Abril";
            break;
        case 5:
            $mes = "Mayo";
            break;
        case 6:
            $mes = "Junio";
            break;
        case 7:
            $mes = "Julio";
            break;
        case 8:
            $mes = "Agosto";
            break;
        case 9:
            $mes = "Septiembre";
            break;
        case 10:
            $mes = "Octubre";
            break;
        case 11:
            $mes = "Noviembre";
            break;
        case 12:
            $mes = "Diciembre";
            break;
    }
    $liquidaciones = $c->listartodasliquidacionesperiodo($periodo);
    $contenido = "";

    $contenido .= "<h4 class='text-center'>LIBRO DE REMUNERACIONES</h4>";
    $contenido .= "<h5 class='text-center'>" . strtoupper("Periodo: " . $mes . " del " . $anio) . "</h5>";

    /*********************Haberes****************************** */
    $contenido .= "<table class='table table-bordered table-hover' style='width: 100%;'>";
    $contenido .= "<thead>";
    $contenido .= "<tr>";
    $contenido .= "<th class='text-nowrap'>Rut</th>";
    $contenido .= "<th class='text-nowrap'>Nombre</th>";
    $contenido .= "<th class='text-nowrap'>DT</th>";
    $contenido .= "<th class='text-nowrap'>S. Base</th>";
    $contenido .= "<th class='text-nowrap'>H.E</th>";
    $contenido .= "<th class='text-nowrap'>Grat. Legal</th>";
    $contenido .= "<th class='text-nowrap'>Otros. Imp</th>";
    $contenido .= "<th class='text-nowrap'>Total. Imp</th>";
    $contenido .= "<th class='text-nowrap'>Asig Fam.</th>";
    $contenido .= "<th class='text-nowrap'>Otr. No Imp</th>";
    $contenido .= "<th class='text-nowrap'>Tot. No Imp</th>";
    $contenido .= "<th class='text-nowrap'>Tot. Haberes</th>";
    $contenido .= "</tr>";
    $contenido .= "</thead>";
    $contenido .= "<tbody>";
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $detalleliquidacion = $c->buscardetallesliquidacion($liquidacion->getId());
        $otrosimponibles = 0;
        $otrosnoimpobibles = 0;
        $asignacionfamiliar = 0;
        $horaextras = 0;

        foreach ($detalleliquidacion as $detalle) {
            if ($detalle->getTipo() == 1) {
                if ($detalle->getCodigo() != 'SUELDO BASE' && $detalle->getCodigo() != 'GRATIFICACION' && $detalle->getCodigo() != 'HORA EXTRAS AL 50%' && $detalle->getCodigo() != 'HORA EXTRAS AL 75%' && $detalle->getCodigo() != 'HORA EXTRAS AL 100%') {
                    $otrosimponibles = $otrosimponibles + $detalle->getMonto();
                } else if ($detalle->getCodigo() == 'HORA EXTRAS AL 50%' || $detalle->getCodigo() == 'HORA EXTRAS AL 75%' || $detalle->getCodigo() == 'HORA EXTRAS AL 100%') {
                    $horaextras = $horaextras + $detalle->getMonto();
                }
            } else if ($detalle->getTipo() == 2) {
                $otrosnoimpobibles = $otrosnoimpobibles + $detalle->getMonto();
            }
        }

        $contenido .= "<tr>";
        //Ajustar el rut al tamaño del te
        $contenido .= "<td class='text-nowrap'>" . $trabajador->getRut() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . $liquidacion->getDiastrabajados() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getSueldobase(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($horaextras, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getGratificacion(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($otrosimponibles, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getTotalimponible(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($asignacionfamiliar, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($otrosnoimpobibles, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getTotalnoimponible(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible(), 0, ",", ".") . "</td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</tbody>";
    $contenido .= "</table>";
    /*********************************************Fin Haberes *********************/
    
    $mpdf->WriteHTML($contenido);
    $mpdf->AddPage('L');
    $contenido = "<h4 class='text-center'>LIBRO DE REMUNERACIONES</h4>";
    $contenido .= "<h5 class='text-center'>" . strtoupper("Periodo: " . $mes . " del " . $anio) . "</h5>";

    /************************************************************Descuentos************************************* */
    $contenido .= "<table class='table table-bordered table-hover' style='width: 100%;'>";
    $contenido .= "<thead>";
    $contenido .= "<tr>";
    $contenido .= "<th class='text-nowrap'>Rut</th>";
    $contenido .= "<th class='text-nowrap'>Nombre</th>";
    $contenido .= "<th class='text-nowrap'>DT</th>";
    $contenido .= "<th class='text-nowrap'>PREVISIÓN</th>";
    $contenido .= "<th class='text-nowrap'>SALUD</th>";
    $contenido .= "<th class='text-nowrap'>Imp. Unico</th>";
    $contenido .= "<th class='text-nowrap'>Seg. Ces</th>";
    $contenido .= "<th class='text-nowrap'>Otros D.leg</th>";
    $contenido .= "<th class='text-nowrap'>Tot. D.leg.</th>";
    $contenido .= "<th class='text-nowrap'>Varios</th>";
    $contenido .= "<th class='text-nowrap'>Tot. Desc</th>";
    $contenido .= "<th class='text-nowrap'>Líquido</th>";
    $contenido .= "</tr>";
    $contenido .= "</thead>";
    $contenido .= "<tbody>";
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $detalleliquidacion = $c->buscardetallesliquidacion($liquidacion->getId());
        $otrosdescuentoslegales = 0;
        $varios = 0;
        $impuestounico = 0;
        $asignacionfamiliar = 0;
        $horaextras = 0;
        $cesantia = 0;

        foreach ($detalleliquidacion as $detalle) {
            if ($detalle->getTipo() == 3) {
                if ($detalle->getCodigo() != 'PREVISION' && $detalle->getCodigo() != 'SALUD' && $detalle->getCodigo() != 'CESANTIA') {
                    $otrosdescuentoslegales = $otrosdescuentoslegales + $detalle->getMonto();
                } else if ($detalle->getCodigo() == 'CESANTIA') {
                    $cesantia = $cesantia + $detalle->getMonto();
                }
            } else if ($detalle->getTipo() == 4) {
                $varios = $varios + $detalle->getMonto();
            }

        }

        $contenido .= "<tr>";
        //Ajustar el rut al tamaño del te
        $contenido .= "<td class='text-nowrap'>" . $trabajador->getRut() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . $liquidacion->getDiastrabajados() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getDesafp(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getDessalud(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($impuestounico, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($cesantia, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($otrosdescuentoslegales, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getTotaldeslegales(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($varios, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format(($liquidacion->getTotaldeslegales() + $varios), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format(($liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible()) - ($liquidacion->getTotaldeslegales() + $varios), 0, ",", ".") . "</td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</tbody>";
    $contenido .= "</table>";

    /*******************************Fin Descuentos*************************************** */
    $mpdf->WriteHTML($contenido);
    $mpdf->AddPage('L');
    $contenido = "<h4 class='text-center'>LIBRO DE REMUNERACIONES</h4>";
    $contenido .= "<h5 class='text-center'>" . strtoupper("Periodo: " . $mes . " del " . $anio) . "</h5>";

    /************************************************************APORTE PATRONAL************************************* */
    $contenido .= "<table class='table table-bordered table-hover' style='width: 100%;'>";
    $contenido .= "<thead>";
    $contenido .= "<tr>";
    $contenido .= "<th class='text-nowrap'>Rut</th>";
    $contenido .= "<th class='text-nowrap'>Nombre</th>";
    $contenido .= "<th class='text-nowrap'>DT</th>";
    $contenido .= "<th class='text-nowrap'>Total. Imp</th>";
    $contenido .= "<th class='text-nowrap'>SIS</th>";
    $contenido .= "<th class='text-nowrap'>SEG. CES</th>";
    $contenido .= "<th class='text-nowrap'>TASA BASE</th>";
    $contenido .= "<th class='text-nowrap'>TASA LEY SANNA</th>";
    $contenido .= "<th class='text-nowrap'>TASA ADICIONAL</th>";
    $contenido .= "<th class='text-nowrap'>TOTAL SEGURO ACCIDENTES</th>";
    $contenido .= "</tr>";
    $contenido .= "</thead>";
    $contenido .= "<tbody>";
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $aporteempleador = $c->buscaraportempleador($liquidacion->getId());
        $sis = $liquidacion->getDessis();
        $cesantiap = 0;
        $tasabase = 0;
        $leysana = 0;
        $adicional = 0;
        $total = 0;
        if ($aporteempleador != null) {
            $cesantiap = $aporteempleador->getCesantiaempleador();
            $tasabase = $aporteempleador->getCotizacionbasica();
            $leysana = $aporteempleador->getCotizacionleysanna();
            $adicional = $aporteempleador->getCotizacionadicional();
            $total = $aporteempleador->getSeguroaccidentes();
        }

        $contenido .= "<tr>";
        //Ajustar el rut al tamaño del te
        $contenido .= "<td class='text-nowrap'>" . $trabajador->getRut() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . $liquidacion->getDiastrabajados() . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($liquidacion->getTotalimponible(), 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($sis, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($cesantiap, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($tasabase, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($leysana, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($adicional, 0, ",", ".") . "</td>";
        $contenido .= "<td class='text-nowrap'>" . number_format($total, 0, ",", ".") . "</td>";
        $contenido .= "</tr>";
    }
    $contenido .= "</tbody>";
    $contenido .= "</table>";

    /*******************************Fin Aporte Patronal*************************************** */



    $mpdf->WriteHTML($contenido);
    $mpdf->Output();
    

} else {
    $contenido .= "<div class='alert alert-danger'>Debe ingresar un periodo</div>";
    return;
}
