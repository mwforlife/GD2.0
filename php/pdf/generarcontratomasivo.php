<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: ../../signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: ../../lockscreen.php");
    }
}

if (isset($_POST['idempresa'])  && isset($_POST['tipocontratoid'])) {
    //Informacion Trabajador
    $empresa = $_POST['idempresa'];
    $tipocontrato = $_POST['tipocontratoid'];
    $emp = $c->buscarEmpresavalor($empresa);
    $lista = $c->buscarlote($_SESSION['USER_ID']);
    if (count($lista) == 0) {
        echo "No hay trabajadores seleccionados";
        return;
    }
    $mpdf = new \Mpdf\Mpdf();
    $conteo = 0;
    foreach ($lista as $tra) {
        $dom = $c->ultimodomiciliotexto($tra->getEmpresa());
        $con = $c->ultimocontacto($tra->getEmpresa());
        if ($con == false) {
            echo "El trabajador " . $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2() . " no tiene Información de Contacto registrado";
            return;
        }
        if ($dom == false) {
            echo "El trabajador " . $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2() . " no tiene Domicilio registrado";
            return;
        }
        $prevision = $c->ultimaprevision($tra->getEmpresa());
        if ($prevision == false) {
            echo "El trabajador " . $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2() . " no tiene Información de Previsión registrada";
            return;
        }
        $contenido = $c->buscarplantilla($tipocontrato);
        $nacionalidadid = $tra->getNacionalidad();
        $nac = $c->buscarnacionalidad($nacionalidadid);
        $nacionalidad = $nac->getNombre();
        $correotrabajador = $con->getCorreo();
        $telefonotrabajador = $con->getTelefono();
        $trabajadorregion = $dom->getRegion();
        $trabajadorcomuna  = $dom->getComuna();
        $calletrabajador = $dom->getCalle() . " " . $dom->getVilla();
        $numerotrabajador = $dom->getNumero();
        $departamentotrabajador = $dom->getdepartamento();

        //Informacion de Celebracion de Contrato
        $categoria_contrato = $_POST['categoria_contrato'];
        $regioncelebracion = $_POST['regioncelebracion'];
        $regicel = $c->buscarregion($regioncelebracion);
        $regioncelebracion = $regicel->getNombre();
        $comunacelebracion = $_POST['comunacelebracion'];
        $comun = $c->buscarcomuna($comunacelebracion);
        $comunacelebracion = $comun->getNombre();
        $fechacelebracion = $_POST['fechacelebracion'];
        //Convertir fecha a formato dd/mm/yyyy
        $fechacelebracion = date("d/m/Y", strtotime($fechacelebracion));

        //Informacion Empresa
        $representante_legal = $_POST['representante_legal'];
        $represen = $c->BuscarRepresentanteLegal($representante_legal);
        $representante_legal = $represen->getNombre() . " " . $represen->getApellido1() . " " . $represen->getApellido2();
        $rutrepresentantelegal = $represen->getRut();
        $codigoactividadid = $_POST['codigoactividadid'];
        $empresaregion = $_POST['empresaregion'];
        $empresacomuna = $_POST['empresacomuna'];
        $empresaregion = $_POST['empresaregion'];
        $empreg = $c->buscarregion($empresaregion);
        $empresaregion = $empreg->getNombre();
        $empresacomuna = $_POST['empresacomuna'];
        $empcom = $c->buscarcomuna($empresacomuna);
        $empresacomuna = $empcom->getNombre();
        $calle = $_POST['calle'];
        $numero = $_POST['numero'];



        //Informacion de lugar de trabajo
        $centrocosto = $_POST['centrocosto'];
        $Charge = $_POST['Charge'];
        //Comprobar si charge es tipo numerico
        if (is_numeric($Charge)) {
            if ($Charge > 0) {
                $cargito = $c->buscarcargo($Charge);
                $Charge = $cargito->getNombre();
            }
        }
        $ChargeDescripcion = $_POST['ChargeDescripcion'];
        $regionespecifica = $_POST['regionespecifica'];
        $regies = $c->buscarregion($regionespecifica);
        $regionespecifica = $regies->getNombre();
        $comunaespecifica = $_POST['comunaespecifica'];
        $comues = $c->buscarcomuna($comunaespecifica);
        $comunaespecifica = $comues->getNombre();
        $calleespecifica = $_POST['calleespecifica'];
        $numeroespecifica = $_POST['numeroespecifica'];

        //Informacion de Subcontratacion & Transitorios
        $subcontratacionrut = $_POST['subcontratacionrut'];
        $subcontratacionrazonsocial = $_POST['subcontratacionrazonsocial'];
        $transitoriosrut = $_POST['transitoriosrut'];
        $transitoriosrazonsocial = $_POST['transitoriosrazonsocial'];

        //Informacion de Remuneracion
        $tiposueldo = $_POST['tiposueldo'];
        switch ($tiposueldo) {
            case '1':
                $tiposueldo = "Por Hora";
                break;
            case '2':
                $tiposueldo = "Mensual";
                break;
            case '3':
                $tiposueldo = "Semanal";
                break;
            case '4':
                $tiposueldo = "Diario";
                break;
        }
        $sueldo = $_POST['sueldo'];
        //Cambiar sueldo numerico a letras
        $sueldo = $sueldo;
        //Eliminar puntos   
        $sueldo1 = str_replace(".", "", $sueldo);
        $sueldoletras = $c->convertirNumeroLetras($sueldo1);

        $periodopagogra = $_POST['periodopagogra'];
        $detallerenumeraciongra = $_POST['detallerenumeraciongra'];
        switch ($periodopagogra) {
            case '1':
                $periodopagogra = "Mensual";
                break;
            case '2':
                $periodopagogra = "Bimestral";
                break;
            case '3':
                $periodopagogra = "Trimestral";
                break;
            case '4':
                $periodopagogra = "Cuatrimestral";
                break;
            case '5':
                $periodopagogra = "Semestral";
                break;
            case '6':
                $periodopagogra = "Anual";
                break;
        }

        $formapago = $_POST['formapago'];
        switch ($formapago) {
            case '1':
                $formapago = "No pactado en contrato de trabajo";
                $periodopagogra = "";
                $detallerenumeraciongra = "";
                break;
            case '2':
                $formapago = "Artículo 47 del Código del Trabajo";
                $detallerenumeraciongra = "";
                break;
            case '3':
                $formapago = "Modalidad convencional superior al mínimo legal";
                break;
            case '4':
                $formapago = "Artíuculo 50 del Código del Trabajo";
                $detallerenumeraciongra = "";
                break;
            case '5':
                $formapago = "Sin obligación legal de pago";
                $periodopagogra = "";
                $detallerenumeraciongra = "";
        }

        $periodopagot = $_POST['periodopagot'];
        switch ($periodopagot) {
            case '1':
                $periodopagot = "Semanal";
                break;
            case '2':
                $periodopagot = "Mensual";
                break;
            case '3':
                $periodopagot = "Quicenal";
                break;
            case '4':
                $periodopagot = "Diario";
                break;
            case '5':
                $periodopagot = "Por Hora";
                break;
        }

        $banco = "";
        $tipocuenta = "";
        $numerocuenta = "";

        $formapagot = $_POST['formapagot'];
        $fechapagot = $_POST['fechapagot'];
        $cuentabancaria = $c->ultimacuentabancariaregistrada($tra->getEmpresa());
        if ($formapagot == 1 || $formapagot == 2 || $formapagot == 3) {
        } else {
            if ($cuentabancaria == false) {
                echo "El trabajador " . $tra->getNombre() . " " . $tra->getApellido1() . " " . $tra->getApellido2() . " no tiene Información Bancaria Registrada";
                return;
            } else {
                $banco = $cuentabancaria->getBanco();
                switch ($banco) {
                    case '1':
                        $banco = "Banco de Chile";
                        break;
                    case '2':
                        $banco = "Banco Santander";
                        break;
                    case '3':
                        $banco = "Banco Estado";
                        break;
                    case '4':
                        $banco = "Banco Security";
                        break;
                    case '5':
                        $banco = "Banco Itaú";
                        break;
                    case '6':
                        $banco = "Banco BCI";
                        break;
                    case '7':
                        $banco = "Banco Falabella";
                        break;
                    case '8':
                        $banco = "Banco Ripley";
                        break;
                    case '9':
                        $banco = "Banco Consorcio";
                        break;
                    case '10':
                        $banco = "Banco Internacional";
                        break;
                    case '11':
                        $banco = "Banco Edwards Citi";
                        break;
                    case '12':
                        $banco = "Banco de Crédito e Inversiones (BCI)";
                        break;
                    case '13':
                        $banco = "Banco Penta";
                        break;
                    case '14':
                        $banco = "Banco Paris";
                        break;
                }

                $tipocuenta = $cuentabancaria->getTipo();
                switch ($tipocuenta) {
                    case '1':
                        $tipocuenta = "Cuenta Corriente";
                        break;
                    case '2':
                        $tipocuenta = "Cuenta Vista";
                        break;
                    case '3':
                        $tipocuenta = "Cuenta Rut";
                        break;
                    case '4':
                        $tipocuenta = "Cuenta de Ahorro";
                        break;
                    case '5':
                        $tipocuenta = "Cuenta de Inversiones";
                        break;
                }

                $numerocuenta = $cuentabancaria->getNumero();
            }
        }

        switch ($formapagot) {
            case '1':
                $formapagot = "Dinero en efectivo";
                $banco = "";
                $tipocuenta = "";
                $numerocuenta = "";
                break;
            case '2':
                $formapagot = "Cheque";
                $banco = "";
                $tipocuenta = "";
                $numerocuenta = "";
                break;
            case '3':
                $formapagot = "Vale vista";
                $banco = "";
                $tipocuenta = "";
                $numerocuenta = "";
                break;
            case '4':
                $formapagot = "Deposito Bancario";
                break;
            case '5':
                $formapagot = "Transferencia Bancaria";
                break;
        }



        $anticipot = $_POST['anticipot'];
        switch ($anticipot) {
            case '1':
                $anticipot = "Sin Anticipo";
                break;
            case '2':
                $anticipot = "Con Anticipo Semanal";
                break;
            case '3':
                $anticipot = "Con Anticipo Quincenal";
                break;
        }

        //Informacion de Horario
        $noresolucion = $_POST['noresolucion'];
        $exfecha = $_POST['exfecha'];
        //Cambiar formato a dd/mm/aaaa
        $exfecha = date("d/m/Y", strtotime($exfecha));
        $tipojornada = $_POST['tipojornada'];
        switch ($tipojornada) {
            case '1':
                $tipojornada = "Jornada Semanal ordinaria";
                break;
            case '2':
                $tipojornada = "Jornada Semana Extendida";
                break;
            case '3':
                $tipojornada = "Joranda Bisemanal";
                break;
            case '4':
                $tipojornada = "Jornada Mensual";
                break;
            case '5':
                $tipojornada = "Jornada diaria";
                break;
        }
        //$horaspactadas = $_POST['horaspactadas'];
        $dias = $_POST['dias'];
        $colacion = $_POST['colacion'];
        $colacionimp = $_POST['colacionimp'];
        $duracionjor = $_POST['duracionjor'];
        $colaimpu = $_POST['colaimpu'];
        switch ($duracionjor) {
            case '1':
                $duracionjor = "45 Horas";
                break;
            case '2':
                $duracionjor = "44 Horas";
                break;
            case '3':
                $duracionjor = "43 Horas";
                break;
            case '4':
                $duracionjor = "42 Horas";
                break;
            case '5':
                $duracionjor = "41 Horas";
                break;
            case '6':
                $duracionjor = "40 Horas";
                break;
            case '7':
                $duracionjor = "39 Horas";
                break;
            case '8':
                $duracionjor = "38 Horas";
                break;
            case '9':
                $duracionjor = "37 Horas";
                break;
            case '10':
                $duracionjor = "36 Horas";
                break;
            case '11':
                $duracionjor = "35 Horas";
                break;
            case '12':
                $duracionjor = "34 Horas";
                break;
            case '13':
                $duracionjor = "33 Horas";
                break;
            case '14':
                $duracionjor = "32 Horas";
                break;
            case '15':
                $duracionjor = "31 Horas";
                break;
            case '16':
                $duracionjor = "30 Horas";
                break;
            case '17':
                $duracionjor = "29 Horas";
                break;
            case '18':
                $duracionjor = "28 Horas";
                break;
            case '19':
                $duracionjor = "27 Horas";
                break;
            case '20':
                $duracionjor = "26 Horas";
                break;
            case '21':
                $duracionjor = "25 Horas";
                break;
            case '22':
                $duracionjor = "24 Horas";
                break;
            case '23':
                $duracionjor = "23 Horas";
                break;
            case '24':
                $duracionjor = "22 Horas";
                break;
            case '25':
                $duracionjor = "21 Horas";
                break;
            case '26':
                $duracionjor = "20 Horas";
                break;
            case '27':
                $duracionjor = "19 Horas";
                break;
            case '28':
                $duracionjor = "18 Horas";
                break;
            case '29':
                $duracionjor = "17 Horas";
                break;
            case '30':
                $duracionjor = "16 Horas";
                break;
            case '31':
                $duracionjor = "15 Horas";
                break;
            case '32':
                $duracionjor = "14 Horas";
                break;
            case '33':
                $duracionjor = "13 Horas";
                break;
            case '34':
                $duracionjor = "12 Horas";
                break;
            case '35':
                $duracionjor = "11 Horas";
                break;
            case '36':
                $duracionjor = "10 Horas";
                break;
            case '37':
                $duracionjor = "9 Horas";
                break;
            case '38':
                $duracionjor = "8 Horas";
                break;
            case '39':
                $duracionjor = "7 Horas";
                break;
            case '40':
                $duracionjor = "6 Horas";
                break;
            case '41':
                $duracionjor = "5 Horas";
                break;
            case '42':
                $duracionjor = "4 Horas";
                break;
            case '43':
                $duracionjor = "3 Horas";
                break;
            case '44':
                $duracionjor = "2 Horas";
                break;
            case '45':
                $duracionjor = "1 Hora";
                break;
            case '46':
                $duracionjor = "30 Minutos";
                break;
        }


        //Informacion de Estipulaciones
        $fecha_inicio = $_POST['fecha_inicio'];
        $fechainicioregistro = $_POST['fecha_inicio'];
        //Convertir fecha en formato yyyy-mm-dd
        $fechainicioregistro = date("Y-m-d", strtotime($fecha_inicio));
        //Convertir fecha en formato largo
        $fecha_inicio = date("d/m/Y", strtotime($fecha_inicio));

        $typecontract = $_POST['typecontract'];
        $fecha_termino = $_POST['fecha_termino'];
        //Convertir fecha en formato largo
        if ($typecontract == 1) {
            $typecontract = "Contrato Indefinido";
            $fecha_termino = "";
        } else if ($typecontract == 2) {
            $typecontract = "Contrato a Plazo Fijo";
            $fecha_termino = date("d/m/Y", strtotime($fecha_termino));
        } else {
            $typecontract = "Obra o Faena";
            $fecha_termino = "";
        }

        $estipulacion1 = $_POST['estipulacion1'];
        $estipulacion2 = $_POST['estipulacion2'];
        $estipulacion3 = $_POST['estipulacion3'];
        $estipulacion4 = $_POST['estipulacion4'];
        $estipulacion5 = $_POST['estipulacion5'];
        $estipulacion6 = $_POST['estipulacion6'];
        $estipulacion7 = $_POST['estipulacion7'];
        $estipulacion8 = $_POST['estipulacion8'];
        $estipulacion9 = $_POST['estipulacion9'];
        $estipulacion10 = $_POST['estipulacion10'];
        $estipulacion11 = $_POST['estipulacion11'];
        $estipulacion12 = $_POST['estipulacion12'];
        $estipulacion13 = $_POST['estipulacion13'];

        $estipulaciones = "";
        if ($estipulacion1 != 0) {
            $estipulaciones .= $estipulacion1 . ",";
        } else if ($estipulacion2 != 0) {
            $estipulaciones .= $estipulacion2 . ",";
        } else if ($estipulacion3 != 0) {
            $estipulaciones .= $estipulacion3;
        } else if ($estipulacion4 != 0) {
            $estipulaciones .= $estipulacion4;
        } else if ($estipulacion5 != 0) {
            $estipulaciones .= $estipulacion5;
        } else if ($estipulacion6 != 0) {
            $estipulaciones .= $estipulacion6;
        } else if ($estipulacion7 != 0) {
            $estipulaciones .= $estipulacion7;
        } else if ($estipulacion8 != 0) {
            $estipulaciones .= $estipulacion8;
        } else if ($estipulacion9 != 0) {
            $estipulaciones .= $estipulacion9;
        } else if ($estipulacion10 != 0) {
            $estipulaciones .= $estipulacion10;
        } else if ($estipulacion11 != 0) {
            $estipulaciones .= $estipulacion11;
        } else if ($estipulacion12 != 0) {
            $estipulaciones .= $estipulacion12;
        } else if ($estipulacion13 != 0) {
            $estipulaciones .= $estipulacion13;
        }
        $rotativo = $_POST['rotativo'];
        switch ($rotativo) {
            case '1':
                $rotativo = "Diaria";
                break;
            case '2':
                $rotativo = "Semanal";
                break;
            case '3':
                $rotativo = "Quincenal";
                break;
            case '4':
                $rotativo = "Mensual";
                break;
            case '5':
                $rotativo = "Trimestral";
                break;
            case '6':
                $rotativo = "Semestral";
                break;
        }

        $horarioturno = $_POST['horarioturno'];
        
        $distribucion = "";


        if ($horarioturno == 1) {
            $rotativo = "";
            $distribucion .= "<p>Duración de colación: " . $colacion . " minutos</p>";
            //Jornada Normal
            //Formato Hora HH:MM
            $lunes = $_POST['lunes'];
            $lunesinicio = $_POST['lunesinicio'];
            $lunesinicio = date("H:i", strtotime($lunesinicio));
            $lunesfin = $_POST['lunesfin'];
            $lunesfin = date("H:i", strtotime($lunesfin));
            $martes = $_POST['martes'];
            $martesinicio = $_POST['martesinicio'];
            $martesinicio = date("H:i", strtotime($martesinicio));
            $martesfin = $_POST['martesfin'];
            $martesfin = date("H:i", strtotime($martesfin));
            $miercoles = $_POST['miercoles'];
            $miercolesinicio = $_POST['miercolesinicio'];
            $miercolesinicio = date("H:i", strtotime($miercolesinicio));
            $miercolesfin = $_POST['miercolesfin'];
            $miercolesfin = date("H:i", strtotime($miercolesfin));
            $jueves = $_POST['jueves'];
            $juevesinicio = $_POST['juevesinicio'];
            $juevesinicio = date("H:i", strtotime($juevesinicio));
            $juevesfin = $_POST['juevesfin'];
            $juevesfin = date("H:i", strtotime($juevesfin));
            $viernes = $_POST['viernes'];
            $viernesinicio = $_POST['viernesinicio'];
            $viernesinicio = date("H:i", strtotime($viernesinicio));
            $viernesfin = $_POST['viernesfin'];
            $viernesfin = date("H:i", strtotime($viernesfin));
            $sabado = $_POST['sabado'];
            $sabadoinicio = $_POST['sabadoinicio'];
            $sabadoinicio = date("H:i", strtotime($sabadoinicio));
            $sabadofin = $_POST['sabadofin'];
            $sabadofin = date("H:i", strtotime($sabadofin));
            $domingo = $_POST['domingo'];
            $domingoinicio = $_POST['domingoinicio'];
            $domingoinicio = date("H:i", strtotime($domingoinicio));
            $domingofin = $_POST['domingofin'];
            $domingofin = date("H:i", strtotime($domingofin));
    
            //Agregar cabezale de table jornada general
            $distribucion .= "<table border='1' width='100%' >";
            $distribucion .= "<thead><tr><th>Días</th>";
            if ($lunes == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martes == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercoles == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($jueves == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernes == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabado == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingo == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
    
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunes == 1) {
                $distribucion .= "<td>" . $lunesinicio . "</td>";
            }
            if ($martes == 1) {
                $distribucion .= "<td>" . $martesinicio . "</td>";
            }
            if ($miercoles == 1) {
                $distribucion .= "<td>" . $miercolesinicio . "</td>";
            }
            if ($jueves == 1) {
                $distribucion .= "<td>" . $juevesinicio . "</td>";
            }
            if ($viernes == 1) {
                $distribucion .= "<td>" . $viernesinicio . "</td>";
            }
            if ($sabado == 1) {
                $distribucion .= "<td>" . $sabadoinicio . "</td>";
            }
            if ($domingo == 1) {
                $distribucion .= "<td>" . $domingoinicio . "</td>";
            }
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunes == 1) {
                $distribucion .= "<td>" . $lunesfin . "</td>";
            }
            if ($martes == 1) {
                $distribucion .= "<td>" . $martesfin . "</td>";
            }
            if ($miercoles == 1) {
                $distribucion .= "<td>" . $miercolesfin . "</td>";
            }
            if ($jueves == 1) {
                $distribucion .= "<td>" . $juevesfin . "</td>";
            }
            if ($viernes == 1) {
                $distribucion .= "<td>" . $viernesfin . "</td>";
            }
            if ($sabado == 1) {
                $distribucion .= "<td>" . $sabadofin . "</td>";
            }
            if ($domingo == 1) {
                $distribucion .= "<td>" . $domingofin . "</td>";
            }
    
            $distribucion .= "</tr></tbody></table>" . "<br>";
    
        }
    
        if ($horarioturno == 2) {
            $rotativo = "";
            $distribucion = "<p>NB: Turnos de trabajo especificados en el reglamento interno de orden, higiene y seguridad</p>";
        }
    
        if ($horarioturno == 3) {
            $distribucion .= "<p>Duración de colación: " . $colacion . " minutos</p>";
            $distribucion = "";
    
            //Jornada Matutina
            //Formato Hora HH:MM
            $lunesm = $_POST['lunesm'];
            $lunesiniciom = $_POST['lunesminicio'];
            $lunesiniciom = date("H:i", strtotime($lunesiniciom));
            $lunesfinm = $_POST['lunesmfin'];
            $lunesfinm = date("H:i", strtotime($lunesfinm));
            $martesm = $_POST['martesm'];
            $martesiniciom = $_POST['martesminicio'];
            $martesiniciom = date("H:i", strtotime($martesiniciom));
            $martesfinm = $_POST['martesmfin'];
            $martesfinm = date("H:i", strtotime($martesfinm));
            $miercolesm = $_POST['miercolesm'];
            $miercolesiniciom = $_POST['miercolesminicio'];
            $miercolesiniciom = date("H:i", strtotime($miercolesiniciom));
            $miercolesfinm = $_POST['miercolesmfin'];
            $miercolesfinm = date("H:i", strtotime($miercolesfinm));
            $juevesm = $_POST['juevesm'];
            $juevesiniciom = $_POST['juevesminicio'];
            $juevesiniciom = date("H:i", strtotime($juevesiniciom));
            $juevesfinm = $_POST['juevesmfin'];
            $juevesfinm = date("H:i", strtotime($juevesfinm));
            $viernesm = $_POST['viernesm'];
            $viernesiniciom = $_POST['viernesminicio'];
            $viernesiniciom = date("H:i", strtotime($viernesiniciom));
            $viernesfinm = $_POST['viernesmfin'];
            $viernesfinm = date("H:i", strtotime($viernesfinm));
            $sabadom = $_POST['sabadom'];
            $sabadoiniciom = $_POST['sabadominicio'];
            $sabadoiniciom = date("H:i", strtotime($sabadoiniciom));
            $sabadofinm = $_POST['sabadomfin'];
            $sabadofinm = date("H:i", strtotime($sabadofinm));
            $domingom = $_POST['domingom'];
            $domingoiniciom = $_POST['domingominicio'];
            $domingoiniciom = date("H:i", strtotime($domingoiniciom));
            $domingofinm = $_POST['domingomfin'];
            $domingofinm = date("H:i", strtotime($domingofinm));
    
            //Agregar cabezale de table jornada matutina
            $distribucion .= "<table border='1' width='100%'>";
            $distribucion .= "<thead><tr><th>Días</th>";
    
            if ($lunesm == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martesm == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingom == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
            
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunesm == 1) {
                $distribucion .= "<td>" . $lunesiniciom . "</td>";
            }
            if ($martesm == 1) {
                $distribucion .= "<td>" . $martesiniciom . "</td>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<td>" . $miercolesiniciom . "</td>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<td>" . $juevesiniciom . "</td>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<td>" . $viernesiniciom . "</td>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<td>" . $sabadoiniciom . "</td>";
            }
            if ($domingom == 1) {
                $distribucion .= "<td>" . $domingoiniciom . "</td>";
            }
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunesm == 1) {
                $distribucion .= "<td>" . $lunesfinm . "</td>";
            }
            if ($martesm == 1) {
                $distribucion .= "<td>" . $martesfinm . "</td>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<td>" . $miercolesfinm . "</td>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<td>" . $juevesfinm . "</td>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<td>" . $viernesfinm . "</td>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<td>" . $sabadofinm . "</td>";
            }
            if ($domingom == 1) {
                $distribucion .= "<td>" . $domingofinm . "</td>";
            }
            $distribucion .= "</tr></tbody></table>" . "<br>";
    
    
            //Jornada Tarde
            $distribucion .= "";
            $lunest = $_POST['lunest'];
            $lunesiniciot = $_POST['lunestinicio'];
            //Formato de hora HH:MM
            $lunesiniciot = date("H:i", strtotime($lunesiniciot));
            $lunesfint = $_POST['lunestfin'];
            $lunesfint = date("H:i", strtotime($lunesfint));
            $martest = $_POST['martest'];
            $martesiniciot = $_POST['martestinicio'];
            $martesiniciot = date("H:i", strtotime($martesiniciot));
            $martesfint = $_POST['martestfin'];
            $martesfint = date("H:i", strtotime($martesfint));
            $miercolest = $_POST['miercolest'];
            $miercolesiniciot = $_POST['miercolestinicio'];
            $miercolesiniciot = date("H:i", strtotime($miercolesiniciot));
            $miercolesfint = $_POST['miercolestfin'];
            $miercolesfint = date("H:i", strtotime($miercolesfint));
            $juevest = $_POST['juevest'];
            $juevesiniciot = $_POST['juevestinicio'];
            $juevesiniciot = date("H:i", strtotime($juevesiniciot));
            $juevesfint = $_POST['juevestfin'];
            $juevesfint = date("H:i", strtotime($juevesfint));
            $viernest = $_POST['viernest'];
            $viernesiniciot = $_POST['viernestinicio'];
            $viernesiniciot = date("H:i", strtotime($viernesiniciot));
            $viernesfint = $_POST['viernestfin'];
            $viernesfint = date("H:i", strtotime($viernesfint));
            $sabadot = $_POST['sabadot'];
            $sabadoiniciot = $_POST['sabadotinicio'];
            $sabadoiniciot = date("H:i", strtotime($sabadoiniciot));
            $sabadofint = $_POST['sabadotfin'];
            $sabadofint = date("H:i", strtotime($sabadofint));
            $domingot = $_POST['domingot'];
            $domingoiniciot = $_POST['domingotinicio'];
            $domingoiniciot = date("H:i", strtotime($domingoiniciot));
            $domingofint = $_POST['domingotfin'];
            $domingofint = date("H:i", strtotime($domingofint));
    
            //Agregar cabezale de table jornada Tarde
            $distribucion = $distribucion . "<table border='1' width='100%'>";
            $distribucion = $distribucion . "<thead><tr><th>Días</th>";         
            if ($lunest == 1) {
                $distribucion = $distribucion . "<th>Lunes</th>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<th>Martes</th>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<th>Miercoles</th>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<th>Jueves</th>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<th>Viernes</th>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<th>Sabado</th>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<th>Domingo</th>";
            }
            
            $distribucion = $distribucion . "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunest == 1) {
                $distribucion = $distribucion . "<td>" . $lunesiniciot . "</td>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<td>" . $martesiniciot . "</td>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<td>" . $miercolesiniciot . "</td>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<td>" . $juevesiniciot . "</td>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<td>" . $viernesiniciot . "</td>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<td>" . $sabadoiniciot . "</td>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<td>" . $domingoiniciot . "</td>";
            }
    
            $distribucion = $distribucion . "</tr><tr><td>Fin</td>";
            if ($lunest == 1) {
                $distribucion = $distribucion . "<td>" . $lunesfint . "</td>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<td>" . $martesfint . "</td>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<td>" . $miercolesfint . "</td>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<td>" . $juevesfint . "</td>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<td>" . $viernesfint . "</td>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<td>" . $sabadofint . "</td>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<td>" . $domingofint . "</td>";
            }
            $distribucion = $distribucion . "</tr></tbody></table>" . "<br>";
        }
    
        if ($horarioturno == 4) {
            //Jornada Tarde
            $distribucion .= "<p>Duración de colación: " . $colacion . " minutos</p>";
            $distribucion .= "";
            //Formato Hora HH:MM
            $lunest = $_POST['lunest'];
            $lunesiniciot = $_POST['lunestinicio'];
            $lunesiniciot = date("H:i", strtotime($lunesiniciot));
            $lunesfint = $_POST['lunestfin'];
            $lunesfint = date("H:i", strtotime($lunesfint));
            $martest = $_POST['martest'];
            $martesiniciot = $_POST['martestinicio'];
            $martesiniciot = date("H:i", strtotime($martesiniciot));
            $martesfint = $_POST['martestfin'];
            $martesfint = date("H:i", strtotime($martesfint));
            $miercolest = $_POST['miercolest'];
            $miercolesiniciot = $_POST['miercolestinicio'];
            $miercolesiniciot = date("H:i", strtotime($miercolesiniciot));
            $miercolesfint = $_POST['miercolestfin'];
            $miercolesfint = date("H:i", strtotime($miercolesfint));
            $juevest = $_POST['juevest'];
            $juevesiniciot = $_POST['juevestinicio'];
            $juevesiniciot = date("H:i", strtotime($juevesiniciot));
            $juevesfint = $_POST['juevestfin'];
            $juevesfint = date("H:i", strtotime($juevesfint));
            $viernest = $_POST['viernest'];
            $viernesiniciot = $_POST['viernestinicio'];
            $viernesiniciot = date("H:i", strtotime($viernesiniciot));
            $viernesfint = $_POST['viernestfin'];
            $viernesfint = date("H:i", strtotime($viernesfint));
            $sabadot = $_POST['sabadot'];
            $sabadoiniciot = $_POST['sabadotinicio'];
            $sabadoiniciot = date("H:i", strtotime($sabadoiniciot));
            $sabadofint = $_POST['sabadotfin'];
            $sabadofint = date("H:i", strtotime($sabadofint));
            $domingot = $_POST['domingot'];
            $domingoiniciot = $_POST['domingotinicio'];
            $domingoiniciot = date("H:i", strtotime($domingoiniciot));
            $domingofint = $_POST['domingotfin'];
            $domingofint = date("H:i", strtotime($domingofint));
    
            //Agregar cabezale de table jornada Tarde
            $distribucion = $distribucion . "<table border='1' width='100%'>";
            $distribucion = $distribucion . "<thead><tr><th>Días</th>";         
            if ($lunest == 1) {
                $distribucion = $distribucion . "<th>Lunes</th>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<th>Martes</th>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<th>Miercoles</th>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<th>Jueves</th>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<th>Viernes</th>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<th>Sabado</th>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<th>Domingo</th>";
            }
            
            $distribucion = $distribucion . "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunest == 1) {
                $distribucion = $distribucion . "<td>" . $lunesiniciot . "</td>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<td>" . $martesiniciot . "</td>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<td>" . $miercolesiniciot . "</td>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<td>" . $juevesiniciot . "</td>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<td>" . $viernesiniciot . "</td>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<td>" . $sabadoiniciot . "</td>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<td>" . $domingoiniciot . "</td>";
            }
    
            $distribucion = $distribucion . "</tr><tr><td>Fin</td>";
            if ($lunest == 1) {
                $distribucion = $distribucion . "<td>" . $lunesfint . "</td>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<td>" . $martesfint . "</td>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<td>" . $miercolesfint . "</td>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<td>" . $juevesfint . "</td>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<td>" . $viernesfint . "</td>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<td>" . $sabadofint . "</td>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<td>" . $domingofint . "</td>";
            }
            $distribucion = $distribucion . "</tr></tbody></table>" . "<br>";
    
            //Jornada Nocturna
            $distribucion .= "<h4></h2>";
    
            //Formato Hora HH:MM
            $lunesn = $_POST['lunesn'];
            $lunesinicion = $_POST['lunesninicio'];
            $lunesiniciom = date("H:i", strtotime($lunesinicion));
            $lunesfinn = $_POST['lunesnfin'];
            $lunesfinn = date("H:i", strtotime($lunesfinn));
            $martesn = $_POST['martesn'];
            $martesinicion = $_POST['martesninicio'];
            $martesinicion = date("H:i", strtotime($martesinicion));
            $martesfinn = $_POST['martesnfin'];
            $martesfinn = date("H:i", strtotime($martesfinn));
            $miercolesn = $_POST['miercolesn'];
            $miercolesinicion = $_POST['miercolesninicio']; 
            $miercolesinicion = date("H:i", strtotime($miercolesinicion));
            $miercolesfinn = $_POST['miercolesnfin'];
            $miercolesfinn = date("H:i", strtotime($miercolesfinn));
            $juevesn = $_POST['juevesn'];
            $juevesinicion = $_POST['juevesninicio'];
            $juevesinicion = date("H:i", strtotime($juevesinicion));
            $juevesfinn = $_POST['juevesnfin'];
            $juevesfinn = date("H:i", strtotime($juevesfinn));
            $viernesn = $_POST['viernesn'];
            $viernesinicion = $_POST['viernesninicio'];
            $viernesinicion = date("H:i", strtotime($viernesinicion));
            $viernesfinn = $_POST['viernesnfin'];
            $viernesfinn = date("H:i", strtotime($viernesfinn));
            $sabadon = $_POST['sabadon'];
            $sabadoinicion = $_POST['sabadoninicio'];
            $sabadoinicion = date("H:i", strtotime($sabadoinicion));
            $sabadofinn = $_POST['sabadonfin'];
            $sabadofinn = date("H:i", strtotime($sabadofinn));
            $domingon = $_POST['domingon'];
            $domingoinicion = $_POST['domingoninicio'];
            $domingoinicion = date("H:i", strtotime($domingoinicion));
            $domingofinn = $_POST['domingonfin'];
            $domingofinn = date("H:i", strtotime($domingofinn));
    
            //Agregar cabezale de table jornada Nocturna
            $distribucion .= "<table border='1' width='100%'>";
            $distribucion .= "<thead><tr><th>Días</th>";
            if ($lunesn == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martesn == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingon == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
            
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunesn == 1) {
                $distribucion .= "<td>" . $lunesinicion . "</td>";
            }
            if ($martesn == 1) {
                $distribucion .= "<td>" . $martesinicion . "</td>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<td>" . $miercolesinicion . "</td>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<td>" . $juevesinicion . "</td>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<td>" . $viernesinicion . "</td>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<td>" . $sabadoinicion . "</td>";
            }
            if ($domingon == 1) {
                $distribucion .= "<td>" . $domingoinicion . "</td>";
            }
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunesn == 1) {
                $distribucion .= "<td>" . $lunesfinn . "</td>";
            }
            if ($martesn == 1) {
                $distribucion .= "<td>" . $martesfinn . "</td>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<td>" . $miercolesfinn . "</td>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<td>" . $juevesfinn . "</td>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<td>" . $viernesfinn . "</td>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<td>" . $sabadofinn . "</td>";
            }
            if ($domingon == 1) {
                $distribucion .= "<td>" . $domingofinn . "</td>";
            }
            $distribucion .= "</tr></tbody></table>" . "<br>";
        }
    
        if ($horarioturno == 5) {
            //Jornada Matutina
            $distribucion .= "<p>Duración de colación: " . $colacion . " minutos</p>";
            $distribucion .= "";
    
            //Formato Hora HH:MM
            $lunesm = $_POST['lunesm'];
            $lunesiniciom = $_POST['lunesminicio'];
            $lunesiniciom = date("H:i", strtotime($lunesiniciom));
            $lunesfinm = $_POST['lunesmfin'];
            $lunesfinm = date("H:i", strtotime($lunesfinm));
            $martesm = $_POST['martesm'];
            $martesiniciom = $_POST['martesminicio'];
            $martesiniciom = date("H:i", strtotime($martesiniciom));
            $martesfinm = $_POST['martesmfin'];
            $martesfinm = date("H:i", strtotime($martesfinm));
            $miercolesm = $_POST['miercolesm'];
            $miercolesiniciom = $_POST['miercolesminicio'];
            $miercolesiniciom = date("H:i", strtotime($miercolesiniciom));
            $miercolesfinm = $_POST['miercolesmfin'];
            $miercolesfinm = date("H:i", strtotime($miercolesfinm));
            $juevesm = $_POST['juevesm'];
            $juevesiniciom = $_POST['juevesminicio'];
            $juevesiniciom = date("H:i", strtotime($juevesiniciom));
            $juevesfinm = $_POST['juevesmfin'];
            $juevesfinm = date("H:i", strtotime($juevesfinm));
            $viernesm = $_POST['viernesm'];
            $viernesiniciom = $_POST['viernesminicio'];
            $viernesiniciom = date("H:i", strtotime($viernesiniciom));
            $viernesfinm = $_POST['viernesmfin'];
            $viernesfinm = date("H:i", strtotime($viernesfinm));
            $sabadom = $_POST['sabadom'];
            $sabadoiniciom = $_POST['sabadominicio'];
            $sabadoiniciom = date("H:i", strtotime($sabadoiniciom));
            $sabadofinm = $_POST['sabadomfin'];
            $sabadofinm = date("H:i", strtotime($sabadofinm));
            $domingom = $_POST['domingom'];
            $domingoiniciom = $_POST['domingominicio'];
            $domingoiniciom = date("H:i", strtotime($domingoiniciom));
            $domingofinm = $_POST['domingomfin'];
            $domingofinm = date("H:i", strtotime($domingofinm));
    
            //Agregar cabezale de table jornada matutina
            $distribucion .= "<table border='1' width='100%'>";
            $distribucion .= "<thead><tr><th>Días</th>";
            if ($lunesm == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martesm == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingom == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
            
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunesm == 1) {
                $distribucion .= "<td>" . $lunesiniciom . "</td>";
            }
            if ($martesm == 1) {
                $distribucion .= "<td>" . $martesiniciom . "</td>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<td>" . $miercolesiniciom . "</td>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<td>" . $juevesiniciom . "</td>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<td>" . $viernesiniciom . "</td>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<td>" . $sabadoiniciom . "</td>";
            }
            if ($domingom == 1) {
                $distribucion .= "<td>" . $domingoiniciom . "</td>";
            }       
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunesm == 1) {
                $distribucion .= "<td>" . $lunesfinm . "</td>";
            }
            if ($martesm == 1) {
                $distribucion .= "<td>" . $martesfinm . "</td>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<td>" . $miercolesfinm . "</td>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<td>" . $juevesfinm . "</td>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<td>" . $viernesfinm . "</td>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<td>" . $sabadofinm . "</td>";
            }
            if ($domingom == 1) {
                $distribucion .= "<td>" . $domingofinm . "</td>";
            }
            $distribucion .= "</tr></tbody></table>" . "<br>";
    
    
            //Jornada Nocturna
            $distribucion .= "<h4></h2>";
    
            //Formato Hora HH:MM
            $lunesn = $_POST['lunesn'];
            $lunesinicion = $_POST['lunesninicio'];
            $lunesiniciom = date("H:i", strtotime($lunesinicion));
            $lunesfinn = $_POST['lunesnfin'];
            $lunesfinn = date("H:i", strtotime($lunesfinn));
            $martesn = $_POST['martesn'];
            $martesinicion = $_POST['martesninicio'];
            $martesinicion = date("H:i", strtotime($martesinicion));
            $martesfinn = $_POST['martesnfin'];
            $martesfinn = date("H:i", strtotime($martesfinn));
            $miercolesn = $_POST['miercolesn'];
            $miercolesinicion = $_POST['miercolesninicio']; 
            $miercolesinicion = date("H:i", strtotime($miercolesinicion));
            $miercolesfinn = $_POST['miercolesnfin'];
            $miercolesfinn = date("H:i", strtotime($miercolesfinn));
            $juevesn = $_POST['juevesn'];
            $juevesinicion = $_POST['juevesninicio'];
            $juevesinicion = date("H:i", strtotime($juevesinicion));
            $juevesfinn = $_POST['juevesnfin'];
            $juevesfinn = date("H:i", strtotime($juevesfinn));
            $viernesn = $_POST['viernesn'];
            $viernesinicion = $_POST['viernesninicio'];
            $viernesinicion = date("H:i", strtotime($viernesinicion));
            $viernesfinn = $_POST['viernesnfin'];
            $viernesfinn = date("H:i", strtotime($viernesfinn));
            $sabadon = $_POST['sabadon'];
            $sabadoinicion = $_POST['sabadoninicio'];
            $sabadoinicion = date("H:i", strtotime($sabadoinicion));
            $sabadofinn = $_POST['sabadonfin'];
            $sabadofinn = date("H:i", strtotime($sabadofinn));
            $domingon = $_POST['domingon'];
            $domingoinicion = $_POST['domingoninicio'];
            $domingoinicion = date("H:i", strtotime($domingoinicion));
            $domingofinn = $_POST['domingonfin'];
            $domingofinn = date("H:i", strtotime($domingofinn));
    
            //Agregar cabezale de table jornada Nocturna
            $distribucion .= "<table border='1' width='100%'>";
            $distribucion .= "<thead><tr><th>Días</th>";
            if ($lunesn == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martesn == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingon == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
            
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunesn == 1) {
                $distribucion .= "<td>" . $lunesinicion . "</td>";
            }
            if ($martesn == 1) {
                $distribucion .= "<td>" . $martesinicion . "</td>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<td>" . $miercolesinicion . "</td>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<td>" . $juevesinicion . "</td>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<td>" . $viernesinicion . "</td>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<td>" . $sabadoinicion . "</td>";
            }
            if ($domingon == 1) {
                $distribucion .= "<td>" . $domingoinicion . "</td>";
            }
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunesn == 1) {
                $distribucion .= "<td>" . $lunesfinn . "</td>";
            }
            if ($martesn == 1) {
                $distribucion .= "<td>" . $martesfinn . "</td>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<td>" . $miercolesfinn . "</td>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<td>" . $juevesfinn . "</td>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<td>" . $viernesfinn . "</td>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<td>" . $sabadofinn . "</td>";
            }
            if ($domingon == 1) {
                $distribucion .= "<td>" . $domingofinn . "</td>";
            }
            $distribucion .= "</tr></tbody></table>" . "<br>";
        }
    
        if ($horarioturno == 6) {
            //Jornada Matutina
            $distribucion .= "<p>Duración de colación: " . $colacion . " minutos</p>";
            $distribucion .= "";
            //Formato Hora HH:MM
            $lunesm = $_POST['lunesm'];
            $lunesiniciom = $_POST['lunesminicio'];
            $lunesiniciom = date("H:i", strtotime($lunesiniciom));
            $lunesfinm = $_POST['lunesmfin'];
            $lunesfinm = date("H:i", strtotime($lunesfinm));
            $martesm = $_POST['martesm'];
            $martesiniciom = $_POST['martesminicio'];
            $martesiniciom = date("H:i", strtotime($martesiniciom));
            $martesfinm = $_POST['martesmfin'];
            $martesfinm = date("H:i", strtotime($martesfinm));
            $miercolesm = $_POST['miercolesm'];
            $miercolesiniciom = $_POST['miercolesminicio'];
            $miercolesiniciom = date("H:i", strtotime($miercolesiniciom));
            $miercolesfinm = $_POST['miercolesmfin'];
            $miercolesfinm = date("H:i", strtotime($miercolesfinm));
            $juevesm = $_POST['juevesm'];
            $juevesiniciom = $_POST['juevesminicio'];
            $juevesiniciom = date("H:i", strtotime($juevesiniciom));
            $juevesfinm = $_POST['juevesmfin'];
            $juevesfinm = date("H:i", strtotime($juevesfinm));
            $viernesm = $_POST['viernesm'];
            $viernesiniciom = $_POST['viernesminicio'];
            $viernesiniciom = date("H:i", strtotime($viernesiniciom));
            $viernesfinm = $_POST['viernesmfin'];
            $viernesfinm = date("H:i", strtotime($viernesfinm));
            $sabadom = $_POST['sabadom'];
            $sabadoiniciom = $_POST['sabadominicio'];
            $sabadoiniciom = date("H:i", strtotime($sabadoiniciom));
            $sabadofinm = $_POST['sabadomfin'];
            $sabadofinm = date("H:i", strtotime($sabadofinm));
            $domingom = $_POST['domingom'];
            $domingoiniciom = $_POST['domingominicio'];
            $domingoiniciom = date("H:i", strtotime($domingoiniciom));
            $domingofinm = $_POST['domingomfin'];
            $domingofinm = date("H:i", strtotime($domingofinm));
    
            //Agregar cabezale de table jornada matutina
            $distribucion .= "<table border='1' width='100%'>";
            $distribucion .= "<thead><tr><th>Días</th>";
            if ($lunesm == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martesm == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingom == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
            
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunesm == 1) {
                $distribucion .= "<td>" . $lunesiniciom . "</td>";
            }
            if ($martesm == 1) {
                $distribucion .= "<td>" . $martesiniciom . "</td>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<td>" . $miercolesiniciom . "</td>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<td>" . $juevesiniciom . "</td>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<td>" . $viernesiniciom . "</td>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<td>" . $sabadoiniciom . "</td>";
            }
            if ($domingom == 1) {
                $distribucion .= "<td>" . $domingoiniciom . "</td>";
            }       
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunesm == 1) {
                $distribucion .= "<td>" . $lunesfinm . "</td>";
            }
            if ($martesm == 1) {
                $distribucion .= "<td>" . $martesfinm . "</td>";
            }
            if ($miercolesm == 1) {
                $distribucion .= "<td>" . $miercolesfinm . "</td>";
            }
            if ($juevesm == 1) {
                $distribucion .= "<td>" . $juevesfinm . "</td>";
            }
            if ($viernesm == 1) {
                $distribucion .= "<td>" . $viernesfinm . "</td>";
            }
            if ($sabadom == 1) {
                $distribucion .= "<td>" . $sabadofinm . "</td>";
            }
            if ($domingom == 1) {
                $distribucion .= "<td>" . $domingofinm . "</td>";
            }
            $distribucion .= "</tr></tbody></table>" . "<br>";
    
            //Jornada Tarde
            $distribucion .= "";
            //Formato Hora HH:MM
            $lunest = $_POST['lunest'];
            $lunesiniciot = $_POST['lunestinicio'];
            $lunesiniciot = date("H:i", strtotime($lunesiniciot));
            $lunesfint = $_POST['lunestfin'];
            $lunesfint = date("H:i", strtotime($lunesfint));
            $martest = $_POST['martest'];
            $martesiniciot = $_POST['martestinicio'];
            $martesiniciot = date("H:i", strtotime($martesiniciot));
            $martesfint = $_POST['martestfin'];
            $martesfint = date("H:i", strtotime($martesfint));
            $miercolest = $_POST['miercolest'];
            $miercolesiniciot = $_POST['miercolestinicio'];
            $miercolesiniciot = date("H:i", strtotime($miercolesiniciot));
            $miercolesfint = $_POST['miercolestfin'];
            $miercolesfint = date("H:i", strtotime($miercolesfint));
            $juevest = $_POST['juevest'];
            $juevesiniciot = $_POST['juevestinicio'];
            $juevesiniciot = date("H:i", strtotime($juevesiniciot));
            $juevesfint = $_POST['juevestfin'];
            $juevesfint = date("H:i", strtotime($juevesfint));
            $viernest = $_POST['viernest'];
            $viernesiniciot = $_POST['viernestinicio'];
            $viernesiniciot = date("H:i", strtotime($viernesiniciot));
            $viernesfint = $_POST['viernestfin'];
            $viernesfint = date("H:i", strtotime($viernesfint));
            $sabadot = $_POST['sabadot'];
            $sabadoiniciot = $_POST['sabadotinicio'];
            $sabadoiniciot = date("H:i", strtotime($sabadoiniciot));
            $sabadofint = $_POST['sabadotfin'];
            $sabadofint = date("H:i", strtotime($sabadofint));
            $domingot = $_POST['domingot'];
            $domingoiniciot = $_POST['domingotinicio'];
            $domingoiniciot = date("H:i", strtotime($domingoiniciot));
            $domingofint = $_POST['domingotfin'];
            $domingofint = date("H:i", strtotime($domingofint));
    
            //Agregar cabezale de table jornada Tarde
            $distribucion = $distribucion . "<table border='1' width='100%'>";
            $distribucion = $distribucion . "<thead><tr><th>Días</th>";         
            if ($lunest == 1) {
                $distribucion = $distribucion . "<th>Lunes</th>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<th>Martes</th>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<th>Miercoles</th>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<th>Jueves</th>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<th>Viernes</th>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<th>Sabado</th>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<th>Domingo</th>";
            }
            
            $distribucion = $distribucion . "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunest == 1) {
                $distribucion = $distribucion . "<td>" . $lunesiniciot . "</td>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<td>" . $martesiniciot . "</td>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<td>" . $miercolesiniciot . "</td>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<td>" . $juevesiniciot . "</td>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<td>" . $viernesiniciot . "</td>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<td>" . $sabadoiniciot . "</td>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<td>" . $domingoiniciot . "</td>";
            }
    
            $distribucion = $distribucion . "</tr><tr><td>Fin</td>";
            if ($lunest == 1) {
                $distribucion = $distribucion . "<td>" . $lunesfint . "</td>";
            }
            if ($martest == 1) {
                $distribucion = $distribucion . "<td>" . $martesfint . "</td>";
            }
            if ($miercolest == 1) {
                $distribucion = $distribucion . "<td>" . $miercolesfint . "</td>";
            }
            if ($juevest == 1) {
                $distribucion = $distribucion . "<td>" . $juevesfint . "</td>";
            }
            if ($viernest == 1) {
                $distribucion = $distribucion . "<td>" . $viernesfint . "</td>";
            }
            if ($sabadot == 1) {
                $distribucion = $distribucion . "<td>" . $sabadofint . "</td>";
            }
            if ($domingot == 1) {
                $distribucion = $distribucion . "<td>" . $domingofint . "</td>";
            }
            $distribucion = $distribucion . "</tr></tbody></table>" . "<br>";
    
    
           
            //Jornada Nocturna
            $distribucion .= "<h4></h2>";
    
            //Formato Hora HH:MM
            $lunesn = $_POST['lunesn'];
            $lunesinicion = $_POST['lunesninicio'];
            $lunesiniciom = date("H:i", strtotime($lunesinicion));
            $lunesfinn = $_POST['lunesnfin'];
            $lunesfinn = date("H:i", strtotime($lunesfinn));
            $martesn = $_POST['martesn'];
            $martesinicion = $_POST['martesninicio'];
            $martesinicion = date("H:i", strtotime($martesinicion));
            $martesfinn = $_POST['martesnfin'];
            $martesfinn = date("H:i", strtotime($martesfinn));
            $miercolesn = $_POST['miercolesn'];
            $miercolesinicion = $_POST['miercolesninicio']; 
            $miercolesinicion = date("H:i", strtotime($miercolesinicion));
            $miercolesfinn = $_POST['miercolesnfin'];
            $miercolesfinn = date("H:i", strtotime($miercolesfinn));
            $juevesn = $_POST['juevesn'];
            $juevesinicion = $_POST['juevesninicio'];
            $juevesinicion = date("H:i", strtotime($juevesinicion));
            $juevesfinn = $_POST['juevesnfin'];
            $juevesfinn = date("H:i", strtotime($juevesfinn));
            $viernesn = $_POST['viernesn'];
            $viernesinicion = $_POST['viernesninicio'];
            $viernesinicion = date("H:i", strtotime($viernesinicion));
            $viernesfinn = $_POST['viernesnfin'];
            $viernesfinn = date("H:i", strtotime($viernesfinn));
            $sabadon = $_POST['sabadon'];
            $sabadoinicion = $_POST['sabadoninicio'];
            $sabadoinicion = date("H:i", strtotime($sabadoinicion));
            $sabadofinn = $_POST['sabadonfin'];
            $sabadofinn = date("H:i", strtotime($sabadofinn));
            $domingon = $_POST['domingon'];
            $domingoinicion = $_POST['domingoninicio'];
            $domingoinicion = date("H:i", strtotime($domingoinicion));
            $domingofinn = $_POST['domingonfin'];
            $domingofinn = date("H:i", strtotime($domingofinn));
    
            //Agregar cabezale de table jornada Nocturna
            $distribucion .= "<table border='1' width='100%'>";
            $distribucion .= "<thead><tr><th>Días</th>";
            if ($lunesn == 1) {
                $distribucion .= "<th>Lunes</th>";
            }
            if ($martesn == 1) {
                $distribucion .= "<th>Martes</th>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<th>Miercoles</th>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<th>Jueves</th>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<th>Viernes</th>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<th>Sabado</th>";
            }
            if ($domingon == 1) {
                $distribucion .= "<th>Domingo</th>";
            }
            
            $distribucion .= "</tr></thead><tbody><tr><td>Inicio</td>";
            if ($lunesn == 1) {
                $distribucion .= "<td>" . $lunesinicion . "</td>";
            }
            if ($martesn == 1) {
                $distribucion .= "<td>" . $martesinicion . "</td>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<td>" . $miercolesinicion . "</td>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<td>" . $juevesinicion . "</td>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<td>" . $viernesinicion . "</td>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<td>" . $sabadoinicion . "</td>";
            }
            if ($domingon == 1) {
                $distribucion .= "<td>" . $domingoinicion . "</td>";
            }
    
            $distribucion .= "</tr><tr><td>Fin</td>";
            if ($lunesn == 1) {
                $distribucion .= "<td>" . $lunesfinn . "</td>";
            }
            if ($martesn == 1) {
                $distribucion .= "<td>" . $martesfinn . "</td>";
            }
            if ($miercolesn == 1) {
                $distribucion .= "<td>" . $miercolesfinn . "</td>";
            }
            if ($juevesn == 1) {
                $distribucion .= "<td>" . $juevesfinn . "</td>";
            }
            if ($viernesn == 1) {
                $distribucion .= "<td>" . $viernesfinn . "</td>";
            }
            if ($sabadon == 1) {
                $distribucion .= "<td>" . $sabadofinn . "</td>";
            }
            if ($domingon == 1) {
                $distribucion .= "<td>" . $domingofinn . "</td>";
            }
            $distribucion .= "</tr></tbody></table>" . "<br>";
        }

        $exluido = $_POST['exluido'];
        if ($exluido == 1) {
            $rotativo = "";
            $distribucion = "<p>El trabajador se encuentra excluido de la limitación de jornada de trabajo conforme al Artículo 22 Inciso 2° del Código del Trabajo.</p>";
        }

        $zona = "<div style='width: 100%; display: flex; justify-content: center;'><h5>Zonas de Prestacion de Servicio</h5>";
        $zonaregion = $c->listarzonasregion($_SESSION['USER_ID']);
        $zonaprovincia = $c->listarzonaprovinciatrabajador($_SESSION['USER_ID']);
        $zonacomunas = $c->listarzonacomunatrabajador($_SESSION['USER_ID']);
        $territoriozona = $_POST['territoriozona'];
        if ($territoriozona == 1) {
            $zona .= "<div>";
            $zona .= "<p>El trabajador presta servicio en todo el territorio nacional</p>";
            $zona .= "</div>";
        } else {
            if (count($zonaregion) > 0) {
                $zona .= "<div>";
                $zona .= "<h6>Regiones de Prestacion de Servicio: </h6>";
                $zona .= "<ul>";
                foreach ($zonaregion as $zr) {
                    $zona .= "<li>" . $zr->getNombre() . "</li>";
                }
                $zona .= "</ul>";
                $zona .= "</div>";
            }

            if (count($zonaprovincia) > 0) {
                $zona .= "<div>";
                $zona .= "<h6>Provincias de Prestacion de Servicio: </h6>";
                $zona .= "<ul>";
                foreach ($zonaprovincia as $zp) {
                    $zona .= "<li>" . $zp->getNombre() . "</li>";
                }
                $zona .= "</ul>";
                $zona .= "</div>";
            }

            if (count($zonacomunas) > 0) {
                $zona .= "<div>";
                $zona .= "<h6>Comunas de Prestacion de Servicio: </h6>";
                $zona .= "<ul>";
                foreach ($zonacomunas as $zc) {
                    $zona .= "<li>" . $zc->getNombre() . "</li>";
                }
                $zona .= "</ul>";
                $zona .= "</div>";
            }

            if (count($zonaregion) == 0 && count($zonaprovincia) == 0 && count($zonacomunas) == 0) {
                $zona .= "<div>";
                $zona .= "<h6>El trabajador no posee zonas de prestacion de servicio</h6>";
                $zona .= "</div>";
            }
        }

        $zona .= "</div>";

        //Sacar la calle y numero de la direcciond e la empresa
        $numero = $emp->getNumero();
        //Extraer la letra de la direccion con todos los espacios en blanco
        $calle = $emp->getCalle() . " " . $emp->getVilla();
        $discapacidad = "El trabajador no posee discapacidad";
        $pensionado = "El trabajador no es pensionado";
        if ($tra->getDiscapacidad() == 1) {
            $discapacidad = "El trabajador posee discapacidad";
        }

        if ($tra->getPension() == 1) {
            $pensionado = "El trabajador es pensionado";
        }


        $departamentoespecifico = "";
        $badi =  $_POST['badi'];
        $otrter =  "";
        if ($badi == 1) {
            $otrter =  $_POST['otrter'];
        }

        $jornadaesc = $_POST['jornadaesc'];
        if ($jornadaesc == 1) {
            $jornadaesc = "La Empresa posee un sistema de jornada excepcional autorizado por la dirección de trabajo donde se estipulan los dias de Trabajo donde se estipulan los días de trabajo y descanso para la respectiva faena.";
        }

        $estadocivil = $tra->getCivil();
        switch ($estadocivil) {
            case 1:
                $estadocivil = "Soltero";
                break;
            case 2:
                $estadocivil = "Casado";
                break;
            case 3:
                $estadocivil = "Divorciado";
                break;
            case 4:
                $estadocivil = "Viudo";
                break;
        }


        $nacimiento = $tra->getNacimiento();
        //convertir fecha de nacimiento a formato dd/mm/yyyy
        $nacimiento = date("d/m/Y", strtotime($nacimiento));

        $swap_var = array(
            "{CATEGORIA_CONTRATO}" => $categoria_contrato,
            "{CEL_REGION}" => $regioncelebracion,
            "{CEL_COMUNA}" => $comunacelebracion,
            "{FECHA_CELEBRACION}" => $fechacelebracion,

            "{RUT_EMPRESA}" => $emp->getRut(),
            "{NOMBRE_EMPRESA}" => $emp->getRazonSocial(),
            "{REPRESENTANTE_LEGAL}" => $representante_legal,
            "{RUT_REPRESENTANTE_LEGAL}" => $rutrepresentantelegal,
            "{CORREO_EMPRESA}" => $emp->getEmail(),
            "{TELEFONO_EMPRESA}" => $emp->getTelefono(),
            "{CALLE_EMPRESA}" => $calle,
            "{NUMERO_EMPRESA}" => $numero,
            "{REGION_EMPRESA}" => $empresaregion,
            "{COMUNA_EMPRESA}" => $empresacomuna,
            "{CODIGO_ACTIVIDAD}" => $codigoactividadid,
            "{DEPT_EMPRESA}" => $emp->getDepartamento(),

            "{RUT_TRABAJADOR}" => $tra->getRut(),
            "{NOMBRE_TRABAJADOR}" => $tra->getNombre(),
            "{APELLIDO_1}" => $tra->getApellido1(),
            "{APELLIDO_2}" => $tra->getApellido2(),
            "{FECHA_NACIMIENTO}" => $nacimiento,
            "{SEXO}" => $tra->getSexo(),
            "{ESTADO_CIVIL}" => $estadocivil,
            "{NACIONALIDAD}" => $nacionalidad,
            "{CORREO_TRABAJADOR}" => $correotrabajador,
            "{TELEFONO_TRABAJADOR}" => $telefonotrabajador,
            "{REGION_TRABAJADOR}" => $trabajadorregion,
            "{COMUNA_TRABAJADOR}" => $trabajadorcomuna,
            "{CALLE_TRABAJADOR}" => $calletrabajador,
            "{NUMERO_CASA_TRABAJADOR}" => $numerotrabajador,
            "{DEPARTAMENTO_TRABAJADOR}" => $departamentotrabajador,
            "{DISCAPACIDAD" => $discapacidad,
            "{PENSION_INVALIDEZ}" => $pensionado,

            "{CENTRO_DE_COSTO}" => $centrocosto,
            "{CARGO}" => $Charge,
            "{DESCRIPCION_CARGO}" => $ChargeDescripcion,

            "{REGION_ESPECIFICA}" => $regionespecifica,
            "{COMUNA_ESPECIFICA}" => $comunaespecifica,
            "{CALLE_ESPECIFICA}" => $calleespecifica,
            "{NUMERO_CASA_ESPECIFICA}" => $numeroespecifica,
            "{DEPARTAMENTO_ESPECIFICO}" => $departamentoespecifico,

            "{ZONA_PRESTACION}" => $zona,

            "{RUT_EMPRESA_SUBCONTRATADA}" => $subcontratacionrut,
            "{NOMBRE_EMPRESA_SUBCONTRATADA}" => $subcontratacionrazonsocial,

            "{RUT_EMPRESA_TRANSITORIA}" => $transitoriosrut,
            "{NOMBRE_EMPRESA_TRANSITORIA}" => $transitoriosrazonsocial,

            "{SUELDO_BASE}" => $tiposueldo,
            "{SUELDO_MONTO}" => $sueldo,
            "{SUELDO_MONTO_LETRAS}" => $sueldoletras,
            "{ZONA_EXTREMA}" => "",

            "{GRATIFICACION_FORMA_PAGO}" => $formapago,
            "{PERIODO_GRATIFICACION}" => $periodopagogra,
            "{DETALLE_REMUNERACION_GRATIFICACION}" => $detallerenumeraciongra,

            "{PERIODO_PAGO}" => $periodopagot,
            "{FECHA_PAGO}" => $fechapagot,
            "{FORMA_PAGO}" => $formapagot,
            "{BANCO}" => $banco,
            "{TIPO_CUENTA}" => $tipocuenta,
            "{NUMERO_CUENTA}" => $numerocuenta,
            "{ANTICIPO}" => $anticipot,
            "{AFP}" => $prevision->getAfp(),
            "{SALUD}" => $prevision->getIsapre(),
            "{OTROS_PACTOS}" => $otrter,

            "{JORNADA_EXCEPCIONAL}" => $jornadaesc,
            "{NUMERO_RESOLUCION}" => $noresolucion,
            "{FECHA_RESOLUCION}" => $exfecha,

            "{TIPO_JORNADA}" => $tipojornada,
            "{DURACION_JORNADA_HORAS}" => $dias,
            "{DURACION_JORNADA_MENSUAL}" => $duracionjor,
            "{COLACION_MINUTOS}" => $colacion,
            "{COLACION_IMPUTABLES_MINUTOS}" => $colacionimp,
            "{ROTACION}" => $rotativo,

            "{DISTRIBUCION_JORNADA}" => $distribucion,
            "{TIPO_CONTRATO}" => $typecontract,
            "{INICIO_CONTRATO}" => $fecha_inicio,
            "{TERMINO_CONTRATO}" => $fecha_termino,
            "{ESTIPULACIONES}" => $estipulaciones
        );

        foreach (array_keys($swap_var) as $key) {
            $contenido = str_replace($key, $swap_var[$key], $contenido);
        }

        if ($conteo == 0) {
            $mpdf->title = 'Contrato de Trabajo';
            $mpdf->author = 'Wilkens Mompoint';
            $mpdf->creator = 'Wilkens Mompoint';
            $mpdf->subject = 'Contrato de Trabajo';
            $mpdf->keywords = 'Contrato, Trabajo, Empleo';
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($contenido);
        } else {
            $mpdf->AddPage();
            $mpdf->WriteHTML($contenido);
        }
        $conteo++;
    }


    $fecha = date('Ymdhis');
    //Generar nombre documento
    $nombre_documento = 'Contrato_' . $fecha . '.pdf';
    //Generar y guardar documento en la caperta uploads/Contratos
    $mpdf->Output('../../uploads/previa/' . $nombre_documento, 'F');
    //Imprimir ruta de documento
    echo "1previa/Contratos/" . $nombre_documento;
}
