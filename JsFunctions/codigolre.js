$(document).ready(function () {
    $("#codigolreform").on("submit", function (e) {
        e.preventDefault();
        var form = $(this);
        $("#global-loader").show();
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/codigolre.php",
            data: data,
            success: function (data) {
                if (data == 1 || data == "1") {
                    $("#global-loader").hide();
                    ToastifySuccess("Registro insertado correctamente");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    $("#global-loader").hide();
                    ToastifyError("Error al Registrar")
                }
            }
        });
    });
});

function eliminarcodigolre(id) {
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
                url: "php/eliminar/codigolre.php",
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

function editarcodigolre(id){
    $("#global-loader").show();
    $.ajax({
        type: "POST",
        url: "php/cargaredit/codigolre.php",
        data: {id: id},
        success: function(data){
            $("#global-loader").hide();
            $(".content").html(data);            
        }
    });
}

function Actualizarcodigolre(id){
    $("#global-loader").hide();
    var articulo = $("#articuloco").val();
    var codigo = $("#codigodt").val();
    var codigoprevired = $("#codigoprevi").val();
    var nombre = $("#descripcionco").val();

    $.ajax({
        type: "POST",
        url: "php/update/codigolre.php",
        data: {id: id, articulo: articulo, codigo: codigo, codigoprevired: codigoprevired, nombre: nombre},
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