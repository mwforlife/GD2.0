
function agregarlotefiniquito(id) {
    $.ajax({
        url: 'php/insert/lotefiniquito.php',
        type: 'POST',
        data: { contrato: id },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contrato agregado correctamente");
                listarlotesfiniquito();
            } else if (response == 2) {
                ToastifyError("Contrato ya agregado");
            } else {
                ToastifyError("Error al agregar Contrato");
            }
        }
    });
}

function agregartodofiniquito(lote) {
    $.ajax({
        url: 'php/insert/lotefiniquito.php',
        type: 'POST',
        data: { lote: lote },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contratos agregados correctamente");
                listarlotesfiniquito();
            } else {
                ToastifyError("Error al agregar los Contratos");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function listarlotesfiniquito() {
    $.ajax({
        url: 'php/listar/lotefiniquito.php',
        type: 'GET',
        success: function (data) {
            $('#lotes').html(data);
        }
    });
}

// Path: JsFunctions\generarlote.js

function Eliminardellotefiniquito(id) {
    $.ajax({
        url: 'php/eliminar/lotefiniquito.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contrato eliminado correctamente");
                listarlotesfiniquito();
            } else {
                ToastifyError("Error al eliminar Contrato");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function Eliminarlotefiniquito() {
    $.ajax({
        url: 'php/eliminar/todolotefiniquito.php',
        type: 'GET',
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contratos eliminados correctamente");
                listarlotesfiniquito();
            } else {
                ToastifyError("Error al eliminar los Contratos");
            }
        }
    });
}