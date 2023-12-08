<?php
require '../controller.php';
$c = new Controller();
require '../plugins/vendor/autoload.php';
//phpspreadsheet for CSV
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

session_start();
if (!isset($_SESSION['CURRENT_ENTERPRISE'])) {
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
    $pos = 1;
    if (strlen($periodo) < 7) {
        echo "Periodo invalido<br>";
        echo "<div style='color:red'>El periodo debe tener 7 caracteres</div>";
        return;
    }
    $periodo = $periodo . "-01";
    $mesperiodo = date("m", strtotime($periodo));

    $liquidaciones = $c->listartodasliquidacionesperiodo($periodo);
    $empresa = $c->buscarEmpresa1($empresa);
    $cajacompensacion = $c->buscarcaja($empresa->getCajasCompensacion());
    $mutual = $c->buscarmutual($empresa->getMutuales());
    foreach ($liquidaciones as $liquidacion) {
        $trabajador = $c->buscartrabajador($liquidacion->getTrabajador());
        $detalleliquidacion = $c->buscardetallesliquidacion($liquidacion->getId());
        $aportepatronal = $c->buscaraportempleador($liquidacion->getId());
        $prevision  = $c->buscarprevisiontrabajador($liquidacion->getTrabajador());
        $movimientos = $c->buscarmovimientoxtrabajador1($liquidacion->getTrabajador(), $periodo);
        $contrato = $c->buscarultimocontratoactivo($liquidacion->getTrabajador());
        $afp = null;
        if ($prevision != null) {
            $afp = $c->buscarafp($prevision->getAfp());
        }

        //Gestion de datos y valores
        $ruttrabajador = $trabajador->getRut();

        //Dividir el RUN en número de indentificación y dígito verificador
        $posicionGuion = strpos($ruttrabajador, "-");
        $numeroIdentificacion = substr($ruttrabajador, 0, $posicionGuion);
        $digitoVerificador = substr($ruttrabajador, $posicionGuion + 1);

        $rut = $numeroIdentificacion;
        $rut = str_replace(".", "", $rut);
        $dv = $digitoVerificador;

        $ape_paterno = $trabajador->getApellido1();
        $ape_materno = $trabajador->getApellido2();
        $nombres = $trabajador->getNombre();
        $sexo = $trabajador->getSexo();
        if($sexo == 1){
            $sexo = "M";
        }else{
            $sexo = "F";
        }
        $nacionalidad = $trabajador->getNacionalidad();
        $nacionalidad = $c->buscarnacionalidad($nacionalidad);
        if ($nacionalidad != null) {
            $nacionalidad = $nacionalidad->getCodigoPrevired();
        } else {
            $nacionalidad = "00";
        }
        $tipo_pago = "01";
        $mesperiodo = date("m", strtotime($periodo));
        $anioperiodo = date("Y", strtotime($periodo));
        $mesperiodo = intval($mesperiodo);
        $periododesde = $mesperiodo . $anioperiodo;
        $periodohasta = $mesperiodo . $anioperiodo;
        $regimenprevisional = "AFP";
        if ($afp != null) {
            if ($afp->getCodigoPrevired() > 0) {
                $regimenprevisional = "AFP";
            } else {
                $regimenprevisional = "SIP";
            }
        } else {
            $regimenprevisional = "SIP";
        }
        $tipotrabajador = "01";
        $tipotrabajador = 0;
        if ($trabajador->getPension() == 1) {
            $tipotrabajador = 1;
        } else {
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
        $tramoasignacion = "D";
        $cargasimple = 0;
        $cargamaterna = 0;
        $cargainvalida = 0;
        $asignacionfamiliar = 0;
        $asignacionfamiliarretroactiva = 0;
        $reintegrocargas = 0;
        $subsidiojoven = "N";
        $codafp = "00";
        if ($regimenprevisional == "AFP") {
            if ($afp != null) {
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
        $formapagoapvi = 0;
        $cotizacionapvi = 0;
        $cotizaciondepositos = 0;
        $codapvc = "00";
        $ncontratoapvc = "";
        $formapagoapvc = 0;
        $cotizaciontrabajadorapvc = 0;
        $cotizacionempleadorapvc = 0;
        $rutafiliado = 0;
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
        $instsalud = "00";
        if ($prevision != null) {
            $instsalud = $c->buscarisapre($prevision->getIsapre());
            if ($instsalud != null) {
                $instsalud = $instsalud->getCodigoPrevired();
            }
        }
        $numerofun = 0;
        $rentaimponibleisapre = 0;
        $monedapactada = "00";
        $cotizacionpactada = 0;
        $cotizacionobligatoriaisapre = 0;
        $cotizacionadicional = 0;
        $montoges = 0;
        $codccaf = "00";
        if ($cajacompensacion != null) {
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
        $codsucursal = "";
        $codmutual = "00";
        if ($mutual != null) {
            $codmutual = $mutual->getCodigoPrevired();
        }
        $rentaimponiblemutual = $liquidacion->getTotalimponible();
        $cotizacionaccidentemutual = round($aportepatronal->getSeguroaccidentes(), 0);
        $sucursalpago = "0";
        $rentaimponiblecesantia = $liquidacion->getTotalimponible();
        $aportetrabajadorcesantia = 0;
        foreach ($detalleliquidacion as $detalle) {
            if ($detalle->getCodigo() == "CESANTIA") {
                $aportetrabajadorcesantia = $detalle->getMonto();
            }
        }
        $aporteempleadorcesantia = $aportepatronal->getCesantiaempleador();
        $rutpagador = "";
        $dvpagador = "";
        $centrocostos = $contrato->getCentrocosto();

        //Ingresas la linea Principal
        //Que las columnas A sea numerica
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
        $spreadsheet->getActiveSheet()->setCellValue('CW' . $pos, round($aportetrabajadorcesantia, 0));
        $spreadsheet->getActiveSheet()->setCellValue('CX' . $pos, round($aporteempleadorcesantia, 0));
        $spreadsheet->getActiveSheet()->setCellValue('CY' . $pos, $rutpagador);
        $spreadsheet->getActiveSheet()->setCellValue('CZ' . $pos, $dvpagador);
        $spreadsheet->getActiveSheet()->setCellValue('DA' . $pos, $centrocostos);
        //Ingresas las lineas de movimientos
        foreach ($movimientos as $movimiento) {
            $pos++;
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
            $spreadsheet->getActiveSheet()->setCellValue('N' . $pos, "01");
            $spreadsheet->getActiveSheet()->setCellValue('O' . $pos, $movimiento->getEvento());
            if($movimiento->getEvento() == 2){
                $spreadsheet->getActiveSheet()->setCellValue('P' . $pos, $contrato->getFechainicio());
                $spreadsheet->getActiveSheet()->setCellValue('Q' . $pos, $movimiento->getFechainicio());
            }else{
            $spreadsheet->getActiveSheet()->setCellValue('P' . $pos, $movimiento->getFechainicio());
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $pos, $movimiento->getFechatermino());
            }
            $spreadsheet->getActiveSheet()->setCellValue('R' . $pos, "D");
            $spreadsheet->getActiveSheet()->setCellValue('S' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('T' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('U' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('V' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('W' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('X' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('Y' . $pos, $subsidiojoven);
            $spreadsheet->getActiveSheet()->setCellValue('Z' . $pos, $codafp);
            $spreadsheet->getActiveSheet()->setCellValue('AA' . $pos, $rentaimponibleafp);
            $spreadsheet->getActiveSheet()->setCellValue('AB' . $pos, $cotizacionobligatoriaafp);
            $spreadsheet->getActiveSheet()->setCellValue('AC' . $pos, $cotizacionsegurosis);
            $spreadsheet->getActiveSheet()->setCellValue('AD' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('AE' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('AF' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('AG' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('AH' . $pos, "00");
            $spreadsheet->getActiveSheet()->setCellValue('AI' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('AJ' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('AK' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('AL' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('AM' . $pos, 0);
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
            $spreadsheet->getActiveSheet()->setCellValue('AX' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('AY' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('AZ' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('BA' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('BB' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('BC' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BD' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('BE' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('BF' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BG' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BH' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BI' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BJ' . $pos, $codexcaja);
            $spreadsheet->getActiveSheet()->setCellValue('BK' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BL' . $pos, $rentaimponiblefonasa);
            $spreadsheet->getActiveSheet()->setCellValue('BM' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BN' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BO' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BP' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BQ' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BR' . $pos, $cotizacionfonasa);
            $spreadsheet->getActiveSheet()->setCellValue('BS' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BT' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BU' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BV' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('BW' . $pos, $instsalud);
            $spreadsheet->getActiveSheet()->setCellValue('BX' . $pos, $numerofun);
            $spreadsheet->getActiveSheet()->setCellValue('BY' . $pos, $rentaimponibleisapre);
            $spreadsheet->getActiveSheet()->setCellValue('BZ' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CA' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CB' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CC' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CD' . $pos, $montoges);
            $spreadsheet->getActiveSheet()->setCellValue('CE' . $pos, $codccaf);
            $spreadsheet->getActiveSheet()->setCellValue('CF' . $pos, $rentaimponibleccaf);
            $spreadsheet->getActiveSheet()->setCellValue('CG' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CH' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CI' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CJ' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CK' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CL' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CM' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CN' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CO' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CP' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CQ' . $pos, "");
            $spreadsheet->getActiveSheet()->setCellValue('CR' . $pos, $codmutual);
            $spreadsheet->getActiveSheet()->setCellValue('CS' . $pos, $rentaimponiblemutual);
            $spreadsheet->getActiveSheet()->setCellValue('CT' . $pos, $cotizacionaccidentemutual);
            $spreadsheet->getActiveSheet()->setCellValue('CU' . $pos, $sucursalpago);
            $spreadsheet->getActiveSheet()->setCellValue('CV' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CW' . $pos, 0);
            $spreadsheet->getActiveSheet()->setCellValue('CX' . $pos, 0);

            $rutpagador = "";
            $dvpagador = "";
            if ($movimiento->getEvento() == 3) {
                $runCompleto = $movimiento->getRutentidad();
                // Dividir el RUN en número de identificación y dígito verificador
                $posicionGuion = strpos($runCompleto, '-');
                $numeroIdentificacion = substr($runCompleto, 0, $posicionGuion);
                $digitoVerificador = substr($runCompleto, $posicionGuion + 1);

                $rutpagador = $numeroIdentificacion;
                $dvpagador = $digitoVerificador;
            } else {
                $rutpagador = 0;
                $dvpagador = "";
            }
            $spreadsheet->getActiveSheet()->setCellValue('CY' . $pos, $rutpagador);
            $spreadsheet->getActiveSheet()->setCellValue('CZ' . $pos, $dvpagador);
            $spreadsheet->getActiveSheet()->setCellValue('DA' . $pos, $centrocostos);
        }

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
