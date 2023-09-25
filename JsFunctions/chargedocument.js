$(document).ready(function () {
    $("#documentoform").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/subirdocumento.php",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Documento Registrado Correctamente");
                    setTimeout(function () {
                        location.href = "menuinfo.php";
                    }, 1000);
                } else if (data == 0) {
                    ToastifyError("Error al Registrar");
                } else {
                    ToastifyError(data);
                }
            }
        });
    });
});

