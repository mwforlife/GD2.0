var trabajadores = new Array();

function agregartrabajador(id, rut, nombre, contrato) {
    if (!validatrabajador(id)) {
        ToastifyError("Ya existe un trabajador con ese id");
        return false;
    }
    var trabajador = new Object();
    trabajador.id = id;
    trabajador.rut = rut;
    trabajador.nombre = nombre;
    trabajador.contrato = contrato;
    trabajadores.push(trabajador);
    gettrabajadores();
}

function allwork() {
    $.ajax({
        url: "php/cargar/trabajadoresactivos.php",
        success: function (response) {
            try {
                var json = JSON.parse(response);
                json.forEach(element => {
                    agregartrabajador(element.id, element.rut, element.nombre, element.contrato);
                });
            } catch (error) {
                console.log(error);
                ToastifyError("Error al cargar los trabajadores");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
}

function validatrabajador(id) {
    for (var i = 0; i < trabajadores.length; i++) {
        if (trabajadores[i].id == id) {
            return false;
        }
    }
    return true;
}

function eliminatrabajador(id) {
    for (var i = 0; i < trabajadores.length; i++) {
        if (trabajadores[i].id == id) {
            trabajadores.splice(i, 1);
        }
    }
    gettrabajadores();
}

function gettrabajadores() {
    var html = "";
    for (var i = 0; i < trabajadores.length; i++) {
        html += "<tr>";
        html += "<td>" + trabajadores[i].rut + "</td>";
        html += "<td>" + trabajadores[i].nombre + "</td>";
        html += "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"eliminatrabajador(" + trabajadores[i].id + ")\"><i class=\"fas fa-trash-alt\"></i></button></td>";
        html += "</tr>";
    }
    $("#lotes").html(html);
}

//Revisar si la lista esta vacia
function validalista() {
    if (trabajadores.length == 0) {
        return false;
    }
    return true;
}

function Eliminartodo() {
    trabajadores = new Array();
    gettrabajadores();
}


function filtrartrabajadores() {
    var centrocosto = $("#centrocosto").val();
    $.ajax({
        url: "php/cargar/trabajadorescentro.php",
        data: { centrocosto: centrocosto },
        type: "POST",
        success: function (response) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
}

function limpiarfiltro() {
    var centrocosto = $("#centrocosto").val();
    $.ajax({
        url: "php/eliminar/trabajadorescentro.php",
        type: "POST",
        success: function (response) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
}

function cambiarevento(element) {
    //Capturar el valor del atributo termino del elemento del select
    var termino = element.options[element.selectedIndex].getAttribute('termino');
    //Capturar la Entidad del elemento del select
    var entidad = element.options[element.selectedIndex].getAttribute('entidad');

    if (termino == 1) {
        $(".termino").removeClass("d-none");
    } else {
        $(".termino").addClass("d-none");
    }
}

$(document).ready(function () {
    cambiarevento(document.getElementById("evento"));
});

function procesartodo() {
    //abrir una ventana nueva enviando el array de trabajadores
    var periodo = $("#periodo").val();
    var tipomovimiento = $("#tipo").val();
    var evento = $("#evento").val();
    var fechainicio = $("#fechainicio").val();
    var fechatermino = $("#fechatermino").val();

    if (validalista()) {
        if (periodo.trim().length == 0) {
            ToastifyError("Debe seleccionar un periodo");
            return false;
        }
        if (tipomovimiento.trim().length == 0) {
            ToastifyError("Debe seleccionar un tipo de movimiento");
            return false;
        }
        if (evento.trim().length == 0) {
            ToastifyError("Debe seleccionar un evento");
            return false;
        }

        if (fechainicio.trim().length == 0) {
            ToastifyError("Debe seleccionar una fecha de inicio");
            return false;
        }

        var element = document.getElementById("evento");
        //Capturar el valor del atributo termino del elemento del select
        var termino = element.options[element.selectedIndex].getAttribute('termino');
        //Capturar la Entidad del elemento del select
        var entidad = element.options[element.selectedIndex].getAttribute('entidad');

        if (termino == 1) {
            if (fechatermino.trim().length == 0) {
                ToastifyError("Debe seleccionar una fecha de termino");
                return false;
            }
        }

        $.ajax({
            url: "php/insert/movpersonal.php",
            method: "POST",
            data: { trabajadores: JSON.stringify(trabajadores), periodo: periodo, tipomovimiento: tipomovimiento, evento: evento,termino:termino,entidad:entidad, fechainicio: fechainicio, fechatermino: fechatermino },
            success: function (response) {
                try {
                    var json = JSON.parse(response);
                    if (json.status == true) {
                        var jsonexito = json.exito;
                        var jsonerror = json.errores;
                        var html = "";
                        var htmlerror = "";
                        for (var i = 0; i < jsonexito.length; i++) {
                            html += jsonexito[i] + "<br>";
                        }

                        for (var i = 0; i < jsonerror.length; i++) {
                            htmlerror += jsonerror[i] + "<br>";
                        }

                        if (html.trim().length > 0) {
                            html = "<div class=\"alert alert-success\" role=\"alert\">" + html + "</div>";
                        }

                        if (htmlerror.trim().length > 0) {
                            htmlerror = "<div class=\"alert alert-danger\" role=\"alert\">" + htmlerror + "</div>";
                        }

                        $("#message-content").html(html + htmlerror);
                    } else {
                        ToastifyError(json.message);
                    }
                } catch (error) {
                    console.log(error);
                    ToastifyError("Error al ingresar el movimiento de personal");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });

    } else {
        ToastifyError("Debe seleccionar al menos un trabajador");
    }
}