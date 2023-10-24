 var trabajadores = new Array();

function agregartrabajador(id, rut, nombre) {
    if(!validatrabajador(id)){
        ToastifyError("Ya existe un trabajador con ese id");
        return false;
    }
    var trabajador = new Object();
    trabajador.id = id;
    trabajador.rut = rut;
    trabajador.nombre = nombre;
    trabajadores.push(trabajador);
    gettrabajadores();
}

function allwork(){
    $.ajax({
        url: "php/cargar/trabajadoresactivos.php",
        success: function (response) {
            try {
                var json = JSON.parse(response);
                json.forEach(element => {
                    agregartrabajador(element.id, element.rut, element.nombre);
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
function validalista(){
    if(trabajadores.length==0){
        return false;
    }
    return true;
}

function Eliminartodo(){
    trabajadores = new Array();
    gettrabajadores();
}

function procesartodo(){
    //abrir una ventana nueva enviando el array de trabajadores
    if(validalista()){
        window.open("procesamiento.php?trabajadores="+JSON.stringify(trabajadores));
    }else{
        ToastifyError("No hay trabajadores para procesar");
    }
}

function filtrartrabajadores(){
    var centrocosto = $("#centrocosto").val();
    $.ajax({
        url: "php/cargar/trabajadorescentro.php",
        data: {centrocosto:centrocosto},
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

function limpiarfiltro(){
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