<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['periodo'])) {
    $periodo = $_POST['periodo'];
    if (strlen($periodo) == 0) {
        echo "<div class='alert alert-danger'>Debe ingresar un periodo</div>";
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

    echo "<h4 class='text-center'>LIBRO DE REMUNERACIONES</h4>";
    echo "<h5 class='text-center'>" . strtoupper("Periodo: " . $mes . " del " . $anio) . "</h5>";

    //AGREGAR BOTON PARA DESCARGAR PDF Y EXCEL A LA DERECHA
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<div class="text-right d-flex justify-content-end" style="gap:10px">';
    echo '<button class="btn btn-outline-primary" onclick="exportarlibroremuneracionespdf()"><i class="fa fa-file-pdf-o"></i> Exportar PDF</button>';
    echo '<button class="btn btn-outline-primary" onclick="exportarlibroremuneracionesexcel()"><i class="fa fa-file-excel-o"></i> Exportar Excel</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    

    //CUERPO DEL LIBRO DE REMUNERACIONES
    echo '<div class="text-wrap">
    <div class="example">
        <div class="border">
            <div class="bg-light-1 nav-bg">
                <nav class="nav nav-tabs">
                    <a class="nav-link active" data-toggle="tab" href="#tabCont1">Haberes</a>
                    <a class="nav-link" data-toggle="tab" href="#tabCont2">Descuentos</a>
                    <a class="nav-link" data-toggle="tab" href="#tabCont3">Aporte Patronal</a>
                </nav>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane active show" id="tabCont1">
                    <div class="row">
                    <div class="col-md-12">
    ';


    /*********************Haberes****************************** */
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='text-nowrap'>Rut</th>";
    echo "<th class='text-nowrap'>Nombre</th>";
    echo "<th class='text-nowrap'>DT</th>";
    echo "<th class='text-nowrap'>S. Base</th>";
    echo "<th class='text-nowrap'>H.E</th>";
    echo "<th class='text-nowrap'>Grat. Legal</th>";
    echo "<th class='text-nowrap'>Otros. Imp</th>";
    echo "<th class='text-nowrap'>Total. Imp</th>";
    echo "<th class='text-nowrap'>Asig Fam.</th>";
    echo "<th class='text-nowrap'>Otr. No Imp</th>";
    echo "<th class='text-nowrap'>Tot. No Imp</th>";
    echo "<th class='text-nowrap'>Tot. Haberes</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $detalleliquidacion = $c->buscardetallesliquidacion($liquidacion->getId());
        $otrosimponibles = 0;
        $otrosnoimpobibles = 0;
        $asignacionfamiliar = 0;
        $horaextras = 0;
        
        foreach($detalleliquidacion as $detalle){
            if($detalle->getTipo() == 1){
                if($detalle->getCodigo()!= 'SUELDO BASE' && $detalle->getCodigo()!= 'GRATIFICACION' && $detalle->getCodigo()!= 'HORA EXTRAS AL 50%' && $detalle->getCodigo()!= 'HORA EXTRAS AL 75%' && $detalle->getCodigo()!= 'HORA EXTRAS AL 100%'){
                    $otrosimponibles = $otrosimponibles + $detalle->getMonto();
                }else if($detalle->getCodigo() == 'HORA EXTRAS AL 50%' || $detalle->getCodigo() == 'HORA EXTRAS AL 75%' || $detalle->getCodigo() == 'HORA EXTRAS AL 100%'){
                    $horaextras = $horaextras + $detalle->getMonto();
                }
            }else if($detalle->getTipo() == 2){
                $otrosnoimpobibles = $otrosnoimpobibles + $detalle->getMonto();
            }
        }

        echo "<tr>";
        //Ajustar el rut al tamaño del te
        echo "<td class='text-nowrap'>" . $trabajador->getRut() . "</td>";
        echo "<td class='text-nowrap'>" . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . "</td>";
        echo "<td class='text-nowrap'>" . $liquidacion->getDiastrabajados() . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getSueldobase(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($horaextras, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getGratificacion(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($otrosimponibles, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getTotalimponible(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($asignacionfamiliar, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($otrosnoimpobibles, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getTotalnoimponible(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible(), 0, ",", ".") . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    /*********************************************Fin Haberes *********************/


    echo '</div>
    </div>
    </div>
    <div class="tab-pane" id="tabCont2">
    <div class="row">
    <div class="col-md-12">
    ';
    /************************************************************Descuentos************************************* */
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='text-nowrap'>Rut</th>";
    echo "<th class='text-nowrap'>Nombre</th>";
    echo "<th class='text-nowrap'>DT</th>";
    echo "<th class='text-nowrap'>PREVISIÓN</th>";
    echo "<th class='text-nowrap'>SALUD</th>";
    echo "<th class='text-nowrap'>Imp. Unico</th>";
    echo "<th class='text-nowrap'>Seg. Ces</th>";
    echo "<th class='text-nowrap'>Otros D.leg</th>";
    echo "<th class='text-nowrap'>Tot. D.leg.</th>";
    echo "<th class='text-nowrap'>Varios</th>";
    echo "<th class='text-nowrap'>Tot. Desc</th>";
    echo "<th class='text-nowrap'>Líquido</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $detalleliquidacion = $c->buscardetallesliquidacion($liquidacion->getId());
        $otrosdescuentoslegales = 0;
        $varios = 0;
        $impuestounico = 0;
        $asignacionfamiliar = 0;
        $horaextras = 0;
        $cesantia = 0;
        
        foreach($detalleliquidacion as $detalle){
            if($detalle->getTipo() == 3){
                if($detalle->getCodigo()!= 'PREVISION' && $detalle->getCodigo()!= 'SALUD' && $detalle->getCodigo()!= 'CESANTIA'){
                    $otrosdescuentoslegales = $otrosdescuentoslegales + $detalle->getMonto();
                }else if($detalle->getCodigo() == 'CESANTIA'){
                    $cesantia = $cesantia + $detalle->getMonto();
                }
            }else if($detalle->getTipo() == 4){
                $varios = $varios + $detalle->getMonto();
            }

        }

        echo "<tr>";
        //Ajustar el rut al tamaño del te
        echo "<td class='text-nowrap'>" . $trabajador->getRut() . "</td>";
        echo "<td class='text-nowrap'>" . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . "</td>";
        echo "<td class='text-nowrap'>" . $liquidacion->getDiastrabajados() . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getDesafp(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getDessalud(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($impuestounico, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($cesantia, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($otrosdescuentoslegales, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getTotaldeslegales(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($varios, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format(($liquidacion->getTotaldeslegales() + $varios), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format(($liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible()) - ($liquidacion->getTotaldeslegales() + $varios), 0, ",", ".") . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    /*******************************Fin Descuentos*************************************** */

    echo '</div>
    </div>
    </div>
    <div class="tab-pane" id="tabCont3">
    <div class="row">
    <div class="col-md-12">
    ';
    
    /************************************************************APORTE PATRONAL************************************* */
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='text-nowrap'>Rut</th>";
    echo "<th class='text-nowrap'>Nombre</th>";
    echo "<th class='text-nowrap'>DT</th>";
    echo "<th class='text-nowrap'>Total. Imp</th>";
    echo "<th class='text-nowrap'>SIS</th>";
    echo "<th class='text-nowrap'>SEG. CES</th>";
    echo "<th class='text-nowrap'>TASA BASE</th>";
    echo "<th class='text-nowrap'>TASA LEY SANNA</th>";
    echo "<th class='text-nowrap'>TASA ADICIONAL</th>";
    echo "<th class='text-nowrap'>TOTAL SEGURO ACCIDENTES</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $aporteempleador = $c->buscaraportempleador($liquidacion->getId());
        $sis = $liquidacion->getDessis();
        $cesantiap = 0;
        $tasabase = 0;
        $leysana = 0;
        $adicional = 0;
        $total = 0;
        if($aporteempleador!=null){
            $cesantiap = $aporteempleador->getCesantiaempleador();
            $tasabase = $aporteempleador->getCotizacionbasica();
            $leysana = $aporteempleador->getCotizacionleysanna();
            $adicional = $aporteempleador->getCotizacionadicional();
            $total = $aporteempleador->getSeguroaccidentes();
        }

        echo "<tr>";
        //Ajustar el rut al tamaño del te
        echo "<td class='text-nowrap'>" . $trabajador->getRut() . "</td>";
        echo "<td class='text-nowrap'>" . $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2() . "</td>";
        echo "<td class='text-nowrap'>" . $liquidacion->getDiastrabajados() . "</td>";
        echo "<td class='text-nowrap'>" . number_format($liquidacion->getTotalimponible(), 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($sis, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($cesantiap, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($tasabase, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($leysana, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($adicional, 0, ",", ".") . "</td>";
        echo "<td class='text-nowrap'>" . number_format($total, 0, ",", ".") . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    /*******************************Fin Descuentos*************************************** */
    

    echo '</div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>';
}else{
    echo "<div class='alert alert-danger'>Debe ingresar un periodo</div>";
    return;
}
