<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['contrato'])){
    $contrato = $_POST['contrato'];
    $anexos = $c->listaranexo($contrato);

    if($anexos!=null){
        foreach($anexos as $anexo){
            echo "<tr>";
            echo "<td>".$anexo->getFechageneracion()."</td>";
            if($anexo->getBase()==1){
                echo "<td>Si Aplica</td>";
            }else{
                echo "<td>No Aplica</td>";
            }

            if($anexo->getEstado()==1){
                echo "<td>Activo</td>";
            }else{
                echo "<td>Inactivo</td>";
            }
            echo "<td class='text-center'><a target='_blank' href='php/pdf/anexo.php?id=".$anexo->getId()."'><i class='fa fa-file-pdf-o'></i></a></td>";
            echo "<td class='text-center'><a class='btn btn-outline-danger btn-sm' href='javascript:void(0)' onclick='eliminaranexo(".$anexo->getId().",$contrato)'><i class='fa fa-trash'></i></a></td>";
            echo "</tr>";
        }
    }else{
        echo "<tr><td colspan='5'>No hay anexos para este contrato</td></tr>";
    }
}else{
    echo "<tr><td colspan='5'>No hay anexos para este contrato</td></tr>";
}