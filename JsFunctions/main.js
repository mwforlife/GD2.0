function seleccionarEmpresa(id){
    if(id == 0){
        ToastifyError("Seleccione una empresa");
        return;
    }
    $.ajax({
        url: "php/cargar/seleccionarEmpresa.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            ToastifySuccess("Empresa seleccionada Con exito");
            mostrarEmpresa(id);
            setTimeout(function(){
                location.reload();
            }, 1000);
        }
    });

}

function mostrarEmpresa(id){
    $.ajax({
        url: "php/cargar/empresaname.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            $(".empresaname").html(data);
        }
    });
}