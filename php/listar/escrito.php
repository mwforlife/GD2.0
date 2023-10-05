<?php
require '../controller.php';
$c = new Controller();
$lista = $c->listartipodocumento();
$empresa = $_POST['empresa'];
if (count($lista) > 0) {
    foreach ($lista as $object) {
        echo "<tr>
                    <td>" . $object->getCodigo() . "</td>
                    <td>" . $object->getCodigoPrevired() . "</td>
                    <td>" . $object->getNombre() . "</td>
                    <td class='text-center'>";
                    if($c->validardocumento($empresa,$object->getId()) == false){
                        echo "<a href='javascript:void(0)' class='btn btn-sm btn-danger m-1' onclick='asignar(" . $object->getId() . ")'><i class='fa fa-plus'></i></a>";
                    }else{
                        echo "<a href='javascript:void(0)' class='btn btn-sm btn-success m-1' onclick='revocar(" . $object->getId() . ")'><i class='fa fa-check'></i></a>";
                    }
                    echo "</td>
                </tr>";
    }
}else{
    echo "<tr>
            <td colspan='4' class='text-center'>No hay datos para mostrar</td>
        </tr>";
}