function filtarmovimiento(){
    var periodo = $("#periodo").val();
    var periodo_termino = $("#periodo_termino").val();
    var centrocosto = $("#centrocosto").val();

    $.ajax({
        type: "POST",
        url: "php/validation/filtrarmovimiento.php",
        data: { periodo: periodo, periodo_termino: periodo_termino, centrocosto: centrocosto },
        success: function (response) {
            location.reload();
        }
    });
}

function limpiarfiltro(){
    $.ajax({
        type: "POST",
        url: "php/validation/filtrarmovimiento.php",
        success: function (response) {
            location.reload();
        }
    });
}

function eliminar(id){
    swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/movimiento.php",
                data: { id: id },
                success: function (response) {
                    try {
                        var json = JSON.parse(response);
                        if (json.status == true) {
                            ToastifySuccess(json.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            ToastifyError(json.message);
                        }
                    } catch (error) {
                        ToastifyError(response);
                    }
                }
            });
        }
    })
}