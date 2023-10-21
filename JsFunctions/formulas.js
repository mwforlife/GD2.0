//agregar(" . $haber->getId() . ",\"" . $haber->getDescripcion() . "\")
function agregar(id, descripcion) {
    descripcion = descripcion.replace(" ", "_");
    var iddent = "{";
    iddent += descripcion + "}";
    //pasar a mayusculas
    iddent = iddent.toUpperCase();
    $("#formula").val($("#formula").val() + iddent);
}

function sumar() {
    $("#formula").val($("#formula").val() + "+");
}

function restar() {
    $("#formula").val($("#formula").val() + "-");
}

function multiplicar() {
    $("#formula").val($("#formula").val() + "*");
}

function dividir() {
    $("#formula").val($("#formula").val() + "/");
}

function representacion(element) {
    var valor = $(element).val();
    if (valor.trim().length == 0) {
        $("#represent").val("");
        return;
    } else {
        valor = valor.replaceAll(" ", "_");
        valor = valor.toUpperCase();
        $("#represent").val("{" + valor + "}");
    }
}