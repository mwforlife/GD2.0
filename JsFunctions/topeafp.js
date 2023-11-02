$(document).ready(function(){
    $("#RegisForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").show();
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/topeafp.php",
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
            url: "php/update/topeafp.php",
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
                url: "php/eliminar/topeafp.php",
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
    //Eliminar los ultimos 3 caracteres del periodo
    periodo = periodo.substring(0, periodo.length - 3);
    $("#periodoedit").val(periodo);
    $("#topeedit").val(tasa);
    $("#modaledit").modal("show");
    //formatearnumero();
}