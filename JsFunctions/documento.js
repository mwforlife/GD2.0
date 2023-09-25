$(document).ready(function () {
    $("#formdocumento").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertardocumento.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Documento Registrado Correctamente");
                    setTimeout(function () {
                        location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al Registrar");
                }
            }
        });
    });
    $("#previadocumento").on("click", function () {
        var datos = $("#formdocumento").serialize();
        $("#global-loader").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "php/cargar/previadocumento.php",
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
    $("#formdocumentomasivo").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertardocumentomasivo.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Documentos Registrados Correctamente");
                    setTimeout(function () {
                        location.href = "generarlotepersonalizado.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al Registrar");
                }
            }
        });
    });
    $("#previadocumentomasivo").on("click", function () {
        var datos = $("#formdocumentomasivo").serialize();
        $("#global-loader").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "php/cargar/previadocumentomasivo.php",
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