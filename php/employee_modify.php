<?php
session_start();
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
        $anticipo = $_POST['anticipo'];

         // Verificar si ya existe una reserva con la misma fecha y tipo de reserva
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
        } else{
        // Actualizar la tabla reservacion
        $sql_update_reservacion = "UPDATE reservacion 
                                   SET Fecha_Reserva='$fecha_reservacion', Tipo_Reserva='$tipo_reserva', Anticipo='$anticipo' 
                                   WHERE ID_Reservacion=$id_reservacion_a_modificar";
        $conn->query($sql_update_reservacion);

        // Actualizar la tabla cliente si se desea cambiar el teléfono
        $sql_update_cliente = "UPDATE cliente c 
                               INNER JOIN reservacion r ON c.ID_Cliente = r.ID_Cliente
                               SET c.Telefono='$telefono_cliente'
                               WHERE r.ID_Reservacion=$id_reservacion_a_modificar";
        $conn->query($sql_update_cliente);

        // Actualizar la tabla usuario si se desea cambiar el nombre o apellidos
        $sql_update_usuario = "UPDATE usuario u 
                               INNER JOIN cliente c ON u.ID_Usuario = c.ID_Usuario
                               INNER JOIN reservacion r ON c.ID_Cliente = r.ID_Cliente
                               SET u.Nombre='$nombre_cliente', u.Apellido_Paterno='$apellido_paterno', u.Apellido_Materno='$apellido_materno'
                               WHERE r.ID_Reservacion=$id_reservacion_a_modificar";
        $conn->query($sql_update_usuario);

        // Calcular la diferencia en horas
        $hora_inicio_dt = new DateTime($hora_inicio);
        $hora_final_dt = new DateTime($hora_final);

        $diferencia_horas = $hora_inicio_dt->diff($hora_final_dt)->h;

        // Actualizar la tabla evento con la duración en horas
        $sql_update_duracion = "UPDATE evento e 
                                INNER JOIN reservacion r ON e.ID_Reservacion = r.ID_Reservacion
                                SET e.Hora_Inicio='$hora_inicio', e.Hora_Final='$hora_final', e.Duracion='$diferencia_horas'
                                WHERE r.ID_Reservacion=$id_reservacion_a_modificar";
        $conn->query($sql_update_duracion);

        echo "<script>
                alert('Modificación exitosa');
                window.location.href='../html/employee_page.php';
              </script>";
        exit();}
    }
}

$conn->close(); // Cerrar la conexión a la base de datos
?>