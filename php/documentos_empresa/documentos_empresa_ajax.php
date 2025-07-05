<?php
require '../controller.php';
require_once '../plugins/vendor/autoload.php';

session_start();

header('Content-Type: application/json');

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

$action = $_POST['action'] ?? '';
$data = $_POST['data'] ?? [];

try {
    switch ($action) {
        case 'listar_usuarios':
            listarUsuarios($c, $empresa_id);
            break;

        case 'obtener_usuario':
            obtenerUsuario($c, $_POST['id']);
            break;

        case 'listar_plantillas_por_tipo':
            listarPlantillasPorTipo($c, $_POST['tipo']);
            break;

        case 'obtener_plantilla':
            obtenerPlantilla($c, $_POST['id']);
            break;

        case 'obtener_plantilla_por_id':
            obtenerPlantillaPorId($c, $_POST['id']);
            break;

        case 'crear_plantilla':
            crearPlantilla($c, $_POST, $empresa_id, $usuario_id);
            break;

        case 'actualizar_plantilla':
            actualizarPlantilla($c, $_POST, $usuario_id);
            break;

        case 'duplicar_plantilla':
            duplicarPlantilla($c, $_POST['id'], $usuario_id);
            break;

        case 'eliminar_plantilla':
            eliminarPlantilla($c, $_POST['id']);
            break;

        case 'generar_documento':
            generardocumento($c, $data, $empresa_id, $usuario_id);
            break;

        case 'generar_pdf':
            generarPDF($c, $_POST, $empresa_id, $usuario_id);
            break;

        case 'obtener_estadisticas':
            obtenerEstadisticas($c, $empresa_id);
            break;

        case 'regenerar_documento':
            regenerarDocumento($c, $_POST['id'], $usuario_id);
            break;

        case 'eliminar_documento':
            eliminarDocumento($c, $_POST['id']);
            break;

        case 'listar_plantillas':
            listarplantillas($c);
            break;

        case 'listar_documentos_generados':
            listarDocumentosGenerados($c, $empresa_id);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

function listarplantillas($c)
{
    $c->conexion();

    $sql = "SELECT pe.id, pe.nombre, pe.version, tde.nombre as tipo_nombre, tde.categoria as categoria, pe.updated_at as ultima_modificacion, pe.activo as estado
            FROM plantillas_empresa pe
            INNER JOIN tipo_documento_empresa_plantilla tde ON pe.tipo_documento = tde.id
            ORDER BY pe.nombre";

    $result = $c->mi->query($sql);
    $plantillas = [];

    while ($row = mysqli_fetch_array($result)) {
        $plantillas[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'version' => $row['version'],
            'tipo_nombre' => $row['tipo_nombre'],
            'categoria' => $row['categoria'],
            'ultima_modificacion' => date('d-m-Y H:i:s', strtotime($row['ultima_modificacion'])),
            'estado' => $row['estado'] ? 'Activo' : 'Inactivo'
        ];
    }

    $c->desconectar();
    echo json_encode(['success' => true, 'data' => $plantillas]);
}

function listarUsuarios($c, $empresa_id)
{
    $c->conexion();

    // Obtener usuarios que pueden ser mandatarios (excluyendo usuarios tipo 3 - mandantes)
    $sql = "select users.*, region.nombre as region_nombre, comuna.nombre as comuna_nombre, status.nombre as estado_nombre, nacionalidad.nombre as nacionalidad_nombre, estadocivil.nombre as estado_civil_nombre 
                from users, regiones region, comunas comuna, status, nacionalidad, estadocivil 
                where users.region = region.id and users.comuna = comuna.id 
                and users.estado = status.id and users.nacionalidad = nacionalidad.id 
                and users.estado_civil = estadocivil.id order by users.id_usu desc;";

    $result = $c->mi->query($sql);
    $usuarios = [];

    while ($row = mysqli_fetch_array($result)) {
        $usuarios[] = [
            'id' => $row['id_usu'],
            'rut' => $row['rut'],
            'nombre' => $row['nombre'],
            'apellidos' => $row['apellidos'],
            'nacionalidad' => $row['nacionalidad_nombre'] ?? 'No especificada',
            'estado_civil' => $row['estado_civil_nombre'] ?? 'No especificado',
            'profesion' => $row['profesion'] ?? ''
        ];
    }

    $c->desconectar();
    echo json_encode(['success' => true, 'data' => $usuarios]);
}

function obtenerUsuario($c, $id)
{
    $c->conexion();

    $sql = "SELECT u.id_usu as id, u.rut, u.nombre, u.apellidos, 
                   n.nombre as nacionalidad, ec.nombre as estado_civil, u.profesion
            FROM users u
            LEFT JOIN nacionalidad n ON u.nacionalidad = n.id
            LEFT JOIN estadocivil ec ON u.estado_civil = ec.id
            WHERE u.id_usu = $id";

    $result = $c->mi->query($sql);

    if ($row = mysqli_fetch_array($result)) {
        $usuario = [
            'id' => $row['id'],
            'rut' => $row['rut'],
            'nombre' => $row['nombre'],
            'apellidos' => $row['apellidos'],
            'nacionalidad' => $row['nacionalidad'] ?? 'No especificada',
            'estado_civil' => $row['estado_civil'] ?? 'No especificado',
            'profesion' => $row['profesion'] ?? ''
        ];

        $c->desconectar();
        echo json_encode(['success' => true, 'data' => $usuario]);
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }
}

function listarPlantillasPorTipo($c, $tipo)
{
    $c->conexion();

    $sql = "SELECT pe.id, pe.nombre, pe.version
            FROM plantillas_empresa pe
            INNER JOIN tipo_documento_empresa_plantilla tde ON pe.tipo_documento = tde.id
            WHERE tde.id = $tipo AND pe.activo = 1
            ORDER BY pe.nombre";

    $result = $c->mi->query($sql);
    $plantillas = [];

    while ($row = mysqli_fetch_array($result)) {
        $plantillas[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'version' => $row['version']
        ];
    }

    $c->desconectar();
    echo json_encode(['success' => true, 'data' => $plantillas]);
}

function obtenerPlantilla($c, $id)
{
    $c->conexion();

    $sql = "SELECT pe.*, tde.nombre as tipo_nombre, tde.categoria
            FROM plantillas_empresa pe
            INNER JOIN tipo_documento_empresa_plantilla tde ON pe.tipo_documento = tde.id
            WHERE pe.id = $id";

    $result = $c->mi->query($sql);

    if ($row = mysqli_fetch_array($result)) {
        $plantilla = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'contenido' => $row['contenido'],
            'tipo_nombre' => $row['tipo_nombre'],
            'categoria' => $row['categoria'],
            'version' => $row['version']
        ];

        $c->desconectar();
        echo json_encode(['success' => true, 'data' => $plantilla]);
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Plantilla no encontrada']);
    }
}

function obtenerPlantillaPorId($c, $id)
{
    $c->conexion();

    $sql = "SELECT pe.*, tde.id as categoria, tde.descripcion as descripcion
     FROM plantillas_empresa pe
        INNER JOIN tipo_documento_empresa_plantilla tde ON pe.tipo_documento = tde.id
      WHERE pe.id = $id";

    $result = $c->mi->query($sql);

    if ($row = mysqli_fetch_array($result)) {
        $plantilla = [
            'id' => $row['id'],
            'tipo_documento' => $row['tipo_documento'],
            'categoria' => $row['categoria'],
            'descripcion' => $row['descripcion'] ?? '',
            'nombre' => $row['nombre'],
            'contenido' => $row['contenido'],
            'version' => $row['version'],
            'activo' => $row['activo'],
            'created_at' => date('d-m-Y H:i:s', strtotime($row['created_at'])),
            'updated_at' => date('d-m-Y H:i:s', strtotime($row['updated_at']))
        ];

        $c->desconectar();
        echo json_encode(['success' => true, 'data' => $plantilla]);
    } else {
        $c->desconectar();
        return null;
    }
}

function crearPlantilla($c, $data, $empresa_id, $usuario_id)
{
    $c->conexion();

    $nombre = mysqli_real_escape_string($c->mi, $data['nombre']);
    $categoria = mysqli_real_escape_string($c->mi, $data['categoria']);
    $descripcion = mysqli_real_escape_string($c->mi, $data['descripcion'] ?? '');
    $contenido = mysqli_real_escape_string($c->mi, $data['contenido']);

    // Buscar o crear tipo de documento
    $sql_tipo = "SELECT id FROM tipo_documento_empresa_plantilla WHERE categoria = '$categoria' LIMIT 1";
    $result_tipo = $c->mi->query($sql_tipo);

    if ($row_tipo = mysqli_fetch_array($result_tipo)) {
        $tipo_documento_id = $row_tipo['id'];
    } else {
        // Crear nuevo tipo si no existe
        $codigo = strtoupper(substr($categoria, 0, 3)) . time();
        $sql_create_tipo = "INSERT INTO tipo_documento_empresa_plantilla (codigo, nombre, categoria, descripcion) 
                           VALUES ('$codigo', '$nombre', '$categoria', '$descripcion')";
        $c->mi->query($sql_create_tipo);
        $tipo_documento_id = $c->mi->insert_id;
    }

    // Crear plantilla
    $sql = "INSERT INTO plantillas_empresa (tipo_documento, nombre, contenido, version) 
            VALUES ($tipo_documento_id, '$nombre', '$contenido', '1.0')";

    if ($c->mi->query($sql)) {
        $c->desconectar();
        echo json_encode(['success' => true, 'message' => 'Plantilla creada correctamente']);
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Error al crear la plantilla']);
    }
}

function actualizarPlantilla($c, $data, $usuario_id)
{
    $c->conexion();

    $id = intval($data['id']);
    $nombre = mysqli_real_escape_string($c->mi, $data['nombre']);
    $descripcion = mysqli_real_escape_string($c->mi, $data['descripcion'] ?? '');
    $contenido = mysqli_real_escape_string($c->mi, $data['contenido']);
    $categoria = mysqli_real_escape_string($c->mi, $data['categoria']);

    $sql = "UPDATE plantillas_empresa 
            SET nombre = '$nombre', contenido = '$contenido', updated_at = NOW(), tipo_documento = $categoria
            WHERE id = $id";

    if ($c->mi->query($sql)) {
        $c->desconectar();
        echo json_encode(['success' => true, 'message' => 'Plantilla actualizada correctamente']);
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la plantilla']);
    }
}

function duplicarPlantilla($c, $id, $usuario_id)
{
    $c->conexion();

    $sql_original = "SELECT * FROM plantillas_empresa WHERE id = $id";
    $result = $c->mi->query($sql_original);

    if ($row = mysqli_fetch_array($result)) {
        $nombre = $row['nombre'] . ' (Copia)';
        $contenido = mysqli_real_escape_string($c->mi, $row['contenido']);
        $tipo_documento = $row['tipo_documento'];

        $sql_duplicate = "INSERT INTO plantillas_empresa (tipo_documento, nombre, contenido, version) 
                         VALUES ($tipo_documento, '$nombre', '$contenido', '1.0')";

        if ($c->mi->query($sql_duplicate)) {
            $c->desconectar();
            echo json_encode(['success' => true, 'message' => 'Plantilla duplicada correctamente']);
        } else {
            $c->desconectar();
            echo json_encode(['success' => false, 'message' => 'Error al duplicar la plantilla']);
        }
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Plantilla no encontrada']);
    }
}

function eliminarPlantilla($c, $id)
{
    $c->conexion();

    $sql = "UPDATE plantillas_empresa SET activo = 0 WHERE id = $id";

    if ($c->mi->query($sql)) {
        $c->desconectar();
        echo json_encode(['success' => true, 'message' => 'Plantilla eliminada correctamente']);
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la plantilla']);
    }
}

function guardarDocumento($c, $data, $empresa_id, $usuario_id)
{
    $c->conexion();

    $tipo_documento = intval($data['tipo_documento'] ?? 0);
    $plantilla_id = intval($data['plantilla_id'] ?? 0);
    $contenido = mysqli_real_escape_string($c->mi, $data['contenido']);
    $mandatarios = mysqli_real_escape_string($c->mi, $data['mandatarios'] ?? '[]');
    $monto_arriendo = floatval($data['monto_arriendo'] ?? 0);
    $datos_adicionales = mysqli_real_escape_string($c->mi, $data['datos_adicionales'] ?? '{}');

    // Generar título automático
    $fecha = date('Y-m-d');
    $titulo = "Documento " . date('Y-m-d H:i:s');

    // Buscar tipo de documento por categoría
    $sql_tipo = "SELECT id FROM tipo_documento_empresa_plantilla WHERE categoria = '$tipo_documento' LIMIT 1";
    $result_tipo = $c->mi->query($sql_tipo);

    if ($row_tipo = mysqli_fetch_array($result_tipo)) {
        $tipo_doc_id = $row_tipo['id'];

        $sql = "INSERT INTO documentos_empresa_generados 
                (tipo_documento, plantilla_id, empresa, titulo, contenido_generado, 
                 mandatarios_seleccionados, datos_adicionales, usuario_creador, fecha_generacion) 
                VALUES ($tipo_doc_id, $plantilla_id, $empresa_id, '$titulo', '$contenido', 
                        '$mandatarios', '$datos_adicionales', $usuario_id, '$fecha')";

        if ($c->mi->query($sql)) {
            $documento_id = $c->mi->insert_id;

            // Registrar mandatarios si no existen
            $mandatarios_array = json_decode($data['mandatarios'], true);
            if (is_array($mandatarios_array)) {
                foreach ($mandatarios_array as $mandatario) {
                    $usuario_id_mandatario = intval($mandatario['id']);

                    // Verificar si ya existe en la tabla mandatarios
                    $sql_check = "SELECT id FROM mandatarios WHERE usuario = $usuario_id_mandatario AND empresa = $empresa_id";
                    $result_check = $c->mi->query($sql_check);

                    if (!mysqli_fetch_array($result_check)) {
                        // Insertar nuevo mandatario
                        $sql_mandatario = "INSERT INTO mandatarios (usuario, empresa) VALUES ($usuario_id_mandatario, $empresa_id)";
                        $c->mi->query($sql_mandatario);
                    }
                }
            }

            // Registrar monto de arriendo si aplica
            if ($monto_arriendo > 0) {
                $sql_monto = "INSERT INTO mandatos_arriendo (empresa, monto) VALUES ($empresa_id, $monto_arriendo)";
                $c->mi->query($sql_monto);
            }

            $c->desconectar();
            echo json_encode(['success' => true, 'message' => 'Documento guardado correctamente', 'id' => $documento_id]);
        } else {
            $c->desconectar();
            echo json_encode(['success' => false, 'message' => 'Error al guardar el documento']);
        }
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Tipo de documento no encontrado']);
    }
}

function generardocumento($c, $data, $empresa_id, $usuario_id)
{
    try {
        // Obtener datos de la empresa
        $empresa = $c->buscarempresa($empresa_id);
        $representante = $c->BuscarRepresentanteLegalempresa($empresa_id);
        $data = json_decode($data, true);

        // Procesar variables del documento
        $contenido = $data['contenido'];
        $mandatarios = $data['mandatarios'] ?? [];
        $monto_arriendo = floatval($data['monto_arriendo'] ?? 0);
        $rutempresaletras = convertirRutATexto($empresa->getRut());

        //Verificar si al final terminar en guion ka y convertirlo guion k
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
        $contenido_procesado = $contenido;
        foreach ($swap_var as $variable => $valor) {
            $contenido_procesado = str_replace($variable, $valor, $contenido_procesado);
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

        // Guardar documento en servidor
        $mpdf->WriteHTML($contenido_procesado);
        $fecha = date('YmdHis');
        $tipo_doc = $data['tipo_documento'] ?? 'documento';
        $nombre_archivo = 'documento_' . $tipo_doc . '_' . $fecha . '.pdf';
        $carpeta_documentos = "../documentos_generados/";

        if (!file_exists($carpeta_documentos)) {
            mkdir($carpeta_documentos, 0755, true);
        }

        $ruta_completa = $carpeta_documentos . $nombre_archivo;
        $mpdf->Output($ruta_completa, 'F');

        // Guardar registro en base de datos
        $c->conexion();

        // Obtener el ID del tipo de documento
        $tipo_documento = $data['tipo_documento'] ?? 'documento';
        $plantilla_id = isset($data['plantilla_id']) ? intval($data['plantilla_id']) : 'NULL';

        $sql_tipo = "SELECT id FROM tipo_documento_empresa_plantilla WHERE categoria = '$tipo_documento' LIMIT 1";
        $result_tipo = $c->mi->query($sql_tipo);

        if ($row_tipo = mysqli_fetch_array($result_tipo)) {
            $tipo_doc_id = $row_tipo['id'];

            // Crear título más descriptivo
            $titulo = $data['titulo'] ?? "Documento " . ucfirst($tipo_documento) . " - " . date('d/m/Y H:i');

            // Escapar contenido para evitar problemas con caracteres especiales
            $contenido_procesado_escaped = mysqli_real_escape_string($c->mi, $contenido_procesado);
            $titulo_escaped = mysqli_real_escape_string($c->mi, $titulo);

            // Insertar documento en documentos_empresa_generados
            $sql_insert = "INSERT INTO documentos_empresa_generados 
                           (tipo_documento, plantilla_id, empresa, titulo, contenido_generado, usuario_creador, fecha_generacion, archivo_pdf) 
                           VALUES ($tipo_doc_id, $plantilla_id, $empresa_id, '$titulo_escaped', '$contenido_procesado_escaped', $usuario_id, CURDATE(), '$nombre_archivo')";

            if ($c->mi->query($sql_insert)) {
                $documento_id = $c->mi->insert_id;

                // Registrar mandatarios en la tabla mandatarios
                if (is_array($mandatarios) && !empty($mandatarios)) {
                    foreach ($mandatarios as $mandatario) {
                        $usuario_id_mandatario = intval($mandatario['id']);

                        // Verificar si ya existe la relación mandatario-documento
                        $sql_check = "SELECT id FROM mandatarios WHERE usuario = $usuario_id_mandatario AND documento = $documento_id";
                        $result_check = $c->mi->query($sql_check);

                        if (mysqli_num_rows($result_check) === 0) {
                            // Insertar nuevo mandatario
                            $sql_mandatario = "INSERT INTO mandatarios (usuario, documento) VALUES ($usuario_id_mandatario, $documento_id)";

                            if (!$c->mi->query($sql_mandatario)) {
                                echo json_encode(['success' => false, 'message' => 'Error al registrar mandatario: ' . $c->mi->error]);
                                $c->desconectar();
                                return;
                            }
                        }
                    }
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Documento generado correctamente',
                    'documento_id' => $documento_id,
                    'pdf_url' => $nombre_archivo,
                    'titulo' => $titulo
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar el documento en la base de datos: ' . $c->mi->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Tipo de documento no encontrado: ' . $tipo_documento]);
        }

        $c->desconectar();
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al generar documento: ' . $e->getMessage()
        ]);
    }
}

function generarPDF($c, $data, $empresa_id, $usuario_id)
{
    try {
        // Obtener datos de la empresa
        $empresa = $c->buscarempresa($empresa_id);
        $representante = $c->BuscarRepresentanteLegalempresa($empresa_id);

        // Procesar variables del documento
        $contenido = $data['contenido'];
        $mandatarios_json = $data['mandatarios'] ?? '[]';
        $mandatarios = json_decode($mandatarios_json, true);
        $monto_arriendo = floatval($data['monto_arriendo'] ?? 0);

        // Variables de reemplazo
        $swap_var = [
            "{RUT_EMPRESA}" => $empresa->getRut(),
            "{NOMBRE_EMPRESA}" => $empresa->getRazonSocial(),
            "{REPRESENTANTE_LEGAL}" => $representante->getNombre() . " " . $representante->getApellido1() . " " . $representante->getApellido2(),
            "{RUT_REPRESENTANTE_LEGAL}" => $representante->getRut(),
            "{DIRECCION_EMPRESA}" => $empresa->getCalle() . " " . $empresa->getNumero() . ", " . $empresa->getVilla(),
            "{TELEFONO_EMPRESA}" => $empresa->getTelefono(),
            "{CORREO_EMPRESA}" => $empresa->getEmail(),
            "{FECHA_GENERACION}" => date("d-m-Y"),
            "{FECHA_CELEBRACION}" => date("d-m-Y")
        ];

        // Procesar mandatarios
        foreach ($mandatarios as $index => $mandatario) {
            $num = $index + 1;
            $swap_var["{MANDATARIO_$num}"] = $mandatario['nombre'] ?? '';
            $swap_var["{RUT_MANDATARIO_$num}"] = $mandatario['rut'] ?? '';
            $swap_var["{NACIONALIDAD_MANDATARIO_$num}"] = $mandatario['nacionalidad'] ?? '';
            $swap_var["{ESTADO_CIVIL_MANDATARIO_$num}"] = $mandatario['estado_civil'] ?? '';
            $swap_var["{PROFESION_MANDATARIO_$num}"] = $mandatario['profesion'] ?? '';
        }

        // Procesar monto de arriendo
        $swap_var["{MONTO_ARRIENDO}"] = number_format($monto_arriendo, 0, ',', '.');
        $swap_var["{MONTO_ARRIENDO_LETRAS}"] = convertirNumeroALetras($monto_arriendo);


        // Reemplazar variables en el contenido
        foreach ($swap_var as $variable => $valor) {
            $contenido = str_replace($variable, $valor, $contenido);
        }

        // Generar PDF usando mPDF
        $mpdf = new \Mpdf\Mpdf([
            'format' => [216, 356], // Tamaño oficio
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20
        ]);

        $mpdf->SetTitle('Documento Empresarial');
        $mpdf->SetAuthor('Sistema Gestor de Documentos');
        $mpdf->SetCreator('iustax.cl');
        $mpdf->SetSubject('Documento Empresarial');
        $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">www.iustax.cl - Página {PAGENO} de {nbpg}</div>');
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($contenido);

        // Generar nombre único para el archivo
        $fecha = date('Ymdhis');
        $tipo_doc = $data['tipo_documento'] ?? 'documento';
        $nombre_archivo = 'documento_' . $tipo_doc . '_' . $fecha . '.pdf';

        // Crear carpeta si no existe
        $carpeta_documentos = "../documentos_generados/";
        if (!file_exists($carpeta_documentos)) {
            mkdir($carpeta_documentos, 0755, true);
        }

        $ruta_completa = $carpeta_documentos . $nombre_archivo;

        // Guardar PDF
        $mpdf->Output($ruta_completa, 'F');

        // Guardar registro en base de datos si no existe
        $titulo = "Documento " . date('Y-m-d H:i:s');
        $tipo_documento = $data['tipo_documento'];

        $c->conexion();

        // Buscar tipo de documento por categoría
        $sql_tipo = "SELECT id FROM tipo_documento_empresa_plantilla WHERE categoria = '$tipo_documento' LIMIT 1";
        $result_tipo = $c->mi->query($sql_tipo);

        if ($row_tipo = mysqli_fetch_array($result_tipo)) {
            $tipo_doc_id = $row_tipo['id'];

            $sql_insert = "INSERT INTO documentos_empresa_generados 
                          (tipo_documento, empresa, titulo, contenido_generado, archivo_pdf,
                           mandatarios_seleccionados, datos_adicionales, usuario_creador, fecha_generacion) 
                          VALUES ($tipo_doc_id, $empresa_id, '$titulo', '" . mysqli_real_escape_string($c->mi, $contenido) . "', 
                                  '$nombre_archivo', '" . mysqli_real_escape_string($c->mi, $mandatarios_json) . "', 
                                  '" . mysqli_real_escape_string($c->mi, json_encode(['monto_arriendo' => $monto_arriendo])) . "', 
                                  $usuario_id, '" . date('Y-m-d') . "')";

            $c->mi->query($sql_insert);
        }

        $c->desconectar();

        echo json_encode([
            'success' => true,
            'message' => 'PDF generado correctamente',
            'pdf_url' => 'php/documentos_generados/' . $nombre_archivo,
            'filename' => $nombre_archivo
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al generar PDF: ' . $e->getMessage()]);
    }
}

function obtenerEstadisticas($c, $empresa_id)
{
    $c->conexion();

    // Contar documentos generados
    $sql_docs = "SELECT COUNT(*) as total FROM documentos_empresa_generados WHERE empresa = $empresa_id";
    $result_docs = $c->mi->query($sql_docs);
    $total_documentos = mysqli_fetch_array($result_docs)['total'];

    // Contar plantillas activas
    $sql_plantillas = "SELECT COUNT(*) as total FROM plantillas_empresa WHERE activo = 1";
    $result_plantillas = $c->mi->query($sql_plantillas);
    $total_plantillas = mysqli_fetch_array($result_plantillas)['total'];

    // Contar mandatarios activos
    $sql_mandatarios = "SELECT COUNT(*) as total FROM mandatarios WHERE empresa = $empresa_id AND activo = 1";
    $result_mandatarios = $c->mi->query($sql_mandatarios);
    $total_mandatarios = mysqli_fetch_array($result_mandatarios)['total'];

    // Documentos pendientes (ejemplo: documentos sin archivo PDF)
    $sql_pendientes = "SELECT COUNT(*) as total FROM documentos_empresa_generados 
                      WHERE empresa = $empresa_id AND (archivo_pdf IS NULL OR archivo_pdf = '')";
    $result_pendientes = $c->mi->query($sql_pendientes);
    $total_pendientes = mysqli_fetch_array($result_pendientes)['total'];

    $c->desconectar();

    echo json_encode([
        'success' => true,
        'data' => [
            'documentos' => $total_documentos,
            'plantillas' => $total_plantillas,
            'mandatarios' => $total_mandatarios,
            'pendientes' => $total_pendientes
        ]
    ]);
}

function regenerarDocumento($c, $documento_id, $usuario_id)
{
    try {
        $c->conexion();

        // Obtener documento original
        $sql = "SELECT * FROM documentos_empresa_generados WHERE id = $documento_id";
        $result = $c->mi->query($sql);

        if ($row = mysqli_fetch_array($result)) {
            $contenido_generado = $row['contenido_generado'];
            $archivo_actual = $row['archivo_pdf'];
            $tipo_documento = $row['tipo_documento'];

            // Verificar si el archivo actual existe en el servidor
            $carpeta_documentos = "../documentos_generados/";
            $ruta_archivo_actual = $carpeta_documentos . $archivo_actual;
            $archivo_existe = file_exists($ruta_archivo_actual);

            // Generar nuevo PDF usando mPDF
            $mpdf = new \Mpdf\Mpdf([
                'format' => [216, 356] // Tamaño oficio
            ]);

            $mpdf->SetTitle('Documento Empresarial Regenerado');
            $mpdf->SetAuthor('Sistema Gestor de Documentos');
            $mpdf->SetCreator('iustax.cl');
            $mpdf->SetSubject('Documento Empresarial');
            $mpdf->SetDisplayMode('fullpage');

            // Generar el PDF con el contenido guardado
            $mpdf->WriteHTML($contenido_generado);

            // Crear nuevo nombre de archivo
            $fecha = date('YmdHis');
            $nuevo_nombre_archivo = 'documento_regenerado_' . $documento_id . '_' . $fecha . '.pdf';

            // Crear carpeta si no existe
            if (!file_exists($carpeta_documentos)) {
                mkdir($carpeta_documentos, 0755, true);
            }

            $nueva_ruta_completa = $carpeta_documentos . $nuevo_nombre_archivo;

            // Guardar el nuevo PDF
            $mpdf->Output($nueva_ruta_completa, 'F');

            // Actualizar el registro en la base de datos con el nuevo archivo
            // Limpiar título anterior de regeneraciones previas
            $titulo_original = $row['titulo'];
            $titulo_limpio = preg_replace('/\s*\(Regenerado.*?\)/', '', $titulo_original);
            $titulo_actualizado = $titulo_limpio . ' (Regenerado ' . date('d/m/Y H:i') . ')';
            $titulo_escaped = mysqli_real_escape_string($c->mi, $titulo_actualizado);

            $sql_update = "UPDATE documentos_empresa_generados 
                          SET archivo_pdf = '$nuevo_nombre_archivo',
                              titulo = '$titulo_escaped',
                              updated_at = NOW()
                          WHERE id = $documento_id";

            if ($c->mi->query($sql_update)) {
                // Si el archivo anterior existía, eliminarlo después de crear el nuevo
                if ($archivo_existe && !empty($archivo_actual)) {
                    if (file_exists($ruta_archivo_actual)) {
                        unlink($ruta_archivo_actual);
                    }
                }

                $c->desconectar();
                echo json_encode([
                    'success' => true,
                    'message' => 'Documento regenerado correctamente',
                    'nuevo_archivo' => $nuevo_nombre_archivo,
                    'archivo_anterior_eliminado' => $archivo_existe
                ]);
            } else {
                // Si falla la actualización, eliminar el nuevo archivo creado
                if (file_exists($nueva_ruta_completa)) {
                    unlink($nueva_ruta_completa);
                }

                $c->desconectar();
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar el registro del documento: ' . $c->mi->error
                ]);
            }
        } else {
            $c->desconectar();
            echo json_encode([
                'success' => false,
                'message' => 'Documento no encontrado'
            ]);
        }
    } catch (Exception $e) {
        $c->desconectar();
        echo json_encode([
            'success' => false,
            'message' => 'Error al regenerar documento: ' . $e->getMessage()
        ]);
    }
}

function eliminarDocumento($c, $documento_id)
{
    $c->conexion();

    // Obtener información del archivo antes de eliminar
    $sql_file = "SELECT archivo_pdf FROM documentos_empresa_generados WHERE id = $documento_id";
    $result_file = $c->mi->query($sql_file);

    if ($row_file = mysqli_fetch_array($result_file)) {
        $archivo_pdf = $row_file['archivo_pdf'];

        // Eliminar registro de base de datos
        $sql_delete = "DELETE FROM documentos_empresa_generados WHERE id = $documento_id";

        if ($c->mi->query($sql_delete)) {
            // Intentar eliminar archivo físico
            if ($archivo_pdf && file_exists("../documentos_generados/" . $archivo_pdf)) {
                unlink("../documentos_generados/" . $archivo_pdf);
            }

            $c->desconectar();
            echo json_encode(['success' => true, 'message' => 'Documento eliminado correctamente']);
        } else {
            $c->desconectar();
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el documento']);
        }
    } else {
        $c->desconectar();
        echo json_encode(['success' => false, 'message' => 'Documento no encontrado']);
    }
}

function verpdf($c, $documento_id)
{
    $c->conexion();

    // Obtener información del documento
    $sql = "SELECT archivo_pdf FROM documentos_empresa_generados WHERE id = $documento_id";
    $result = $c->mi->query($sql);

    if ($row = mysqli_fetch_array($result)) {
        $archivo_pdf = $row['archivo_pdf'];

        if ($archivo_pdf && file_exists("../documentos_generados/" . $archivo_pdf)) {
            // Redirigir al PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($archivo_pdf) . '"');
            readfile("../documentos_generados/" . $archivo_pdf);
        } else {
            echo json_encode(['success' => false, 'message' => 'Archivo PDF no encontrado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Documento no encontrado']);
    }

    $c->desconectar();
}


// Función alternativa más simple si prefieres una sola consulta
function listarDocumentosGenerados($c, $empresa_id)
{
    $c->conexion();

    $sql = "SELECT 
                d.id, 
                d.titulo, 
                d.fecha_generacion, 
                d.archivo_pdf, 
                tde.nombre as tipo_nombre,
                u.id_usu as mandatario_id,
                CONCAT(u.nombre, ' ', u.apellidos) as mandatario_nombre_completo
            FROM documentos_empresa_generados d
            INNER JOIN tipo_documento_empresa_plantilla tde ON d.tipo_documento = tde.id
            LEFT JOIN mandatarios m ON d.id = m.documento
            LEFT JOIN users u ON m.usuario = u.id_usu
            WHERE d.empresa = $empresa_id
            ORDER BY d.fecha_generacion DESC, d.id, u.nombre";

    $result = $c->mi->query($sql);
    $documentos = [];
    $documento_actual = null;

    while ($row = mysqli_fetch_array($result)) {
        // Si es un documento nuevo o el primero
        if ($documento_actual === null || $documento_actual['id'] != $row['id']) {
            // Si hay un documento anterior, agregarlo al array
            if ($documento_actual !== null) {
                $documentos[] = $documento_actual;
            }

            // Crear nuevo documento
            $documento_actual = [
                'id' => $row['id'],
                'titulo' => $row['titulo'],
                'fecha_generacion' => date('d-m-Y', strtotime($row['fecha_generacion'])),
                'archivo_pdf' => $row['archivo_pdf'],
                'tipo_nombre' => $row['tipo_nombre'],
                'mandatarios' => [],
                'estado' => 'Generado'
            ];
        }

        // Agregar mandatario si existe
        if (!empty($row['mandatario_id'])) {
            $documento_actual['mandatarios'][] = [
                'id' => $row['mandatario_id'],
                'nombre' => $row['mandatario_nombre_completo']
            ];
        }
    }

    // Agregar el último documento si existe
    if ($documento_actual !== null) {
        $documentos[] = $documento_actual;
    }

    $c->desconectar();
    echo json_encode(['success' => true, 'data' => $documentos]);
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
