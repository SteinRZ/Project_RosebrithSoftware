<?php
session_start();
include 'db_config.php'; // Archivo de configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_cita'])) {
        $nombre_cliente = $_POST['nombre_cliente'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $tipo_reserva = $_POST['tipo_reserva'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $fecha_reservacion = $_POST['fecha_reservacion'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_final = $_POST['hora_final'];
        $anticipo = $_POST['anticipo'];

        // Generar un correo electrónico aleatorio basado en el nombre del cliente
        $correo = strtolower(str_replace(' ', '', $nombre_cliente)) . '@gmail.com';

        // Realizar la inserción en la tabla usuario
        $sql_usuario = "INSERT INTO usuario (ID_Usuario, Nombre, Apellido_Paterno, Apellido_Materno, Correo, Contraseña, Rol) 
                        VALUES (DEFAULT, '$nombre_cliente', '$apellido_paterno', '$apellido_materno', '$correo', 'contrasena_generica', 'cliente')";
        $conn->query($sql_usuario);
        $id_usuario = $conn->insert_id; // Obtener el ID del usuario insertado

        // Realizar la inserción en la tabla cliente
        $sql_cliente = "INSERT INTO cliente (ID_Cliente, ID_Usuario, Telefono, Deuda) 
                        VALUES (DEFAULT, $id_usuario, '$telefono_cliente', 0)";
        $conn->query($sql_cliente);
        $id_cliente = $conn->insert_id; // Obtener el ID del cliente insertado

        // Realizar la inserción en la tabla reservacion
        $sql_reservacion = "INSERT INTO reservacion (ID_Reservacion, ID_Cliente, Fecha_Reserva, Tipo_Reserva, Anticipo) 
                            VALUES (DEFAULT, $id_cliente, '$fecha_reservacion', '$tipo_reserva', '$anticipo')";
        $conn->query($sql_reservacion);
        $id_reservacion = $conn->insert_id; // Obtener el ID de la reservación insertada

        // Obtener el ID del empleado para el usuario actual
        $id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);
        $sql_empleado = "SELECT e.ID_Empleado 
                         FROM empleado e
                         INNER JOIN usuario u ON e.ID_Usuario = u.ID_Usuario
                         WHERE e.ID_Usuario = '$id_usuario'";
        $result = $conn->query($sql_empleado);
        $row = $result->fetch_assoc();
        $id_empleado = $row['ID_Empleado']; // Obtener el ID del empleado

        // Calcular la duración en base a Hora_Inicio y Hora_Final
        $sql_calculate_duration = "SELECT TIMEDIFF('$hora_final', '$hora_inicio') AS Duracion";
        $result = $conn->query($sql_calculate_duration);
        $duracion = $result->fetch_assoc()['Duracion'];

        // Realizar la inserción en la tabla evento
        $sql_evento = "INSERT INTO evento (ID_Reservacion, ID_Empleado, Hora_Inicio, Hora_Final, Duracion, Total) 
                        VALUES ($id_reservacion, $id_empleado, '$hora_inicio', '$hora_final', '$duracion', 0)";
        $conn->query($sql_evento);

        echo "<script>
                alert('Se ha agregado la reserva correctamente.');
                window.location.href='../html/employee_page.php';
              </script>";
        exit();
    }
}

$conn->close(); // Cerrar la conexión a la base de datos
?>