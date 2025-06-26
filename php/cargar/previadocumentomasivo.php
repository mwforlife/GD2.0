<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();

if (isset($_SESSION['USER_ID']) && isset($_POST['tipocontratoid'])  && isset($_POST['empresa']) && isset($_POST['fechageneracion'])) {
    $usuario = $_SESSION['USER_ID'];
    $lista = $c->buscarlotefiniquito($usuario);
    
    if (count($lista) == 0) {
        echo "Debe seleccionar al menos un contrato";
        return;
    }
    
    $tipocontratoid = $_POST['tipocontratoid'];
    if ($tipocontratoid == 0) {
        echo "Debe seleccionar un tipo de Documento";
        return;
    }
    
    $empresa = $_POST['empresa'];
    $fechageneracion = $_POST['fechageneracion'];
    
    if ($fechageneracion == "") {
        echo "Debe ingresar una fecha de generación";
        return;
    }
    
    if ($empresa == 0) {
        echo "Debe seleccionar una empresa";
        return;
    }
    
    $codigo = $c->buscarCodigoActividad($empresa);
    if ($codigo == null) {
        $codigo = "No definido";
    } else {
        $codigo = $codigo->getCodigosii() . " - " . $codigo->getNombre();
    }

    $empresa = $c->buscarempresa($empresa);
    $rutempresa = $empresa->getRut();
    $nombreempresa = $empresa->getRazonSocial();
    $comuna = $empresa->getComuna();
    $region = $empresa->getRegion();
    $repre = $c->BuscarRepresentanteLegalempresa($empresa->getId());

    // Configuración de mPDF para tamaño oficio (21.6 x 35.6 cm)
    $config = [
        'mode' => 'utf-8',
        'format' => [216, 356], // Tamaño en milímetros: 21.6 x 35.6 cm
        'orientation' => 'P', // Portrait (vertical)
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 16,
        'margin_bottom' => 16,
        'margin_header' => 9,
        'margin_footer' => 9,
        'default_font_size' => 12,
        'default_font' => 'Arial'
    ];
    
    $mpdf = new \Mpdf\Mpdf($config);
    
    // Configuración adicional del PDF
    $mpdf->SetTitle('Documento');
    $mpdf->SetAuthor('Iustax - Gestor de Documentos');
    $mpdf->SetSubject('Documento');
    $mpdf->SetKeywords('Documento');
    $mpdf->SetDisplayMode('fullpage');

    foreach ($lista as $object) {
        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        
        // Cambiar formato de fecha a dd/mm/yyyy
        $fechainicio = date("d-m-Y", strtotime($fechainicio));
        $trabajadorid = $contrato->getFecharegistro();
        $trabajador = $c->buscartrabajadortext($trabajadorid);
        $dom = $c->ultimodomicilio($trabajadorid);
        $con = $c->ultimocontacto($trabajadorid);
        $comunatra = $c->buscarcomuna($dom->getComuna());
        $comunatra = $comunatra->getNombre();
        $regiontra = $dom->getRegion();
        $regiontra = $c->buscarregion($regiontra);
        $regiontra = $regiontra->getNombre();

        // Variables de reemplazo mejoradas con validación
        $swap_var = array(
            "{RUT_EMPRESA}" => $empresa->getRut() ?? '',
            "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial() ?? '',
            "{REPRESENTANTE_LEGAL}" => trim(($repre->getNombre() ?? '') . " " . ($repre->getApellido1() ?? '') . " " . ($repre->getApellido2() ?? '')),
            "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut() ?? '',
            "{CEL_COMUNA}" => $empresa->getComuna() ?? '',
            "{FECHA_CELEBRACION}" => date("d-m-Y", strtotime($fechageneracion)),
            "{CALLE_EMPRESA}" => $empresa->getCalle() ?? '',
            "{VILLA_EMPRESA}" => $empresa->getVilla() ?? '',
            "{NUMERO_EMPRESA}" => $empresa->getNumero() ?? '',
            "{DEPT_EMPRESA}" => $empresa->getDepartamento() ?? '',
            "{COMUNA_EMPRESA}" => $empresa->getComuna() ?? '',
            "{REGION_EMPRESA}" => $empresa->getRegion() ?? '',
            "{TELEFONO_EMPRESA}" => $empresa->getTelefono() ?? '',
            "{CORREO_EMPRESA}" => $empresa->getEmail() ?? '',
            "{RUT_TRABAJADOR}" => $trabajador->getRut() ?? '',
            "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre() ?? '',
            "{APELLIDO_1}" => $trabajador->getApellido1() ?? '',
            "{APELLIDO_2}" => $trabajador->getApellido2() ?? '',
            // Fecha de nacimiento en formato dd/mm/aaaa con validación
            "{FECHA_NACIMIENTO}" => $trabajador->getNacimiento() ? date("d-m-Y", strtotime($trabajador->getNacimiento())) : '',
            "{CALLE_TRABAJADOR}" => $dom->getCalle() ?? '',
            "{VILLA_TRABAJADOR}" => $dom->getVilla() ?? '',
            "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero() ?? '',
            "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento() ?? '',
            "{COMUNA_TRABAJADOR}" => $comunatra ?? '',
            "{REGION_TRABAJADOR}" => $regiontra ?? '',
            "{DISCAPACIDAD}" => $trabajador->getDiscapacidad() ?? '',
            "{PENSION_INVALIDEZ}" => $trabajador->getPension() ?? '',
            "{CODIGO_ACTIVIDAD}" => $codigo,
            "{SEXO}" => $trabajador->getSexo() ?? '',
            "{NACIONALIDAD}" => $trabajador->getNacionalidad() ?? '',
            "{ESTADO_CIVIL}" => $trabajador->getCivil() ?? '',
            "{CORREO_TRABAJADOR}" => $con->getCorreo() ?? '',
            "{TELEFONO_TRABAJADOR}" => $con->getTelefono() ?? '',
            "{CARGO}" => $contrato->getCargo() ?? '',
            "{FECHA_GENERACION}" => date("d-m-Y", strtotime($fechageneracion)),
            "{FECHA_INICIO}" => $fechainicio
        );

        $contenido = $c->buscarplantilla($tipocontratoid);

        // Reemplazo de variables en el contenido
        foreach (array_keys($swap_var) as $key) {
            $contenido = str_replace($key, $swap_var[$key], $contenido);
        }

        // Agregar nueva página para cada documento
        $mpdf->AddPage();
        
        // Escribir el contenido HTML
        $mpdf->WriteHTML($contenido);
    }
    
    // Generar nombre del documento con timestamp
    $fecha = date('Ymdhis');
    $nombre_documento = 'Documento_' . $fecha . '.pdf';
    
    // Carpeta para guardar
    $carpeta = "../previa/";
    
    // Crear directorio si no existe
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0755, true);
    }
    
    // Generar archivo y guardar en carpeta
    $mpdf->Output($carpeta . $nombre_documento, 'F');
    
    // Respuesta exitosa
    echo "1php/previa/" . $nombre_documento;
    
} else {
    echo "Error: Faltan parámetros requeridos";
}
?>