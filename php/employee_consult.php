<?php
// Iniciar sesión si no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include 'db_config.php'; // Archivo de configuración de la base de datos

// Realizar la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query_clientes = "SELECT ID_Cliente, Nombre FROM cliente";
$result_clientes = $conn->query($query_clientes);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la reservación
    $id_reservacion = $_POST['id_reservacion'];

    $query_reservacion = "SELECT c.ID_Cliente, c.Nombre AS nombre_cliente, c.Apellido_Paterno, c.Apellido_Materno, c.Telefono, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Hora_Inicio, r.Hora_Finalizado, r.Duracion,r. Total, r.TotalCambiado
    FROM reservacion r
    INNER JOIN cliente c ON r.ID_Cliente = c.ID_Cliente
    INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
    WHERE r.ID_Reservacion = $id_reservacion";

    $result_reservacion = $conn->query($query_reservacion);

    if ($result_reservacion && $result_reservacion->num_rows > 0) {
        // Obtener los datos y guardarlos en variables, incluyendo el ID_Cliente
        $row = $result_reservacion->fetch_assoc();
        $id_cliente = $row['ID_Cliente'];
        $nombre_cliente = $row['nombre_cliente'];
        $apellido_paterno = $row['Apellido_Paterno'];
        $apellido_materno = $row['Apellido_Materno'];
        $telefono_cliente = $row['Telefono'];
        $fecha_reservacion = $row['Fecha_Reserva'];
        $tipo_reserva = $row['Tipo_Reserva'];
        $hora_inicio = $row['Hora_Inicio'];
        $hora_finalizado = $row['Hora_Finalizado'];
        $anticipo = $row['Anticipo'];
        $duracion = $row['Duracion'];
        $total = $row['Total'];
        $total_cambiado=$row['TotalCambiado'];
    } else {
        echo "No se encontraron resultados para la reservación con ID: $id_reservacion";
    }
    
}

// Cerrar la conexión a la base de datos
$conn->close();
?>