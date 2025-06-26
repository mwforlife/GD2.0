<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();

if (isset($_SESSION['USER_ID']) && isset($_POST['tipocontratoid'])  && isset($_POST['empresa']) && isset($_POST['fechageneracion'])) {
    $usuario = $_SESSION['USER_ID'];
    $lista = $c->buscarlotefiniquito($usuario);
    if (count($lista) == 0) {
        echo "Debe seleccionar al menos un contrato de trabajo";
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
    $val2 = $empresa;
    $codigo = $c->buscarCodigoActividad($empresa);
    if ($codigo == null) {
        $codigo = "No definido";
    } else {
        $codigo = $codigo->getCodigosii() . " - " . $codigo->getNombre();
    }

    $empresa = $c->buscarempresa($empresa);

    $villa_empresa = $empresa->getVilla();
    if ($villa_empresa == "") {
        $villa_empresa = "";
    } else {
        $villa_empresa = $empresa->getVilla() . ", ";
    }

    foreach ($lista as $object) {
        $val3 = $tipocontratoid;
        $val4 = $fechageneracion;
        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        //Cambiar formato de fecha a dd/mm/yyyy
        $fechainicio = date("d/m/Y", strtotime($fechainicio));
        $trabajadorid = $contrato->getFecharegistro();
        $val1 = $trabajadorid;
        $trabajador = $c->buscartrabajadortext($trabajadorid);

        $rutempresa = $empresa->getRut();
        $nombreempresa = $empresa->getRazonSocial();

        $comuna = $empresa->getComuna();
        $region = $empresa->getRegion();
        $repre = $c->BuscarRepresentanteLegalempresa($empresa->getId());
        $dom = $c->ultimodomicilio($trabajadorid);
        $con = $c->ultimocontacto($trabajadorid);
        $comunatra = $c->buscarcomuna($dom->getComuna());
        $comunatra = $comunatra->getNombre();
        $regiontra = $dom->getRegion();
        $regiontra = $c->buscarregion($regiontra);
        $regiontra = $regiontra->getNombre();

        $swap_var = array(
            "{CEL_COMUNA}" => $empresa->getComuna(),
            "{FECHA_CELEBRACION}" => date("d-m-Y", strtotime($fechageneracion)),
            "{RUT_EMPRESA}" => $empresa->getRut(),
            "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
            "{REPRESENTANTE_LEGAL}" => $repre->getNombre() . " " . $repre->getApellido1() . " " . $repre->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut(),
            "{CALLE_EMPRESA}" => $empresa->getCalle(),
            "{NUMERO_EMPRESA}" => $empresa->getNumero(),
            "{VILLA_EMPRESA}," => $villa_empresa,
            "{DEPT_EMPRESA}" => $empresa->getDepartamento(),
            "{COMUNA_EMPRESA}" => $empresa->getComuna(),
            "{REGION_EMPRESA}" => $empresa->getRegion(),
            "{TELEFONO_EMPRESA}" => $empresa->getTelefono(),
            "{CORREO_EMPRESA}" => $empresa->getEmail(),
            "{RUT_TRABAJADOR}" => $trabajador->getRut(),
            "{NOMBRE_TRABAJADOR}" => $trabajador->getNombre(),
            "{APELLIDO_1}" => $trabajador->getApellido1(),
            "{APELLIDO_2}" => $trabajador->getApellido2(),
            //Fecha de nacimiento en formato dd-mm-aaaa
            "{FECHA_NACIMIENTO}" => date("d-m-Y", strtotime($trabajador->getNacimiento())),
            "{CALLE_TRABAJADOR}" => $dom->getCalle(),
            "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero(),
            "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento(),
            "{COMUNA_TRABAJADOR}" => $comunatra,
            "{REGION_TRABAJADOR}" => $regiontra,
            "{DISCAPACIDAD}" => $trabajador->getDiscapacidad(),
            "{PENSION_INVALIDEZ}" => $trabajador->getPension(),
            "{CODIGO_ACTIVIDAD}" => $codigo,
            "{SEXO}" => $trabajador->getSexo(),
            "{NACIONALIDAD}" => $trabajador->getNacionalidad(),
            "{ESTADO_CIVIL}" => $trabajador->getCivil(),
            "{CORREO_TRABAJADOR}" => $con->getCorreo(),
            "{TELEFONO_TRABAJADOR}" => $con->getTelefono(),
            "{CARGO}" => $contrato->getCargo(),
            "{FECHA_GENERACION}" => date("d-m-Y", strtotime($fechageneracion))
        );


        $contenido = $c->buscarplantilla($tipocontratoid);

        foreach (array_keys($swap_var) as $key) {
            $contenido = str_replace($key, $swap_var[$key], $contenido);
        }

        $mpdf = new \Mpdf\Mpdf(['format' => [216, 356]]);
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

        $nombre_documento = 'Documento_' . $fecha . '.pdf';
        //Carpeta para guardar
        $carpeta = "../../uploads/documentos/";
        //Generar archivo y guardar en carpeta
        $mpdf->Output($carpeta . $nombre_documento, 'F');
        $result = $c->registrardocumento($val1, $val2, $contrato->getId(), $val3, $val4, $nombre_documento);
        //Esperar 1 segundo para que se guarde el archivo
        sleep(1);
    }
    $sql = "delete from resumenfiniquito where usuario = $usuario;";
    $result = $c->query($sql);
    $c->eliminartodolotefiniquito($usuario);
    echo 1;
}