$(document).ready(function(){
    $("#RegisForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").show();
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/topeapvanual.php",
            data: data,
            success: function(data){
                try {
                    var json = JSON.parse(data);
                    if(json.status == true){
                        $("#global-loader").hide();
                        ToastifySuccess(json.message);
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        $("#global-loader").hide();
                        ToastifyError(json.message);
                    }
                } catch (error) {
                    $("#global-loader").hide();
                    ToastifyError(data);
                }
            }
        });
    });
    $("#formedit").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").show();
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/topeapvanual.php",
            data: data,
            success: function(data){
                try {
                    var json = JSON.parse(data);
                    if(json.status == true){
                        $("#global-loader").hide();
                        ToastifySuccess(json.message);
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        $("#global-loader").hide();
                        ToastifyError(json.message);
                    }
                } catch (error) {
                    $("#global-loader").hide();
                    ToastifyError(data);
                }
            }
        });
    });
});

function eliminar(id){
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
                url: "php/eliminar/topeapvanual.php",
                data: {id: id},
                success: function(data){
                    $("#global-loader").hide();
                    try {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            ToastifySuccess(json.message);
                            setTimeout(function(){
                                location.reload();
                            }, 1500);
                        }else{
                            ToastifyError(json.message);
                        }
                    
                    } catch (error) {
                        ToastifyError(data);    
                    }
                }
            });
        }else{
            $("#global-loader").hide();
            ToastifyInfo("Operacion cancelada");
        }
    });
}


function editar(id, periodo, tasa){
    $("#idedit").val(id);
    //Recorrer el select periodo y seleccionar el que tenga el value igual al que se recibe
    $("#periodoedit option").each(function(){
        if($(this).val() == periodo){
            $(this).attr("selected", true);
            $("#select2-periodoedit-container").text($(this).text());
        }
    });


    $("#topeedit").val(tasa);
    $("#modaledit").modal("show");
    //formatearnumero();
}