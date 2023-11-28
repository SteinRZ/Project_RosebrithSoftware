<?php
// Iniciar sesión si no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include 'db_config.php'; // Archivo de configuración de la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la reservación
    $id_reservacion = $_POST['id_reservacion'];

    // Realizar la conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para obtener los datos de las diferentes tablas relacionadas
    $query = "SELECT u.Nombre AS nombre_cliente, u.Apellido_Paterno, u.Apellido_Materno, c.Telefono, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, e.Hora_Inicio, e.Hora_Final
              FROM reservacion r
              INNER JOIN cliente c ON r.ID_Cliente = c.ID_Cliente
              INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
              INNER JOIN evento e ON r.ID_Reservacion = e.ID_Reservacion
              WHERE r.ID_Reservacion = $id_reservacion";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Obtener los datos y guardarlos en variables
        $row = $result->fetch_assoc();
        $nombre_cliente = $row['nombre_cliente'];
        $apellido_paterno = $row['Apellido_Paterno'];
        $apellido_materno = $row['Apellido_Materno'];
        $telefono_cliente = $row['Telefono'];
        $fecha_reservacion = $row['Fecha_Reserva'];
        $tipo_reserva = $row['Tipo_Reserva'];
        $hora_inicio = $row['Hora_Inicio'];
        $hora_final = $row['Hora_Final'];
        $anticipo = $row['Anticipo'];
    } else {
        echo "No se encontraron resultados para la reservación con ID: $id_reservacion";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>