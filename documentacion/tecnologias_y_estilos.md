# Documentación de Tecnologías, Estilos y Plugins

Este documento detalla el stack tecnológico del sistema **GD2.0**, los frameworks y plugins (de PHP, JavaScript y CSS) utilizados, así como la guía de estilos visuales de la aplicación.

---

## 1. Tecnologías Principales (Stack)

*   **Servidor de Aplicación**: PHP 7.x / 8.x en entorno Apache (XAMPP).
*   **Base de Datos**: MySQL 5.7+ / MariaDB 10.x.
*   **Cliente / Frontend**: HTML5, CSS3, JavaScript (ES6+).

---

## 2. Dependencias de PHP (Backend)

Las dependencias de PHP están integradas mediante **Composer** y se definen en el archivo [php/plugins/composer.json](file:///c:/xampp/htdocs/GD2.0/php/plugins/composer.json).

```json
{
    "require": {
        "mpdf/mpdf": "^8.1",
        "phpoffice/phpspreadsheet": "^1.27",
        "tecnickcom/tcpdf": "^6.6"
    }
}
```

### Detalle de Plugins PHP:
1.  **`mpdf/mpdf` (v8.1)**:
    *   *Propósito*: Generación principal de PDFs a partir de HTML/CSS.
    *   *Uso en el sistema*: Es el motor utilizado para la generación de contratos individuales y masivos ([generarcontratoindividual.php](file:///c:/xampp/htdocs/GD2.0/php/pdf/generarcontratoindividual.php)). Facilita la aplicación de CSS para definir márgenes y marcas de agua.
2.  **`tecnickcom/tcpdf` (v6.6)**:
    *   *Propósito*: Generación y manipulación alternativa de archivos PDF.
    *   *Uso en el sistema*: Utilizado en algunos flujos específicos de generación de documentos y plantillas personalizadas.
3.  **`phpoffice/phpspreadsheet` (v1.27)**:
    *   *Propósito*: Lectura y escritura de hojas de cálculo de Microsoft Excel (`.xlsx`, `.xls`) y archivos `.csv`.
    *   *Uso en el sistema*: Utilizado en la carga masiva de asistencia ([cargaasistencia.php](file:///c:/xampp/htdocs/GD2.0/cargaasistencia.php)), carga de datos de empresas ([cargaempresa.php](file:///c:/xampp/htdocs/GD2.0/cargaempresa.php)) y exportación de reportes previsionales.

---

## 3. Plugins y Librerías de JavaScript (Frontend)

Ubicados principalmente en la carpeta [JsFunctions/](file:///c:/xampp/htdocs/GD2.0/JsFunctions) y en [assets/plugins/](file:///c:/xampp/htdocs/GD2.0/assets/plugins).

*   **jQuery**:
    *   *Propósito*: Simplificación de la manipulación del DOM, control de eventos y envío de solicitudes AJAX.
    *   *Uso*: Utilizado de forma transversal en todos los formularios interactivos para enviar y recibir datos en formato JSON.
*   **Select2**:
    *   *Propósito*: Reemplazo de los elementos `<select>` nativos del navegador por selectores interactivos con soporte de filtrado y búsqueda.
    *   *Uso*: Selección dinámica de trabajadores, comunas, AFP, Isapres y centros de costo.
*   **DataTables**:
    *   *Propósito*: Transformación de tablas HTML estáticas en cuadrículas interactivas de datos.
    *   *Uso*: Utilizado en los listados maestros de empresas, trabajadores y auditorías, agregando buscador integrado, ordenamiento por columnas, paginación y exportación a formatos Excel, CSV o PDF.
*   **TinyMCE**:
    *   *Propósito*: Editor de texto enriquecido (WYSIWYG) incrustado en la web.
    *   *Uso*: Edición y redacción dinámica de contratos y plantillas personalizadas en [redactardocumento.php](file:///c:/xampp/htdocs/GD2.0/redactardocumento.php).
*   **AutoNumeric**:
    *   *Propósito*: Formateo en tiempo real de números y monedas mientras el usuario escribe.
    *   *Uso*: Aplicado en los campos de sueldo base, haberes y montos de bonificaciones para evitar ingresos inválidos.
*   **Toastify**:
    *   *Propósito*: Notificaciones no intrusivas en forma de banners flotantes temporales.
    *   *Uso*: Mostrar notificaciones de éxito o error al guardar datos, cambiar el estado de un contrato o al realizar validaciones asíncronas.

---

## 4. Diseño Visual y Estilos (CSS)

El sistema implementa una plantilla web basada en **Bootstrap 4** con hojas de estilo personalizadas para manejar skins y variaciones de visualización.

### A. Archivos CSS Clave:
*   [assets/plugins/bootstrap/css/bootstrap.min.css](file:///c:/xampp/htdocs/GD2.0/assets/plugins/bootstrap/css/bootstrap.min.css): Base responsiva del layout.
*   [assets/css/style.css](file:///c:/xampp/htdocs/GD2.0/assets/css/style.css): Estilo general de la plantilla administrativa.
*   [assets/css/colors/color.css](file:///c:/xampp/htdocs/GD2.0/assets/css/colors/color.css): Define la paleta de colores global y las propiedades de acento.
*   `dark-boxed.css` / `dark-style.css`: Hojas de estilo para la implementación de la variante de diseño oscuro (Dark Mode).

### B. Paleta de Colores Corporativa:

*   **Primary / Acento Principal**: `#214fbe` (Azul Rey / Navy Blue).
*   **Primary Hover**: `#1d439e` (Azul Rey Oscuro).
*   **Gradiente Primario**: `linear-gradient(to top, #2556cc, #4785fc)`. Usado en el encabezado de las tarjetas y botones principales.
*   **Background General**: `#ecedef` (Gris claro que disminuye el cansancio visual).
*   **Primary Transparent**: `rgba(29, 81, 235, 0.1)`. Usado como color de selección o focus.
*   **Success / Éxito**: `#22c55e` (Verde). Usado para indicar que un contrato o documento está firmado y aprobado.
*   **Warning / Alerta**: `#f59e0b` (Naranja). Usado para documentos pendientes de firma.
*   **Danger / Error**: `#ef4444` (Rojo). Usado para documentos rechazados, inactivos o finiquitados.
