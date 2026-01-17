# Instrucciones Finales - Integración del Sistema de Preview

## ⚠️ IMPORTANTE: Cambio de Arquitectura

El sistema anterior tenía:
- `finalizar()` → Genera preview (llama a `generarcontratoindividual.php`)
- `generar(url)` → Guarda contrato (llama a `generarcontratoindividual1.php`)

El sistema nuevo tiene:
- `generarPreviewContrato()` → Genera preview en memoria
- `confirmarYGuardarContrato()` → Guarda contrato

---

## 🔧 Cambios Necesarios

### Opción 1: Reemplazar Función finalizar() (RECOMENDADO)

Reemplazar la función `finalizar()` completa (línea ~1202) con:

```javascript
//Finalizar proceso de creacion de contrato
function finalizar() {
  generarPreviewContrato(); // Llama a la nueva función
}
```

**Ventaja:** Mantiene compatibilidad con código existente que llame a `finalizar()`

---

### Opción 2: Modificar Referencias Directamente

Si prefieres eliminar la complejidad, buscar y reemplazar en `contratoindividual.php`:
- Buscar: `onclick="finalizar()"`
- Reemplazar por: `onclick="generarPreviewContrato()"`

Y eliminar la función `finalizar()` completa del archivo JS.

---

## 📋 Verificaciones Post-Implementación

### 1. Verificar que el Botón Llama a la Función Correcta

En `contratoindividual.php`, buscar el botón que genera el contrato:

```html
<!-- ANTES (si existe algo así) -->
<button onclick="finalizar()">...</button>

<!-- DEBE SER -->
<button class="generar">Generar Contrato</button>
<!-- O -->
<button onclick="generarPreviewContrato()">Generar Contrato</button>
```

Ya agregamos el event listener:
```javascript
$(".generar").click(function() {
    generarPreviewContrato();
});
```

### 2. Eliminar/Comentar el Modal Antiguo (Si Existe)

Buscar en `contratoindividual.php` un modal con ID como:
- `#modalvistaprevia`
- `#vistaprevia`

Si existe, puede:
- **Eliminarlo** (ya no se usa)
- **Comentarlo** (por si necesitas referencia)

El nuevo modal es:
```html
<div id="previewContratoModal">...</div>
```

### 3. Eliminar Carpeta `uploads/previa/` (Opcional)

El sistema antiguo guardaba PDFs temporales en `uploads/previa/`.
El nuevo sistema NO guarda nada en disco hasta confirmar.

Puedes:
- Eliminar la carpeta (ya no se usa)
- Dejarla (por compatibilidad temporal)

---

## 🎯 Flujo Completo del Usuario

```
1. Usuario completa formulario
2. Click en "Generar Contrato"
3. Validación de formularios (JS)
4. Envío a generarcontratoindividual.php
5. PDF generado EN MEMORIA
6. Datos guardados en $_SESSION
7. Modal muestra PDF (nuevo modal #previewContratoModal)
8. Usuario ve el PDF
   ├─ Click "Cancelar" → Cierra modal, no guarda nada
   └─ Click "Confirmar y Guardar"
      ├─ Envío a confirmarcontrato.php
      ├─ PDF guardado en disco (uploads/Contratos/)
      ├─ Datos guardados en BD
      ├─ Sesión limpiada
      └─ Redirección a contratos.php
```

---

## 🔍 Testing Rápido

1. **Abrir** `contratoindividual.php`
2. **Completar** formulario mínimo
3. **Click** en "Generar Contrato"
4. **Verificar:**
   - ✅ Se muestra loader
   - ✅ Se abre modal nuevo (no el viejo)
   - ✅ Se ve el PDF en el iframe
   - ✅ Botón "Cancelar" cierra modal
   - ✅ Botón "Confirmar" guarda y redirige
5. **Verificar en BD:**
   - ✅ Registro en tabla `contratos`
   - ✅ Registros en `contrato_distribucion_horaria` (si aplica)
   - ✅ Registros en `contrato_estipulaciones` (si aplica)
6. **Verificar en disco:**
   - ✅ PDF guardado en `uploads/Contratos/`

---

## 🐛 Troubleshooting

### Problema: El modal no se abre
**Solución:** Verificar que el ID del modal sea `previewContratoModal` en el HTML y en el JS

### Problema: El PDF no se muestra
**Solución:** Verificar consola del navegador (F12). Posible error de CORS o base64 inválido

### Problema: Error al confirmar
**Solución:**
1. Verificar que `$_SESSION['contrato_preview']` existe
2. Verificar permisos de carpeta `uploads/Contratos/`
3. Verificar conexión a BD

### Problema: La sesión expira muy rápido
**Solución:** Aumentar tiempo en `confirmarcontrato.php` línea ~40:
```php
// Cambiar de 1800 (30 min) a 3600 (60 min)
if (time() - $preview['timestamp'] > 3600) {
```

---

## 📝 Archivos a Revisar/Modificar

| Archivo | Línea | Acción |
|---------|-------|--------|
| `JsFunctions/contrato.js` | 1202 | Reemplazar función `finalizar()` |
| `contratoindividual.php` | Buscar | Verificar referencias a `finalizar()` |
| `contratoindividual.php` | Buscar | Eliminar modal antiguo `#modalvistaprevia` |
| `database/script.sql` | - | Ejecutar ALTER TABLE y CREATE TABLE |

---

## ✅ Checklist Final

- [ ] Función `finalizar()` reemplazada o referencias actualizadas
- [ ] Modal antiguo eliminado/comentado
- [ ] Event listener del botón `.generar` funcionando
- [ ] SQL ejecutado en base de datos
- [ ] Permisos de carpeta `uploads/Contratos/` verificados (777)
- [ ] Probado flujo completo: Preview → Confirmar → Verificar BD
- [ ] Probado flujo completo: Preview → Cancelar
- [ ] Probado con datos mínimos
- [ ] Probado con todos los campos completos
- [ ] Verificado que domingos se validan correctamente
- [ ] Verificado que horas se calculan correctamente

---

**Última actualización:** 2026-01-15
**Estado:** Requiere integración final por parte del usuario
