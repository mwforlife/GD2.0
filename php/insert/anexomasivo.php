<?php
require '../controller.php';
$c = new Controller();
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

    $clausulas = $_POST['clausulas'];
    if (count($clausulas) == 0) {
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

    $lista = $c->buscarloteanexo($usuario, $empresa);
    foreach ($lista as $object) {
        $contrato = $object->getId();
        $contratoData = $c->buscarcontratoid($contrato);
        $fechainicio = $contratoData->getFechainicio();
        $trabajadorid = $contratoData->getFecharegistro();
        $fechaterminoActual = $contratoData->getFechatermino();

        $contrato = $object->getId();
        $res = $c->registraraenxo($contrato,$fechageneracion,$base, $sueldo, 1);

        // Actualizar sueldo si está activado
        if($base==1){
            $c->query("update contratos set sueldo = $sueldo where id = $contrato;");
        }

        if ($res>0) {
            // Verificar si el contrato es a plazo fijo
            $esPlazoFijo = (!empty($fechaterminoActual) && $fechaterminoActual != '' && $fechaterminoActual != null && $fechaterminoActual != '0000-00-00');
            $debeActualizarFecha = false;

            foreach($clausulas as $clausula){
                $clau = $clausula['clausula'];
                $plantilla = $clausula['tipodocumentoid'];

                // Si la plantilla contiene {NUEVA_FECHA_TERMINO} y el contrato es indefinido, NO insertar esta cláusula
                if(in_array($plantilla, $plantillasConFechaTermino) && !$esPlazoFijo){
                    // Saltar esta cláusula para contratos indefinidos
                    continue;
                }

                // Insertar la cláusula
                $c->query("insert into clausulasanexos (anexo, clausula, tipodocumento) values ($res, '$clau',$plantilla);");

                // Verificar si esta plantilla requiere actualización de fecha
                if(in_array($plantilla, $plantillasConFechaTermino)){
                    $debeActualizarFecha = true;
                }
            }

            // Actualizar fecha de término solo si:
            // 1. Está activada la modificación
            // 2. Alguna plantilla usa el campo {NUEVA_FECHA_TERMINO}
            // 3. El contrato es a plazo fijo
            if($debeActualizarFecha && $modificafecha == 1 && !empty($nuevafechatermino) && $esPlazoFijo){
                $c->actualizarfechaterminocontrato($contrato, $nuevafechatermino);
            }
        }
    }
    $c->eliminartodoloteanexo($usuario, $empresa);
    echo 1;
} else {
    echo "Error al procesar la solicitud";
}
