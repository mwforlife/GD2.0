<?php
ini_set('display_errors', 0);
header('Content-Type: application/json');

require '../controller.php';
$c = new Controller();
session_start();

if (!isset($_SESSION['USER_ID']) || !isset($_SESSION['CURRENT_ENTERPRISE'])) {
    echo json_encode(['success' => false, 'error' => 'Sesion no valida']);
    exit;
}

if (!isset($_POST['trabajadores']) || !isset($_POST['periodo']) || !isset($_POST['gratificacion'])) {
    echo json_encode(['success' => false, 'error' => 'Parametros incompletos']);
    exit;
}

$empresa = $_SESSION['CURRENT_ENTERPRISE'];
$empresa = $c->buscarEmpresa($empresa);

$trabajadores = $_POST['trabajadores'];
$periodo = $_POST['periodo'];
$periodo = $periodo . "-01";
$gratif = $_POST['gratificacion'];

$trabajadores = json_decode($trabajadores);
$resultados = [];
$errores = [];

foreach ($trabajadores as $object) {
    try {
        $id = $object->id;
        $rut = $object->rut;
        $nombre = $object->nombre;
        $contratoid = $object->contrato;
        $contrato = $c->buscarcontratobyID($contratoid);
        $horas = $c->buscarhoraspactadas($contratoid);
        $trabajador = $c->buscartrabajador($id);
        $centrocosto = $c->buscarcentrcosto($contrato->getCentroCosto());
        $prevision = $c->buscarprevisiontrabajador($id);
        $mes = date('m', strtotime($periodo));
        $mes1 = date('m', strtotime($periodo));
        $anio = date('Y', strtotime($periodo));
        $ausencias = $c->cantidadausencias($id, $contratoid, $mes1, $anio);
        $mediodia = $c->cantidadmediodiaausencias($id, $contratoid, $mes1, $anio);
        $licencias = $c->buscarlicencias($id, $periodo, date("Y-m-t", strtotime($periodo)));
        $fechosa = "";
        $fechoter = "";
        $contardias = 0;
        if ($licencias != null) {
            $fechosa = $licencias->getFechainicio();
            $fechoter = $licencias->getFechafin();
            $fechosa = new DateTime($fechosa);
            $fechoter = new DateTime($fechoter);
            $contardias = 0;
            while ($fechosa <= $fechoter) {
                $contardias++;
                $fechosa->modify('+1 day');
            }
        }

        $mesNombre = "";
        switch ($mes) {
            case 1: $mesNombre = "Enero"; break;
            case 2: $mesNombre = "Febrero"; break;
            case 3: $mesNombre = "Marzo"; break;
            case 4: $mesNombre = "Abril"; break;
            case 5: $mesNombre = "Mayo"; break;
            case 6: $mesNombre = "Junio"; break;
            case 7: $mesNombre = "Julio"; break;
            case 8: $mesNombre = "Agosto"; break;
            case 9: $mesNombre = "Septiembre"; break;
            case 10: $mesNombre = "Octubre"; break;
            case 11: $mesNombre = "Noviembre"; break;
            case 12: $mesNombre = "Diciembre"; break;
        }

        // Variables de Haberes y Descuentos
        $valor_haberes = array();
        $valor_descuentos_legales = array();
        $valor_descuentos_no_legales = array();
        $gratificacion = 0;

        // Horas falladas y extras
        $horasfalladas = 0;
        $extra1 = 0;
        $extra2 = 0;
        $extra3 = 0;

        // Totales
        $total_haberes = 0;
        $total_Descuentos = 0;
        $total_imponible = 0;
        $total_no_imponible = 0;
        $total_descuentos_legales = 0;
        $total_descuentos_no_legales = 0;
        $total_tributable = 0;

        // Topes
        $topeafp = $c->topesafp($periodo);
        if ($topeafp == 0) {
            $topeafp = $c->ultimotopeafp();
        }
        $topeips = $c->topesips($periodo);
        if ($topeips == 0) {
            $topeips = $c->ultimotopeips();
        }
        $topecesantiap = $c->topescesantia($periodo);
        if ($topecesantiap == 0) {
            $topecesantiap = $c->ultimotopecesantia();
        }
        $topeapvmensual = $c->topesapvmensual($periodo);
        if ($topeapvmensual == 0) {
            $topeapvmensual = $c->ultimotopeapvmensual();
        }
        $ano = date("Y", strtotime($periodo));
        $topeapvanual = $c->topesapvanual($ano);
        if ($topeapvanual == 0) {
            $topeapvanual = $c->ultimotopeapvanual();
        }

        $sueldo = $contrato->getSueldo();
        $dias = 30 - $ausencias - $mediodia - $contardias;
        $periodoCalc = date($anio . "-" . $mes1 . "-01");
        $haberes = $c->listarhaberes_descuentotrababajador($periodoCalc, $periodoCalc, $empresa->getId(), $trabajador->getId(), 1);

        $sueldo = round(($sueldo / 30 * $dias), 0, PHP_ROUND_HALF_UP);
        $valor_haberes[] = array("codigo" => "SUELDO BASE", "valor" => $sueldo, "tipo" => 1);
        $total_imponible = $total_imponible + $sueldo;
        if ($gratif == 1) {
            $gratificacion = $gratificacion + $sueldo;
        }

        // Haberes
        foreach ($haberes as $haber) {
            if ($haber->getRegistro() == 1) {
                if ($haber->getTipo() == 1) {
                    $habere = $c->buscarhaberesydescuentos($haber->getEmpresa());
                    $formula = $habere->getFormula();
                    $formula = str_replace("{SUELDO_BASE}", $sueldo, $formula);
                    $formula = str_replace("{DIAS_TRABAJADOS}", $dias, $formula);
                    $formula = str_replace("{HORAS_EXTRAS}", $haber->gethoras(), $formula);
                    $formula = str_replace("{VALOR_HORA}", 12000, $formula);
                    $formula = str_replace("{HORAS_TRABAJADAS}", $horas, $formula);

                    if ($haber->getMonto() > 0) {
                        $formula = str_replace("{VALOR_AGREGADO}", $haber->getMonto(), $formula);
                    } else if ($haber->getDias() > 0) {
                        $formula = str_replace("{VALOR_AGREGADO}", $haber->getDias(), $formula);
                    } else {
                        $formula = str_replace("{VALOR_AGREGADO}", $haber->gethoras(), $formula);
                        if ($habere->getId() == 16) {
                            $extra1 = $haber->gethoras();
                        } else if ($habere->getId() == 17) {
                            $extra2 = $haber->gethoras();
                        } else if ($habere->getId() == 18) {
                            $extra3 = $haber->gethoras();
                        }
                    }

                    $formula = str_replace(" ", "", $formula);
                    $resultado = eval("return $formula;");
                    $resultado = round($resultado, 0, PHP_ROUND_HALF_UP);
                    $valor_haberes[] = array("codigo" => $haber->getCodigo(), "valor" => $resultado, "tipo" => 1);
                    $total_imponible = $total_imponible + round($resultado, 0, PHP_ROUND_HALF_UP);
                    if ($gratif == 1) {
                        if ($habere->getGratificacion() == 1) {
                            $gratificacion = $gratificacion + $resultado;
                        }
                    }
                } else {
                    $habere = $c->buscarhaberesydescuentos($haber->getEmpresa());
                    $valor_haberes[] = array("codigo" => $haber->getCodigo(), "valor" => $haber->getMonto(), "tipo" => 1);
                    $total_imponible = $total_imponible + round($haber->getMonto(), 0, PHP_ROUND_HALF_UP);
                    if ($gratif == 1) {
                        if ($habere->getGratificacion() == 1) {
                            $gratificacion = $gratificacion + $haber->getMonto();
                        }
                    }
                }
            }
        }

        if ($gratif == 1) {
            $gratificacion = $gratificacion * 0.25;
            $valor_haberes[] = array("codigo" => "GRATIFICACION", "valor" => $gratificacion, "tipo" => 1);
            $total_imponible = $total_imponible + round($gratificacion, 0, PHP_ROUND_HALF_UP);
        }

        foreach ($haberes as $haber) {
            if ($haber->getRegistro() == 2) {
                if ($haber->getTipo() == 1) {
                    $habere = $c->buscarhaberesydescuentos($haber->getEmpresa());
                    $formula = $habere->getFormula();
                    $formula = str_replace("{SUELDO_BASE}", $sueldo, $formula);
                    $formula = str_replace("{DIAS_TRABAJADOS}", $dias, $formula);
                    $formula = str_replace("{HORAS_EXTRAS}", $haber->gethoras(), $formula);
                    $formula = str_replace("{VALOR_HORA}", 12000, $formula);
                    $formula = str_replace("{HORAS_TRABAJADAS}", $horas, $formula);

                    if ($haber->getMonto() > 0) {
                        $formula = str_replace("{VALOR_AGREGADO}", $haber->getMonto(), $formula);
                    } else if ($haber->getDias() > 0) {
                        $formula = str_replace("{VALOR_AGREGADO}", $haber->getDias(), $formula);
                    } else if ($haber->getHoras() > 0) {
                        $formula = str_replace("{VALOR_AGREGADO}", $haber->gethoras(), $formula);
                    }
                    $formula = str_replace(" ", "", $formula);
                    $resultado = eval("return $formula;");
                    $resultado = round($resultado, 0, PHP_ROUND_HALF_UP);
                    $valor_haberes[] = array("codigo" => $haber->getCodigo(), "valor" => $resultado, "tipo" => 2);
                    $total_no_imponible = intval($total_no_imponible) + intval($resultado);
                } else {
                    $valor_haberes[] = array("codigo" => $haber->getCodigo(), "valor" => $haber->getMonto(), "tipo" => 2);
                    $total_no_imponible = intval($total_no_imponible) + intval($haber->getMonto());
                }
            }
        }

        // Descuentos - Prevision
        $afp = $c->buscarafp($prevision->getAfp());
        $tasa = $c->buscartasaafp($afp->getId(), $mes1, $anio);
        if ($tasa == null) {
            $tasa = $c->buscarultimatasaafp($afp->getId());
        }

        $dessis = $total_imponible * ($tasa->getInstitucion() / 100);
        $prevision_des = $total_imponible * ($tasa->getTasa() / 100);
        $uf = $c->buscaruf($periodo);
        if($uf==false){
            $uf = $c->ultimavaloruf();
            if($uf==false){
                $uf = 0;
            }else{
                $uf = $uf->getTasa();
            }
        }else{
            $uf = $uf->getTasa();
        }

        if($uf>0){
            $topeafp = $topeafp * $uf;
        }

        if($topeafp>0){
            if($prevision_des>$topeafp){
                $prevision_des = $topeafp;
            }
        }
        $valor_descuentos_legales[] = array("codigo" => "PREVISION", "valor" => ($prevision_des + $dessis), "tipo" => 1);
        $total_descuentos_legales = $total_descuentos_legales + $prevision_des;

        // Salud
        $isapre = $c->buscarisapre($prevision->getIsapre());
        $desc_salud = "0%";
        if ($isapre->getTipo() == 1) {
            $desc_salud = "7%";
        }

        $formuladescuentsalud = $total_imponible . "*" . $desc_salud;
        $formuladescuentsalud = str_replace("%", "/100", $formuladescuentsalud);
        $salud_des = eval("return $formuladescuentsalud;");
        $valor_descuentos_legales[] = array("codigo" => "SALUD", "valor" => $salud_des, "tipo" => 1);
        $total_descuentos_legales = $total_descuentos_legales + $salud_des;

        // Cesantia
        $cesantia_des = 0;
        if ($contrato->getTipocontrato() == "Contrato Indefinido") {
            $cesantia_des = $total_imponible * 0.006;
            if($uf>0){
                $topecesantiap = $topecesantiap * $uf;
            }
            if($topecesantiap>0){
                if($cesantia_des>$topecesantiap){
                    $cesantia_des = $topecesantiap;
                }
            }
            $valor_descuentos_legales[] = array("codigo" => "CESANTIA", "valor" => $cesantia_des, "tipo" => 1);
            $total_descuentos_legales = $total_descuentos_legales + $cesantia_des;
        }

        $total_tributable = $total_imponible - $prevision_des - $salud_des - $cesantia_des;

        // Otros descuentos
        $descuentos = $c->listarhaberes_descuentotrababajador($periodoCalc, $periodoCalc, $empresa->getId(), $trabajador->getId(), 2);
        foreach ($descuentos as $haber) {
            $habere = $c->buscarhaberesydescuentos($haber->getEmpresa());
            if ($haber->getTipo() == 1) {
                $formula = $habere->getFormula();
                $formula = str_replace("{SUELDO_BASE}", $sueldo, $formula);
                $formula = str_replace("{DIAS_TRABAJADOS}", $dias, $formula);
                $formula = str_replace("{HORAS_EXTRAS}", $haber->gethoras(), $formula);
                $formula = str_replace("{VALOR_HORA}", 12000, $formula);
                $formula = str_replace("{TOTAL_IMPONIBLE}", $total_imponible, $formula);
                $formula = str_replace("{HORAS_TRABAJADAS}", $horas, $formula);
                $formula = str_replace("{AFP}", 0, $formula);
                $formula = str_replace("{SALUD}", 0, $formula);
                $formula = str_replace("{CESANTIA}", 0, $formula);

                if ($haber->getMonto() > 0) {
                    $formula = str_replace("{VALOR_AGREGADO}", $haber->getMonto(), $formula);
                } else if ($haber->getDias() > 0) {
                    $formula = str_replace("{VALOR_AGREGADO}", $haber->getDias(), $formula);
                } else if ($haber->getHoras() > 0) {
                    $formula = str_replace("{VALOR_AGREGADO}", $haber->gethoras(), $formula);
                    if ($habere->getId() == 19 || $habere->getId() == 20) {
                        $horasfalladas = $horasfalladas + $haber->gethoras();
                    }
                }
                $formula = str_replace(" ", "", $formula);
                $formula = str_replace("%", "/100", $formula);
                $resultado = eval("return $formula;");
                $resultado = round($resultado, 0, PHP_ROUND_HALF_UP);
                if ($habere->getReservado() == 1) {
                    $valor_descuentos_legales[] = array("codigo" => $haber->getCodigo(), "valor" => $resultado, "tipo" => 1);
                    $total_descuentos_legales = $total_descuentos_legales + $resultado;
                } else {
                    $valor_descuentos_no_legales[] = array("codigo" => $haber->getCodigo(), "valor" => $resultado, "tipo" => 2);
                    $total_descuentos_no_legales = $total_descuentos_no_legales + $resultado;
                }
            } else {
                if ($habere->getReservado() == 1) {
                    $valor_descuentos_legales[] = array("codigo" => $haber->getCodigo(), "valor" => $haber->getMonto(), "tipo" => 1);
                    $total_descuentos_legales = $total_descuentos_legales + intval($haber->getMonto());
                } else {
                    $valor_descuentos_no_legales[] = array("codigo" => $haber->getCodigo(), "valor" => $haber->getMonto(), "tipo" => 2);
                    $total_descuentos_no_legales = $total_descuentos_no_legales + intval($haber->getMonto());
                }
            }
        }

        // Aporte empleador
        $cesantia_empleador = 0;
        if ($contrato->getTipocontrato() == "Contrato Indefinido" || $contrato->getTipocontrato() == 1) {
            $cesantia_empleador = $total_imponible * 0.024;
        }
        if ($contrato->getTipocontrato() == "Contrato a Plazo Fijo" || $contrato->getTipocontrato() == "Obra o Faena" || $contrato->getTipocontrato() == 2 || $contrato->getTipocontrato() == 3) {
            $cesantia_empleador = $total_imponible * 0.03;
        }

        $tasaadicional = $empresa->getCotizacionAdicional();
        $tasamutual = $c->buscartasamutual($periodo);
        $tasabasica = 0.90;
        if($tasamutual!=null){
            $tasabasica = $tasamutual->getFecha();
            $tasamutual = $tasamutual->getTasa();
        }else{
            $tasa = $c->buscarultimatasamutual();
            if($tasa!=null){
                $tasabasica = $tasa->getFecha();
                $tasamutual = $tasa->getTasa();
            }else{
                $tasamutual = 0.03;
            }
        }
        $seguro_accidente = 0;
        $cotizacionbasica = $total_imponible * ($tasabasica / 100);
        $cotizacionleysanna = 0;

        if($contardias>0){
            $cotizacionleysanna = ((($total_imponible / 30)*$contardias) * ($tasamutual / 100) + ($total_imponible * ($tasamutual / 100)));
        }else{
            $cotizacionleysanna = $total_imponible * ($tasamutual / 100);
        }
        $cotizacionadicion = $total_imponible * ($tasaadicional / 100);
        $seguro_accidente = ($cotizacionbasica + $cotizacionleysanna + $cotizacionadicion);

        // Calcular liquido
        $liquido = $total_imponible + $total_no_imponible - $total_descuentos_legales - $total_descuentos_no_legales;
        $cargas = $c->listarcargas($trabajador->getId());

        // Validar si ya existe liquidacion
        $valid = $c->validarliquidacion($periodo, $contrato->getId(), $empresa->getId());
        $yaExiste = false;
        $idliquidacion = 0;

        if ($valid == false) {
            $ultimofolio = $c->ultimofolioliquidacion($empresa->getId()) + 1;
            $idliquidacion = $c->registrarliquidacion($ultimofolio, $contrato->getId(), $periodo, $empresa->getId(), $trabajador->getId(), $dias, $sueldo, $horasfalladas, $extra1, $extra2, $extra3, $afp->getNombre(), $tasa->getTasa(), $tasa->getInstitucion(), $isapre->getNombre(), $desc_salud, $prevision_des, $dessis, $salud_des, $gratificacion, $total_imponible, $total_no_imponible, $total_tributable, $total_descuentos_legales, $total_descuentos_no_legales, date("Y-m-d"));
            foreach ($valor_haberes as $haber) {
                if ($haber['tipo'] == 1) {
                    $c->registrardetalleliquidacion($idliquidacion, $haber['codigo'], $haber['valor'], 1);
                } else {
                    $c->registrardetalleliquidacion($idliquidacion, $haber['codigo'], $haber['valor'], 2);
                }
            }
            $sql = "insert into aporteempleador values(null,$idliquidacion,$cesantia_empleador,$cotizacionbasica,$cotizacionleysanna,$cotizacionadicion,$seguro_accidente,now());";
            $c->query($sql);
            foreach ($valor_descuentos_legales as $descuento) {
                $c->registrardetalleliquidacion($idliquidacion, $descuento['codigo'], $descuento['valor'], 3);
            }
            foreach ($valor_descuentos_no_legales as $descuento) {
                $c->registrardetalleliquidacion($idliquidacion, $descuento['codigo'], $descuento['valor'], 4);
            }
        } else {
            $yaExiste = true;
            $idliquidacion = $valid;
        }

        $resultados[] = [
            'id' => $id,
            'liquidacion_id' => $idliquidacion,
            'rut' => $rut,
            'nombre' => $nombre,
            'centro_costo' => $centrocosto->getNombre(),
            'periodo' => $mesNombre . " " . $anio,
            'dias' => $dias,
            'horas_extras' => $extra1 + $extra2 + $extra3,
            'horas_falladas' => $horasfalladas,
            'cargas' => count($cargas),
            'afp' => $afp->getNombre(),
            'afp_tasa' => $tasa->getTasa(),
            'isapre' => $isapre->getNombre(),
            'desc_salud' => $desc_salud,
            'haberes' => $valor_haberes,
            'descuentos_legales' => $valor_descuentos_legales,
            'descuentos_no_legales' => $valor_descuentos_no_legales,
            'total_imponible' => $total_imponible,
            'total_no_imponible' => $total_no_imponible,
            'total_tributable' => $total_tributable,
            'total_descuentos_legales' => $total_descuentos_legales,
            'total_descuentos_no_legales' => $total_descuentos_no_legales,
            'liquido' => $liquido,
            'ya_existe' => $yaExiste,
            'fecha' => date("d/m/Y")
        ];
    } catch (Exception $e) {
        $errores[] = [
            'trabajador' => $nombre ?? 'Desconocido',
            'error' => $e->getMessage()
        ];
    }
}

echo json_encode([
    'success' => true,
    'empresa' => [
        'razon_social' => $empresa->getRazonSocial(),
        'rut' => $empresa->getRut()
    ],
    'liquidaciones' => $resultados,
    'errores' => $errores,
    'total_procesados' => count($resultados),
    'total_errores' => count($errores)
]);
