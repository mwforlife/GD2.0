//Contratos masivos
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

function eliminartodoccontrato(id){
    swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:'Si, Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result)=>{
        if(result.value){
            $.ajax({
                url: 'php/eliminar/lotecontrato.php',
                type: 'POST',
                data: {id: id,},
                success: function(data){
                    try {
                        data = JSON.parse(data);
                        if(data.status == true || data.status.trim() == 'true'){
                            ToastifySuccess(data.message);
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }else{
                            ToastifyError(data.message);
                        }
                    } catch (error) {
                        ToastifyError('Error al eliminar');                        
                    }
                }
            })
        }
    });
}

//Finiquitos masivos
var cartfin = new Array();

//addcart1(2," . $object1->getNombre_lote() . ",\"" . $object1->getContrato() . "\",\"" . $object1->getFecha_fin() . "\",\"" . $object1->getTrabajador() . "\",\"" . $object1->getFecha_inicio() . "\")
function addcart1(tipo, id, contrato, fecha_fin, trabajador, fecha_inicio){
    var obj = new Object();
    obj.tipo = tipo;
    obj.id = id;
    obj.contrato = contrato;
    obj.fecha_fin = fecha_fin;
    obj.trabajador = trabajador;
    obj.fecha_inicio = fecha_inicio;
    //Validar si existe el objeto
    if(validarobjeto1(id)){
        ToastifyError('El objeto ya existe en la lista');
        return;
    }
    cartfin.push(obj);
    ToastifySuccess('Objeto agregado a la lista');
    console.log(cartfin);
    listarobjectos1();
}

function validarobjeto1(id){
    var existe = false;
    for (var i = 0; i < cartfin.length; i++) {
        if(cartfin[i].id == id){
            existe = true;
        }
    }
    return existe;
}

function listarobjectos1(){
    if(cartfin.length > 0){
    var html = '';
    html += "<div class='col-md-12'>";
    html += "<div class='card'>";
    html += "<div class='card-header d-flex justify-content-between'>";
    html += "<h3 class='card-title'>Finiquitos a imprimir</h3>";
    html += "<div>";
    html += "<button class='btn btn-outline-danger' onclick='cartfin = []; listarobjectos1();'><i class='fa fa-trash'></i>Limpiar lista </button>";
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimir1();'><i class='fa fa-print'></i>Imprimir </button>";
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
    for (var i = 0; i < cartfin.length; i++) {
        html += '<tr>';
        if(cartfin[i].tipo == 2){
            html += '<td>Finiquito</td>';
        }
        html += '<td>'+cartfin[i].trabajador+'</td>';
        html += '<td>'+cartfin[i].contrato+'</td>';
        html += '<td><button class="btn btn-outline-danger" onclick="eliminarobjeto1('+i+')"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
    }
    html += "</tbody>";
    html += "</table>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $('.objetos1').html(html);
    }else{
        $('.objetos1').html('');
    }
}

function eliminarobjeto1(id){
    cartfin.splice(id, 1);
    listarobjectos1();
}

function imprimir1(){
    if(cartfin.length > 0){
        window.open('php/report/imprimir1.php?cart='+JSON.stringify(cartfin), '_blank');
    }
}

function eliminartodofiniquito(id){
    swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:'Si, Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result)=>{
        if(result.value){
            $.ajax({
                url: 'php/eliminar/masivofiniquito.php',
                type: 'POST',
                data: {id: id,},
                success: function(data){
                    try {
                        data = JSON.parse(data);
                        if(data.status == true || data.status.trim() == 'true'){
                            ToastifySuccess(data.message);
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }else{
                            ToastifyError(data.message);
                        }
                    } catch (error) {
                        ToastifyError('Error al eliminar');                        
                    }
                }
            })
        }
    });
}

