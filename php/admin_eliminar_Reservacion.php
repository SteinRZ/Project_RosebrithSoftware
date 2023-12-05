<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Reservacion'])) {
    $reservacion_id = $_POST['Reservacion'];

    // Realiza la eliminación de la reservación en la base de datos
    $stmt = $conn->prepare("DELETE FROM Reservacion WHERE ID_Reservacion = ?");
    $stmt->bind_param("i", $reservacion_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>
                alert('La reservación se eliminó correctamente.');
                window.location.href = '../php/admin_table_reservation.php';
              </script>";
    } else {
        echo "<script>
                alert('No se pudo eliminar la reservación. Inténtalo de nuevo.');
                window.location.href = '../php/admin_table_reservation.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>