<?php
require '../controller.php';
$c = new Controller();
require '../plugins/vendor/autoload.php';
//phpspreadsheet for CSV
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

session_start();
if(!isset($_SESSION['CURRENT_ENTERPRISE'])){
    header("location: ../../");
}
$empresa = $_SESSION['CURRENT_ENTERPRISE'];


if (isset($_GET['periodo'])) {
    $periodo = $_GET['periodo'];
    $spreadsheet = new Spreadsheet();
    $spreadsheet->getActiveSheet()->setTitle('Hoja 1');
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
    $writer->setDelimiter(';');
    $writer->setEnclosure('');
    $writer->setLineEnding("\r\n");
    //Formato UTF-8
    $writer->setUseBOM(true);
    $spreadsheet->getActiveSheet()->setTitle('Hoja 1');
    /*
    $spreadsheet->getActiveSheet()->setCellValue('A1', 'RUT');
    $spreadsheet->getActiveSheet()->setCellValue('B1', 'DV');
    $spreadsheet->getActiveSheet()->setCellValue('C1', 'Apellido Paterno');
    $spreadsheet->getActiveSheet()->setCellValue('D1', 'Apellido Materno');
    $spreadsheet->getActiveSheet()->setCellValue('E1', 'Nombres');
    $spreadsheet->getActiveSheet()->setCellValue('F1', 'Sexo');
    $spreadsheet->getActiveSheet()->setCellValue('G1', 'Nacionalidad');
    $spreadsheet->getActiveSheet()->setCellValue('H1', 'Tipo Pago');
    $spreadsheet->getActiveSheet()->setCellValue('I1', 'Período Remuneraciones (Desde)');
    $spreadsheet->getActiveSheet()->setCellValue('J1', 'Período Remuneraciones (Hasta)');
    $spreadsheet->getActiveSheet()->setCellValue('K1', 'Régimen Previsional');
    $spreadsheet->getActiveSheet()->setCellValue('L1', 'Tipo Trabajador');
    $spreadsheet->getActiveSheet()->setCellValue('M1', 'Días Trabajados');
    $spreadsheet->getActiveSheet()->setCellValue('N1', 'Tipo de Línea');
    $spreadsheet->getActiveSheet()->setCellValue('O1', 'Código Movimiento de Personal');
    $spreadsheet->getActiveSheet()->setCellValue('P1', 'Fecha Desde');
    $spreadsheet->getActiveSheet()->setCellValue('Q1', 'Fecha Hasta');
    $spreadsheet->getActiveSheet()->setCellValue('R1', 'Tramo Asignación Familiar');
    $spreadsheet->getActiveSheet()->setCellValue('S1', 'N° Cargas Simples');
    $spreadsheet->getActiveSheet()->setCellValue('T1', 'N° Cargas Maternales');
    $spreadsheet->getActiveSheet()->setCellValue('U1', 'N° Cargas Inválidas');
    $spreadsheet->getActiveSheet()->setCellValue('V1', 'Asignación Familiar');
    $spreadsheet->getActiveSheet()->setCellValue('W1', 'Asignación Familiar Retroactiva');
    $spreadsheet->getActiveSheet()->setCellValue('X1', 'Reintegro Cargas Familiares');
    $spreadsheet->getActiveSheet()->setCellValue('Y1', 'Subsidio Trabajador Joven');
    $spreadsheet->getActiveSheet()->setCellValue('Z1', 'Código de la AFP');
    $spreadsheet->getActiveSheet()->setCellValue('AA1', 'Renta Imponible AFP');
    $spreadsheet->getActiveSheet()->setCellValue('AB1', 'Cotización Obligatoria AFP');
    $spreadsheet->getActiveSheet()->setCellValue('AC1', 'Cotización Seguro de Invalidez y Sobrevivencia SIS');
    $spreadsheet->getActiveSheet()->setCellValue('AD1', 'Cuenta de Ahorro Voluntario AFP');
    $spreadsheet->getActiveSheet()->setCellValue('AE1', 'Renta Imp. Sust.AFP');
    $spreadsheet->getActiveSheet()->setCellValue('AF1', 'Tasa Pactada (Sustit.)');
    $spreadsheet->getActiveSheet()->setCellValue('AG1', 'Aporte Indemn. (Sustit.)');
    $spreadsheet->getActiveSheet()->setCellValue('AH1', 'N° Períodos (Sustit.)');
    $spreadsheet->getActiveSheet()->setCellValue('AI1', 'Período desde (Sustit.)');
    $spreadsheet->getActiveSheet()->setCellValue('AJ1', 'Período Hasta (Sustit.)');
    $spreadsheet->getActiveSheet()->setCellValue('AK1', 'Puesto de Trabajo Pesado');
    $spreadsheet->getActiveSheet()->setCellValue('AL1', '% Cotización Trabajo Pesado');
    $spreadsheet->getActiveSheet()->setCellValue('AM1', 'Cotización Trabajo Pesado');
    $spreadsheet->getActiveSheet()->setCellValue('AN1', 'Código de la Institución APVI');
    $spreadsheet->getActiveSheet()->setCellValue('AO1', 'Número de Contrato APVI');
    $spreadsheet->getActiveSheet()->setCellValue('AP1', 'Forma de Pago APVI');
    $spreadsheet->getActiveSheet()->setCellValue('AQ1', 'Cotización APVI');
    $spreadsheet->getActiveSheet()->setCellValue('AR1', 'Cotización Depósitos Convenidos');
    $spreadsheet->getActiveSheet()->setCellValue('AS1', 'Código de la Institución Autorizada APVC');
    $spreadsheet->getActiveSheet()->setCellValue('AT1', 'Número de Contrato APVC');
    $spreadsheet->getActiveSheet()->setCellValue('AU1', 'Forma de Pago APVC');
    $spreadsheet->getActiveSheet()->setCellValue('AV1', 'Cotización Trabajador APVC');
    $spreadsheet->getActiveSheet()->setCellValue('AW1', 'Cotización Empleador APVC');
    $spreadsheet->getActiveSheet()->setCellValue('AX1', 'RUT Afiliado Voluntario');
    $spreadsheet->getActiveSheet()->setCellValue('AY1', 'DV Afiliado Voluntario');
    $spreadsheet->getActiveSheet()->setCellValue('AZ1', 'Apellido Paterno');
    $spreadsheet->getActiveSheet()->setCellValue('BA1', 'Apellido Materno');
    $spreadsheet->getActiveSheet()->setCellValue('BB1', 'Nombres');
    $spreadsheet->getActiveSheet()->setCellValue('BC1', 'Código Movimiento de Personal');
    $spreadsheet->getActiveSheet()->setCellValue('BD1', 'Fecha Desde');
    $spreadsheet->getActiveSheet()->setCellValue('BE1', 'Fecha Hasta');
    $spreadsheet->getActiveSheet()->setCellValue('BF1', 'Código de la AFP');
    $spreadsheet->getActiveSheet()->setCellValue('BG1', 'Monto Capitalización Voluntaria');
    $spreadsheet->getActiveSheet()->setCellValue('BH1', 'Monto Ahorro Voluntario');
    $spreadsheet->getActiveSheet()->setCellValue('BI1', 'Número de Periodos de Cotización');
    $spreadsheet->getActiveSheet()->setCellValue('BJ1', 'Código Ex-Caja Régimen');
    $spreadsheet->getActiveSheet()->setCellValue('BK1', 'Tasa Cotización Ex-Caja Previsión');
    $spreadsheet->getActiveSheet()->setCellValue('BL1', 'Renta Imponible IPS / ISL / Fonasa');
    $spreadsheet->getActiveSheet()->setCellValue('BM1', 'Cotización Obligatoria IPS');
    $spreadsheet->getActiveSheet()->setCellValue('BN1', 'Renta Imponible Desahucio');
    $spreadsheet->getActiveSheet()->setCellValue('BO1', 'Código Ex-Caja Régimen Desahucio');
    $spreadsheet->getActiveSheet()->setCellValue('BP1', 'Tasa Cotización Desahucio');
    $spreadsheet->getActiveSheet()->setCellValue('BQ1', 'Cotización Desahucio');
    $spreadsheet->getActiveSheet()->setCellValue('BR1', 'Cotización Fonasa');
    $spreadsheet->getActiveSheet()->setCellValue('BS1', 'Cotización Acc. Trabajo (INP)');
    $spreadsheet->getActiveSheet()->setCellValue('BT1', 'Bonificación Ley 15.386');
    $spreadsheet->getActiveSheet()->setCellValue('BU1', 'Descuento por cargas familiar IPS');
    $spreadsheet->getActiveSheet()->setCellValue('BV1', 'Bonos de Gobierno');
    $spreadsheet->getActiveSheet()->setCellValue('BW1', 'Código Institución de Salud');
    $spreadsheet->getActiveSheet()->setCellValue('BX1', 'Número del FUN');
    $spreadsheet->getActiveSheet()->setCellValue('BY1', 'Renta Imponible Isapre');
    $spreadsheet->getActiveSheet()->setCellValue('BZ1', 'Moneda del plan pactado con Isapre');
    $spreadsheet->getActiveSheet()->setCellValue('CA1', 'Cotización Pactada');
    $spreadsheet->getActiveSheet()->setCellValue('CB1', 'Cotización Obligatoria Isapre');
    $spreadsheet->getActiveSheet()->setCellValue('CC1', 'Cotización Adicional Voluntaria');
    $spreadsheet->getActiveSheet()->setCellValue('CD1', 'Monto Garantía Explícita de Salud');
    $spreadsheet->getActiveSheet()->setCellValue('CE1', 'Código CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CF1', 'Renta Imponible CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CG1', 'Créditos Personales CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CH1', 'Descuento Dental CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CI1', 'Descuento por Leasing');
    $spreadsheet->getActiveSheet()->setCellValue('CJ1', 'Descuento por seguro de vida CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CK1', 'Otros descuentos CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CL1', 'Cotización a CCAF de no afiliados a Isapres');
    $spreadsheet->getActiveSheet()->setCellValue('CM1', 'Descuento Cargas Familiares CCAF');
    $spreadsheet->getActiveSheet()->setCellValue('CN1', 'Otros Descuentos CCAF 1');
    $spreadsheet->getActiveSheet()->setCellValue('CO1', 'Otros Descuentos CCAF 2');
    $spreadsheet->getActiveSheet()->setCellValue('CP1', 'Bonos de Gobierno (Uso Futuro)');
    $spreadsheet->getActiveSheet()->setCellValue('CQ1', 'Código de Sucursal (Uso Futuro)');
    $spreadsheet->getActiveSheet()->setCellValue('CR1', 'Código Mutual');
    $spreadsheet->getActiveSheet()->setCellValue('CS1', 'Renta Imponible Mutual');
    $spreadsheet->getActiveSheet()->setCellValue('CT1', 'Cotización Accidente');
    $spreadsheet->getActiveSheet()->setCellValue('CU1', 'Sucursal para pago Mutual');
    $spreadsheet->getActiveSheet()->setCellValue('CV1', 'Renta Imponible Seguro Cesantía');
    $spreadsheet->getActiveSheet()->setCellValue('CW1', 'Aporte Trabajador Seguro Cesantía');
    $spreadsheet->getActiveSheet()->setCellValue('CX1', 'Aporte Empleador Seguro Cesantía');
    $spreadsheet->getActiveSheet()->setCellValue('CY1', 'Rut Pagadora Subsidio');
    $spreadsheet->getActiveSheet()->setCellValue('CZ1', 'DV Pagadora Subsidio');
    $spreadsheet->getActiveSheet()->setCellValue('DA1', 'Centro de Costos, Sucursal, Agencia, Obra, Región');*/

    $pos = 1;
    if (strlen($periodo) < 7) {
        echo "Periodo invalido<br>";
        echo "<div style='color:red'>El periodo debe tener 7 caracteres</div>";
        return;
    }
    $periodo = $periodo . "-01";
    $mes = date("m", strtotime($periodo));

    $liquidaciones = $c->listartodasliquidacionesperiodo($periodo);
    $empresa = $c->buscarEmpresa1($empresa);
    $cajacompensacion = $c->buscarcaja($empresa->getCajasCompensacion());
    $mutual = $c->buscarmutual($empresa->getMutuales());
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $detalleliquidacion = $c->buscardetallesliquidacion($liquidacion->getId());
        $aportepatronal = $c->buscaraportempleador($liquidacion->getId());
        $prevision  = $c->buscarprevisiontrabajador($liquidacion->getTrabajador());
        $movimientos = $c->buscarmovimientoxtrabajador($liquidacion->getTrabajador(), $periodo);
        $contrato = $c->buscarultimocontratoactivo($liquidacion->getTrabajador());
        $afp = null;
        if($prevision!=null){
            $afp = $c->buscarafp($prevision->getAfp());
        }

        //Gestion de datos y valores
        $rut = $trabajador->getRut();
        $rut = str_replace(".", "", $rut);
        //El DV es el ultimo caracter del rut
        $dv = substr($rut, -1);
        //El rut es todo menos el ultimo caracter
        $rut = str_replace("-", "", $rut);
        $rut = substr($rut, 0, -1);
        $ape_paterno = $trabajador->getApellido1();
        $ape_materno = $trabajador->getApellido2();
        $nombres = $trabajador->getNombre();
        $sexo = $trabajador->getSexo();
        $nacionalidad = $trabajador->getNacionalidad();
        $tipo_pago = "01";
        $mesperiodo = date("m", strtotime($periodo));
        $anioperiodo = date("Y", strtotime($periodo));
        $mesperiodo = intval($mesperiodo);
        $periododesde = $mes.$anioperiodo;
        $periodohasta = $mes.$anioperiodo;
        $regimenprevisional = "AFP";
        if($afp!=null){
            if($afp->getCodigoPrevired()>0){
                $regimenprevisional = "AFP";
            }else{
                $regimenprevisional = "SIP";
            }
        }else{
            $regimenprevisional = "SIP";
        }
        $tipotrabajador = "01";
        $tipotrabajador = 0;
        if($trabajador->getPension()==1){
            $tipotrabajador = 1;
        }else{
            $fechanacimiento = $trabajador->getNacimiento();
            //Calculo de la edad
            $dia = date("d");
            $mes = date("m");
            $ano = date("Y");
            $edad = $ano - date("Y", strtotime($fechanacimiento));
            if ($mes < date("m", strtotime($fechanacimiento))) {
                $edad--;
            } else {
                if ($mes == date("m", strtotime($fechanacimiento))) {
                    if ($dia < date("d", strtotime($fechanacimiento))) {
                        $edad--;
                    }
                }
            }
            if ($edad > 65) {
                $tipotrabajador = 3;
            } else {
                $tipotrabajador = 0;
            }
        }
        $diastrabajados = $liquidacion->getDiasTrabajados();
        $tipolinea = "00";
        $codmovi = 0;
        $fechadesde = "";
        $fechahasta = "";
        $tramoasignacion = "Sin Información";
        $cargasimple = 0;
        $cargamaterna = 0;
        $cargainvalida = 0;
        $asignacionfamiliar = 0;
        $asignacionfamiliarretroactiva = 0;
        $reintegrocargas = 0;
        $subsidiojoven = "N";
        $codafp = "00";
        if($regimenprevisional=="AFP"){
            if($afp!=null){
                $codafp = $afp->getCodigoPrevired();
            }
        }
        $rentaimponibleafp = $liquidacion->getTotalimponible();
        $cotizacionobligatoriaafp = $liquidacion->getDesafp();
        $cotizacionsegurosis = $liquidacion->getDessis();
        $cuentavoluntariaafp = 0;
        $rentaimponiblesustitutiva = 0;
        $tasapactada = 0;
        $aporteindemnizacion = 0;
        $nperiodosustitutiva = "";
        $periododesdesustitutiva = "";
        $periodohastasustitutiva = "";
        $puestotrabajopesado = "";
        $cotizaciontrabajopesado = 0;
        $porcotizaciontrabajopesado = 0;
        $codapvi = "000";
        $ncontratoapvi = "";
        $formapagoapvi = "";
        $cotizacionapvi = 0;
        $cotizaciondepositos = 0;
        $codapvc = "00";
        $ncontratoapvc = "";
        $formapagoapvc = "";
        $cotizaciontrabajadorapvc = 0;
        $cotizacionempleadorapvc = 0;
        $rutafiliado = "";
        $dvafiliado = "";
        $apepaternoafiliado = "";
        $apematernoafiliado = "";
        $nombresafiliado = "";
        $codmoviafiliado = 0;
        $fechadesdeafiliado = "";
        $fechahastaafiliado = "";
        $codafpafiliado = "0";
        $montocapitalizacion = 0;
        $montoahorro = 0;
        $nperiodoscotizacion = 0;
        $codexcaja = "00";
        $tasacotizacion = 0;
        $rentaimponiblefonasa = $liquidacion->getTotalimponible();
        $cotizacionobligatoriaips = 0;
        $rentaimponibledesahucio = 0;
        $codexcajadesahucio = "0";
        $tasacotizaciondesahucio = 0;
        $cotizaciondesahucio = 0;
        $cotizacionfonasa = $liquidacion->getDessalud();
        $cotizacionaccidente = 0;
        $bonificacionley = 0;
        $descuentocargas = 0;
        $bonosgobierno = 0;
        $instsalud ="00";
        if($prevision!=null){
            $instsalud = $c->buscarisapre($prevision->getIsapre());
            if($instsalud!=null){
                $instsalud = $instsalud->getCodigoPrevired();
            }
        }
        $numerofun = "";
        $rentaimponibleisapre = 0;
        $monedapactada = "00";
        $cotizacionpactada = 0;
        $cotizacionobligatoriaisapre = 0;
        $cotizacionadicional = 0;
        $montoges = 0;
        $codccaf = "00";
        if($cajacompensacion!=null){
            $codccaf = $cajacompensacion->getCodigoPrevired();
        }
        $rentaimponibleccaf = $liquidacion->getTotalimponible();
        $creditosccaf = 0;
        $descuentodental = 0;
        $descuentoleasing = 0;
        $descuentoseguro = 0;
        $otrosdescuentosccaf = 0;
        $cotizacionccaf = 0;
        $descuentocargasccaf = 0;
        $otrosdescuentosccaf1 = 0;
        $otrosdescuentosccaf2 = 0;
        $bonosgobiernoccaf = 0;
        $codsucursal = "00";
        $codmutual = "00";
        if($mutual!=null){
            $codmutual = $mutual->getCodigoPrevired();
        }
        $rentaimponiblemutual = $liquidacion->getTotalimponible();
        $cotizacionaccidentemutual = round($aportepatronal->getSeguroaccidentes(), 0);
        $sucursalpago = "0";
        $rentaimponiblecesantia = $liquidacion->getTotalimponible();
        $aportetrabajadorcesantia = 0;
        foreach($detalleliquidacion as $detalle){
            if($detalle->getCodigo()=="CESANTIA"){
                $aportetrabajadorcesantia = $detalle->getMonto();
            }
        }
        $aporteempleadorcesantia = $aportepatronal->getCesantiaempleador();
        $rutpagador = "";
        $dvpagador = "";
        $centrocostos = $contrato->getCentrocosto();

        //Ingresas la linea Principal
        $spreadsheet->getActiveSheet()->setCellValue('A' . $pos, $rut);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $pos, $dv);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $pos, $ape_paterno);
        $spreadsheet->getActiveSheet()->setCellValue('D' . $pos, $ape_materno);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $pos, $nombres);
        $spreadsheet->getActiveSheet()->setCellValue('F' . $pos, $sexo);
        $spreadsheet->getActiveSheet()->setCellValue('G' . $pos, $nacionalidad);
        $spreadsheet->getActiveSheet()->setCellValue('H' . $pos, $tipo_pago);
        $spreadsheet->getActiveSheet()->setCellValue('I' . $pos, $periododesde);
        $spreadsheet->getActiveSheet()->setCellValue('J' . $pos, $periodohasta);
        $spreadsheet->getActiveSheet()->setCellValue('K' . $pos, $regimenprevisional);
        $spreadsheet->getActiveSheet()->setCellValue('L' . $pos, $tipotrabajador);
        $spreadsheet->getActiveSheet()->setCellValue('M' . $pos, $diastrabajados);
        $spreadsheet->getActiveSheet()->setCellValue('N' . $pos, $tipolinea);
        $spreadsheet->getActiveSheet()->setCellValue('O' . $pos, $codmovi);
        $spreadsheet->getActiveSheet()->setCellValue('P' . $pos, $fechadesde);
        $spreadsheet->getActiveSheet()->setCellValue('Q' . $pos, $fechahasta);
        $spreadsheet->getActiveSheet()->setCellValue('R' . $pos, $tramoasignacion);
        $spreadsheet->getActiveSheet()->setCellValue('S' . $pos, $cargasimple);
        $spreadsheet->getActiveSheet()->setCellValue('T' . $pos, $cargamaterna);
        $spreadsheet->getActiveSheet()->setCellValue('U' . $pos, $cargainvalida);
        $spreadsheet->getActiveSheet()->setCellValue('V' . $pos, $asignacionfamiliar);
        $spreadsheet->getActiveSheet()->setCellValue('W' . $pos, $asignacionfamiliarretroactiva);
        $spreadsheet->getActiveSheet()->setCellValue('X' . $pos, $reintegrocargas);
        $spreadsheet->getActiveSheet()->setCellValue('Y' . $pos, $subsidiojoven);
        $spreadsheet->getActiveSheet()->setCellValue('Z' . $pos, $codafp);
        $spreadsheet->getActiveSheet()->setCellValue('AA' . $pos, $rentaimponibleafp);
        $spreadsheet->getActiveSheet()->setCellValue('AB' . $pos, $cotizacionobligatoriaafp);
        $spreadsheet->getActiveSheet()->setCellValue('AC' . $pos, $cotizacionsegurosis);
        $spreadsheet->getActiveSheet()->setCellValue('AD' . $pos, $cuentavoluntariaafp);
        $spreadsheet->getActiveSheet()->setCellValue('AE' . $pos, $rentaimponiblesustitutiva);
        $spreadsheet->getActiveSheet()->setCellValue('AF' . $pos, $tasapactada);
        $spreadsheet->getActiveSheet()->setCellValue('AG' . $pos, $aporteindemnizacion);
        $spreadsheet->getActiveSheet()->setCellValue('AH' . $pos, $nperiodosustitutiva);
        $spreadsheet->getActiveSheet()->setCellValue('AI' . $pos, $periododesdesustitutiva);
        $spreadsheet->getActiveSheet()->setCellValue('AJ' . $pos, $periodohastasustitutiva);
        $spreadsheet->getActiveSheet()->setCellValue('AK' . $pos, $puestotrabajopesado);
        $spreadsheet->getActiveSheet()->setCellValue('AL' . $pos, $porcotizaciontrabajopesado);
        $spreadsheet->getActiveSheet()->setCellValue('AM' . $pos, $cotizaciontrabajopesado);
        $spreadsheet->getActiveSheet()->setCellValue('AN' . $pos, $codapvi);
        $spreadsheet->getActiveSheet()->setCellValue('AO' . $pos, $ncontratoapvi);
        $spreadsheet->getActiveSheet()->setCellValue('AP' . $pos, $formapagoapvi);
        $spreadsheet->getActiveSheet()->setCellValue('AQ' . $pos, $cotizacionapvi);
        $spreadsheet->getActiveSheet()->setCellValue('AR' . $pos, $cotizaciondepositos);
        $spreadsheet->getActiveSheet()->setCellValue('AS' . $pos, $codapvc);
        $spreadsheet->getActiveSheet()->setCellValue('AT' . $pos, $ncontratoapvc);
        $spreadsheet->getActiveSheet()->setCellValue('AU' . $pos, $formapagoapvc);
        $spreadsheet->getActiveSheet()->setCellValue('AV' . $pos, $cotizaciontrabajadorapvc);
        $spreadsheet->getActiveSheet()->setCellValue('AW' . $pos, $cotizacionempleadorapvc);
        $spreadsheet->getActiveSheet()->setCellValue('AX' . $pos, $rutafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('AY' . $pos, $dvafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('AZ' . $pos, $apepaternoafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BA' . $pos, $apematernoafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BB' . $pos, $nombresafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BC' . $pos, $codmoviafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BD' . $pos, $fechadesdeafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BE' . $pos, $fechahastaafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BF' . $pos, $codafpafiliado);
        $spreadsheet->getActiveSheet()->setCellValue('BG' . $pos, $montocapitalizacion);
        $spreadsheet->getActiveSheet()->setCellValue('BH' . $pos, $montoahorro);
        $spreadsheet->getActiveSheet()->setCellValue('BI' . $pos, $nperiodoscotizacion);
        $spreadsheet->getActiveSheet()->setCellValue('BJ' . $pos, $codexcaja);
        $spreadsheet->getActiveSheet()->setCellValue('BK' . $pos, $tasacotizacion);
        $spreadsheet->getActiveSheet()->setCellValue('BL' . $pos, $rentaimponiblefonasa);
        $spreadsheet->getActiveSheet()->setCellValue('BM' . $pos, $cotizacionobligatoriaips);
        $spreadsheet->getActiveSheet()->setCellValue('BN' . $pos, $rentaimponibledesahucio);
        $spreadsheet->getActiveSheet()->setCellValue('BO' . $pos, $codexcajadesahucio);
        $spreadsheet->getActiveSheet()->setCellValue('BP' . $pos, $tasacotizaciondesahucio);
        $spreadsheet->getActiveSheet()->setCellValue('BQ' . $pos, $cotizaciondesahucio);
        $spreadsheet->getActiveSheet()->setCellValue('BR' . $pos, $cotizacionfonasa);
        $spreadsheet->getActiveSheet()->setCellValue('BS' . $pos, $cotizacionaccidente);
        $spreadsheet->getActiveSheet()->setCellValue('BT' . $pos, $bonificacionley);
        $spreadsheet->getActiveSheet()->setCellValue('BU' . $pos, $descuentocargas);
        $spreadsheet->getActiveSheet()->setCellValue('BV' . $pos, $bonosgobierno);
        $spreadsheet->getActiveSheet()->setCellValue('BW' . $pos, $instsalud);
        $spreadsheet->getActiveSheet()->setCellValue('BX' . $pos, $numerofun);
        $spreadsheet->getActiveSheet()->setCellValue('BY' . $pos, $rentaimponibleisapre);
        $spreadsheet->getActiveSheet()->setCellValue('BZ' . $pos, $monedapactada);
        $spreadsheet->getActiveSheet()->setCellValue('CA' . $pos, $cotizacionpactada);
        $spreadsheet->getActiveSheet()->setCellValue('CB' . $pos, $cotizacionobligatoriaisapre);
        $spreadsheet->getActiveSheet()->setCellValue('CC' . $pos, $cotizacionadicional);
        $spreadsheet->getActiveSheet()->setCellValue('CD' . $pos, $montoges);
        $spreadsheet->getActiveSheet()->setCellValue('CE' . $pos, $codccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CF' . $pos, $rentaimponibleccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CG' . $pos, $creditosccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CH' . $pos, $descuentodental);
        $spreadsheet->getActiveSheet()->setCellValue('CI' . $pos, $descuentoleasing);
        $spreadsheet->getActiveSheet()->setCellValue('CJ' . $pos, $descuentoseguro);
        $spreadsheet->getActiveSheet()->setCellValue('CK' . $pos, $otrosdescuentosccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CL' . $pos, $cotizacionccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CM' . $pos, $descuentocargasccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CN' . $pos, $otrosdescuentosccaf1);
        $spreadsheet->getActiveSheet()->setCellValue('CO' . $pos, $otrosdescuentosccaf2);
        $spreadsheet->getActiveSheet()->setCellValue('CP' . $pos, $bonosgobiernoccaf);
        $spreadsheet->getActiveSheet()->setCellValue('CQ' . $pos, $codsucursal);
        $spreadsheet->getActiveSheet()->setCellValue('CR' . $pos, $codmutual);
        $spreadsheet->getActiveSheet()->setCellValue('CS' . $pos, $rentaimponiblemutual);
        $spreadsheet->getActiveSheet()->setCellValue('CT' . $pos, $cotizacionaccidentemutual);
        $spreadsheet->getActiveSheet()->setCellValue('CU' . $pos, $sucursalpago);
        $spreadsheet->getActiveSheet()->setCellValue('CV' . $pos, $rentaimponiblecesantia);
        $spreadsheet->getActiveSheet()->setCellValue('CW' . $pos, $aportetrabajadorcesantia);
        $spreadsheet->getActiveSheet()->setCellValue('CX' . $pos, $aporteempleadorcesantia);
        $spreadsheet->getActiveSheet()->setCellValue('CY' . $pos, $rutpagador);
        $spreadsheet->getActiveSheet()->setCellValue('CZ' . $pos, $dvpagador);
        $spreadsheet->getActiveSheet()->setCellValue('DA' . $pos, $centrocostos);
        
        $pos++;
    }
    //Fin del cuerpo del excel
    $fecha = date("dmYHis");
    //Descargar por navegador
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="lreprevired' . $fecha . '.csv"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}
