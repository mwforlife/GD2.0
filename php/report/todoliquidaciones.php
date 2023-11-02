<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
$liquidaciones = $c->listarliquidaciones1($_SESSION['CURRENT_ENTERPRISE']);

if(isset($_SESSION['PERIOD_LIQUIDACION']) && isset($_SESSION['CENTRO_COSTO_LIQUIDACION'])){
    $periodo = $_SESSION['PERIOD_LIQUIDACION'];
    $periodo = $periodo . "-01";
    $liquidaciones = $c->listarliquidacionesperiodocentrocosto1($_SESSION['CURRENT_ENTERPRISE'],$periodo,$_SESSION['CENTRO_COSTO_LIQUIDACION']);
}else if(isset($_SESSION['PERIOD_LIQUIDACION'])){
    $periodo = $_SESSION['PERIOD_LIQUIDACION'];
    $periodo = $periodo . "-01";
    $liquidaciones = $c->listarliquidacionesperiodo1($_SESSION['CURRENT_ENTERPRISE'],$periodo);
}else if(isset($_SESSION['CENTRO_COSTO_LIQUIDACION'])){
    $liquidaciones = $c->listarliquidacionescentrocosto1($_SESSION['CURRENT_ENTERPRISE'],$_SESSION['CENTRO_COSTO_LIQUIDACION']);
}
if (count($liquidaciones) > 0) {
    $mpdf = new \Mpdf\Mpdf();
    foreach ($liquidaciones as $liquidacion) {
        $id = $liquidacion->getId();
        $detalle_liquidacion = $c->buscardetallesliquidacion($id);
        $empresa = $c->buscarempresa($liquidacion->getRegister_at());
        $representante = $c->BuscarRepresentanteLegalempresa($empresa->getId());
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $contrato = $c->buscarcontratobyID($liquidacion->getContrato());
        $centrocosto = $c->buscarcentrcosto($contrato->getCentrocosto());
        $periodo = $liquidacion->getPeriodo();
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

        $periodo = $mes . " " . $anio;

        $contenido = "";

        $contenido .= "<table style='width: 100%;'>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 60%; text-align: right;'>LIQUIDICACION DE SUELDO</td>";
        $contenido .= "<td style='width: 40%; text-align: right;'> " . $periodo . "</td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";
        $contenido .= "<hr style='width: 100%; margin:2px;'>";
        $contenido .= "<hr style='width: 100%; margin:2px;'>";

        //Datos de la empresa
        $contenido .= "<table style='width: 100%; font-size:12px;'>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 70%;'>NOMBRE EMPRESA: " . $empresa->getRazonSocial() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 70%;'>RUT: " . $empresa->getRut() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 70%;'>DIRECCION: " . $empresa->getCalle() . " " . $empresa->getNumero() . ", " . $empresa->getVilla() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 70%;'>GIRO: " . $empresa->getGiro() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 70%;'>REPRESENTANTE LEGAL: " . $representante->getNombre() . " " . $representante->getApellido1() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";
        $contenido .= "<hr style='width: 100%; margin:2px;'>";

        //Datos del trabajador
        $contenido .= "<table style='width: 100%; font-size:12px;' >";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'>RUN: " . $trabajador->getRut() . "</td>";
        $contenido .= "<td style='width: 50%;'>AFP: " . $liquidacion->getAfp() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'>NOMBRE: " . $trabajador->getNombre() . " " . $trabajador->getApellido1() . "</td>";
        $contenido .= "<td style='width: 50%;'>INSTITUTO DE SALUD: " . $liquidacion->getSalud() . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'>CARGO: " . $contrato->getCargo() . "</td>";
        $contenido .= "<td style='width: 50%;'>SUELDO BASE: $" . number_format($liquidacion->getSueldobase(), 0, ",", ".") . "</td>";

        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'>INICIO CONTRATO: " . date("d-m-Y", strtotime($contrato->getFechaInicio())) . "</td>";
        $contenido .= "<td style='width: 50%;'>IMPONIBLE: $" . number_format($liquidacion->getTotalimponible(), 0, ",", ".") . "</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'>DIAS TRABAJADOS: " . $liquidacion->getDiastrabajados() . " Dias</td>";
        $contenido .= "<td style='width: 50%;'>TRIBUTABLE: $" . number_format($liquidacion->getTotaltributable(), 0, ",", ".") . "</td>";
        $contenido .= "</tr>";
        if($liquidacion->getHorasextras1() > 0 && $liquidacion->getHorasextras2() > 0 && $liquidacion->getHorasextras3() > 0){
            $contenido .= "<tr>";
            $contenido .= "<td style='width: 50%;'>HORAS EXTRAS AL 50%: " . $liquidacion->getHorasextras1() . " hrs</td>";
            $contenido .= "<td style='width: 50%;'>HORAS EXTRAS AL 75%: " . $liquidacion->getHorasextras2() . " hrs</td>";
            $contenido .= "</tr>";
            $contenido .= "<tr>";
            $contenido .= "<td style='width: 50%;'>HORAS EXTRAS AL 100%: " . $liquidacion->getHorasextras3() . " hrs</td>";
            $contenido .= "</tr>";
        }else{
        $contenido .= "<tr>";
        if ($liquidacion->getHorasextras1() > 0) {
            $contenido .= "<td style='width: 50%;'>HORAS EXTRAS AL 50%: " . $liquidacion->getHorasextras1() . " hrs</td>";
        }
        if ($liquidacion->getHorasextras2() > 0) {
            $contenido .= "<td style='width: 50%;'>HORAS EXTRAS AL 75%: " . $liquidacion->getHorasextras2() . " hrs</td>";
        }
        if ($liquidacion->getHorasextras3() > 0) {
            $contenido .= "<td style='width: 50%;'>HORAS EXTRAS AL 100%: " . $liquidacion->getHorasextras3() . " hrs</td>";
        }
        $contenido .= "</tr>";
        }
        $contenido .= "</table>";
        $contenido .= "<hr style='width: 100%; margin:2px;'>";

        //Detalle de la liquidacion
        $contenido .= "<br/>";
        $contenido .= "<br/>";
        $contenido .= "<table style='width: 100%;border-top: 1px solid black;border-bottom: 1px solid black;font-size:12px;'>";
        $contenido .= "<tr style=''>";
        $contenido .= "<td style='width: 50%;'><h4>HABERES</h4></td>";
        $contenido .= "<td style='width: 50%; text-align: right;'> <h4>VALOR</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "<table style='width: 100%;font-size:12px;'>";
        foreach ($detalle_liquidacion as $detalle) {
            if ($detalle->getTipo() == 1) {
                $contenido .= "<tr>";
                $contenido .= "<td style='width: 50%;'>" . $detalle->getCodigo() . "</td>";
                $contenido .= "<td style='width: 50%;text-align: right;'>$ " . number_format($detalle->getMonto(), 0, ",", ".") . "</td>";
                $contenido .= "</tr>";
            }
        }
        $contenido .= "<tr  style='border-top: 1px solid black;'>";
        $contenido .= "<td style='width: 50%;'><h4>TOTAL IMPONIBLE</h4></td>";
        $contenido .= "<td style='width: 50%;text-align: right;'><h4>$ " . number_format($liquidacion->getTotalimponible(), 0, ",", ".") . "</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'><br/></td>";
        $contenido .= "</tr>";

        foreach ($detalle_liquidacion as $detalle) {
            if ($detalle->getTipo() == 2) {
                $contenido .= "<tr>";
                $contenido .= "<td style='width: 50%;'>" . $detalle->getCodigo() . "</td>";
                $contenido .= "<td style='width: 50%;text-align: right;'>$ " . number_format($detalle->getMonto(), 0, ",", ".") . "</td>";
                $contenido .= "</tr>";
            }
        }
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'><h4>TOTAL NO IMPONIBLE</h4></td>";
        $contenido .= "<td style='width: 50%;text-align: right;'><h4>$ " . number_format($liquidacion->getTotalnoimponible(), 0, ",", ".") . "</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'><br/></td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "<table style='width: 100%;border-top: 1px solid black;border-bottom: 1px solid black;font-size:12px;'>";
        $contenido .= "<tr style=''>";
        $contenido .= "<td style='width: 50%;'><h4>TOTAL HABERES</h4></td>";
        $contenido .= "<td style='width: 50%; text-align: right;'><h4>$ " . number_format($liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible(), 0, ",", ".") . "</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "<br/>";
        $contenido .= "<table style='width: 100%;border-top: 1px solid black;border-bottom: 1px solid black;font-size:12px;'>";
        $contenido .= "<tr style=''>";
        $contenido .= "<td style='width: 50%;'><h4>DESCUENTOS</h4></td>";
        $contenido .= "<td style='width: 50%; text-align: right;'> <h4>VALOR</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "<table style='width: 100%;font-size:12px;'>";
        foreach ($detalle_liquidacion as $detalle) {
            if ($detalle->getTipo() == 3) {
                $contenido .= "<tr>";
                $contenido .= "<td style='width: 50%;'>" . $detalle->getCodigo() . "</td>";
                $contenido .= "<td style='width: 50%;text-align: right;'>$ " . number_format($detalle->getMonto(), 0, ",", ".") . "</td>";
                $contenido .= "</tr>";
            }
        }
        $contenido .= "<tr  style='border-top: 1px solid black;'>";
        $contenido .= "<td style='width: 50%;'><h4>TOTAL DESCUENTOS LEGALES</h4></td>";
        $contenido .= "<td style='width: 50%;text-align: right;'><h4>$ " . number_format($liquidacion->getTotaldeslegales(), 0, ",", ".") . "</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'><br/></td>";
        $contenido .= "</tr>";

        foreach ($detalle_liquidacion as $detalle) {
            if ($detalle->getTipo() == 4) {
                $contenido .= "<tr>";
                $contenido .= "<td style='width: 50%;'>" . $detalle->getCodigo() . "</td>";
                $contenido .= "<td style='width: 50%;text-align: right;'>$ " . number_format($detalle->getMonto(), 0, ",", ".") . "</td>";
                $contenido .= "</tr>";
            }
        }
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'><h4>TOTAL DESCUENTOS NO LEGALES</h4></td>";
        $contenido .= "<td style='width: 50%;text-align: right;'><h4>$ " . number_format($liquidacion->getTotaldesnolegales(), 0, ",", ".") . "</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'><br/></td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";


        $contenido .= "<table style='width: 100%;border-top: 1px solid black;border-bottom: 1px solid black;font-size:12px;'>";
        $contenido .= "<tr style=''>";
        $contenido .= "<td style='width: 50%;'><h4>TOTAL DESCUENTOS</h4></td>";
        $contenido .= "<td style='width: 50%; text-align: right;'><h4>$ " . number_format($liquidacion->getTotaldeslegales() + $liquidacion->getTotaldesnolegales(), 0, ",", ".") . "</h4></td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "<br/>";
        $totalliquidacion = $liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible() - ($liquidacion->getTotaldeslegales() + $liquidacion->getTotaldesnolegales());
        $totalenletras = $c->convertirNumeroLetras($totalliquidacion);
        $contenido .= "<table style='width: 100%;font-size:12px; border-top: 1px solid black; border-bottom: 1px solid black;'>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%;'>ALCANCE LIQUIDO </td>";
        $contenido .= "<td style='width: 50%;text-align: right;'>$ " . number_format($totalliquidacion, 0, ",", ".") . "</td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";
        $contenido .= "<br/>";

        $contenido .= "<table style='width: 100%;font-size:12px;'>";
        $contenido .= "<tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 75%;'>SON " . strtoupper($totalenletras) . " PESOS</td>";
        $contenido .= "<td style='width: 25%;text-align: right;'>Fecha: " . date("d-m-Y", strtotime($liquidacion->getFecha_liquidacion())) . "</td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";

        $contenido .= "<hr style='width: 100%; margin:2px;'>";
        $contenido .= "<p style='font-size: 12px; text-align: justify;'>Recibí conforme el alcance líquido de la presente liquidación, no teniendo cargo o cobro alguno que hacer por otro concepto.</p>";
        $contenido .= "<br/>";
        $contenido .= "<br/>";

        $contenido .= "<table style='width: 100%;'>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%; text-align: center;font-size:12px;'>____________________________________</td>";
        $contenido .= "<td style='width: 50%; text-align: center;font-size:12px;'>____________________________________</td>";
        $contenido .= "</tr>";
        $contenido .= "<tr>";
        $contenido .= "<td style='width: 50%; text-align: center;font-size:12px;'>FIRMA DEL EMPLEADOR</td>";
        $contenido .= "<td style='width: 50%; text-align: center;font-size:12px;'>FIRMA DEL TRABAJADOR</td>";
        $contenido .= "</tr>";
        $contenido .= "</table>";
        $mpdf->AddPage();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.apoyocontratista.cl</div>');
        $mpdf->WriteHTML($contenido);
    }
    $mpdf->title = 'Liquidaciones de Sueldo';
    $mpdf->author = 'KaiserTech - Gestor de Documentos';
    $mpdf->creator = 'KaiserTech - Gestor de Documentos';
    $mpdf->subject = 'Finiquito del Trabajador';
    $mpdf->keywords = 'Finiquito, Trabajador, KaiserTech';
    $fecha = date('Ymdhis');
    $mpdf->Output('Liquidacion_' . $fecha . '.pdf', 'I');
} else {
    header('Location: ../../liquidaciones.php');
}
