$(document).ready(function () {
    //Registrar Trabajador
    $("#TrabajadorForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var rut = $("#TrabajadorRut").val();
        if (validarRut(rut) == false) {
            $("#global-loader").fadeOut("slow");
            ToastifyError("Rut Invalido");
            return false;
        }
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/trabajadores.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos guardados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else if (data == 2 || data == "2") {
                    ToastifyError("El Trabajador ya se encuentra registrado");
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    //Editar Trabajador
    $("#TrabajadorFormEdit").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var rut = $("#TrabajadorRut").val();
        if (validarRut(rut) == false) {
            $("#global-loader").fadeOut("slow");
            ToastifyError("Rut Invalido");
            return false;
        }
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/trabajadores.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    $("#PreviForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/previs.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos guardados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    });
    $("#CargaForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/cargas.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos guardados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else if (data == 2 || data == "2") {
                    ToastifyError("Esta Carga Ya Ha sido asignada");
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    });
    $("#CargaFormEdit").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/update/cargas.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    });
    $("#DomicilioEdit").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/trabajadoresdomicilio.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    $("#DomicilioEditForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/trabajadoresdomicilioedit.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    $("#ContactFormEdit").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/trabajadorescontacto.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    $("#ContactFormEditForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/trabajadorescontactoedit.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    $("#ContratoFormEditForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: "php/update/trabajadorescontratoedit.php",
            data: data,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    }
    );
    $("#LicenciaForm").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var dataForm = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/licencias.php",
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos guardados correctamente");
                    setTimeout(function () {
                        //Volver a la pagina anterior del historial
                        window.history.back();
                    }, 2000);
                } else {
                    ToastifyError(data);
                }
            }
        });
    });
    $("#LicenciaFormEdit").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var dataForm = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/update/licencias.php",
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        //Volver a la pagina anterior del historial
                        window.history.back();
                    }, 2000);
                } else {
                    ToastifyError(data);
                }
            }
        });
    });

    $("#vacacionesform").on("submit", function (e) {
        e.preventDefault();
        var dataForm = new FormData(this);
        //Enviar los datos por GET a la pagina php y abre el archivo en un modal
        var url = "php/previa/vacaciones.php";
        var modal = $("#previadocument");
        var modalBody = $("#previadocument");
        var ruta = url+"?"+$(this).serialize();
        $("#iframebody").attr("src",ruta);
        modal.modal("show");
    });

    $("#formvacaprogresivas").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var dataForm = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/afecto.php",
            data: dataForm,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos guardados correctamente");
                } else if (data == 3 || data == "3") {
                    ToastifySuccess("Datos Actualizados correctamente");
                }
                else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        })
    });
    $("#formcargarcomp").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var dataForm = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/comprobantes.php",
            data: dataForm,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Comprobante cargado correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);

                }
                else {
                    ToastifyError(data);
                }
            }
        })
    });
    $("#cuentabancariaform").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        $("#global-loader").fadeIn("slow");
        var dataForm = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/insert/cuentabancaria.php",
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos guardados correctamente");
                    $("#global-loader").fadeOut("slow");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    $("#global-loader").fadeOut("slow");
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    });
    $("#cuentabancariaformedit").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var dataForm = new FormData(this);
        $.ajax({
            type: "POST",
            url: "php/update/cuentabancaria.php",
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Datos Actualizados correctamente");
                    setTimeout(function () {
                        window.location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al guardar los datos");
                }
            }
        });
    });
});

function validarpacto() {
    $id = $("#TrabajadorIsapre").val();
    if ($id <= 0) {
        ToastifyError("Seleccione una Isapre");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "php/validation/pacto.php",
        data: { id: $id },
        success: function (data) {
            $("#global-loader").fadeOut("slow");
            if (data == 2 || data == "2") {
                $(".pacto").css("display", "block");
                $(".pacto").attr("required", true);
            } else {
                $(".pacto").css("display", "none");
                $(".pacto").attr("required", false);
            }
            $("#tipoIsapre").val(data);
        }
    });
}

function listarpervision() {
    $.ajax({
        type: "POST",
        url: "php/listar/previs.php",
        success: function (data) {
            $(".tableprevision").html(data);
        }
    });
}

function listarcargas() {
    $.ajax({
        type: "POST",
        url: "php/listar/cargas.php",
        success: function (data) {
            $(".tablecargas").html(data);
        }
    });
}

function eliminardomicilio($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar este Domicilio?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/domicilio.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Domicilio Eliminado");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Domicilio");
                    }
                }
            });
        } else {
            ToastifySuccess("El Domicilio no ha sido eliminado");
        }
    });
}

function eliminarcontacto($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar este Contacto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/contacto.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Contacto Eliminado");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Contacto");
                    }
                }
            });
        } else {
            ToastifySuccess("El Contacto no ha sido eliminado");
        }
    });
}

function eliminarinfocontrato($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar la información de este contrato?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/trabajadorcargo.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Información Eliminada");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Información");
                    }
                }
            });
        } else {
            ToastifySuccess("Operacion Cancelada");
        }
    });
}

function eliminarinforemuneracion($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar la información de esta remuneración?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/trabajadorremuneracion.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Información Eliminada");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Información");
                    }
                }
            });
        } else {
            ToastifySuccess("Operacion Cancelada");
        }
    });
}

function eliminarprevision($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar esta Previsión?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/prevision.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Previsión Eliminada");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Previsión");
                    }
                }
            });
        } else {
            ToastifySuccess("La Previsión no ha sido eliminada");
        }
    });
}

function eliminarcarga($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar esta Carga?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/carga.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Carga Eliminada");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Carga");
                    }
                }
            });
        } else {
            ToastifySuccess("La Carga no ha sido eliminada");
        }
    });
}

function eliminarlicencia($id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar esta Licencia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/licencias.php",
                data: { id: $id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Licencia Eliminada");
                        setTimeout(function () {
                            window.location.href = "menuinfo.php";
                        }, 2000);
                    } else {
                        ToastifyError("Error al Eliminar Licencia");
                    }
                }
            });
        } else {
            ToastifySuccess("La Licencia no ha sido eliminada");
        }
    });
}

function nuevocontrato(id) {
    $.ajax({
        type: "POST",
        url: "php/cargar/new.php",
        data: { id: id },
        success: function (data) {
            window.location.href = "contratoindividual.php";
        }
    });
}


function buscartrabajador() {
    var rut = $("#rut").val();
    if (validarRut(rut)) {
        $.ajax({
            type: "POST",
            url: "php/cargar/new.php",
            data: { rut: rut },
            success: function (data) {
                if (data == 0 || data == "0") {
                    ToastifyError("No se encontró ningun trabajador registrado con este Rut");
                } else {
                    swal.fire({
                        title: "¿Desea redactar el contrato de este trabajador?",
                        text: data,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Si, Redactar",
                        cancelButtonText: "No, Cancelar",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = "contratoindividual.php";
                        } else {
                            ToastifySuccess("Operación Cancelada");
                        }
                    });
                }

            }
        });
    } else {
        ToastifyError("Rut no valido");
    }
}

function agregarDatatable() {


}

function calcular() {
    var fechainicio = $("#fechainicio").val();
    if (fechainicio == "") {
        return;
    }
    var fechatermino = $("#fechatermino").val();
    if (fechatermino == "") {
        return;
    }
    //Calculo de dias
    var fecha1 = new Date(fechainicio);
    var fecha2 = new Date(fechatermino);
    if (fechainicio > fechatermino) {
        $("#cantidaddias").val(0);
    } else {
        var dias = Math.floor((fecha2 - fecha1) / (1000 * 60 * 60 * 24));
        $("#cantidaddias").val(dias + 1);
    }
}

function calcular1() {
    //Calcula de dias de vacaciones restando los dias de fin de semana 
    var fechainicio = $("#fechainicio").val();
    if (fechainicio == "") {
        return;
    }
    var fechatermino = $("#fechatermino").val();
    if (fechatermino == "") {
        return;
    }
    if (fechainicio > fechatermino) {
        $("#cantidaddias").val(0);
    } else {
        $.ajax({
            type: "POST",
            url: "php/autoprocess/calculodias.php",
            data: { fechainicio: fechainicio, fechatermino: fechatermino },
            success: function (data) {
                //Recibir un json con los dias habiles, dias feriados, dias fin de semana y total de dias
                var json = JSON.parse(data);
                var diashabiles = json.diasHabiles;
                var diasfindesemana = json.diasFinSemana;
                var diasferiados = json.diasFeriados;
                var totales = json.totales;
                //Convertir a numero
                var diashabiles = parseInt(diashabiles);
                var diasfindesemana = parseInt(diasfindesemana);
                var diasferiados = parseInt(diasferiados);
                var totales = parseInt(totales);

                $("#cantidaddias").val(diashabiles);
                $("#diasinhabiles").val(diasfindesemana);
                $("#diasferiados").val(diasferiados);
                $("#totales").val(totales);

                var diasvacaciones = $("#diasvacaciones").val();
                if (diasvacaciones.trim().length > 0) {
                    if(diasvacaciones == 0 || diasvacaciones == "0"){
                        ToastifyError("No tiene dias de vacaciones acumulados");
                        $("#cantidaddias").val(0);
                        $("#diasinhabiles").val(0);
                        $("#diasferiados").val(0);
                        $("#totales").val(0);
                        $("#diasrestantes").val(0);
                        return;
                    }
                    var diasvacaciones = parseInt(diasvacaciones);
                    var diasrestantes = diasvacaciones - diashabiles;
                    if(diasrestantes < 0){
                        $("#cantidaddias").val(0);
                    }else{
                    $("#diasrestantes").val(diasrestantes);
                    }
                }else{
                    ToastifyError("No tiene dias de vacaciones acumulados");
                }
            }
        });
    }
}

//Vista Previa Tipodocumento
function previadocument(id) {
    $.ajax({
        type: "POST",
        url: "php/cargar/previa.php",
        data: "id=" + id,
        success: function (data) {
            $(".previadocument").html(data);
        },
    });
}

//Seleccionar TIpo Documento
function seleccionartipodocumento(id, codigo, nombre) {
    $("#tipocontratotext").html(codigo + " - " + nombre);
    $("#tipocontratoid").val(id);
}

//Eliminar vacaciones
function eliminarvacaciones(id) {
    swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "No podrá recuperar este registro",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/vacaciones.php",
                data: "id=" + id,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Registro eliminado");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("No se pudo eliminar el registro");
                    }
                },
            });
        } else {
            ToastifySuccess("Operación Cancelada");
        }
    });
}

function change() {
    var jubilado = $("#jubilado").val();
    if (jubilado == 1) {
        $("#documentojubilacion").prop("required", true);
    } else {
        $("#documentojubilacion").prop("required", false);
        //Eliminar documento adjunto al input de jubilacion dropify
        var drEvent = $('#documentojubilacion').dropify();
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
        drEvent.settings.defaultFile = "";
        drEvent.destroy();
        drEvent.init();


    }

}

function vista(valor, trabajador) {
    if (valor == 1) {
        $(".afectosi").removeClass("d-none");
        //Agregar atributo class d-flex al segundo div de la clase afectosi
        $(".afectosi").children("div").eq(1).addClass("d-flex");
    } else {
        $(".afectosi").removeClass("d-flex");
        $(".afectosi").addClass("d-none");
        //Eliminar atributo class d-flex al segundo div de la clase afectosi
        $(".afectosi").children("div").eq(1).removeClass("d-flex");
        $.ajax({
            type: "POST",
            url: "php/eliminar/afectos.php",
            data: "trabajador=" + trabajador,
            success: function (data) {
                console.log("Registro eliminado");
                $("#vacacionesprogresivas").val("");
            }
        });
    }
}

function cargarcomprobante(id) {
    $("#idvacaciones").val(id);
}

function eliminarcuentabancaria(id) {
    swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "No podrá recuperar este registro",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/cuentabancaria.php",
                data: "id=" + id,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Registro eliminado");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("No se pudo eliminar el registro");
                    }
                },
            });
        } else {
            ToastifySuccess("Operación Cancelada");
        }
    });
}

function eliminarfiniquito(id) {
    swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "No podrá recuperar este registro",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/finiquito.php",
                data: "id=" + id,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Finiquitos eliminado");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("No se pudo eliminar el registro");
                    }
                },
            });
        } else {
            ToastifySuccess("Operación Cancelada");
        }
    });
}

function eliminarcontrato(id) {
    swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "No podrá recuperar este registro",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/contrato.php",
                data: "id=" + id,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Contrato eliminado");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("No se pudo eliminar el registro");
                    }
                },
            });
        } else {
            ToastifySuccess("Operación Cancelada");
        }
    });
}

function detallefiniquito(id) {
    $.ajax({
        type: "POST",
        url: "php/cargar/detallefiniquito.php",
        data: "id=" + id,
        success: function (data) {
            $(".detallefin").html(data);
        },
    });
}

function eliminarnotificacion(id) {
    swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "No podrá recuperar este registro",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/notificacion.php",
                data: "id=" + id,
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Notificación eliminada");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("No se pudo eliminar el registro");
                    }
                },
            });
        } else {
            ToastifySuccess("Operación Cancelada");
        }
    });
}

function eliminardocumento(id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar este Documento?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/documento.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Documento Eliminado");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("Error al Eliminar");
                    }
                }
            });
        } else {
            ToastifySuccess("Operacion Cancelada");
        }
    });
}

function eliminaranotacion(id) {
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar esta anotación?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/anotacion.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1 || data == "1") {
                        ToastifySuccess("Anotación Eliminada");
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        ToastifyError("Error al Eliminar");
                    }
                }
            });
        } else {
            ToastifySuccess("Operacion Cancelada");
        }
    });
}

function eliminaranotacion(id) {
    Swal.fire({
        title: '¿Estas seguro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/anotaciones.php",
                data: "id=" + id,
                success: function (data) {
                    if (data == 1) {
                        ToastifySuccess("Anotacion Eliminada");
                        setTimeout(function () {
                            location.href = "menuinfo.php";
                        }, 1000);
                    } else if (data == 0) {
                        ToastifyError("Error al Eliminar");
                    } else {
                        ToastifyError(data);
                    }
                }
            });
        } else {
            ToastifyInfo("Accion Cancelada");
        }
    })
}

function mostraranotacion(id) {
    $.ajax({
        type: "POST",
        url: "php/cargar/anotaciones.php",
        data: "id=" + id,
        success: function (data) {
            $("#anot").html(data);
        }
    });
}

function eliminardocumentosubido(id) {
    Swal.fire({
        title: '¿Estas seguro?',
        text: "No podras revertir esta accion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php/eliminar/eliminardocumento.php",
                data: { id: id },
                success: function (data) {
                    if (data == 1) {
                        ToastifySuccess("Documento Eliminado Correctamente");
                        setTimeout(function () {
                            location.href = "menuinfo.php";
                        }, 1000);
                    } else {
                        ToastifyError("Error al Eliminar");
                    }
                }
            });
        } else {
            ToastifyInfo("Accion Cancelada");
        }
    });
}

function generarcomprobante(){
    //Ejecutar formulario de vacaciones
    //$("#vacacionesform").submit(); 
    $("#global-loader").fadeIn("slow");
    var dataForm = new FormData($("#vacacionesform")[0]);
    $.ajax({
        type: "POST",
        url: "php/insert/vacaciones.php",
        data: dataForm,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#global-loader").fadeOut("slow");
            if (data == 1 || data == "1") {
                ToastifySuccess("Datos guardados correctamente");
                setTimeout(function () {
                    window.location.href = "menuinfo.php";
                }, 2000);
            } else if (data == 0 || data == "0") {
                ToastifyError("No se pudo guardar los datos");
            } else {
                ToastifyError(data);
            }
        }
    });
}

function buscartrabajador(element){
    var rut = $(element).val();
    if(rut.trim().length < 8){
        return;
    }

    if(validarRut(rut)==false){
        return;
    }

    $.ajax({
        type: "POST",
        url: "php/cargar/buscartrabajador.php",
        data: { rut: rut },
        success: function (data) {
            try {
                var object = JSON.parse(data);
                $("#TrabajadorDNI").val(object.dni);
                $("#TrabajadorNombre").val(object.nombre);
                $("#TrabajadorApellido1").val(object.apellido1);
                $("#TrabajadorApellido2").val(object.apellido2);
                $("#TrabajadorNacimiento").val(object.nacimiento);
                //Seleccionar la option del select sexo
                $("#TrabajadorSexo option[value="+object.sexo+"]").attr("selected",true);
                //Seleccionar la option del select estado civil
                $("#TrabajadorCivil option[value="+object.civil+"]").attr("selected",true);
                //Seleccionar la option del select nacionalidad
                $("#TrabajadorNacionalidad option[value="+object.nacionalidad+"]").attr("selected",true);
                //Seleccionar la option del select discapacidad
                $("#TrabajadorDiscapacidad option[value="+object.discapacidad+"]").attr("selected",true);
                //Seleccionar la option del select pension
                $("#TrabajadorPension option[value="+object.pension+"]").attr("selected",true);
                $("#TrabajadorCalle").val(object.calle);
                $("#TrabajadorVilla").val(object.villa);
                $("#TrabajadorNumero").val(object.numero);
                $("#TrabajadorDepartamento").val(object.departamento);
                //Seleccionar la option del select region
                $("#TrabajadorRegion option[value="+object.region+"]").attr("selected",true);
                listarcomunas(); 
                listarciudades();
                //Seleccionar la option del select comuna
                $("#TrabajadorComuna option[value="+object.comuna+"]").attr("selected",true);
                //Seleccionar la option del select ciudad
                $("#TrabajadorCiudad option[value="+object.ciudad+"]").attr("selected",true);
                $("#TrabajadorTelefono").val(object.telefono);
                $("#TrabajadorCorreo").val(object.correo);
            } catch (error) {
                console.log(error);
            }

        }
    });

}

function buscaranexo(contrato){
    $.ajax({
        type: "POST",
        url: "php/cargar/buscaranexo.php",
        data: { contrato: contrato },
        success: function (data) {
            $("#anexos").html(data);
            $("#modalanexos").modal("show");

        }
    });
}

function eliminaranexo(id,contrato){
    //Confirmar Eliminarcion
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas ver los anexos de este contrato?",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if(result.value){
            $.ajax({
                type: "POST",
                url: "php/eliminar/anexo.php",
                data: { id: id },
                success: function (data) {
                    if(data == 1 || data == "1"){
                        buscaranexo(contrato);
                    }else{
                        ToastifyError("Error al Eliminar");
                    }
                }
            });
        }
    });
}

function eliminardanexo(id){
    //Confirmar Eliminarcion
    swal.fire({
        title: "¿Estas seguro?",
        text: "¿Deseas eliminar este anexo?",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if(result.value){
            $.ajax({
                type: "POST",
                url: "php/eliminar/anexo.php",
                data: { id: id },
                success: function (data) {
                    if(data == 1 || data == "1"){
                        location.reload();
                    }else{
                        ToastifyError("Error al Eliminar");
                    }
                }
            });
        }
    });
}