
function agregarlotenotificacion(id) {
    $.ajax({
        url: 'php/insert/lotenotificacion.php',
        type: 'POST',
        data: { finiquito: id },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Finiquito agregado correctamente");
                listarlotesnotificacion();
            } else if (response == 2) {
                ToastifyError("Finiquito ya agregado");
            } else {
                ToastifyError("Error al agregar Finiquito");
            }
        }
    });
}

function agregartodonotificacion() {
    $.ajax({
        url: 'php/insert/lotenotificacion.php',
        type: 'POST',
        data: { finiquito: "all" },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Finiquitos agregados correctamente");
                listarlotesnotificacion();
            } else {
                ToastifyError("Error al agregar los Finiquitos");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function listarlotesnotificacion() {
    $.ajax({
        url: 'php/listar/lotenotificacion.php',
        type: 'GET',
        success: function (data) {
            $('#lotes').html(data);
        }
    });
}

// Path: JsFunctions\generarlote.js

function Eliminardellotenotificacion(id) {
    $.ajax({
        url: 'php/eliminar/lotenotificacion.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Finiquito eliminado correctamente");
                listarlotesnotificacion();
            } else {
                ToastifyError("Error al eliminar Finiquito");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function Eliminarlotenotificacion() {
    $.ajax({
        url: 'php/eliminar/todolotenotificacion.php',
        type: 'GET',
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Finiquitos eliminados correctamente");
                listarlotesnotificacion();
            } else {
                ToastifyError("Error al eliminar los Finiquitos");
            }
        }
    });
}