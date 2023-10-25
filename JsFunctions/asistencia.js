function asistencia(id, rut, nombre,centrocosto){
    $(".modal-title").html("Registrar asistencia<br>");
    $(".modal-title").append("Trabajador: "+nombre);
    $(".modal-title").append("<br>C.Costo: "+centrocosto);
    $("#idtrabajador").val(id);
    $("#modalasistencia").modal("show");
}