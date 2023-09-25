function cargarfecha() {
    $("#global-loader").fadeIn("slow");

    var id = $("#contrato").val();
    if (id == 0) {
        $("#fechainicio").val("");
    } else {
        $.ajax({
            type: "POST",
            url: "php/cargar/cargarfecha.php",
            data: "id=" + id,
            success: function (fecha) {
                $("#global-loader").fadeOut("slow");
                if (fecha == 0) {
                    $("#fechainicio").val("");
                } else {
                    $("#fechainicio").val(fecha);
                    fechatermino(id);
                }
            }
        });
    }
}

function fechatermino(id) {
    $.ajax({
        type: "POST",
        url: "php/cargar/cargarfecha1.php",
        data: "id=" + id,
        success: function (fecha) {
            if (fecha == 0) {
                $("#fechatermino").val("");
            } else {
                $("#fechatermino").val(fecha);
            }
        }
    });
}

$(document).ready(function () {
    $("#formfiniquitop").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertarfiniquito.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Finiquito Registrado");
                    setTimeout(function () {
                        location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al Registrar");
                }
            }
        });
    });
    $("#previafiniquito").on("click", function () {
        var datos = $("#formfiniquitop").serialize();
        $("#global-loader").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "php/cargar/previafiniquito.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                var first = data.substring(0, 1);
                var url = data.substring(1);
                console.log(data);
                console.log(first);
                console.log(url);
                //Si el primer caracter es un numero
                if (first == 1 || first == "1") {
                    //Sacar la URL del texto sin el primer caracter
                    var url = data.substring(1);
                    //Mostrar vista previa en un modal e abrir el modal
                    $("#vistaprevia").attr("src", url);
                    $("#modalvistaprevia").modal("show");
                    //Mostrar vista previa en un modal e abrir el modal
                    //Agregar la URL

                } else {
                    ToastifyError(data);
                }
            }
        });
    });
    $("#formfiniquitomasivo").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertarfiniquitomasivo.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Finiquito Registrado");
                    setTimeout(function () {
                        location.href = "generarlotefiniquito.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al Registrar");
                }
            }
        });
    });
    $("#previafiniquitomasivo").on("click", function () {
        $("#global-loader").fadeIn("slow");
        var datos = $("#formfiniquitomasivo").serialize();
        $.ajax({
            type: "POST",
            url: "php/cargar/previafiniquitomasivo.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                var first = data.substring(0, 1);
                var url = data.substring(1);
                console.log(data);
                console.log(first);
                console.log(url);
                //Si el primer caracter es un numero
                if (first == 1 || first == "1") {
                    //Sacar la URL del texto sin el primer caracter
                    var url = data.substring(1);
                    //Mostrar vista previa en un modal e abrir el modal
                    $("#vistaprevia").attr("src", url);
                    $("#modalvistaprevia").modal("show");
                    //Mostrar vista previa en un modal e abrir el modal
                    //Agregar la URL

                } else {
                    ToastifyError(data);
                }
            }
        });
    });
    $("#formnotificacion").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertarnotificacion.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Notificación Registrada");
                    setTimeout(function () {
                        location.href = "menuinfo.php";
                    }, 2000);
                } else if(data ==0) {
                    ToastifyError("Error al Registrar");
                }else{
                    ToastifyError(data);
                }
            }
        });
    });
    $("#previanotificacion").on("click", function () {
        $("#global-loader").fadeIn("slow");
        var datos = $("#formnotificacion").serialize();
        $.ajax({
            type: "POST",
            url: "php/cargar/previanotificacion.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                var first = data.substring(0, 1);
                var url = data.substring(1);
                console.log(data);
                console.log(first);
                console.log(url);
                //Si el primer caracter es un numero
                if (first == 1 || first == "1") {
                    //Sacar la URL del texto sin el primer caracter
                    var url = data.substring(1);
                    //Mostrar vista previa en un modal e abrir el modal
                    $("#vistaprevia").attr("src", url);
                    $("#modalvistaprevia").modal("show");
                    //Mostrar vista previa en un modal e abrir el modal
                    //Agregar la URL

                } else {
                    ToastifyError(data);
                }
            }
        });
    });
    $("#formnotificacionmasiva").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertarnotificacionmasiva.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Notificación Registrada");
                    setTimeout(function () {
                        location.href = "generarlotenotificacion.php";
                    }, 2000);
                } else if(data ==0) {
                    ToastifyError("Error al Registrar");
                }else{
                    ToastifyError(data);
                }
            }
        });
    });
    $("#previanotificacionmasiva").on("click", function () {
        $("#global-loader").fadeIn("slow");
        var datos = $("#formnotificacionmasiva").serialize();
        $.ajax({
            type: "POST",
            url: "php/cargar/previanotificacionmasiva.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                var first = data.substring(0, 1);
                var url = data.substring(1);
                console.log(data);
                console.log(first);
                console.log(url);
                //Si el primer caracter es un numero
                if (first == 1 || first == "1") {
                    //Sacar la URL del texto sin el primer caracter
                    var url = data.substring(1);
                    //Mostrar vista previa en un modal e abrir el modal
                    $("#vistaprevia").attr("src", url);
                    $("#modalvistaprevia").modal("show");
                    //Mostrar vista previa en un modal e abrir el modal
                    //Agregar la URL

                } else {
                    ToastifyError(data);
                }
            }
        });
    });
});

function registrarresumen() {
    $("#global-loader").fadeIn("slow");
    var tipo = $("#tipo").val();
    var descripcion = $("#descripcion").val();
    var monto = $("#monto").val();
    if (tipo == 0) {
        ToastifyError("Seleccione un Tipo");
        $("#tipo").focus();
        return;
    }

    if (descripcion.trim().length == 0) {
        $("#global-loader").fadeOut("slow");
        ToastifyError("Ingrese una Descripcion");
        $("#descripcion").focus();
        return;
    }

    if (monto <= 0) {
        $("#global-loader").fadeOut("slow");
        ToastifyError("Ingrese un Monto");
        $("#monto").focus();
        return;
    }

    var datos = "tipo=" + tipo + "&descripcion=" + descripcion + "&monto=" + monto;
    $.ajax({
        type: "POST",
        url: "php/insert/insertarresumen.php",
        data: datos,
        success: function (data) {
            $("#global-loader").fadeOut("slow");
            if (data == 1) {
                ToastifySuccess("Fila Agregada");
                listarresumen();
            } else {
                ToastifyError("Error al Agregar");
            }
        }
    });
}

function listarresumen() {
    $.ajax({
        type: "POST",
        url: "php/cargar/resumenfiniquito.php",
        success: function (data) {
            $("#tableresumen").html(data);
        }
    });
}

function eliminar(id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar esta Fila?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/resumenfiniquito.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Fila Eliminada");
                        listarresumen();
                    } else {
                        ToastifyError("Error al Eliminar");
                    }
                }
            });
        } else {
            ToastifySuccess("Operacion Cancelada");
        }
    });
}

function cargarinfo() {
    var id = $("#finiquito").val();
    if (id == 0) {
        ToastifyError("Seleccione un Finiquito");
        $(".datefiniquito").html("");
        $("#tableresumen").html("");
        $("#finiquito").focus();
        return;
    } else {
        $.ajax({
            type: "POST",
            url: "php/cargar/cargarinfo.php",
            data: "id=" + id,
            success: function (data) {
                if (data == 0) {
                    ToastifyError("Error al Cargar");
                    $(".datefiniquito").html("");
                } else {
                    $(".datefiniquito").html(data);
                    detallefiniquito(id);
                }
            }
        });
    }
}


function detallefiniquito(id) {
    $.ajax({
        type: "POST",
        url: "php/cargar/detallefiniquito1.php",
        data: "id=" + id,
        success: function (data) {
            $("#tableresumen").html(data);
        },
    });
}

function vista(val) {
    if (val == 1) {
        $(".vista").addClass("d-none");
    } else {
        $(".vista").removeClass("d-none");
    }
}

function vistas(val){
    if(val == 1){
        $(".vista2").removeClass("d-none");
        $(".vista3").addClass("d-none");
    }else if(val == 2){
        $(".vista3").removeClass("d-none");
        $(".vista2").addClass("d-none");
    }
}

