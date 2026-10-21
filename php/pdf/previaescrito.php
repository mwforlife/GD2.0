<?php
// Preview the saved template without changing its content or registering a document.
session_start();
header('Cache-Control: no-store, private');
header('X-Content-Type-Options: nosniff');

function errorVistaPrevia($status, $mensaje)
{
    http_response_code($status);
    header('Content-Type: text/plain; charset=UTF-8');
    exit($mensaje);
}

if (!isset($_SESSION['USER_ID'], $_SESSION['USER_TOKEN'])) {
    errorVistaPrevia(401, 'Debe iniciar sesión para ver el escrito.');
}

$id = filter_input(INPUT_GET, 'code', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false || $id === null) {
    errorVistaPrevia(400, 'El código del escrito no es válido.');
}

require_once __DIR__ . '/../controller.php';
require_once __DIR__ . '/../plugins/vendor/autoload.php';

try {
    $c = new Controller();
    if (!$c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN'])) {
        errorVistaPrevia(401, 'La sesión ha expirado. Vuelva a iniciar sesión.');
    }

    $gestion = false;
    foreach ($c->listarPermisosUsuario1($_SESSION['USER_ID']) as $permiso) {
        if ($permiso->getId() == 1) {
            $gestion = true;
            break;
        }
    }

    if (!$gestion) {
        $permitido = false;
        $empresa = (int) ($_SESSION['CURRENT_ENTERPRISE'] ?? 0);
        if ($empresa > 0) {
            foreach ($c->listartipodocumento1($empresa) as $escrito) {
                if ($escrito->getId() == $id) {
                    $permitido = true;
                    break;
                }
            }
        }
        if (!$permitido) {
            errorVistaPrevia(403, 'No tiene acceso a este escrito.');
        }
    }

    $tipo = $c->buscartipodocumento($id);
    if ($tipo === null) {
        errorVistaPrevia(404, 'El escrito no existe.');
    }
    $contenido = $c->buscarplantilla($id);
    if ($contenido === false || trim($contenido) === '') {
        errorVistaPrevia(404, 'Este escrito todavía no tiene una plantilla guardada.');
    }
    session_write_close();

    // Match the page format and rendering used by Documentos Individual.
    $mpdf = new \Mpdf\Mpdf(['format' => [216, 356]]);
    $mpdf->SetTitle('Vista previa - ' . $tipo->getNombre());
    $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.iustax.cl</div>');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($contenido);
    $mpdf->Output('Vista_previa_escrito_' . $id . '.pdf', 'I');
} catch (\Throwable $e) {
    error_log('Error al generar vista previa del escrito ' . $id . ': ' . $e->getMessage());
    errorVistaPrevia(500, 'No se pudo generar la vista previa del escrito.');
}
