<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
        $lista1 = $c->listarlotestext3($id);
        foreach ($lista1 as $object) {
            $contrato = $object;
        if ($contrato != null) {
            $c->eliminarcontrato($contrato->getContrato());
            unlink("../../uploads/Contratos/" . $contrato->getFecha_inicio());
        }
    }
    $c->eliminarlotecontrato($id);
    echo json_encode(array('status' => true, 'message' => 'Contratos eliminados correctamente'));
}else{
    echo json_encode(array('status' => false, 'message' => 'Hubo un error al eliminar los contratos'));
    exit();
}