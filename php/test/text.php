<?php
// Identifica el trabajador y la fecha de asistencia modificada
$trabajador_id = 123;
$fecha_modificada = '2023-11-12';

// Consulta para encontrar el movimiento existente
$query = "SELECT * FROM movimientos WHERE trabajador_id = $trabajador_id AND fecha_inicio <= '$fecha_modificada' AND fecha_termino >= '$fecha_modificada'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $movimiento_id = $row['id'];
    
    // Calcula las fechas para los nuevos movimientos
    $nueva_fecha_inicio_1 = $row['fecha_inicio'];
    $nueva_fecha_termino_1 = date('Y-m-d', strtotime($fecha_modificada . ' -1 day'));
    $nueva_fecha_inicio_2 = date('Y-m-d', strtotime($fecha_modificada . ' +1 day'));
    $nueva_fecha_termino_2 = $row['fecha_termino'];

    // Crea nuevos registros de movimientos
    $query1 = "INSERT INTO movimientos (trabajador_id, fecha_inicio, fecha_termino) VALUES ($trabajador_id, '$nueva_fecha_inicio_1', '$nueva_fecha_termino_1')";
    $query2 = "INSERT INTO movimientos (trabajador_id, fecha_inicio, fecha_termino) VALUES ($trabajador_id, '$nueva_fecha_inicio_2', '$nueva_fecha_termino_2')";

    // Elimina el movimiento original
    $delete_query = "DELETE FROM movimientos WHERE id = $movimiento_id";

    // Actualiza la asistencia en la fecha modificada si es necesario
    // ...

    // Ejecuta las consultas SQL
    mysqli_query($con, $query1);
    mysqli_query($con, $query2);
    mysqli_query($con, $delete_query);

    // Cierra la conexión a la base de datos
    mysqli_close($con);
}
?>
