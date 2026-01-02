/**
 * Validación de anexos masivos
 * Verifica tipos de contrato y habilita/deshabilita campo de fecha de término
 */

// Variables globales
var tienePlazoFijo = false;
var tieneIndefinidos = false;
var totalContratos = 0;

$(document).ready(function() {
    // Verificar tipos de contrato al cargar la página
    verificarTiposContrato();

    // Toggle para modificar sueldo base
    $('#base').change(function() {
        if($(this).is(':checked')) {
            $(this).val('1');
            $('#sueldo').prop('disabled', false);
            $(this).siblings('.custom-switch-description').text('Sí.');
        } else {
            $(this).val('0');
            $('#sueldo').prop('disabled', true).val('');
            $(this).siblings('.custom-switch-description').text('No.');
        }
    });

    // Toggle para modificar fecha de término
    $('#modificafecha').change(function() {
        if($(this).is(':checked')) {
            if(!tienePlazoFijo) {
                ToastifyError('No hay contratos a plazo fijo en el lote');
                $(this).prop('checked', false);
                return;
            }
            $(this).val('1');
            $('#nuevafechatermino').prop('disabled', false).removeClass('fecha-input-disabled');
            $(this).siblings('.custom-switch-description').text('Sí.');
        } else {
            $(this).val('0');
            $('#nuevafechatermino').prop('disabled', true).addClass('fecha-input-disabled').val('');
            $(this).siblings('.custom-switch-description').text('No.');
        }
    });

    // Validar fecha de término
    $('#nuevafechatermino').change(function() {
        validarFechaTermino($(this).val());
    });
});

/**
 * Verifica los tipos de contrato en el lote actual
 */
function verificarTiposContrato() {
    var empresa = $('#empresa').val();

    if(!empresa) {
        console.error('No se encontró ID de empresa');
        return;
    }

    $.ajax({
        url: 'php/verificar/verificar_tipos_contrato_lote.php',
        type: 'POST',
        dataType: 'json',
        data: {
            empresa: empresa
        },
        success: function(response) {
            if(response.success) {
                tienePlazoFijo = response.tiene_plazo_fijo;
                tieneIndefinidos = response.tiene_indefinidos;
                totalContratos = response.total;

                // Actualizar UI según los resultados
                actualizarUISegunTipoContrato();
            } else {
                console.error('Error al verificar contratos:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error AJAX:', error);
            ToastifyError('Error al verificar tipos de contrato');
        }
    });
}

/**
 * Actualiza la interfaz según los tipos de contrato encontrados
 */
function actualizarUISegunTipoContrato() {
    var $container = $('.fecha-termino-container');
    var $checkbox = $('#modificafecha');
    var $input = $('#nuevafechatermino');
    var $warning = $('#warning-indefinido');
    var $infoAlert = $('#info-contratos');

    // Limpiar estados previos
    $warning.addClass('d-none');
    $infoAlert.remove();

    if(totalContratos === 0) {
        // No hay contratos en el lote
        $checkbox.prop('disabled', true);
        $input.prop('disabled', true);
        $container.prepend(
            '<div id="info-contratos" class="alert alert-warning">' +
            '<i class="fa fa-exclamation-triangle"></i> ' +
            '<strong>No hay contratos en el lote.</strong> Agregue contratos antes de continuar.' +
            '</div>'
        );
        return;
    }

    if(!tienePlazoFijo && tieneIndefinidos) {
        // Solo contratos indefinidos
        $checkbox.prop('disabled', true);
        $input.prop('disabled', true);
        $container.prepend(
            '<div id="info-contratos" class="alert alert-info">' +
            '<i class="fa fa-info-circle"></i> ' +
            '<strong>Información:</strong> Todos los contratos en el lote son indefinidos. ' +
            'No es posible modificar la fecha de término.' +
            '</div>'
        );
    } else if(tienePlazoFijo && !tieneIndefinidos) {
        // Solo contratos a plazo fijo
        $checkbox.prop('disabled', false);
        $container.prepend(
            '<div id="info-contratos" class="alert alert-success">' +
            '<i class="fa fa-check-circle"></i> ' +
            '<strong>Todos los contratos son a plazo fijo.</strong> ' +
            'Puede modificar la fecha de término para todos.' +
            '</div>'
        );
    } else if(tienePlazoFijo && tieneIndefinidos) {
        // Mezcla de contratos
        $checkbox.prop('disabled', false);
        $warning.removeClass('d-none');
        $container.prepend(
            '<div id="info-contratos" class="alert alert-warning">' +
            '<i class="fa fa-exclamation-triangle"></i> ' +
            '<strong>Advertencia:</strong> El lote contiene contratos a plazo fijo e indefinidos. ' +
            'La fecha de término solo se aplicará a los contratos a plazo fijo.' +
            '</div>'
        );
    }
}

/**
 * Valida que la fecha de término sea válida
 */
function validarFechaTermino(fecha) {
    if(!fecha) return false;

    var fechaSeleccionada = new Date(fecha);
    var hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    // La fecha no puede ser anterior a hoy
    if(fechaSeleccionada < hoy) {
        ToastifyError('La fecha de término no puede ser anterior a la fecha actual');
        $('#nuevafechatermino').val('').addClass('field-required-error');
        setTimeout(function() {
            $('#nuevafechatermino').removeClass('field-required-error');
        }, 500);
        return false;
    }

    return true;
}

/**
 * Validación antes de enviar el formulario
 */
function validarFormularioAnexo() {
    var modificaFecha = $('#modificafecha').is(':checked');
    var nuevaFecha = $('#nuevafechatermino').val();

    if(modificaFecha && !nuevaFecha) {
        ToastifyError('Debe ingresar la nueva fecha de término');
        $('#nuevafechatermino').addClass('field-required-error').focus();
        setTimeout(function() {
            $('#nuevafechatermino').removeClass('field-required-error');
        }, 500);
        return false;
    }

    if(modificaFecha && nuevaFecha) {
        if(!validarFechaTermino(nuevaFecha)) {
            return false;
        }
    }

    return true;
}
