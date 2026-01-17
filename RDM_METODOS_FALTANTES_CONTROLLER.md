<?php
/**
 * MÉTODOS FALTANTES PARA EL CONTROLLER
 *
 * Estos métodos deben agregarse al archivo controller.php
 * para que el sistema de eliminación de contratos funcione correctamente.
 *
 * Copiar y pegar estos métodos al final de la clase Controller
 * antes del cierre de la clase (antes del último })
 */

// ==================================================================================
// MÉTODOS DE TRANSACCIONES
// ==================================================================================

/**
 * Inicia una transacción en la base de datos
 */
public function iniciarTransaccion()
{
    $this->conexion();
    $this->mi->autocommit(FALSE);
    $this->mi->begin_transaction();
}

/**
 * Confirma (commit) la transacción actual
 */
public function commitTransaccion()
{
    $this->mi->commit();
    $this->mi->autocommit(TRUE);
    $this->desconectar();
}

/**
 * Revierte (rollback) la transacción actual
 */
public function rollbackTransaccion()
{
    $this->mi->rollback();
    $this->mi->autocommit(TRUE);
    $this->desconectar();
}

// ==================================================================================
// MÉTODOS DE LISTADO POR CONTRATO
// ==================================================================================

/**
 * Lista todas las asistencias de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos Asistencia o null
 */
public function listarasistenciasporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM asistencia WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $asistencias = array();
    while ($row = $result->fetch_assoc()) {
        // Crear objeto Asistencia (ajustar según tu clase)
        $asistencia = new stdClass();
        $asistencia->id = $row['id'];
        $asistencia->fecha = $row['fecha'];
        $asistencia->estado = $row['estado'];
        $asistencia->trabajador = $row['trabajador'];
        $asistencia->contrato = $row['contrato'];
        $asistencias[] = $asistencia;
    }

    $stmt->close();
    $this->desconectar();

    return count($asistencias) > 0 ? $asistencias : null;
}

/**
 * Lista todas las liquidaciones de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos Liquidacion o null
 */
public function listarliquidacionesporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM liquidaciones WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $liquidaciones = array();
    while ($row = $result->fetch_assoc()) {
        // Crear objeto Liquidacion
        $liquidacion = new Liquidacion();
        $liquidacion->setId($row['id']);
        $liquidacion->setFolio($row['folio']);
        $liquidacion->setContrato($row['contrato']);
        $liquidacion->setPeriodo($row['periodo']);
        $liquidacion->setEmpresa($row['empresa']);
        $liquidacion->setTrabajador($row['trabajador']);
        $liquidaciones[] = $liquidacion;
    }

    $stmt->close();
    $this->desconectar();

    return count($liquidaciones) > 0 ? $liquidaciones : null;
}

/**
 * Lista todos los finiquitos de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos Finiquito o null
 */
public function listarfiniquitosporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM finiquito WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $finiquitos = array();
    while ($row = $result->fetch_assoc()) {
        // Crear objeto Finiquito
        $finiquito = new Finiquitos();
        $finiquito->setId($row['id']);
        $finiquito->setContrato($row['contrato']);
        $finiquito->setTipodocumento($row['tipodocumento']);
        $finiquito->setFechafiniquito($row['fechafiniqito']);
        $finiquito->setTrabajador($row['trabajador']);
        $finiquito->setEmpresa($row['empresa']);
        $finiquitos[] = $finiquito;
    }

    $stmt->close();
    $this->desconectar();

    return count($finiquitos) > 0 ? $finiquitos : null;
}

/**
 * Lista todos los contratos firmados de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos o null
 */
public function listarcontratosfirmadosporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM contratosfirmados WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $contratos = array();
    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass();
        $obj->id = $row['id'];
        $obj->empresa = $row['empresa'];
        $obj->centrocosto = $row['centrocosto'];
        $obj->contrato = $row['contrato'];
        $obj->documento = $row['documento'];
        $contratos[] = $obj;
    }

    $stmt->close();
    $this->desconectar();

    return count($contratos) > 0 ? $contratos : null;
}

/**
 * Lista todos los anexos de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos Anexo o null
 */
public function listaranexosporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM anexoscontrato WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $anexos = array();
    while ($row = $result->fetch_assoc()) {
        $anexo = new Anexo();
        $anexo->setId($row['id']);
        $anexo->setContrato($row['contrato']);
        $anexo->setFechageneracion($row['fechageneracion']);
        $anexo->setBase($row['base']);
        $anexo->setSueldoBase($row['sueldo_base']);
        $anexo->setEstado($row['estado']);
        $anexos[] = $anexo;
    }

    $stmt->close();
    $this->desconectar();

    return count($anexos) > 0 ? $anexos : null;
}

/**
 * Lista todos los documentos de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos Documento o null
 */
public function listardocumentosporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM documentos WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $documentos = array();
    while ($row = $result->fetch_assoc()) {
        $doc = new Documento();
        $doc->setId($row['id']);
        $doc->setTrabajador($row['trabajador']);
        $doc->setEmpresa($row['empresa']);
        $doc->setContrato($row['contrato']);
        $doc->setTipodocumento($row['tipodocumento']);
        $doc->setFechageneracion($row['fechageneracion']);
        $doc->setDocumento($row['documento']);
        $documentos[] = $doc;
    }

    $stmt->close();
    $this->desconectar();

    return count($documentos) > 0 ? $documentos : null;
}

/**
 * Lista todas las horas pactadas de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos o null
 */
public function listarhoraspactadasporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM horaspactadas WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $horas = array();
    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass();
        $obj->id = $row['id'];
        $obj->horas = $row['horas'];
        $obj->contrato = $row['contrato'];
        $horas[] = $obj;
    }

    $stmt->close();
    $this->desconectar();

    return count($horas) > 0 ? $horas : null;
}

/**
 * Lista todos los detalle de lotes de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos o null
 */
public function listardetallelotesporcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM detallelotes WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $lotes = array();
    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass();
        $obj->id = $row['id'];
        $obj->contrato = $row['contrato'];
        $obj->lotes = $row['lotes'];
        $lotes[] = $obj;
    }

    $stmt->close();
    $this->desconectar();

    return count($lotes) > 0 ? $lotes : null;
}

/**
 * Lista todos los lote2 de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos o null
 */
public function listarlote2porcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM lote2 WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $lotes = array();
    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass();
        $obj->id = $row['id'];
        $obj->contrato = $row['contrato'];
        $obj->usuario = $row['usuario'];
        $lotes[] = $obj;
    }

    $stmt->close();
    $this->desconectar();

    return count($lotes) > 0 ? $lotes : null;
}

/**
 * Lista todos los lote4 de un contrato
 * @param int $contrato - ID del contrato
 * @return array|null - Array de objetos o null
 */
public function listarlote4porcontrato($contrato)
{
    $this->conexion();
    $sql = "SELECT * FROM lote4 WHERE contrato = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $contrato);
    $stmt->execute();
    $result = $stmt->get_result();

    $lotes = array();
    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass();
        $obj->id = $row['id'];
        $obj->contrato = $row['contrato'];
        $obj->usuario = $row['usuario'];
        $obj->empresa = $row['empresa'];
        $lotes[] = $obj;
    }

    $stmt->close();
    $this->desconectar();

    return count($lotes) > 0 ? $lotes : null;
}

// ==================================================================================
// MÉTODOS DE ELIMINACIÓN ADICIONALES
// ==================================================================================

/**
 * Elimina el detalle de liquidación por ID de liquidación
 * @param int $idLiquidacion - ID de la liquidación
 * @return bool - true si se eliminó correctamente
 */
public function eliminardetalleliquidacion($idLiquidacion)
{
    $this->conexion();
    $sql = "DELETE FROM detalle_liquidacion WHERE liquidacion = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $idLiquidacion);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina el aporte empleador por ID de liquidación
 * @param int $idLiquidacion - ID de la liquidación
 * @return bool - true si se eliminó correctamente
 */
public function eliminaraporteempleador($idLiquidacion)
{
    $this->conexion();
    $sql = "DELETE FROM aporteempleador WHERE liquidacion = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $idLiquidacion);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina las cláusulas de un anexo
 * @param int $idAnexo - ID del anexo
 * @return bool - true si se eliminó correctamente
 */
public function eliminarclausulasanexo($idAnexo)
{
    $this->conexion();
    $sql = "DELETE FROM clausulasanexos WHERE anexo = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $idAnexo);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina las notificaciones de un finiquito
 * @param int $idFiniquito - ID del finiquito
 * @return bool - true si se eliminó correctamente
 */
public function eliminarnotificacionesfiniquito($idFiniquito)
{
    $this->conexion();
    $sql = "DELETE FROM notificaciones WHERE finiquito = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $idFiniquito);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina los finiquitos firmados de un finiquito
 * @param int $idFiniquito - ID del finiquito
 * @return bool - true si se eliminó correctamente
 */
public function eliminarfiniquitosfirmados($idFiniquito)
{
    $this->conexion();
    $sql = "DELETE FROM finiquitosfirmados WHERE finiquito = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $idFiniquito);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina el lote3 de un finiquito
 * @param int $idFiniquito - ID del finiquito
 * @return bool - true si se eliminó correctamente
 */
public function eliminarlote3finiquito($idFiniquito)
{
    $this->conexion();
    $sql = "DELETE FROM lote3 WHERE finiquito = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $idFiniquito);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina las horas pactadas por ID
 * @param int $id - ID de horas pactadas
 * @return bool - true si se eliminó correctamente
 */
public function eliminarhoraspactadas($id)
{
    $this->conexion();
    $sql = "DELETE FROM horaspactadas WHERE id = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $id);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina el detalle de lote por ID
 * @param int $id - ID del detalle lote
 * @return bool - true si se eliminó correctamente
 */
public function eliminardetallelote($id)
{
    $this->conexion();
    $sql = "DELETE FROM detallelotes WHERE id = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $id);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina el lote2 por ID
 * @param int $id - ID del lote2
 * @return bool - true si se eliminó correctamente
 */
public function eliminarlote2($id)
{
    $this->conexion();
    $sql = "DELETE FROM lote2 WHERE id = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $id);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

/**
 * Elimina el lote4 por ID
 * @param int $id - ID del lote4
 * @return bool - true si se eliminó correctamente
 */
public function eliminarlote4($id)
{
    $this->conexion();
    $sql = "DELETE FROM lote4 WHERE id = ?";
    $stmt = $this->mi->prepare($sql);
    $stmt->bind_param("i", $id);
    $r = $stmt->execute();
    $stmt->close();
    $this->desconectar();
    return $r;
}

// FIN DE LOS MÉTODOS FALTANTES
?>
