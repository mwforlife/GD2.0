function checkcentrocosto(value){
    var usuario = value;
    if(usuario <=0 || usuario == "" || usuario == null || usuario == undefined){
        $("#centrocosto").html("");
        return false;
    }
    var empresa = $("#empresa").val();
    $.ajax({
        type: "POST",
        url: "php/validation/mandante.php",
        data: {usuario:usuario, empresa:empresa},
        success: function(data){
            $("#centrocosto").html(data);
        }
    });

}

$(document).ready(function(){
    checkcentrocosto($("#usuario").val());
});

function asignar(usuario, centrocosto){
    $.ajax({
        type: "POST",
        url: "php/insert/mandante.php",
        data: {usuario:usuario, centrocosto:centrocosto},
        success: function(data){
            if(data==1 || data=="1"){
                ToastifySuccess("Asignado correctamente");
                checkcentrocosto(usuario);
            }else{
                ToastifyError("Error al asignar");
            }
        }
    });
}

function revocar(usuario, centrocosto){
    $.ajax({
        type: "POST",
        url: "php/eliminar/mandante.php",
        data: {usuario:usuario, centrocosto:centrocosto},
        success: function(data){
            if(data==1 || data=="1"){
                ToastifySuccess("Revocado correctamente");
                checkcentrocosto(usuario);
            }else{
                ToastifyError("Error al revocar");
            }
        }
    });
}