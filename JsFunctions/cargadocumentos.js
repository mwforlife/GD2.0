// Objetivo: Cargar documentos de trabajadores
function cargarcontrato(id, trabajador, centrocosto, fechainicio, fechatermino, tipocontrato) {
    if(fechatermino == "0000-00-00" || fechatermino == null || fechatermino == ""){
        fechatermino = "Indefinido";
    }
    $(".modal-title").html("Cargar Contrato Firmado");
    $(".info-doc").html("<div class='alert alert-info'><i class='fa fa-info-circle'></i> <strong>Cargando Contrato Firmado</strong> <br>Trabajador: " + trabajador + "<br>Centro de Costo: " + centrocosto + "<br>Fecha Inicio: " + fechainicio + "<br>Fecha Termino: " + fechatermino + "<br>Tipo Contrato: " + tipocontrato + "</div>");
    $("#idcontrato").val(id);
    $("#idfiniquito").val("");
    $("#idnotificacion").val("");
    $("#iddocumento").val("");
    $("#tipodocumento").val(1);
    $("#modalcarga").modal("show");
    validarcontrato(id);
}

//Validar Carga de contrato
function validarcontrato(id){
    $.ajax({
        url: "php/validation/cargarcontrato.php",
        type: "POST",
        data: {id: id},
        success:function(response){
        try {
            var data = JSON.parse(response);
            if(data.status == true){
                $(".message").html(data.message);
                $(".message").append("");
            }else{
                $(".message").html("");
            }
        } catch (error) {
            ToastifyError("Error interno".error);
        }
    }
    });
}

$(document).ready(function(){
    $("#formcarga").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this);
        if($("#tipodocumento").val() == 1){
            var contratoid = $("#idcontrato").val();
            if(contratoid == ""){
                ToastifyError("Debe seleccionar un contrato");
                return false;
            }
        }else if($("#tipodocumento").val() == 2){
            var finiquitoid = $("#idfiniquito").val();
            if(finiquitoid == ""){
                ToastifyError("Debe seleccionar un finiquito");
                return false;
            }
        }else if($("#tipodocumento").val() == 3){
            var notificacionid = $("#idnotificacion").val();
            if(notificacionid == ""){
                ToastifyError("Debe seleccionar una notificacion");
                return false;
            }
        }else if($("#tipodocumento").val() == 4){
            var documentoid = $("#iddocumento").val();
            if(documentoid == ""){
                ToastifyError("Debe seleccionar un documento");
                return false;
            }
        }
        $.ajax({
            url: "php/insert/cargacontrato.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
            try {
                var data = JSON.parse(response);
                if(data.status == true){
                    $("#formcarga")[0].reset();
                    $("#modalcarga").modal("hide");
                    $(".info-doc").html("");
                    ToastifySuccess(data.message);
                }else{
                    ToastifyError(data.message);
                }
            } catch (error) {
                ToastifyError("Error interno".error);
            }
        }
    });
    });
});
