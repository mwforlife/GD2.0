<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';

session_start();

// Verificar sesión
if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit;
}

if (!isset($_SESSION['CURRENT_ENTERPRISE'])) {
    echo json_encode(['success' => false, 'message' => 'No hay empresa seleccionada']);
    exit;
}

$c = new Controller();
$usuario_id = $_SESSION['USER_ID'];
$empresa_id = $_SESSION['CURRENT_ENTERPRISE'];

// Aceptar datos por POST o GET (compatibilidad)
$dataJson = null;
if (isset($_POST['data'])) {
    $dataJson = $_POST['data'];
} elseif (isset($_GET['data'])) {
    $dataJson = $_GET['data'];
}

if ($dataJson) {
    $data = json_decode($dataJson, true);

    $tipodocumento = $data['tipo_documento'] ?? '';
    $contenido = $data['contenido'] ?? '';
    $monto_arriendo = $data['monto_arriendo'] ?? 0;

    if ($data) {
        $c = new Controller();
        generarVistaPrevia($c, $data, $empresa_id);
    } else {
        echo "Datos incompletos para generar la vista previa.";
    }
} else {
    echo "Parámetros no proporcionados.";
}

function generarVistaPrevia($c, $data, $empresa_id)
{
    try {
        // Obtener datos de la empresa
        $empresa = $c->buscarempresa($empresa_id);
        $representante = $c->BuscarRepresentanteLegalempresa($empresa_id);

        // Procesar variables del documento
        $contenido = $data['contenido'];
        $mandatarios = $data['mandatarios'] ?? '[]';
        //$mandatarios = json_decode($mandatarios_json, true);
        $monto_arriendo = floatval($data['monto_arriendo'] ?? 0);
        $rutempresaletras = convertirRutATexto($empresa->getRut());
        //Verificar si al final terminar en  guion ka y convertirlo  guion k
        if (strpos($rutempresaletras, 'guion ka') !== false) {
            $rutempresaletras = str_replace('guion ka', 'guion k', $rutempresaletras);
        }

        $avaluo_fiscal = $data['avaluo_fiscal'] ?? '';

        // Variables de reemplazo
        $swap_var = [
            "{RUT_EMPRESA}" => $empresa->getRut(),
            "{RUT_EMPRESA_EN_LETRAS}" => convertirRutATexto($empresa->getRut()),
            "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
            "{REPRESENTANTE_LEGAL}" => $representante->getNombre() . " " . $representante->getApellido1() . " " . $representante->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $representante->getRut(),
            "{RUT_REPRESENTANTE_LEGAL_EN_LETRAS}" => convertirRutATexto($representante->getRut()),
            "{DIRECCION_EMPRESA}" => $empresa->getCalle() . " " . $empresa->getNumero(),
            "{VILLA_EMPRESA}" => $empresa->getVilla(),
            "{COMUNA_EMPRESA}" => $empresa->getComuna(),
            "{REGION_EMPRESA}" => $empresa->getRegion(),
            "{TELEFONO_EMPRESA}" => $empresa->getTelefono(),
            "{CORREO_EMPRESA}" => $empresa->getEmail(),
            "{FECHA_GENERACION}" => date("d-m-Y"),
            "{FECHA_CELEBRACION}" => date("d-m-Y"),
            "{AVALUO_FISCAL}" => $avaluo_fiscal
        ];

        $mandatarios_encabezado = "";
        $datosmandatarios = "";
        // Procesar mandatarios
        foreach ($mandatarios as $index => $mandatario) {
            $num = $index + 1;

            $rutmandatario = $mandatario['rut'] ?? '';
            $ruttexto = convertirRutATexto($rutmandatario);

            $mandatarios_encabezado .= $mandatario['nombre'] . ' <br/>';
            $datosmandatarios .= $mandatario['nombre'] . " de nacionalidad " . $mandatario['nacionalidad'] . ", estado civil " . $mandatario['estado_civil'] . " de profesión u oficio " . $mandatario['profesion'] . ", cédula nacional de identidad " . $ruttexto . " y ";
        }

        // Eliminar el último "y" de los mandatarios
        if (!empty($datosmandatarios)) {
            $datosmandatarios = rtrim($datosmandatarios, ' y ');
        }

        $swap_var["{DATOS_MANDATARIOS_ENCABEZADO}"] = $mandatarios_encabezado;
        $swap_var["{DATOS_MANDATARIOS}"] = $datosmandatarios;

        // Procesar monto de arriendo
        $swap_var["{MONTO_ARRIENDO}"] = number_format($monto_arriendo, 0, ',', '.');
        $swap_var["{MONTO_ARRIENDO_LETRAS}"] = convertirNumeroALetras($monto_arriendo);


        // Reemplazar variables en el contenido
        foreach ($swap_var as $variable => $valor) {
            $contenido = str_replace($variable, $valor, $contenido);
        }

        // Generar PDF usando mPDF
        $mpdf = new \Mpdf\Mpdf([
            'format' => [216, 356] // Tamaño oficio
        ]);

        $mpdf->SetTitle('Documento Empresarial');
        $mpdf->SetAuthor('Sistema Gestor de Documentos');
        $mpdf->SetCreator('iustax.cl');
        $mpdf->SetSubject('Documento Empresarial');
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($contenido);
        //Imprimir PDF en el navegador
        $mpdf->Output('vista_previa_documento.pdf', 'I');
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al generar PDF: ' . $e->getMessage()]);
    }
}


// Función auxiliar para convertir números a letras (versión simplificada)
function convertirNumeroALetras($numero)
{
    $unidades = [
        '',
        'uno',
        'dos',
        'tres',
        'cuatro',
        'cinco',
        'seis',
        'siete',
        'ocho',
        'nueve',
        'diez',
        'once',
        'doce',
        'trece',
        'catorce',
        'quince',
        'dieciséis',
        'diecisiete',
        'dieciocho',
        'diecinueve'
    ];

    $decenas = [
        '',
        '',
        'veinte',
        'treinta',
        'cuarenta',
        'cincuenta',
        'sesenta',
        'setenta',
        'ochenta',
        'noventa'
    ];

    $centenas = [
        '',
        'ciento',
        'doscientos',
        'trescientos',
        'cuatrocientos',
        'quinientos',
        'seiscientos',
        'setecientos',
        'ochocientos',
        'novecientos'
    ];

    if ($numero == 0) return 'cero';
    if ($numero == 100) return 'cien';

    $resultado = '';

    // Millones
    if ($numero >= 1000000) {
        $millones = intval($numero / 1000000);
        if ($millones == 1) {
            $resultado .= 'un millón ';
        } else {
            $resultado .= convertirNumeroALetras($millones) . ' millones ';
        }
        $numero %= 1000000;
    }

    // Miles
    if ($numero >= 1000) {
        $miles = intval($numero / 1000);
        if ($miles == 1) {
            $resultado .= 'mil ';
        } else {
            $resultado .= convertirNumeroALetras($miles) . ' mil ';
        }
        $numero %= 1000;
    }

    // Centenas
    if ($numero >= 100) {
        $resultado .= $centenas[intval($numero / 100)] . ' ';
        $numero %= 100;
    }

    // Decenas y unidades
    if ($numero >= 20) {
        $resultado .= $decenas[intval($numero / 10)];
        if ($numero % 10 != 0) {
            $resultado .= ' y ' . $unidades[$numero % 10];
        }
    } elseif ($numero > 0) {
        $resultado .= $unidades[$numero];
    }

    return trim($resultado);
}


class ConvertirRutTexto
{

    /**
     * Convierte un RUT completo (ej: 17.992.627-K) a texto
     * @param string $rut RUT en formato XX.XXX.XXX-X
     * @return string RUT en texto
     */
    public function rutATexto($rut)
    {
        // Limpiar el RUT de puntos y guiones
        $rutLimpio = str_replace(['.', '-'], '', $rut);

        // Separar número y dígito verificador
        $numero = substr($rutLimpio, 0, -1);
        $dv = strtoupper(substr($rutLimpio, -1));

        // Convertir número a texto
        $numeroTexto = $this->numeroATexto(intval($numero));

        // Convertir dígito verificador
        $dvTexto = $this->digitoVerificadorATexto($dv);

        return $numeroTexto . " guion " . $dvTexto;
    }

    /**
     * Convierte números a texto en español
     * @param int $numero
     * @return string
     */
    private function numeroATexto($numero)
    {
        $unidades = [
            '',
            'uno',
            'dos',
            'tres',
            'cuatro',
            'cinco',
            'seis',
            'siete',
            'ocho',
            'nueve',
            'diez',
            'once',
            'doce',
            'trece',
            'catorce',
            'quince',
            'dieciséis',
            'diecisiete',
            'dieciocho',
            'diecinueve'
        ];

        $decenas = [
            '',
            '',
            'veinte',
            'treinta',
            'cuarenta',
            'cincuenta',
            'sesenta',
            'setenta',
            'ochenta',
            'noventa'
        ];

        $centenas = [
            '',
            'ciento',
            'doscientos',
            'trescientos',
            'cuatrocientos',
            'quinientos',
            'seiscientos',
            'setecientos',
            'ochocientos',
            'novecientos'
        ];

        if ($numero == 0) return 'cero';
        if ($numero == 100) return 'cien';

        $resultado = '';

        // Millones
        if ($numero >= 1000000) {
            $millones = intval($numero / 1000000);
            if ($millones == 1) {
                $resultado .= 'un millón ';
            } else {
                $resultado .= $this->convertirGrupoTresCifras($millones) . ' millones ';
            }
            $numero = $numero % 1000000;
        }

        // Miles
        if ($numero >= 1000) {
            $miles = intval($numero / 1000);
            if ($miles == 1) {
                $resultado .= 'mil ';
            } else {
                $resultado .= $this->convertirGrupoTresCifras($miles) . ' mil ';
            }
            $numero = $numero % 1000;
        }

        // Unidades, decenas y centenas
        if ($numero > 0) {
            $resultado .= $this->convertirGrupoTresCifras($numero);
        }

        return trim($resultado);
    }

    /**
     * Convierte un grupo de hasta 3 cifras a texto
     * @param int $numero
     * @return string
     */
    private function convertirGrupoTresCifras($numero)
    {
        $unidades = [
            '',
            'uno',
            'dos',
            'tres',
            'cuatro',
            'cinco',
            'seis',
            'siete',
            'ocho',
            'nueve',
            'diez',
            'once',
            'doce',
            'trece',
            'catorce',
            'quince',
            'dieciséis',
            'diecisiete',
            'dieciocho',
            'diecinueve'
        ];

        $decenas = [
            '',
            '',
            'veinte',
            'treinta',
            'cuarenta',
            'cincuenta',
            'sesenta',
            'setenta',
            'ochenta',
            'noventa'
        ];

        $centenas = [
            '',
            'ciento',
            'doscientos',
            'trescientos',
            'cuatrocientos',
            'quinientos',
            'seiscientos',
            'setecientos',
            'ochocientos',
            'novecientos'
        ];

        $resultado = '';

        if ($numero >= 100) {
            if ($numero == 100) {
                return 'cien';
            }
            $resultado .= $centenas[intval($numero / 100)] . ' ';
            $numero = $numero % 100;
        }

        if ($numero >= 20) {
            $resultado .= $decenas[intval($numero / 10)];
            $numero = $numero % 10;
            if ($numero > 0) {
                $resultado .= ' y ' . $unidades[$numero];
            }
        } elseif ($numero > 0) {
            $resultado .= $unidades[$numero];
        }

        return trim($resultado);
    }

    /**
     * Convierte el dígito verificador a texto
     * @param string $dv
     * @return string
     */
    private function digitoVerificadorATexto($dv)
    {
        $digitosTexto = [
            '0' => 'cero',
            '1' => 'uno',
            '2' => 'dos',
            '3' => 'tres',
            '4' => 'cuatro',
            '5' => 'cinco',
            '6' => 'seis',
            '7' => 'siete',
            '8' => 'ocho',
            '9' => 'nueve',
            'K' => 'ka'
        ];

        return $digitosTexto[$dv] ?? $dv;
    }
}

// Función para integrar con tu controlador existente
function convertirRutATexto($rut)
{
    $conversor = new ConvertirRutTexto();
    $textoretornado =  $conversor->rutATexto($rut);
    if (strpos($textoretornado, 'guion ka') !== false) {
        $textoretornado = str_replace('guion ka', 'guion k', $textoretornado);
    }
    return $textoretornado;
}

// Ejemplos de uso:
/*
echo convertirRutATexto('17.992.627-K'); 
// Salida: "diecisiete millones novecientos noventa y dos mil seiscientos veintisiete guion ka"

echo convertirRutATexto('1.234.567-8');
// Salida: "un millón doscientos treinta y cuatro mil quinientos sesenta y siete guion ocho"

echo convertirRutATexto('12.345.678-9');
// Salida: "doce millones trescientos cuarenta y cinco mil seiscientos setenta y ocho guion nueve"
*/

// Método para agregar a tu clase Controller existente
/*
// Agregar este método a tu clase Controller
public function convertirRutTexto($rut) {
    $conversor = new ConvertirRutTexto();
    return $conversor->rutATexto($rut);
}
*/