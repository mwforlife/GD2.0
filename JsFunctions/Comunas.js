$(document).ready(function(){
    $("#RegisForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").show();
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/comunas.php",
            data: data,
            success: function(data){
                if(data == 1 || data == "1"){
                    $("#global-loader").hide();
                    ToastifySuccess("Registro insertado correctamente");
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    $("#global-loader").hide();
                    ToastifyError("Error al Registrar")
                }
            }
        });
    }
    );
});

function Editar(id){
    $("#global-loader").show();
    $.ajax({
        type: "POST",
        url: "php/cargaredit/comunas.php",
        data: {id: id},
        success: function(data){
            $("#global-loader").hide();
            $(".content").html(data);            
        }
    });
}

function Actualizar(id){
    $("#global-loader").hide();
    var codigo = $("#codigo").val();
    var codigoPrevired = $("#codigoPrevired").val();
    var nombre = $("#nombre").val();
    var provincia = $("#provincia").val();

    $.ajax({
        type: "POST",
        url: "php/update/comunas.php",
        data: {id: id, codigo: codigo, codigoPrevired: codigoPrevired, nombre: nombre, provincia: provincia},
        success: function(data){
            if(data == 1 || data == "1"){
                $("#global-loader").hide();
                ToastifySuccess("Registro actualizado correctamente");
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }else{
                $("#global-loader").hide();
                ToastifyError("Error al actualizar")
            }
        }
    });
}

function Eliminar(id){
    $("#global-loader").show();
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
                url: "php/eliminar/comunas.php",
                data: {id: id},
                success: function(data){
                    $("#global-loader").hide();
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Registro eliminado correctamente");
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        $("#global-loader").hide();
                        ToastifyError("Error al eliminar")
                    }
                }
            });
        }else{
            $("#global-loader").hide();
            ToastifyInfo("Operacion cancelada");
        }
    });

}

