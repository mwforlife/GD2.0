//Inicializacion del editor de documentos
tinymce.init({
    selector: '#editorContent',
    plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [{
        value: 'First.Name',
        title: 'First Name'
    },
    {
        value: 'Email',
        title: 'Email'
    },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
});

//Inicializar el editor de TinyMCE
tinymce.init({
    selector: '#templateContent',
    plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [{
        value: 'First.Name',
        title: 'First Name'
    },
    {
        value: 'Email',
        title: 'Email'
    },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
});


//Limpiar el editor al cargar la pagina
$(document).ready(function () {
    window.onload = function () {
        setTimeout(function () {
            cerrar();
        }, 1000);
    }
});

//Cerrar notificaciones de TinyMCE
function cerrar() {
    $(".tox-notifications-container").addClass("d-none");
    $(".tox tox-silver-sink tox-tinymce-aux").addClass("d-none");
}

// Function to insert text at the cursor position in TinyMCE editor
function ingresartexto(texto) {
    tinymce.activeEditor.execCommand('mceInsertContent', false, texto);
}

//Function to insert text in a Specific TinyMCE editor
function insertarTextoEnEditor(editorId, texto) {
    const editor = tinymce.get(editorId);
    if (editor) {
        editor.execCommand('mceInsertContent', false, texto);
    } else {
        console.error(`Editor with ID ${editorId} not found`);
    }
}

//Function to receive text from TinyMCE editor
function recibirtexto() {
    return tinymce.activeEditor.getContent();
}

//Limpiar el editor de TinyMCE
function limpiarEditor() {
    tinymce.activeEditor.setContent('');
}


/************************************************************************************************** */
// Global variables
let selectedMandatarios = [];
let currentEditingTemplate = null;
let currentDocument = {
    type: null,
    template: null,
    content: '',
    mandatarios: [],
    montoArriendo: 0
};

// Document ready
$(document).ready(function () {
    initializeComponents();
    loadInitialData();
    bindEvents();
});

// Initialize components
function initializeComponents() {
    // Initialize DataTables
    $('#templatesTable').DataTable({
        language: {
            url: 'JsFunctions/Spanish.json'
        },
        pageLength: 10,
        responsive: true
    });

    $('#generatedTable').DataTable({
        language: {
            url: 'JsFunctions/Spanish.json'
        },
        pageLength: 10,
        responsive: true,
        order: [
            [3, 'desc']
        ] // Order by date desc
    });

    // Initialize Select2
    $('#selectUsuario').select2({
        placeholder: 'Buscar usuario...',
        allowClear: true,
        dropdownParent: $('#addMandatarioModal')
    });
}

// Load initial data
function loadInitialData() {
    loadStats();
    loadUsuarios();
    loadPlantillas();
    loadDocuments();
}

// Bind events
function bindEvents() {
    // Document type change
    $('#documentType').on('change', function () {
        const type = $(this).val();
        const categoria = $(this).find('option:selected').data('type');
        currentDocument.type = categoria;
        resetEditor();
        if (type) {
            loadTemplatesByType(type);
            $('#templateBase').prop('disabled', false);

            // Show/hide monto arriendo for contract types
            if (categoria === 'contrato_arriendo') {
                $('#montoArriendoContainer').show();
            } else {
                $('#montoArriendoContainer').hide();
                $('#montoArriendo').val('');
            }
        } else {
            $('#templateBase').prop('disabled', true).empty().append('<option value="">Seleccionar plantilla...</option>');
            $('#montoArriendoContainer').hide();
            resetEditor();
        }
    });

    // Template change
    $('#templateBase').on('change', function () {
        const templateId = $(this).val();
        if (templateId) {
            loadTemplateContent(templateId);
        } else {
            resetEditor();
        }
    });

    // Monto arriendo change
    $('#montoArriendo').on('input', function () {
        currentDocument.montoArriendo = $(this).val();
        updateDocumentPreview();
    });

    // Editor content change
    $('#editorContent').on('input', function () {
        currentDocument.content = $(this).html();
        $('#saveDocumentBtn').prop('disabled', false);
        updatePreviewButtons();
    });


    // Variable insertion
    $(document).on('click', '.variable-item', function () {
        const variable = $(this).data('variable');
        insertVariableAtCursor(variable);
    });

    // Mandatario management
    $('#addMandatarioBtn').on('click', function () {
        $('#addMandatarioModal').modal('show');
    });

    $('#selectUsuario').on('change', function () {
        const userId = $(this).val();
        if (userId) {
            loadUserData(userId);
        } else {
            clearUserData();
        }
    });

    $('#saveMandatarioBtn').on('click', function () {
        saveMandatario();
    });

    // Template management
    $('#createTemplateBtn').on('click', function () {
        openTemplateModal();
    });

    $('#saveTemplateBtn').on('click', function () {
        saveTemplate();
    });

    // Document actions
    $('#newDocumentBtn').on('click', function () {
        newDocument();
    });

    $('#saveDocumentBtn').on('click', function () {
        saveDocument();
    });

    $('#previewDocumentBtn').on('click', function () {
        previewDocument();
    });

    $('#generateDocumentBtn').on('click', function () {
        generateDocument();
    });
    $("#downloadPdfBtn").on('click', function () {
        $("#previewModal").modal('hide');
        generateDocument();
    });

    // Filter actions
    $('#filterGeneratedBtn').on('click', function () {
        $('#filterModal').modal('show');
    });

    $('#applyFiltersBtn').on('click', function () {
        applyFilters();
    });

    $('#clearFiltersBtn').on('click', function () {
        clearFilters();
    });
}

// Load usuarios
function loadUsuarios() {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'listar_usuarios'
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const select = $('#selectUsuario');
                select.empty().append('<option value="">Seleccionar usuario...</option>');

                response.data.forEach(function (user) {
                    select.append(`<option value="${user.id}">${user.rut} - ${user.nombre} ${user.apellidos}</option>`);
                });
            }
        },
        error: function () {
            showError('Error al cargar la lista de usuarios');
        }
    });
}

// Load plantillas by type
function loadTemplatesByType(type) {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'listar_plantillas_por_tipo',
            tipo: type
        },
        dataType: 'json',
        success: function (response) {
            const select = $('#templateBase');
            select.empty().append('<option value="">Seleccionar plantilla...</option>');

            if (response.success && response.data.length > 0) {
                response.data.forEach(function (template) {
                    select.append(`<option value="${template.id}">${template.nombre}</option>`);
                });
            }
        },
        error: function () {
            showError('Error al cargar las plantillas');
        }
    });
}

//Load templates
function loadPlantillas() {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'listar_plantillas'
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                //Destroy existing DataTable if it exists
                if ($.fn.DataTable.isDataTable('#templatesTable')) {
                    $('#templatesTable').DataTable().clear().destroy();
                }

                //Add templates to DataTable
                const table = $('#templatesTable').DataTable({
                    language: {
                        url: 'JsFunctions/Spanish.json'
                    },
                    pageLength: 10,
                    responsive: true
                });
                table.clear().draw();
                response.data.forEach(function (template) {
                    let estado = template.estado === 'Activo' ? 'Activo' : 'Inactivo';
                    let estadoClass = template.estado === 'Activo' ? 'bg-success' : 'bg-danger';
                    let textbuttondelete = "";
                    if (template.estado === 'Activo') {
                        textbuttondelete = `<button class="btn btn-outline-danger btn-sm" onclick="deleteTemplate(${template.id})" title="Eliminar"><i class="fas fa-trash"></i></button>`;
                    }
                    table.row.add([
                        `<div>
                            <strong>${template.tipo_nombre}</strong>
                            <br>
                            <small class="text-muted">ID: ${template.id}</small>
                        </div>`,
                        template.nombre,
                        `<span class="badge bg-info badge-custom">${template.categoria}</span>`,
                        template.ultima_modificacion,
                        `<span class="badge ${estadoClass}">${estado}</span>`,
                        `<button class="btn btn-outline-primary btn-sm" onclick="editTemplate(${template.id})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="previewTemplate(${template.id})" title="Vista previa">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="duplicateTemplate(${template.id})" title="Duplicar">
                            <i class="fas fa-copy"></i>
                        </button>
                        ${textbuttondelete}
                         `
                    ]).draw();

                });

            }
        }
    });
}

// Load documents
function loadDocuments() {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'listar_documentos_generados'
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Destroy existing DataTable if it exists
                if ($.fn.DataTable.isDataTable('#generatedTable')) {
                    $('#generatedTable').DataTable().clear().destroy();
                }
                // Add documents to DataTable
                const table = $('#generatedTable').DataTable({
                    language: {
                        url: 'JsFunctions/Spanish.json'
                    },
                    pageLength: 10,
                    responsive: true
                });
                table.clear().draw();
                
                response.data.forEach(function (doc) {
                    // Procesar mandatarios
                    let mandatariosHTML = '';
                    let mandatarios = doc.mandatarios || [];
                    
                    if (Array.isArray(mandatarios) && mandatarios.length > 0) {
                        // Si hay mandatarios, mostrarlos
                        mandatariosHTML = mandatarios.map(m => 
                            `<span class="badge bg-success mb-1">${m.nombre}</span>`
                        ).join(' ');
                    } else {
                        // Si no hay mandatarios, mostrar "No aplica"
                        mandatariosHTML = '<span class="badge bg-info">No aplica</span>';
                    }
                        
                    table.row.add([
                        `<div>
                            <strong>${doc.titulo}</strong>
                            <br>
                            <small class="text-muted">ID: ${doc.id}</small>
                        </div>`,
                        `<span class="badge bg-primary">${doc.tipo_nombre}</span>`,
                        mandatariosHTML,
                        `<span class="text-muted">${doc.fecha_generacion}</span>`,
                        `<span class="badge bg-success">${doc.estado}</span>`,
                        `<button class="btn btn-outline-primary btn-sm" title="Ver PDF" onclick="viewPDF(${doc.id})">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm" title="Regenerar Documento" onclick="regenerateDocument(${doc.id})">
                            <i class="fas fa-sync"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" title="Eliminar Documento" onclick="deleteDocument(${doc.id})">
                            <i class="fas fa-trash"></i>
                        </button>`
                    ]).draw();
                });
            } else {
                showError('Error al cargar los documentos generados');
            }
        },
        error: function () {
            showError('Error al cargar los documentos generados');
        }
    });
}


// Load template content
function loadTemplateContent(templateId) {
    showEditorLoading(true);

    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'obtener_plantilla',
            id: templateId
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                tinymce.get("editorContent").setContent(response.data.contenido);
                updatePreviewButtons();
            } else {
                showError('Error al cargar el contenido de la plantilla');
            }
        },
        error: function () {
            showError('Error al cargar la plantilla');
        },
        complete: function () {
            showEditorLoading(false);
        }
    });
}

// Load user data
function loadUserData(userId) {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'obtener_usuario',
            id: userId
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const user = response.data;
                $('#rutMandatario').val(user.rut);
                $('#nombreMandatario').val(`${user.nombre} ${user.apellidos}`);
                $('#nacionalidadMandatario').val(user.nacionalidad);
                $('#estadoCivilMandatario').val(user.estado_civil);
                $('#profesionMandatario').val(user.profesion || '');
                $('#saveMandatarioBtn').prop('disabled', false);
            }
        },
        error: function () {
            showError('Error al cargar los datos del usuario');
        }
    });
}

// Clear user data
function clearUserData() {
    $('#rutMandatario, #nombreMandatario, #nacionalidadMandatario, #estadoCivilMandatario, #profesionMandatario').val('');
    $('#saveMandatarioBtn').prop('disabled', true);
}

// Save mandatario
function saveMandatario() {
    const userId = $('#selectUsuario').val();
    const userData = {
        id: userId,
        rut: $('#rutMandatario').val(),
        nombre: $('#nombreMandatario').val(),
        nacionalidad: $('#nacionalidadMandatario').val(),
        estado_civil: $('#estadoCivilMandatario').val(),
        profesion: $('#profesionMandatario').val()
    };

    // Check if already exists
    const exists = selectedMandatarios.find(m => m.id === userId);
    if (exists) {
        showError('Este mandatario ya está agregado');
        return;
    }

    selectedMandatarios.push(userData);
    updateMandatariosList();
    //$('#addMandatarioModal').modal('hide');
    clearMandatarioForm();

    showSuccess('Mandatario agregado correctamente');
}

// Update mandatarios list
function updateMandatariosList() {
    const container = $('#mandatariosList');
    const noMandatarios = $('#noMandatarios');

    if (selectedMandatarios.length === 0) {
        noMandatarios.show();
        return;
    }

    noMandatarios.hide();

    let html = '';
    selectedMandatarios.forEach(function (mandatario, index) {
        html += `
                    <div class="mandatario-card">
                        <button class="remove-mandatario" onclick="removeMandatario(${index})" title="Eliminar">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="fw-bold">${mandatario.nombre}</div>
                        <div class="text-muted small">RUT: ${mandatario.rut}</div>
                        <div class="text-muted small">${mandatario.nacionalidad} - ${mandatario.estado_civil}</div>
                        <div class="text-muted small">${mandatario.profesion || 'Profesión no especificada'}</div>
                    </div>
                `;
    });

    container.html(html);
    updateStats();
}

// Remove mandatario
function removeMandatario(index) {
    selectedMandatarios.splice(index, 1);
    updateMandatariosList();
    showSuccess('Mandatario eliminado');
}

// Clear mandatario form
function clearMandatarioForm() {
    $('#selectUsuario').val('').trigger('change');
    clearUserData();
}

// Insert variable at cursor
function insertVariableAtCursor(variable) {
    ingresartexto(variable);

    // Focus back to editor

}

// Show/hide editor
function showEditor() {
    $('#documentEditor').addClass('active');
    $('.editor-placeholder').hide();
    $('#editorContent').addClass('active').show();
}

function resetEditor() {
    $('#documentEditor').removeClass('active');
    tinymce.get('editorContent').setContent('');
    currentDocument.content = '';
    $('#saveDocumentBtn').prop('disabled', true);
    updatePreviewButtons();
}

// Show editor loading
function showEditorLoading(show) {
    if (show) {
        $('#editorLoading').show();
    } else {
        $('#editorLoading').hide();
    }
}

// Update preview buttons
function updatePreviewButtons() {
    let content = tinymce.get('editorContent').getContent();
    currentDocument.content = content;
    const hasContent = currentDocument.content && currentDocument.content.trim() !== '';
    $('#previewDocumentBtn, #generateDocumentBtn').prop('disabled', !hasContent);
}

// Update stats
function updateStats() {
    $('#totalMandatarios').text(selectedMandatarios.length);
}

// Load stats
function loadStats() {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'obtener_estadisticas'
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#totalDocumentos').text(response.data.documentos || 0);
                $('#totalPlantillas').text(response.data.plantillas || 0);
                $('#totalPendientes').text(response.data.pendientes || 0);
            }
        }
    });
}

// Template management functions
function openTemplateModal(templateId = null) {
    if (templateId) {
        // Edit mode
        currentEditingTemplate = templateId;
        $('#templateModalTitle').html('<i class="fas fa-edit me-2"></i>Editar Plantilla');
        loadTemplateForEdit(templateId);
    } else {
        // Create mode
        currentEditingTemplate = null;
        $('#templateModalTitle').html('<i class="fas fa-plus me-2"></i>Nueva Plantilla');
        $('#templateForm')[0].reset();
        $('#templateModal').modal('show');
    }

}

function loadTemplateForEdit(templateId) {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'obtener_plantilla_por_id',
            id: templateId
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#templateName').val(response.data.nombre);
                $('#templateCategory').val(response.data.categoria);
                $('#templateDescription').val(response.data.descripcion || '');
                tinymce.get('templateContent').setContent(response.data.contenido);
                $('#templateModal').modal('show');
            } else {
                showError('Error al cargar la plantilla para edición');
            }
        },
        error: function () {
            showError('Error al cargar la plantilla para edición');
        }
    });
}

function saveTemplate() {
    const formData = {
        action: currentEditingTemplate ? 'actualizar_plantilla' : 'crear_plantilla',
        id: currentEditingTemplate,
        nombre: $('#templateName').val(),
        categoria: $('#templateCategory').val(),
        descripcion: $('#templateDescription').val(),
        contenido: recibirtexto() // Get content from TinyMCE editor
    };

    if (!formData.nombre || !formData.categoria || !formData.contenido) {
        showError('Por favor complete todos los campos obligatorios');
        return;
    }

    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#templateModal').modal('hide');
                loadPlantillas();
                showSuccess(currentEditingTemplate ? 'Plantilla actualizada correctamente' : 'Plantilla creada correctamente');
            } else {
                showError(response.message || 'Error al guardar la plantilla');
            }
        },
        error: function () {
            showError('Error al guardar la plantilla');
        }
    });
}

// Document management functions
function newDocument() {
    if (confirm('¿Está seguro de crear un nuevo documento? Se perderán los cambios no guardados.')) {
        resetForm();
        showSuccess('Nuevo documento iniciado');
    }
}

function saveDocument() {
    if (!currentDocument.type || !currentDocument.template || !currentDocument.content) {
        showError('Por favor complete todos los campos necesarios');
        return;
    }

    const documentData = {
        action: 'guardar_documento',
        tipo_documento: currentDocument.type,
        plantilla_id: currentDocument.template,
        contenido: currentDocument.content,
        mandatarios: JSON.stringify(selectedMandatarios),
        monto_arriendo: currentDocument.montoArriendo || 0,
        datos_adicionales: JSON.stringify({
            monto_arriendo: currentDocument.montoArriendo
        })
    };

    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: documentData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#saveDocumentBtn').prop('disabled', true);
                loadDocuments();
                loadStats();
                showSuccess('Documento guardado correctamente');
            } else {
                showError(response.message || 'Error al guardar el documento');
            }
        },
        error: function () {
            showError('Error al guardar el documento');
        }
    });
}

function previewDocument() {
    const processedContent = tinymce.get('editorContent').getContent();
    if (!processedContent) {
        showError('No hay contenido para previsualizar');
        return;
    }

    let textavaluoFiscal = $("#avaluoFiscal").val();

    if (currentDocument.type === "mandato_especial_empresa" || currentDocument.type === "mandato_especial_representante") {
        //Validate if there are mandatarios selected
        if (selectedMandatarios.length === 0) {
            showError('Debe seleccionar al menos un mandatario para previsualizar el documento');
            return;
        }
    }

    var datos = {
        tipo_documento: currentDocument.type,
        contenido: processedContent,
        mandatarios: selectedMandatarios,
        monto_arriendo: currentDocument.montoArriendo || 0,
        avaluo_fiscal: textavaluoFiscal
    };

    $("#previewContent").html("<iframe src='php/documentos_empresa/vistaprevia.php?data=" + encodeURIComponent(JSON.stringify(datos)) + "' frameborder='0' style='width: 100%; height: 100vh;'></iframe>");
    $('#previewModal').modal('show');
}

function generateDocument() {
    const processedContent = tinymce.get('editorContent').getContent();
    if (!processedContent) {
        showError('No hay contenido para previsualizar');
        return;
    }
    let textavaluoFiscal = $("#avaluoFiscal").val();

    if (currentDocument.type === "mandato_especial_empresa" || currentDocument.type === "mandato_especial_representante") {
        //Validate if there are mandatarios selected
        if (selectedMandatarios.length === 0) {
            showError('Debe seleccionar al menos un mandatario para previsualizar el documento');
            return;
        }
    }

    var datos = {
        tipo_documento: currentDocument.type,
        contenido: processedContent,
        mandatarios: selectedMandatarios,
        monto_arriendo: currentDocument.montoArriendo || 0,
        avaluo_fiscal: textavaluoFiscal
    };


    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'generar_documento',data: JSON.stringify(datos)
        },
        dataType: 'json',
        success: function (response) {
            Swal.close();
            if (response.success) {
                // Download PDF
                showSuccess('PDF generado correctamente');
                window.open("php/documentos_generados/"+response.pdf_url, '_blank');

                // Reload tables
                loadDocuments();
                loadStats();
            } else {
                showError(response.message || 'Error al generar el PDF');
            }
        },
        error: function () {
            Swal.close();
            showError('Error al generar el PDF');
        }
    });
}

// Process document variables
function processDocumentVariables(content) {
    let processedContent = content;

    // Replace company variables (these would come from session/database)
    const companyVars = {
        '{RUT_EMPRESA}': '12.345.678-9',
        '{NOMBRE_EMPRESA}': 'EMPRESA DEMO SPA',
        '{REPRESENTANTE_LEGAL}': 'Juan Carlos Pérez López',
        '{RUT_REPRESENTANTE_LEGAL}': '98.765.432-1',
        '{DIRECCION_EMPRESA}': 'Av. Libertador 123, Oficina 456',
        '{TELEFONO_EMPRESA}': '+56 9 8765 4321',
        '{CORREO_EMPRESA}': 'contacto@empresademo.cl'
    };

    // Replace mandatarios variables
    selectedMandatarios.forEach((mandatario, index) => {
        const num = index + 1;
        processedContent = processedContent.replace(new RegExp(`{MANDATARIO_${num}}`, 'g'), mandatario.nombre);
        processedContent = processedContent.replace(new RegExp(`{RUT_MANDATARIO_${num}}`, 'g'), mandatario.rut);
        processedContent = processedContent.replace(new RegExp(`{NACIONALIDAD_MANDATARIO_${num}}`, 'g'), mandatario.nacionalidad);
        processedContent = processedContent.replace(new RegExp(`{ESTADO_CIVIL_MANDATARIO_${num}}`, 'g'), mandatario.estado_civil);
        processedContent = processedContent.replace(new RegExp(`{PROFESION_MANDATARIO_${num}}`, 'g'), mandatario.profesion);
    });

    // Replace date variables
    const today = new Date();
    const dateVars = {
        '{FECHA_GENERACION}': today.toLocaleDateString('es-CL'),
        '{FECHA_CELEBRACION}': today.toLocaleDateString('es-CL')
    };

    // Replace amount variables
    if (currentDocument.montoArriendo > 0) {
        processedContent = processedContent.replace(/{MONTO_ARRIENDO}/g,
            new Intl.NumberFormat('es-CL', {
                style: 'currency',
                currency: 'CLP'
            }).format(currentDocument.montoArriendo));
        processedContent = processedContent.replace(/{MONTO_ARRIENDO_LETRAS}/g,
            numeroALetras(currentDocument.montoArriendo));
    }

    // Apply all replacements
    Object.keys(companyVars).forEach(key => {
        processedContent = processedContent.replace(new RegExp(key, 'g'), companyVars[key]);
    });

    Object.keys(dateVars).forEach(key => {
        processedContent = processedContent.replace(new RegExp(key, 'g'), dateVars[key]);
    });

    return processedContent;
}

// Number to words conversion (simplified)
function numeroALetras(numero) {
    const unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    const decenas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    const centenas = ['', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

    if (numero === 0) return 'cero';
    if (numero < 10) return unidades[numero];
    if (numero < 100) {
        if (numero < 20) {
            const especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
            return especiales[numero - 10];
        }
        const dec = Math.floor(numero / 10);
        const uni = numero % 10;
        return decenas[dec] + (uni > 0 ? ' y ' + unidades[uni] : '');
    }

    // Simplified for demo - full implementation would handle thousands, millions, etc.
    return numero.toString() + ' (conversión completa pendiente)';
}

// Template actions
function editTemplate(id) {
    openTemplateModal(id);
}

function previewTemplate(id) {
    $.ajax({
        url: 'php/documentos_empresa/documentos_empresa_ajax.php',
        method: 'POST',
        data: {
            action: 'obtener_plantilla',
            id: id
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#previewContent').html(response.data.contenido);
                $('#previewModal').modal('show');
            }
        }
    });
}

function duplicateTemplate(id) {
    Swal.fire({
        title: '¿Duplicar plantilla?',
        text: 'Se creará una copia de esta plantilla',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, duplicar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'php/documentos_empresa/documentos_empresa_ajax.php',
                method: 'POST',
                data: {
                    action: 'duplicar_plantilla',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadPlantillas();
                        showSuccess('Plantilla duplicada correctamente');
                    } else {
                        showError('Error al duplicar la plantilla');
                    }
                }
            });
        }
    });
}

function deleteTemplate(id) {
    Swal.fire({
        title: '¿Eliminar plantilla?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc2626'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'php/documentos_empresa/documentos_empresa_ajax.php',
                method: 'POST',
                data: {
                    action: 'eliminar_plantilla',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadPlantillas();
                        showSuccess('Plantilla eliminada correctamente');
                    } else {
                        showError('Error al eliminar la plantilla');
                    }
                }
            });
        }
    });
}

// Document actions
function viewPDF(id) {
    window.open(`php/documentos_empresa/ver_pdf.php?id=${id}`, '_blank');
}

function downloadDocument(id) {
    window.open(`php/documentos_empresa/descargar_documento.php?id=${id}`, '_blank');
}

function regenerateDocument(id) {
    Swal.fire({
        title: '¿Regenerar documento?',
        text: 'Se creará una nueva versión del documento',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, regenerar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'php/documentos_empresa/documentos_empresa_ajax.php',
                method: 'POST',
                data: {
                    action: 'regenerar_documento',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadDocuments();
                        showSuccess('Documento regenerado correctamente');
                    } else {
                        showError('Error al regenerar el documento');
                    }
                }
            });
        }
    });
}

function deleteDocument(id) {
    Swal.fire({
        title: '¿Eliminar documento?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc2626'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'php/documentos_empresa/documentos_empresa_ajax.php',
                method: 'POST',
                data: {
                    action: 'eliminar_documento',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadDocuments();
                        loadStats();
                        showSuccess('Documento eliminado correctamente');
                    } else {
                        showError('Error al eliminar el documento');
                    }
                }
            });
        }
    });
}

// Filter functions
function applyFilters() {
    const filters = {
        tipo: $('#filterDocumentType').val(),
        fecha_desde: $('#filterDateFrom').val(),
        fecha_hasta: $('#filterDateTo').val()
    };

    // Apply filters to DataTable
    const table = $('#generatedTable').DataTable();

    // Custom filter implementation
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'generatedTable') return true;

        const tipo = data[1]; // Type column
        const fecha = data[3]; // Date column

        // Type filter
        if (filters.tipo && !tipo.toLowerCase().includes(filters.tipo.toLowerCase())) {
            return false;
        }

        // Date filters
        if (filters.fecha_desde || filters.fecha_hasta) {
            const docDate = new Date(fecha.split(' ')[0].split('/').reverse().join('-'));

            if (filters.fecha_desde) {
                const fromDate = new Date(filters.fecha_desde);
                if (docDate < fromDate) return false;
            }

            if (filters.fecha_hasta) {
                const toDate = new Date(filters.fecha_hasta);
                if (docDate > toDate) return false;
            }
        }

        return true;
    });

    table.draw();
    $('#filterModal').modal('hide');
    showSuccess('Filtros aplicados correctamente');
}

function clearFilters() {
    $('#filterDocumentType').val('');
    $('#filterDateFrom').val('');
    $('#filterDateTo').val('');

    // Clear DataTable filters
    $.fn.dataTable.ext.search.pop();
    $('#generatedTable').DataTable().draw();

    $('#filterModal').modal('hide');
    showSuccess('Filtros limpiados');
}

// Utility functions
function resetForm() {
    $('#documentType').val('');
    limpiarEditor();
    $('#montoArriendo').val('');
    $('#montoArriendoContainer').hide();
    selectedMandatarios = [];
    updateMandatariosList();
    resetEditor();
    currentDocument = {
        type: null,
        template: null,
        content: '',
        mandatarios: [],
        montoArriendo: 0
    };
}

function showSuccess(message) {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
    });
}

function showInfo(message) {
    Swal.fire({
        icon: 'info',
        title: 'Información',
        text: message
    });
}