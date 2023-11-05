function generarlibro(){
    var periodo = $("#periodo").val();
    if(periodo == ""){
        ToastifyError("Debe seleccionar un periodo");
        return false;
    }

    
    $(".content").html('<div class="alert alert-info"><i class="fe fe-info mr-2" aria-hidden="true"></i>Cargando......</div>');

    $.ajax({
        type: "POST",
        url: "php/cargar/libroremuneraciones.php",
        data: {periodo: periodo},
        success: function (response) {
            $(".content").html(response);
        }
    });
    
}

function exportarlibroremuneracionespdf(){
    var periodo = $("#periodo").val();
    if(periodo == ""){
        ToastifyError("Debe seleccionar un periodo");
        return false;
    }

    window.open('php/report/libroremuneracionespdf.php?periodo='+periodo);
}

exportarlibroremuneracionesexcel = function(){
    var periodo = $("#periodo").val();
    if(periodo == ""){
        ToastifyError("Debe seleccionar un periodo");
        return false;
    }

    window.open('php/report/libroremuneracionesexcel.php?periodo='+periodo);
}