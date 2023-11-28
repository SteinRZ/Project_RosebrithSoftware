<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

$id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);

// Obtener la información del empleado para el usuario actual
$sql_empleado = "SELECT e.ID_Empleado, e.Area, e.Telefono, e.Sueldo,
                        u.Nombre AS NombreEmpleado,
                        u.Apellido_Paterno,
                        u.Apellido_Materno
                FROM empleado e
                INNER JOIN usuario u ON e.ID_Usuario = u.ID_Usuario
                WHERE e.ID_Usuario = '$id_usuario'";

$result_empleado = $conn->query($sql_empleado);

if ($result_empleado->num_rows > 0) {
    $fila_empleado = $result_empleado->fetch_assoc();
    $id_empleado = $fila_empleado['ID_Empleado'];
    $nombre_empleado = $fila_empleado['NombreEmpleado'];
    $apellido_paterno = $fila_empleado['Apellido_Paterno'];
    $area = $fila_empleado['Area'];

    // Obtener las reservaciones según el área del empleado
    $sql_reservaciones = "SELECT r.ID_Reservacion, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Comentario,
                                u.Nombre AS NombreCliente, u.Apellido_Paterno AS ApellidoCliente
                        FROM reservacion r
                        INNER JOIN cliente c ON r.ID_Cliente = c.ID_Cliente
                        INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
                        WHERE UPPER(r.Tipo_Reserva) = UPPER('$area')";

    $result_reservaciones = $conn->query($sql_reservaciones);
}

// CERRAR CONEXION
$conn->close();
?>