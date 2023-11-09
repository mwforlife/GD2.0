<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';
$c = new Controller();
session_start();
if (isset($_GET['code'])) {
    $vaca = $c->buscarvacacion($_GET['code']);
    if ($vaca == false) {
        echo "No se encontro el registro";
    } else {
        $representante = $c->BuscarRepresentanteLegal1($_SESSION['CURRENT_ENTERPRISE']);
        $empresa = $c->buscarEmpresavalor2($_SESSION['CURRENT_ENTERPRISE']);
        $trabajador = $c->buscartrabajador($vaca->getTrabajador());
        $total = $vaca->getDiasacumulados() + $vaca->getDiasprogesivas();
        $diashabiles = $vaca->getDiashabiles();
        $diasinhabiles = $vaca->getDiasinhabiles();
        $diasferiados = $vaca->getDiasferiados();
        $totales = $vaca->getTotales();
        $diasrestantes = $vaca->getDiasrestantes();
        $observasion = $vaca->getObservacion();
        $fechacomprobante = $vaca->getRegistro();


        $fecha_inicio = $vaca->getFechaInicio();
        $fecha_termino = $vaca->getFechaTermino();
        $fecha_inicio = date("d-m-Y", strtotime($fecha_inicio));
        $fecha_termino = date("d-m-Y", strtotime($fecha_termino));
        $periodoinicio = $vaca->getPeriodoinicio();
        $periodotermino = $vaca->getPeriodotermino();
        $periodoiniciomes = date("m", strtotime($periodoinicio));
        $periodoinicioano = date("Y", strtotime($periodoinicio));
        $periodoterminomes = date("m", strtotime($periodotermino));
        $periodoterminoano = date("Y", strtotime($periodotermino));

        switch ($periodoiniciomes) {
            case 1:
                $periodoiniciomes = "Enero";
                break;
            case 2:
                $periodoiniciomes = "Febrero";
                break;
            case 3:
                $periodoiniciomes = "Marzo";
                break;
            case 4:
                $periodoiniciomes = "Abril";
                break;
            case 5:
                $periodoiniciomes = "Mayo";
                break;
            case 6:
                $periodoiniciomes = "Junio";
                break;
            case 7:
                $periodoiniciomes = "Julio";
                break;
            case 8:
                $periodoiniciomes = "Agosto";
                break;
            case 9:
                $periodoiniciomes = "Septiembre";
                break;
            case 10:
                $periodoiniciomes = "Octubre";
                break;
            case 11:
                $periodoiniciomes = "Noviembre";
                break;
            case 12:
                $periodoiniciomes = "Diciembre";
                break;
        }

        switch ($periodoterminomes) {
            case 1:
                $periodoterminomes = "Enero";
                break;
            case 2:
                $periodoterminomes = "Febrero";
                break;
            case 3:
                $periodoterminomes = "Marzo";
                break;
            case 4:
                $periodoterminomes = "Abril";
                break;
            case 5:
                $periodoterminomes = "Mayo";
                break;
            case 6:
                $periodoterminomes = "Junio";
                break;
            case 7:
                $periodoterminomes = "Julio";
                break;
            case 8:
                $periodoterminomes = "Agosto";
                break;
            case 9:
                $periodoterminomes = "Septiembre";
                break;
            case 10:
                $periodoterminomes = "Octubre";
                break;
            case 11:
                $periodoterminomes = "Noviembre";
                break;
            case 12:
                $periodoterminomes = "Diciembre";
                break;
        }
        
        $periodoinicio = $periodoiniciomes . " " . $periodoinicioano;
        $periodotermino = $periodoterminomes . " " . $periodoterminoano;

        $swap_var = array(
            "{NUMERO_COMPROBANTE}" => $vaca->getId(),
            "{FECHA_COMPROBANTE}" => date("d-m-Y", strtotime($vaca->getRegistro())),
            "{REPRESENTANTE_LEGAL}" => $representante->getNombre() . " " . $representante->getApellido1() . " " . $representante->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $representante->getRut(),
            "{CALLE_EMPRESA}" => $empresa->getCalle(),
            "{NUMERO_EMPRESA}" => $empresa->getNumero(),
            "{COMUNA_EMPRESA}" => $empresa->getComuna(),
            "{REGION_EMPRESA}" => $empresa->getRegion(),
            "{PERIODO_VACACIONES}" => $vaca->getPeriodoinicio() . " - " . $vaca->getPeriodotermino(),
            "{FECHA_INICIO_VACACIONES}" => $fecha_inicio,
            "{FECHA_TERMINO_VACACIONES}" => $fecha_termino,
            "{DIAS_VACACIONES}" => $diashabiles,
            "{OBSERVACIONES_VACACIONES}" => $vaca->getObservacion(),
            "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
            "{APELLIDO_1}" => $trabajador->getApellido1(),
            "{APELLIDO_2}" => $trabajador->getApellido2(),
            "{RUT_TRABAJADOR}" => $trabajador->getRut(),
            "{INICIO_PERIODO_VACACIONES}" => $periodoinicio,
            "{TERMINO_PERIODO_VACACIONES}" => $periodotermino . " : ".$diashabiles . " día(s) hábil(es)",
            "{TOTAL_DIAS_VACACIONES}" => $totales,
            "{DIAS_HABILES_RESTANTES}" => $diasrestantes
        );

        $contenido = $c->buscarplantilla($vaca->getTipoDocumento());

        foreach (array_keys($swap_var) as $key) {
            $contenido = str_replace($key, $swap_var[$key], $contenido);
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->title = 'Comprobante de Vacaciones';
        $mpdf->author = 'Wilkens Mompoint';
        $mpdf->creator = 'Wilkens Mompoint';
        $mpdf->subject = 'Comprobante de Vacaciones';
        $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.iustax.cl</div>');
        $mpdf->keywords = 'Comprobante de Vacaciones';
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($contenido);
        $fecha = date('Ymdhis');
        //Generar nombre documento
        $nombre_documento = 'Comprobante_Vacaciones' . $vaca->getFechaInicio() . "_" . $vaca->getFechaTermino() . '.pdf';
        //Generar e imprimir documento
        $mpdf->Output($nombre_documento, 'I');
    }
}
