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

        // Realizar la inserción en la tabla usuario (cliente)
        $sql_usuario = "INSERT INTO usuario (ID_Usuario, Correo, Contraseña, Rol, Fecha_Creacion) 
                        VALUES (DEFAULT, '$correo', '$apellido_paterno', 'cliente', NOW())";
        $conn->query($sql_usuario);
        $id_usuario = $conn->insert_id; // Obtener el ID del usuario insertado

        // Realizar la inserción en la tabla cliente
        $sql_cliente = "INSERT INTO cliente (ID_Cliente, ID_Usuario, Nombre, Apellido_Paterno, Apellido_Materno, Telefono, Fecha_Creacion) 
                        VALUES (DEFAULT, $id_usuario, '$nombre_cliente', '$apellido_paterno', '$apellido_materno', '$telefono_cliente', NOW())";
        $conn->query($sql_cliente);
        $id_cliente = $conn->insert_id; // Obtener el ID del cliente insertado

        // Verificar si ya existe una reserva con la misma fecha y tipo de reserva
        $sql_verificar_reserva = "SELECT ID_Reservacion FROM reservacion WHERE Fecha_Reserva = '$fecha_reservacion' AND Tipo_Reserva = '$tipo_reserva'";
        $result_verificar = $conn->query($sql_verificar_reserva);

        if ($result_verificar->num_rows > 0 || $tipo_reserva === 'Ambos') {
            // Si ya existe una reserva para la fecha y tipo seleccionados o si el tipo de reserva es "Ambos", mostrar una alerta
            echo "<script>
                    alert('No se puede realizar la reserva. La fecha o tipo de reserva ya está ocupada.');
                    window.location.href='../html/employee_page.php';
                  </script>";
            exit();
        }

        // Calcular la duración entre la hora de inicio y la hora final
        $inicio = strtotime($hora_inicio);
        $final = strtotime($hora_final);
        $duracion = round(($final - $inicio) / 3600); // Calcula la diferencia en horas

        // Realizar la inserción en la tabla reservacion con la duración calculada
        $sql_reservacion = "INSERT INTO reservacion (ID_Reservacion, ID_Cliente, Fecha_Reserva, Tipo_Reserva, Anticipo, Hora_Inicio, Hora_Finalizado, Duracion, Total, Comentario, Fecha_Creacion) 
                            VALUES (DEFAULT, $id_cliente, '$fecha_reservacion', '$tipo_reserva', '$anticipo', '$hora_inicio', '$hora_final', '$duracion', NULL, NULL, NOW())";
        $conn->query($sql_reservacion);
        $id_reservacion = $conn->insert_id; // Obtener el ID de la reservación insertada

        echo "<script>
                alert('Se ha agregado la reserva correctamente.');
                window.location.href='../html/employee_page.php';
              </script>";
        exit();
    }
}

$conn->close(); // Cerrar la conexión a la base de datos
?>