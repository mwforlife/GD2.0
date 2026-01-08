//Funcion de carga inicial
$(document).ready(function () {
    mostrar1();
    detigra();
    listarcomunasespecifica();
});

function listarcomunasespecifica() {
    var region = $(".regionespecifica").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/comunas.php",
        data: "id=" + region,
        success: function (data) {
            $(".comunaespecifica").html(data);
        },
    });
}

//Funcion para mostrar las secciones del contrato express
//Gestionar Primera Seccion
function mostrar1() {
    $(".men1").addClass("active");
    $(".men2").removeClass("active");
    $(".men3").removeClass("active");
    $(".men4").removeClass("active");
    $(".identificacion").removeClass("d-none");
    $(".funciones").addClass("d-none");
    $(".Remuneraciones").addClass("d-none");
    $(".jornada").addClass("d-none");
}

//Gestionar Segunda Seccion
function mostrar2() {
    $(".men1").addClass("active");
    $(".men2").addClass("active");
    $(".men3").removeClass("active");
    $(".men4").removeClass("active");
    $(".identificacion").addClass("d-none");
    $(".funciones").removeClass("d-none");
    $(".Remuneraciones").addClass("d-none");
    $(".jornada").addClass("d-none");
}

//Gestionar Tercera Seccion
function mostrar3() {
    $(".men1").addClass("active");
    $(".men2").addClass("active");
    $(".men3").addClass("active");
    $(".men4").removeClass("active");
    $(".identificacion").addClass("d-none");
    $(".funciones").addClass("d-none");
    $(".Remuneraciones").removeClass("d-none");
    $(".jornada").addClass("d-none");
}

//Gestionar Cuarta Seccion
function mostrar4() {
    $(".men1").addClass("active");
    $(".men2").addClass("active");
    $(".men3").addClass("active");
    $(".men4").addClass("active");
    $(".identificacion").addClass("d-none");
    $(".funciones").addClass("d-none");
    $(".Remuneraciones").addClass("d-none");
    $(".jornada").removeClass("d-none");
}

//Gestionar MENU
function mostrar(v) {
    if (v == 1) {
        mostrar1();
    } else if (v == 2) {
        mostrar2();
    } else if (v == 3) {
        mostrar3();
    } else if (v == 4) {
        mostrar4();
    }
    scrollToTop();
}
function scrollToTop() {
    window.scrollTo(0, 0);
}

function detigra() {
    var v = $("#formapago").val();
    $("#detitext").html($("#formapago option:selected").data("content"));
    $(".periogat").toggleClass("d-none", !["2", "3", "4"].includes(v));
    $(".detdrati").toggleClass("d-none", v != "3");
}