<?php
require '../controller.php';
$c = new Controller();
require_once '../plugins/vendor/autoload.php';
session_start();
$empresa = $_SESSION['CURRENT_ENTERPRISE'];
if (isset($_SESSION['USER_ID'])  && isset($_POST['empresa']) && isset($_POST['clausulas']) && isset($_POST['fechageneracion']) && isset($_POST['base']) && isset($_POST['sueldo'])) {

    $usuario = $_SESSION['USER_ID'];
    $lista = $c->buscarloteanexo($usuario, $empresa);
    if (count($lista) == 0) {
        echo "Debe seleccionar al menos un contrato";
        return;
    }
    $fechageneracion = $_POST['fechageneracion'];
    $empresa = $_POST['empresa'];
    
    if ($empresa == 0) {
        echo "Debe seleccionar una empresa";
        return;
    }

    // Decodificar el JSON de las clausulas
    $clausulas = json_decode($_POST['clausulas'], true);
    if (!$clausulas || count($clausulas) == 0) {
        echo "Debe seleccionar al menos una clausula";
        return;
    }

    $base = $_POST['base'];
    $sueldo = $_POST['sueldo'];

    // Capturar datos de modificación de fecha de término
    $modificafecha = isset($_POST['modificafecha']) ? $_POST['modificafecha'] : 0;
    $nuevafechatermino = isset($_POST['nuevafechatermino']) ? $_POST['nuevafechatermino'] : '';

    if($base == 1){
        if($sueldo == 0){
            echo "Debe ingresar un sueldo";
            return;
        }
    }else{
        $sueldo = 0;
    }

    // Validar fecha de término si está activada
    if($modificafecha == 1){
        if(empty($nuevafechatermino)){
            echo "Debe ingresar una nueva fecha de término";
            return;
        }
    }

    // Verificar qué plantillas contienen {NUEVA_FECHA_TERMINO}
    // IMPORTANTE: Esto debe verificarse SIEMPRE, no solo cuando está activada la modificación
    // porque necesitamos filtrar estas plantillas para contratos indefinidos
    $plantillasConFechaTermino = array();
    foreach($clausulas as $clausula){
        $plantillaId = $clausula['tipodocumentoid'];
        $contenidoPlantilla = $c->buscarplantilla($plantillaId);
        if(strpos($contenidoPlantilla, '{NUEVA_FECHA_TERMINO}') !== false){
            $plantillasConFechaTermino[] = $plantillaId;
        }
    }


    $sueldo1 = $sueldo;
    $sueldo = number_format($sueldo, 0, ",", ".");
    $sueldo1 = str_replace(".", "", $sueldo1);
    $sueldo1 = $c->convertirNumeroLetras($sueldo1);



    $empresa = $c->buscarempresa($empresa);
    $comuna = $empresa->getComuna();
    $region = $empresa->getRegion();
    $repre = $c->BuscarRepresentanteLegalempresa($empresa->getId());

    //crear instancia de mpdf con tamaño Legal
    $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
    $primeraIteracion = true;
    foreach ($lista as $object) {
        // Agregar salto de página entre trabajadores (excepto para el primero)

        $contrato = $object->getId();
        $contrato = $c->buscarcontratoid($contrato);
        $fechainicio = $contrato->getFechainicio();
        //Cambiar formato de fecha a dd/mm/yyyy
        $fechainicio = date("d/m/Y", strtotime($fechainicio));
        $fechatermino = $contrato->getFechatermino();
        if($fechatermino != null && $fechatermino != "" && $fechatermino != "0000-00-00"){
            $fechatermino = date("d/m/Y", strtotime($fechatermino));
        }else{
            $fechatermino = "Indefinido";
        }
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
        $contact = $c->ultimocontacto($trabajador->getId());
        $prevision = $c->buscarprevisiontrabajador($trabajadorid);

        if($prevision==null){
            echo "El trabajador no tiene prevision registrada";
            return;
        }

        $isapre = $c->buscarisapre($prevision->getIsapre());
        $afp = $c->buscarafp($prevision->getAfp());

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



        // Verificar si alguna de las cláusulas de este contrato usa una plantilla con {NUEVA_FECHA_TERMINO}
        $usaFechaTermino = false;
        $fechaterminoActual = $contrato->getFechatermino();
        $esPlazoFijo = (!empty($fechaterminoActual) && $fechaterminoActual != '' && $fechaterminoActual != null && $fechaterminoActual != '0000-00-00');

        foreach($clausulas as $clausula){
            if(in_array($clausula['tipodocumentoid'], $plantillasConFechaTermino)){
                $usaFechaTermino = true;
                break;
            }
        }

        // Preparar la nueva fecha de término para la vista previa
        // Solo usar la nueva fecha si:
        // 1. La modificación está activada
        // 2. Alguna plantilla usa {NUEVA_FECHA_TERMINO}
        // 3. El contrato es a plazo fijo
        $nuevafechaformat = $fechatermino; // Por defecto, usar la fecha actual
        if($modificafecha == 1 && !empty($nuevafechatermino) && $usaFechaTermino && $esPlazoFijo){
            $nuevafechaformat = date("d/m/Y", strtotime($nuevafechatermino));
        }

        $swap_var = array(
            "{FECHA_GENERACION}" => date("d-m-Y", strtotime($fechageneracion)),
            "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
            "{RUT_EMPRESA}" => $empresa->getRut(),
            "{REPRESENTANTE_LEGAL}" => $repre->getNombre() . " " . $repre->getApellido1() . " " . $repre->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $repre->getRut(),
            "{CALLE_EMPRESA}" => $empresa->getCalle(),
            "{VILLA_EMPRESA}" => $empresa->getVilla(),
            "{TELEFONO_EMPRESA}" => $empresa->getTelefono(),
            "{CORREO_EMPRESA}" => $empresa->getEmail(),
            "{NUMERO_EMPRESA}" => $empresa->getNumero(),
            "{FECHA_NACIMIENTO}" => date("d-m-Y", strtotime($trabajador->getNacimiento())),
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
            "{VILLA_TRABAJADOR}" => $dom->getVilla(),
            "{NUMERO_CASA_TRABAJADOR}" => $dom->getNumero(),
            "{DEPARTAMENTO_TRABAJADOR}" => $dom->getDepartamento(),
            "{COMUNA_TRABAJADOR}" => $comunatra,
            "{REGION_TRABAJADOR}" => $regiontra,
            "{NACIONALIDAD}" => $nacionalidad->getNombre(),
            "{ESTADO_CIVIL}" => $estadocivil->getNombre(),
            "{CARGO}" => $contrato->getCargo(),
            "{INICIO_CONTRATO}" => $fechainicio,
            "{TERMINO_CONTRATO}" => $fechatermino,
            "{NUEVA_FECHA_TERMINO}" => $nuevafechaformat,
            "{FORMA_PAGO}" => "Transferencia Electrónica",
            "{TIPO_CUENTA}" => $tipocuenta,
            "{NUMERO_CUENTA}" => $numerocuenta,
            "{BANCO}" => $banco,
            "{SUELDO_MONTO}" => $sueldo,
            "{SUELDO_MONTO_LETRAS}" => $sueldo1,
            "{SALUD}" => $isapre->getNombre(),
            "{AFP}" => $afp->getNombre(),
            "{FECHA_CELEBRACION}" => date("d-m-Y", strtotime($fechageneracion)),
        );

        $contenido = "";

        foreach($clausulas as $clausula){
            $plantillaId = $clausula['tipodocumentoid'];

            // Si la plantilla contiene {NUEVA_FECHA_TERMINO} y el contrato es indefinido, NO procesar esta cláusula
            if(in_array($plantillaId, $plantillasConFechaTermino) && !$esPlazoFijo){
                // Saltar esta cláusula para contratos indefinidos
                continue;
            }

            $plantilla = $c->buscarplantilla($plantillaId);

            // Reemplazar las variables en la plantilla
            foreach (array_keys($swap_var) as $key) {
                $plantilla = str_replace($key, $swap_var[$key], $plantilla);
            }

            // Reemplazar la cláusula a modificar manteniendo el formato de la plantilla
            $plantilla = str_replace("{CLAUSULA_A_MODIFICAR}", $clausula['clausula'], $plantilla);

            // Limpiar etiquetas HTML/BODY que puedan causar saltos de página
            $plantilla = preg_replace('/<\/?html[^>]*>/i', '', $plantilla);
            $plantilla = preg_replace('/<\/?body[^>]*>/i', '', $plantilla);
            $plantilla = preg_replace('/<\/?head[^>]*>/i', '', $plantilla);
            $plantilla = preg_replace('/<meta[^>]*>/i', '', $plantilla);

            // Concatenar la plantilla procesada DENTRO del loop
            $contenido .= $plantilla;
        }

        if (!$primeraIteracion) {
            $mpdf->AddPage();
        }
        $primeraIteracion = false;
        // Configurar el PDF
        $mpdf->title = 'Anexo de trabajo';
        $mpdf->author = 'Kairos - Gestor de Documentos';
        $mpdf->creator = 'kairos';
        $mpdf->subject = 'Anexo de trabajo';
        $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.iustax.cl</div>');
        $mpdf->keywords = 'anexo de trabajo, contrato, kairos, gestor de documentos';
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($contenido);
    }

    // Generar PDF y enviarlo directamente al navegador
    $mpdf->Output('anexo_preview.pdf', 'I');
} else {
    echo "UPPS, No LLegaron todos los datos";
}
