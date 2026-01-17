//Contratos masivos
var cart = new Array();

function addcart(tipo, id, contrato, trabajador, ruta, formato_contrato){
    var obj = new Object();
    obj.tipo = tipo;
    obj.id = id;
    obj.contrato = contrato;
    obj.trabajador = trabajador;
    obj.ruta = ruta;
    obj.formato_contrato = formato_contrato !== undefined ? formato_contrato : 1;
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
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimirConModal();'><i class='fa fa-print'></i>Imprimir </button>";
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimirfaena()'><i class='fa fa-print'></i>Inscripción Faena </button>";
    html += "</div>";
    html += "</div>";
    html += "<div class='card-body'>";
    html += "<table class='table table-bordered'>";
    html += "<thead>";
    html += "<tr>";
    html += "<th>Tipo</th>";
    html += "<th>Trabajador</th>";
    html += "<th>Documento</th>";
    html += "<th>Estado</th>";
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
        // Mostrar badge según formato_contrato
        if(cart[i].formato_contrato == 1){
            html += '<td><span class="badge badge-success">Normal</span></td>';
        } else {
            html += '<td><span class="badge badge-warning">Express</span></td>';
        }
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

function imprimirfaena(){
    if(cart.length > 0){
        window.open('php/report/faena2.php?cart='+JSON.stringify(cart), '_blank');
    }
}

function eliminartodoccontrato(id){
    $("#global-loader").fadeIn("slow");

    // Primero obtener los detalles del lote y sus contratos
    $.ajax({
        url: "php/obtener/detalles_lote_eliminacion.php",
        type: "POST",
        data: {id: id},
        success: function(response){
            $("#global-loader").fadeOut("slow");
            try {
                if(typeof response === 'string'){
                    response = JSON.parse(response);
                }

                if(!response.status){
                    ToastifyError(response.message);
                    return;
                }

                var detalles = response.data;

                // Construir el HTML para mostrar los detalles
                var htmlContent = '<div style="text-align: left; max-height: 500px; overflow-y: auto;">';

                // Información del lote
                htmlContent += '<div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">';
                htmlContent += '<h4 style="margin: 0 0 10px 0; color: #495057;"><i class="fa fa-folder-open"></i> ' + detalles.nombre_lote + '</h4>';
                htmlContent += '<p style="margin: 5px 0;"><strong>Total de contratos:</strong> ' + detalles.total_contratos + '</p>';
                htmlContent += '<p style="margin: 5px 0;"><strong>Total de registros relacionados:</strong> ' + detalles.total_registros_relacionados + '</p>';
                htmlContent += '</div>';

                // Lista de trabajadores y contratos
                htmlContent += '<div style="margin-bottom: 15px;">';
                htmlContent += '<h5 style="color: #dc3545; margin-bottom: 10px;"><i class="fa fa-users"></i> Trabajadores y Contratos a Eliminar:</h5>';

                detalles.contratos.forEach(function(item, index){
                    htmlContent += '<div style="background-color: #fff3cd; padding: 10px; border-left: 4px solid #ffc107; margin-bottom: 10px; border-radius: 3px;">';
                    htmlContent += '<p style="margin: 5px 0;"><strong>' + (index + 1) + '. ' + item.trabajador.nombre + '</strong></p>';
                    htmlContent += '<p style="margin: 5px 0; font-size: 0.9em;">RUT: ' + item.trabajador.rut + '</p>';
                    htmlContent += '<p style="margin: 5px 0; font-size: 0.9em;">Cargo: ' + item.contrato.cargo + '</p>';
                    htmlContent += '<p style="margin: 5px 0; font-size: 0.9em;">Tipo: ' + item.contrato.tipocontrato + '</p>';

                    // Mostrar registros relacionados si existen
                    if(item.total_registros > 0){
                        htmlContent += '<div style="margin-top: 8px; padding: 8px; background-color: #f8d7da; border-radius: 3px;">';
                        htmlContent += '<p style="margin: 0 0 5px 0; font-size: 0.85em; font-weight: bold; color: #721c24;">Registros relacionados (' + item.total_registros + '):</p>';
                        htmlContent += '<ul style="margin: 0; padding-left: 20px; font-size: 0.85em;">';

                        if(item.registros_relacionados.asistencias){
                            htmlContent += '<li>Asistencias: ' + item.registros_relacionados.asistencias + '</li>';
                        }
                        if(item.registros_relacionados.liquidaciones){
                            htmlContent += '<li>Liquidaciones: ' + item.registros_relacionados.liquidaciones + '</li>';
                        }
                        if(item.registros_relacionados.anexos){
                            htmlContent += '<li>Anexos: ' + item.registros_relacionados.anexos + '</li>';
                        }
                        if(item.registros_relacionados.finiquitos){
                            htmlContent += '<li>Finiquitos: ' + item.registros_relacionados.finiquitos + '</li>';
                        }
                        if(item.registros_relacionados.contratosfirmados){
                            htmlContent += '<li>Contratos Firmados: ' + item.registros_relacionados.contratosfirmados + '</li>';
                        }
                        if(item.registros_relacionados.documentos){
                            htmlContent += '<li>Documentos: ' + item.registros_relacionados.documentos + '</li>';
                        }
                        if(item.registros_relacionados.horaspactadas){
                            htmlContent += '<li>Horas Pactadas: ' + item.registros_relacionados.horaspactadas + '</li>';
                        }
                        if(item.registros_relacionados.detallelotes){
                            htmlContent += '<li>Detalle Lotes: ' + item.registros_relacionados.detallelotes + '</li>';
                        }
                        if(item.registros_relacionados.lote2){
                            htmlContent += '<li>Lote 2: ' + item.registros_relacionados.lote2 + '</li>';
                        }
                        if(item.registros_relacionados.lote4){
                            htmlContent += '<li>Lote 4: ' + item.registros_relacionados.lote4 + '</li>';
                        }

                        htmlContent += '</ul>';
                        htmlContent += '</div>';
                    }

                    htmlContent += '</div>';
                });

                htmlContent += '</div>';

                // Advertencia final
                htmlContent += '<div style="background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 12px; border-radius: 5px; margin-top: 15px;">';
                htmlContent += '<p style="margin: 0; color: #721c24; font-weight: bold;"><i class="fa fa-exclamation-triangle"></i> Esta acción eliminará permanentemente:</p>';
                htmlContent += '<ul style="margin: 10px 0 0 20px; color: #721c24;">';
                htmlContent += '<li>' + detalles.total_contratos + ' contrato(s)</li>';
                htmlContent += '<li>' + detalles.total_registros_relacionados + ' registro(s) relacionado(s)</li>';
                htmlContent += '<li>Todos los archivos asociados</li>';
                htmlContent += '</ul>';
                htmlContent += '</div>';

                htmlContent += '</div>';

                // Mostrar modal de confirmación con los detalles
                swal.fire({
                    title: '¿Confirmar Eliminación del Lote?',
                    html: htmlContent,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="fa fa-trash"></i> Sí, Eliminar Todo',
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
                    customClass: {
                        popup: 'swal-wide'
                    },
                    width: '700px'
                }).then((result) => {
                    if(result.isConfirmed){
                        $("#global-loader").fadeIn("slow");

                        // Proceder con la eliminación
                        $.ajax({
                            url: 'php/eliminar/lotecontrato.php',
                            type: 'POST',
                            data: {id: id, confirmado: 'true'},
                            success: function(data){
                                $("#global-loader").fadeOut("slow");
                                try {
                                    if(typeof data === 'string'){
                                        data = JSON.parse(data);
                                    }
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
                            },
                            error: function(){
                                $("#global-loader").fadeOut("slow");
                                ToastifyError('Error en la conexión');
                            }
                        });
                    }
                });

            } catch (error) {
                console.error('Error:', error);
                ToastifyError('Error al obtener detalles del lote');
            }
        },
        error: function(){
            $("#global-loader").fadeOut("slow");
            ToastifyError('Error en la conexión');
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

//Notificaciones Masivas
var cartnot = new Array();

//addcart2(3," . $notificacion->getId() . ",\"" . $notificacion->getRegistro() . "\",\"" . $notificacion->getFechanotificacion() . "\",\"" . $notificacion->getCausal() . "\",\"" . $notificacion->getComunicacion() . "\")
function addcart2(tipo, id, trabajador, fechanotificacion, causal, comunicacion){
    var obj = new Object();
    obj.tipo = tipo;
    obj.id = id;
    obj.trabajador = trabajador;
    obj.fechanotificacion = fechanotificacion;
    obj.causal = causal;
    obj.comunicacion = comunicacion;
    //Validar si existe el objeto
    if(validarobjeto2(id)){
        ToastifyError('El objeto ya existe en la lista');
        return;
    }
    cartnot.push(obj);
    ToastifySuccess('Objeto agregado a la lista');
    console.log(cartnot);
    listarobjectos2();
}

function validarobjeto2(id){
    var existe = false;
    for (var i = 0; i < cartnot.length; i++) {
        if(cartnot[i].id == id){
            existe = true;
        }
    }
    return existe;
}

function listarobjectos2(){
    if(cartnot.length > 0){
    var html = '';
    html += "<div class='col-md-12'>";
    html += "<div class='card'>";
    html += "<div class='card-header d-flex justify-content-between'>";
    html += "<h3 class='card-title'>Notificaciones a imprimir</h3>";
    html += "<div>";
    html += "<button class='btn btn-outline-danger' onclick='cartnot = []; listarobjectos2();'><i class='fa fa-trash'></i>Limpiar lista </button>";
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimir2();'><i class='fa fa-print'></i>Imprimir </button>";
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimirretiro();'><i class='fa fa-print'></i>Retiro Previred </button>";
    html += "</div>";
    html += "</div>";
    html += "<div class='card-body'>";
    html += "<table class='table table-bordered'>";
    html += "<thead>";
    html += "<tr>";
    html += "<th>Tipo</th>";
    html += "<th>Trabajador</th>";
    html += "<th>Fecha Notificacion</th>";
    html += "<th>Comunicacion</th>";
    html += "<th>Eliminar</th>";
    html += "</tr>";
    html += "</thead>";
    html += "<tbody>";
    for (var i = 0; i < cartnot.length; i++) {
        html += '<tr>';
        if(cartnot[i].tipo == 3){
            html += '<td>Notificación</td>';
        }
        html += '<td>'+cartnot[i].trabajador+'</td>';
        html += '<td>'+cartnot[i].fechanotificacion+'</td>';
        html += '<td>'+cartnot[i].comunicacion+'</td>';
        html += '<td><button class="btn btn-outline-danger" onclick="eliminarobjeto2('+i+')"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
    }
    html += "</tbody>";
    html += "</table>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $('.objetos2').html(html);
    }else{
        $('.objetos2').html('');
    }
}

function eliminarobjeto2(id){
    cartnot.splice(id, 1);
    listarobjectos2();
}

function imprimir2(){
    if(cartnot.length > 0){
        window.open('php/report/imprimir2.php?cart='+JSON.stringify(cartnot), '_blank');
    }
}

function imprimirretiro(){
    if(cartnot.length > 0){
        window.open('php/report/retiro.php?cart='+JSON.stringify(cartnot), '_blank');
    }
}

function eliminartodonotificacion(id){
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
                url: 'php/eliminar/masivonotificacion.php',
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

//Documentos Masivos
var cartdoc = new Array();

//addcart3(4," . $object1->getId() . ",\"" . $object1->getEmpresa() . "\",\"" . $object1->getTrabajador() . "\",\"" . $object1->getFechageneracion() . "\",\"" . $object1->getTipodocumento() . "\",\"" . $object1->getDocumento() . "\")

function addcart3(tipo, id, empresa, trabajador, fechageneracion, tipodocumento, documento){
    var obj = new Object();
    obj.tipo = tipo;
    obj.id = id;
    obj.empresa = empresa;
    obj.trabajador = trabajador;
    obj.fechageneracion = fechageneracion;
    obj.tipodocumento = tipodocumento;
    obj.documento = documento;
    //Validar si existe el objeto
    if(validarobjeto3(id)){
        ToastifyError('El objeto ya existe en la lista');
        return;
    }
    cartdoc.push(obj);
    ToastifySuccess('Objeto agregado a la lista');
    console.log(cartdoc);
    listarobjectos3();
}

function validarobjeto3(id){
    var existe = false;
    for (var i = 0; i < cartdoc.length; i++) {
        if(cartdoc[i].id == id){
            existe = true;
        }
    }
    return existe;
}

function listarobjectos3(){
    if(cartdoc.length > 0){
    var html = '';
    html += "<div class='col-md-12'>";
    html += "<div class='card'>";
    html += "<div class='card-header d-flex justify-content-between'>";
    html += "<h3 class='card-title'>Documentos a imprimir</h3>";
    html += "<div>";
    html += "<button class='btn btn-outline-danger' onclick='cartdoc = []; listarobjectos3();'><i class='fa fa-trash'></i>Limpiar lista </button>";
    html += "<button class='ml-2 btn btn-outline-success' onclick='imprimir3();'><i class='fa fa-print'></i>Imprimir </button>";
    html += "</div>";
    html += "</div>";
    html += "<div class='card-body'>";
    html += "<table class='table table-bordered'>";
    html += "<thead>";
    html += "<tr>";
    html += "<th>Tipo</th>";
    html += "<th>RUT</th>";
    html += "<th>Trabajador</th>";
    html += "<th>Tipo Documento</th>";
    html += "<th>Fecha Generacion</th>";
    html += "<th>Eliminar</th>";
    html += "</tr>";
    html += "</thead>";
    html += "<tbody>";
    for (var i = 0; i < cartdoc.length; i++) {
        html += '<tr>';
        if(cartdoc[i].tipo == 4){
            html += '<td>Documento</td>';
        }
        html += '<td>'+cartdoc[i].empresa+'</td>';
        html += '<td>'+cartdoc[i].trabajador+'</td>';
        html += '<td>'+cartdoc[i].tipodocumento+'</td>';
        html += '<td>'+cartdoc[i].fechageneracion+'</td>';
        html += '<td><button class="btn btn-outline-danger" onclick="eliminarobjeto3('+i+')"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
    }
    html += "</tbody>";
    html += "</table>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $('.objetos3').html(html);
    }
    else{
        $('.objetos3').html('');
    }
}

function eliminarobjeto3(id){
    cartdoc.splice(id, 1);
    listarobjectos3();
}

function imprimir3(){
    if(cartdoc.length > 0){
        window.open('php/report/imprimir3.php?cart='+JSON.stringify(cartdoc), '_blank');
    }
}

function eliminartododocumento(id){
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
                url: 'php/eliminar/masivodocumento.php',
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

// ==========================================
// FUNCIONES PARA MODAL DE IMPRESION
// ==========================================

var currentLoteId = null;
var currentPdfUrl = null;

// Abrir modal para imprimir todo el lote
function abrirModalImpresionLote(loteId) {
    currentLoteId = loteId;
    $("#global-loader").fadeIn("slow");

    $.ajax({
        url: 'php/obtener/obtener_trabajadores_lote.php',
        type: 'POST',
        data: { id: loteId },
        success: function(response) {
            $("#global-loader").fadeOut("slow");
            try {
                if(typeof response === 'string') {
                    response = JSON.parse(response);
                }

                if(response.status) {
                    mostrarModalConDatos(response, loteId, 'lote');
                } else {
                    ToastifyError(response.message || 'Error al obtener datos');
                }
            } catch(error) {
                console.error('Error:', error);
                ToastifyError('Error al procesar la respuesta');
            }
        },
        error: function() {
            $("#global-loader").fadeOut("slow");
            ToastifyError('Error en la conexión');
        }
    });
}

// Abrir modal para imprimir seleccion del carrito
function abrirModalImpresionCarrito() {
    if(cart.length == 0) {
        ToastifyError('No hay contratos seleccionados');
        return;
    }

    $("#global-loader").fadeIn("slow");

    $.ajax({
        url: 'php/obtener/obtener_trabajadores_lote.php',
        type: 'POST',
        data: { cart: JSON.stringify(cart) },
        success: function(response) {
            $("#global-loader").fadeOut("slow");
            try {
                if(typeof response === 'string') {
                    response = JSON.parse(response);
                }

                if(response.status) {
                    mostrarModalConDatos(response, null, 'carrito');
                } else {
                    ToastifyError(response.message || 'Error al obtener datos');
                }
            } catch(error) {
                console.error('Error:', error);
                ToastifyError('Error al procesar la respuesta');
            }
        },
        error: function() {
            $("#global-loader").fadeOut("slow");
            ToastifyError('Error en la conexión');
        }
    });
}

// Mostrar modal con los datos
function mostrarModalConDatos(data, loteId, tipo) {
    // Actualizar contador
    $('#totalTrabajadoresModal').text(data.total);

    // Construir HTML del panel izquierdo
    var htmlTrabajadores = '';

    // Resumen de documentos agregados y no agregados
    htmlTrabajadores += '<div class="alert alert-info p-2 mb-3" style="font-size: 0.85rem;">';
    htmlTrabajadores += '<i class="fa fa-info-circle mr-1"></i><strong>Resumen de impresión:</strong>';
    htmlTrabajadores += '</div>';

    // Documentos que SÍ se agregarán (normales)
    if(data.contratos_normales > 0) {
        htmlTrabajadores += '<div class="alert alert-success p-2 mb-2" style="font-size: 0.8rem;">';
        htmlTrabajadores += '<i class="fa fa-check-circle mr-1"></i><strong>' + data.contratos_normales + '</strong> contrato(s) con documento PDF';
        htmlTrabajadores += '</div>';
    }

    // Documentos que NO se agregarán (express)
    if(data.contratos_express > 0) {
        htmlTrabajadores += '<div class="alert alert-warning p-2 mb-3" style="font-size: 0.8rem;">';
        htmlTrabajadores += '<i class="fa fa-exclamation-triangle mr-1"></i><strong>' + data.contratos_express + '</strong> contrato(s) Express <span class="text-muted">(sin documento)</span>';
        htmlTrabajadores += '</div>';
    }

    // Separador
    htmlTrabajadores += '<hr class="my-2">';

    // Sección de contratos que SÍ se imprimirán
    if(data.contratos_normales > 0) {
        htmlTrabajadores += '<h6 class="text-success mb-2" style="font-size: 0.85rem;"><i class="fa fa-print mr-1"></i>Se imprimirán:</h6>';
        data.trabajadores.forEach(function(trab, index) {
            if(!trab.es_express) {
                htmlTrabajadores += '<div class="card mb-2 border-success" style="border-left: 4px solid;">';
                htmlTrabajadores += '<div class="card-body p-2">';
                htmlTrabajadores += '<p class="mb-1 font-weight-bold text-dark" style="font-size: 0.8rem;"><i class="fa fa-check text-success mr-1"></i>' + trab.nombre + '</p>';
                htmlTrabajadores += '<p class="mb-0 text-muted" style="font-size: 0.7rem;"><i class="fa fa-file-contract mr-1"></i>' + trab.contrato + '</p>';
                htmlTrabajadores += '</div>';
                htmlTrabajadores += '</div>';
            }
        });
    }

    // Sección de contratos que NO se imprimirán (express)
    if(data.contratos_express > 0) {
        htmlTrabajadores += '<hr class="my-2">';
        htmlTrabajadores += '<h6 class="text-warning mb-2" style="font-size: 0.85rem;"><i class="fa fa-ban mr-1"></i>No se imprimirán (Express):</h6>';
        data.trabajadores.forEach(function(trab) {
            if(trab.es_express) {
                htmlTrabajadores += '<div class="card mb-2 border-warning" style="border-left: 4px solid; opacity: 0.8;">';
                htmlTrabajadores += '<div class="card-body p-2">';
                htmlTrabajadores += '<p class="mb-1 font-weight-bold text-muted" style="font-size: 0.8rem;"><i class="fa fa-times text-warning mr-1"></i>' + trab.nombre + '</p>';
                htmlTrabajadores += '<p class="mb-0 text-muted" style="font-size: 0.7rem;"><i class="fa fa-file-contract mr-1"></i>' + trab.contrato + '</p>';
                htmlTrabajadores += '<span class="badge badge-warning" style="font-size: 0.65rem;">Sin documento PDF</span>';
                htmlTrabajadores += '</div>';
                htmlTrabajadores += '</div>';
            }
        });
    }

    $('#listaTrabajadoresModal').html(htmlTrabajadores);

    // Resumen
    var resumen = 'Contratos Normales: ' + data.contratos_normales + ' | Contratos Express: ' + data.contratos_express;
    $('#resumenContratosModal').text(resumen);

    // Verificar si todos son express
    if(data.todos_express) {
        // Mostrar mensaje de que no hay documentos
        $('#pdfViewerContainer').hide();
        $('#mensajeExpressContainer').show();
        $('#btnImprimirModal').prop('disabled', true).addClass('btn-secondary').removeClass('btn-success');

        // Mostrar detalle de contratos express
        var htmlDetalle = '<ul class="list-unstyled mb-0">';
        data.trabajadores.forEach(function(trab) {
            htmlDetalle += '<li class="mb-2"><i class="fa fa-user text-warning mr-2"></i>' + trab.nombre + ' - <small class="text-muted">' + trab.contrato + '</small></li>';
        });
        htmlDetalle += '</ul>';
        $('#detalleContratosExpress').html(htmlDetalle);

        currentPdfUrl = null;
    } else {
        // Mostrar PDF
        $('#mensajeExpressContainer').hide();
        $('#pdfViewerContainer').show();
        $('#btnImprimirModal').prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');

        // Cargar PDF
        if(tipo === 'lote') {
            currentPdfUrl = 'php/report/impresioncontratos.php?id=' + loteId;
        } else {
            currentPdfUrl = 'php/report/imprimir.php?cart=' + encodeURIComponent(JSON.stringify(cart));
        }

        $('#pdfViewer').attr('src', currentPdfUrl);
    }

    // Mostrar modal
    $('#modalImpresionContratos').modal('show');
}

// Imprimir desde el modal
function imprimirDesdeModal() {
    if(currentPdfUrl) {
        window.open(currentPdfUrl, '_blank');
    }
}

// Funcion modificada para usar el modal (reemplaza la redirección)
function imprimirTodoLoteModal(loteId) {
    abrirModalImpresionLote(loteId);
}

// Funcion modificada para imprimir carrito con modal
function imprimirConModal() {
    if(cart.length > 0) {
        abrirModalImpresionCarrito();
    } else {
        ToastifyError('No hay contratos seleccionados');
    }
}

