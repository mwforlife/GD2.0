/**
 * Funcionalidad de búsqueda de campos para redactar documento
 */

$(document).ready(function() {
    // Función de búsqueda de campos
    $('#searchField').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase().trim();

        if (searchTerm === '') {
            // Mostrar todos los campos y categorías
            $('.field-category').removeClass('hidden').show();
            $('.field-btn').removeClass('hidden').show();
        } else {
            // Ocultar todas las categorías primero
            $('.field-category').each(function() {
                var $category = $(this);
                var $fields = $category.find('.field-btn');
                var hasVisibleFields = false;

                // Filtrar campos dentro de esta categoría
                $fields.each(function() {
                    var fieldText = $(this).text().toLowerCase();
                    var fieldData = $(this).data('field');

                    if (fieldData) {
                        fieldData = fieldData.toLowerCase();
                    } else {
                        fieldData = '';
                    }

                    if (fieldText.indexOf(searchTerm) > -1 || fieldData.indexOf(searchTerm) > -1) {
                        $(this).removeClass('hidden').show();
                        hasVisibleFields = true;
                    } else {
                        $(this).addClass('hidden').hide();
                    }
                });

                // Mostrar u ocultar la categoría según tenga campos visibles
                if (hasVisibleFields) {
                    $category.removeClass('hidden').show();
                } else {
                    $category.addClass('hidden').hide();
                }
            });
        }
    });

    // Limpiar búsqueda al hacer click en el input
    $('#searchField').on('focus', function() {
        $(this).select();
    });

    // Atajo de teclado para enfocar el buscador (Ctrl+F o Cmd+F)
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            $('#searchField').focus();
        }
    });
});
