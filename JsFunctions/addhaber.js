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

//Asignar Haberes y Descuentos a Trabajador
function verificartipo(){
    // Obtén el elemento select por su ID
    var selectElement = document.getElementById("codigohaber");

    // Obtén la opción seleccionada
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    // Obtén el valor del atributo "tipo" de la opción seleccionada
    var tipoAtributo = selectedOption.getAttribute("tipo");

    console.log("El valor del atributo 'tipo' de la opción seleccionada es: " + tipoAtributo);
    var tipo = tipoAtributo;
    console.log(tipo);
    if(tipo==1){
        $(".monto").removeClass("d-none");
        $(".monto").attr("required", "required");
        $(".monto").val("");
        $(".dias").addClass("d-none", "d-none");
        $(".dias").removeAttr("required");
        $(".dias").val("");
        $(".horas").addClass("d-none", "d-none");
        $(".horas").removeAttr("required");
        $(".horas").val("");
    }else if(tipo==3){
        $(".monto").addClass("d-none", "d-none");
        $(".monto").removeAttr("required");
        $(".monto").val("");
        $(".dias").removeClass("d-none");
        $(".dias").removeAttr("required", "required");
        $(".dias").val("");
        $(".horas").addClass("d-none", "d-none");
        $(".horas").attr("required", "required");
        $(".horas").val("");
    }else if(tipo==2){
        $(".monto").addClass("d-none", "d-none");
        $(".monto").removeAttr("required");
        $(".monto").val("");
        $(".dias").addClass("d-none", "d-none");
        $(".dias").removeAttr("required");
        $(".dias").val("");
        $(".horas").removeClass("d-none");
        $(".horas").attr("required", "required");
        $(".horas").val("");
    }
}


function registrarhaberes(){
    //Validar lista
    if(!validalista()){
        ToastifyError("Debe agregar al menos un trabajador");
        return false;
    }   
    //Recuperar datos
    var codigo = $("#codigohaber").val();
    var periodoini = $("#periodoini").val();
    var periodofin = $("#periodoter").val();
    var monto = $("#monto").val();
    var dias = $("#dias").val();
    var horas = $("#horas").val();
    var tipo = $("#codigohaber").find(":selected").attr("tipo");
    var modalidad = $("#modalidad").val();

    //Validar datos
    if(codigo==0){
        ToastifyError("Debe seleccionar un haber o descuento");
        return false;
    }

    if(periodoini==""){
        ToastifyError("Debe seleccionar un periodo inicial");
        return false;
    }

    if(periodofin==""){
        ToastifyError("Debe seleccionar un periodo final");
        return false;
    }

    if(tipo==1){
        if(monto==""){
            ToastifyError("Debe ingresar un monto");
            return false;
        }
    }else if(tipo==2){
        if(horas==""){
            ToastifyError("Debe ingresar las horas");
            return false;
        }
    }else if(tipo==3){
        if(dias==""){
            ToastifyError("Debe ingresar los dias");
            return false;
        }
    }

    if(modalidad==""){
        ToastifyError("Debe seleccionar una modalidad");
        return false;
    }

    //Enviar datos
    var data = new FormData();
    data.append("codigo", codigo);
    data.append("periodoini", periodoini);
    data.append("periodofin", periodofin);
    data.append("monto", monto);
    data.append("dias", dias);
    data.append("horas", horas);
    data.append("tipo", tipo);
    data.append("modalidad", modalidad);
    data.append("trabajadores", JSON.stringify(trabajadores));
    $.ajax({
        url: "php/insert/habertrabajador.php",
        type: "POST",
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            try {
                var json = JSON.parse(response);
                if(json.status==true){
                    ToastifySuccess(json.message);
                    setTimeout(function(){ window.location.href = "habmaster.php"; }, 1500);
                }else{
                    ToastifyError(json.message);
                }
            } catch (error) {
                ToastifyError("Error al asignar haberes y descuentos");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            ToastifyError("Error al asignar haberes y descuentos");
        },
    });
}

function filtrarhaberesdescuentos(){
    var periodoinico = $("#periodoinico").val();
    var periodofin = $("#periodofin").val();
    var funcionario = $("#funcionario").val();
    var tipo = $("#tipo").val();

    if(periodoinico.trim().length==0){
        ToastifyError("Debe ingresar el periodo inicial");
        $("#periodoinico").focus();
        return false;
    }

    if(periodofin.trim().length==0){
        ToastifyError("Debe ingresar el periodo final");
        $("#periodofin").focus();
        return false;
    }

    //Comparar si el periodo inicial es mayor al periodo final
    var dateini = new Date(periodoinico);
    var datefin = new Date(periodofin);
    if(dateini>datefin){
        ToastifyError("El periodo inicial no puede ser mayor al periodo final");
        $("#periodoinico").focus();
        return false;
    }
    $.ajax({
        url: "php/cargar/filtrohaberessession.php",
        type: "POST",
        data: {periodoinico: periodoinico, periodofin: periodofin, funcionario: funcionario, tipo: tipo},
        success: function (response) {
            try {
                var json = JSON.parse(response);
                if(json.status==true){
                    location.reload();
                }else{
                    ToastifyError("UPS! No se pudo cargar el Filtro");
                }
            } catch (error) {
                console.log(error);
                ToastifyError("UPS! No se pudo cargar el Filtro");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            ToastifyError("Error al cargar los haberes y descuentos");
        },
    });
}

function limpiarfiltro(){
    $.ajax({
        url: "php/cargar/limpiarfiltrohaberes.php",
        success: function (response) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            ToastifyError("Error al cargar los haberes y descuentos");
        },
    });
}

function eliminarhabertrabajador(id){
    swal.fire({
        title: '¿Está seguro de eliminar este haber o descuento?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:'Si, eliminar',
        cancelButtonText: 'No, cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "php/eliminar/habertrabajador.php",
                type: "POST",
                data: {id: id},
                success: function (response) {
                    try {
                        var json = JSON.parse(response);
                        if(json.status==true){
                            ToastifySuccess(json.message);
                            setTimeout(function(){ 
                                location.reload();
                             }, 1500);
                        }else{
                            ToastifyError(json.message);
                        }
                    } catch (error) {
                        ToastifyError("Error al eliminar el haber o descuento");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    ToastifyError("Error al eliminar el haber o descuento");
                },
            });
        }
    })
}