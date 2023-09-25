function agregarlote($id){
    $.ajax({
        url: 'php/insert/lote.php',
        type: 'POST',
        data: {trabajador: $id},
        success: function(response){
            if(response ==1){
                ToastifySuccess("Trabajador agregado correctamente");
                listarlotes();
            }else if(response ==2){
                ToastifyError("Trabajador ya agregado");
            }else{
                ToastifyError("Error al agregar trabajador");
            }
        }
    });
}

function agregartodo(){
    $.ajax({
        url: 'php/insert/lote.php',
        type: 'POST',
        data: {trabajador: 'all'},
        success: function(response){
            if(response ==1){
                ToastifySuccess("Trabajadores agregados correctamente");
                listarlotes();
            }else{
                ToastifyError("Error al agregar trabajadores");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function listarlotes(){
    $.ajax({
        url: 'php/listar/lote.php',
        type: 'GET',
        success: function(data){
            $('#lotes').html(data);
        }
    });
}

// Path: JsFunctions\generarlote.js

function Eliminardellote($id){
    $.ajax({
        url: 'php/eliminar/lote.php',
        type: 'POST',
        data: {id: $id},
        success: function(response){
            if(response ==1){
                ToastifySuccess("Trabajador eliminado correctamente");
                listarlotes();
            }else{
                ToastifyError("Error al eliminar trabajador");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function Eliminartodo(){
    $.ajax({
        url: 'php/eliminar/todolote.php',
        type: 'GET',
        success: function(response){
            if(response ==1){
                ToastifySuccess("Trabajadores eliminados correctamente");
                listarlotes();
            }else{
                ToastifyError("Error al eliminar trabajadores");
            }
        }
    });
}