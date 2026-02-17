 var trabajadores = new Array();

function agregartrabajador(id, rut, nombre,contrato) {
    if(!validatrabajador(id)){
        ToastifyError("Ya existe un trabajador con ese id");
        return false;
    }
    var trabajador = new Object();
    trabajador.id = id;
    trabajador.rut = rut;
    trabajador.nombre = nombre;
    trabajador.contrato = contrato;
    trabajadores.push(trabajador);
    gettrabajadores();
}

function allwork(){
    $.ajax({
        url: "php/cargar/trabajadoresactivos.php",
        success: function (response) {
            try {
                var json = JSON.parse(response);
                json.forEach(element => {
                    agregartrabajador(element.id, element.rut, element.nombre,element.contrato);
                });
            } catch (error) {
                console.log(error);
                ToastifyError("Error al cargar los trabajadores");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
}

function validatrabajador(id) {
    for (var i = 0; i < trabajadores.length; i++) {
        if (trabajadores[i].id == id) {
            return false;
        }
    }
    return true;
}

function eliminatrabajador(id) {
    for (var i = 0; i < trabajadores.length; i++) {
        if (trabajadores[i].id == id) {
            trabajadores.splice(i, 1);
        }
    }
    gettrabajadores();
}

function gettrabajadores() {
    var html = "";
    for (var i = 0; i < trabajadores.length; i++) {
        html += "<tr>";
        html += "<td>" + trabajadores[i].rut + "</td>";
        html += "<td>" + trabajadores[i].nombre + "</td>";
        html += "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"eliminatrabajador(" + trabajadores[i].id + ")\"><i class=\"fas fa-trash-alt\"></i></button></td>";
        html += "</tr>";
    }
    $("#lotes").html(html);
}

//Revisar si la lista esta vacia
function validalista(){
    if(trabajadores.length==0){
        return false;
    }
    return true;
}

function Eliminartodo(){
    trabajadores = new Array();
    gettrabajadores();
}

// Variable global para almacenar las liquidaciones procesadas
var liquidacionesProcesadas = [];
var liquidacionActualIndex = -1;

function procesartodo(){
    var periodo = $("#periodo").val();
    var gratificacion = 0;

    if($("#gratificacion").is(':checked')){
        gratificacion = 1;
    }
    if(periodo.trim().length==0){
        ToastifyError("Debe seleccionar un periodo");
        return false;
    }
    if(!validalista()){
        ToastifyError("No hay trabajadores para procesar");
        return false;
    }

    // Mostrar overlay de procesamiento
    mostrarOverlayProcesamiento();

    // Llamar al endpoint AJAX
    $.ajax({
        url: "php/cargar/procesarliquidaciones.php",
        type: "POST",
        data: {
            trabajadores: JSON.stringify(trabajadores),
            periodo: periodo,
            gratificacion: gratificacion
        },
        success: function(response) {
            ocultarOverlayProcesamiento();
            try {
                var data = typeof response === 'string' ? JSON.parse(response) : response;
                if(data.success) {
                    liquidacionesProcesadas = data.liquidaciones;
                    mostrarModalLiquidaciones(data);
                    // Actualizar KPI de procesados
                    var kpiProcesados = document.getElementById('kpi-procesados');
                    if(kpiProcesados) {
                        kpiProcesados.textContent = data.total_procesados;
                    }
                    // Limpiar bandeja
                    Eliminartodo();
                    ToastifySuccess("Se procesaron " + data.total_procesados + " liquidaciones");
                } else {
                    ToastifyError(data.error || "Error al procesar liquidaciones");
                }
            } catch(e) {
                console.error(e);
                ToastifyError("Error al procesar la respuesta del servidor");
            }
        },
        error: function(xhr, status, error) {
            ocultarOverlayProcesamiento();
            console.error(xhr, status, error);
            ToastifyError("Error de conexion al procesar liquidaciones");
        }
    });
}

function mostrarOverlayProcesamiento() {
    var overlay = document.createElement('div');
    overlay.id = 'processing-overlay';
    overlay.className = 'processing-overlay';
    overlay.innerHTML = `
        <div class="spinner"></div>
        <div class="text">Procesando liquidaciones...</div>
        <div class="progress-text">Por favor espere</div>
    `;
    document.body.appendChild(overlay);
}

function ocultarOverlayProcesamiento() {
    var overlay = document.getElementById('processing-overlay');
    if(overlay) {
        overlay.remove();
    }
}

function mostrarModalLiquidaciones(data) {
    // Actualizar header del modal
    $('#modal-periodo-info').text('Periodo: ' + (data.liquidaciones[0]?.periodo || ''));
    $('#modal-stats').text(data.total_procesados + ' liquidaciones procesadas');
    $('#count-trabajadores').text(data.total_procesados);
    $('#footer-info').text('Empresa: ' + data.empresa.razon_social + ' | RUT: ' + data.empresa.rut);

    // Generar lista de trabajadores
    var listaHtml = '';
    data.liquidaciones.forEach(function(liq, index) {
        var yaExisteClass = liq.ya_existe ? 'ya-existe' : '';
        var yaExisteBadge = liq.ya_existe ? '<span class="badge-warning-subtle">Ya existia</span>' : '';
        listaHtml += `
            <div class="trabajador-item ${yaExisteClass}" onclick="seleccionarTrabajador(${index})" data-index="${index}" data-nombre="${liq.nombre.toLowerCase()}">
                <div class="trabajador-info">
                    <div class="trabajador-nombre">${liq.nombre}</div>
                    <div class="trabajador-rut text-muted">${liq.rut} ${yaExisteBadge}</div>
                </div>
                <div class="trabajador-liquido">$${formatearNumero(liq.liquido)}</div>
            </div>
        `;
    });
    $('#lista-trabajadores-modal').html(listaHtml);

    // Resetear vista de detalle
    $('#estado-inicial').show();
    $('#liquidacion-content').hide();
    $('#detalle-header').hide();
    liquidacionActualIndex = -1;

    // Mostrar modal
    $('#modalLiquidaciones').modal('show');

    // Si solo hay una liquidacion, seleccionarla automaticamente
    if(data.liquidaciones.length === 1) {
        seleccionarTrabajador(0);
    }
}

function seleccionarTrabajador(index) {
    liquidacionActualIndex = index;
    var liq = liquidacionesProcesadas[index];

    // Actualizar clase activa en la lista
    $('.trabajador-item').removeClass('active');
    $(`.trabajador-item[data-index="${index}"]`).addClass('active');

    // Actualizar header del detalle
    $('#detalle-nombre-trabajador').text(liq.nombre);
    $('#detalle-rut-trabajador').text('RUT: ' + liq.rut + ' | Centro de Costo: ' + liq.centro_costo);
    $('#detalle-header').show();

    // Generar contenido de la liquidacion
    var contenidoHtml = generarContenidoLiquidacion(liq);
    $('#liquidacion-content').html(contenidoHtml);

    // Mostrar contenido y ocultar estado inicial
    $('#estado-inicial').hide();
    $('#liquidacion-content').show();
}

function generarContenidoLiquidacion(liq) {
    var html = '';

    // Informacion general
    html += `
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Periodo</div>
                <div class="value">${liq.periodo}</div>
            </div>
            <div class="info-item">
                <div class="label">Dias Trabajados</div>
                <div class="value">${liq.dias}</div>
            </div>
            <div class="info-item">
                <div class="label">Horas Extras</div>
                <div class="value">${liq.horas_extras}</div>
            </div>
            <div class="info-item">
                <div class="label">Cargas Familiares</div>
                <div class="value">${liq.cargas}</div>
            </div>
            <div class="info-item">
                <div class="label">AFP</div>
                <div class="value">${liq.afp} (${liq.afp_tasa}%)</div>
            </div>
            <div class="info-item">
                <div class="label">Salud</div>
                <div class="value">${liq.isapre} (${liq.desc_salud})</div>
            </div>
        </div>
    `;

    // Haberes Imponibles
    html += `<div class="liquidacion-card">
        <div class="liquidacion-card-header">
            <span><i class="fa fa-plus-circle mr-2 text-success"></i>Haberes Imponibles</span>
            <span class="text-success font-weight-bold">$${formatearNumero(liq.total_imponible)}</span>
        </div>
        <div class="liquidacion-card-body">`;

    liq.haberes.forEach(function(haber) {
        if(haber.tipo === 1) {
            html += `<div class="liquidacion-row">
                <span class="codigo">${haber.codigo}</span>
                <span class="valor">$${formatearNumero(haber.valor)}</span>
            </div>`;
        }
    });
    html += `</div></div>`;

    // Haberes No Imponibles
    if(liq.total_no_imponible > 0) {
        html += `<div class="liquidacion-card">
            <div class="liquidacion-card-header">
                <span><i class="fa fa-plus-circle mr-2 text-info"></i>Haberes No Imponibles</span>
                <span class="text-info font-weight-bold">$${formatearNumero(liq.total_no_imponible)}</span>
            </div>
            <div class="liquidacion-card-body">`;

        liq.haberes.forEach(function(haber) {
            if(haber.tipo === 2) {
                html += `<div class="liquidacion-row">
                    <span class="codigo">${haber.codigo}</span>
                    <span class="valor">$${formatearNumero(haber.valor)}</span>
                </div>`;
            }
        });
        html += `</div></div>`;
    }

    // Descuentos Legales
    html += `<div class="liquidacion-card">
        <div class="liquidacion-card-header">
            <span><i class="fa fa-minus-circle mr-2 text-danger"></i>Descuentos Legales</span>
            <span class="text-danger font-weight-bold">-$${formatearNumero(liq.total_descuentos_legales)}</span>
        </div>
        <div class="liquidacion-card-body">`;

    liq.descuentos_legales.forEach(function(desc) {
        html += `<div class="liquidacion-row">
            <span class="codigo">${desc.codigo}</span>
            <span class="valor">$${formatearNumero(desc.valor)}</span>
        </div>`;
    });
    html += `</div></div>`;

    // Descuentos No Legales
    if(liq.total_descuentos_no_legales > 0) {
        html += `<div class="liquidacion-card">
            <div class="liquidacion-card-header">
                <span><i class="fa fa-minus-circle mr-2 text-warning"></i>Otros Descuentos</span>
                <span class="text-warning font-weight-bold">-$${formatearNumero(liq.total_descuentos_no_legales)}</span>
            </div>
            <div class="liquidacion-card-body">`;

        liq.descuentos_no_legales.forEach(function(desc) {
            html += `<div class="liquidacion-row">
                <span class="codigo">${desc.codigo}</span>
                <span class="valor">$${formatearNumero(desc.valor)}</span>
            </div>`;
        });
        html += `</div></div>`;
    }

    // Resumen
    html += `
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="info-item" style="background: #d4edda;">
                    <div class="label text-success">Total Haberes</div>
                    <div class="value text-success">$${formatearNumero(liq.total_imponible + liq.total_no_imponible)}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item" style="background: #f8d7da;">
                    <div class="label text-danger">Total Descuentos</div>
                    <div class="value text-danger">$${formatearNumero(liq.total_descuentos_legales + liq.total_descuentos_no_legales)}</div>
                </div>
            </div>
        </div>
    `;

    // Liquido
    html += `
        <div class="liquidacion-total">
            <span class="label"><i class="fa fa-money-bill-wave mr-2"></i>LIQUIDO A PAGAR</span>
            <span class="amount">$${formatearNumero(liq.liquido)}</span>
        </div>
    `;

    // Aviso si ya existia
    if(liq.ya_existe) {
        html += `
            <div class="alert alert-warning mt-3" style="border-radius: 10px;">
                <i class="fa fa-exclamation-triangle mr-2"></i>
                Esta liquidacion ya existia en el sistema. No se crearon registros duplicados.
            </div>
        `;
    }

    return html;
}

function formatearNumero(numero) {
    return Math.round(numero).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function imprimirLiquidacionActual() {
    if(liquidacionActualIndex < 0) {
        ToastifyError("Seleccione un trabajador primero");
        return;
    }
    var liq = liquidacionesProcesadas[liquidacionActualIndex];
    if(liq.liquidacion_id) {
        window.open('php/report/liquidacion.php?id=' + liq.liquidacion_id, '_blank');
    } else {
        ToastifyError("No se puede imprimir esta liquidacion");
    }
}

function imprimirTodasLiquidaciones() {
    if(liquidacionesProcesadas.length === 0) {
        ToastifyError("No hay liquidaciones para imprimir");
        return;
    }

    // Obtener todos los IDs de liquidaciones
    var ids = liquidacionesProcesadas.map(function(liq) {
        return liq.liquidacion_id;
    }).filter(function(id) {
        return id > 0;
    });

    if(ids.length === 0) {
        ToastifyError("No hay liquidaciones validas para imprimir");
        return;
    }

    // Abrir en nueva ventana con los IDs
    window.open('php/report/liquidacionesmultiples.php?ids=' + ids.join(','), '_blank');
}

// Buscador de trabajadores en el modal
$(document).ready(function() {
    $(document).on('input', '#buscar-trabajador-modal', function() {
        var busqueda = $(this).val().toLowerCase();
        $('.trabajador-item').each(function() {
            var nombre = $(this).data('nombre');
            if(nombre.indexOf(busqueda) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

function filtrartrabajadores(){
    var centrocosto = $("#centrocosto").val();
    $.ajax({
        url: "php/cargar/trabajadorescentro.php",
        data: {centrocosto:centrocosto},
        type: "POST",
        success: function (response) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
}

function limpiarfiltro(){
    var centrocosto = $("#centrocosto").val();
    $.ajax({
        url: "php/eliminar/trabajadorescentro.php",
        type: "POST",
        success: function (response) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
}