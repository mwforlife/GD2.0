function agregarcampo(valor){
    tinymce.activeEditor.execCommand('mceInsertContent', false,  "{"+valor+"}");
    //tinymce.get("editorContent").execCommand('mceInsertContent', false, '{' + valor + '}');
}

//Inicializacion del editor de documentos
tinymce.init({
    selector: '#summernote',
    height: '100%',
    min_height: 300,
    max_height: null,
    resize: false,
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
    setup: function(editor) {
        editor.on('init', function() {
            // Asegurar que el editor use el 100% de altura disponible
            var container = editor.getContainer();
            if (container) {
                container.style.height = '100%';
                container.style.maxHeight = '100%';
            }
        });
    }
});

//Function to receive text from TinyMCE editor
function recibirtexto() {
    return tinymce.activeEditor.getContent();
}

//Limpiar el editor de TinyMCE
function limpiarEditor() {
    tinymce.activeEditor.setContent('');
}

//Cargar contenido en el editor de TinyMCE
function cargarContenidoEditor(contenido) {
    tinymce.activeEditor.setContent(contenido);
}


function generarDocumento(id){
    $("#global-loader").fadeIn("slow");
    //Capturar el contenido del editor
    var contenido = recibirtexto();
    //Validar que el contenido no este vacio
    if(contenido.trim() === ""){
        $("#global-loader").fadeOut("slow");
        ToastifyError("El contenido del documento no puede estar vacio");
        return;
    }
    $.ajax({
        url: "php/insert/registrarplantillas.php",
        type: "POST",
        data: {contenido: contenido, id: id},
        success: function(data){
            if(data==1){
                ToastifySuccess("Plantilla Registrada con exito");
                $("#global-loader").fadeOut("slow");
            }else{
                $("#global-loader").fadeOut("slow");
                ToastifyError("Error al registrar la plantilla");

            }
            
        }
    });
    $("#global-loader").fadeOut("slow");

}

function cargarDocumento(id){
    $("#global-loader").fadeIn("slow");
    $.ajax({
        url: "php/listar/cargardocumento.php",
        type: "POST",
        data: {id: id},
        success: function(data){
            //Limpiar el editor antes de cargar el nuevo contenido
            limpiarEditor();
            //Cargar el contenido en el editor
            cargarContenidoEditor(data);
            $("#global-loader").fadeOut("slow");
        }
    });
}