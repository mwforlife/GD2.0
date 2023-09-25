$(document).ready(function () {
    $("#formanotaciones").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/anotaciones.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Anotacion Registrada");
                    setTimeout(function () {
                        location.href = "menuinfo.php";
                    }, 1000);
                } else if(data == 0) {
                    ToastifyError("Error al Registrar");
                }else{
                    ToastifyError(data);
                }
            }
        });
    });
});

