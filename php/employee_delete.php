<?php
// Iniciar sesión si no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_cita'])) {
    include 'db_config.php';

    $id_reservacion_a_eliminar = $_POST['id_reservacion'];

    $sql_eliminar_reservacion = "DELETE FROM reservacion WHERE ID_Reservacion = '$id_reservacion_a_eliminar'";

    if ($conn->query($sql_eliminar_reservacion) === TRUE) {
        echo "<script>
                alert('Reservación eliminada exitosamente');
                window.location.href = '../html/employee_page.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al eliminar la reservación: " . $conn->error . "');
                window.location.href = '../html/employee_page.php';
              </script>";
    }

    $conn->close();
}
?>