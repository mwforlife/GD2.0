function filtrarliquidaciones(){
    var centrocosto = $("#centrocosto").val();
    var periodo = $("#periodo").val();

    if(centrocosto == "" && periodo == ""){
        ToastifyError("Debe seleccionar un centro de costo o un periodo");
        return;
    }

    $.ajax({
        type: "POST",
        url: "php/validation/filtrarliquidaciones.php",
        data: {centrocosto: centrocosto, periodo: periodo},
        success: function(data){
            location.reload();
        }
    });

}

function limpiarfiltro(){
    var centrocosto = "";
    var periodo = "";
    $.ajax({
        type: "POST",
        url: "php/validation/filtrarliquidaciones.php",
        data: {centrocosto: centrocosto, periodo: periodo},
        success: function(data){
            location.reload();
        }
    });
}

function eliminar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/liquidacion.php",
                data: {id: id},
                success: function(data){
                    try {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            ToastifySuccess(json.message);
                            setTimeout(function(){
                                location.reload();
                            }, 1500);
                        }else{
                            ToastifyError(json.message);
                        }
                    } catch (error) {
                        ToastifyError(data);
                    }
                }
            });
        }
    });
}

//agregar(".$object->getId().",\"".$object->getTrabajador()."\",\"".$object->getCentroCosto()."\",\"".$mes." ".$anio."\")
var liquidaciones = new Array();

//Agregar liquidacion
function agregar(id, trabajador, centrocosto, periodo){

    //Validar si ya existe
    if(validarregistro(id)){
        ToastifyError("La liquidación ya se encuentra agregada");
        return;
    }

    //Agregar liquidacion
    var liquidacion = new Object();
    liquidacion.id = id;
    liquidacion.trabajador = trabajador;
    liquidacion.centrocosto = centrocosto;
    liquidacion.periodo = periodo;
    liquidaciones.push(liquidacion);
    actualizarTabla();
    ToastifySuccess("Liquidación agregada");
}

//Validar si ya existe
function validarregistro(id){
    for(var i = 0; i < liquidaciones.length; i++){
        if(liquidaciones[i].id == id){
            return true;
        }
    }
    return false;
}

//Actualizar tabla
function actualizarTabla(){
    if(validarlista()){
    var html = "";
    for(var i = 0; i < liquidaciones.length; i++){
        html += "<tr>";
        html += "<td>"+liquidaciones[i].trabajador+"</td>";
        html += "<td>"+liquidaciones[i].centrocosto+"</td>";
        html += "<td>"+liquidaciones[i].periodo+"</td>";
        html += "<td><button class='btn btn-danger' onclick='eliminarLiquidacion("+liquidaciones[i].id+")'><i class='fas fa-trash'></i></button></td>";
        html += "</tr>";
    }
    $("#objects").removeClass("d-none");
    $("#contenido").html(html);
    }else{
        $("#objects").addClass("d-none");
        $("#contenido").html("");
    }
}

//Eliminar liquidacion
function eliminarLiquidacion(id){
    for(var i = 0; i < liquidaciones.length; i++){
        if(liquidaciones[i].id == id){
            liquidaciones.splice(i, 1);
            actualizarTabla();
            break;
        }
    }
}

//Validar lista si esta vacia
function validarlista(){
    if(liquidaciones.length == 0){
        return false;
    }
    return true;
}

//Limpiar lista
function limpiarlista(){
    liquidaciones = new Array();
    actualizarTabla();
}

//Imprimir Todo
function imprimirtodo(){
    if(validarlista()){
        window.open("php/report/liquidaciones.php?liquidaciones="+JSON.stringify(liquidaciones), "_blank");
    }else{
        ToastifyError("No hay liquidaciones para imprimir");
    }
}

function eliminartodo(){
    if(validarlista()==false){
        ToastifyError("No hay liquidaciones para eliminar");
        return;
    }
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/liquidaciones.php",
                data: {liquidaciones: JSON.stringify(liquidaciones)},
                success: function(data){
                    try {
                        var json = JSON.parse(data);
                        if(json.status == true){
                            ToastifySuccess(json.message);
                            setTimeout(function(){
                                location.reload();
                            }, 1500);
                        }else{
                            ToastifyError(json.message);
                        }
                    } catch (error) {
                        ToastifyError(data);
                    }
                }
            });
        }
    });
}