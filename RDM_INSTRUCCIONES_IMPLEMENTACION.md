# 📋 INSTRUCCIONES DE IMPLEMENTACIÓN - Sistema de Eliminación de Contratos

## ✅ Archivos Ya Creados/Modificados

Los siguientes archivos ya están listos y funcionando:

1. ✅ **[php/obtener/detalles_contrato_eliminacion.php](php/obtener/detalles_contrato_eliminacion.php)**
   - Obtiene los detalles del contrato y registros relacionados
   - **LISTO PARA USAR**

2. ✅ **[php/eliminar/contrato.php](php/eliminar/contrato.php)**
   - Procesa la eliminación en cascada con transacciones
   - **LISTO PARA USAR**

3. ✅ **[JsFunctions/Trabajadores.js](JsFunctions/Trabajadores.js)** (líneas 996-1149)
   - Función `eliminarcontrato(id)` actualizada con modal detallado
   - **LISTO PARA USAR**

---

## ⚠️ PASOS PENDIENTES PARA COMPLETAR LA IMPLEMENTACIÓN

### PASO 1: Agregar Métodos al Controller

Debes abrir el archivo **[php/controller.php](php/controller.php)** y agregar los métodos que faltan.

**Ubicación:** Al final de la clase `Controller`, antes del último `}` (aproximadamente línea 12,490)

**Métodos a agregar:** Todos los métodos del archivo **[php/METODOS_FALTANTES_CONTROLLER.php](php/METODOS_FALTANTES_CONTROLLER.php)**

#### Instrucciones detalladas:

1. Abre el archivo: `php/controller.php`

2. Ve al final del archivo (línea ~12,490)

3. Busca el último `}` de la clase Controller

4. **ANTES** de ese `}`, copia y pega todos los métodos del archivo `php/METODOS_FALTANTES_CONTROLLER.php`

5. Los métodos a agregar son:

   **A. Métodos de Transacciones (3 métodos):**
   - `iniciarTransaccion()`
   - `commitTransaccion()`
   - `rollbackTransaccion()`

   **B. Métodos de Listado (10 métodos):**
   - `listarasistenciasporcontrato($contrato)`
   - `listarliquidacionesporcontrato($contrato)`
   - `listarfiniquitosporcontrato($contrato)`
   - `listarcontratosfirmadosporcontrato($contrato)`
   - `listaranexosporcontrato($contrato)`
   - `listardocumentosporcontrato($contrato)`
   - `listarhoraspactadasporcontrato($contrato)`
   - `listardetallelotesporcontrato($contrato)`
   - `listarlote2porcontrato($contrato)`
   - `listarlote4porcontrato($contrato)`

   **C. Métodos de Eliminación (10 métodos):**
   - `eliminardetalleliquidacion($idLiquidacion)`
   - `eliminaraporteempleador($idLiquidacion)`
   - `eliminarclausulasanexo($idAnexo)`
   - `eliminarnotificacionesfiniquito($idFiniquito)`
   - `eliminarfiniquitosfirmados($idFiniquito)`
   - `eliminarlote3finiquito($idFiniquito)`
   - `eliminarhoraspactadas($id)`
   - `eliminardetallelote($id)`
   - `eliminarlote2($id)`
   - `eliminarlote4($id)`

---

### PASO 2: Verificar Métodos Existentes

Algunos métodos ya existen en el controller. Verifica que estos métodos estén implementados correctamente:

#### Métodos que YA DEBEN EXISTIR:

- ✅ `buscarcontratoid($id)` - línea ~6498
- ✅ `buscartrabajadorid($id)` - Verificar que exista
- ✅ `buscarasistenciacontrato($id)` - línea ~6514
- ✅ `buscarfiniquitocontrato($id)` - línea ~6527
- ✅ `buscarcontratofirmadocontrato($id)` - línea ~6540
- ✅ `buscaranexoscontrato($id)` - línea ~6566
- ✅ `eliminarcontrato($id)` - línea ~6498
- ✅ `eliminarasistencia($id)` - línea ~9933
- ✅ `eliminarliquidacion($id)` - línea ~10397
- ✅ `eliminarfiniquito($id)` - línea ~6136
- ✅ `eliminarcontratofirmado($id)` - línea ~8846
- ✅ `eliminardocumento($id)` - línea ~7119
- ✅ `eliminaranexo($id)` - línea ~6959

Si alguno de estos métodos NO existe, debes implementarlo siguiendo el patrón de los métodos en `METODOS_FALTANTES_CONTROLLER.php`.

---

### PASO 3: Verificar Clases de Objetos

Asegúrate de que las siguientes clases existan y tengan el método `getId()`:

- ✅ `Liquidacion` - Archivo: `php/Class/Liquidacion.php`
- ✅ `Finiquitos` - Archivo: `php/Class/Finiquitos.php`
- ✅ `Anexo` - Archivo: `php/Class/Anexo.php`
- ✅ `Documento` - Archivo: `php/Class/Documento.php`
- ✅ `Trabajadores` - Archivo: `php/Class/Trabajadores.php`

Para `listarasistenciasporcontrato()`, si no existe una clase `Asistencia`, se usa `stdClass()` (ya implementado).

---

### PASO 4: Ajustar Nombres de Métodos en Clases

Verifica que los objetos tengan los métodos getter necesarios. Por ejemplo:

**Para la clase Liquidacion:**
```php
public function getId() { return $this->id; }
public function getFolio() { return $this->folio; }
public function getContrato() { return $this->contrato; }
// ... etc
```

**Para la clase Finiquitos:**
```php
public function getId() { return $this->id; }
public function getContrato() { return $this->contrato; }
public function getTipodocumento() { return $this->tipodocumento; }
// ... etc
```

Si algún método getter no existe, agrégalo a la clase correspondiente.

---

### PASO 5: Probar el Sistema

Una vez agregados todos los métodos al controller:

1. **Prueba en un entorno de desarrollo primero**
2. Intenta eliminar un contrato de prueba
3. Verifica que:
   - ✅ Se muestre el modal con los detalles
   - ✅ Se listen todos los registros relacionados
   - ✅ Al confirmar, se eliminen todos los registros
   - ✅ Se eliminen los archivos físicos
   - ✅ La transacción funcione correctamente
   - ✅ Si hay error, se haga rollback

---

## 🔍 VERIFICACIÓN DE IMPLEMENTACIÓN

Usa este checklist para verificar que todo esté correcto:

### Checklist de Métodos en Controller:

- [ ] `iniciarTransaccion()` agregado
- [ ] `commitTransaccion()` agregado
- [ ] `rollbackTransaccion()` agregado
- [ ] `listarasistenciasporcontrato()` agregado
- [ ] `listarliquidacionesporcontrato()` agregado
- [ ] `listarfiniquitosporcontrato()` agregado
- [ ] `listarcontratosfirmadosporcontrato()` agregado
- [ ] `listaranexosporcontrato()` agregado
- [ ] `listardocumentosporcontrato()` agregado
- [ ] `listarhoraspactadasporcontrato()` agregado
- [ ] `listardetallelotesporcontrato()` agregado
- [ ] `listarlote2porcontrato()` agregado
- [ ] `listarlote4porcontrato()` agregado
- [ ] `eliminardetalleliquidacion()` agregado
- [ ] `eliminaraporteempleador()` agregado
- [ ] `eliminarclausulasanexo()` agregado
- [ ] `eliminarnotificacionesfiniquito()` agregado
- [ ] `eliminarfiniquitosfirmados()` agregado
- [ ] `eliminarlote3finiquito()` agregado
- [ ] `eliminarhoraspactadas()` agregado
- [ ] `eliminardetallelote()` agregado
- [ ] `eliminarlote2()` agregado
- [ ] `eliminarlote4()` agregado

### Checklist de Pruebas:

- [ ] Modal de confirmación se muestra correctamente
- [ ] Se listan todos los registros relacionados
- [ ] Contador de registros es correcto
- [ ] Al confirmar, se eliminan todos los registros
- [ ] Archivos físicos se eliminan del servidor
- [ ] Si hay error, se hace rollback correctamente
- [ ] Mensaje de éxito aparece después de eliminar
- [ ] La página se recarga y el contrato ya no aparece

---

## 🚨 SOLUCIÓN DE PROBLEMAS

### Error: "Call to undefined method"

**Causa:** Falta algún método en el controller o en alguna clase.

**Solución:** Verifica que hayas agregado todos los métodos listados arriba.

### Error: "Call to a member function on null"

**Causa:** Algún método de listado retorna null cuando debería retornar un array vacío.

**Solución:** Asegúrate de que los métodos `listar*` retornen `null` o un array, nunca false.

### La transacción no funciona

**Causa:** Los métodos de transacción no están correctamente implementados.

**Solución:** Verifica que `iniciarTransaccion()`, `commitTransaccion()` y `rollbackTransaccion()` estén implementados como se muestra en `METODOS_FALTANTES_CONTROLLER.php`.

### No se eliminan los archivos físicos

**Causa:** La ruta de los archivos es incorrecta.

**Solución:** Verifica las rutas en `php/eliminar/contrato.php`:
- `../../uploads/Contratos/`
- `../../uploads/ContratosFirmados/`
- `../../uploads/Documentos/`

---

## 📞 SOPORTE

Si encuentras algún problema durante la implementación:

1. Verifica los errores en la consola del navegador (F12)
2. Verifica los errores de PHP en el log del servidor
3. Usa `console.log()` en JavaScript para debug
4. Usa `var_dump()` o `error_log()` en PHP para debug

---

## ✅ RESUMEN

Una vez completados los 5 pasos anteriores, el sistema de eliminación de contratos estará completamente funcional y permitirá:

1. ✅ Mostrar un modal detallado antes de eliminar
2. ✅ Listar todos los registros que se eliminarán
3. ✅ Eliminar en cascada con transacciones
4. ✅ Eliminar archivos físicos del servidor
5. ✅ Revertir cambios si hay errores (rollback)
6. ✅ Confirmar solo si el usuario acepta explícitamente

**¡Buena suerte con la implementación!** 🚀
