# Métodos Requeridos en el Controller para Eliminación de Contratos

Este documento lista todos los métodos que deben estar implementados en el archivo `controller.php` para que el sistema de eliminación de contratos funcione correctamente.

## Métodos de Búsqueda/Listado

### 1. Trabajadores
- `buscartrabajadorid($id)` - Buscar trabajador por ID

### 2. Contratos
- `buscarcontratoid($id)` - Buscar contrato por ID
- `eliminarcontrato($id)` - Eliminar contrato

### 3. Asistencias
- `buscarasistenciacontrato($id)` - Verificar si hay asistencias
- `listarasistenciasporcontrato($id)` - Listar todas las asistencias del contrato
- `eliminarasistencia($id)` - Eliminar asistencia

### 4. Finiquitos
- `buscarfiniquitocontrato($id)` - Verificar si hay finiquitos
- `listarfiniquitosporcontrato($id)` - Listar todos los finiquitos del contrato
- `eliminarfiniquito($id)` - Eliminar finiquito
- `eliminardetallefiniquito($idFiniquito)` - Eliminar detalles del finiquito
- `eliminarnotificacionesfiniquito($idFiniquito)` - Eliminar notificaciones del finiquito
- `eliminarfiniquitosfirmados($idFiniquito)` - Eliminar finiquitos firmados
- `eliminarlote3finiquito($idFiniquito)` - Eliminar lote3

### 5. Contratos Firmados
- `buscarcontratofirmadocontrato($id)` - Verificar si hay contratos firmados
- `listarcontratosfirmadosporcontrato($id)` - Listar contratos firmados
- `eliminarcontratofirmado($id)` - Eliminar contrato firmado

### 6. Anexos
- `buscaranexoscontrato($id)` - Verificar si hay anexos
- `listaranexosporcontrato($id)` - Listar anexos del contrato
- `eliminaranexo($id)` - Eliminar anexo
- `eliminarclausulasanexo($idAnexo)` - Eliminar cláusulas del anexo

### 7. Documentos
- `listardocumentosporcontrato($id)` - Listar documentos del contrato
- `eliminardocumento($id)` - Eliminar documento

### 8. Liquidaciones
- `listarliquidacionesporcontrato($id)` - Listar liquidaciones del contrato
- `eliminarliquidacion($id)` - Eliminar liquidación
- `eliminardetalleliquidacion($idLiquidacion)` - Eliminar detalle de liquidación
- `eliminaraporteempleador($idLiquidacion)` - Eliminar aporte empleador

### 9. Horas Pactadas
- `listarhoraspactadasporcontrato($id)` - Listar horas pactadas del contrato
- `eliminarhoraspactadas($id)` - Eliminar horas pactadas

### 10. Lotes
- `listardetallelotesporcontrato($id)` - Listar detalle de lotes
- `eliminardetallelote($id)` - Eliminar detalle de lote
- `listarlote2porcontrato($id)` - Listar lote2
- `eliminarlote2($id)` - Eliminar lote2
- `listarlote4porcontrato($id)` - Listar lote4
- `eliminarlote4($id)` - Eliminar lote4

### 11. Transacciones
- `iniciarTransaccion()` - Iniciar transacción de base de datos
- `commitTransaccion()` - Confirmar transacción
- `rollbackTransaccion()` - Revertir transacción

## Ejemplo de Implementación de Transacciones

```php
class Controller {
    private $conn; // Conexión a la base de datos

    public function iniciarTransaccion() {
        $this->conn->begin_transaction();
    }

    public function commitTransaccion() {
        $this->conn->commit();
    }

    public function rollbackTransaccion() {
        $this->conn->rollback();
    }
}
```

## Notas Importantes

1. **Transacciones**: Es crucial que los métodos de transacción estén implementados correctamente para garantizar la integridad de los datos.

2. **Orden de Eliminación**: El archivo `php/eliminar/contrato.php` elimina los registros en un orden específico para evitar errores de claves foráneas:
   - Asistencias
   - Liquidaciones (detalle → aporte → liquidación)
   - Anexos (cláusulas → anexo)
   - Finiquitos (detalle → notificaciones → firmados → lote3 → finiquito)
   - Contratos firmados
   - Documentos
   - Horas pactadas
   - Lotes (detalle, lote2, lote4)
   - Finalmente el contrato

3. **Archivos Físicos**: El sistema elimina automáticamente los archivos físicos almacenados en:
   - `uploads/Contratos/`
   - `uploads/ContratosFirmados/`
   - `uploads/Documentos/`

4. **Retorno de Métodos de Listado**: Los métodos `listar*` deben retornar:
   - Un array de objetos si hay registros
   - Un array vacío o `null` si no hay registros

5. **Retorno de Métodos de Eliminación**: Los métodos `eliminar*` deben retornar:
   - `true` si la eliminación fue exitosa
   - `false` si hubo un error

## Pruebas Recomendadas

Antes de usar en producción, verifica:
1. Que todos los métodos estén implementados
2. Que las transacciones funcionen correctamente
3. Que los archivos físicos se eliminen
4. Que no queden registros huérfanos en la base de datos
