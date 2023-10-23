function agregar(id, descripcion) {
    descripcion = descripcion.replace(" ", "_");
    var iddent = "{";
    iddent += descripcion + ";id:" + id + "}";
    //pasar a mayusculas
    iddent = iddent.toUpperCase();
    $("#formula").val($("#formula").val() + iddent);
    $("#formula").focus();
}

function sumar() {
    $("#formula").val($("#formula").val() + "+");
    $("#formula").focus();
}

function restar() {
    $("#formula").val($("#formula").val() + "-");
    $("#formula").focus();
}

function multiplicar() {
    $("#formula").val($("#formula").val() + "*");
    $("#formula").focus();
}

function dividir() {
    $("#formula").val($("#formula").val() + "/");
    $("#formula").focus();
}

function representacion(element) {
    var valor = $(element).val();
    if (valor.trim().length == 0) {
        $("#represent").val("");
        return;
    } else {
        valor = valor.replaceAll(" ", "_");
        valor = valor.toUpperCase();
        $("#represent").val("{" + valor + "}");
    }
}

function agregaratributo(atributo){
    $("#formula").val($("#formula").val() + atributo);
    $("#formula").focus();
}

$(document).ready(function () {
    $("#formulaform").submit(function (e) {
        e.preventDefault();
        var formdata = new FormData(this);
        $.ajax({
            url: "php/insert/formula.php",
            type: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data) {
                try {
                    var json = JSON.parse(data);
                    if (json.status == true) {
                        ToastifySuccess(json.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        ToastifyError(json.message);
                    }
                } catch (error) {
                    ToastifyError(error)
                }
            }
        });
    });
});

function utilizar(representacion){
    $("#formula").val($("#formula").val() + representacion);
    $("#formula").focus();
}

function eliminar(id){
    swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'No, cancelar',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: "php/eliminar/formula.php",
                type: "POST",
                data: {
                    id: id
                },
                success: function (data) {
                    try {
                        var json = JSON.parse(data);
                        if (json.status == true) {
                            ToastifySuccess(json.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            ToastifyError(json.message);
                        }
                    } catch (error) {
                        ToastifyError(error)
                    }
                }
            });
        }
    })
}