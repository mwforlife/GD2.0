<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $lista1 = $c->listarlotestext5($id);
    foreach ($lista1 as $object) {
        $id = $object->getId();
        unlink("../../uploads/documentos/".$object->getDocumento());
        $result = $c->eliminardocumento($id);

    }
    echo json_encode(array('status' => true, 'message' => 'Documentos eliminados correctamente'));
} else {
    echo json_encode(array('status' => false, 'message' => 'Hubo un error al eliminar los documentos'));
    exit();
}