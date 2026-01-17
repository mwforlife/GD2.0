# Implementación Backend - Sistema de Contratos

## Archivos Creados/Modificados

### 1. `database/script.sql`
- ✅ Modificada estructura de BD para usar `cargo` (varchar) en lugar de `cargo_id`
- ✅ Agregados más de 60 campos nuevos a la tabla `contratos`
- ✅ Creadas 3 tablas relacionales:
  - `contrato_distribucion_horaria` - Para horarios por turno
  - `contrato_zona_geografica` - Para zonas de desplazamiento
  - `contrato_estipulaciones` - Para cláusulas adicionales

### 2. `php/pdf/contrato_helper.php` ✨ NUEVO
Archivo auxiliar con funciones reutilizables:
- `capturarDatosContrato()` - Captura y valida TODOS los campos del formulario
- `capturarDistribucionHoraria()` - Procesa los 4 turnos × 7 días
- `capturarEstipulaciones()` - Procesa las 13 estipulaciones posibles
- `prepararSQLInsertContrato()` - Genera SQL prepared statement
- `prepararParametrosInsert()` - Prepara array de parámetros
- Funciones de validación: `validarNumero()`, `validarFecha()`, `obtenerPost()`

---

## Próximos Pasos de Implementación

### PASO 1: Modificar `generarcontratoindividual.php` (PREVIEW)

Este archivo debe generar el PDF en **memoria temporal** para mostrar preview:

```php
<?php
require '../controller.php';
require 'contrato_helper.php';
$c = new Controller();
$helper = new ContratoHelper($c);

try {
    // 1. Capturar todos los datos
    $datos = $helper->capturarDatosContrato();

    // 2. Procesar datos para el template
    // ... (convertir IDs a nombres, formatear fechas, etc.)

    // 3. Generar HTML del contrato
    $contenido = $c->buscarplantilla($datos['tipocontratoid']);
    // ... (reemplazar variables en el template)

    // 4. Generar PDF en MEMORIA (no guardar en disco)
    $mpdf = new \Mpdf\Mpdf([/* configuración */]);
    $mpdf->WriteHTML($contenido);

    // 5. Devolver PDF como string base64 para preview
    $pdfContent = $mpdf->Output('', 'S'); // 'S' = return as string
    $pdfBase64 = base64_encode($pdfContent);

    // 6. Guardar datos en sesión temporal para confirmar después
    $_SESSION['contrato_temp'] = [
        'datos' => $datos,
        'pdf_content' => $pdfContent,
        'timestamp' => time()
    ];

    // 7. Responder con JSON
    echo json_encode([
        'success' => true,
        'pdf' => $pdfBase64,
        'message' => 'Preview generado exitosamente'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
```

### PASO 2: Crear `confirmarcontrato.php` (GUARDAR DEFINITIVO)

Este archivo se llama cuando el usuario confirma el contrato:

```php
<?php
require '../controller.php';
require 'contrato_helper.php';
$c = new Controller();
$helper = new ContratoHelper($c);

try {
    // 1. Recuperar datos de sesión temporal
    if (!isset($_SESSION['contrato_temp'])) {
        throw new Exception("No hay contrato pendiente de confirmación");
    }

    $temp = $_SESSION['contrato_temp'];
    $datos = $temp['datos'];
    $pdfContent = $temp['pdf_content'];

    // 2. Verificar que no haya expirado (ej: 30 minutos)
    if (time() - $temp['timestamp'] > 1800) {
        throw new Exception("La sesión de preview ha expirado");
    }

    // 3. Generar nombre único del documento
    $timestamp = date('Ymdhis');
    $nombreDocumento = "Contrato_{$timestamp}.pdf";

    // 4. Guardar PDF en disco
    $rutaArchivo = "../../uploads/Contratos/{$nombreDocumento}";
    file_put_contents($rutaArchivo, $pdfContent);

    // 5. Preparar INSERT del contrato principal
    $sql = $helper->prepararSQLInsertContrato($datos);
    $params = $helper->prepararParametrosInsert($datos, $nombreDocumento, $tipoContrato, $sueldoNumerico);

    // 6. Insertar contrato (usar prepared statement)
    $contratoId = $c->ejecutarInsertPreparado($sql, $params);

    if (!$contratoId) {
        throw new Exception("Error al guardar el contrato");
    }

    // 7. Insertar distribución horaria
    foreach ($datos['distribucion_horaria'] as $horario) {
        $c->query("INSERT INTO contrato_distribucion_horaria
            (contrato_id, tipo_turno, dia_semana, dia_seleccionado, hora_inicio, hora_termino)
            VALUES
            ({$contratoId}, '{$horario['turno']}', {$horario['dia']}, {$horario['seleccionado']},
             " . ($horario['hora_inicio'] ? "'{$horario['hora_inicio']}'" : "NULL") . ",
             " . ($horario['hora_termino'] ? "'{$horario['hora_termino']}'" : "NULL") . ")");
    }

    // 8. Insertar zonas geográficas (si aplica)
    if ($datos['territoriozona'] == 1) {
        // Insertar regiones, provincias, comunas seleccionadas
        // ... código para procesar tablas de zonas
    }

    // 9. Insertar estipulaciones
    foreach ($datos['estipulaciones'] as $est) {
        $c->query("INSERT INTO contrato_estipulaciones
            (contrato_id, numero_estipulacion, contenido)
            VALUES ({$contratoId}, {$est['numero']}, '{$est['contenido']}')");
    }

    // 10. Registrar auditoría
    $usuario = $_SESSION['USER_ID'];
    $trabajador = $c->buscartrabajador($datos['idtrabajador']);
    $eventos = "Registró contrato para " . $trabajador->getNombre();
    $c->RegistrarAuditoriaEventos($usuario, $eventos);

    // 11. Limpiar sesión temporal
    unset($_SESSION['contrato_temp']);

    // 12. Responder con éxito
    echo json_encode([
        'success' => true,
        'contrato_id' => $contratoId,
        'documento' => $nombreDocumento,
        'message' => 'Contrato registrado exitosamente'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
```

### PASO 3: Modificar Frontend (JavaScript)

En `JsFunctions/contrato.js`, crear función para enviar y preview:

```javascript
function generarPreviewContrato() {
    // 1. Obtener todos los datos del formulario
    var formData = new FormData(document.getElementById('formContrato'));

    // 2. Enviar a generar preview
    fetch('php/pdf/generarcontratoindividual.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 3. Mostrar PDF en modal
            mostrarPreviewPDF(data.pdf);
        } else {
            ToastifyError(data.error);
        }
    })
    .catch(error => {
        ToastifyError('Error al generar preview: ' + error);
    });
}

function mostrarPreviewPDF(pdfBase64) {
    // Crear modal con iframe para mostrar el PDF
    var pdfBlob = base64ToBlob(pdfBase64, 'application/pdf');
    var pdfUrl = URL.createObjectURL(pdfBlob);

    // Mostrar en modal con botones: "Confirmar" y "Cancelar"
    $('#previewModal iframe').attr('src', pdfUrl);
    $('#previewModal').modal('show');
}

function confirmarContrato() {
    // Enviar confirmación
    fetch('php/pdf/confirmarcontrato.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            ToastifySuccess('Contrato registrado exitosamente');
            window.location.href = 'contratos.php';
        } else {
            ToastifyError(data.error);
        }
    });
}
```

---

## Consideraciones Importantes

### 🔴 Seguridad
1. **Validar TODOS los datos** en el backend
2. **Usar prepared statements** para evitar SQL injection
3. **Validar permisos** del usuario antes de guardar
4. **Limpiar sesiones temporales** después de confirmar o expirar

### ⚡ Rendimiento
1. **Limitar tamaño de sesión** - Solo guardar datos esenciales
2. **Limpiar sesiones expiradas** - Crear cron job
3. **Optimizar consultas** - Usar transacciones para múltiples INSERTs

### 📝 Manejo de Errores
1. **Try-catch en todas las operaciones** críticas
2. **Rollback en caso de error** (usar transacciones)
3. **Logs detallados** para debugging
4. **Mensajes claros** al usuario

### 🧪 Testing
1. Probar con datos mínimos (contrato express)
2. Probar con datos completos (contrato normal)
3. Probar expiración de sesión
4. Probar errores de validación

---

## Flujo Completo

```
[Usuario completa formulario]
        ↓
[Click en "Generar Preview"]
        ↓
[Frontend: Envía FormData → generarcontratoindividual.php]
        ↓
[Backend: Valida datos + Genera PDF en memoria]
        ↓
[Backend: Guarda datos en $_SESSION['contrato_temp']]
        ↓
[Backend: Retorna PDF como base64]
        ↓
[Frontend: Muestra PDF en modal con botones]
        ↓
    ┌───────┴───────┐
    ↓               ↓
[Cancelar]   [Confirmar]
    ↓               ↓
[Limpiar]   [Envía → confirmarcontrato.php]
                    ↓
         [Backend: Recupera datos de sesión]
                    ↓
         [Backend: Guarda PDF en disco]
                    ↓
         [Backend: INSERT en contratos]
                    ↓
         [Backend: INSERT distribución horaria]
                    ↓
         [Backend: INSERT zonas geográficas]
                    ↓
         [Backend: INSERT estipulaciones]
                    ↓
         [Backend: Limpia sesión]
                    ↓
         [Backend: Retorna success]
                    ↓
         [Frontend: Redirecciona a lista]
```

---

**Fecha:** 2026-01-15
**Estado:** Helper creado, pendiente implementar archivos PHP principales
