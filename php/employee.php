<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);

    // Obtener la información del empleado para el usuario actual
    $sql_empleado = "SELECT e.ID_Empleado, e.Area, e.Telefono, e.Sueldo,
                            e.Nombre AS NombreEmpleado,
                            e.Apellido_Paterno,
                            e.Apellido_Materno
                    FROM empleado e
                    WHERE e.ID_Usuario = '$id_usuario'";

    $result_empleado = $conn->query($sql_empleado);

    if ($result_empleado && $result_empleado->num_rows > 0) {
        $fila_empleado = $result_empleado->fetch_assoc();
        $id_empleado = $fila_empleado['ID_Empleado'];
        $nombre_empleado = $fila_empleado['NombreEmpleado'];
        $apellido_paterno = $fila_empleado['Apellido_Paterno'];
        $area = $fila_empleado['Area'];

        // Obtener las reservaciones según el área del empleado, incluyendo duración y hora final
        $sql_reservaciones = "SELECT r.ID_Reservacion, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Comentario,
                                    c.Nombre AS NombreCliente, c.Apellido_Paterno AS ApellidoCliente,
                                    r.Hora_Inicio, r.Hora_Finalizado, r.Duracion
                            FROM reservacion r
                            INNER JOIN cliente c ON r.ID_Cliente = c.ID_Cliente
                            WHERE UPPER(r.Tipo_Reserva) = UPPER('$area')";

        $result_reservaciones = $conn->query($sql_reservaciones);
    } else {
        // Manejar el caso en que no se encuentre un empleado para el usuario actual
    }
} else {
    // Manejar el caso en que la variable de sesión 'id_usuario' no esté definida
}

// CERRAR CONEXION
$conn->close();
?>