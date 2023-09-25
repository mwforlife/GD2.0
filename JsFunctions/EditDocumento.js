function agregarcampo(valor){
    $("#summernote").summernote('editor.insertText', "{"+valor+"}");
}

function generarDocumento(id){
    $("#global-loader").fadeIn("slow");
    //Capturar el contenido del editor
    var contenido = $("#summernote").summernote('code');
    $.ajax({
        url: "php/insert/registrarplantillas.php",
        type: "POST",
        data: {contenido: contenido, id: id},
        success: function(data){
            if(data==1){
                ToastifySuccess("Plantilla Registrada con exito");
                $("#global-loader").fadeOut("slow");
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error al registrar la plantilla");

            }
            
        }
    });
    $("#global-loader").fadeOut("slow");

}

function cargarDocumento(id){
    $("#global-loader").fadeIn("slow");
    $.ajax({
        url: "php/listar/cargardocumento.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            $("#summernote").summernote('code', data);
            $("#global-loader").fadeOut("slow");
        }
    });
}