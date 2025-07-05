<?php
// Archivo: php/listar/usuarios.php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $usuario = $c->buscarusuario($id);
    
    if ($usuario != null) {
        $region = $c->buscarregion($usuario->getRegion());
        $comuna = $c->buscarcomuna($usuario->getComuna());
        $nacionalidad = $c->buscarnacionalidad($usuario->getNacionalidad());
        $estadoCivil = $c->buscarestadocivil($usuario->getEstadoCivil());
        
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<p><strong>RUT:</strong> " . $usuario->getRut() . "</p>";
        echo "<p><strong>Nombre:</strong> " . $usuario->getNombre() . " " . $usuario->getApellido() . "</p>";
        echo "<p><strong>Email:</strong> " . $usuario->getCorreo() . "</p>";
        echo "<p><strong>Teléfono:</strong> " . $usuario->getTelefono() . "</p>";
        echo "<p><strong>Dirección:</strong> " . $usuario->getDireccion() . "</p>";
        echo "</div>";
        echo "<div class='col-md-6'>";
        echo "<p><strong>Región:</strong> " . ($region ? $region->getNombre() : 'NO DEFINIDA') . "</p>";
        echo "<p><strong>Comuna:</strong> " . ($comuna ? $comuna->getNombre() : 'NO DEFINIDA') . "</p>";
        echo "<p><strong>Nacionalidad:</strong> " . ($nacionalidad ? $nacionalidad->getNombre() : 'NO DEFINIDA') . "</p>";
        echo "<p><strong>Estado Civil:</strong> " . ($estadoCivil ? $estadoCivil->getNombre() : 'NO DEFINIDO') . "</p>";
        echo "<p><strong>Profesión:</strong> " . ($usuario->getProfesion() ? $usuario->getProfesion() : 'NO DEFINIDA') . "</p>";
        
        $tipo = '';
        if($usuario->getTipo() == 1) {
            $tipo = 'Administrador';
        } else if($usuario->getTipo() == 2) {
            $tipo = 'Contratista';
        } else if($usuario->getTipo() == 3) {
            $tipo = 'Mandante';
        }
        echo "<p><strong>Tipo de Usuario:</strong> " . $tipo . "</p>";
        echo "</div>";
        echo "</div>";
        
        echo "<div class='row mt-3'>";
        echo "<div class='col-md-12'>";
        echo "<p><strong>Fecha de Registro:</strong> " . date('d-m-Y H:i:s', strtotime($usuario->getCreatedAt())) . "</p>";
        echo "<p><strong>Última Actualización:</strong> " . date('d-m-Y H:i:s', strtotime($usuario->getUpdatedAt())) . "</p>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>Usuario no encontrado</p>";
    }
} else {
    echo "<p>ID de usuario no proporcionado</p>";
}
?>