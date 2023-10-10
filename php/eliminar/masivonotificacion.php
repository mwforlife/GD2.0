<?php
require '../controller.php';
$c = new Controller();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $lista1 = $c->listarlotestext4($id);
    foreach ($lista1 as $object) {
        $id = $object->getId();
        $result = $c->eliminarnotificacion($id);

    }
    echo json_encode(array('status' => true, 'message' => 'Notificaciones eliminados correctamente'));
} else {
    echo json_encode(array('status' => false, 'message' => 'Hubo un error al eliminar las notificaciones'));
    exit();
}