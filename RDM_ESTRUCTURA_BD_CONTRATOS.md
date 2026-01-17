# Estructura de Base de Datos - Sistema de Contratos

## Resumen de Cambios Implementados

Este documento detalla la nueva estructura de base de datos para el sistema de contratos, incluyendo campos adicionales y tablas relacionales.

---

## 1. Tabla Principal: `contratos`

### Campos Existentes (sin cambios)
- `id` - ID autoincremental
- `trabajador` - Referencia a trabajadores(id)
- `empresa` - Referencia a empresa(id)
- `centrocosto` - Referencia a centrocosto(id)
- `tipocontrato` - Tipo de contrato (varchar)
- `cargo` - Cargo (varchar) [MANTENER para compatibilidad]
- `sueldo` - Sueldo (decimal) [MANTENER para compatibilidad]
- `fechainicio` - Fecha de inicio del contrato
- `fechatermino` - Fecha de término del contrato
- `documento` - Ruta del documento PDF (ahora nullable)
- `estado` - Estado del contrato
- `register_at` - Fecha de registro

---

## 2. Nuevos Campos Agregados a `contratos`

### A. Información Básica del Contrato
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `formato_contrato` | int | SÍ | ID del formato de contrato | tipo_contrato |
| `categoria_contrato` | varchar(200) | SÍ | Categoría del contrato | categoria_contrato |
| `fecha_suscripcion` | date | SÍ | Fecha de suscripción | fecha_suscripcion |
| `region_celebracion` | int | SÍ | Región donde se celebra | regioncelebracion |
| `comuna_celebracion` | int | SÍ | Comuna donde se celebra | comunacelebracion |
| `fecha_celebracion` | date | SÍ | Fecha de celebración | fechacelebracion |

### B. Información del Cargo y Lugar de Trabajo
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `centro_costo` | int | SÍ | Centro de costo | centrocosto |
| `cargo_id` | int | SÍ | ID del cargo | Charge |
| `cargo_descripcion` | varchar(500) | SÍ | Descripción del cargo | ChargeDescripcion |
| `region_especifica` | int | SÍ | Región específica de trabajo | regionespecifica |
| `comuna_especifica` | int | SÍ | Comuna específica de trabajo | comunaespecifica |
| `calle_especifica` | varchar(200) | SÍ | Calle del lugar de trabajo | calleespecifica |
| `numero_especifico` | varchar(20) | SÍ | Número del lugar de trabajo | numeroespecifica |
| `dept_oficina_especifico` | varchar(20) | SÍ | Depto/Oficina | departamentoespecifica |
| `territorio_zona` | tinyint(1) | NO | ¿Incluye territorio/zonas? | territoriozona |

### C. Subcontratación y Servicios Transitorios
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `subcontratacion` | tinyint(1) | NO | ¿Es subcontratación? | subcontratacionval |
| `subcontratacion_rut` | varchar(20) | SÍ | RUT empresa subcontratista | subcontratacionrut |
| `subcontratacion_razon_social` | varchar(200) | SÍ | Razón social subcontratista | subcontratacionrazonsocial |
| `servicios_transitorios` | tinyint(1) | NO | ¿Es servicio transitorio? | transitoriosval |
| `transitorios_rut` | varchar(20) | SÍ | RUT empresa transitoria | transitoriosrut |
| `transitorios_razon_social` | varchar(200) | SÍ | Razón social transitoria | transitoriosrazonsocial |

### D. Remuneración Base
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `tipo_sueldo` | int | SÍ | Tipo de sueldo | tiposueldo |
| `sueldo_base` | decimal(10,2) | SÍ | Sueldo base | sueldo |
| `asignacion_zona` | decimal(10,2) | SÍ | Asignación zona extrema | asignacion |

### E. Haberes Imponibles Tributables
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `haber_imponible_tipo` | int | SÍ | Tipo de haber | tipohaber |
| `haber_imponible_monto` | decimal(10,2) | SÍ | Monto del haber | montohaber |
| `haber_imponible_periodo` | varchar(50) | SÍ | Periodo de pago | periodohaber |
| `haber_imponible_detalle` | varchar(500) | SÍ | Detalle adicional | detallerenumeracion |

### F. Haberes No Imponibles Tributables
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `haber_no_imponible_tipo` | int | SÍ | Tipo de haber | tipohaberno |
| `haber_no_imponible_monto` | decimal(10,2) | SÍ | Monto del haber | montohaberno |
| `haber_no_imponible_periodo` | varchar(50) | SÍ | Periodo de pago | periodohaberno |
| `haber_no_imponible_detalle` | varchar(500) | SÍ | Detalle adicional | detallerenumeracionno |

### G. Haberes Imponibles No Tributables
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `haber_imponible_notributable_tipo` | int | SÍ | Tipo de haber | tipohabernotributable |
| `haber_imponible_notributable_monto` | decimal(10,2) | SÍ | Monto del haber | montohabernotributable |
| `haber_imponible_notributable_periodo` | varchar(50) | SÍ | Periodo de pago | periodohabernotributable |
| `haber_imponible_notributable_detalle` | varchar(500) | SÍ | Detalle adicional | detallerenumeracionnotributable |

### H. Haberes No Imponibles No Tributables
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `haber_no_imponible_notributable_tipo` | int | SÍ | Tipo de haber | tipohabernonotributable |
| `haber_no_imponible_notributable_monto` | decimal(10,2) | SÍ | Monto del haber | montohabernonotributable |
| `haber_no_imponible_notributable_periodo` | varchar(50) | SÍ | Periodo de pago | periodohabernonotributable |
| `haber_no_imponible_notributable_detalle` | varchar(500) | SÍ | Detalle adicional | detallerenumeracionnonotributable |

### I. Forma de Pago y Gratificación
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `forma_pago` | int | SÍ | Forma de pago gratificación | formapago |
| `periodo_pago_gratificacion` | varchar(50) | SÍ | Periodo pago gratificación | periodopagogra |
| `detalle_gratificacion` | varchar(500) | SÍ | Detalle gratificación | detallerenumeraciongra |
| `periodo_pago_trabajador` | varchar(50) | SÍ | Periodo pago trabajador | periodopagot |
| `fecha_pago_trabajador` | varchar(50) | SÍ | Fecha de pago | fechapagot |
| `forma_pago_trabajador` | int | SÍ | Forma de pago (efectivo/banco) | formapagot |
| `banco_id` | int | SÍ | ID del banco | banco |
| `tipo_cuenta_id` | int | SÍ | Tipo de cuenta bancaria | tipocuenta |
| `numero_cuenta` | varchar(50) | SÍ | Número de cuenta | numerocuenta |
| `anticipo` | varchar(50) | SÍ | Anticipo de sueldo | anticipot |

### J. Previsión Social
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `afp_id` | int | SÍ | ID de AFP | afp |
| `salud_id` | int | SÍ | ID de Salud/Isapre | salud |

### K. Pactos Adicionales
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `pacto_badi` | tinyint(1) | NO | Pacto BADI | badi |
| `otros_terminos` | text | SÍ | Otros términos pactados | otrter |

### L. Jornada Laboral
| Campo | Tipo | Nullable | Descripción | Campo Form |
|-------|------|----------|-------------|------------|
| `jornada_excepcional` | tinyint(1) | NO | ¿Jornada excepcional? | jornadaesc |
| `jornada_excluida` | tinyint(1) | NO | ¿Jornada excluida? | exluido |
| `no_resolucion` | varchar(100) | SÍ | Número de resolución | noresolucion |
| `fecha_excepcion` | date | SÍ | Fecha de excepción | exfech |
| `tipo_jornada` | int | SÍ | Tipo de jornada | tipojornada |
| `incluye_domingos` | tinyint(1) | NO | ¿Incluye domingos? | incluye |
| `dias_trabajo` | varchar(100) | SÍ | Días de trabajo | dias |
| `duracion_jornada` | varchar(50) | SÍ | Duración de jornada | duracionjor |
| `dias_trabajo_semanal` | varchar(100) | SÍ | Días semanales | diasf |
| `horario_turno` | int | SÍ | Tipo de horario/turno | horarioturno |
| `colacion` | varchar(100) | SÍ | Tiempo de colación | colacion |
| `rotativo` | varchar(50) | SÍ | Horario rotativo | rotativo |
| `colacion_imputable` | varchar(100) | SÍ | Colación imputable | colacionimp |
| `colacion_imputable_tiempo` | varchar(100) | SÍ | Tiempo imputable | colanoipu |

---

## 3. Nuevas Tablas Relacionales

### A. `contrato_distribucion_horaria`
**Propósito:** Almacenar la distribución detallada de horarios por turno y día de la semana.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | ID autoincremental |
| `contrato_id` | int | FK a contratos(id) |
| `tipo_turno` | varchar(20) | 'normal', 'matutino', 'tarde', 'noche' |
| `dia_semana` | tinyint(1) | 1=Lunes, 2=Martes, ..., 7=Domingo |
| `dia_seleccionado` | tinyint(1) | 0=No, 1=Sí |
| `hora_inicio` | time | Hora de inicio (ej: 08:00:00) |
| `hora_termino` | time | Hora de término (ej: 17:00:00) |
| `register_at` | timestamp | Fecha de registro |

**Ejemplo de datos:**
```sql
-- Turno matutino: Lunes a Viernes 08:00-17:00
INSERT INTO contrato_distribucion_horaria (contrato_id, tipo_turno, dia_semana, dia_seleccionado, hora_inicio, hora_termino)
VALUES
(1, 'matutino', 1, 1, '08:00:00', '17:00:00'), -- Lunes
(1, 'matutino', 2, 1, '08:00:00', '17:00:00'), -- Martes
(1, 'matutino', 3, 1, '08:00:00', '17:00:00'), -- Miércoles
(1, 'matutino', 4, 1, '08:00:00', '17:00:00'), -- Jueves
(1, 'matutino', 5, 1, '08:00:00', '17:00:00'), -- Viernes
(1, 'matutino', 6, 0, NULL, NULL),             -- Sábado (no seleccionado)
(1, 'matutino', 7, 0, NULL, NULL);             -- Domingo (no seleccionado)
```

**Mapeo de campos del formulario:**
- `dias11-17` → día_semana 1-7, tipo_turno='normal'
- `dias21-27` → día_semana 1-7, tipo_turno='matutino'
- `dias31-37` → día_semana 1-7, tipo_turno='tarde'
- `dias41-47` → día_semana 1-7, tipo_turno='noche'
- `hora11-17`, `horat11-17` → normal
- `hora21-27`, `horat21-27` → matutino
- `hora31-37`, `horat31-37` → tarde
- `hora41-47`, `horat41-47` → noche

---

### B. `contrato_zona_geografica`
**Propósito:** Almacenar las zonas geográficas donde el trabajador puede desplazarse.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | ID autoincremental |
| `contrato_id` | int | FK a contratos(id) |
| `tipo_zona` | varchar(20) | 'region', 'provincia', 'comuna' |
| `zona_id` | int | ID de la región/provincia/comuna |
| `register_at` | timestamp | Fecha de registro |

**Ejemplo de datos:**
```sql
-- Trabajador puede desplazarse en Región Metropolitana y sus comunas
INSERT INTO contrato_zona_geografica (contrato_id, tipo_zona, zona_id)
VALUES
(1, 'region', 13),      -- Región Metropolitana
(1, 'provincia', 131),  -- Provincia Santiago
(1, 'comuna', 13101),   -- Santiago
(1, 'comuna', 13102);   -- Providencia
```

**Mapeo de campos del formulario:**
- `zonaregion` → tipo_zona='region'
- `zonaprovincia` → tipo_zona='provincia'
- `zonacomuna` → tipo_zona='comuna'
- Los IDs seleccionados en las tablas dinámicas se guardan aquí

---

### C. `contrato_estipulaciones`
**Propósito:** Almacenar estipulaciones adicionales del contrato (cláusulas especiales).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | ID autoincremental |
| `contrato_id` | int | FK a contratos(id) |
| `numero_estipulacion` | tinyint | Número de estipulación (1-13) |
| `contenido` | text | Texto de la estipulación |
| `register_at` | timestamp | Fecha de registro |

**Ejemplo de datos:**
```sql
INSERT INTO contrato_estipulaciones (contrato_id, numero_estipulacion, contenido)
VALUES
(1, 1, 'El trabajador se compromete a...'),
(1, 2, 'La empresa proporcionará...'),
(1, 3, 'Ambas partes acuerdan...');
```

**Mapeo de campos del formulario:**
- `estipulacion1` → numero_estipulacion=1
- `estipulacion2` → numero_estipulacion=2
- ... hasta `estipulacion13`

---

## 4. Consideraciones Importantes

### Campos Nullables
✅ **Todos los nuevos campos son NULL** para mantener compatibilidad con registros existentes.

### Campos Duplicados
⚠️ Existen algunos campos duplicados entre la estructura antigua y nueva:
- `cargo` (antiguo) vs `cargo_id` + `cargo_descripcion` (nuevo)
- `sueldo` (antiguo) vs `sueldo_base` (nuevo)
- `centrocosto` (antiguo) vs `centro_costo` (nuevo)

**Recomendación:** Mantener ambos temporalmente para compatibilidad, migrar gradualmente.

### Contrato Express vs Contrato Normal
- **Contrato Express:** `formato_contrato` = NULL (no genera PDF)
- **Contrato Normal:** `formato_contrato` = ID del formato seleccionado

### Distribución Horaria
- Solo se guardan registros para los turnos que fueron configurados
- Si un día no está seleccionado: `dia_seleccionado=0`, `hora_inicio=NULL`, `hora_termino=NULL`
- Si incluye domingos está desmarcado, el domingo (día 7) tendrá `dia_seleccionado=0`

### Zonas Geográficas
- Solo se guardan si `territorio_zona=1` en la tabla contratos
- Se pueden tener múltiples registros por contrato (varias regiones, provincias, comunas)

---

## 5. Script de Migración

El script SQL completo se encuentra en: `database/script.sql`

Para aplicar los cambios:
```sql
-- 1. Ejecutar el ALTER TABLE para agregar los nuevos campos
-- 2. Crear las nuevas tablas relacionales
-- 3. Crear los índices para rendimiento
```

**IMPORTANTE:** Hacer backup de la base de datos antes de ejecutar.

---

## 6. Próximos Pasos

1. ✅ Estructura de BD definida
2. ⏳ Actualizar PHP para insertar en nuevas tablas
3. ⏳ Crear funciones para recuperar distribución horaria
4. ⏳ Crear funciones para recuperar zonas geográficas
5. ⏳ Actualizar formulario de edición de contratos
6. ⏳ Migrar datos existentes (si es necesario)

---

**Fecha de creación:** 2026-01-15
**Última actualización:** 2026-01-15
