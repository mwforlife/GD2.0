function asistencia(id, rut, nombre, centrocosto, contrato) {
    $("#contenidoasistencia").html("");
    $(".titleasis").html("Registrar asistencia<br>");
    $(".titleasis").append("Trabajador: " + nombre);
    $(".titleasis").append("<br>C.Costo: " + centrocosto);
    var inicio = $("#inicio").val();
    var termino = $("#termino").val();

    //Periodo en formato aaaa-mm
    var mesinicio = inicio.substring(5, 7);
    var anoinicio = inicio.substring(0, 4);

    var mestermino = termino.substring(5, 7);
    var anotermino = termino.substring(0, 4);

    switch (mesinicio) {
        case '01': mesinicio = 'Enero'; break;
        case '02': mesinicio = 'Febrero'; break;
        case '03': mesinicio = 'Marzo'; break;
        case '04': mesinicio = 'Abril'; break;
        case '05': mesinicio = 'Mayo'; break;
        case '06': mesinicio = 'Junio'; break;
        case '07': mesinicio = 'Julio'; break;
        case '08': mesinicio = 'Agosto'; break;
        case '09': mesinicio = 'Septiembre'; break;
        case '10': mesinicio = 'Octubre'; break;
        case '11': mesinicio = 'Noviembre'; break;
        case '12': mesinicio = 'Diciembre'; break;
    }

    switch (mestermino) {
        case '01': mestermino = 'Enero'; break;
        case '02': mestermino = 'Febrero'; break;
        case '03': mestermino = 'Marzo'; break;
        case '04': mestermino = 'Abril'; break;
        case '05': mestermino = 'Mayo'; break;
        case '06': mestermino = 'Junio'; break;
        case '07': mestermino = 'Julio'; break;
        case '08': mestermino = 'Agosto'; break;
        case '09': mestermino = 'Septiembre'; break;
        case '10': mestermino = 'Octubre'; break;
        case '11': mestermino = 'Noviembre'; break;
        case '12': mestermino = 'Diciembre'; break;
    }

    $(".titleasis").append("<br>Periodo: " + mesinicio + " " + anoinicio + " - " + mestermino + " " + anotermino);
    $.ajax({
        url: "php/validation/asistencia.php",
        type: "POST",
        data: { id: id, inicio: inicio, termino: termino, contrato: contrato },
        success: function (data) {
            $("#contenidoasistencia").html(data);
        }
    });

    $(".trabajadores").addClass("d-none");
    $(".asistencias").removeClass("d-none");
    $("#idtrabajador").val(id);
    //$("#modalasistencia").modal("show");
}

function recargartrabajores() {
    $(".trabajadores").removeClass("d-none");
    $(".asistencias").addClass("d-none");
    $("#idtrabajador").val("");
}
//".$id.",$empresa,$contrato,\"".$dia."\",this)
function cargarasistencia(id, empresa, contrato, dia, estado, elemento) {
    var valor = elemento;
    elemento = document.getElementById("button"+elemento);
    $.ajax({
        url: "php/validation/asistencia.php",
        type: "POST",
        data: { id: id, empresa: empresa, contrato: contrato, dia: dia, estado: estado },
        success: function () {
            switch (estado) {
                case 1: $(elemento).removeClass("btn-success"); $(elemento).addClass("btn-info"); $(elemento).attr("onclick", "cargarasistencia(" + id + "," + empresa + "," + contrato + ",'" + dia + "',2,"+valor+")"); $(elemento).attr("title", "Medio día"); break;
                case 2: $(elemento).removeClass("btn-info"); $(elemento).addClass("btn-danger"); $(elemento).attr("onclick", "cargarasistencia(" + id + "," + empresa + "," + contrato + ",'" + dia + "',3,"+valor+")"); $(elemento).attr("title", "Ausente"); break;
                case 3: $(elemento).removeClass("btn-danger"); $(elemento).addClass("btn-success"); $(elemento).attr("onclick", "cargarasistencia(" + id + "," + empresa + "," + contrato + ",'" + dia + "',1,"+valor+")"); $(elemento).attr("title", "Presente"); break;
                default: console.log("Error"); break;
            }
            ToastifySuccess("Asistencia actualizada");
        }
    });
}