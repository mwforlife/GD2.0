$(document).ready(function(){
    $("#RegisForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/jornadas.php",
            data: data,
            success: function(data){
                if(data == 1 || data == "1"){
                    $("#global-loader").fadeOut("slow");
                    ToastifySuccess("Registro insertado correctamente");
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("Error al Registrar")
                }
            }
        });
    }
    );
});

function Editar(id){
    $("#global-loader").fadeIn("slow");
    $.ajax({
        type: "POST",
        url: "php/cargaredit/jornadas.php",
        data: {id: id},
        success: function(data){
            $("#global-loader").fadeOut("slow");
            $(".content").html(data);            
        }
    });
}

function Actualizar(id){
    $("#global-loader").fadeOut("slow");
    var codigo = $("#codigo").val();
    var codigoPrevired = $("#codigoPrevired").val();
    var nombre = $("#nombre").val();
    var termino = 2;
    var entidad = 2;

    //Validar si el termino esta checkeado
    if($("#terminoedit").is(":checked")){
        termino = 1;
    }

    //Validar si la entidad esta checkeada
    if($("#entidadedit").is(":checked")){
        entidad = 1;
    }

    $.ajax({
        type: "POST",
        url: "php/update/jornadas.php",
        data: {id: id, codigo: codigo, codigoPrevired: codigoPrevired, nombre: nombre, termino: termino, entidad: entidad},
        success: function(data){
            if(data == 1 || data == "1"){
                $("#global-loader").fadeOut("slow");
                ToastifySuccess("Registro actualizado correctamente");
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error al actualizar")
            }
        }
    });
}

function Eliminar(id){
    $("#global-loader").fadeIn("slow");
    swal.fire({
        title: "¿Estas seguro?",
        text: "Una vez eliminado no se podra recuperar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/jornadas.php",
                data: {id: id},
                success: function(data){
                    $("#global-loader").fadeOut("slow");
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Registro eliminado correctamente");
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        $("#global-loader").fadeOut("slow");
                        ToastifyError("Error al eliminar")
                    }
                }
            });
        }else{
            $("#global-loader").fadeOut("slow");
            ToastifyInfo("Operacion cancelada");
        }
    });

}
