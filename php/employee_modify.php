<?php
// Iniciar sesión si no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include 'db_config.php'; // Archivo de configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    if (isset($_POST['pagar'])) {
        $id_reservacion = $_POST['id_reservacion'];
        $pagar = $_POST['pagar'];

        // Obtener el total actual y el total cambiado
        $query_total = "SELECT Total, TotalCambiado FROM reservacion WHERE ID_Reservacion = $id_reservacion";
        $result_total = $conn->query($query_total);

        if ($result_total->num_rows > 0) {
            $row = $result_total->fetch_assoc();
            $total = $row['Total'];
            $total_cambiado = $row['TotalCambiado'];

            // Restar el monto pagado a TotalCambiado
            $total_cambiado -= $pagar;

            // Actualizar el TotalCambiado en la base de datos
            $sql_actualizar_total_cambiado = "UPDATE reservacion SET TotalCambiado = $total_cambiado WHERE ID_Reservacion = $id_reservacion";

            if ($conn->query($sql_actualizar_total_cambiado) === TRUE) {
                echo "<script>
                        alert('Se ha pagado correctamente.');
                        window.location.href='../html/employee_page.php';
                      </script>";
                exit();
            } else {
                echo "Error al actualizar el TotalCambiado: " . $conn->error;
            }
        } else {
            echo "No se encontraron resultados para la reservación con ID: $id_reservacion";
        }
    }

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

        // Obtener la información actual de la reserva para comparar
        $query_get_info = "SELECT Fecha_Reserva, Tipo_Reserva FROM reservacion WHERE ID_Reservacion = $id_reservacion_a_modificar";
        $result_info = $conn->query($query_get_info);

        if ($result_info->num_rows > 0) {
            $row_info = $result_info->fetch_assoc();
            $fecha_actual = $row_info['Fecha_Reserva'];
            $tipo_actual = $row_info['Tipo_Reserva'];

            // Verificar si la fecha o el tipo han cambiado
            if ($fecha_actual !== $fecha_reservacion || $tipo_actual !== $tipo_reserva) {
                // Realizar la verificación si la fecha, el tipo o el anticipo han cambiado
                $sql_verificar_reserva = "SELECT ID_Reservacion FROM reservacion WHERE Fecha_Reserva = '$fecha_reservacion' AND Tipo_Reserva = '$tipo_reserva'";
                $result_verificar = $conn->query($sql_verificar_reserva);

                if ($result_verificar->num_rows > 0 && $tipo_reserva !== 'Ambos') {
                    // Si ya existe una reserva para la fecha y tipo seleccionados, mostrar una alerta
                    echo "<script>
                            alert('No se puede realizar la reserva. La fecha o tipo de reserva ya está ocupada.');
                            window.location.href='../html/employee_page.php';
                          </script>";
                    exit();
                } elseif ($result_verificar->num_rows > 0 && $tipo_reserva === 'Ambos') {
                    // Si el tipo de reserva es "Ambos" y ya existe una reserva para esa fecha, mostrar una alerta
                    echo "<script>
                            alert('No se puede realizar la reserva. La fecha ya está ocupada para el tipo de reserva Ambos.');
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
        }
    }
}
$conn->close(); // Cerrar la conexión a la base de datos
?>