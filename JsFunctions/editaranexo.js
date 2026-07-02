// Crear un array para almacenar las cláusulas (ya pre-cargado desde PHP si existe)
if (typeof clausulasArray === 'undefined') {
    var clausulasArray = [];
}

$(document).ready(function () {
    // Mostrar cláusulas cargadas al inicio
    actualizarTablaClausulas();

    // Evento de submit del formulario de registro
    $("#formanexomasivo").submit(function (e) {
        e.preventDefault();
        enviarDatos("registro");
    });

    // Evento de click para la vista previa
    $("#previaanexomasivo").click(function () {
        enviarDatos("vista_previa");
    });
});

// Función para agregar una cláusula
function agregarClausula() {
    var clausulaInput = $("#clausula");
    var tipoContratoIdInput = $("#tipocontratoid");
    var tipoContratoTextoInput = $("#tipocontratotext");

    // Obtener los valores de los campos
    var clausula = clausulaInput.val();
    var tipoDocumentoId = tipoContratoIdInput.val();
    var tipoDocumentoTexto = tipoContratoTextoInput.text();

    // Validar campos no vacíos
    if (!tipoDocumentoId || !tipoDocumentoTexto) {
        ToastifyError("Por favor, completa todos los campos antes de agregar la cláusula.");
        return;
    }

    // Crear un objeto de cláusula
    var nuevaClausula = {
        clausula: clausula,
        tipodocumentoid: tipoDocumentoId,
        tipodocumentotexto: tipoDocumentoTexto
    };

    // Agregar la cláusula al array
    clausulasArray.push(nuevaClausula);

    // Limpiar los campos
    clausulaInput.val("");

    // Actualizar la tabla de información de cláusulas
    actualizarTablaClausulas();

    // Mostrar mensaje de éxito
    ToastifySuccess("Clausula agregada con éxito");
}

// Función para eliminar una cláusula
function eliminarClausula(index) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la cláusula seleccionada.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            clausulasArray.splice(index, 1);
            actualizarTablaClausulas();
            ToastifySuccess("Clausula eliminada con éxito");
        }
    });
}

// Función para actualizar la tabla de información de cláusulas
function actualizarTablaClausulas() {
    var tabla = $("#clausulas");
    tabla.empty();

    for (var i = 0; i < clausulasArray.length; i++) {
        var clausula = clausulasArray[i];

        var fila = $("<tr></tr>").html(`
                <td>${clausula.clausula}</td>
                <td>${clausula.tipodocumentotexto}</td>
                <td><button type="button" class="btn btn-outline-danger" onclick="eliminarClausula(${i})"><i class="fas fa-trash-alt"></i></button></td>
            `);

        tabla.append(fila);
    }
}

function enviarDatos(accion) {
    $("#global-loader").fadeIn("slow");
    var id = $("#anexo_id").val();
    var contratoid = $("#contrato_id").val();
    var empresa = $("#empresa").val();
    var fechageneracion = $("#fechageneracion").val();
    var base = 0;
    var sueldo = $("#sueldo").val();
    
    //Comprobar si el modificar sueldo base esta chequeado
    if($("#base").is(":checked")){
        base = 1;
        //Comprobar si el sueldo esta vacio
        if(sueldo.trim().length == 0){
            $("#global-loader").fadeOut("slow");
            ToastifyError("Por favor, ingrese el sueldo base.");
            $("#sueldo").focus();
            return false;
        }
    }

    var modificafecha = 0;
    var nuevafechatermino = $("#nuevafechatermino").val();
    if ($("#modificafecha").is(":checked")) {
        modificafecha = 1;
    }

    //Validar si el array esta vacio
    if (clausulasArray.length == 0) {
        $("#global-loader").fadeOut("slow");
        ToastifyError("No hay Clausulas Agregadas.");
        return false;
    }

    var clausulas = clausulasArray;

    var datos = {
        id: id,
        contrato_id: contratoid,
        empresa: empresa,
        fechageneracion: fechageneracion,
        clausulas: clausulas,
        base: base,
        sueldo: sueldo,
        modificafecha: modificafecha,
        nuevafechatermino: nuevafechatermino
    };

    // Realizar la solicitud Ajax
    if (accion === "vista_previa") {
        $("#global-loader").fadeOut("slow");

        // Crear un formulario temporal para enviar los datos al iframe
        var form = $('<form>', {
            'method': 'POST',
            'action': 'php/cargar/previaanexo.php',
            'target': 'vistaprevia'
        });

        // Agregar los campos del formulario
        form.append($('<input>', { 'type': 'hidden', 'name': 'empresa', 'value': datos.empresa }));
        form.append($('<input>', { 'type': 'hidden', 'name': 'fechageneracion', 'value': datos.fechageneracion }));
        form.append($('<input>', { 'type': 'hidden', 'name': 'base', 'value': datos.base }));
        form.append($('<input>', { 'type': 'hidden', 'name': 'sueldo', 'value': datos.sueldo }));
        form.append($('<input>', { 'type': 'hidden', 'name': 'modificafecha', 'value': datos.modificafecha }));
        form.append($('<input>', { 'type': 'hidden', 'name': 'nuevafechatermino', 'value': datos.nuevafechatermino }));
        form.append($('<input>', { 'type': 'hidden', 'name': 'contratoid_preview', 'value': datos.contrato_id }));

        // Agregar el array de clausulas como JSON
        form.append($('<input>', { 'type': 'hidden', 'name': 'clausulas', 'value': JSON.stringify(datos.clausulas) }));

        // Agregar el formulario al body, enviarlo y eliminarlo
        form.appendTo('body').submit().remove();

        // Mostrar el modal
        $("#modalvistaprevia").modal("show");
    }
    else if (accion === "registro") {
        $.ajax({
            type: "POST",
            url: "php/update/anexocompleto.php",
            data: datos,
            success: function (response) {
                $("#global-loader").fadeOut("slow");
                if (response == 1) {
                    ToastifySuccess("Anexo actualizado correctamente");
                    setTimeout(function () {
                        location.href = "impresiondocumentos.php";
                    }, 1000);
                } else {
                    ToastifyError(response || "Error al actualizar anexo");
                }
            },
            error: function () {
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error de comunicación con el servidor");
            }
        });
    }
}
