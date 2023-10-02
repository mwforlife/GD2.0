<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();


if (isset($_SESSION['USER_ID'])  && isset($_POST['empresa']) && isset($_POST['clausulas']) && isset($_POST['fechageneracion'])){
    $usuario = $_SESSION['USER_ID'];
    $lista = $c->buscarloteanexo($usuario);
    if (count($lista) == 0) {
        echo "Debe seleccionar al menos un contrato";
        return;
    }
    $fechaanexo = $_POST['fechageneracion'];
    $tipocontratoid = $_POST['tipocontratoid'];
    if ($tipocontratoid == 0) {
        echo "Debe seleccionar un tipo de Documento";
        return;
    }

    $empresa = $_POST['empresa'];
    if ($empresa == 0) {
        echo "Debe seleccionar una empresa";
        return;
    }
    $empresa = $c->buscarempresa($empresa);
    $comuna = $empresa->getComuna();
    $region = $empresa->getRegion();

    $repre = $c->BuscarRepresentanteLegalempresa($empresa->getId());
    $mpdf = new \Mpdf\Mpdf();
    foreach ($lista as $object) {
        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        //Cambiar formato de fecha a dd/mm/yyyy
        $fechainicio = date("d/m/Y", strtotime($fechainicio));
        $trabajadorid = $contrato->getFecharegistro();
        $trabajador = $c->buscartrabajador($trabajadorid);
        $dom = $c->ultimodomicilio($trabajadorid);
        $comunatra = $c->buscarcomuna($dom->getComuna());
        $comunatra = $comunatra->getNombre();
        $regiontra = $dom->getRegion();
        $regiontra = $c->buscarregion($regiontra);
        $regiontra = $regiontra->getNombre();

        $nacionalidad = $c->buscarnacionalidad($trabajador->getNacionalidad());
        $estadocivil = $c->buscarestadocivil($trabajador->getCivil());
        $cuentabancaria = $c->ultimacuentabancariaregistrada1($trabajador->getId());
        $contact = $c->buscarcontacto($trabajador->getId());

        $tipocuenta = "No Registrada";
        $numerocuenta = "No Registrada";
        $banco = "No Registrada";
        if ($cuentabancaria != false) {
            $tipocuenta = $cuentabancaria->getTipo();
            $numerocuenta = $cuentabancaria->getNumero();
            $banco = $cuentabancaria->getBanco();
        } else {
            $tipocuenta = "CuentaRut";
            //Numero de cuenta es igual al RUt del trabajar sin punto ni guion ni digito verificador
            $numerocuenta = str_replace(".", "", $trabajador->getRut());
            $numerocuenta = str_replace("-", "", $numerocuenta);
            $numerocuenta = substr($numerocuenta, 0, -1);
            $banco = "BancoEstado";
        }




        $swap_var = array(
            "{FECHA_anexo}" => $fechaanexo,
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
            "{CAUSAL_anexo}" => $causal,
            "{DETALLE_anexo}" => $detalle,
            "{FORMA_PAGO}" => "Transferencia Electrónica",
            "{TIPO_CUENTA}" => $tipocuenta,
            "{NUMERO_CUENTA}" => $numerocuenta,
            "{BANCO}" => $banco
        );

        $contenido = $c->buscarplantilla($tipocontratoid);

        foreach (array_keys($swap_var) as $key) {
            $contenido = str_replace($key, $swap_var[$key], $contenido);
        }

        $mpdf->title = 'anexo del Trabajador';
        $mpdf->author = 'KaiserTech - Gestor de Documentos';
        $mpdf->creator = 'WilkensTech';
        $mpdf->subject = 'anexo del Trabajador';
        $mpdf->keywords = 'anexo del Trabajador';
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($contenido);
        //Agregar pagina
        $mpdf->AddPage();
    }

    $fecha = date('Ymdhis');

    $nombre_documento = 'anexo' . $fecha . '.pdf';
    //Carpeta para guardar
    $carpeta = "../previa/";
    //Generar archivo y guardar en carpeta
    $mpdf->Output($carpeta . $nombre_documento, 'F');
    echo 1;
    echo "php/previa/" . $nombre_documento;
} else {
    echo "No LLegaron todos los datos";
}
