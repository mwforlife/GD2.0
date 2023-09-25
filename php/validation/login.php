<?php
if (isset($_POST['User']) && isset($_POST['Password'])) {
    include '../controller.php';
    $c = new Controller();
    $User = $_POST['User'];
    $Password = $_POST['Password'];
    $User = $c->escapeString($User);

    $object = $c->login($User, $Password);
    if ($object != null) {
        $permiso = $c->listarPermisosUsuario1($object->getId());
        session_start();
        $_SESSION['USER_ID'] = $object->getId();
        $_SESSION['USER_NAME'] = $object->getNombre() . " " . $object->getApellido();
        $_SESSION['USER_EMAIL'] = $object->getCorreo();
        $_SESSION['USER_TELEFONO'] = $object->getTelefono();
        $_SESSION['USER_DIRECCION'] = $object->getDireccion();
        $_SESSION['USER_REGISTRO'] = $object->getRegistro();
        $_SESSION['USER_ESTADO'] = $object->getEstado();
        $_SESSION['USER_UPDATE'] = $object->getUpdate();
        $c->eliminartodolotefiniquito($object->getId());
        $c->eliminartodolotenotificacion($object->getId());
        $c->eliminartodoellote($object->getId());

        foreach ($permiso as $p) {
            if ($p->getId() == 1) {
                $_SESSION['GESTION_PERMISO'] = true;
            } else if ($p->getId() == 2) {
                $_SESSION['LECTURA_PERMISO'] = true;
            } else if ($p->getId() == 3) {
                $_SESSION['ESCRITURA_PERMISO'] = true;
            } else if ($p->getId() == 4) {
                $_SESSION['ACTUALIZACION_PERMISO'] = true;
            } else {
                $_SESSION['ELIMINACION_PERMISO'] = true;
            }
        }

        //Valor alfanumerico aleatorio
        $token = md5(uniqid(mt_rand(), true));
        $_SESSION['USER_TOKEN'] = $token;
        $c->crearsesion($object->getId(), $token);
        echo 1;
    } else {
        echo "Usuario o contraseña incorrectos";
    }
} else {
    echo "No se ha recibido ningun dato";
}
