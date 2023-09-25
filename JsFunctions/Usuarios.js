window.onload = function () {
    //alert("Hola");
    listarcomunas();
    $(".form-control").attr("autocomplete","off");
}

$(document).ready(function(){
    $("#UserForm").on("submit", function(e){
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var rut = $("#UserRut").val();
        var pass = $("#UserPassword").val();
        var pass2 = $("#UserPassword1").val();
        if(validarRut(rut)){
            if(pass == pass2){

            var form = $(this);
            var data = form.serialize();
            $.ajax({
                url: "php/insert/usuarios.php",
                type: "POST",
                data: data,
                success: function(data){
                    if(data == 1 || data == "1"){
                        $("#global-loader").fadeOut("slow");
                        ToastifySuccess("Registro insertado correctamente");
                        setTimeout(function(){
                            window.location.href = "usuarios.php";
                        }, 1500);
                    }else if(data == 0 || data == "0"){
                        $("#global-loader").fadeOut("slow");
                        ToastifyError("Error Al Registrar");
                    }else{
                        $("#global-loader").fadeOut("slow");
                        ToastifyError(data);
                    }
                }
            });
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError("Las contraseñas no coinciden");
            }
        }else{
            $("#global-loader").fadeOut("slow");
            ToastifyError("Rut Invalido");
        }
    }
    );

    $("#UserEditForm").on("submit", function(e){
        e.preventDefault();
        var rut = $("#UserRut").val();
        if(validarRut(rut)){
            var form = $(this);
            var data = form.serialize();
            $.ajax({
                url: "php/update/usuarios.php",
                type: "POST",
                data: data,
                success: function(data){
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Registro actualizado correctamente");
                        setTimeout(function(){
                            window.location.href = "usuarios.php";
                        }, 1500);
                    }else if(data == 0 || data == "0"){
                        ToastifyError("Error Al Actualizar");
                    }else{
                        ToastifyError(data);
                    }
                }
            });
        }else{
            ToastifyError("Rut Invalido");
        }
    }
    );

    $("#changepass").on("click", function(e){
        e.preventDefault();
        var pass = $("#NewPass").val();
        var pass2 = $("#NewPass1").val();
        var id = $("#idus").val();
        if(pass == pass2){
            $.ajax({
                url: "php/update/password.php",
                type: "POST",
                data: {id: id, pass: pass},
                success: function(data){
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Contraseña actualizada correctamente");
                        setTimeout(function(){
                            window.location.href = "usuarios.php";
                        }, 1500);
                    }else if(data == 0 || data == "0"){
                        ToastifyError("Error Al Actualizar");
                    }else{
                        ToastifyError(data);
                    }
                }
            });
        }else{
            ToastifyError("Las contraseñas no coinciden");
        }
    }
    );
});


function more(id){
    $.ajax({
        url: "php/listar/usuarios.php",
        type: "POST",
        data: {id:id},
        success: function(data){
           $(".detalle").html(data);
           ;
        }
    });
    
}

function Eliminar(id){
    swal.fire({
        title: "¿Estas seguro?",
        text: "No podras revertir esto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "php/eliminar/usuarios.php",
                type: "POST",
                data: {id:id},
                success: function(data){
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Registro eliminado correctamente");
                        setTimeout(function(){
                            window.location.href = "usuarios.php";
                        }, 1500);
                    }else if(data == 0 || data == "0"){
                        ToastifyError("Error Al Eliminar");
                    }else{
                        ToastifyError(data);
                    }
                }
            });
        }else{
            ToastifyInfo("Proceso Cancelado");
        }
    });
}

function asignar(id,usuario){
    $.ajax({
        url: "php/insert/asignar.php",
        type: "POST",
        data: {id:id,usuario:usuario},
        success: function(data){
            if(data == 1 || data == "1"){
                ToastifySuccess("Permiso asignado correctamente");
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }else if(data == 0 || data == "0"){
                ToastifyError("Error Al Registrar");
            }else{
                ToastifyError(data);
            }
        }
    });
}

function revocar(id,usuario){
    swal.fire({
        title: "¿Estas seguro?",
        text: "No podras revertir esto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "php/eliminar/revocar.php",
                type: "POST",
                data: {id:id,usuario:usuario},
                success: function(data){
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Permiso revocado correctamente");
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else if(data == 0 || data == "0"){
                        ToastifyError("Error Al Registrar");
                    }else{
                        ToastifyError(data);
                    }
                }
            });
        }else{
            ToastifyInfo("Proceso Cancelado");
        }
    }
    );

    
}

function cargarid(id){
    $("#idus").val(id);
}

