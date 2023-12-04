<?php
// Iniciar sesión si no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include 'db_config.php'; // Archivo de configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    if (isset($_POST['modificar_cita'])) {
        $id_reservacion_a_modificar = $_POST['id_reservacion'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $tipo_reserva = $_POST['tipo_reserva'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $fecha_reservacion = $_POST['fecha_reservacion'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_final = $_POST['hora_final'];

        // Obtener la información actual de la reserva para comparar la fecha
        $query_get_info = "SELECT Fecha_Reserva FROM reservacion WHERE ID_Reservacion = $id_reservacion_a_modificar";
        $result_info = $conn->query($query_get_info);

        if ($result_info->num_rows > 0) {
            $row_info = $result_info->fetch_assoc();
            $fecha_actual = $row_info['Fecha_Reserva'];

            // Verificar si la fecha ha sido modificada
            if ($fecha_actual !== $fecha_reservacion) {
                // Verificar si la fecha está ocupada independientemente del tipo de reserva
                $sql_verificar_reserva = "SELECT ID_Reservacion FROM reservacion WHERE Fecha_Reserva = '$fecha_reservacion'";
                $result_verificar = $conn->query($sql_verificar_reserva);

                if ($result_verificar->num_rows > 0) {
                    // Si ya existe una reserva para la fecha seleccionada, mostrar una alerta
                    echo "<script>
                            alert('No se puede realizar la reserva. La fecha ya está ocupada.');
                            window.location.href='../html/employee_page.php';
                          </script>";
                    exit();
                }
            }

            // Calcular la diferencia en horas entre la hora de inicio y finalización
            $hora_inicio_dt = new DateTime($hora_inicio);
            $hora_final_dt = new DateTime($hora_final);
            $diferencia = $hora_inicio_dt->diff($hora_final_dt);
            $duracion = $diferencia->h; // Obtener la diferencia solo en horas

            // Actualizar la tabla reservacion con la duración en horas y el anticipo
            $sql_update_reservacion = "UPDATE reservacion 
                           SET Fecha_Reserva='$fecha_reservacion', Tipo_Reserva='$tipo_reserva', Hora_Inicio='$hora_inicio', Hora_Finalizado='$hora_final', Duracion='$duracion'
                           WHERE ID_Reservacion=$id_reservacion_a_modificar";
            $conn->query($sql_update_reservacion);

            // Actualizar la tabla cliente si se desea cambiar el teléfono
            $sql_update_cliente = "UPDATE cliente 
                                    SET Telefono='$telefono_cliente'
                                    WHERE ID_Cliente=(SELECT ID_Cliente FROM reservacion WHERE ID_Reservacion=$id_reservacion_a_modificar)";
            $conn->query($sql_update_cliente);

            // Actualizar la tabla usuario si se desea cambiar el nombre o apellidos
            $sql_update_usuario = "UPDATE cliente c 
                                   INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
                                   SET c.Nombre='$nombre_cliente', c.Apellido_Paterno='$apellido_paterno', c.Apellido_Materno='$apellido_materno'
                                   WHERE c.ID_Cliente=(SELECT ID_Cliente FROM reservacion WHERE ID_Reservacion=$id_reservacion_a_modificar)";
            $conn->query($sql_update_usuario);

            // Mostrar alerta de modificación exitosa
            echo "<script>
                    alert('La reserva ha sido modificada exitosamente.');
                    window.location.href='../html/employee_page.php';
                  </script>";
            exit();
        }
    }
}

$conn->close(); // Cerrar la conexión a la base de datos
?>