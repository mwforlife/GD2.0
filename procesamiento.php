<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon" />

    <!-- Title -->
    <title>Gestor de Documentos | Procesamiento Liquidaciones</title>

    <!-- Bootstrap css-->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Icons css-->
    <link href="assets/css/icons.css" rel="stylesheet" />
    <link href="assets/css/toastify.min.css" rel="stylesheet" />

    <!-- Style css-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/dark-boxed.css" rel="stylesheet">
    <link href="assets/css/boxed.css" rel="stylesheet">
    <link href="assets/css/skins.css" rel="stylesheet">
    <link href="assets/css/dark-style.css" rel="stylesheet">

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/css/colors/color.css">

    <!-- Select2 css -->
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Internal DataTables css-->
    <link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

    <!-- Sidemenu css-->
    <link href="assets/css/sidemenu/sidemenu.css" rel="stylesheet">

    <link rel="stylesheet" href="JsFunctions/Alert/loader.css">
    <script src="JsFunctions/Alert/loader.js"></script>

</head>

<body class="main-body container">

    <?php
    require 'php/controller.php';
    $c = new Controller();
    session_start();
    $empresa = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($empresa);

    if (isset($_GET['trabajadores']) && isset($_GET['periodo']) && isset($_GET['gratificacion'])) {
        //recibimos el array de trabajadores
        $trabajadores = $_GET['trabajadores'];
        $arrayfinal = $_GET['trabajadores'];
        $periodo = $_GET['periodo'];
        $periodo = $periodo . "-01";
        $gratif = $_GET['gratificacion'];
        //recorremos el array
        $trabajadores = json_decode($trabajadores);
        foreach ($trabajadores as $object) {
            //obtenemos el trabajador
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
    ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center">LIQUIDACION DE SUELDO</h5>
                            <h6>Remuneraciones Mes de:
                                <?php echo $mes . " " . $anio; ?>
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Razon Social:<br />
                                        <?php echo $empresa->getRazonSocial(); ?>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>Rut:<br />
                                        <?php echo $empresa->getRut(); ?>
                                    </h6>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>Rut:<br />
                                        <?php echo $trabajador->getRut(); ?>
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>Trabajador:<br />
                                        <?php echo $trabajador->getNombre() . " " . $trabajador->getApellido1() . " " . $trabajador->getApellido2(); ?>
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>Centro de Costo:<br />
                                        <?php echo $centrocosto->getNombre(); ?>
                                    </h6>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>AFP</h6>
                                    <p>
                                        <?php
                                        $afp = $c->buscarafp($prevision->getAfp());
                                        echo $afp->getNombre() . "<br/> ";
                                        $tasa = $c->buscartasaafp($afp->getId(), $mes1, $anio);
                                        if ($tasa == null) {
                                            $tasa = $c->buscarultimatasaafp($afp->getId());
                                            if ($tasa == null) {
                                                echo 0;
                                            } else {
                                                echo $tasa->getTasa() . "%";
                                            }
                                        } else {
                                            echo $tasa->getTasa() . "%";
                                        }
                                        ?>
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <h6>Isapre</h6>
                                    <p>
                                        <?php
                                        $desc_salud = "0%";
                                        $isapre = $c->buscarisapre($prevision->getIsapre());
                                        echo $isapre->getNombre() . " <br/>";
                                        if ($isapre->getTipo() == 1) {
                                            $desc_salud = "7%";
                                        } else {
                                            $tipomodena = $prevision->getMonedapacto();
                                            $monto = $prevision->getMonto();
                                            $tipoges = $prevision->getTipoges();
                                            $montoges = $prevision->getGes();
                                            $desc_salud = "0%";
                                        }
                                        echo $desc_salud;
                                        ?>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php

                    //********************************************Definicion de variables************************************************************ */
                    $valor_haberes = array();
                    $valor_descuentos_legales = array();
                    $valor_descuentos_no_legales = array();
                    $gratificacion = 0;

                    $horasfalladas =0;
                    $extra1 = 0;
                    $extra2 = 0;
                    $extra3 = 0;

                    $total_haberes = 0;
                    $total_Descuentos = 0;
                    $total_imponible = 0;
                    $total_no_imponible = 0;
                    $total_descuentos_legales = 0;
                    $total_descuentos_no_legales = 0;
                    $total_tributable = 0;

                    $sueldo = $contrato->getSueldo();
                    $dias = 30 - $ausencias - $mediodia - $contardias;
                    $periodo = date($anio . "-" . $mes1 . "-01");
                    $haberes = $c->listarhaberes_descuentotrababajador($periodo, $periodo, $empresa->getId(), $trabajador->getId(), 1);

                    $sueldo = $sueldo / 30 * $dias;
                    $valor_haberes[] = array("codigo" => "SUELDO BASE", "valor" => $sueldo, "tipo" => 1);
                    $total_imponible = $total_imponible + $sueldo;
                    if($gratif==1){
                     $gratificacion = $gratificacion + $sueldo;
                    }
                    //********************************************Fin Definicion de Variables************************************************************ */

                    //********************************************Haberes************************************************************ */

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

                                if ($haber->getMonto()>0) {
                                    $formula = str_replace("{VALOR_AGREGADO}", $haber->getMonto(), $formula);
                                } else if ($haber->getDias()>0) {
                                    $formula = str_replace("{VALOR_AGREGADO}", $haber->getDias(), $formula);
                                } else {
                                    $formula = str_replace("{VALOR_AGREGADO}", $haber->gethoras(), $formula);
                                    if($habere->getId()==16){
                                        $extra1 = $haber->gethoras();
                                    }else if($habere->getId()==17){
                                        $extra2 = $haber->gethoras();
                                    }else if($habere->getId()==18){
                                        $extra3 = $haber->gethoras();
                                    }
                                }

                                //EVALUAMOS LA FORMULA
                                $formula = str_replace(" ", "", $formula);
                                $resultado = eval("return $formula;");
                                $resultado = round($resultado, 0, PHP_ROUND_HALF_UP);
                                $valor_haberes[] = array("codigo" => $haber->getCodigo(), "valor" => $resultado, "tipo" => 1);
                                $total_imponible = $total_imponible + $resultado;
                                if($gratif==1){
                                    if($habere->getGratificacion()==1){
                                        $gratificacion = $gratificacion + $resultado;
                                    }
                                }
                            } else {
                                $habere = $c->buscarhaberesydescuentos($haber->getEmpresa());
                                $valor_haberes[] = array("codigo" => $haber->getCodigo(), "valor" => $haber->getMonto(), "tipo" => 1);
                                $total_imponible = $total_imponible + $haber->getMonto();
                                if($gratif==1){
                                    if($habere->getGratificacion()==1){
                                        $gratificacion = $gratificacion + $haber->getMonto();
                                    }
                                }

                            }
                        }
                    }

                    if($gratif==1){
                        $gratificacion = $gratificacion * 0.25;
                        $valor_haberes[] = array("codigo" => "GRATIFICACION", "valor" => $gratificacion, "tipo" => 1);
                        $total_imponible = $total_imponible + $gratificacion;
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
                                //EVALUAMOS LA FORMULA
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
                    //********************************************Fin Haberes************************************************************ */


                    //********************************************Descuentos************************************************************ */
                    //Prevision
                    $dessis = $total_imponible * ($tasa->getInstitucion() / 100);
                    $prevision_des = $total_imponible * ($tasa->getTasa() / 100);
                    $valor_descuentos_legales[] = array("codigo" => "PREVISION", "valor" => ($prevision_des + $dessis), "tipo" => 1);
                    $total_descuentos_legales = $total_descuentos_legales + $prevision_des;

                    //Salud
                    $formuladescuentsalud = $total_imponible . "*" . $desc_salud;

                    $formuladescuentsalud = str_replace("%", "/100", $formuladescuentsalud);
                    $salud_des = eval("return $formuladescuentsalud;");
                    $valor_descuentos_legales[] = array("codigo" => "SALUD", "valor" => $salud_des, "tipo" => 1);
                    $total_descuentos_legales = $total_descuentos_legales + $salud_des;

                    //Indefinido
                    $cesantia_des = 0;
                    if ($contrato->getTipocontrato() == "Contrato Indefinido") {
                        $cesantia_des = $total_imponible * 0.006;
                        $valor_descuentos_legales[] = array("codigo" => "CESANTIA", "valor" => $cesantia_des, "tipo" => 1);
                        $total_descuentos_legales = $total_descuentos_legales + $cesantia_des;
                    }

                    $total_tributable = $total_imponible - $prevision_des - $salud_des - $cesantia_des;

                    $descuentos = $c->listarhaberes_descuentotrababajador($periodo, $periodo, $empresa->getId(), $trabajador->getId(), 2);
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
                                if($habere->getId()==19 || $habere->getId()==20){
                                    $horasfalladas= $horasfalladas + $haber->gethoras();
                                }
                            }
                            //EVALUAMOS LA FORMULA
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
                    //********************************************Fin Descuentos************************************************************ */
                    ?>


                    <div class="row">
                        <div class="col-md-12">
                            <table class="table w-100">
                                <tr>
                                    <th>Dias</th>
                                    <th>HH Extras</th>
                                    <th>HH Faltadas</th>
                                    <th>Cargas</th>
                                    <th>Imponible</th>
                                    <th>Tributable</th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        echo $dias;

                                        ?>
                                    </td>
                                    <td>
                                        
                                    <?php
                                        echo $extra1 + $extra2 + $extra3;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $horasfalladas;?>
                                    </td>
                                    <td>
                                        <?php
                                        $cargas = $c->listarcargas($trabajador->getId());
                                        echo count($cargas);
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo " $" . number_format($total_imponible, 0, ',', '.'); ?>
                                    </td>
                                    <td>
                                        <?php echo " $" . number_format($total_tributable, 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-center">HABERES</h5>
                                    <table class="table">
                                        <?php
                                        foreach ($valor_haberes as $haber) {
                                            if ($haber['tipo'] == 1) {
                                                echo "<tr>";
                                                echo "<td>" . $haber['codigo'] . "</td>";
                                                //Imprimir el valor con separador de miles y sin decimales
                                                echo "<td> $" . number_format($haber['valor'], 0, ',', '.') . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        echo "<tr>";
                                        echo "<td><h6>Total Imponible</h6></td>";
                                        echo "<td><h6> $" . number_format($total_imponible, 0, ',', '.') . "</h6></td>";
                                        echo "</tr>";
                                        foreach ($valor_haberes as $haber) {
                                            if ($haber['tipo'] == 2) {
                                                echo "<tr>";
                                                echo "<td>" . $haber['codigo'] . "</td>";
                                                echo "<td> $" . number_format($haber['valor'], 0, ',', '.') . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        echo "<tr>";
                                        echo "<td><h6>Total No Imponible</h6></td>";
                                        echo "<td><h6> $" . number_format($total_no_imponible, 0, ',', '.') . "</h6></td>";
                                        echo "</tr>";
                                        ?>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-center">Descuentos</h5>
                                    <table class="table">
                                        <?php
                                        foreach ($valor_descuentos_legales as $descuento) {
                                            if ($descuento['tipo'] == 1) {
                                                echo "<tr>";
                                                echo "<td>" . $descuento['codigo'] . "</td>";
                                                echo "<td> $" . number_format($descuento['valor'], 0, ',', '.') . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        echo "<tr>";
                                        echo "<td><h6>Total Descuentos Legales</h6></td>";
                                        echo "<td><h6> $" . number_format($total_descuentos_legales, 0, ',', '.') . "</h6></td>";
                                        echo "</tr>";
                                        foreach ($valor_descuentos_no_legales as $descuento) {
                                            if ($descuento['tipo'] == 2) {
                                                echo "<tr>";
                                                echo "<td>" . $descuento['codigo'] . "</td>";
                                                echo "<td> $" . number_format($descuento['valor'], 0, ',', '.') . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        echo "<tr>";
                                        echo "<td><h6>Total Descuentos No Legales</h6></td>";
                                        echo "<td><h6> $" . number_format($total_descuentos_no_legales, 0, ',', '.') . "</h6></td>";
                                        echo "</tr>";
                                        ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" style="text-align: start;">
                                <tr>
                                    <td>TOTAL HABERES</td>
                                    <td>
                                        <?php echo " $" . number_format(($total_imponible + $total_no_imponible), 0, ',', '.'); ?>
                                    </td>
                                    <td>TOTAL DESCUENTOS</td>
                                    <td>
                                        <?php echo " $" . number_format(($total_descuentos_legales+$total_descuentos_no_legales), 0, ',', '.'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>FECHA:</td>
                                    <td>
                                        <?php echo date("d/m/Y"); ?>
                                    </td>
                                    <td>LÍQUIDO A PAGAR</td>
                                    <td>
                                        <?php $liquido = $total_imponible + $total_no_imponible - $total_descuentos_legales - $total_descuentos_no_legales;
                                        echo "$" . number_format($liquido, 0, ',', '.'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    $liqudoenletras = $c->convertirNumeroLetras(intval($liquido));
                                    ?>
                                    <td>Son:</td>
                                    <td>
                                        <?php echo $liqudoenletras; ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <?php
                        /****************************************************SENTENCIAS************************************************ */
                        $valid = $c->validarliquidacion($periodo,$contrato->getId(),$empresa->getId());
                        if($valid==false){
                        $ultimofolio = $c->ultimofolioliquidacion($empresa->getId())+1;
                        $idliquidacion = $c->registrarliquidacion($ultimofolio,$contrato->getId(),$periodo,$empresa->getId(),$trabajador->getId(),$dias,$sueldo,$horasfalladas,$extra1,$extra2,$extra3,$afp->getNombre(),$tasa->getTasa(),$tasa->getInstitucion(),$isapre->getNombre(),$desc_salud,$prevision_des,$dessis,$salud_des,$gratificacion,$total_imponible,$total_no_imponible,$total_tributable,$total_descuentos_legales,$total_descuentos_no_legales,date("Y-m-d"));
                        foreach($valor_haberes as $haber){
                            if($haber['tipo']==1){
                            $c->registrardetalleliquidacion($idliquidacion,$haber['codigo'],$haber['valor'],1);
                            }else{
                                $c->registrardetalleliquidacion($idliquidacion,$haber['codigo'],$haber['valor'],2);
                            }
                        }
                        foreach($valor_descuentos_legales as $descuento){
                            $c->registrardetalleliquidacion($idliquidacion,$descuento['codigo'],$descuento['valor'],3);
                        }

                        foreach($valor_descuentos_no_legales as $descuento){
                            $c->registrardetalleliquidacion($idliquidacion,$descuento['codigo'],$descuento['valor'],4);
                        }
                        }else{
                            echo "<div class='alert alert-danger'>Ya se ha generado la liquidacion de este trabajador para este periodo, si desea generarla nuevamente debe eliminar la liquidacion anterior</div>";
                        }

                    ?>
                    <hr>
                </div>
            </div>

    <?php
        }
    }
    ?>

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

    <!-- Jquery js-->
    <script src="assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap js-->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Internal Chart.Bundle js-->
    <script src="assets/plugins/chart.js/Chart.bundle.min.js"></script>

    <!-- Peity js-->
    <script src="assets/plugins/peity/jquery.peity.min.js"></script>

    <!--Internal Apexchart js-->
    <script src="assets/js/apexcharts.js"></script>

    <!-- Internal Data Table js -->
    <script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/table-data.js"></script>
    <script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>


    <!-- Perfect-scrollbar js -->
    <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!-- Select2 js-->
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/select2.js"></script>

    <!-- Sidemenu js -->
    <script src="assets/plugins/sidemenu/sidemenu.js"></script>

    <!-- Sidebar js -->
    <script src="assets/plugins/sidebar/sidebar.js"></script>


    <!-- Sticky js -->
    <script src="assets/js/sticky.js"></script>

    <!-- Custom js -->
    <script src="assets/js/custom.js"></script>
    <script src="JsFunctions/validation.js"></script>
    <script src="JsFunctions/Alert/toastify.js"></script>
    <script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
    <script src="JsFunctions/Alert/alert.js"></script>
    <script src="JsFunctions/main.js"></script>
    <script src="JsFunctions/procesar.js"></script>
    <script src="JsFunctions/precargado.js"></script>

    <script>
        $(document).ready(function() {
            mostrarEmpresa();
        });
    </script>
    <script>
        $(document).ready(function() {
            //Add Datatable
            $('#e2').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ datos/página",
                    "zeroRecords": "No se encontraron resultados en su búsqueda",
                    "searchPlaceholder": "Buscar registros",
                    "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                    "infoEmpty": "No existen registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });


        });
    </script>


</body>

</html>