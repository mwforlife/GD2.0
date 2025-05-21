<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();

if (isset($_SESSION['USER_ID']) && isset($_POST['finiquito']) && isset($_POST['tipocontratoid']) && isset($_POST['causal']) && isset($_POST['causalhechos']) && isset($_POST['comunicacion']) && isset($_POST['cotipre']) && isset($_POST['acreditacion']) && isset($_POST['fechanotificacion']) && isset($_POST['texto'])) {
    $usuario = $_SESSION['USER_ID'];
    $fechanotificacion = $_POST['fechanotificacion'];
    if ($fechanotificacion == "") {
        echo "Debe ingresar la fecha de notificacion";
        return;
    }
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechanotificacion = date("d/m/Y", strtotime($fechanotificacion));
    $finiquito = $_POST['finiquito'];
    if ($finiquito <= 0) {
        echo "Debe seleccionar un finiquito";
        return;
    }
    $finiquito = $c->buscarfiniquitotext($finiquito);
    $contrato = $c->buscarcontratoid($finiquito->getContrato());
    $tipocontratoid = $_POST['tipocontratoid'];
    if ($tipocontratoid == 0) {
        echo "Debe seleccionar un tipo de Documento";
        return;
    }
    $causal = $_POST['causal'];
    if ($causal <= 0) {
        echo "Debe seleccionar una causal";
        return;
    }
    $causalhechos = $_POST['causalhechos'];
    if ($causalhechos == "") {
        echo "Debe ingresar el causal de hechos";
        return;
    }
    $comunicacion = $_POST['comunicacion'];
    $comuna = "";
    if ($comunicacion == 2) {
        $comunicacion = "Carta Certificada";
        $comuna = $_POST['comuna'];
        if ($comuna <= 0) {
            echo "Debe seleccionar una comuna";
            return;
        }
        $comuna = $c->buscarcomuna($comuna);
        $comuna = $comuna->getNombre();
    } else {
        $comunicacion = "Personal";
    }
    $cotipre = $_POST['cotipre'];
    if (strlen($cotipre) <= 0) {
        echo "Debe ingresar la Informacion de Cotizaciones Previsionales";
        return;
    }

    $acreditacion = $_POST['acreditacion'];
    if (strlen($acreditacion) <= 0) {
        echo "Debe Elegir una opcion de Acreditacion de pago Previsional";
        return;
    }
    if ($acreditacion == 1) {
        $acreditacion = "Planilla Cotizaciones";
    } else if ($acreditacion == 2) {
        $acreditacion = "Certificado Cotizaciones";
    } else {
        $acreditacion = "No Corresponde Informar";
    }
    $texto = $_POST['texto'];
    if (strlen($texto) <= 0) {
        echo "Debe ingresar el texto de la notificacion";
        return;
    }
    if ($texto == 1) {
        $texto = $_POST['texto1'];
    } else if ($texto == 2) {
        $texto = $_POST['texto2'];
    }
    $trabajadorid = $finiquito->getTrabajador();
    $empresa = $finiquito->getEmpresa();
    $fechafiniquito = $finiquito->getFechafiniquito();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechafiniquito = date("d/m/Y", strtotime($fechafiniquito));
    $fechainicio = $finiquito->getFechainicio();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechainicio = date("d/m/Y", strtotime($fechainicio));
    $fechatermino = $finiquito->getFechatermino();
    //Cambiar formato de fecha a dd/mm/yyyy
    $fechatermino = date("d/m/Y", strtotime($fechatermino));


    $causal = $c->buscarcausalterminacioncontrato($causal);
    $causal = $causal->getNombre()." ".$causal->getArticulo()." ".$causal->getLetra();
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

    $repre = $c->BuscarRepresentanteLegalempresa($empresa->getId());
    $resum = $c->listarresumenfiniquitoids($usuario);

    $detfin = $c->listarresumenfiniquito($usuario);
    $detalle = "";
    $descuento = 0;
    $haber = 0;
    $saldo = 0;
    $detalle = $detalle . "<h4 style='text-align: center;'>Haberes</h4>";
    $detalle .= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
    foreach ($detfin as $df) {
        if ($df->getTipo() == 2) {
            $detalle = $detalle . "<tr>";
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse; width:75%;'>" . $df->getIndemnizacion() . " - " . $df->getDescripcion() . "</td>";
            $monto = $df->getMonto();
            //Redondear sin decimales
            $monto = round($monto, 0);
            $monto1 = number_format($monto, 0, ',', '.');
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $monto1 . "</td>";
            $detalle = $detalle . "</tr>";
            $haber = $haber + $monto;
        }
    }
    $detalle = $detalle . "<tr>";
    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL HABERES</td>";
    $haber1 = number_format($haber, 0, ',', '.');
    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $haber1 . "</td>";
    $detalle = $detalle . "</tr>";
    $detalle = $detalle . "</table>";

    $detalle = $detalle . "<h4 style='text-align: center;'>Descuentos</h4>";
    $detalle .= "<table style='width:100%; border: 1px solid black; border-collapse: collapse;'>";
    foreach ($detfin as $df) {
        if ($df->getTipo() == 1) {
            $detalle = $detalle . "<tr>";
            $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>" . $df->getIndemnizacion() . " - " . $df->getDescripcion() . "</td>";
            $monto = $df->getMonto();
            //Redondear sin decimales
            $monto = round($monto, 0);
            $monto1 = number_format($monto, 0, ',', '.');
            $detalle = $detalle .  "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $monto1 . "</td>";
            $detalle = $detalle . "</tr>";
            $descuento = $descuento + $df->getMonto();
        }
    }
    $detalle = $detalle . "<tr>";
    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL DESCUENTOS</td>";
    $descuento1 = number_format($descuento, 0, ',', '.');
    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $descuento1 . "</td>";
    $detalle = $detalle . "</tr>";
    $detalle = $detalle . "<tr>";
    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:75%;'>TOTAL A PAGAR</td>";
    $saldo = $haber - $descuento;
    $saldo1 = number_format($saldo, 0, ',', '.');
    $detalle = $detalle . "<td style='border: 1px solid black; border-collapse: collapse;width:25%;'>$ " . $saldo1 . "</td>";
    $detalle = $detalle . "</table>";



    $villa_empresa = $empresa->getVilla();
    if ($villa_empresa == "") {
        $villa_empresa = "";
    } else {
        $villa_empresa = $empresa->getVilla() . ", ";
    }

    $swap_var = array(
        "{CEL_COMUNA}" => $empresa->getComuna(),
        "{FECHA_FINIQUITO}" => $fechafiniquito,
        "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
        "{RUT_EMPRESA}" => $empresa->getRut(),
        "{REPRESENTANTE_LEGAL}" => $repre->getNombre() . " " . $repre->getApellido1() . " " . $repre->getApellido2(),
        "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut(),
        "{CALLE_EMPRESA}" => $empresa->getCalle(),
        "{VILLA_EMPRESA}," => $villa_empresa,
        "{NUMERO_EMPRESA}" => $empresa->getNumero(),
        "{DEPT_EMPRESA}" => $empresa->getDepartamento(),
        "{COMUNA_EMPRESA}" => $empresa->getComuna(),
        "{REGION_EMPRESA}" => $empresa->getRegion(),
        "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
        "{APELLIDO_1}" => $trabajador->getApellido1(),
        "{APELLIDO_2}" => $trabajador->getApellido2(),
        "{RUT_TRABAJADOR}" => $trabajador->getRut(),
        "{CALLE_TRABAJADOR}" => $dom->getCalle(),
        "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero(),
        "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento(),
        "{COMUNA_TRABAJADOR}" => $comunatra,
        "{REGION_TRABAJADOR}" => $regiontra,
        "{CARGO}" => $contrato->getCargo(),
        "{INICIO_CONTRATO}" => $fechainicio,
        "{TERMINO_CONTRATO}" => $fechatermino,
        "{CAUSAL_FINIQUITO}" => $causal,
        "{DETALLE_FINIQUITO}" => $detalle,
        "{FECHA_NOTIFICACION}" => $fechanotificacion,
        "{CAUSAL_DE_DERECHO}" => $causal,
        "{CAUSAL_DE_HECHOS}" => $causalhechos,
        "{COTIZACIONES_PREVISIONALES}" => $cotipre,
        "{FORMA_DE_COMUNICACION}" => $comunicacion,
        "{DOCUMENTACION_DE_ACREDITACION}" => $acreditacion,
    );

    foreach (array_keys($swap_var) as $key) {
        $texto = str_replace($key, $swap_var[$key], $texto);
    }

    $swap_var = array(
        "{CEL_COMUNA}" => $empresa->getComuna(),
        "{FECHA_FINIQUITO}" => $fechafiniquito,
        "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
        "{RUT_EMPRESA}" => $empresa->getRut(),
        "{REPRESENTANTE_LEGAL}" => $repre->getNombre() . " " . $repre->getApellido1() . " " . $repre->getApellido2(),
        "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut(),
        "{CALLE_EMPRESA}" => $empresa->getCalle(),
        "{VILLA_EMPRESA}" => $empresa->getVilla(),
        "{NUMERO_EMPRESA}" => $empresa->getNumero(),
        "{DEPT_EMPRESA}" => $empresa->getDepartamento(),
        "{COMUNA_EMPRESA}" => $empresa->getComuna(),
        "{REGION_EMPRESA}" => $empresa->getRegion(),
        "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
        "{APELLIDO_1}" => $trabajador->getApellido1(),
        "{APELLIDO_2}" => $trabajador->getApellido2(),
        "{RUT_TRABAJADOR}" => $trabajador->getRut(),
        "{CALLE_TRABAJADOR}" => $dom->getCalle(),
        "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero(),
        "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento(),
        "{COMUNA_TRABAJADOR}" => $comunatra,
        "{REGION_TRABAJADOR}" => $regiontra,
        "{CARGO}" => $contrato->getCargo(),
        "{INICIO_CONTRATO}" => $fechainicio,
        "{TERMINO_CONTRATO}" => $fechatermino,
        "{CAUSAL_FINIQUITO}" => $causal,
        "{DETALLE_FINIQUITO}" => $detalle,
        "{FECHA_NOTIFICACION}" => $fechanotificacion,
        "{CAUSAL_DE_DERECHO}" => $causal,
        "{CAUSAL_DE_HECHOS}" => $causalhechos,
        "{COTIZACIONES_PREVISIONALES}" => $cotipre,
        "{FORMA_DE_COMUNICACION}" => $comunicacion,
        "{DOCUMENTACION_DE_ACREDITACION}" => $acreditacion,
        "{DISPOSICION_Y_PAGO}" => $texto
    );
    $contenido = $c->buscarplantilla($tipocontratoid);

    foreach (array_keys($swap_var) as $key) {
        $contenido = str_replace($key, $swap_var[$key], $contenido);
    }


    $mpdf = new \Mpdf\Mpdf();
    $mpdf->title = 'Notificacion de Termino de Contrato Laboralr';
    $mpdf->author = 'KaiserTech - Gestor de Documentos';
    $mpdf->creator = 'WilkensTech';
    $mpdf->subject = 'Notificacion de Termino de Contrato Laboralr';
    $mpdf->keywords = 'Notificacion de Termino de Contrato Laboralr';
    $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.iustax.cl</div>');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($contenido);
    $fecha = date('Ymdhis');
    //Generar nombre documento
    //Cambiar formato Fechainicio
    $fechanotificacion = date("Ymdhis");

    $nombre_documento = 'Notificacion_' . $fechanotificacion . '.pdf';
    //Carpeta para guardar
    $carpeta = "../previa/";
    //Generar archivo y guardar en carpeta
    $mpdf->Output($carpeta . $nombre_documento, 'F');
    echo 1;
    echo "php/previa/" . $nombre_documento;
}
