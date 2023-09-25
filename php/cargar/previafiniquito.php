<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();

if (isset($_SESSION['USER_ID']) && isset($_POST['contrato']) && isset($_POST['tipocontratoid']) && isset($_POST['trabajadorid'])  && isset($_POST['empresa']) && isset($_POST['fechafiniquito']) && isset($_POST['fechainicio']) && isset($_POST['fechatermino']) && isset($_POST['causal']) && isset($_POST['descripcion']) && isset($_POST['monto'])) {
    $usuario = $_SESSION['USER_ID'];
    $contrato = $_POST['contrato'];
    if($contrato==0){
        echo "Debe seleccionar un contrato";
        return;
    }
    $tipocontratoid = $_POST['tipocontratoid'];
    if($tipocontratoid==0){
        echo "Debe seleccionar un tipo de Documento";
        return;
    }
    $trabajadorid = $_POST['trabajadorid'];
    if($trabajadorid==0){
        echo "Debe seleccionar un trabajador";
        return;
    }
    $empresa = $_POST['empresa'];
    if($empresa==0){
        echo "Debe seleccionar una empresa";
        return;
    }
    $fechafiniquito = $_POST['fechafiniquito'];
    if($fechafiniquito==""){
        echo "Debe ingresar una fecha de finiquito";
        return;
    }
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechafiniquito = date("d/m/Y", strtotime($fechafiniquito));
    $fechainicio = $_POST['fechainicio'];
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechainicio = date("d/m/Y", strtotime($fechainicio));
    $fechatermino = $_POST['fechatermino'];
    if($fechatermino==""){
        echo "Debe ingresar una fecha de termino";
        return;
    }
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechatermino = date("d/m/Y", strtotime($fechatermino));
    $causal = $_POST['causal'];
    if($causal<=0){
        echo "Debe seleccionar una causal";
        return;
    }
    $causal = $c->buscarcausalterminacioncontrato($causal);
    $causal = $causal->getNombre();
    $trabajador = $c->buscartrabajador($trabajadorid);
    $dom = $c->ultimodomicilio($trabajadorid);
    $comunatra = $c->buscarcomuna($dom->getComuna());
    $comunatra = $comunatra->getNombre();
    $regiontra = $dom->getRegion();
    $regiontra = $c->buscarregion($regiontra);
    $regiontra = $regiontra->getNombre();

    $empresa = $c->buscarempresa($empresa);
    $comuna = $empresa->getComuna();
    $region = $empresa->getRegion();

    $contrato = $c->buscarcontratoid($contrato);
    $repre = $c->BuscarRepresentanteLegal1($empresa->getId());
    $resum = $c->listarresumenfiniquitoids($usuario);
    
    $detfin = $c->listarresumenfiniquito($usuario);
        $detalle = "";
        $descuento =0;
        $haber = 0;
        $saldo = 0;
        $detalle = $detalle . "<h4 style='text-align: center;'>Haberes</h4>";
        $detalle.= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
        foreach ($detfin as $df) {
            if($df->getTipo()==2){
                $detalle = $detalle . "<tr>";
                $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse; width:75%;'>" . $df->getIndemnizacion()." - ".$df->getDescripcion() . "</td>";
                $monto = $df->getMonto();
                //Redondear sin decimales
                $monto = round($monto, 0);
                $monto1 = number_format($monto, 0, ',', '.');
                $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $monto1 . "</td>";
                $detalle = $detalle . "</tr>";
                $haber = $haber + $monto;
            }
        }
        $detalle = $detalle. "<tr>";
        $detalle = $detalle. "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL HABERES</td>";
        $haber1 = number_format($haber, 0, ',', '.');
        $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $haber1 . "</td>";
        $detalle = $detalle. "</tr>";
        $detalle = $detalle . "</table>";

        $detalle = $detalle . "<h4 style='text-align: center;'>Descuentos</h4>";
        $detalle.= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
        foreach ($detfin as $df) {
            if($df->getTipo()==1){
                $detalle = $detalle . "<tr>";
                $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>" . $df->getIndemnizacion()." - ".$df->getDescripcion() . "</td>";
                $monto = $df->getMonto();
                //Redondear sin decimales
                $monto = round($monto, 0);
                $monto1 = number_format($monto, 0, ',', '.');
                $detalle = $detalle .  "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $monto1 . "</td>";
                $detalle = $detalle . "</tr>";
                $descuento = $descuento + $df->getMonto();
            }
        }
        $detalle = $detalle. "<tr>";
        $detalle = $detalle. "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL DESCUENTOS</td>";
        $descuento1 = number_format($descuento, 0, ',', '.');
        $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $descuento1 . "</td>";
        $detalle = $detalle. "</tr>";
        $detalle = $detalle . "<tr>";
        $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL A PAGAR</td>";
        $saldo = $haber - $descuento;
        $saldo1 = number_format($saldo, 0, ',', '.');
        $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $saldo1 . "</td>";
        $detalle = $detalle . "</table>";


        $nacionalidad = $c->buscarnacionalidad($trabajador->getNacionalidad());
        $estadocivil = $c->buscarestadocivil($trabajador->getCivil());
        $cuentabancaria = $c->ultimacuentabancariaregistrada1($trabajador->getId());
        $contact = $c->buscarcontacto($_POST['trabajadorid']);

        $tipocuenta = "No Registrada";
        $numerocuenta = "No Registrada";
        $banco = "No Registrada";
        if($cuentabancaria!=false){
            $tipocuenta = $cuentabancaria->getTipo();
            $numerocuenta = $cuentabancaria->getNumero();
            $banco = $cuentabancaria->getBanco();
        }else{
            $tipocuenta = "CuentaRut";
            //Numero de cuenta es igual al RUt del trabajar sin punto ni guion ni digito verificador
            $numerocuenta = str_replace(".", "", $trabajador->getRut());
            $numerocuenta = str_replace("-", "", $numerocuenta);
            $numerocuenta = substr($numerocuenta, 0, -1);
            $banco = "BancoEstado";
        }


        
    
    $swap_var = array(
        "{FECHA_FINIQUITO}" => $fechafiniquito,
            "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
            "{RUT_EMPRESA}" => $empresa->getRut(),
            "{REPRESENTANTE_LEGAL}" => $repre->getNombre() . " " . $repre->getApellido1() . " " . $repre->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut(),
            "{CALLE_EMPRESA}" => $empresa->getCalle(),
            "{TELEFONO_EMPRESA}" => $empresa->getTelefono(),
            "{CORREO_EMPRESA}" => $empresa->getEmail(),
            "{NUMERO_EMPRESA}" => $empresa->getNumero(),
            "{FECHA_NACIMIENTO}" => $trabajador->getNacimiento(),
            "{DEPT_EMPRESA}" => $empresa->getDepartamento(),
            "{COMUNA_EMPRESA}" => $empresa->getComuna(),
            "{CEL_COMUNA}" => $empresa->getComuna(),
            "{REGION_EMPRESA}" => $empresa->getRegion(),
            "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
            "{APELLIDO_1}" => $trabajador->getApellido1(),
            "{APELLIDO_2}" => $trabajador->getApellido2(),
            "{CORREO_TRABAJADOR}" => $contact->getCorreo(),
            "{TELEFONO_TRABAJADOR}" => $contact->getTelefono(),
            "{RUT_TRABAJADOR}" => $trabajador->getRut(),
            "{CALLE_TRABAJADOR}" => $dom->getCalle(),
            "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero(),
            "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento(),
            "{COMUNA_TRABAJADOR}" => $comunatra,
            "{REGION_TRABAJADOR}" => $regiontra,
            "{NACIONALIDAD}" => $nacionalidad->getNombre(),
            "{ESTADO_CIVIL}" => $estadocivil->getNombre(),
            "{CARGO}" => $contrato->getCargo(),
            "{INICIO_CONTRATO}" => $fechainicio,
            "{TERMINO_CONTRATO}" => $fechatermino,
            "{CAUSAL_FINIQUITO}" => $causal,
            "{DETALLE_FINIQUITO}" => $detalle,
            "{FORMA_PAGO}" => "Transferencia Electrónica",
            "{TIPO_CUENTA}" => $tipocuenta,
            "{NUMERO_CUENTA}" => $numerocuenta,
            "{BANCO}" => $banco
    );

    $contenido = $c->buscarplantilla($tipocontratoid);

    foreach (array_keys($swap_var) as $key) {
        $contenido = str_replace($key, $swap_var[$key], $contenido);
    }

    $mpdf = new \Mpdf\Mpdf();
        $mpdf->title = 'Finiquito del Trabajador';
        $mpdf->author = 'KaiserTech - Gestor de Documentos';
        $mpdf->creator = 'WilkensTech';
        $mpdf->subject = 'Finiquito del Trabajador';
        $mpdf->keywords = 'Finiquito del Trabajador';
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($contenido);
        $fecha = date('Ymdhis');
        //Generar nombre documento
        //Cambiar formato Fechainicio
    $fechainicio = date("Y-m-d", strtotime($fechainicio));
        
        $nombre_documento = 'Finiquito' . $fechainicio . '.pdf';
        //Carpeta para guardar
        $carpeta = "../previa/";
        //Generar archivo y guardar en carpeta
        $mpdf->Output($carpeta . $nombre_documento, 'F');
        echo 1;
        echo "php/previa/" . $nombre_documento;
}