//Gestionar MENU
function mostrar(v) {
    if (v == 1) {
        mostrar1();
    } else if (v == 2) {
        validarform1();
    } else if (v == 3) {
        validarform2();
    } else if (v == 4) {
        validarform3();
    }
}

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

function validarform1() {
    var regioncelebracion = $("#regioncelebracion").val();
    var comunacelebracion = $("#comunacelebracion").val();
    var fechacelebracion = $("#fechacelebracion").val();
    var tipocontratoid = $("#tipocontratoid").val();
    var nombre_razon_social = $("#nombre_razon_social").val();
    var rut_empleador = $("#rut_empleador").val();
    var representante_legal = $("#representante_legal").val();
    var correo_electronico = $("#correo_electronico").val();
    var telefono = $("#telefono").val();
    var codigoactividadid = $("#codigoactividadid").val();
    var domicilio = $("#domicilio").val();
    var empresaregion = $("#empresaregion").val();
    var empresacomuna = $("#empresacomuna").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var ruttrabajador = $("#ruttrabajador").val();
    var nombretrabajador = $("#nombretrabajador").val();
    var apellidos = $("#apellidos").val();
    var fechanacimiento = $("#fechanacimiento").val();
    var sexo = $("#sexo").val();
    var nacionalidad = $("#nacionalidad").val();
    var correotrabajador = $("#correotrabajador").val();
    var telefonotrabajador = $("#telefonotrabajador").val();
    var trabajadorregion = $("#trabajadorregion").val();
    var trabajadorcomuna = $("#trabajadorcomuna").val();
    var calletrabajador = $("#calletrabajador").val();
    var numerotrabajador = $("#numerotrabajador").val();
    var departamentotrabajador = $("#departamentotrabajador").val();

    if (regioncelebracion <= 0) {
        ToastifyError("Debe seleccionar una region de celebracion");
        mostrar1();
        $("#regioncelebracion").focus();
        return false;
    } else if (comunacelebracion <= 0) {
        ToastifyError("Debe seleccionar una comuna de celebracion");
        mostrar1();
        $("#comunacelebracion").focus();
        return false;
    } else if (fechacelebracion == false) {
        ToastifyError("Debe seleccionar una fecha de celebracion");
        mostrar1();
        $("#fechacelebracion").focus();
        return false;
    } else if (tipocontratoid <= 0) {
        ToastifyError("Debe seleccionar el tipo de documento");
        console.log(tipocontratoid);
        mostrar1();
        $("#tipocontratoid").focus();
        return false;
    } else if (nombre_razon_social.trim().length == 0) {
        ToastifyError("Debe ingresar el nombre o razon social");
        mostrar1();
        $("#nombre_razon_social").focus();
        return false;
    } else if (rut_empleador.trim().length == 0) {
        ToastifyError("Debe ingresar el rut del empleador");
        mostrar1();
        $("#rut_empleador").focus();
        return false;
    } else if (representante_legal <= 0) {
        ToastifyError("Debe ingresar el representante legal");
        mostrar1();
        $("#representante_legal").focus();
        return false;
    } else if (correo_electronico.trim().length == 0) {
        ToastifyError("Debe ingresar el correo electronico");
        mostrar1();
        $("#correo_electronico").focus();
        return false;
    } else if (telefono.trim().length == 0) {
        ToastifyError("Debe ingresar el telefono");
        mostrar1();
        $("#telefono").focus();
        return false;
    } else if (codigoactividadid <= 0) {
        ToastifyError("Debe seleccionar el codigo de actividad");
        mostrar1();
        $("#codigoactividadid").focus();
        return false;
    } else if (domicilio.trim().length == 0) {
        ToastifyError("Debe ingresar el domicilio");
        mostrar1();
        $("#domicilio").focus();
        return false;
    } else if (empresaregion <= 0) {
        ToastifyError("Debe seleccionar la region");
        mostrar1();
        $("#empresaregion").focus();
        return false;
    } else if (empresacomuna <= 0) {
        ToastifyError("Debe seleccionar la comuna");
        mostrar1();
        $("#empresacomuna").focus();
        return false;
    } else if (calle.trim().length == 0) {
        ToastifyError("Debe ingresar la calle");
        mostrar1();
        $("#calle").focus();
        return false;
    } else if (numero.trim().length == 0) {
        ToastifyError("Debe ingresar el numero");
        mostrar1();
        $("#numero").focus();
        return false;
    } else {
        mostrar2();
        return true;
    }
}

function validarform2() {
    if (validarform1() == true) {
        var centrocosto = $("#centrocosto").val();
        var Charge = $("#Charge").val();
        var ChargeDescripcion = $("#ChargeDescripcion").val();
        var regionespecifica = $("#regionespecifica").val();
        var comunaespecifica = $("#comunaespecifica").val();
        var calleespecifica = $("#calleespecifica").val();
        var numeroespecifica = $("#numeroespecifica").val();
        var subcontratacionrut = $("#subcontratacionrut").val();
        var subcontratacionrazonsocial = $("#subcontratacionrazonsocial").val();
        var transitoriosrut = $("#transitoriosrut").val();
        var transitoriosrazonsocial = $("#transitoriosrazonsocial").val();

        if (centrocosto <= 0) {
            ToastifyError("Debe ingresar el centro de costo");
            mostrar2();
            $("#centrocosto").focus();
            return false;
        } else if (Charge <= 0) {
            ToastifyError("Debe ingresar el cargo");
            mostrar2();
            $("#Charge").focus();
            return false;
        } else if (ChargeDescripcion.trim().length == 0) {
            ToastifyError("Debe ingresar la descripcion del cargo");
            mostrar2();
            $("#ChargeDescripcion").focus();
            return false;
        } else if (regionespecifica <= 0) {
            ToastifyError("Debe seleccionar la region");
            mostrar2();
            $("#regionespecifica").focus();
            return false;
        } else if (comunaespecifica <= 0) {
            ToastifyError("Debe seleccionar la comuna");
            mostrar2();
            $("#comunaespecifica").focus();
            return false;
        } else if (calleespecifica.trim().length == 0) {
            ToastifyError("Debe ingresar la calle");
            mostrar2();
            $("#calleespecifica").focus();
            return false;
        } else if (numeroespecifica.trim().length == 0) {
            ToastifyError("Debe ingresar el numero");
            mostrar2();
            $("#numeroespecifica").focus();
            return false;

            //Validar si Subcontratacion esta checkeado
        } else if ($("#subcontratacionval").is(":checked")) {
            if (subcontratacionrut.trim().length == 0) {
                ToastifyError("Debe ingresar el rut del trabajador subcontratado");
                mostrar2();
                $("#subcontratacionrut").focus();
                return false;
            } else if (subcontratacionrazonsocial.trim().length == 0) {
                ToastifyError(
                    "Debe ingresar la razon social del trabajador subcontratado"
                );
                mostrar2();
                $("#subcontratacionrazonsocial").focus();
                return false;
            }

            //Validar si transitoriosval esta checkeado
        } else if ($("#transitoriosval").is(":checked")) {
            if (transitoriosrut.trim().length == 0) {
                ToastifyError("Debe ingresar el rut del trabajador transitorio");
                mostrar2();
                $("#transitoriosrut").focus();
                return false;
            } else if (transitoriosrazonsocial.trim().length == 0) {
                ToastifyError(
                    "Debe ingresar la razon social del trabajador transitorio"
                );
                mostrar2();
                $("#transitoriosrazonsocial").focus();
                return false;
            }
        } else {
            mostrar3();
            return true;
        }
    }
}

function validarform3() {
    if (validarform1() == true && validarform2() == true) {
        var tiposueldo = $("#tiposueldo").val();
        var sueldo = $("#sueldo").val();
        var formapago = $("#formapago").val();
        var periodopagogra = $("#periodopagogra").val();
        var detallerenumeraciongra = $("#detallerenumeraciongra").val();
        var periodopagot = $("#periodopagotra").val();
        var fechapagot = $("#fechapagotra").val();
        var formapagot = $("#formapagot").val();
        var anticipot = $("#anticipot").val();
        var afp = $("#afp").val();
        var salud = $("#salud").val();
        var otrter = $("#otrter").val();

        if (tiposueldo <= 0) {
            ToastifyError("Debe ingresar el tipo de sueldo");
            mostrar3();
            $("#tiposueldo").focus();
            return false;
        } else if (sueldo.trim().length == 0) {
            ToastifyError("Debe ingresar el sueldo");
            mostrar3();
            $("#sueldo").focus();
            return false;
        } else if (formapago <= 0) {
            ToastifyError("Debe ingresar la forma de pago");
            mostrar3();
            $("#formapago").focus();
            return false;
        } else if (periodopagogra <= 0) {
            ToastifyError("Debe ingresar el periodo de pago");
            mostrar3();
            $("#periodopagogra").focus();
            return false;
        } else if (periodopagot <= 0) {
            ToastifyError("Debe ingresar el periodo de pago");
            mostrar3();
            $("#periodopagot").focus();
            return false;
        } else if (fechapagot <= 0) {
            ToastifyError("Debe Seleccionar la fecha de pago");
            mostrar3();
            $("#fechapagot").focus();
            return false;
        } else if (formapagot <= 0) {
            ToastifyError("Debe ingresar la forma de pago");
            mostrar3();
            $("#formapagot").focus();
            return false;
        } else if (anticipot <= 0) {
            ToastifyError("Debe ingresar el anticipo");
            mostrar3();
            $("#anticipot").focus();
            return false;
        } else if ($("#badi").is(":checked")) {
            if (otrter.trim().length == 0) {
                ToastifyError("Debe ingresar el otro tipo de pacto");
                mostrar3();
                $("#otrter").focus();
                return false;
            }
        } else {
            mostrar4();
            return true;
        }
    }
}

function validarform4() {
    if (validarform1() == true) {
        if (validarform2() == true) {
            if (validarform3() == true) {
                var noresolucion = $("#noresolucion").val();
                var exfecha = $("#exfecha").val();
                var tipojornada = $("#tipojornada").val();
                var horaspactadas = $("#horaspactadas").val();
                var dias = $("#dias").val();
                var colacion = $("#colacion").val();
                var Horaspactadas = $("#Horaspactadas").val();
                var colacionimp = $("#colacionimp").val();
                var fecha_inicio = $("#fecha_inicio").val();
                var fecha_termino = $("#fecha_termino").val();
                var estipulacion13 = $("#estipulacion13").val();
                var juramento = $("#juramento").val();

                //validar si jornadaesc es checkeado
                if ($("#jornadaesc").is(":checked")) {
                    if (noresolucion.trim().length == 0) {
                        ToastifyError("Debe ingresar el numero de resolucion");
                        mostrar4();
                        $("#noresolucion").focus();
                        return false;
                    } else if (exfecha == false) {
                        ToastifyError("Debe ingresar la fecha de expedicion");
                        mostrar4();
                        $("#exfecha").focus();
                        return false;
                    }
                    //validar si exluido no esta checkeado
                } else if ($("#exluido").is(":checked") == false) {
                    if (tipojornada <= 0) {
                        ToastifyError("Debe ingresar el tipo de jornada");
                        mostrar4();
                        $("#tipojornada").focus();
                        return false;
                    } else if (horaspactadas.trim().length == 0) {
                        ToastifyError("Debe ingresar las horas pactadas");
                        mostrar4();
                        $("#horaspactadas").focus();
                        return false;
                    } else if (dias.trim().length == 0) {
                        ToastifyError("Debe ingresar los dias");
                        mostrar4();
                        $("#dias").focus();
                        return false;
                    } else if (colacion.trim().length == 0) {
                        ToastifyError("Debe ingresar la colacion");
                        mostrar4();
                        $("#colacion").focus();
                        return false;
                    } else if (Horaspactadas.trim().length == 0) {
                        ToastifyError("Debe ingresar las horas pactadas");
                        mostrar4();
                        $("#Horaspactadas").focus();
                        return false;
                    } else if (colacionimp.trim().length == 0) {
                        ToastifyError("Debe ingresar la colacion");
                        mostrar4();
                        $("#colacionimp").focus();
                        return false;
                    }
                } else if (fecha_inicio == false) {
                    ToastifyError("Debe ingresar la fecha de inicio");
                    mostrar4();
                    $("#fecha_inicio").focus();
                    return false;
                    //Validar si tipo_contrato2 esta checkeado
                } else if ($("#tipo_contrato2").is(":checked")) {
                    if (fecha_termino == false) {
                        ToastifyError("Debe ingresar la fecha de termino");
                        mostrar4();
                        $("#fecha_termino").focus();
                        return false;
                    }
                    //Validar si estipulacion12 esta checkeado
                } else if ($("#estipulacion12").is(":checked")) {
                    if (estipulacion13.trim().length == 0) {
                        ToastifyError("Debe ingresar la estipulacion 13");
                        mostrar4();
                        $("#estipulacion13").focus();
                        return false;
                    }
                    //Validar si el juramento no esta checkeado
                } else if ($("#juramento").is(":checked") == false) {
                    ToastifyError("Debe aceptar el juramento");
                    mostrar4();
                    $("#juramento").focus();
                    return false;
                }
                return true;
            }
        }
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

//Seleccionar REpresentante Legal
function SeleccionarRepresentante(id, rut, nombre, apellido1, apellido2) {
    $("#representante_text").html(rut + " - " + nombre + " " + apellido1);
    $("#representante_legal").val(id);
}

//Seleccionar Codigo de Actividades
function SeleccionarCodigosii(id, codigo) {
    $.ajax({
      type: "POST",
      url: "php/cargar/codigoactividadcontrato.php",
      data: "id=" + id,
      success: function (data) {
        if(data == 0){
          ToastifyError("Codigo de Actividad no existe");
          $("#codigoactividadtext").html("");
          $("#codigoactividadid").val("");
        }else{
          $("#codigoactividadtext").html(codigo + " - " + data);
          $("#codigoactividadid").val(id);
        }
      },
    });
  }

//Funcion listar comunas Especificas
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

//Function AgregarRegion
function agregarregion() {
    var region = $("#zonaregion").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/regiones.php",
        data: "id=" + region,
        success: function (data) {
            actualizarprovincias();
        },
    });
}

//Function Actualizar Provincias
function actualizarprovincias() {
    $.ajax({
        type: "POST",
        url: "php/cargar/provincias.php",
        success: function (data) {
            $(".provincias").html(data);
        },
    });
}

//Function Agrergar Provincia
function agregarprovincia() {
    var provincia = $("#provincia").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/provincias.php",
        data: "id=" + provincia,
        success: function (data) {
            actualizarcomunas();
        },
    });
}

//Function Actualizar Comunas
function actualizarcomunas() {
    $.ajax({
        type: "POST",
        url: "php/cargar/comunas.php",
        success: function (data) {
            $(".comunas").html(data);
        },
    });
}

//Function Agregar Comuna
function agregarcomuna() {
    var comuna = $("#comuna").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/comunas.php",
        data: "id=" + comuna,
        success: function (data) { },
    });
}

//Function subcontratacion
function subcontratacion() {
    var subcontratacionval = $("#subcontratacionval").val();
    if (subcontratacionval == 0) {
        $(".subcontratacion").removeClass("d-none");
        $("#subcontratacionval").val(1);
        //Deselccionar checkbox transitorios
        $(".transitorios").addClass("d-none");
        $("#transitoriosval").val(0);
        $("#transitoriosval").prop("checked", false);
    } else {
        $(".subcontratacion").addClass("d-none");
        $("#subcontratacionval").val(0);
    }
}

//Fuction transitorios
function transitorios() {
    var transitoriosval = $("#transitoriosval").val();
    if (transitoriosval == 0) {
        $(".transitorios").removeClass("d-none");
        $("#transitoriosval").val(1);
        //Deseleccionar checkbox subcontratacion
        $(".subcontratacion").addClass("d-none");
        $("#subcontratacionval").val(0);
        $("#subcontratacionval").prop("checked", false);
    } else {
        $(".transitorios").addClass("d-none");
        $("#transitoriosval").val(0);
    }
}

//function checkpacto
function checkpacto() {
    var pacto = $("#badi").val();
    if (pacto == 0) {
        $(".pacto").removeClass("d-none");
        $(".otrter").attr("required", "required");
        $("#badi").val(1);
    } else {
        $(".pacto").addClass("d-none");
        $(".otrter").removeAttr("required");
        $("#badi").val(0);
    }
}

//function checkexcepcional
function checkexcepcional() {
    var excepcional = $("#jornadaesc").val();
    if (excepcional == 0) {
        $(".excepcional").removeClass("d-none");
        $(".noresolucion").attr("required", "required");
        $(".desde").attr("required", "required");
        $("#jornadaesc").val(1);
    } else {
        $(".excepcional").addClass("d-none");
        $(".noresolucion").removeAttr("required");
        $(".desde").removeAttr("required");
        $("#jornadaesc").val(0);
    }
}

//function checkexcluido
function checkexcluido() {
    var excluido = $("#exluido").val();
    if (excluido == 0) {
        $(".excluido").addClass("d-none");
        $(".excluidoselect").removeAttr("required");
        $("#exluido").val(1);
    } else {
        $(".excluido").removeClass("d-none");
        $(".excluidoselect").attr("required", "required");
        $("#exluido").val(0);
        tipochange();
    }
}

function detigra() {
    var detigra = $("#formapago").val();
    if (detigra == 1) {
        $("#detitext").html(
            "Las partes no pactan un sistema de pago de gratificación. Tener presente que en caso de ser de aquellas empresas señaladas en el artículo 47 del Código del Trabajo y obtener utilidades líquidas en su giro, tendrá la obligación de pagar esa."
        );
        $(".periogat").addClass("d-none");
        $(".detdrati").addClass("d-none");
    } else if (detigra == 2) {
        $("#detitext").html(
            "Gratificación no inferior al 30% de las utilidades de la empresa en el año anterior."
        );
        $(".periogat").removeClass("d-none");
        $(".detdrati").addClass("d-none");
    } else if (detigra == 3) {
        $("#detitext").html(
            "Es aquella pactada por las partes en el contrato individual o en instrumento colectivo y que sean superiores a las que resultan de la aplicación del artículo 47 o 50 del Código del Trabajo.."
        );
        $(".periogat").removeClass("d-none");
        $(".detdrati").removeClass("d-none");
    } else if (detigra == 4) {
        $("#detitext").html(
            "Gratificación del 25% de lo percibido por el trabajador, con un máximo de 4.75 IMM al año."
        );
        $(".periogat").removeClass("d-none");
        $(".detdrati").addClass("d-none");
    } else if (detigra == 5) {
        $("#detitext").html("No tiene obligación legal de pagar gratificación.");
        $(".periogat").addClass("d-none");
        $(".detdrati").addClass("d-none");
    }
}

function tipochange() {
    var tipo = $("#tipojornada").val();
    if (tipo == 1) {
        $(".joption1").removeClass("d-none");
        $(".joption2").addClass("d-none");
        $(".joption3").removeClass("d-none");
        $(".joption4").addClass("d-none");
        checkturno();
    } else if (tipo == 2) {
        $(".joption1").removeClass("d-none");
        $(".joption2").removeClass("d-none");
        $(".joption3").addClass("d-none");
        $(".joption4").addClass("d-none");
        checkturno();
    } else if (tipo == 3) {
        $(".joption1").addClass("d-none");
        $(".joption2").removeClass("d-none");
        $(".joption3").addClass("d-none");
        $(".joption4").removeClass("d-none");
        $(".general").addClass("d-none");
        $(".matutino").addClass("d-none");
        $(".tarde").addClass("d-none");
        $(".noche").addClass("d-none");
        $(".cola").addClass("d-none");
        checkturno();
    } else if (tipo == 4) {
        $(".joption1").addClass("d-none");
        $(".joption2").removeClass("d-none");
        $(".joption3").addClass("d-none");
        $(".joption4").removeClass("d-none");
        checkturno();
        $(".general").addClass("d-none");
        $(".matutino").addClass("d-none");
        $(".tarde").addClass("d-none");
        $(".noche").addClass("d-none");
        $(".cola").addClass("d-none");
    } else {
        $(".joption1").removeClass("d-none");
        $(".joption2").removeClass("d-none");
        $(".joption3").addClass("d-none");
        $(".joption4").addClass("d-none");
        checkturno();
    }
}
//function checkturno
function checkturno() {
    //Clases
    //1 - General
    //2 - Nada
    //3 - Mañana y Tarde
    //4 - Tarde y Noche
    //5 - Mañana y Noche
    //6 - Mañana y Tarde y Noche
    //.general
    //.matutino
    //.tarde
    //.noche
    var turno = $("#horarioturno").val();
    var tipo = $("#tipojornada").val();
    if (turno == 1 && tipo != 3 && tipo != 4) {
        $(".general").removeClass("d-none");
        $(".matutino").addClass("d-none");
        $(".tarde").addClass("d-none");
        $(".noche").addClass("d-none");
        $(".cola").removeClass("d-none");
        $(".rotativo").addClass("d-none");
    } else if (turno == 2 && tipo != 3 && tipo != 4) {
        $(".general").addClass("d-none");
        $(".matutino").addClass("d-none");
        $(".tarde").addClass("d-none");
        $(".noche").addClass("d-none");
        $(".cola").addClass("d-none");
        $(".rotativo").addClass("d-none");
    } else if (turno == 3 && tipo != 3 && tipo != 4) {
        $(".general").addClass("d-none");
        $(".matutino").removeClass("d-none");
        $(".tarde").removeClass("d-none");
        $(".noche").addClass("d-none");
        $(".cola").removeClass("d-none");
        $(".rotativo").removeClass("d-none");
    } else if (turno == 4 && tipo != 3 && tipo != 4) {
        $(".general").addClass("d-none");
        $(".matutino").addClass("d-none");
        $(".tarde").removeClass("d-none");
        $(".noche").removeClass("d-none");
        $(".cola").removeClass("d-none");
        $(".rotativo").removeClass("d-none");
    } else if (turno == 5 && tipo != 3 && tipo != 4) {
        $(".general").addClass("d-none");
        $(".matutino").removeClass("d-none");
        $(".tarde").addClass("d-none");
        $(".noche").removeClass("d-none");
        $(".cola").removeClass("d-none");
        $(".rotativo").removeClass("d-none");
    } else if (turno == 6 && tipo != 3 && tipo != 4) {
        $(".general").addClass("d-none");
        $(".matutino").removeClass("d-none");
        $(".tarde").removeClass("d-none");
        $(".noche").removeClass("d-none");
        $(".cola").removeClass("d-none");
        $(".rotativo").removeClass("d-none");
    }
    console.log(turno);
    console.log(tipo);
    if (turno == 3 || turno == 4 || turno == 5 || turno == 6) {
        $(".rotativo").removeClass("d-none");
        console.log("entro");
    } else {
        $(".rotativo").addClass("d-none");
        console.log("no entro");
    }
}

//todo3onclick
function todo3onclick() {
    //Validar si el elemento  esta checkeado
    if ($("#todo3").is(":checked")) {
        //Checkear todos los elementos
        $(".dias4").prop("checked", true);
    } else {
        //Descheckear todos los elementos
        $(".dias4").prop("checked", false);
    }
}

//todo2onclick
function todo2onclick() {
    //Validar si el elemento  esta checkeado
    if ($("#todo2").is(":checked")) {
        //Checkear todos los elementos
        $(".dias3").prop("checked", true);
    } else {
        //Descheckear todos los elementos
        $(".dias3").prop("checked", false);
    }
}

//todo1onclick
function todo1onclick() {
    //Validar si el elemento  esta checkeado
    if ($("#todo1").is(":checked")) {
        //Checkear todos los elementos
        $(".dias2").prop("checked", true);
    } else {
        //Descheckear todos los elementos
        $(".dias2").prop("checked", false);
    }
}

//todoonclick
function todoonclick() {
    //Validar si el elemento  esta checkeado
    if ($("#todo").is(":checked")) {
        //Checkear todos los elementos
        $(".dias1").prop("checked", true);
    } else {
        //Descheckear todos los elementos
        $(".dias1").prop("checked", false);
    }
}

//checktodo1
function checktodo1() {
    //Validar si todos los dias estan checkeados y si el dia domingo esta habilitado validar si esta checkeado
    if ($(".dias1:checked").length == 7) {
        //Checkear el elemento todo1
        $("#todo").prop("checked", true);
    } else if (
        $(".dias1:checked").length == 6 &&
        $("#dias17").is(":disabled") == true &&
        $("#dias17").is(":checked") == true
    ) {
        //Checkear el elemento todo1
        $("#todo").prop("checked", false);
    } else if (
        $(".dias1:checked").length == 6 &&
        $("#dias17").is(":disabled") == true &&
        $("#dias17").is(":checked") == false
    ) {
        //Checkear el elemento todo4
        $("#todo").prop("checked", true);
    } else {
        //Descheckear el elemento todo1
        $("#todo").prop("checked", false);
    }
}

//checktodo2
function checktodo2() {
    //Validar si todos los dias estan checkeados y si el dia domingo esta habilitado validar si esta checkeado
    if ($(".dias2:checked").length == 7) {
        //Checkear el elemento todo2
        $("#todo1").prop("checked", true);
    } else if (
        $(".dias2:checked").length == 6 &&
        $("#dias27").is(":disabled") == true &&
        $("#dias27").is(":checked") == true
    ) {
        //Checkear el elemento todo2
        $("#todo1").prop("checked", false);
    } else if (
        $(".dias2:checked").length == 6 &&
        $("#dias27").is(":disabled") == true &&
        $("#dias27").is(":checked") == false
    ) {
        //Checkear el elemento todo2
        $("#todo1").prop("checked", true);
    } else {
        //Descheckear el elemento todo2
        $("#todo1").prop("checked", false);
    }
}

//checktodo3
function checktodo3() {
    //Validar si todos los dias estan checkeados y si el dia domingo esta habilitado validar si esta checkeado
    if ($(".dias3:checked").length == 7) {
        //Checkear el elemento todo3
        $("#todo2").prop("checked", true);
    } else if (
        $(".dias3:checked").length == 6 &&
        $("#dias37").is(":disabled") == true &&
        $("#dias37").is(":checked") == true
    ) {
        //Checkear el elemento todo3
        $("#todo2").prop("checked", false);
    } else if (
        $(".dias3:checked").length == 6 &&
        $("#dias37").is(":disabled") == true &&
        $("#dias37").is(":checked") == false
    ) {
        //Checkear el elemento todo3
        $("#todo2").prop("checked", true);
    } else {
        //Descheckear el elemento todo3
        $("#todo2").prop("checked", false);
    }
}

//checktodo4
function checktodo4() {
    //Validar si todos los dias estan checkeados y si el dia domingo esta habilitado validar si esta checkeado
    if ($(".dias4:checked").length == 7) {
        //Checkear el elemento todo4
        $("#todo3").prop("checked", true);
    } else if (
        $(".dias4:checked").length == 6 &&
        $("#dias47").is(":disabled") == true &&
        $("#dias47").is(":checked") == true
    ) {
        //Checkear el elemento todo4
        $("#todo3").prop("checked", false);
    } else if (
        $(".dias4:checked").length == 6 &&
        $("#dias47").is(":disabled") == true &&
        $("#dias47").is(":checked") == false
    ) {
        //Checkear el elemento todo4
        $("#todo3").prop("checked", true);
    } else {
        //Descheckear el elemento todo4
        $("#todo3").prop("checked", false);
    }
}

//function incluyedomingo
function incluyedomingo() {
    //Validar si el elemento  esta checkeado
    if ($("#incluye").is(":checked")) {
        //Habilite todos los domingos
        $("#dias17").prop("disabled", false);
        $("#dias27").prop("disabled", false);
        $("#dias37").prop("disabled", false);
        $("#dias47").prop("disabled", false);
        checktodo1();
        checktodo2();
        checktodo3();
        checktodo4();
    } else {
        //Deshabilite todos los domingos
        $("#dias17").prop("disabled", true);
        $("#dias27").prop("disabled", true);
        $("#dias37").prop("disabled", true);
        $("#dias47").prop("disabled", true);
        checktodo1();
        checktodo2();
        checktodo3();
        checktodo4();
    }
}

//Function contratotipo
function contratotipo(element) {
    var tipo = $(element).val();
    if (tipo == 1) {
        $(".terminor").addClass("d-none");
        $(".terminorinput").removeAttr("required", "required");
    } else if (tipo == 2) {
        $(".terminor").removeClass("d-none");
        $(".terminorinput").attr("required", "required");
    } else {
        $(".terminor").addClass("d-none");
        $(".terminorinput").removeAttr("required", "required");
    }
}

//Function checkotraestipulacion
function checkotraestipulacion() {
    //Validar si esta checkeado
    if ($("#estipulacion12").is(":checked")) {
        $(".otraestipulacion").removeClass("d-none");
        $(".otraestipulacion input").attr("required", "required");
    } else {
        $(".otraestipulacion").addClass("d-none");
        $(".otraestipulacion input").removeAttr("required", "required");
    }
}

function agregarregion() {
    var region = $("#zonaregion").val();
    var regiontext = $("#zonaregion option:selected").text();
    var regionid = $("#zonaregion option:selected").val();
    $(".resumenregion").append(
        '<div class="row region' +
        regionid +
        '"><div class="col-10"><p class="text-left">' +
        regiontext +
        '</p></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm" onclick="eliminarregion(' +
        regionid +
        ')"><i class="fas fa-trash"></i></button></div></div>'
    );
}

function formadepago() {
    var forma = $("#formapagot").val();
    if (forma == 4 || forma == 5) {
        $(".trans").removeClass("d-none");
        $(".trans input").attr("required", "required");
        $(".trans select").attr("required", "required");
    } else {
        $(".trans").addClass("d-none");
        $(".trans input").removeAttr("required", "required");
        $(".trans select").removeAttr("required", "required");
    }
}

function eliminarregion(id) {
    $(".region" + id).remove();
}

function agregarprovincia() {
    var provincia = $("#zonaprovincia").val();
    var provinciatext = $("#zonaprovincia option:selected").text();
    var provinciaid = $("#zonaprovincia option:selected").val();
    $(".resumenprovincia").append(
        '<div class="row provincia' +
        provinciaid +
        '"><div class="col-10"><p class="text-left">' +
        provinciatext +
        '</p></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm" onclick="eliminarprovincia(' +
        provinciaid +
        ')"><i class="fas fa-trash"></i></button></div></div>'
    );
}

function eliminarprovincia(id) {
    $(".provincia" + id).remove();
}

function agregarcomuna() {
    var comuna = $("#zonacomuna").val();
    var comunatext = $("#zonacomuna option:selected").text();
    var comunaid = $("#zonacomuna option:selected").val();
    $(".resumencomuna").append(
        '<div class="row comuna' +
        comunaid +
        '"><div class="col-10"><p class="text-left">' +
        comunatext +
        '</p></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm" onclick="eliminarcomuna(' +
        comunaid +
        ')"><i class="fas fa-trash"></i></button></div></div>'
    );
}

function eliminarcomuna(id) {
    $(".comuna" + id).remove();
}


function changetimeinit1() {
    var valu = $("#hora10").val();
    $(".hora1").val(valu);
}

function changetimeend1() {
    var valu = $("#horat10").val();
    $(".horat1").val(valu);
}

function changetimeinit2() {
    var valu = $("#hora20").val();
    $(".hora2").val(valu);
}

function changetimeend2() {
    var valu = $("#horat20").val();
    $(".horat2").val(valu);
}

function changetimeinit3() {
    var valu = $("#hora30").val();
    $(".hora3").val(valu);
}

function changetimeend3() {
    var valu = $("#horat30").val();
    $(".horat3").val(valu);
}

function changetimeinit4() {
    var valu = $("#hora40").val();
    $(".hora4").val(valu);
}

function changetimeend4() {
    var valu = $("#horat40").val();
    $(".horat4").val(valu);
}




//Finalizar proceso de creacion de contrato
function finalizar() {
    $("#global-loader").fadeIn("slow");
    //validar si todos los formularios estan completos
    //Capturar los datos del formulario Identificacion de las partes
    var categoria_contrato = $("#categoria_contrato").val();
    var regioncelebracion = $("#regioncelebracion").val();
    var comunacelebracion = $("#comunacelebracion").val();
    var fechacelebracion = $("#fechacelebracion").val();
    var tipocontratoid = $("#tipocontratoid").val();
    var nombre_razon_social = $("#nombre_razon_social").val();
    var rut_empleador = $("#rut_empleador").val();
    var representante_legal = $("#representante_legal").val();
    var correo_electronico = $("#correo_electronico").val();
    var telefono = $("#telefono").val();
    var codigoactividadid = $("#codigoactividadid").val();
    var domicilio = $("#domicilio").val();
    var empresaregion = $("#empresaregion").val();
    var empresacomuna = $("#empresacomuna").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var ruttrabajador = $("#ruttrabajador").val();
    var nombretrabajador = $("#nombretrabajador").val();
    var apellidos = $("#apellidos").val();
    var fechanacimiento = $("#fechanacimiento").val();
    var sexo = $("#sexo").val();
    var nacionalidad = $("#nacionalidad").val();
    var correotrabajador = $("#correotrabajador").val();
    var telefonotrabajador = $("#telefonotrabajador").val();
    var trabajadorregion = $("#trabajadorregion").val();
    var trabajadorcomuna = $("#trabajadorcomuna").val();
    var calletrabajador = $("#calletrabajador").val();
    var numerotrabajador = $("#numerotrabajador").val();
    var departamentotrabajador = $("#departamentotrabajador").val();

    //Capturar los datos del formulario Functoin y lugares de prestacion de los servicios
    var centrocosto = $("#centrocosto").val();
    var Charge = $("#Charge").val();
    var ChargeDescripcion = $("#ChargeDescripcion").val();
    var regionespecifica = $("#regionespecifica").val();
    var comunaespecifica = $("#comunaespecifica").val();
    var calleespecifica = $("#calleespecifica").val();
    var numeroespecifica = $("#numeroespecifica").val();
    var subcontratacionrut = $("#subcontratacionrut").val();
    var subcontratacionrazonsocial = $("#subcontratacionrazonsocial").val();
    var transitoriosrut = $("#transitoriosrut").val();
    var transitoriosrazonsocial = $("#transitoriosrazonsocial").val();

    //Capturar los datos del formulario Remuneraciones
    var tiposueldo = $("#tiposueldo").val();
    var sueldo = $("#sueldo").val();
    var formapago = $("#formapago").val();
    var periodopagogra = $("#periodopagogra").val();
    var detallerenumeraciongra = $("#detallerenumeraciongra").val();
    var periodopagot = $("#periodopagot").val();
    var fechapagot = $("#fechapagot").val();
    var formapagot = $("#formapagot").val();
    var anticipot = $("#anticipot").val();
    //var afp = $("#afp").val();
    //var salud = $("#salud").val();
    var otrter = $("#otrter").val();


    //Capturar los datos del formulario Jornada de trabajo y estipulaciones
    var noresolucion = $("#noresolucion").val();
    var exfecha = $("#exfech").val();
    var tipojornada = $("#tipojornada").val();
    var horaspactadas = $("#horaspactadas").val();
    var dias = $("#dias").val();
    var duracionjor = $("#duracionjor").val();
    var diasf = $("#diasf").val();
    var horarioturno = $("#horarioturno").val();
    var rotativo = $("#rotativo").val();
    var Horaspactadas = $("#Horaspactadas").val();
    var colacion = $("#colacion").val();
    var colaimpu = $("#colaimpu").val();
    var colacionimp = $("#colacionimp").val();
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_termino = $("#fecha_termino").val();
    var estipulacion13 = $("#estipulacion13").val();
    var juramento = $("#juramento").val();

    //Capturar datos Distribucion Jornada laboral General
    var lunes = 0;
    var lunesinicio = 0;
    var lunesfin = 0;
    var martes = 0;
    var martesinicio = 0;
    var martesfin = 0;
    var miercoles = 0;
    var miercolesinicio = 0;
    var miercolesfin = 0;
    var jueves = 0;
    var juevesinicio = 0;
    var juevesfin = 0;
    var viernes = 0;
    var viernesinicio = 0;
    var viernesfin = 0;
    var sabado = 0;
    var sabadoinicio = 0;
    var sabadofin = 0;
    var domingo = 0;
    var domingoinicio = 0;
    var domingofin = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todos").is(":checked") == true &&
        $("#dias17").prop("disabled") == false
    ) {
        lunes = 1;
        lunesinicio = $("#hora11").val();
        lunesfin = $("#horat11").val();
        martes = 1;
        martesinicio = $("#hora12").val();
        martesfin = $("#horat12").val();
        miercoles = 1;
        miercolesinicio = $("#hora13").val();
        miercolesfin = $("#horat13").val();
        jueves = 1;
        juevesinicio = $("#hora14").val();
        juevesfin = $("#horat14").val();
        viernes = 1;
        viernesinicio = $("#hora15").val();
        viernesfin = $("#horat15").val();
        sabado = 1;
        sabadoinicio = $("#hora16").val();
        sabadofin = $("#horat16").val();
        domingo = 1;
        domingoinicio = $("#hora17").val();
        domingofin = $("#horat17").val();
    } else {
        if ($("#dias11").is(":checked") == true) {
            lunes = 1;
            lunesinicio = $("#hora11").val();
            lunesfin = $("#horat11").val();
        }
        if ($("#dias12").is(":checked") == true) {
            martes = 1;
            martesinicio = $("#hora12").val();
            martesfin = $("#horat12").val();
        }
        if ($("#dias13").is(":checked") == true) {
            miercoles = 1;
            miercolesinicio = $("#hora13").val();
            miercolesfin = $("#horat13").val();
        }
        if ($("#dias14").is(":checked") == true) {
            jueves = 1;
            juevesinicio = $("#hora14").val();
            juevesfin = $("#horat14").val();
        }
        if ($("#dias15").is(":checked") == true) {
            viernes = 1;
            viernesinicio = $("#hora15").val();
            viernesfin = $("#horat15").val();
        }
        if ($("#dias16").is(":checked") == true) {
            sabado = 1;
            sabadoinicio = $("#hora16").val();
            sabadofin = $("#horat16").val();
        }
        if (
            $("#dias17").is(":checked") == true &&
            $("#dias17").prop("disabled") == false
        ) {
            domingo = 1;
            domingoinicio = $("#hora17").val();
            domingofin = $("#horat17").val();
        }
    }

    //Capturar datos Distribucion Jornada laboral Matutina
    var lunesm = 0;
    var lunesiniciom = 0;
    var lunesfinm = 0;
    var martesm = 0;
    var martesiniciom = 0;
    var martesfinm = 0;
    var miercolesm = 0;
    var miercolesiniciom = 0;
    var miercolesfinm = 0;
    var juevesm = 0;
    var juevesiniciom = 0;
    var juevesfinm = 0;
    var viernesm = 0;
    var viernesiniciom = 0;
    var viernesfinm = 0;
    var sabadom = 0;
    var sabadoiniciom = 0;
    var sabadofinm = 0;
    var domingom = 0;
    var domingoiniciom = 0;
    var domingofinm = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todo1").is(":checked") == true &&
        $("#dias27").prop("disabled") == false
    ) {
        lunesm = 1;
        lunesiniciom = $("#hora21").val();
        lunesfinm = $("#horat21").val();
        martesm = 1;
        martesiniciom = $("#hora22").val();
        martesfinm = $("#horat22").val();
        miercolesm = 1;
        miercolesiniciom = $("#hora23").val();
        miercolesfinm = $("#horat23").val();
        juevesm = 1;
        juevesiniciom = $("#hora24").val();
        juevesfinm = $("#horat24").val();
        viernesm = 1;
        viernesiniciom = $("#hora25").val();
        viernesfinm = $("#horat25").val();
        sabadom = 1;
        sabadoiniciom = $("#hora26").val();
        sabadofinm = $("#horat26").val();
        domingom = 1;
        domingoiniciom = $("#hora27").val();
        domingofinm = $("#horat27").val();
    } else {
        if ($("#dias21").is(":checked") == true) {
            lunesm = 1;
            lunesiniciom = $("#hora21").val();
            lunesfinm = $("#horat21").val();
        }
        if ($("#dias22").is(":checked") == true) {
            martesm = 1;
            martesiniciom = $("#hora22").val();
            martesfinm = $("#horat22").val();
        }
        if ($("#dias23").is(":checked") == true) {
            miercolesm = 1;
            miercolesiniciom = $("#hora23").val();
            miercolesfinm = $("#horat23").val();
        }
        if ($("#dias24").is(":checked") == true) {
            juevesm = 1;
            juevesiniciom = $("#hora24").val();
            juevesfinm = $("#horat24").val();
        }
        if ($("#dias25").is(":checked") == true) {
            viernesm = 1;
            viernesiniciom = $("#hora25").val();
            viernesfinm = $("#horat25").val();
        }
        if ($("#dias26").is(":checked") == true) {
            sabadom = 1;
            sabadoiniciom = $("#hora26").val();
            sabadofinm = $("#horat26").val();
        }
        if (
            $("#dias27").is(":checked") == true &&
            $("#dias27").prop("disabled") == false
        ) {
            domingom = 1;
            domingoiniciom = $("#hora27").val();
            domingofinm = $("#horat27").val();
        }
    }

    //Capturar datos Distribucion Jornada laboral Tarde
    var lunest = 0;
    var lunesiniciot = 0;
    var lunesfint = 0;
    var martest = 0;
    var martesiniciot = 0;
    var martesfint = 0;
    var miercolest = 0;
    var miercolesiniciot = 0;
    var miercolesfint = 0;
    var juevest = 0;
    var juevesiniciot = 0;
    var juevesfint = 0;
    var viernest = 0;
    var viernesiniciot = 0;
    var viernesfint = 0;
    var sabadot = 0;
    var sabadoiniciot = 0;
    var sabadofint = 0;
    var domingot = 0;
    var domingoiniciot = 0;
    var domingofint = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todo2").is(":checked") == true &&
        $("#dias37").prop("disabled") == false
    ) {
        lunest = 1;
        lunesiniciot = $("#hora31").val();
        lunesfint = $("#horat31").val();
        martest = 1;
        martesiniciot = $("#hora32").val();
        martesfint = $("#horat32").val();
        miercolest = 1;
        miercolesiniciot = $("#hora33").val();
        miercolesfint = $("#horat33").val();
        juevest = 1;
        juevesiniciot = $("#hora34").val();
        juevesfint = $("#horat34").val();
        viernest = 1;
        viernesiniciot = $("#hora35").val();
        viernesfint = $("#horat35").val();
        sabadot = 1;
        sabadoiniciot = $("#hora36").val();
        sabadofint = $("#horat36").val();
        domingot = 1;
        domingoiniciot = $("#hora37").val();
        domingofint = $("#horat37").val();
    } else {
        if ($("#dias31").is(":checked") == true) {
            lunest = 1;
            lunesiniciot = $("#hora31").val();
            lunesfint = $("#horat31").val();
        }
        if ($("#dias32").is(":checked") == true) {
            martest = 1;
            martesiniciot = $("#hora32").val();
            martesfint = $("#horat32").val();
        }
        if ($("#dias33").is(":checked") == true) {
            miercolest = 1;
            miercolesiniciot = $("#hora33").val();
            miercolesfint = $("#horat33").val();
        }
        if ($("#dias34").is(":checked") == true) {
            juevest = 1;
            juevesiniciot = $("#hora34").val();
            juevesfint = $("#horat34").val();
        }
        if ($("#dias35").is(":checked") == true) {
            viernest = 1;
            viernesiniciot = $("#hora35").val();
            viernesfint = $("#horat35").val();
        }
        if ($("#dias36").is(":checked") == true) {
            sabadot = 1;
            sabadoiniciot = $("#hora36").val();
            sabadofint = $("#horat36").val();
        }
        if (
            $("#dias37").is(":checked") == true &&
            $("#dias37").prop("disabled") == false
        ) {
            domingot = 1;
            domingoiniciot = $("#hora37").val();
            domingofint = $("#horat37").val();
        }
    }

    //Capturar datos Distribucion Jornada laboral Noche
    var lunesn = 0;
    var lunesinicion = 0;
    var lunesfinn = 0;
    var martesn = 0;
    var martesinicion = 0;
    var martesfinn = 0;
    var miercolesn = 0;
    var miercolesinicion = 0;
    var miercolesfinn = 0;
    var juevesn = 0;
    var juevesinicion = 0;
    var juevesfinn = 0;
    var viernesn = 0;
    var viernesinicion = 0;
    var viernesfinn = 0;
    var sabadon = 0;
    var sabadoinicion = 0;
    var sabadofinn = 0;
    var domingon = 0;
    var domingoinicion = 0;
    var domingofinn = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todo3").is(":checked") == true &&
        $("#dias47").prop("disabled") == false
    ) {
        lunesn = 1;
        lunesinicion = $("#hora41").val();
        lunesfinn = $("#horat41").val();
        martesn = 1;
        martesinicion = $("#hora42").val();
        martesfinn = $("#horat42").val();
        miercolesn = 1;
        miercolesinicion = $("#hora43").val();
        miercolesfinn = $("#horat43").val();
        juevesn = 1;
        juevesinicion = $("#hora44").val();
        juevesfinn = $("#horat44").val();
        viernesn = 1;
        viernesinicion = $("#hora45").val();
        viernesfinn = $("#horat45").val();
        sabadon = 1;
        sabadoinicion = $("#hora46").val();
        sabadofinn = $("#horat46").val();
        domingon = 1;
        domingoinicion = $("#hora47").val();
        domingofinn = $("#horat47").val();
    } else {
        if ($("#dias41").is(":checked") == true) {
            lunesn = 1;
            lunesinicion = $("#hora41").val();
            lunesfinn = $("#horat41").val();
        }
        if ($("#dias42").is(":checked") == true) {
            martesn = 1;
            martesinicion = $("#hora42").val();
            martesfinn = $("#horat42").val();
        }
        if ($("#dias43").is(":checked") == true) {
            miercolesn = 1;
            miercolesinicion = $("#hora43").val();
            miercolesfinn = $("#horat43").val();
        }
        if ($("#dias44").is(":checked") == true) {
            juevesn = 1;
            juevesinicion = $("#hora44").val();
            juevesfinn = $("#horat44").val();
        }
        if ($("#dias45").is(":checked") == true) {
            viernesn = 1;
            viernesinicion = $("#hora45").val();
            viernesfinn = $("#horat45").val();
        }
        if ($("#dias46").is(":checked") == true) {
            sabadon = 1;
            sabadoinicion = $("#hora46").val();
            sabadofinn = $("#horat46").val();
        }
        if (
            $("#dias47").is(":checked") == true &&
            $("#dias47").prop("disabled") == false
        ) {
            domingon = 1;
            domingoinicion = $("#hora47").val();
            domingofinn = $("#horat47").val();
        }
    }

    var territoriozona = $("#territoriozona").val();

    //Lugar, Fecha y Plazo del Contrato
    var tipocontrato1 = 0;
    //validar si que radio button de tipo de contrato esta Seleccionado
    if ($("#tipocontrato1").is(":selected") == true) {
        tipocontrato1 = 1;
    } else if ($("#tipocontrato2").is(":selected") == true) {
        tipocontrato1 = 2;
    } else if ($("#tipocontrato3").is(":selected") == true) {
        tipocontrato1 = 3;
    }

    var badi = 0;
    //validar si que radio button de badi esta Seleccionado
    if ($("#badi1").is(":selected") == true) {
        badi = 1;
    }
    var otrter = $("#otrter").val();
    //Estipulaciones
    //Declarar estipulacion del 1 al 13
    var estipulacion1 = 0;
    var estipulacion2 = 0;
    var estipulacion3 = 0;
    var estipulacion4 = 0;
    var estipulacion5 = 0;
    var estipulacion6 = 0;
    var estipulacion7 = 0;
    var estipulacion8 = 0;
    var estipulacion9 = 0;
    var estipulacion10 = 0;
    var estipulacion11 = 0;
    var estipulacion12 = 0;
    var estipulacion13 = 0;
    //validar si que checkbox de estipulacion esta Seleccionado
    if ($("#estipulacion1").is(":checked") == true) {
        estipulacion1 = $("#estipulacion1").val();
    }
    if ($("#estipulacion2").is(":checked") == true) {
        estipulacion2 = $("#estipulacion2").val();
    }
    if ($("#estipulacion3").is(":checked") == true) {
        estipulacion3 = $("#estipulacion3").val();
    }
    if ($("#estipulacion4").is(":checked") == true) {
        estipulacion4 = $("#estipulacion4").val();
    }
    if ($("#estipulacion5").is(":checked") == true) {
        estipulacion5 = $("#estipulacion5").val();
    }
    if ($("#estipulacion6").is(":checked") == true) {
        estipulacion6 = $("#estipulacion6").val();
    }
    if ($("#estipulacion7").is(":checked") == true) {
        estipulacion7 = $("#estipulacion7").val();
    }
    if ($("#estipulacion8").is(":checked") == true) {
        estipulacion8 = $("#estipulacion8").val();
    }
    if ($("#estipulacion9").is(":checked") == true) {
        estipulacion9 = $("#estipulacion9").val();
    }
    if ($("#estipulacion10").is(":checked") == true) {
        estipulacion10 = $("#estipulacion10").val();
    }
    if ($("#estipulacion11").is(":checked") == true) {
        estipulacion11 = $("#estipulacion11").val();
    }
    if ($("#estipulacion12").is(":checked") == true) {
        estipulacion12 = 1;
        estipulacion13 = $("#estipulacion13").val();
    }
    var idempresa = $("#idempresa").val();

    var exluido = 0;
    if ($("#exluido").is(":checked") == true) {
        exluido = 1;
    }


    var typecontract = 0;
    if ($("#tipo_contrato1").is(":checked") == true) {
        typecontract = 1;
    } else if ($("#tipo_contrato2").is(":checked") == true) {
        typecontract = 2;
    } else if ($("#tipo_contrato3").is(":checked") == true) {
        typecontract = 3;
    }

    var jornadaesc = $("#jornadaesc").val();

    //validar juramento
    if ($("#juramento").is(":checked")) {
        $.ajax({
            url: "php/pdf/generarcontratomasivo.php",
            type: "POST",
            data: {
                categoria_contrato: categoria_contrato,
                regioncelebracion: regioncelebracion,
                comunacelebracion: comunacelebracion,
                fechacelebracion: fechacelebracion,
                tipocontratoid: tipocontratoid,
                idempresa: idempresa,
                representante_legal: representante_legal,
                codigoactividadid: codigoactividadid,
                empresaregion: empresaregion,
                empresacomuna: empresacomuna,
                calle: calle,
                numero: numero,
                jornadaesc: jornadaesc,
                centrocosto: centrocosto,
                Charge: Charge,
                ChargeDescripcion: ChargeDescripcion,
                regionespecifica: regionespecifica,
                comunaespecifica: comunaespecifica,
                calleespecifica: calleespecifica,
                numeroespecifica: numeroespecifica,
                territoriozona: territoriozona,
                subcontratacionrut: subcontratacionrut,
                subcontratacionrazonsocial: subcontratacionrazonsocial,
                transitoriosrut: transitoriosrut,
                transitoriosrazonsocial: transitoriosrazonsocial,
                tiposueldo: tiposueldo,
                sueldo: sueldo,
                formapago: formapago,
                periodopagogra: periodopagogra,
                detallerenumeraciongra: detallerenumeraciongra,
                periodopagot: periodopagot,
                fechapagot: fechapagot,
                formapagot: formapagot,
                badi: badi,
                otrter: otrter,
                anticipot: anticipot,
                noresolucion: noresolucion,
                exfecha: exfecha,
                exluido: exluido,
                tipojornada: tipojornada,
                horaspactadas: horaspactadas,
                horarioturno: horarioturno,
                dias: dias,
                colacion: colacion,
                colacionimp: colacionimp,
                fecha_inicio: fecha_inicio,
                fecha_termino: fecha_termino,
                estipulacion1: estipulacion1,
                estipulacion2: estipulacion2,
                estipulacion3: estipulacion3,
                estipulacion4: estipulacion4,
                estipulacion5: estipulacion5,
                estipulacion6: estipulacion6,
                estipulacion7: estipulacion7,
                estipulacion8: estipulacion8,
                estipulacion9: estipulacion9,
                estipulacion10: estipulacion10,
                estipulacion11: estipulacion11,
                estipulacion12: estipulacion12,
                estipulacion13: estipulacion13,
                lunes: lunes,
                lunesinicio: lunesinicio,
                lunesfin: lunesfin,
                territoriozona: territoriozona,
                martes: martes,
                martesinicio: martesinicio,
                martesfin: martesfin,
                miercoles: miercoles,
                miercolesinicio: miercolesinicio,
                miercolesfin: miercolesfin,
                jueves: jueves,
                juevesinicio: juevesinicio,
                juevesfin: juevesfin,
                viernes: viernes,
                viernesinicio: viernesinicio,
                viernesfin: viernesfin,
                sabado: sabado,
                sabadoinicio: sabadoinicio,
                sabadofin: sabadofin,
                domingo: domingo,
                domingoinicio: domingoinicio,
                domingofin: domingofin,
                lunesm: lunesm,
                lunesminicio: lunesiniciom,
                lunesmfin: lunesfinm,
                martesm: martesm,
                martesminicio: martesiniciom,
                martesmfin: martesfinm,
                miercolesm: miercolesm,
                miercolesminicio: miercolesiniciom,
                miercolesmfin: miercolesfinm,
                juevesm: juevesm,
                juevesminicio: juevesiniciom,
                juevesmfin: juevesfinm,
                viernesm: viernesm,
                viernesminicio: viernesiniciom,
                viernesmfin: viernesfinm,
                sabadom: sabadom,
                sabadominicio: sabadoiniciom,
                sabadomfin: sabadofinm,
                domingom: domingom,
                domingominicio: domingoiniciom,
                domingomfin: domingofinm,
                lunest: lunest,
                lunestinicio: lunesiniciot,
                lunestfin: lunesfint,
                martest: martest,
                martestinicio: martesiniciot,
                martestfin: martesfint,
                miercolest: miercolest,
                miercolestinicio: miercolesiniciot,
                miercolestfin: miercolesfint,
                juevest: juevest,
                juevestinicio: juevesiniciot,
                juevestfin: juevesfint,
                viernest: viernest,
                viernestinicio: viernesiniciot,
                viernestfin: viernesfint,
                sabadot: sabadot,
                sabadotinicio: sabadoiniciot,
                sabadotfin: sabadofint,
                domingot: domingot,
                domingotinicio: domingoiniciot,
                domingotfin: domingofint,
                lunesn: lunesn,
                lunesninicio: lunesinicion,
                lunesnfin: lunesfinn,
                martesn: martesn,
                martesninicio: martesinicion,
                martesnfin: martesfinn,
                miercolesn: miercolesn,
                miercolesninicio: miercolesinicion,
                miercolesnfin: miercolesfinn,
                juevesn: juevesn,
                juevesninicio: juevesinicion,
                juevesnfin: juevesfinn,
                viernesn: viernesn,
                viernesninicio: viernesinicion,
                viernesnfin: viernesfinn,
                sabadon: sabadon,
                sabadoninicio: sabadoinicion,
                sabadonfin: sabadofinn,
                domingon: domingon,
                domingoninicio: domingoinicion,
                domingonfin: domingofinn,
                typecontract: typecontract,
                duracionjor: duracionjor,
                diasf: diasf,
                horarioturno: horarioturno,
                rotativo: rotativo,
                horaspactadas: horaspactadas,
                colaimpu: colaimpu
            },
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                //Sacar el primer caracter del texto
                var first = data.substring(0, 1);
                var url = data.substring(1);
                console.log(data);
                console.log(first);
                console.log(url);
                //Si el primer caracter es un numero
                    if (first == 1 || first == "1") {
                        //Sacar la URL del texto sin el primer caracter
                        var url = data.substring(1);
                        //Mostrar vista previa en un modal e abrir el modal
                        $("#vistaprevia").attr("src", url);
                        $(".edit").attr("onclick", "editarinfo('" + url + "')");
                        $(".generar").attr("onclick", "generar('" + url + "')");
                        $("#modalvistaprevia").modal("show");
                        //Mostrar vista previa en un modal e abrir el modal
                        //Agregar la URL
                        
                    }else{
                        ToastifyError(data);
                    }
                
            },
        });
    }
}

function generar(valor) {
    $("#global-loader").fadeIn("slow");
    //validar si todos los formularios estan completos
    //Capturar los datos del formulario Identificacion de las partes
    var categoria_contrato = $("#categoria_contrato").val();
    var regioncelebracion = $("#regioncelebracion").val();
    var comunacelebracion = $("#comunacelebracion").val();
    var fechacelebracion = $("#fechacelebracion").val();
    var tipocontratoid = $("#tipocontratoid").val();
    var representante_legal = $("#representante_legal").val();
    var codigoactividadid = $("#codigoactividadid").val();
    var empresaregion = $("#empresaregion").val();
    var empresacomuna = $("#empresacomuna").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();

    //Capturar los datos del formulario Functoin y lugares de prestacion de los servicios
    var centrocosto = $("#centrocosto").val();
    var Charge = $("#Charge").val();
    var ChargeDescripcion = $("#ChargeDescripcion").val();
    var regionespecifica = $("#regionespecifica").val();
    var comunaespecifica = $("#comunaespecifica").val();
    var calleespecifica = $("#calleespecifica").val();
    var numeroespecifica = $("#numeroespecifica").val();
    var subcontratacionrut = $("#subcontratacionrut").val();
    var subcontratacionrazonsocial = $("#subcontratacionrazonsocial").val();
    var transitoriosrut = $("#transitoriosrut").val();
    var transitoriosrazonsocial = $("#transitoriosrazonsocial").val();

    //Capturar los datos del formulario Remuneraciones
    var tiposueldo = $("#tiposueldo").val();
    var sueldo = $("#sueldo").val();
    var formapago = $("#formapago").val();
    var periodopagogra = $("#periodopagogra").val();
    var detallerenumeraciongra = $("#detallerenumeraciongra").val();
    var periodopagot = $("#periodopagot").val();
    var fechapagot = $("#fechapagot").val();
    var formapagot = $("#formapagot").val();
    var anticipot = $("#anticipot").val();
    var otrter = $("#otrter").val();


    //Capturar los datos del formulario Jornada de trabajo y estipulaciones
    var noresolucion = $("#noresolucion").val();
    var exfecha = $("#exfech").val();
    var tipojornada = $("#tipojornada").val();
    var horaspactadas = $("#horaspactadas").val();
    var dias = $("#dias").val();
    var duracionjor = $("#duracionjor").val();
    var diasf = $("#diasf").val();
    var horarioturno = $("#horarioturno").val();
    var rotativo = $("#rotativo").val();
    var Horaspactadas = $("#Horaspactadas").val();
    var colacion = $("#colacion").val();
    var colaimpu = $("#colaimpu").val();
    var colacionimp = $("#colacionimp").val();
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_termino = $("#fecha_termino").val();
    var estipulacion13 = $("#estipulacion13").val();
    var juramento = $("#juramento").val();
    //Capturar datos Distribucion Jornada laboral General
    var lunes = 0;
    var lunesinicio = 0;
    var lunesfin = 0;
    var martes = 0;
    var martesinicio = 0;
    var martesfin = 0;
    var miercoles = 0;
    var miercolesinicio = 0;
    var miercolesfin = 0;
    var jueves = 0;
    var juevesinicio = 0;
    var juevesfin = 0;
    var viernes = 0;
    var viernesinicio = 0;
    var viernesfin = 0;
    var sabado = 0;
    var sabadoinicio = 0;
    var sabadofin = 0;
    var domingo = 0;
    var domingoinicio = 0;
    var domingofin = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todos").is(":checked") == true &&
        $("#dias17").prop("disabled") == false
    ) {
        lunes = 1;
        lunesinicio = $("#hora11").val();
        lunesfin = $("#horat11").val();
        martes = 1;
        martesinicio = $("#hora12").val();
        martesfin = $("#horat12").val();
        miercoles = 1;
        miercolesinicio = $("#hora13").val();
        miercolesfin = $("#horat13").val();
        jueves = 1;
        juevesinicio = $("#hora14").val();
        juevesfin = $("#horat14").val();
        viernes = 1;
        viernesinicio = $("#hora15").val();
        viernesfin = $("#horat15").val();
        sabado = 1;
        sabadoinicio = $("#hora16").val();
        sabadofin = $("#horat16").val();
        domingo = 1;
        domingoinicio = $("#hora17").val();
        domingofin = $("#horat17").val();
    } else {
        if ($("#dias11").is(":checked") == true) {
            lunes = 1;
            lunesinicio = $("#hora11").val();
            lunesfin = $("#horat11").val();
        }
        if ($("#dias12").is(":checked") == true) {
            martes = 1;
            martesinicio = $("#hora12").val();
            martesfin = $("#horat12").val();
        }
        if ($("#dias13").is(":checked") == true) {
            miercoles = 1;
            miercolesinicio = $("#hora13").val();
            miercolesfin = $("#horat13").val();
        }
        if ($("#dias14").is(":checked") == true) {
            jueves = 1;
            juevesinicio = $("#hora14").val();
            juevesfin = $("#horat14").val();
        }
        if ($("#dias15").is(":checked") == true) {
            viernes = 1;
            viernesinicio = $("#hora15").val();
            viernesfin = $("#horat15").val();
        }
        if ($("#dias16").is(":checked") == true) {
            sabado = 1;
            sabadoinicio = $("#hora16").val();
            sabadofin = $("#horat16").val();
        }
        if (
            $("#dias17").is(":checked") == true &&
            $("#dias17").prop("disabled") == false
        ) {
            domingo = 1;
            domingoinicio = $("#hora17").val();
            domingofin = $("#horat17").val();
        }
    }

    //Capturar datos Distribucion Jornada laboral Matutina
    var lunesm = 0;
    var lunesiniciom = 0;
    var lunesfinm = 0;
    var martesm = 0;
    var martesiniciom = 0;
    var martesfinm = 0;
    var miercolesm = 0;
    var miercolesiniciom = 0;
    var miercolesfinm = 0;
    var juevesm = 0;
    var juevesiniciom = 0;
    var juevesfinm = 0;
    var viernesm = 0;
    var viernesiniciom = 0;
    var viernesfinm = 0;
    var sabadom = 0;
    var sabadoiniciom = 0;
    var sabadofinm = 0;
    var domingom = 0;
    var domingoiniciom = 0;
    var domingofinm = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todo1").is(":checked") == true &&
        $("#dias27").prop("disabled") == false
    ) {
        lunesm = 1;
        lunesiniciom = $("#hora21").val();
        lunesfinm = $("#horat21").val();
        martesm = 1;
        martesiniciom = $("#hora22").val();
        martesfinm = $("#horat22").val();
        miercolesm = 1;
        miercolesiniciom = $("#hora23").val();
        miercolesfinm = $("#horat23").val();
        juevesm = 1;
        juevesiniciom = $("#hora24").val();
        juevesfinm = $("#horat24").val();
        viernesm = 1;
        viernesiniciom = $("#hora25").val();
        viernesfinm = $("#horat25").val();
        sabadom = 1;
        sabadoiniciom = $("#hora26").val();
        sabadofinm = $("#horat26").val();
        domingom = 1;
        domingoiniciom = $("#hora27").val();
        domingofinm = $("#horat27").val();
    } else {
        if ($("#dias21").is(":checked") == true) {
            lunesm = 1;
            lunesiniciom = $("#hora21").val();
            lunesfinm = $("#horat21").val();
        }
        if ($("#dias22").is(":checked") == true) {
            martesm = 1;
            martesiniciom = $("#hora22").val();
            martesfinm = $("#horat22").val();
        }
        if ($("#dias23").is(":checked") == true) {
            miercolesm = 1;
            miercolesiniciom = $("#hora23").val();
            miercolesfinm = $("#horat23").val();
        }
        if ($("#dias24").is(":checked") == true) {
            juevesm = 1;
            juevesiniciom = $("#hora24").val();
            juevesfinm = $("#horat24").val();
        }
        if ($("#dias25").is(":checked") == true) {
            viernesm = 1;
            viernesiniciom = $("#hora25").val();
            viernesfinm = $("#horat25").val();
        }
        if ($("#dias26").is(":checked") == true) {
            sabadom = 1;
            sabadoiniciom = $("#hora26").val();
            sabadofinm = $("#horat26").val();
        }
        if (
            $("#dias27").is(":checked") == true &&
            $("#dias27").prop("disabled") == false
        ) {
            domingom = 1;
            domingoiniciom = $("#hora27").val();
            domingofinm = $("#horat27").val();
        }
    }

    //Capturar datos Distribucion Jornada laboral Tarde
    var lunest = 0;
    var lunesiniciot = 0;
    var lunesfint = 0;
    var martest = 0;
    var martesiniciot = 0;
    var martesfint = 0;
    var miercolest = 0;
    var miercolesiniciot = 0;
    var miercolesfint = 0;
    var juevest = 0;
    var juevesiniciot = 0;
    var juevesfint = 0;
    var viernest = 0;
    var viernesiniciot = 0;
    var viernesfint = 0;
    var sabadot = 0;
    var sabadoiniciot = 0;
    var sabadofint = 0;
    var domingot = 0;
    var domingoiniciot = 0;
    var domingofint = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todo2").is(":checked") == true &&
        $("#dias37").prop("disabled") == false
    ) {
        lunest = 1;
        lunesiniciot = $("#hora31").val();
        lunesfint = $("#horat31").val();
        martest = 1;
        martesiniciot = $("#hora32").val();
        martesfint = $("#horat32").val();
        miercolest = 1;
        miercolesiniciot = $("#hora33").val();
        miercolesfint = $("#horat33").val();
        juevest = 1;
        juevesiniciot = $("#hora34").val();
        juevesfint = $("#horat34").val();
        viernest = 1;
        viernesiniciot = $("#hora35").val();
        viernesfint = $("#horat35").val();
        sabadot = 1;
        sabadoiniciot = $("#hora36").val();
        sabadofint = $("#horat36").val();
        domingot = 1;
        domingoiniciot = $("#hora37").val();
        domingofint = $("#horat37").val();
    } else {
        if ($("#dias31").is(":checked") == true) {
            lunest = 1;
            lunesiniciot = $("#hora31").val();
            lunesfint = $("#horat31").val();
        }
        if ($("#dias32").is(":checked") == true) {
            martest = 1;
            martesiniciot = $("#hora32").val();
            martesfint = $("#horat32").val();
        }
        if ($("#dias33").is(":checked") == true) {
            miercolest = 1;
            miercolesiniciot = $("#hora33").val();
            miercolesfint = $("#horat33").val();
        }
        if ($("#dias34").is(":checked") == true) {
            juevest = 1;
            juevesiniciot = $("#hora34").val();
            juevesfint = $("#horat34").val();
        }
        if ($("#dias35").is(":checked") == true) {
            viernest = 1;
            viernesiniciot = $("#hora35").val();
            viernesfint = $("#horat35").val();
        }
        if ($("#dias36").is(":checked") == true) {
            sabadot = 1;
            sabadoiniciot = $("#hora36").val();
            sabadofint = $("#horat36").val();
        }
        if (
            $("#dias37").is(":checked") == true &&
            $("#dias37").prop("disabled") == false
        ) {
            domingot = 1;
            domingoiniciot = $("#hora37").val();
            domingofint = $("#horat37").val();
        }
    }

    //Capturar datos Distribucion Jornada laboral Noche
    var lunesn = 0;
    var lunesinicion = 0;
    var lunesfinn = 0;
    var martesn = 0;
    var martesinicion = 0;
    var martesfinn = 0;
    var miercolesn = 0;
    var miercolesinicion = 0;
    var miercolesfinn = 0;
    var juevesn = 0;
    var juevesinicion = 0;
    var juevesfinn = 0;
    var viernesn = 0;
    var viernesinicion = 0;
    var viernesfinn = 0;
    var sabadon = 0;
    var sabadoinicion = 0;
    var sabadofinn = 0;
    var domingon = 0;
    var domingoinicion = 0;
    var domingofinn = 0;
    //validar los dias seleccionado y si el domingo esta habilitado
    if (
        $("#todo3").is(":checked") == true &&
        $("#dias47").prop("disabled") == false
    ) {
        lunesn = 1;
        lunesinicion = $("#hora41").val();
        lunesfinn = $("#horat41").val();
        martesn = 1;
        martesinicion = $("#hora42").val();
        martesfinn = $("#horat42").val();
        miercolesn = 1;
        miercolesinicion = $("#hora43").val();
        miercolesfinn = $("#horat43").val();
        juevesn = 1;
        juevesinicion = $("#hora44").val();
        juevesfinn = $("#horat44").val();
        viernesn = 1;
        viernesinicion = $("#hora45").val();
        viernesfinn = $("#horat45").val();
        sabadon = 1;
        sabadoinicion = $("#hora46").val();
        sabadofinn = $("#horat46").val();
        domingon = 1;
        domingoinicion = $("#hora47").val();
        domingofinn = $("#horat47").val();
    } else {
        if ($("#dias41").is(":checked") == true) {
            lunesn = 1;
            lunesinicion = $("#hora41").val();
            lunesfinn = $("#horat41").val();
        }
        if ($("#dias42").is(":checked") == true) {
            martesn = 1;
            martesinicion = $("#hora42").val();
            martesfinn = $("#horat42").val();
        }
        if ($("#dias43").is(":checked") == true) {
            miercolesn = 1;
            miercolesinicion = $("#hora43").val();
            miercolesfinn = $("#horat43").val();
        }
        if ($("#dias44").is(":checked") == true) {
            juevesn = 1;
            juevesinicion = $("#hora44").val();
            juevesfinn = $("#horat44").val();
        }
        if ($("#dias45").is(":checked") == true) {
            viernesn = 1;
            viernesinicion = $("#hora45").val();
            viernesfinn = $("#horat45").val();
        }
        if ($("#dias46").is(":checked") == true) {
            sabadon = 1;
            sabadoinicion = $("#hora46").val();
            sabadofinn = $("#horat46").val();
        }
        if (
            $("#dias47").is(":checked") == true &&
            $("#dias47").prop("disabled") == false
        ) {
            domingon = 1;
            domingoinicion = $("#hora47").val();
            domingofinn = $("#horat47").val();
        }
    }

    var territoriozona = $("#territoriozona").val();

    //Lugar, Fecha y Plazo del Contrato
    var tipocontrato1 = 0;
    //validar si que radio button de tipo de contrato esta Seleccionado
    if ($("#tipocontrato1").is(":selected") == true) {
        tipocontrato1 = 1;
    } else if ($("#tipocontrato2").is(":selected") == true) {
        tipocontrato1 = 2;
    } else if ($("#tipocontrato3").is(":selected") == true) {
        tipocontrato1 = 3;
    }

    var badi = 0;
    //validar si que radio button de badi esta Seleccionado
    if ($("#badi1").is(":selected") == true) {
        badi = 1;
    }
    var otrter = $("#otrter").val();
    //Estipulaciones
    //Declarar estipulacion del 1 al 13
    var estipulacion1 = 0;
    var estipulacion2 = 0;
    var estipulacion3 = 0;
    var estipulacion4 = 0;
    var estipulacion5 = 0;
    var estipulacion6 = 0;
    var estipulacion7 = 0;
    var estipulacion8 = 0;
    var estipulacion9 = 0;
    var estipulacion10 = 0;
    var estipulacion11 = 0;
    var estipulacion12 = 0;
    var estipulacion13 = 0;
    //validar si que checkbox de estipulacion esta Seleccionado
    if ($("#estipulacion1").is(":checked") == true) {
        estipulacion1 = $("#estipulacion1").val();
    }
    if ($("#estipulacion2").is(":checked") == true) {
        estipulacion2 = $("#estipulacion2").val();
    }
    if ($("#estipulacion3").is(":checked") == true) {
        estipulacion3 = $("#estipulacion3").val();
    }
    if ($("#estipulacion4").is(":checked") == true) {
        estipulacion4 = $("#estipulacion4").val();
    }
    if ($("#estipulacion5").is(":checked") == true) {
        estipulacion5 = $("#estipulacion5").val();
    }
    if ($("#estipulacion6").is(":checked") == true) {
        estipulacion6 = $("#estipulacion6").val();
    }
    if ($("#estipulacion7").is(":checked") == true) {
        estipulacion7 = $("#estipulacion7").val();
    }
    if ($("#estipulacion8").is(":checked") == true) {
        estipulacion8 = $("#estipulacion8").val();
    }
    if ($("#estipulacion9").is(":checked") == true) {
        estipulacion9 = $("#estipulacion9").val();
    }
    if ($("#estipulacion10").is(":checked") == true) {
        estipulacion10 = $("#estipulacion10").val();
    }
    if ($("#estipulacion11").is(":checked") == true) {
        estipulacion11 = $("#estipulacion11").val();
    }
    if ($("#estipulacion12").is(":checked") == true) {
        estipulacion12 = 1;
        estipulacion13 = $("#estipulacion13").val();
    }
    var idempresa = $("#idempresa").val();
    var idtrabajador = $("#idtrabajador").val();

    var exluido = 0;
    if ($("#exluido").is(":checked") == true) {
        exluido = 1;
    }


    var typecontract = 0;
    if ($("#tipo_contrato1").is(":checked") == true) {
        typecontract = 1;
    } else if ($("#tipo_contrato2").is(":checked") == true) {
        typecontract = 2;
    } else if ($("#tipo_contrato3").is(":checked") == true) {
        typecontract = 3;
    }

    var jornadaesc = $("#jornadaesc").val();

    //validar juramento
    if ($("#juramento").is(":checked")) {
        $.ajax({
            url: "php/pdf/generarcontratomasivo1.php",
            type: "POST",
            data: {
                categoria_contrato: categoria_contrato,
                regioncelebracion: regioncelebracion,
                comunacelebracion: comunacelebracion,
                fechacelebracion: fechacelebracion,
                tipocontratoid: tipocontratoid,
                idempresa: idempresa,
                representante_legal: representante_legal,
                codigoactividadid: codigoactividadid,
                empresaregion: empresaregion,
                empresacomuna: empresacomuna,
                calle: calle,
                numero: numero,
                centrocosto: centrocosto,
                Charge: Charge,
                jornadaesc: jornadaesc,
                ChargeDescripcion: ChargeDescripcion,
                regionespecifica: regionespecifica,
                comunaespecifica: comunaespecifica,
                calleespecifica: calleespecifica,
                numeroespecifica: numeroespecifica,
                territoriozona: territoriozona,
                subcontratacionrut: subcontratacionrut,
                subcontratacionrazonsocial: subcontratacionrazonsocial,
                transitoriosrut: transitoriosrut,
                transitoriosrazonsocial: transitoriosrazonsocial,
                tiposueldo: tiposueldo,
                sueldo: sueldo,
                territoriozona: territoriozona,
                formapago: formapago,
                periodopagogra: periodopagogra,
                detallerenumeraciongra: detallerenumeraciongra,
                periodopagot: periodopagot,
                fechapagot: fechapagot,
                formapagot: formapagot,
                badi: badi,
                otrter: otrter,
                anticipot: anticipot,
                noresolucion: noresolucion,
                exfecha: exfecha,
                exluido: exluido,
                tipojornada: tipojornada,
                horaspactadas: horaspactadas,
                horarioturno: horarioturno,
                dias: dias,
                colacion: colacion,
                colacionimp: colacionimp,
                fecha_inicio: fecha_inicio,
                fecha_termino: fecha_termino,
                estipulacion1: estipulacion1,
                estipulacion2: estipulacion2,
                estipulacion3: estipulacion3,
                estipulacion4: estipulacion4,
                estipulacion5: estipulacion5,
                estipulacion6: estipulacion6,
                estipulacion7: estipulacion7,
                estipulacion8: estipulacion8,
                estipulacion9: estipulacion9,
                estipulacion10: estipulacion10,
                estipulacion11: estipulacion11,
                estipulacion12: estipulacion12,
                estipulacion13: estipulacion13,
                lunes: lunes,
                lunesinicio: lunesinicio,
                lunesfin: lunesfin,
                martes: martes,
                martesinicio: martesinicio,
                martesfin: martesfin,
                miercoles: miercoles,
                miercolesinicio: miercolesinicio,
                miercolesfin: miercolesfin,
                jueves: jueves,
                juevesinicio: juevesinicio,
                juevesfin: juevesfin,
                viernes: viernes,
                viernesinicio: viernesinicio,
                viernesfin: viernesfin,
                sabado: sabado,
                sabadoinicio: sabadoinicio,
                sabadofin: sabadofin,
                domingo: domingo,
                domingoinicio: domingoinicio,
                domingofin: domingofin,
                lunesm: lunesm,
                lunesminicio: lunesiniciom,
                lunesmfin: lunesfinm,
                martesm: martesm,
                martesminicio: martesiniciom,
                martesmfin: martesfinm,
                miercolesm: miercolesm,
                miercolesminicio: miercolesiniciom,
                miercolesmfin: miercolesfinm,
                juevesm: juevesm,
                juevesminicio: juevesiniciom,
                juevesmfin: juevesfinm,
                viernesm: viernesm,
                viernesminicio: viernesiniciom,
                viernesmfin: viernesfinm,
                sabadom: sabadom,
                sabadominicio: sabadoiniciom,
                sabadomfin: sabadofinm,
                domingom: domingom,
                domingominicio: domingoiniciom,
                domingomfin: domingofinm,
                lunest: lunest,
                lunestinicio: lunesiniciot,
                lunestfin: lunesfint,
                martest: martest,
                martestinicio: martesiniciot,
                martestfin: martesfint,
                miercolest: miercolest,
                miercolestinicio: miercolesiniciot,
                miercolestfin: miercolesfint,
                juevest: juevest,
                juevestinicio: juevesiniciot,
                juevestfin: juevesfint,
                viernest: viernest,
                viernestinicio: viernesiniciot,
                viernestfin: viernesfint,
                sabadot: sabadot,
                sabadotinicio: sabadoiniciot,
                sabadotfin: sabadofint,
                domingot: domingot,
                domingotinicio: domingoiniciot,
                domingotfin: domingofint,
                lunesn: lunesn,
                lunesninicio: lunesinicion,
                lunesnfin: lunesfinn,
                martesn: martesn,
                martesninicio: martesinicion,
                martesnfin: martesfinn,
                miercolesn: miercolesn,
                miercolesninicio: miercolesinicion,
                miercolesnfin: miercolesfinn,
                juevesn: juevesn,
                juevesninicio: juevesinicion,
                juevesnfin: juevesfinn,
                viernesn: viernesn,
                viernesninicio: viernesinicion,
                viernesnfin: viernesfinn,
                sabadon: sabadon,
                sabadoninicio: sabadoinicion,
                sabadonfin: sabadofinn,
                domingon: domingon,
                domingoninicio: domingoinicion,
                domingonfin: domingofinn,
                typecontract: typecontract,
                duracionjor: duracionjor,
                diasf: diasf,
                horarioturno: horarioturno,
                rotativo: rotativo,
                horaspactadas: horaspactadas,
                colaimpu: colaimpu,
                previa: valor
            },
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1 || data == "1") {
                    ToastifySuccess("Contratos Registrados Con Exito");
                    setTimeout(function () {
                        window.location.href = "generarlote.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al registrar contrato");
                }
            },
        });
    }
}

//Agregar region
function agregarregion(valor) {
    var region = $("#zonaregion").val();
    var trabajador = valor;
    if (region == 0) {
        ToastifyError("Seleccione una region");
        return;
    }
    $.ajax({
        type: "POST",
        url: "php/insert/agregarregion.php",
        data: { region: region, trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Region agregada");
                actualizardatos(trabajador);
            } else if (data == 2 || data == "2") {
                ToastifySuccess("Region ya agregada");
            } else {
                ToastifyError("No se pudo agregar la region");
            }
        },
    });
}

//Todas las regiones
function todaslasregiones(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/insert/todasregiones.php",
        data: { trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Region agregada");
                actualizardatos(trabajador);
            } else {
                ToastifyError("No se pudo agregar la region");
            }
        }
    });
}

//Agregar provincia
function agregarprovincia(valor) {
    var provincia = $("#zonaprovincia").val();
    var trabajador = valor;
    if (provincia == 0) {
        ToastifyError("Seleccione una provincia");
        return;
    }
    $.ajax({
        type: "POST",
        url: "php/insert/agregarprovincia.php",
        data: { provincia: provincia, trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Provincia agregada");
                actualizardatos(trabajador);
            } else if (data == 2 || data == "2") {
                ToastifySuccess("Provincia ya agregada");
            } else {
                ToastifyError("No se pudo agregar la provincia");
            }
        },
    });
}

//Todas las provincias
function todaslasprovincias(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/insert/todasprovincias.php",
        data: { trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Provincia agregada");
                actualizardatos(trabajador);
            } else {
                ToastifyError("No se pudo agregar la provincia");
            }
        }
    });
}

//Agregar comuna
function agregarcomuna(valor) {
    var comuna = $("#zonacomuna").val();
    var trabajador = valor;
    if (comuna == 0) {
        ToastifyError("Seleccione una comuna");
        return;
    }
    $.ajax({
        type: "POST",
        url: "php/insert/agregarcomuna.php",
        data: { comuna: comuna, trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Comuna agregada");
                actualizardatos(trabajador);
            } else if (data == 2 || data == "2") {
                ToastifyWarning("Comuna ya agregada");
            } else {
                ToastifyError("No se pudo agregar la comuna");
            }
        },
    });
}

//Todas las comunas
function todaslascomunas(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/insert/todascomunas.php",
        data: { trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Comuna agregada");
                actualizardatos(trabajador);
            } else {
                ToastifyError("No se pudo agregar la comuna");
            }
        }
    });
}


//Eliminar region
function eliminarzonaregion(id, valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/eliminar/zonaregion.php",
        data: { id: id, trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Region eliminada");
                actualizardatos(trabajador);
            } else {
                ToastifyError("No se pudo eliminar la region");
            }
        },
    });
}

//Eliminar zona provincia
function eliminarzonaprovincia(id, valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/eliminar/zonaprovincia.php",
        data: { id: id, trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Provincia eliminada");
                actualizardatos(trabajador);
            } else {
                ToastifyError("No se pudo eliminar la provincia");
            }
        },
    });
}

//Eliminar zona comuna
function eliminarzonacomuna(id, valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/eliminar/zonacomuna.php",
        data: { id: id, trabajador: trabajador },
        success: function (data) {
            if (data == 1 || data == "1") {
                ToastifySuccess("Comuna eliminada");
                actualizardatos(trabajador);
            } else {
                ToastifyError("No se pudo eliminar la comuna");
            }
        },
    });
}

//actualizar datos
function actualizardatos(valor) {
    listarzonaregion(valor);
    listarzonaprovincia(valor);
    listarzonacomuna(valor);
    cargarzonaprovincia(valor);
    cargarzonacomunas(valor);
}

//cargarzonaregion
function listarzonaregion(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/cargar/zonaregion.php",
        data: { trabajador: trabajador },
        success: function (data) {
            $("#tablazonaregiones").html(data);
        },
    });
}

//cargarzonaprovincias
function listarzonaprovincia(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/cargar/zonaprovincia.php",
        data: { trabajador: trabajador },
        success: function (data) {
            $("#tablazonaprovincias").html(data);
        },
    });
}

//cargarzonacomunas
function listarzonacomuna(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/cargar/zonacomunas.php",
        data: { trabajador: trabajador },
        success: function (data) {
            $("#tablazonacomunas").html(data);
        },
    });
}

//Cargar Provincia
function cargarzonaprovincia(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/cargar/cargarzonaprovincia.php",
        data: { trabajador: trabajador },
        success: function (data) {
            $(".zonaprovincia").html(data);
        },
    });
}

//Cargar zonacomunas
function cargarzonacomunas(valor) {
    var trabajador = valor;
    $.ajax({
        type: "POST",
        url: "php/cargar/cargarzonacomunas.php",
        data: { trabajador: trabajador },
        success: function (data) {
            $(".zonacomuna").html(data);
        },
    });
}


function todaslaszonas(){
    //Verificar si esta chequeado
    if($("#territoriozona").is(":checked")){
        $("#territoriozona").val(1);
        $(".zone").addClass("d-none");
    }else{
        $("#territoriozona").val(0);
        $(".zone").removeClass("d-none");
    }
}