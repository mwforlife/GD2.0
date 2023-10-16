function checktype(element){
    var type = element.value;

    // Obtén la opción seleccionada
    var selectedOption = element.options[element.selectedIndex];

    // Obtén el valor del atributo "tipo" de la opción seleccionada
    var tipoAtributo = selectedOption.getAttribute("period");

    if(tipoAtributo == "1"){
        $("#periodo").attr("disabled", false);
        $("#periodo").attr("required", true);
    }else{
        $("#periodo").attr("disabled", true);
        $("#periodo").attr("required", false);

    }

}

checktype(document.getElementById("tipo"));

$(document).ready(function() {
    $("#documentoform").on('submit', function(e) {
        e.preventDefault();
        var form = new FormData(this);
        $.ajax({
            url: "php/insert/documententerprise.php",
            type: "POST",
            data: form,
            contentType: false,
            processData: false,
            success: function(data) {
               try {
                    var json = JSON.parse(data);
                    if(json.status == true){
                        ToastifySuccess(json.message);
                        setTimeout(function(){ location.reload(); }, 1500);
                    }else{
                        ToastifyError(json.message);
                    }
               } catch (error) {
                    ToastifyError(error);
               }
            }
        });
    });
});

function eliminardocumento(id){
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
                url: "php/eliminar/documentoempresa.php",
                data: {id: id},
                success: function(data){
                    $("#global-loader").hide();
                    try {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            ToastifySuccess(json.message);
                            setTimeout(function(){ location.reload(); }, 1500);
                        }else{
                            ToastifyError(json.message);
                        }

                    } catch (error) {
                        ToastifyError(error);
                    }
                }
            });
        }else{
            $("#global-loader").hide();
            ToastifyInfo("Operacion cancelada");
        }
    });
}