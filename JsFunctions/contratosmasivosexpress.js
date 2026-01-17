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

//Funcion listar comunas celebracion
function listarcomunas() {
    var region = $("#regioncelebracion").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/comunas.php",
        data: "id=" + region,
        success: function (data) {
            $("#comunacelebracion").html(data);
        },
    });
}

//Funcion subcontratacion
function subcontratacion() {
    var subcontratacionval = $("#subcontratacionval").val();
    if (subcontratacionval == 0) {
        $(".subcontratacion").removeClass("d-none");
        $("#subcontratacionval").val(1);
        $(".transitorios").addClass("d-none");
        $("#transitoriosval").val(0);
        $("#transitoriosval").prop("checked", false);
    } else {
        $(".subcontratacion").addClass("d-none");
        $("#subcontratacionval").val(0);
    }
}

//Funcion transitorios
function transitorios() {
    var transitoriosval = $("#transitoriosval").val();
    if (transitoriosval == 0) {
        $(".transitorios").removeClass("d-none");
        $("#transitoriosval").val(1);
        $(".subcontratacion").addClass("d-none");
        $("#subcontratacionval").val(0);
        $("#subcontratacionval").prop("checked", false);
    } else {
        $(".transitorios").addClass("d-none");
        $("#transitoriosval").val(0);
    }
}

//Funcion checkpacto
function checkpacto() {
    var pacto = $("#badi").val();
    if (pacto == 0) {
        $(".pacto").removeClass("d-none");
        $("#badi").val(1);
    } else {
        $(".pacto").addClass("d-none");
        $("#badi").val(0);
    }
}

//Funcion contratotipo
function contratotipo(element) {
    var tipo = $(element).val();
    if (tipo == 2) {
        $(".terminor").removeClass("d-none");
    } else {
        $(".terminor").addClass("d-none");
    }
}

//Funcion formadepago - No se usa en masivo porque no hay datos bancarios del trabajador
function formadepago() {
    // En contratos masivos express no se muestran datos bancarios del trabajador
}

/**
 * Funcion principal para registrar contratos masivos express
 * Valida los datos y muestra el modal de resumen
 */
function RegistrarContrato() {
    // Validar formularios
    if (!validarFormularioExpressMasivo()) {
        return false;
    }

    // Capturar todos los datos del formulario
    var datosContrato = capturarDatosContratoMasivo();

    // Mostrar resumen en el modal
    mostrarResumenContratoMasivo(datosContrato);

    // Abrir modal de confirmacion
    $('#modalResumenContrato').modal('show');
}

/**
 * Validar todos los campos del formulario express masivo
 * Excluye validaciones de campos individuales como AFP, Salud, banco del trabajador
 */
function validarFormularioExpressMasivo() {
    // Validar Seccion 1 - Identificacion
    var regioncelebracion = $("#regioncelebracion").val();
    var comunacelebracion = $("#comunacelebracion").val();
    var fechacelebracion = $("#fechacelebracion").val();
    var representante_legal = $("#representante_legal").val();
    var codigoactividadid = $("#codigoactividadid").val();

    if (regioncelebracion <= 0) {
        ToastifyError("Debe seleccionar una region de celebracion");
        mostrar1();
        $("#regioncelebracion").focus();
        return false;
    }
    if (comunacelebracion <= 0) {
        ToastifyError("Debe seleccionar una comuna de celebracion");
        mostrar1();
        $("#comunacelebracion").focus();
        return false;
    }
    if (!fechacelebracion) {
        ToastifyError("Debe seleccionar una fecha de suscripcion");
        mostrar1();
        $("#fechacelebracion").focus();
        return false;
    }
    if (representante_legal <= 0) {
        ToastifyError("Debe seleccionar un representante legal");
        mostrar1();
        $("#representante_legal").focus();
        return false;
    }
    if (codigoactividadid <= 0) {
        ToastifyError("Debe seleccionar el codigo de actividad economica");
        mostrar1();
        $("#codigoactividadid").focus();
        return false;
    }

    // Validar Seccion 2 - Funciones
    var centrocosto = $("#centrocosto").val();
    var Charge = $("#Charge").val();
    var ChargeDescripcion = $("#ChargeDescripcion").val();
    var regionespecifica = $("#regionespecifica").val();
    var comunaespecifica = $("#comunaespecifica").val();
    var calleespecifica = $("#calleespecifica").val();
    var numeroespecifica = $("#numeroespecifica").val();

    if (centrocosto <= 0) {
        ToastifyError("Debe seleccionar el centro de costo");
        mostrar2();
        $("#centrocosto").focus();
        return false;
    }
    if (!Charge || Charge == "0") {
        ToastifyError("Debe seleccionar el cargo");
        mostrar2();
        $("#Charge").focus();
        return false;
    }
    if (!ChargeDescripcion || ChargeDescripcion.trim().length == 0) {
        ToastifyError("Debe ingresar la descripcion del cargo");
        mostrar2();
        $("#ChargeDescripcion").focus();
        return false;
    }
    if (regionespecifica <= 0) {
        ToastifyError("Debe seleccionar la region del lugar de trabajo");
        mostrar2();
        $("#regionespecifica").focus();
        return false;
    }
    if (comunaespecifica <= 0) {
        ToastifyError("Debe seleccionar la comuna del lugar de trabajo");
        mostrar2();
        $("#comunaespecifica").focus();
        return false;
    }
    if (!calleespecifica || calleespecifica.trim().length == 0) {
        ToastifyError("Debe ingresar la calle del lugar de trabajo");
        mostrar2();
        $("#calleespecifica").focus();
        return false;
    }
    if (!numeroespecifica || numeroespecifica.trim().length == 0) {
        ToastifyError("Debe ingresar el numero del lugar de trabajo");
        mostrar2();
        $("#numeroespecifica").focus();
        return false;
    }

    // Validar subcontratacion si esta marcada
    if ($("#subcontratacionval").is(":checked") || $("#subcontratacionval").val() == 1) {
        var subcontratacionrut = $("#subcontratacionrut").val();
        var subcontratacionrazonsocial = $("#subcontratacionrazonsocial").val();
        if (!subcontratacionrut || subcontratacionrut.trim().length == 0) {
            ToastifyError("Debe ingresar el RUT de subcontratacion");
            mostrar2();
            $("#subcontratacionrut").focus();
            return false;
        }
        if (!subcontratacionrazonsocial || subcontratacionrazonsocial.trim().length == 0) {
            ToastifyError("Debe ingresar la razon social de subcontratacion");
            mostrar2();
            $("#subcontratacionrazonsocial").focus();
            return false;
        }
    }

    // Validar transitorios si esta marcado
    if ($("#transitoriosval").is(":checked") || $("#transitoriosval").val() == 1) {
        var transitoriosrut = $("#transitoriosrut").val();
        var transitoriosrazonsocial = $("#transitoriosrazonsocial").val();
        if (!transitoriosrut || transitoriosrut.trim().length == 0) {
            ToastifyError("Debe ingresar el RUT de servicios transitorios");
            mostrar2();
            $("#transitoriosrut").focus();
            return false;
        }
        if (!transitoriosrazonsocial || transitoriosrazonsocial.trim().length == 0) {
            ToastifyError("Debe ingresar la razon social de servicios transitorios");
            mostrar2();
            $("#transitoriosrazonsocial").focus();
            return false;
        }
    }

    // Validar Seccion 3 - Remuneraciones (sin datos bancarios del trabajador)
    var tiposueldo = $("#tiposueldo").val();
    var sueldo = $("#sueldo").val();
    var formapago = $("#formapago").val();
    var periodopagot = $("#periodopagot").val();
    var fechapagot = $("#fechapagot").val();
    var formapagot = $("#formapagot").val();
    var anticipot = $("#anticipot").val();

    if (tiposueldo <= 0) {
        ToastifyError("Debe seleccionar el tipo de sueldo");
        mostrar3();
        $("#tiposueldo").focus();
        return false;
    }
    if (!sueldo || sueldo.trim().length == 0) {
        ToastifyError("Debe ingresar el sueldo base");
        mostrar3();
        $("#sueldo").focus();
        return false;
    }
    if (formapago <= 0) {
        ToastifyError("Debe seleccionar la forma de pago de gratificacion");
        mostrar3();
        $("#formapago").focus();
        return false;
    }
    if (periodopagot <= 0) {
        ToastifyError("Debe seleccionar el periodo de pago");
        mostrar3();
        $("#periodopagot").focus();
        return false;
    }
    if (fechapagot <= 0) {
        ToastifyError("Debe seleccionar la fecha de pago");
        mostrar3();
        $("#fechapagot").focus();
        return false;
    }
    if (formapagot <= 0) {
        ToastifyError("Debe seleccionar la forma de pago");
        mostrar3();
        $("#formapagot").focus();
        return false;
    }
    if (anticipot <= 0) {
        ToastifyError("Debe seleccionar el tipo de anticipo");
        mostrar3();
        $("#anticipot").focus();
        return false;
    }

    // Validar pacto adicional si esta marcado
    if ($("#badi").is(":checked") || $("#badi").val() == 1) {
        var otrter = $("#otrter").val();
        if (!otrter || otrter.trim().length == 0) {
            ToastifyError("Debe ingresar los terminos del pacto adicional");
            mostrar3();
            $("#otrter").focus();
            return false;
        }
    }

    // Validar Seccion 4 - Jornada y Contrato
    var duracionjor = $("#duracionjor").val();
    var fecha_inicio = $("#fecha_inicio").val();
    var juramento = $("#juramento").is(":checked");

    if (duracionjor <= 0) {
        ToastifyError("Debe seleccionar la duracion de jornada");
        mostrar4();
        $("#duracionjor").focus();
        return false;
    }
    if (!fecha_inicio) {
        ToastifyError("Debe seleccionar la fecha de inicio de la relacion laboral");
        mostrar4();
        $("#fecha_inicio").focus();
        return false;
    }

    // Validar fecha de termino si es plazo fijo
    if ($("#tipo_contrato2").is(":checked")) {
        var fecha_termino = $("#fecha_termino").val();
        if (!fecha_termino) {
            ToastifyError("Debe seleccionar la fecha de termino para contrato a plazo fijo");
            mostrar4();
            $("#fecha_termino").focus();
            return false;
        }
    }

    if (!juramento) {
        ToastifyError("Debe aceptar la declaracion jurada");
        mostrar4();
        $("#juramento").focus();
        return false;
    }

    return true;
}

/**
 * Capturar todos los datos del formulario para contratos masivos
 * No incluye datos individuales del trabajador (AFP, Salud, banco)
 */
function capturarDatosContratoMasivo() {
    // Obtener tipo de contrato seleccionado
    var tipoContratoValor = 1;
    var tipoContratoTexto = "Indefinido";
    if ($("#tipo_contrato2").is(":checked")) {
        tipoContratoValor = 2;
        tipoContratoTexto = "Plazo Fijo";
    } else if ($("#tipo_contrato3").is(":checked")) {
        tipoContratoValor = 3;
        tipoContratoTexto = "Obra o Faena";
    }

    // Obtener texto de tipo de sueldo
    var tipoSueldoTexto = $("#tiposueldo option:selected").text();

    // Obtener texto de duracion jornada
    var duracionJornadaTexto = $("#duracionjor option:selected").text();

    // Obtener texto de forma de pago gratificacion
    var formaGratificacionTexto = $("#formapago option:selected").text();

    // Obtener texto de periodo de pago
    var periodoPagoTexto = $("#periodopagot option:selected").text();

    // Obtener texto de forma de pago
    var formaPagoTexto = $("#formapagot option:selected").text();

    // Obtener texto de anticipo
    var anticipoTexto = $("#anticipot option:selected").text();

    // Obtener texto de centro de costo
    var centroCostoTexto = $("#centrocosto option:selected").text();

    // Obtener texto de cargo
    var cargoTexto = $("#Charge option:selected").text();

    // Obtener texto de region y comuna celebracion
    var regionCelebracionTexto = $("#regioncelebracion option:selected").text();
    var comunaCelebracionTexto = $("#comunacelebracion option:selected").text();

    // Obtener texto de region y comuna especifica
    var regionEspecificaTexto = $("#regionespecifica option:selected").text();
    var comunaEspecificaTexto = $("#comunaespecifica option:selected").text();

    // Obtener lista de trabajadores del lote
    var trabajadores = [];
    $("#e2 tbody tr").each(function() {
        var rut = $(this).find("td:eq(0)").text().trim();
        var nombre = $(this).find("td:eq(1)").text().trim();
        var fechaNacimiento = $(this).find("td:eq(2)").text().trim();
        var sexo = $(this).find("td:eq(3)").text().trim();
        trabajadores.push({
            rut: rut,
            nombre: nombre,
            fechaNacimiento: fechaNacimiento,
            sexo: sexo
        });
    });
    var cantidadTrabajadores = trabajadores.length;

    var datos = {
        // IDs principales
        idempresa: $("#idempresa").val(),
        typecontract: 2, // Tipo 2 = Express (sin documento)

        // Datos de identificacion
        categoria_contrato: $("#categoria_contrato").val(),
        fechacelebracion: $("#fechacelebracion").val(),
        regioncelebracion: $("#regioncelebracion").val(),
        regioncelebracion_texto: regionCelebracionTexto,
        comunacelebracion: $("#comunacelebracion").val(),
        comunacelebracion_texto: comunaCelebracionTexto,
        representante_legal: $("#representante_legal").val(),
        representante_legal_texto: $("#representante_legal option:selected").text(),
        codigoactividadid: $("#codigoactividadid").val(),
        codigoactividad_texto: $("#codigoactividadid option:selected").text(),

        // Datos de empresa (readonly)
        rut_empleador: $("#rut_empleador").val(),
        nombre_razon_social: $("#nombre_razon_social").val(),

        // Cantidad y lista de trabajadores
        cantidad_trabajadores: cantidadTrabajadores,
        trabajadores: trabajadores,

        // Datos de funciones
        centrocosto: $("#centrocosto").val(),
        centrocosto_texto: centroCostoTexto,
        Charge: $("#Charge").val(),
        Charge_texto: cargoTexto,
        ChargeDescripcion: $("#ChargeDescripcion").val(),
        regionespecifica: $("#regionespecifica").val(),
        regionespecifica_texto: regionEspecificaTexto,
        comunaespecifica: $("#comunaespecifica").val(),
        comunaespecifica_texto: comunaEspecificaTexto,
        calleespecifica: $("#calleespecifica").val(),
        numeroespecifica: $("#numeroespecifica").val(),
        departamentoespecifica: $("#departamentoespecifica").val(),

        // Subcontratacion
        subcontratacionval: ($("#subcontratacionval").is(":checked") || $("#subcontratacionval").val() == 1) ? 1 : 0,
        subcontratacionrut: $("#subcontratacionrut").val(),
        subcontratacionrazonsocial: $("#subcontratacionrazonsocial").val(),

        // Transitorios
        transitoriosval: ($("#transitoriosval").is(":checked") || $("#transitoriosval").val() == 1) ? 1 : 0,
        transitoriosrut: $("#transitoriosrut").val(),
        transitoriosrazonsocial: $("#transitoriosrazonsocial").val(),

        // Remuneraciones
        tiposueldo: $("#tiposueldo").val(),
        tiposueldo_texto: tipoSueldoTexto,
        sueldo: $("#sueldo").val(),
        formapago: $("#formapago").val(),
        formapago_texto: formaGratificacionTexto,
        periodopagogra: $("#periodopagogra").val(),
        detallerenumeraciongra: $("#detallerenumeraciongra").val(),
        periodopagot: $("#periodopagot").val(),
        periodopagot_texto: periodoPagoTexto,
        fechapagot: $("#fechapagot").val(),
        formapagot: $("#formapagot").val(),
        formapagot_texto: formaPagoTexto,
        anticipot: $("#anticipot").val(),
        anticipot_texto: anticipoTexto,

        // Pacto adicional
        badi: ($("#badi").is(":checked") || $("#badi").val() == 1) ? 1 : 0,
        otrter: $("#otrter").val(),

        // Jornada
        duracionjor: $("#duracionjor").val(),
        duracionjor_texto: duracionJornadaTexto,

        // Tipo y fechas de contrato
        tipo_contrato: tipoContratoValor,
        tipo_contrato_texto: tipoContratoTexto,
        fecha_inicio: $("#fecha_inicio").val(),
        fecha_termino: $("#fecha_termino").val()
    };

    return datos;
}

/**
 * Mostrar resumen del contrato masivo en el modal
 */
function mostrarResumenContratoMasivo(datos) {
    var html = '';

    // Seccion 1: Datos del Contrato
    html += '<div class="card mb-3">';
    html += '<div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fe fe-file-text mr-2"></i>Datos del Contrato Masivo</h6></div>';
    html += '<div class="card-body">';
    html += '<div class="row">';
    html += '<div class="col-md-6"><strong>Fecha Suscripcion:</strong> ' + formatearFecha(datos.fechacelebracion) + '</div>';
    html += '<div class="col-md-6"><strong>Lugar:</strong> ' + datos.comunacelebracion_texto + ', ' + datos.regioncelebracion_texto + '</div>';
    html += '<div class="col-md-6"><strong>Tipo Contrato:</strong> <span class="badge badge-info">' + datos.tipo_contrato_texto + '</span></div>';
    html += '<div class="col-md-6"><strong>Fecha Inicio:</strong> ' + formatearFecha(datos.fecha_inicio) + '</div>';
    if (datos.tipo_contrato == 2 && datos.fecha_termino) {
        html += '<div class="col-md-6"><strong>Fecha Termino:</strong> ' + formatearFecha(datos.fecha_termino) + '</div>';
    }
    html += '<div class="col-md-6"><strong>Cantidad Trabajadores:</strong> <span class="badge badge-success">' + datos.cantidad_trabajadores + '</span></div>';
    html += '</div></div></div>';

    // Seccion 2: Datos del Empleador
    html += '<div class="card mb-3">';
    html += '<div class="card-header bg-secondary text-white"><h6 class="mb-0"><i class="fe fe-briefcase mr-2"></i>Datos del Empleador</h6></div>';
    html += '<div class="card-body">';
    html += '<div class="row">';
    html += '<div class="col-md-6"><strong>RUT:</strong> ' + datos.rut_empleador + '</div>';
    html += '<div class="col-md-6"><strong>Razon Social:</strong> ' + datos.nombre_razon_social + '</div>';
    html += '<div class="col-md-6"><strong>Representante Legal:</strong> ' + datos.representante_legal_texto + '</div>';
    html += '<div class="col-md-6"><strong>Actividad Economica:</strong> ' + datos.codigoactividad_texto + '</div>';
    html += '</div></div></div>';

    // Seccion 3: Funciones y Lugar de Trabajo
    html += '<div class="card mb-3">';
    html += '<div class="card-header bg-info text-white"><h6 class="mb-0"><i class="fe fe-map-pin mr-2"></i>Funciones y Lugar de Trabajo</h6></div>';
    html += '<div class="card-body">';
    html += '<div class="row">';
    html += '<div class="col-md-6"><strong>Centro de Costo:</strong> ' + datos.centrocosto_texto + '</div>';
    html += '<div class="col-md-6"><strong>Cargo:</strong> ' + datos.Charge_texto + '</div>';
    html += '<div class="col-md-12"><strong>Descripcion:</strong> ' + datos.ChargeDescripcion + '</div>';
    html += '<div class="col-md-12"><strong>Direccion:</strong> ' + datos.calleespecifica + ' ' + datos.numeroespecifica;
    if (datos.departamentoespecifica) {
        html += ', ' + datos.departamentoespecifica;
    }
    html += ', ' + datos.comunaespecifica_texto + ', ' + datos.regionespecifica_texto + '</div>';
    if (datos.subcontratacionval == 1) {
        html += '<div class="col-md-12 mt-2"><span class="badge badge-warning">Subcontratacion</span> ' + datos.subcontratacionrut + ' - ' + datos.subcontratacionrazonsocial + '</div>';
    }
    if (datos.transitoriosval == 1) {
        html += '<div class="col-md-12 mt-2"><span class="badge badge-warning">Servicios Transitorios</span> ' + datos.transitoriosrut + ' - ' + datos.transitoriosrazonsocial + '</div>';
    }
    html += '</div></div></div>';

    // Seccion 4: Remuneraciones
    html += '<div class="card mb-3">';
    html += '<div class="card-header bg-warning text-dark"><h6 class="mb-0"><i class="fe fe-dollar-sign mr-2"></i>Remuneraciones</h6></div>';
    html += '<div class="card-body">';
    html += '<div class="row">';
    html += '<div class="col-md-6"><strong>Tipo Sueldo:</strong> ' + datos.tiposueldo_texto + '</div>';
    html += '<div class="col-md-6"><strong>Sueldo Base:</strong> $' + formatearMonto(datos.sueldo) + '</div>';
    html += '<div class="col-md-6"><strong>Gratificacion:</strong> ' + datos.formapago_texto + '</div>';
    html += '<div class="col-md-6"><strong>Periodo Pago:</strong> ' + datos.periodopagot_texto + '</div>';
    html += '<div class="col-md-6"><strong>Dia de Pago:</strong> ' + datos.fechapagot + '</div>';
    html += '<div class="col-md-6"><strong>Forma de Pago:</strong> ' + datos.formapagot_texto + '</div>';
    html += '<div class="col-md-6"><strong>Anticipo:</strong> ' + datos.anticipot_texto + '</div>';
    if (datos.badi == 1 && datos.otrter) {
        html += '<div class="col-md-12 mt-2"><strong>Pacto Adicional:</strong> ' + datos.otrter + '</div>';
    }
    html += '</div></div></div>';

    // Seccion 5: Jornada
    html += '<div class="card mb-3">';
    html += '<div class="card-header bg-dark text-white"><h6 class="mb-0"><i class="fe fe-clock mr-2"></i>Jornada Laboral</h6></div>';
    html += '<div class="card-body">';
    html += '<div class="row">';
    html += '<div class="col-md-12"><strong>Duracion:</strong> ' + datos.duracionjor_texto + ' semanales</div>';
    html += '</div></div></div>';

    // Seccion 6: Lista de Trabajadores
    html += '<div class="card mb-3">';
    html += '<div class="card-header bg-success text-white"><h6 class="mb-0"><i class="fe fe-users mr-2"></i>Trabajadores a Contratar (' + datos.cantidad_trabajadores + ')</h6></div>';
    html += '<div class="card-body p-0">';
    html += '<div class="table-responsive" style="max-height: 300px; overflow-y: auto;">';
    html += '<table class="table table-striped table-sm mb-0">';
    html += '<thead class="thead-light"><tr><th>#</th><th>RUT</th><th>Nombre Completo</th><th>Fecha Nac.</th><th>Sexo</th></tr></thead>';
    html += '<tbody>';
    if (datos.trabajadores && datos.trabajadores.length > 0) {
        datos.trabajadores.forEach(function(t, index) {
            html += '<tr>';
            html += '<td>' + (index + 1) + '</td>';
            html += '<td>' + t.rut + '</td>';
            html += '<td>' + t.nombre + '</td>';
            html += '<td>' + t.fechaNacimiento + '</td>';
            html += '<td>' + t.sexo + '</td>';
            html += '</tr>';
        });
    }
    html += '</tbody></table></div></div></div>';

    // Insertar HTML en el modal
    $('#resumenContratoContent').html(html);

    // Guardar datos en el boton de confirmar para usar despues
    $('#btnConfirmarContratoExpress').data('datosContrato', datos);
}

/**
 * Formatear fecha de YYYY-MM-DD a DD/MM/YYYY
 */
function formatearFecha(fecha) {
    if (!fecha) return '-';
    var partes = fecha.split('-');
    if (partes.length === 3) {
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }
    return fecha;
}

/**
 * Formatear monto con separador de miles
 */
function formatearMonto(monto) {
    if (!monto) return '0';
    // Limpiar el monto de caracteres no numericos excepto punto
    var numero = monto.toString().replace(/[^0-9]/g, '');
    return numero.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/**
 * Confirmar y enviar los contratos masivos al backend
 */
function confirmarContratoExpress() {
    var datos = $('#btnConfirmarContratoExpress').data('datosContrato');

    if (!datos) {
        ToastifyError("Error: No se encontraron los datos del contrato");
        return;
    }

    // Mostrar loader
    $("#global-loader").fadeIn("slow");
    $('#btnConfirmarContratoExpress').prop('disabled', true);

    // Enviar datos al backend
    $.ajax({
        type: "POST",
        url: "php/pdf/registrarcontratomasivoexpress.php",
        data: datos,
        dataType: "json",
        success: function (response) {
            $("#global-loader").fadeOut("slow");
            $('#btnConfirmarContratoExpress').prop('disabled', false);

            if (response.success) {
                // Cerrar modal
                $('#modalResumenContrato').modal('hide');

                // Mostrar mensaje de exito con detalles
                var mensaje = response.message || "Contratos registrados exitosamente";
                if (response.contratos_registrados) {
                    mensaje += " (" + response.contratos_registrados + " contratos)";
                }
                if (response.lote_nombre) {
                    mensaje += "\nLote: " + response.lote_nombre;
                }

                ToastifySuccess(mensaje);

                // Mostrar alerta de exito con SweetAlert si hay errores parciales
                if (response.partial && response.errores && response.errores.length > 0) {
                    Swal.fire({
                        title: 'Contratos registrados con advertencias',
                        html: '<p>Se registraron ' + response.contratos_registrados + ' contratos.</p>' +
                              '<p class="text-warning">Algunos contratos no pudieron ser registrados:</p>' +
                              '<ul class="text-left">' + response.errores.map(e => '<li>' + e + '</li>').join('') + '</ul>',
                        icon: 'warning',
                        confirmButtonText: 'Entendido'
                    }).then(() => {
                        window.location.href = "impresionmasiva.php";
                    });
                } else {
                    // Redirigir despues de 2 segundos
                    setTimeout(function () {
                        window.location.href = "impresionmasiva.php";
                    }, 2000);
                }
            } else {
                ToastifyError(response.error || "Error al registrar los contratos");

                // Si hay errores especificos, mostrarlos
                if (response.errores && response.errores.length > 0) {
                    Swal.fire({
                        title: 'Error al registrar contratos',
                        html: '<ul class="text-left">' + response.errores.map(e => '<li>' + e + '</li>').join('') + '</ul>',
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        },
        error: function (xhr, status, error) {
            $("#global-loader").fadeOut("slow");
            $('#btnConfirmarContratoExpress').prop('disabled', false);
            console.error("Error:", error);
            console.error("Response:", xhr.responseText);
            ToastifyError("Error de conexion al registrar los contratos");
        }
    });
}
