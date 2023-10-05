$(document).ready(function(){
    $("#RegisForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/tipodocumento.php",
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
        url: "php/cargaredit/tipodocumento.php",
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

    $.ajax({
        type: "POST",
        url: "php/update/tipodocumento.php",
        data: {id: id, codigo: codigo, codigoPrevired: codigoPrevired, nombre: nombre},
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
            $("#global-loader").fadeIn("slow");
            $.ajax({
                type: "POST",
                url: "php/eliminar/tipodocumento.php",
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


function listartipodocumento(){
    var empresa = $("#empresa").val();
    if(empresa.trim().length == 0 || empresa <=0){
        return;
    }
    $.ajax({
        type: "POST",
        url: "php/listar/escrito.php",
        data: {empresa: empresa},
        success: function(data){
            $("#escritos").html(data);
        }
    });
}

$(document).ready(function(){
    $("#empresa").on("change", function(){
        listartipodocumento();
    }
    );
});

function asignar(id){
    var empresa = $("#empresa").val();
    if(empresa.trim().length == 0 || empresa <=0){
        ToastifyError("Debe seleccionar una empresa");
        return;
    }
    $.ajax({
        type: "POST",
        url: "php/insert/escrito.php",
        data: {empresa: empresa, id: id},
        success: function(data){
            if(data == 1 || data == "1"){
                ToastifySuccess("Escrito asignado correctamente");
                listartipodocumento();
            }else{
                ToastifyError("Error al asignar")
            }
        }
    });
}

function revocar(id){
    var empresa = $("#empresa").val();
    if(empresa.trim().length == 0 || empresa <=0){
        ToastifyError("Debe seleccionar una empresa");
        return;
    }
    $.ajax({
        type: "POST",
        url: "php/eliminar/escrito.php",
        data: {empresa: empresa, id: id},
        success: function(data){
            if(data == 1 || data == "1"){
                ToastifySuccess("Escrito eliminado correctamente");
                listartipodocumento();
            }else{
                ToastifyError("Error al eliminar")
            }
        }
    });
}
