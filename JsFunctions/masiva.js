var cart = new Array();

function addcart(tipo, id, contrato, trabajador, ruta){
    var obj = new Object();
    obj.tipo = tipo;
    obj.id = id;
    obj.contrato = contrato;
    obj.trabajador = trabajador;
    obj.ruta = ruta;
    //Validar si existe el objeto
    if(validarobjeto(id)){
        ToastifyError('El objeto ya existe en la lista');
        return;
    }
    cart.push(obj);
    ToastifySuccess('Objeto agregado a la lista');
    console.log(cart);
    listarobjectos();
}

function validarobjeto(id){
    var existe = false;
    for (var i = 0; i < cart.length; i++) {
        if(cart[i].id == id){
            existe = true;
        }
    }
    return existe;
}

function listarobjectos(){
    if(cart.length > 0){
    var html = '';
    html += "<div class='col-md-12'>";
    html += "<div class='card'>";
    html += "<div class='card-header d-flex justify-content-between'>";
    html += "<h3 class='card-title'>Contratos a imprimir</h3>";
    html += "<div>";
    html += "<button class='btn btn-outline-danger' onclick='cart = []; listarobjectos();'><i class='fa fa-trash'></i>Limpiar lista </button>";
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimir();'><i class='fa fa-print'></i>Imprimir </button>";
    html += "</div>";
    html += "</div>";
    html += "<div class='card-body'>";
    html += "<table class='table table-bordered'>";
    html += "<thead>";
    html += "<tr>";
    html += "<th>Tipo</th>";
    html += "<th>Trabajador</th>";
    html += "<th>Documento</th>";
    html += "<th>Eliminar</th>";
    html += "</tr>";
    html += "</thead>";
    html += "<tbody>";
    for (var i = 0; i < cart.length; i++) {
        html += '<tr>';
        if(cart[i].tipo == 1){
            html += '<td>Contrato</td>';
        }
        html += '<td>'+cart[i].trabajador+'</td>';
        html += '<td>'+cart[i].contrato+'</td>';
        html += '<td><button class="btn btn-outline-danger" onclick="eliminarobjeto('+i+')"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
    }
    html += "</tbody>";
    html += "</table>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $('.objetos').html(html);
    }else{
        $('.objetos').html('');
    }
}

function eliminarobjeto(id){
    cart.splice(id, 1);
    listarobjectos();
}

function imprimir(){
    if(cart.length > 0){
        window.open('php/report/imprimir.php?cart='+JSON.stringify(cart), '_blank');
    }
}