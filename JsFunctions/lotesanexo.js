
function agregarloteanexo(id) {
    $.ajax({
        url: 'php/insert/loteanexo.php',
        type: 'POST',
        data: { contrato: id },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contrato agregado correctamente");
                listarlotesanexo();
            } else if (response == 2) {
                ToastifyError("Contrato ya agregado");
            } else {
                ToastifyError("Error al agregar Contrato");
            }
        }
    });
}

function agregartodoanexo(lote) {
    $.ajax({
        url: 'php/insert/loteanexo.php',
        type: 'POST',
        data: { lote: lote },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contratos agregados correctamente");
                listarlotesanexo();
            } else {
                ToastifyError("Error al agregar los Contratos");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function listarlotesanexo() {
    $.ajax({
        url: 'php/listar/loteanexo.php',
        type: 'GET',
        success: function (data) {
            $('#lotes').html(data);
        }
    });
}

// Path: JsFunctions\generarlote.js

function Eliminardelloteanexo(id) {
    $.ajax({
        url: 'php/eliminar/loteanexo.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contrato eliminado correctamente");
                listarlotesanexo();
            } else {
                ToastifyError("Error al eliminar Contrato");
            }
        }
    });
}

// Path: JsFunctions\generarlote.js
function Eliminarloteanexo() {
    $.ajax({
        url: 'php/eliminar/todoloteanexo.php',
        type: 'GET',
        success: function (response) {
            if (response == 1) {
                ToastifySuccess("Contratos eliminados correctamente");
                listarlotesanexo();
            } else {
                ToastifyError("Error al eliminar los Contratos");
            }
        }
    });
}
