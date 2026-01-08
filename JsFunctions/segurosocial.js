// ===========================
// SEGURO SOCIAL - CRUD UNIFICADO
// Maneja los 3 formularios: Expectativa de Vida, Rentabilidad Protegida y SIS
// ===========================

// Variable global para identificar qué tabla se está utilizando
let tablaActual = '';

// Plugin para DataTables: ordenar por atributo data-order
$.fn.dataTable.ext.order['dom-data-order'] = function(_settings, col) {
    return this.api().column(col, {order:'index'}).nodes().map(function(td) {
        return $(td).attr('data-order') || '';
    });
};

// Detectar en qué página estamos
$(document).ready(function(){
    // Determinar la tabla según la URL de la página
    const currentPage = window.location.pathname.split('/').pop();

    if(currentPage === 'segurosocial_expectativadevida.php'){
        tablaActual = 'expectativadevida';
    } else if(currentPage === 'segurosocial_rentabilidadprotegida.php'){
        tablaActual = 'rentabilidadprotegida';
    } else if(currentPage === 'segurosocial_sis.php'){
        tablaActual = 'sis';
    }

    // Verificar que estamos en una página válida
    if(tablaActual !== ''){
        // Cargar datos al iniciar
        listarRegistros();

        // Manejar el envío del formulario
        $("#RegisForm").on("submit", function(e){
            e.preventDefault();
            registrar();
        });
    }
});

// ===========================
// FUNCIÓN PARA REGISTRAR
// ===========================
function registrar(){
    $("#global-loader").show();

    var codigo = $("#Codigo").val();
    var codigoPrevired = $("#CodigoPrevired").val();
    var periodo = $("#periodo").val();
    var tasa = $("#tasa").val();

    // Validar campos requeridos
    if(periodo === "" || tasa === ""){
        $("#global-loader").hide();
        ToastifyError("Debe completar los campos requeridos (Periodo y Tasa)");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "php/insert/segurosocial.php",
        data: {
            tabla: tablaActual,
            codigo: codigo,
            codigoPrevired: codigoPrevired,
            fecha: periodo,
            tasa: tasa
        },
        success: function(data){
            $("#global-loader").hide();
            if(data == 1 || data == "1"){
                ToastifySuccess("Registro insertado correctamente");
                // Limpiar formulario
                $("#Codigo").val('');
                $("#CodigoPrevired").val('');
                $("#tasa").val('');
                // Recargar tabla en tiempo real
                listarRegistros();
            }else{
                ToastifyError("Error al Registrar: " + data);
            }
        },
        error: function(){
            $("#global-loader").hide();
            ToastifyError("Error de conexión al registrar");
        }
    });
}

// ===========================
// FUNCIÓN PARA LISTAR REGISTROS EN TIEMPO REAL
// ===========================
function listarRegistros(){
    $.ajax({
        type: "POST",
        url: "php/listar/segurosocial.php",
        data: { tabla: tablaActual },
        success: function(data){
            // Destruir DataTable si existe
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().clear().destroy();
            }

            // Actualizar el contenido del tbody
            $("#example1 tbody").html(data);

            // Verificar si hay filas en la tabla antes de inicializar DataTable
            var rowCount = $('#example1 tbody tr').length;

            // Solo inicializar DataTable si hay al menos una fila con datos válidos
            if(rowCount > 0 && !data.includes('No hay registros')) {
                // Reinicializar DataTable
                $('#example1').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
                    "responsive": true,
                    "autoWidth": false,
                    "order": [[2, "desc"]], // Ordenar por fecha (columna 2) descendente
                    "pageLength": 10,
                    "retrieve": true,
                    "columnDefs": [
                        {
                            "targets": [0, 1, 2, 3], // Columnas con data-order
                            "orderDataType": "dom-data-order" // Usar data-order para ordenar
                        }
                    ]
                });
            } else if(rowCount === 0) {
                // Mostrar mensaje cuando no hay datos
                $("#example1 tbody").html('<tr><td colspan="5" class="text-center text-muted py-4"><i class="fe fe-inbox"></i> No hay registros disponibles</td></tr>');
            }
        },
        error: function(){
            ToastifyError("Error al cargar los registros");
        }
    });
}

// ===========================
// FUNCIÓN PARA ABRIR MODAL DE EDICIÓN
// ===========================
function Editar(id){
    $("#global-loader").show();

    $.ajax({
        type: "POST",
        url: "php/listar/segurosocial.php",
        data: {
            tabla: tablaActual,
            id: id,
            accion: 'obtener_uno'
        },
        dataType: 'json',
        success: function(data){
            $("#global-loader").hide();

            if(data){
                // Crear modal de edición dinámicamente
                const modalHTML = `
                <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Registro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="edit_id" value="${data.id}">
                                <div class="form-group">
                                    <label>Codigo (LRM)</label>
                                    <input type="text" class="form-control" id="edit_codigo" value="${data.codigo || ''}">
                                </div>
                                <div class="form-group">
                                    <label>Codigo (PREVIRED)</label>
                                    <input type="text" class="form-control" id="edit_codigoPrevired" value="${data.codigoprevired || ''}">
                                </div>
                                <div class="form-group">
                                    <label>Periodo</label>
                                    <input type="month" class="form-control" id="edit_periodo" value="${data.periodo}" required>
                                </div>
                                <div class="form-group">
                                    <label>Tasa</label>
                                    <input type="text" class="form-control" id="edit_tasa" value="${data.tasa}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="Actualizar()">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                // Remover modal anterior si existe
                $('#modalEditar').remove();

                // Agregar y mostrar modal
                $('body').append(modalHTML);
                $('#modalEditar').modal('show');
            }
        },
        error: function(){
            $("#global-loader").hide();
            ToastifyError("Error al cargar los datos para editar");
        }
    });
}

// ===========================
// FUNCIÓN PARA ACTUALIZAR REGISTRO
// ===========================
function Actualizar(){
    $("#global-loader").show();

    var id = $("#edit_id").val();
    var codigo = $("#edit_codigo").val();
    var codigoPrevired = $("#edit_codigoPrevired").val();
    var periodo = $("#edit_periodo").val();
    var tasa = $("#edit_tasa").val();

    if(periodo === "" || tasa === ""){
        $("#global-loader").hide();
        ToastifyError("Debe completar los campos requeridos");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "php/update/segurosocial.php",
        data: {
            tabla: tablaActual,
            id: id,
            codigo: codigo,
            codigoPrevired: codigoPrevired,
            fecha: periodo,
            tasa: tasa
        },
        success: function(data){
            $("#global-loader").hide();
            if(data == 1 || data == "1"){
                ToastifySuccess("Registro actualizado correctamente");
                $('#modalEditar').modal('hide');
                // Recargar tabla en tiempo real
                listarRegistros();
            }else{
                ToastifyError("Error al actualizar: " + data);
            }
        },
        error: function(){
            $("#global-loader").hide();
            ToastifyError("Error de conexión al actualizar");
        }
    });
}

// ===========================
// FUNCIÓN PARA ELIMINAR
// ===========================
function Eliminar(id){
    swal.fire({
        title: "¿Estás seguro?",
        text: "Una vez eliminado no se podrá recuperar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $("#global-loader").show();

            $.ajax({
                type: "POST",
                url: "php/eliminar/segurosocial.php",
                data: {
                    tabla: tablaActual,
                    id: id
                },
                success: function(data){
                    $("#global-loader").hide();
                    if(data == 1 || data == "1"){
                        ToastifySuccess("Registro eliminado correctamente");
                        // Recargar tabla en tiempo real
                        listarRegistros();
                    }else{
                        ToastifyError("Error al eliminar: " + data);
                    }
                },
                error: function(){
                    $("#global-loader").hide();
                    ToastifyError("Error de conexión al eliminar");
                }
            });
        }
    });
}
