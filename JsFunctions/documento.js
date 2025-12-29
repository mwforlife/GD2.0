$(document).ready(function () {
    $("#formdocumento").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertardocumento.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Documento Registrado Correctamente");
                    setTimeout(function () {
                        location.href = "menuinfo.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al Registrar");
                }
            }
        });
    });
    $("#previadocumento").on("click", function () {
        var datos = $("#formdocumento").serialize();
        $("#global-loader").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "php/cargar/previadocumento.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
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
                    $("#modalvistaprevia").modal("show");
                    //Mostrar vista previa en un modal e abrir el modal
                    //Agregar la URL

                } else {
                    ToastifyError(data);
                }
            }
        });
    });
    $("#formdocumentomasivo").on("submit", function (e) {
        e.preventDefault();
        $("#global-loader").fadeIn("slow");
        var datos = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "php/insert/insertardocumentomasivo.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
                if (data == 1) {
                    ToastifySuccess("Documentos Registrados Correctamente");
                    setTimeout(function () {
                        location.href = "generarlotepersonalizado.php";
                    }, 2000);
                } else {
                    ToastifyError("Error al Registrar");
                }
            }
        });
    });
    $("#previadocumentomasivo").on("click", function () {
        var datos = $("#formdocumentomasivo").serialize();
        $("#global-loader").fadeIn("slow");
        $.ajax({
            type: "POST",
            url: "php/cargar/previadocumentomasivo.php",
            data: datos,
            success: function (data) {
                $("#global-loader").fadeOut("slow");
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
                    $("#modalvistaprevia").modal("show");
                    //Mostrar vista previa en un modal e abrir el modal
                    //Agregar la URL

                } else {
                    ToastifyError(data);
                }
            }
        });
    });
});
// Crear un array para almacenar las cláusulas
var clausulasArray = [];

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

$(document).ready(function () {
    // Manejar la solicitud de vista previa
    $("#previaanexomasivo").click(function () {
        enviarDatos("vista_previa");
    });

    // Manejar la solicitud de registro
    $("#formanexomasivo").submit(function (event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
        enviarDatos("registro");
    });

    function enviarDatos(accion) {
        $("#global-loader").fadeIn("slow");
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

        //Validar si el array esta vacio
        if (clausulasArray.length == 0) {
            $("#global-loader").fadeOut("slow");
            ToastifyError("No hay Clausulas Agregadas.");
            return false;
        }

        var clausulas = clausulasArray; // 

        var datos = {
            empresa: empresa,
            fechageneracion: fechageneracion,
            clausulas: clausulas,
            base: base,
            sueldo: sueldo,
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
                url: "php/insert/anexomasivo.php", //
                data: datos,
                success: function (response) {
                    // Manejar la respuesta del servidor aquí, por ejemplo, mostrar una vista previa o mensaje de éxito
                    $("#global-loader").fadeOut("slow");
                    if (response == 1) {
                        ToastifySuccess("Anexos Registrados Correctamente");
                        setTimeout(function () {
                            //Volver atras
                            location.href = "impresiondocumentos.php";
                        }, 1000);
                    } else {
                        ToastifyError("Error al Registrar");
                    }
                },
                error: function () {
                    $("#global-loader").fadeOut("slow");
                    // Manejar errores de la solicitud aquí

                }
            });

        }
    }
});
