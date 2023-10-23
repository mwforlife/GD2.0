$(document).ready(function () {
    $("#RegisForm").on("submit", function (e) {
        e.preventDefault();
        var form = $(this);
        $("#global-loader").show();
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/haberes.php",
            data: data,
            success: function (data) {
                try {
                    var obj = JSON.parse(data);
                    if(obj.status==true){
                        $("#global-loader").hide();
                        ToastifySuccess(obj.message);
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        $("#global-loader").hide();
                        ToastifyError(obj.message);
                    }
                } catch (error) {
                    $("#global-loader").hide();
                    ToastifyError("Error al registrar")   
                }
            },
            error: function (xhr, status, msg) {
                $("#global-loader").hide();
                ToastifyError("Error al registrar");
            }
        });
    });
});

function eliminarhaber(id) {
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
            $("#global-loader").show();
            $.ajax({
                type: "POST",
                url: "php/eliminar/haberes.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        $("#global-loader").hide();
                        ToastifySuccess("Registro eliminado correctamente");
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        $("#global-loader").hide();
                        ToastifyError("Error al eliminar")
                    }
                }
            });
        }
    });
}

function editarhaber(id){
    $("#global-loader").show();
    $.ajax({
        type: "POST",
        url: "php/cargaredit/haberes.php",
        data: {id: id},
        success: function(data){
            $("#global-loader").hide();
            $(".content").html(data);      
            $("#modaledit").modal("show");       
        }
    });
}

function actualizarhaber(id){
    $("#global-loader").hide();
    var codigo = $("#codigoedit").val();
    var descripcion = $("#descripcionedit").val();
    var tipo = $("#tipoedit").val();
    var imponible = $("#imponibleedit").val();
    var tributable = $("#tributableedit").val();
    var gratificacion = $("#gratificacionedit").val();
    var reservado = $("#reservadoedit").val();
    var lre = $("#lreedit").val();
    var agrupacion = $("#agrupacionedit").val();

    if(codigo.trim().length == 0){
        ToastifyError("Ingrese un codigo");
        return false;
    }

    if(descripcion.trim().length == 0){
        ToastifyError("Ingrese una descripcion");
        return false;
    }

    if(tipo.trim().length == 0){
        ToastifyError("Ingrese un tipo");
        return false;
    }

    if(imponible.trim().length == 0){
        ToastifyError("Ingrese un imponible");
        return false;
    }

    if(tributable.trim().length == 0){
        ToastifyError("Ingrese un tributable");
        return false;
    }

    if(gratificacion.trim().length == 0){
        ToastifyError("Ingrese una gratificacion");
        return false;
    }

    if(reservado.trim().length == 0){
        ToastifyError("Ingrese un reservado");
        return false;
    }

    if(lre.trim().length == 0){
        ToastifyError("Ingrese un lre");
        return false;
    }

    if(agrupacion.trim().length == 0){
        ToastifyError("Ingrese una agrupacion");
        return false;
    }


    $.ajax({
        type: "POST",
        url: "php/update/haberes.php",
        data: {id: id, codigo: codigo, descripcion: descripcion, tipo: tipo, imponible: imponible, tributable: tributable, gratificacion: gratificacion, reservado: reservado, lre: lre, agrupacion: agrupacion},
        success: function(data){
            try {
                var obj = JSON.parse(data);
                if(obj.status==true){
                    $("#global-loader").hide();
                    ToastifySuccess(obj.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    $("#global-loader").hide();
                    ToastifyError(obj.message);
                }                
            } catch (error) {
                $("#global-loader").hide();
                ToastifyError("Error al actualizar");
            }
            
        }
    });
}


function addformula(atributo){
    $("#formula").val($("#formula").val()+atributo);
    $("#formula").focus();
}

function formul(valor){
    if(valor==1){
        $("#formula").attr("readonly", false);
    }else{
        $("#formula").attr("readonly", true);
        $("#formula").val("");
    }
}