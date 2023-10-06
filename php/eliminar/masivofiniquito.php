<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $lista1 = $c->listarlotestext1($id);
    foreach ($lista1 as $object) {
        $finiquito = $object;
        if ($finiquito != null) {
            $id = $finiquito->getNombre_lote();
            $contrato = $c->buscaridcontratofiniquito($id);
            if($contrato!=false){
                $c->query("update contratos set estado = 1, fechatermino='' where id = $contrato;");
                $c->eliminardetallefiniquito($id);
                $c->eliminarfiniquito($id);
            }
        }
    }
    echo json_encode(array('status' => true, 'message' => 'Finiquitos eliminados correctamente'));
} else {
    echo json_encode(array('status' => false, 'message' => 'Hubo un error al eliminar los contratos'));
    exit();
}