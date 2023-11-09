<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
//phpspreadsheet for CSV
use PhpOffice\PhpSpreadsheet\Spreadsheet;


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
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    //Nombre de la hoja
    $sheet->setTitle('Haberes');
    //agregar encabezado "Libro de remuneraciones PERIODO: MES AÑO"
    $sheet->setCellValue('A1', 'Libro de remuneraciones PERIODO: ' . $mes . ' ' . $anio);
    $sheet->setCellValue('A2', 'Rut');
    $sheet->setCellValue('B2', 'Nombre');
    $sheet->setCellValue('C2', 'DT');
    $sheet->setCellValue('D2', 'S. Base');
    $sheet->setCellValue('E2', 'H.E');
    $sheet->setCellValue('F2', 'Grat. Legal');
    $sheet->setCellValue('G2', 'Otros. Imp');
    $sheet->setCellValue('H2', 'Total. Imp');
    $sheet->setCellValue('I2', 'Asig Fam.');
    $sheet->setCellValue('J2', 'Otr. No Imp');
    $sheet->setCellValue('K2', 'Tot. No Imp');
    $sheet->setCellValue('L2', 'Tot. Haberes');

    $pos = 3;
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

        $sheet->setCellValue('A' . $pos, $trabajador->getRut());
        $sheet->setCellValue('B' . $pos, $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2());
        $sheet->setCellValue('C' . $pos, $liquidacion->getDiasTrabajados());
        $sheet->setCellValue('D' . $pos, number_format($liquidacion->getSueldoBase(), 0, ',', '.'));
        $sheet->setCellValue('E' . $pos, number_format($horaextras, 0, ',', '.'));
        $sheet->setCellValue('F' . $pos, number_format($liquidacion->getGratificacion(), 0, ',', '.'));
        $sheet->setCellValue('G' . $pos, number_format($otrosimponibles, 0, ',', '.'));
        $sheet->setCellValue('H' . $pos, number_format($liquidacion->getTotalImponible(), 0, ',', '.'));
        $sheet->setCellValue('I' . $pos, number_format($asignacionfamiliar, 0, ',', '.'));
        $sheet->setCellValue('J' . $pos, number_format($otrosnoimpobibles, 0, ',', '.'));
        $sheet->setCellValue('K' . $pos, number_format($liquidacion->getTotalNoImponible(), 0, ',', '.'));
        $sheet->setCellValue('L' . $pos, number_format($liquidacion->getTotalimponible() + $liquidacion->getTotalNoImponible(), 0, ',', '.'));
        $pos++;
    }

    //Agregar hoja de descuentos
    $spreadsheet->createSheet();
    $sheet = $spreadsheet->setActiveSheetIndex(1);
    //Nombre de la hoja
    $sheet->setTitle('Descuentos');
    //agregar encabezado "Libro de remuneraciones PERIODO: MES AÑO"
    $sheet->setCellValue('A1', 'Libro de remuneraciones PERIODO: ' . $mes . ' ' . $anio);
    $sheet->setCellValue('A2', 'Rut');
    $sheet->setCellValue('B2', 'Nombre');
    $sheet->setCellValue('C2', 'DT');
    $sheet->setCellValue('D2', 'PREVISIÓN');
    $sheet->setCellValue('E2', 'SALUD');
    $sheet->setCellValue('F2', 'Imp. Unico');
    $sheet->setCellValue('G2', 'Seg. Ces');
    $sheet->setCellValue('H2', 'Otros D.leg');
    $sheet->setCellValue('I2', 'Tot. D.leg.');
    $sheet->setCellValue('J2', 'Varios');
    $sheet->setCellValue('K2', 'Tot. Desc');
    $sheet->setCellValue('L2', 'Líquido');
    $pos = 3;
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

        $sheet->setCellValue('A' . $pos, $trabajador->getRut());
        $sheet->setCellValue('B' . $pos, $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2());
        $sheet->setCellValue('C' . $pos, $liquidacion->getDiasTrabajados());
        $sheet->setCellValue('D' . $pos, number_format($liquidacion->getDesafp(), 0, ',', '.'));
        $sheet->setCellValue('E' . $pos, number_format($liquidacion->getDessalud(), 0, ',', '.'));
        $sheet->setCellValue('F' . $pos, number_format($impuestounico, 0, ',', '.'));
        $sheet->setCellValue('G' . $pos, number_format($cesantia, 0, ',', '.'));
        $sheet->setCellValue('H' . $pos, number_format($otrosdescuentoslegales, 0, ',', '.'));
        $sheet->setCellValue('I' . $pos, number_format($liquidacion->getTotaldeslegales(), 0, ',', '.'));
        $sheet->setCellValue('J' . $pos, number_format($varios, 0, ',', '.'));
        $sheet->setCellValue('K' . $pos, number_format($liquidacion->getTotaldeslegales() + $varios, 0, ',', '.'));
        $sheet->setCellValue('L' . $pos, number_format(($liquidacion->getTotalimponible() + $liquidacion->getTotalnoimponible()) - ($liquidacion->getTotaldeslegales() + $varios), 0, ",", "."));
        $pos++;
    }

    //Agregar hoja de Aporte Patronal
    $spreadsheet->createSheet();
    $sheet = $spreadsheet->setActiveSheetIndex(2);
    //Nombre de la hoja
    $sheet->setTitle('Aporte Patronal');
    //agregar encabezado "Libro de remuneraciones PERIODO: MES AÑO"
    $sheet->setCellValue('A1', 'Libro de remuneraciones PERIODO: ' . $mes . ' ' . $anio);
    $sheet->setCellValue('A2', 'Rut');
    $sheet->setCellValue('B2', 'Nombre');
    $sheet->setCellValue('C2', 'DT');
    $sheet->setCellValue('D2', 'Total. Imp');
    $sheet->setCellValue('E2', 'SIS');
    $sheet->setCellValue('F2', 'SEG. CES');
    $sheet->setCellValue('G2', 'TASA BASE');
    $sheet->setCellValue('H2', 'TASA LEY SANNA');
    $sheet->setCellValue('I2', 'TASA ADICIONAL');
    $sheet->setCellValue('J2', 'TOTAL SEGURO ACCIDENTES');

    $pos = 3;
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
        
        $sheet->setCellValue('A' . $pos, $trabajador->getRut());
        $sheet->setCellValue('B' . $pos, $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2());
        $sheet->setCellValue('C' . $pos, $liquidacion->getDiasTrabajados());
        $sheet->setCellValue('D' . $pos, number_format($liquidacion->getTotalImponible(), 0, ',', '.'));
        $sheet->setCellValue('E' . $pos, number_format($sis, 0, ',', '.'));
        $sheet->setCellValue('F' . $pos, number_format($cesantiap, 0, ',', '.'));
        $sheet->setCellValue('G' . $pos, number_format($tasabase, 0, ',', '.'));
        $sheet->setCellValue('H' . $pos, number_format($leysana, 0, ',', '.'));
        $sheet->setCellValue('I' . $pos, number_format($adicional, 0, ',', '.'));
        $sheet->setCellValue('J' . $pos, number_format($total, 0, ',', '.'));
        $pos++;
    }


    //Descargar archivo
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Libro de remuneraciones ' . $mes . ' ' . $anio . '.xlsx"');
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
} else {
    $contenido .= "<div class='alert alert-danger'>Debe ingresar un periodo</div>";
    return;
}