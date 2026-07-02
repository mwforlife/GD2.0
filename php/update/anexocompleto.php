<?php
require '../controller.php';
$c = new Controller();
session_start();

if (!isset($_SESSION['USER_ID'])) {
    echo "Sesión no iniciada";
    exit;
}

if (!isset($_POST['id']) || !isset($_POST['contrato_id']) || !isset($_POST['fechageneracion']) || !isset($_POST['clausulas'])) {
    echo "Parámetros insuficientes";
    exit;
}

$id = intval($_POST['id']);
$contrato_id = intval($_POST['contrato_id']);
$fechageneracion = $_POST['fechageneracion'];
$clausulas = $_POST['clausulas']; // Esto es un array de clausulas
$base = intval($_POST['base']);
$sueldo = floatval($_POST['sueldo']);
$modificafecha = intval($_POST['modificafecha']);
$nuevafechatermino = isset($_POST['nuevafechatermino']) ? $_POST['nuevafechatermino'] : '';

if ($base == 1) {
    if ($sueldo <= 0) {
        echo "Debe ingresar un sueldo base válido";
        exit;
    }
} else {
    $sueldo = 0;
}

if ($modificafecha == 1) {
    if (empty($nuevafechatermino)) {
        echo "Debe ingresar una nueva fecha de término";
        exit;
    }
}

$fecha_termino_val = ($modificafecha == 1 && !empty($nuevafechatermino)) ? "'$nuevafechatermino'" : "NULL";

$c->conexion();
// 1. Actualizar datos generales del anexo
$sql = "UPDATE anexoscontrato SET 
        fechageneracion = '$fechageneracion', 
        base = $base, 
        sueldo_base = $sueldo, 
        fecha_termino = $fecha_termino_val, 
        modifica_fecha = $modificafecha 
        WHERE id = $id";
$res = $c->mi->query($sql);
$c->desconectar();

if ($res) {
    // 2. Eliminar las cláusulas antiguas del anexo
    $c->eliminarclausulaanexo($id);

    // 3. Insertar las nuevas cláusulas
    $c->conexion();
    foreach ($clausulas as $clausula) {
        $clau = $c->mi->real_escape_string($clausula['clausula']);
        $plantilla = intval($clausula['tipodocumentoid']);
        
        $sqlClausula = "INSERT INTO clausulasanexos (anexo, clausula, tipodocumento) VALUES ($id, '$clau', $plantilla)";
        $c->mi->query($sqlClausula);
    }
    $c->desconectar();

    // 4. Actualizar fecha de término del contrato general si aplica
    if ($modificafecha == 1 && !empty($nuevafechatermino)) {
        $c->actualizarfechaterminocontrato($contrato_id, $nuevafechatermino);
    }

    // 5. Actualizar sueldo del contrato general si aplica
    if ($base == 1 && $sueldo > 0) {
        $c->conexion();
        $sqlSueldo = "UPDATE contratos SET sueldo = $sueldo WHERE id = $contrato_id";
        $c->mi->query($sqlSueldo);
        $c->desconectar();
    }

    echo 1;
} else {
    echo "Error al actualizar los datos generales del anexo";
}
