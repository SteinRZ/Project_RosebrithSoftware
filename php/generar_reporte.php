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
    // Obtener el ID de la reservación en este caso como no tenia un formulario lo puse manualmente
    $id_reservacion = 7;

    $query_reservacion = "SELECT c.ID_Cliente, c.Nombre AS nombre_cliente, c.Apellido_Paterno, c.Apellido_Materno, c.Telefono, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Hora_Inicio, r.Hora_Finalizado, r.Duracion
    FROM reservacion r
    INNER JOIN cliente c ON r.ID_Cliente = c.ID_Cliente
    INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
    WHERE r.ID_Reservacion = $id_reservacion";

    $result_reservacion = $conn->query($query_reservacion);

    if ($result_reservacion && $result_reservacion->num_rows > 0) {
        // Mostrar los resultados en texto
        while ($row = $result_reservacion->fetch_assoc()) {
            echo "ID Cliente: " . $row['ID_Cliente'] . ", Nombre Cliente: " . $row['nombre_cliente'] . ", Apellido Paterno: " . $row['Apellido_Paterno'] . ", Apellido Materno: " . $row['Apellido_Materno'] . ", Teléfono: " . $row['Telefono'] . ", Fecha de Reserva: " . $row['Fecha_Reserva'] . ", Tipo de Reserva: " . $row['Tipo_Reserva'] . ", Anticipo: " . $row['Anticipo'] . ", Hora de Inicio: " . $row['Hora_Inicio'] . ", Hora de Finalizado: " . $row['Hora_Finalizado'] . ", Duración: " . $row['Duracion'] . "<br>";
        }
    } else {
        echo "No se encontraron resultados para la reservación con ID: $id_reservacion";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
