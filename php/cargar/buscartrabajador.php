<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['rut'])){
    $rut = $_POST['rut'];
    $trabajador = $c->buscartrabajadorbyRut($rut);
    if($trabajador!=false){
        $direccion = $c->ultimodomicilio($trabajador->getId());
        $contacto = $c->buscarcontacto($trabajador->getId());
        echo json_encode(array("success"=>true,"id"=>$trabajador->getId(),"rut"=>$trabajador->getRut(),"dni"=>$trabajador->getDni(),"nombre"=>$trabajador->getNombre(),"apellido1"=>$trabajador->getApellido1(),"apellido2"=>$trabajador->getApellido2(),"nacimiento"=>$trabajador->getNacimiento(),"sexo"=>$trabajador->getSexo(),"civil"=>$trabajador->getCivil(),"nacionalidad"=>$trabajador->getNacionalidad(),"discapacidad"=>$trabajador->getDiscapacidad(),"pension"=>$trabajador->getPension(),"empresa"=>$trabajador->getEmpresa(),"registrar"=>$trabajador->getRegistrar(),"calle"=>$direccion->getCalle(),"villa"=>$direccion->getVilla(),"numero"=>$direccion->getNumero(),"departamento"=>$direccion->getDepartamento(),"region"=>$direccion->getRegion(),"comuna"=>$direccion->getComuna(),"ciudad"=>$direccion->getCiudad(),"telefono"=>$contacto->getTelefono(),"correo"=>$contacto->getCorreo()));
    }else{
        echo json_encode(array("success"=>false,"error"=>"No se encontró trabajador"));
    }
}else{
    echo json_encode(array("success"=>false,"error"=>"No se encontró trabajador"));
}